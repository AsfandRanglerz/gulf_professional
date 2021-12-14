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

namespace App\Http\Controllers\Account;

use App\Helpers\UrlGen;
use App\Models\Permission;
use App\Models\User;
use http\Cookie;

class CloseController extends AccountBaseController
{
	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index()
	{

		view()->share('pagePath', 'close');
		
		return appView('account.close');
	}
	
	/**
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function submit()
	{

		if (request()->input('close_account_confirmation') == 1) {
			// Get User
			$user = User::findOrFail(auth()->user()->id);
			if(request('password')){
				if(\Hash::check(request('password'), $user->password)){
					// Don't delete admin users
					if ($user->can(Permission::getStaffPermissions())) {
						flash(t('admin_users_cannot_be_deleted'))->error();
						
						return redirect('account');
					}
		
					$data['user'] = $user;
					// dd($data);



//                    dd("close",$user->delete(), $xfUser->delete());
					///Addded by taha send account close email
					\Mail::to($user->email)->send(new \App\Mail\CloseAccountEmail($user));

					// Delete User

                    if($this->deleteXfUser($user))
                    {
                        $user->delete();
                        
                        // Close User's session
                        auth()->logout();

                        $message = t('your_account_has_been_deleted_2', ['url' => UrlGen::register()]);
                        flash($message)->success();

                    }

					return redirect('/');
				}
				else{
					\Session::put('pass_error', 'Password is invalid');
					return back();
				}
			}
			else{
				\Session::put('pass_error', 'Enter your Password to close the account');
				return back();
			}
			
			
		}
		else{
			return back();
		}
		
		
	}

	protected function deleteXfUser($user){
        $xfUser = \XF::finder("XF:User")
            ->where('laravel_user_id','=',$user->id)
            ->fetchOne();

        $xfAdmin = \XF::finder("XF:User")
            ->where('is_admin','=',1)
            ->fetchOne();

        $apiKey = env('XF_API_KEY','jP48tVpsUwwbY_PEWI9nq-EwZynZtywD');
        $headers = array(
            "XF-Api-Key: {$apiKey}",
            "XF-Api-User: {$xfAdmin->user_id}"
        );

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => url("/forum/index.php?api/users/".$xfUser->user_id),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'DELETE',
            CURLOPT_HTTPHEADER => $headers,
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return json_decode($response)->success;

    }
   
}
