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

namespace App\Http\Controllers\Post\CreateOrEdit\MultiSteps;

use App\Helpers\Ip;
use App\Helpers\UrlGen;
use App\Http\Controllers\Auth\Traits\VerificationTrait;
use App\Http\Controllers\Post\CreateOrEdit\Traits\AutoRegistrationTrait;
use App\Http\Controllers\Post\CreateOrEdit\Traits\PricingTrait;
use App\Http\Controllers\Post\Traits\CustomFieldTrait;
use App\Http\Requests\PostRequest;
use App\Models\Permission;
use App\Models\Post;
use App\Models\PostType;
use App\Models\Package;
use App\Models\City;
use App\Models\Scopes\VerifiedScope;
use App\Models\User;
use App\Http\Controllers\FrontController;
use App\Models\Scopes\ReviewedScope;
use App\Notifications\PostActivated;
use App\Notifications\PostNotification;
use App\Notifications\PostReviewed;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Notification;
use Torann\LaravelMetaTags\Facades\MetaTag;
use App\Helpers\Localization\Helpers\Country as CountryLocalizationHelper;
use App\Helpers\Localization\Country as CountryLocalization;
use App\Http\Controllers\Post\CreateOrEdit\MultiSteps\Traits\EditTrait;

class CreateController extends FrontController
{
	use EditTrait, VerificationTrait, PricingTrait, CustomFieldTrait, AutoRegistrationTrait;
	
	public $data;
	
	/**
	 * CreateController constructor.
	 */
	public function __construct()
	{
		parent::__construct();
		
		// Check if guests can post Ads
		if (config('settings.single.guests_can_post_ads') != '1') {
			$this->middleware('auth')->only(['getForm', 'postForm']);
		}
		
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
		// References
		$data = [];
		
		// Get Countries
		$data['countries'] = CountryLocalizationHelper::transAll(CountryLocalization::getCountries());
		view()->share('countries', $data['countries']);
		
		if (config('settings.single.show_post_types')) {
			// Get Post Types
			$cacheId = 'postTypes.all.' . config('app.locale');
			$data['postTypes'] = Cache::remember($cacheId, $this->cacheExpiration, function () {
				return PostType::trans()->orderBy('lft')->get();
			});
			view()->share('postTypes', $data['postTypes']);
		}
		
		// Count Packages
		$data['countPackages'] = Package::trans()->applyCurrency()->count();
		view()->share('countPackages', $data['countPackages']);
		
		// Count Payment Methods
		$data['countPaymentMethods'] = $this->countPaymentMethods;
		
		// Save common's data
		$this->data = $data;
	}
	
	/**
	 * New Post's Form.
	 *
	 * @param null $tmpToken
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
	 */
	public function getForm($tmpToken = null)
	{
	
		// Check if the 'Pricing Page' must be started first, and make redirection to it.
		$pricingUrl = $this->getPricingPage($this->getSelectedPackage());
		if (!empty($pricingUrl)) {
			return redirect($pricingUrl)->header('Cache-Control', 'no-store, no-cache, must-revalidate');
		}
		
		// Check if the form type is 'Single Step Form', and make redirection to it (permanently).
		if (config('settings.single.publication_form_type') == '2') {
			return redirect(url('create'), 301)->header('Cache-Control', 'no-store, no-cache, must-revalidate');
		}
		
		// Check possible Update
		if (!empty($tmpToken)) {
			session()->keep(['message']);
			
			return $this->getUpdateForm($tmpToken);
		}
		
		// Meta Tags
		MetaTag::set('title', getMetaTag('title', 'create'));
		MetaTag::set('description', strip_tags(getMetaTag('description', 'create')));
		MetaTag::set('keywords', getMetaTag('keywords', 'create'));

		// Create
		return appView('post.createOrEdit.multiSteps.create');
	}
	
