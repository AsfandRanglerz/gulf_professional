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

use App\Helpers\Ip;
use App\Helpers\Localization\Country as CountryLocalization;
use App\Helpers\Localization\Helpers\Country as CountryLocalizationHelper;
use App\Http\Controllers\Auth\Traits\VerificationTrait;
use App\Http\Controllers\FrontController;
use App\Http\Requests\UserRequest;
use App\Models\Gender;
use App\Models\Permission;
use App\Models\User;
use App\Models\UserType;
use App\Notifications\UserActivated;
use App\Notifications\UserNotification;
use App\Helpers\Auth\Traits\RegistersUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Torann\LaravelMetaTags\Facades\MetaTag;

class RegisterController extends FrontController
{
	use RegistersUsers, VerificationTrait;
	
	/**
	 * Where to redirect users after login / registration.
	 *
	 * @var string
	 */
	protected $redirectTo = '/account';
	
	/**
	 * @var array
	 */
	public $msg = [];
	
	/**
	 * RegisterController constructor.
	 */
	public function __construct()
	{
		parent::__construct();
		
		// From Laravel 5.3.4 or above
		$this->middleware(function ($request, $next) {
			$this->commonQueries();
			
			return $next($request);
		});
	}
	
	/**
	 * Common Queries
	 */
	public function commonQueries()
	{
		$this->redirectTo = 'account';
	}
	
	/**
	 * Show the form the create a new user account.
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function showRegistrationForm()
	{
		$data = [];
		
		// References
		$data['countries'] = CountryLocalizationHelper::transAll(CountryLocalization::getCountries());
		$data['genders'] = Gender::trans()->get();
		
		// Meta Tags
		MetaTag::set('title', getMetaTag('title', 'register'));
		MetaTag::set('description', strip_tags(getMetaTag('description', 'register')));
		MetaTag::set('keywords', getMetaTag('keywords', 'register'));
		
		return appView('auth.register.index', $data);
	}
	
	/**
	 * Register a new user account.
	 *
	 * @param UserRequest $request
	 * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function register(UserRequest $request)
	{
		// Conditions to Verify User's Email or Phone
		$emailVerificationRequired = config('settings.mail.email_verification') == 1 && $request->filled('email');
		$phoneVerificationRequired = config('settings.sms.phone_verification') == 1 && $request->filled('phone');
		
		// New User
		$user = new User();
		$input = $request->only($user->getFillable());

		foreach ($input as $key => $value) {
			$user->{$key} = $value;
		}
		
		$user->country_code = config('country.code');
		$user->language_code = config('app.locale');
		$user->password = Hash::make($request->input('password'));
		$user->phone_hidden = $request->input('phone_hidden');
		$user->ip_addr = Ip::get();
		$user->verified_email = 1;
		$user->verified_phone = 1;
		
		// Email verification key generation
		if ($emailVerificationRequired) {
			$user->email_token = md5(microtime() . mt_rand());
			$user->verified_email = 0;
		}
		
		// Mobile activation key generation
		if ($phoneVerificationRequired) {
			$user->phone_token = mt_rand(100000, 999999);
			$user->verified_phone = 0;
		}
		
		// Save
		$user->save();

        $curl = curl_init();

        unset($input['accept_terms']);
        unset($input['accept_marketing_offers']);
        unset($input['phone']);

        $input['laravel_user_id'] = $user->id;
        $input['country'] = $input['country_code'];
        $input['username'] = $input['name'];
        unset($input['country_code']);
        unset($input['name']);

        $apiKey = env('XF_API_KEY');
        $headers =  array(
            "XF-Api-Key: {$apiKey}",
            "XF-Api-User: 1"
        );

        curl_setopt_array($curl, array(
            CURLOPT_URL => url('/forum/index.php?api/users'),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $input,
            CURLOPT_HTTPHEADER => $headers,

        ));

        $response = curl_exec($curl);

       $this->bypassXF($input);
       // curl_close($curl);

		
		// Message Notification & Redirection
		$request->session()->flash('message', t("your_account_has_been_created"));
		$nextUrl = 'register/finish';
		
		// Send Admin Notification Email
		if (config('settings.mail.admin_notification') == 1) {
			try {
				// Get all admin users
				$admins = User::permission(Permission::getStaffPermissions())->get();
				if ($admins->count() > 0) {
					Notification::send($admins, new UserNotification($user));
					/*
                    foreach ($admins as $admin) {
						Notification::route('mail', $admin->email)->notify(new UserNotification($user));
                    }
					*/
				}
			} catch (\Exception $e) {
				flash($e->getMessage())->error();
			}
		}
		
		// Send Verification Link or Code
		if ($emailVerificationRequired || $phoneVerificationRequired) {
			
			// Save the Next URL before verification
			session()->put('userNextUrl', $nextUrl);
			
			// Email
			if ($emailVerificationRequired) {
				// Send Verification Link by Email
				$this->sendVerificationEmail($user);
				
				// Show the Re-send link
				$this->showReSendVerificationEmailLink($user, 'user');
			}
			
			// Phone
			if ($phoneVerificationRequired) {
				// Send Verification Code by SMS
				$this->sendVerificationSms($user);
				
				// Show the Re-send link
				$this->showReSendVerificationSmsLink($user, 'user');
				
				// Go to Phone Number verification
				$nextUrl = 'verify/user/phone/';
			}
			
			// Send Confirmation Email or SMS,
			// When User clicks on the Verification Link or enters the Verification Code.
			// Done in the "app/Observers/UserObserver.php" file.
			
		} else {
			
			// Send Confirmation Email or SMS
			if (config('settings.mail.confirmation') == 1) {
				try {
					$user->notify(new UserActivated($user));
				} catch (\Exception $e) {
					flash($e->getMessage())->error();
				}
			}
			
			// Redirect to the user area If Email or Phone verification is not required
			if (Auth::loginUsingId($user->id)) {
				return redirect()->intended('account');
			}
			
		}
		
		// Redirection
		return redirect($nextUrl);
	}

    protected function bypassXF($credentials)
    {
        $xf = \XF::app();
        $ip = $xf->request->getIp();
        $service = $xf->service('XF:User\Login', $credentials['email'], $ip);

        $user = $service->validate("Gulf@123", $error);

        $xf->session->changeUser($user);
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
	
	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
	 */
	public function finish()
	{
		// Keep Success Message for the page refreshing
		session()->keep(['message']);
		if (!session()->has('message')) {
			return redirect('/');
		}
		
		// Meta Tags
		MetaTag::set('title', session('message'));
		MetaTag::set('description', session('message'));
		
		return appView('auth.register.finish');
	}
}
