{{--
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
--}}
@extends('layouts.master')

@section('content')
	@includeFirst([config('larapen.core.customizedViewPath') . 'common.spacer', 'common.spacer'])
	<div class="main-container">
		<div class="container-fluid">
			<div class="row">

				@if (Session::has('flash_notification'))
					<div class="col-xl-12">
						<div class="row">
							<div class="col-xl-12">
								@include('flash::message')
							</div>
						</div>
					</div>
				@endif


				<div class="col-md-3 page-sidebar">
					@includeFirst([config('larapen.core.customizedViewPath') . 'account.inc.sidebar', 'account.inc.sidebar'])
				</div>
				<!--/.page-sidebar-->

				<div class="col-md-9 page-content">

					@if(\Session::has('pass_error'))
					<div class="col-xl-12">
						<div class="alert alert-danger">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<h5><strong>Oops ! An error has occurred.</strong></h5>
							<ul class="list list-check">
								<li>{{\Session::get('pass_error')}}</li>

							</ul>
						</div>
					</div>
					@endif
					@if(\Session::has('pass_error'))
					@php
						\Session::forget('pass_error')
					@endphp
					@endif

					<div class="inner-box">
						<h2 class="title-2"><i class="icon-cancel-circled "></i> {{ t('Close account') }} </h2>
						<p>Closing your account will delete your profile from Gulf Lab EXPO permanently. This will also delete your profile and your contacts and message history from Gulf Lab EXPO Forum. You will not be able to message any members or post on the forum once your account is closed</p>

						@if ($user->can(\App\Models\Permission::getStaffPermissions()))
							<div class="alert alert-danger" role="alert">
								{{ t('Admin users can not be deleted by this way') }}
							</div>
						@else
							<form role="form" method="POST" action="{{ url('account/close') }}">
								{!! csrf_field() !!}
								<div class="form-group row">

									<div class="col-md-5">
										<div class="input-group show-pwd-group">
											<div class="input-group-prepend">
												<span class="input-group-text"><i class="icon-key"></i></span>
											</div>
											<input id="password" name="password" type="password" class="form-control" placeholder="{{ t('password') }}" autocomplete="off">
											<span class="icon-append show-pwd">
												<button type="button" class="eyeOfPwd">
													<i class="far fa-eye-slash"></i>
												</button>
											</span>
										</div>
									</div>

									<div class="col-md-12">
										<div class="form-check form-check-inline pt-2">
											<label class="form-check-label">
												<input class="form-check-input"
													   type="checkbox"
													   name="close_account_confirmation"
													   id="closeAccountConfirmation1"
													   value="1"
													   required
												> I have read the message and fully understand the consequences of closing my account
											</label>
										</div>


										{{-- <div class="form-check form-check-inline pt-2">
											<label class="form-check-label">
												<input class="form-check-input"
													   type="radio"
													   name="close_account_confirmation"
													   id="closeAccountConfirmation0"
													   value="0" checked
												> {{ t('No') }}
											</label>
										</div> --}}
									</div>
								</div>

								<div class="form-group row">
									<div class="col-md-12">
										<button type="submit" class="btn btn-primary">{{ t('submit') }}</button>
									</div>
								</div>
							</form>
						@endif

					</div>
					<!--/.inner-box-->
				</div>
				<!--/.page-content-->

			</div>
			<!--/.row-->
		</div>
		<!--/.container-->
	</div>
	<!-- /.main-container -->
@endsection
