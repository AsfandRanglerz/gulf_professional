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

@section('header')
	@includeFirst([config('larapen.core.customizedViewPath') . 'layouts.inc.header', 'layouts.inc.header'])
@endsection

@section('search')
	@parent
@endsection

@section('content')
	@includeFirst([config('larapen.core.customizedViewPath') . 'common.spacer', 'common.spacer'])
	<div class="main-container inner-page">
		<div class="container-fluid">
			<div class="section-content">
				<div class="row">
					<div class="col-sm-12">
						<p>Gulf Lab EXPO is the next generation expo for the MENA (Middle East and North Africa) region. Join Gulf Lab EXPO and get unprecedented opportunities to network with other clinical lab professionals in the MENA region.</p>
						<div class="row mx-sm-4 mx-2 mb-3">
							<div class="col-sm-4 text-center">
								<img src="{{ url('/images/profile-5.png') }}" alt="forum-3" class="post-contact-ask-imgs" />
								<h4 class="heading">Post Free Profile</h4>
								<p>List yourself on Gulf Lab EXPO and discover networking opportunities in the MENA lab industry</p>
							</div>
							<div class="col-sm-4 text-center">
								<img src="{{ url('/images/search-contact-3.png') }}" alt="profile-5" class="post-contact-ask-imgs" />
								<h4 class="heading">Search & Contact Members</h4>
								<p>Search and contact other listed members for relevant inquiries and networking opportunities</p>
							</div>
							<div class="col-sm-4 text-center">
								<img src="{{ url('/images/forum-3.jpg') }}" alt="search-contact-3" class="post-contact-ask-imgs" />
								<h4 class="heading">Ask and Advise</h4>
								<p>Ask questions or share knowledge by joining forums and group discussions on relevant topics</p>
							</div>
						</div>
					</div>
					<h1 class="text-center title-1" style="text-transform: none;">
						<strong>Create Your Profile</strong>
					</h1>
					<hr class="center-block small mt-0">

					@if (isset($countryCols))
						<div class="col-md-12 page-content">
							<h3 class="title-2 mena-country-heading"><span class="icon-location-2 mr-2"></span>Select the MENA Country where you live</h3>

							<div class="inner-box relative">
								<div class="row m-0">
									@if (!empty($countryCols))
										@foreach ($countryCols as $key => $col)
											<?php $classBorder = (count($countryCols) == $key+1) ? ' cat-list-border' : ''; ?>
											<ul class="cat-list col-xl-3 col-lg-3 col-md-4 col-sm-6 col-xs-6{{ $classBorder }}">
												@foreach ($col as $k => $country)
													<li>
														<img src="{{ url('images/blank.gif') . getPictureVersion() }}"
															 class="flag flag-{{ ($country->get('icode')=='uk') ? 'gb' : $country->get('icode') }}"
															 style="margin-bottom: 4px; margin-right: 5px;"
														>
														<a href="{{url('lang-register/en?d='.$country->get('code'))}}"
														   title="{!! $country->get('name') !!}"
														   class="tooltipHere"
														   data-toggle="tooltip"
														   data-original-title="{!! $country->get('name') !!}"
														>{{ \Illuminate\Support\Str::limit($country->get('name'), 30) }}</a>
													</li>
												@endforeach
											</ul>
										@endforeach
									@else
										<div class="col-12 text-center mb30 text-danger">
											<strong>{{ t('countries_not_found') }}</strong>
										</div>
									@endif
								</div>

							</div>
						</div>
					@endif

				</div>

				<!-- @includeFirst([config('larapen.core.customizedViewPath') . 'layouts.inc.social.horizontal', 'layouts.inc.social.horizontal']) -->
				<p class="mt-3">Registration of Personal Profile on Gulf Lab EXPO is limited to professionals living in the MENA region</p>
			</div>
		</div>
	</div>
@endsection

@section('info')
@endsection

@section('after_scripts')
@endsection
