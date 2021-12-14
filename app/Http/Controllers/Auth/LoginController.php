<?php
/**
 * LaraClassified - Classified Ads Web Application
 * Copyright (c) BedigitCom. All Rights Reserved
 *
 * Website: https://bedigit.com
 *
 * LICENSE
 * -------
 * This software is furnished under a license and may be used and copied
 * only in accordance with the terms of such license and with the inclusion
 * of the above copyright notice. If you Purchased from CodeCanyon,
 * Please read the full License from here - http://codecanyon.net/licenses/standard
 */

namespace App\Http\Controllers\Auth;

use App\Helpers\UrlGen;
use App\Http\Controllers\FrontController;
use App\Http\Requests\LoginRequest;
use App\Events\UserWasLogged;
use App\Models\Permission;
use App\Models\User;
use App\Models\Post;

use App\Models\Picture;
use Illuminate\Support\Facades\Storage;

use App\Helpers\Auth\Traits\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Str;
use Torann\LaravelMetaTags\Facades\MetaTag;
use Illuminate\Support\Facades\Http;
use XF;

class LoginController extends FrontController
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    // If not logged in redirect to
    protected $loginPath = 'login';

    // The maximum number of attempts to allow
    protected $maxAttempts = 5;

    // The number of minutes to throttle for
    protected $decayMinutes = 15;

    // After you've logged in redirect to
    protected $redirectTo = 'account';

    // After you've logged out redirect to
    protected $redirectAfterLogout = '/';

    /**
     * LoginController constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->middleware('guest')->except(['except' => 'logout']);

        // Set default URLs
        $isFromLoginPage = Str::contains(url()->previous(), '/' . UrlGen::loginPath());
        $this->loginPath = $isFromLoginPage ? UrlGen::loginPath() : url()->previous();
        $this->redirectTo = $isFromLoginPage ? 'account' : url()->previous();
        $this->redirectAfterLogout = '/';

        // Get values from Config
        $this->maxAttempts = (int)config('settings.security.login_max_attempts', $this->maxAttempts);
        $this->decayMinutes = (int)config('settings.security.login_decay_minutes', $this->decayMinutes);
    }

    // -------------------------------------------------------
    // Laravel overwrites for loading LaraClassified views
    // -------------------------------------------------------

    /**
     * Show the application login form.
     *
     * @return \Illuminate\Http\RedirectResponse|mixed
     */
    public function showLoginForm()
    {


        // Remembering Login
        if (auth()->viaRemember()) {
            return redirect()->intended($this->redirectTo);
        }

        // Meta Tags
        MetaTag::set('title', getMetaTag('title', 'login'));
        MetaTag::set('description', strip_tags(getMetaTag('description', 'login')));
        MetaTag::set('keywords', getMetaTag('keywords', 'login'));

        return appView('auth.login');
    }

    /**
     * @param LoginRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|void
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(LoginRequest $request)
    {
    

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        // Get the right login field
        $loginField = getLoginField($request->input('login'));

        // Get credentials values
        $credentials = [
            $loginField => $request->input('login'),
            'password' => $request->input('password'),
            'blocked' => 0,
        ];
        if (in_array($loginField, ['email', 'phone'])) {
            $credentials['verified_' . $loginField] = 1;
        } else {
            $credentials['verified_email'] = 1;
            $credentials['verified_phone'] = 1;
        }

        // Auth the User
        if (auth()->attempt($credentials)) {
            $user = User::find(auth()->user()->getAuthIdentifier());

            // Update last user logged Date
            Event::dispatch(new UserWasLogged($user));
           
             $this->bypassXF($user);

           // $apiResponse = $this->xfLoginApi($user);

            // $this->redirectTo = $apiResponse->login_url;


            // Redirect admin users to the Admin panel
            if (auth()->check()) {
                // lets login xf user
                if ($user->hasAllPermissions(Permission::getStaffPermissions())) {
                    return redirect(admin_uri());
                }
            }


            // Redirect normal users
            return redirect()->intended($this->redirectTo);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        // Check and retrieve previous URL to show the login error on it.
        if (session()->has('url.intended')) {
            $this->loginPath = session()->get('url.intended');
        }

        return redirect($this->loginPath)->withErrors(['error' => trans('auth.failed')])->withInput();
    }

    protected function bypassXF($user)
    {
        $xf = \XF::app();
        $ip = $xf->request->getIp();
        // $service = $xf->service('XF:User\Login', $credentials['email'], $ip);

        // $user = $xf->em()->find('XF:User',$userId);
        $user = $xf->finder('XF:User')
            ->where('email',$user->email)->fetchOne();

        $this->changeUser($user);
        \XF::setVisitor($user);
        $xf->repository('XF:SessionActivity')->clearUserActivity(0, $ip);
        $xf->repository('XF:Ip')->logIp(
            $user->user_id, $ip,
            'user', $user->user_id, 'login'
        );

        $rememberRepo = $xf->repository('XF:UserRemember');
        $key = $rememberRepo->createRememberRecord($user->user_id);
        $value = $rememberRepo->getCookieValue($user->user_id, $key);

        setcookie('xf_user', $value, time() + (365 * 86400), '/'); // ugly
    }

    protected function changeUser($user)
    {
        $session = \XF::session();
        $passwordDate = $user->Profile ? $user->Profile->password_date : 0;

        if ($session->exists)
        {
            $session->regenerate(false);
        }

        $session->__set('userId', $user->user_id);
        $session->__set('passwordDate', intval($passwordDate));

        return $session;
    }

    protected function setAvatar($user, $post, $xfUserId)
    {

        $postPic = Picture::where('post_id', $post->id)->first();
        $file = Storage::path($postPic->filename);

        if (!empty($file)) {

            $user->photo = $file;
            $user->save();
            $curl = curl_init();

            $apiKey = env('XF_API_KEY', 'jP48tVpsUwwbY_PEWI9nq-EwZynZtywD');
            $headers = array(
                "XF-Api-Key: {$apiKey}",
                "XF-Api-User: 1"
            );

            $url = url("forum/index.php?api/users") . "/" . $xfUserId . "/avatar";//                $file = $request->input('pictures')[0];
            $fields = array('avatar' =>
                new \CURLFILE($file));

            curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => $fields,
                CURLOPT_HTTPHEADER => $headers,
            ));

            $response = curl_exec($curl);

            curl_close($curl);

        }

    }





//   for xenforo user login end code

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function logout(Request $request)
    {
    
        // Get the current Country
        if (session()->has('country_code')) {
            $countryCode = session('country_code');
        }
        if (session()->has('allowMeFromReferrer')) {
            $allowMeFromReferrer = session('allowMeFromReferrer');
        }

	 $this->logoutXFVisitor();
        // Remove all session vars
        $this->guard()->logout();
        $request->session()->flush();
        $request->session()->regenerate();

        // Retrieve the current Country
        if (isset($countryCode) && !empty($countryCode)) {
            session()->put('country_code', $countryCode);
        }
        if (isset($allowMeFromReferrer) && !empty($allowMeFromReferrer)) {
            session()->put('allowMeFromReferrer', $allowMeFromReferrer);
        }

       

        $message = t('You have been logged out') . ' ' . t('See you soon');
        flash($message)->success();

        return redirect(property_exists($this, 'redirectAfterLogout') ? $this->redirectAfterLogout : '/');
    }
    
        protected function xfLoginApi($user){
        $xf = \XF::app();
        $xfUser = $xf->finder('XF:User')
            ->where('laravel_user_id',$user->id)
            ->fetchOne();


        $curl = curl_init();

        $xfAdmin = \XF::finder("XF:User")
            ->where('is_admin','=',1)
            ->fetchOne();

        $apiKey = env('XF_API_KEY','jP48tVpsUwwbY_PEWI9nq-EwZynZtywD');
        $headers =  array(
            "XF-Api-Key: {$apiKey}",
            "XF-Api-User: {$xfAdmin->user_id}"
        );
        $apiInput = ['user_id' => $xfUser->user_id,
                    'return_url' => url('/account')];
        curl_setopt_array($curl, array(
            CURLOPT_URL => url('/forum/index.php?api/auth/login-token'),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $apiInput,
            CURLOPT_HTTPHEADER => $headers,

        ));

        $response = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        
        if($httpcode == 200) {
            return json_decode($response);
        }

    }

    //   for xenforo user logOut start code

   public function logoutXFVisitor()
    {
        $session = \XF::app()->session();
        $this->lastActivityUpdate();
        $this->deleteVisitorRememberRecord(false);
        $session->logoutUser();
        $this->clearCookies();

    }

    protected function lastActivityUpdate()
    {
        $visitor = \XF::visitor();
        $userId = $visitor->user_id;
        if (!$userId) {
            return;
        }

        $activity = $visitor->Activity;
        if (!$activity) {
            return;
        }

        $visitor->last_activity = $activity->view_date;
        $visitor->save();

        $activity->delete();
    }

    protected function deleteVisitorRememberRecord($deleteCookie = true)
    {
        $userRemember = $this->validateVisitorRememberKey();
        if ($userRemember) {
            $userRemember->delete();
        }

        if ($deleteCookie) {
            \XF::app()->response()->setCookie('user', false);
        }
    }

    /**
     * @return null|\XF\Entity\UserRemember
     */
    protected function validateVisitorRememberKey()
    {
        $rememberCookie = \XF::app()->request()->getCookie('user');
        if (!$rememberCookie) {
            return null;
        }

        /** @var \XF\Repository\UserRemember $rememberRepo */
        $rememberRepo = \XF::app()->repository('XF:UserRemember');
        if ($rememberRepo->validateByCookieValue($rememberCookie, $remember)) {
            return $remember;
        } else {
            return null;
        }
    }

    protected function clearCookieSkipList()
    {
        return ['notice_dismiss', 'push_notice_dismiss', 'session', 'tfa_trust'];
    }

    protected function clearCookies()
    {
        $skip = $this->clearCookieSkipList();
        $response = \XF::app()->response();

        foreach (\XF::app()->request()->getCookies() as $cookie => $null) {
            if (in_array($cookie, $skip)) {
                continue;
            }

            $response->setCookie($cookie, false);
        }
    }

    //   for xenforo user logOut end code


}