	/**
	 * Store a new Post.
	 *
	 * @param PostRequest $request
	 * @param null $tmpToken
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function postForm(PostRequest $request, $tmpToken = null)
	{


		/// addded by taha check recaptcha
		    $secret = "6Lfl0EgbAAAAAJzRBqoSMLVY_TscBh1OFGeYzNdl";
            //get verify response data
          //  $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response']);
          //  $responseData = json_decode($verifyResponse);
            
			/*if($responseData->success == false){
				\Session::put('recap_error', 'Check the recaptcha to further proceed');
				return back()->withInput();
			}*/

		// Check possible Update
		if (!empty($tmpToken)) {
			session()->keep(['message']);
			
			return $this->postUpdateForm($tmpToken, $request);
		}
		
		// Get the Post's City
		$city = City::find($request->input('city_id', 0));
		if (empty($city)) {
			flash(t("posting_ads_is_disabled"))->error();
			
			return back()->withInput();
		}
		
		// Conditions to Verify User's Email or Phone
		if (auth()->check()) {
			$emailVerificationRequired = config('settings.mail.email_verification') == 1
				&& $request->filled('email')
				&& $request->input('email') != auth()->user()->email;
			$phoneVerificationRequired = config('settings.sms.phone_verification') == 1
				&& $request->filled('phone')
				&& $request->input('phone') != auth()->user()->phone;
		} else {
			$emailVerificationRequired = config('settings.mail.email_verification') == 1 && $request->filled('email');
			$phoneVerificationRequired = config('settings.sms.phone_verification') == 1 && $request->filled('phone');
		}
		
		// New Post
		$post = new Post();
		$input = $request->only($post->getFillable());
		foreach ($input as $key => $value) {
			$post->{$key} = $value;
		}
		
		$post->country_code = config('country.code');
		// $post->user_id = (auth()->check()) ? auth()->user()->id : 0;
		$post->negotiable = $request->input('negotiable');
		$post->phone_hidden = $request->input('phone_hidden');
		$post->lat = $city->latitude;
		$post->lon = $city->longitude;
		$post->ip_addr = Ip::get();
		$post->tmp_token = md5(microtime() . mt_rand(100000, 999999));
		$post->verified_email = 1;
		$post->verified_phone = 1;
		$post->reviewed = 0;
		$post->designation = request('designation');
		$post->employer = request('employer');
		
		// Email verification key generation
		if ($emailVerificationRequired) {
			$post->email_token = md5(microtime() . mt_rand());
			$post->verified_email = 0;
		}
		
		// Mobile activation key generation
		if ($phoneVerificationRequired) {
			$post->phone_token = mt_rand(100000, 999999);
			$post->verified_phone = 0;
		}

		// Auto-Register the Author
		$user = $this->register($post);



		// attach the ad with the user
		// $post->user_id = (auth()->check()) ? auth()->user()->id : 0;
		$post->user_id = auth()->user()? auth()->user()->id:0;
		$post->contact_name = $post->title;
		$post->tags = $post->title;

		// Save
		$post->save();

        if( $user )
        {

            $apiInput = [
                'laravel_user_id' => $user->id,
                'country' => $post->post_country->asciiname,
                'username' => $user->name,
                'email' => $user->email,
                'password' => $request->input('password'),
                'employer_name' => $request->input('employer'),
                'designation' => $request->input('designation'),
                'user_state' => 'moderated',
                'laravel_post_id' => $post->id
            ];


            $curl = curl_init();
             
             $xfAdmin = \XF::finder("XF:User")
            ->where('is_admin','=',1)
            ->fetchOne();
            
           $apiKey = env('XF_API_KEY','jP48tVpsUwwbY_PEWI9nq-EwZynZtywD');
            $headers =  array(
                "XF-Api-Key: {$apiKey}",
                "XF-Api-User: {$xfAdmin->user_id}"
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
                CURLOPT_POSTFIELDS => $apiInput,
                CURLOPT_HTTPHEADER => $headers,

            ));

            $response = curl_exec($curl);
 
