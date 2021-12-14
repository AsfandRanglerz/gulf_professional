<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Auth\Traits\ResetsPasswordsUsingTokenTrait;
use App\Http\Controllers\FrontController;
use App\Http\Requests\ResetPasswordRequest;
use App\Models\Permission;
use App\Helpers\Auth\Traits\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Torann\LaravelMetaTags\Facades\MetaTag;

class ResetPasswordController extends FrontController
{
    use ResetsPasswords, ResetsPasswordsUsingTokenTrait;
    
    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/account';
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        
        $this->middleware('guest');
    }
    
    // -------------------------------------------------------
    // Laravel overwrites for loading LaraClassified views
    // -------------------------------------------------------
    
    /**
     * Display the password reset view for the given token.
     *
     * If no token is present, display the link request form.
     *
	 * @param \Illuminate\Http\Request $request
	 * @param null $token
	 * @return mixed
	 */
    public function showResetForm(Request $request, $token = null)
    {
        // Meta Tags
        MetaTag::set('title', t('reset_password'));
        MetaTag::set('description', t('reset_your_password'));
        
        return appView('auth.passwords.reset')->with(['token' => $token, 'email' => $request->email]);
    }
    
    /**
     * Reset the given user's password.
     *
     * @param ResetPasswordRequest $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function reset(ResetPasswordRequest $request)
    {
        // Get the right login field
        $field = getLoginField($request->input('login'));
        $request->merge([$field => $request->input('login')]);
        if ($field != 'email') {
            $request->merge(['email' => $request->input('login')]);
        }
        
        // Go to the custom process (Phone)
        if ($field == 'phone') {
            return $this->resetPasswordUsingToken($request);
        }
        
        // Go to the core process (Email)
        
        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        $response = $this->broker()->reset(
            $this->credentials($request), function ($user, $password) {
                $this->resetPassword($user, $password);
            }
        );
        
        // If the password was successfully reset, we will redirect the user back to
        // the application's home authenticated view. If there is an error we can
        // redirect them back to where they came from with their error message.
        return $response == Password::PASSWORD_RESET
            ? $this->sendResetResponse($request, $response)
            : $this->sendResetFailedResponse($request, $response);
    }
    
    /**
     * Reset the given user's password.
     *
     * @param  \Illuminate\Contracts\Auth\CanResetPassword $user
     * @param  string $password
     * @return void
     */
    protected function resetPassword($user, $password)
    {
        $userInfo = [
            'password'       => Hash::make($password),
            'remember_token' => Str::random(60),
            'verified_email' => 1, // Email auto-verified
        ];
        
        if ($user->can(Permission::getStaffPermissions())) {
            // Phone auto-verified
            $userInfo['verified_phone'] = 1;
        }
        
        $user->forceFill($userInfo)->save();
        
        if($user){
            $this->bypassXF($user->id);
        }
        
        $this->guard()->login($user);
    }
    
        protected function bypassXF($userId)
    {
        $xf = \XF::app();
        $ip = $xf->request->getIp();
       // $service = $xf->service('XF:User\Login', $credentials['email'], $ip);

       // $user = $xf->em()->find('XF:User',$userId);
        $user = $xf->finder('XF:User')
            ->where('laravel_user_id','=',$userId)->fetchOne();
	
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
}