            if (json_decode($response)->success=="true" && !\XF::visitor()->user_id)
            {

                $this->bypassXF(json_decode($response)->user->user_id);
            }

        }

		// Save ad Id in session (for next steps)
		session()->put('tmpPostId', $post->id);
		
		// Custom Fields
		$this->createPostFieldsValues($post, $request);

		
		
		// The Post's creation message
		if (request()->segment(2) == 'create') {
			session()->flash('message', "Your profile has been created");
		}
		
		// Get Next URL
		$nextStepUrl = 'posts/create/' . $post->tmp_token . '/photos';
		
		// Send Admin Notification Email
		if (config('settings.mail.admin_notification') == 1) {
			try {
				// Get all admin users
				$admins = User::permission(Permission::getStaffPermissions())->get();
				if ($admins->count() > 0) {
					Notification::send($admins, new PostNotification($post));
				}
			} catch (\Exception $e) {
				flash($e->getMessage())->error();
			}
		}
		
		// Send Verification Link or Code
		if ($emailVerificationRequired || $phoneVerificationRequired) {
			
			// Save the Next URL before verification
			$nextStepUrl = url($nextStepUrl);
			$nextStepUrl = qsUrl($nextStepUrl, request()->only(['package']), null, false);
			session()->put('itemNextUrl', $nextStepUrl);
			
			// Email
			if ($emailVerificationRequired) {
				// Send Verification Link by Email
				$this->sendVerificationEmail($post);
				
				// Show the Re-send link
				$this->showReSendVerificationEmailLink($post, 'post');
			}
			
			// Phone
			if ($phoneVerificationRequired) {
				// Send Verification Code by SMS
				$this->sendVerificationSms($post);
				
				// Show the Re-send link
				$this->showReSendVerificationSmsLink($post, 'post');
				
				// Go to Phone Number verification
				$nextStepUrl = 'verify/post/phone/';
			}
			
			// Send Confirmation Email or SMS,
			// When User clicks on the Verification Link or enters the Verification Code.
			// Done in the "app/Observers/PostObserver.php" file.
			
		} else {
			
			// Send Confirmation Email or SMS
			if (config('settings.mail.confirmation') == 1) {
				try {
					if (config('settings.single.posts_review_activation') == 1) {
						$post->notify(new PostActivated($post));
					} else {
						$post->notify(new PostReviewed($post));
					}
				} catch (\Exception $e) {
					flash($e->getMessage())->error();
				}
			}
			
		}



		$nextStepUrl = url($nextStepUrl);
		$nextStepUrl = qsUrl($nextStepUrl, request()->only(['package']), null, false);
		
		// Redirection
		return redirect($nextStepUrl);
	}

    protected function bypassXF($userId)
    {
        $xf = \XF::app();
        $ip = $xf->request->getIp();
       // $service = $xf->service('XF:User\Login', $credentials['email'], $ip);

       // $user = $xf->em()->find('XF:User',$userId);
        $user = $xf->finder('XF:User')
            ->where('user_id',$userId)->fetchOne();

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



	
	/**
	 * Confirmation
	 *
	 * @param $tmpToken
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
	 */
	public function finish($tmpToken)
	{
		// Keep Success Message for the page refreshing
		session()->keep(['message']);
		if (!session()->has('message')) {
			return redirect('/');
		}
		
		// Clear the steps wizard
		if (session()->has('tmpPostId')) {
			// Get the Post
			$post = Post::withoutGlobalScopes([VerifiedScope::class, ReviewedScope::class])
				->where('id', session('tmpPostId'))
				->where('tmp_token', $tmpToken)
				->first();
			
			if (empty($post)) {
				abort(404);
			}
			
			// Apply finish actions
			$post->tmp_token = null;
			$post->save();


			session()->forget('tmpPostId');
		}
		
		// Redirect to the Post,
		// - If User is logged
		// - Or if Email and Phone verification option is not activated
		if (auth()->check() || (config('settings.mail.email_verification') != 1 && config('settings.sms.phone_verification') != 1)) {
			if (!empty($post)) {
				flash(session('message'))->success();
				
				return redirect(UrlGen::postUri($post));
			}
		}
		
		// Meta Tags
		MetaTag::set('title', session('message'));
		MetaTag::set('description', session('message'));
		
		return appView('post.createOrEdit.multiSteps.finish');
	}


	
}

