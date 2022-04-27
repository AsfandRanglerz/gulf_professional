<?php
if (
	config('settings.other.ios_app_url') ||
	config('settings.other.android_app_url') ||
	config('settings.social_link.facebook_page_url') ||
	config('settings.social_link.twitter_url') ||
	config('settings.social_link.google_plus_url') ||
	config('settings.social_link.linkedin_url') ||
	config('settings.social_link.pinterest_url') ||
	config('settings.social_link.instagram_url')
) {
	$colClass1 = 'col-lg-3 col-md-3 col-sm-3 col-xs-6';
	$colClass2 = 'col-lg-3 col-md-3 col-sm-3 col-xs-6';
	$colClass3 = 'col-lg-2 col-md-2 col-sm-2 col-xs-12';
	$colClass4 = 'col-lg-4 col-md-4 col-sm-4 col-xs-12';
} else {
	$colClass1 = 'col-lg-4 col-md-4 col-sm-4 col-xs-6';
	$colClass2 = 'col-lg-4 col-md-4 col-sm-4 col-xs-6';
	$colClass3 = 'col-lg-4 col-md-4 col-sm-4 col-xs-12';
	$colClass4 = 'col-lg-4 col-md-4 col-sm-4 col-xs-12';
}
?>
<div class="footer">
	<style type="text/css" media="screen">
		.welcome-text-below2 {
			padding: 0px 0;
			border: 1px solid #999;
			background: #ff7c19;
			color: #fff;
		}

		.welcome-content-below2 h5 {
			text-transform: inherit;
			font-size: 18px;
			font-family: Arial;
			margin-top: 10px;
			margin-bottom: 10px;
		}

		.footer {
			padding: 0;
		}

		#footer {
			padding: 0;
			position: relative;
		    background: #096791;
		}

		.footer-inner {
			padding: 25px 30px!important;
			overflow: hidden;
		}

		.footer_bottom_li {
			margin-top: 5px;
			list-style-type: none;
			margin-left: 0;
			padding: 0;
			overflow: hidden;
		}

		.footer_bottom_li li {
			float: left;
		}

		.footer_bottom_li li a {
			display: block;
			color: unset;
			text-align: center;
			padding-right: 5px;
			margin-right: 3px;
			text-decoration: underline;
			background-color: unset;
			font-size: 12px;
			font-weight: bold;
		}
	
		.footer_bottom_li li a:hover {
			background-color: unset;
			color: #ff7c19;
		}

		.welcome-content-below2 h5 {
			padding: 0 15px;
		}

		#footer .widget-description {
			margin: 0;
			color: #fff;
		}

		#footer .widget-description p {
			margin: unset;
			height: auto;
			overflow: hidden;
			line-height: 19px;
			padding-bottom: 1%;
			text-align: justify;
		}

		#footer .quick_links li a {
			margin-bottom: 5px;
			display: block;
			color: #fff;
			word-spacing: 5px;
			font-size: 14px;
		}

		#footer .quick_links li a:hover {
			color: #ff7c19;
		}

		#footer .footer-copyrights {
			padding: 5px 15px;
		    background: #a9a9a9;
		}

		#footer .footer-copyrights p {
			padding: 5px 0;
			margin: 0;
			color: #000;
		}

		.custom-list {
			padding: 0;
			margin: 0;
		}

		#footer .footer-copyrights .social li {
			float: left;
			margin-left: 5px;
		}

		#footer .footer-copyrights .social li .icon {
			color: #FFF;
		}
		
		#footer .footer-copyrights .social li a:hover {
			background: #FFF;
		}

		.facebook, .twitter, .google-plus, .pinterest, .linkedin, .dribbble {
			display: inline-block;
			width: 25px;
			height: 25px;
			text-align: center;
			line-height: 25px;
		}

		.facebook {
			background: #3b5999;
			border: 1px solid #3b5999;
		}

		.facebook:hover .icon {
			color: #3b5999!important;
		}

		.google-plus {
			background: #dd4b39;
			border: 1px solid #dd4b39;
		}

		.google-plus:hover .icon {
			color: #dd4b39!important;
		}

		.twitter {
			background: #55acee;
			border: 1px solid #55acee;
		}

		.twitter:hover .icon {
			color: #55acee!important;
		}

		.linkedin {
			background: #0073b2;
			border: 1px solid #0073b2;
		}

		.linkedin:hover .icon {
			color: #0073b2!important;
		}

		#footer .widget-title {
			text-transform: capitalize;
			color: #fff;
			font-weight: bold;
			font-size: 18px;
		}

		@media  only screen and (max-width: 1199px) {
			.footer-top h5,
			.welcome-content-below2 h5 {
				font-size: 14px!important;
			}

			#footer .widget-description p,
			#footer .footer-copyrights p {
				margin: unset;
				font-size: 13px!important;
			}

			#footer .quick_links li a {
				font-size: 12px!important;
			}

			.footer_bottom_li li a span {
				font-size: 11px!important;
			}
		}

		@media  only screen and (max-width: 991px) {
			#footer .widget-title {
				margin: 12px 0;
				padding: 0;
			}

			.footer_bottom_li {
				margin: 10px 0;
			}

			.footer-inner {
				padding: 8px 0 16px 0!important;
			}
		}

		@media (max-width: 767px) {
			.footer ul {
				text-align: left;
				margin: 10px 0!important;
			}
		}

		@media  only screen and (max-width: 575px) {
			#footer .footer-copyrights {
				padding-top: 8px;
				padding-bottom: 12px;
				text-align: center;
			}

			ul.social.pull-right.custom-list {
				margin: 0!important;
				display: flex;
				justify-content: center;
			}

			.footer-top h5,
			.welcome-content-below2 h5 {
				font-size: 13px!important;
			}

			#footer .widget-description p,
			#footer .footer-copyrights p {
				margin: unset;
				font-size: 12px!important;
			}

			#footer .quick_links li a {
				font-size: 11px!important;
			}

			.footer-top .col-md-4,
			.footer-top .col-md-8 {
				padding-left: 5px;
				padding-right: 5px;
			}
		}
	</style>
	<div class="welcome-text-below2">
		<div class="css-table">
			<div class="css-table-cell">
				<div class="welcome-content-below2" align="center">

					<h5><strong>Gulf Lab EXPO - Online Expo for Clinical Lab Equipment, Products and Services for MENA Region</strong></h5>
				</div>
			</div>
		</div>
	</div>


	<!-- End Footer -->


	<!-- End Back-To-Top Button -->
	<footer id="footer">
		<div class="container-fluid footer-inner">
			<div class="m-0 row">

				<!-- Start Footer-Top -->
				<div class="footer-top">
					<div class="mx-0 row">
						<div class="col-md-4 pl-0">
							<div class="widget pl-lg-0 col-lg-12 col-sm-12 col-xs-12">
								<h5 class="widget-title">Gulf Lab EXPO</h5>
								<div class="widget-description">
									<p>Gulf Lab EXPO is a Virtual Expo and Marketplace for Clinical Lab Products, Equipment and Services for the MENA (Middle East North Africa) region. Visitors can find lab products and get one-click access to suppliers and distributors for MENA region. Members can create a professional profile to network and exchange knowledge with other lab professionals in MENA, post and search classifieds for lab jobs, products and support services, and get latest news on advances in the clinical lab industry.</p>
									<ul class="footer_bottom_li">

										<li> <a href="#"> <span class="caption">Terms of Use</span> </a> </li>
										<li> <a href="https://gulflabexpo.com/privacy-policy"> <span class="caption">Privacy Policy</span> </a> </li>
										<li> <a href="https://gulflabexpo.com/advertisement"> <span class="caption">Advertise with us</span> </a> </li>
										<li> <a href="#"> <span class="caption">Site Map</span> </a> </li>
									</ul>
								</div>
							</div>
						</div>
						<div class="col-md-8 row mx-0 p-0">
							<div class="widget col-sm-3 col-xs-12">
								<h5 class="widget-title">Online Expo</h5>
								<ul class="quick_links custom-list">
									<li><a href="#">Search Products</a></li>
									<li><a href="#">Search Company</a></li>
									<li><a href="#">Search Distributors</a></li>
									<li><a href="https://gulflabexpo.com/reqistrationFlow?flow=2">Register Company</a></li>
								</ul>
							</div>

							<div class="widget col-sm-3 col-xs-12">
								<h5 class="widget-title">Networking</h5>
								<ul class="quick_links custom-list">
									<li><a href="#">Create Your Profile</a></li>
									<li><a href="#">Find a Professional</a></li>
									<li><a href="#">Post a Question</a></li>
									<li><a href="#">Join a Discussion</a></li>
								</ul>
							</div>
							<div class="widget col-sm-3 col-xs-12">
								<h5 class="widget-title">Classifieds</h5>
								<ul class="quick_links custom-list">
									<li><a href="#">Post an Ad</a></li>
									<li><a href="#">Find a Job</a></li>
									<li><a href="#">Find a Product</a></li>
									<li><a href="#">Find a Service</a></li>
								</ul>
							</div>
							<div class="widget col-sm-3 col-xs-12">
								<h5 class="widget-title">News</h5>
								<ul class="quick_links custom-list">
									<li><a href="#">Latest News</a></li>
									<li><a href="#">Get News through Email</a></li>
									<li><a href="#">Submit Press Release</a></li>
									<li><a href="#">Submit News/Article</a></li>
									<!--                                <li><a href="#">Create Your Profile</a></li>
                                                                    <li><a href="#">Find a Professional</a></li>
                                                                    <li><a href="#">Post a Question</a></li>
                                                                    <li><a href="#">Join a Discussion</a></li>-->
								</ul>
							</div>

						</div>
					</div>
				</div>
				<!-- End Footer-Top -->

			</div>
		</div>
		<!-- End Container -->

		<!-- Start Footer Copyrights -->

		<div class="footer-copyrights">
			<div class="row mx-0">

				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
					<p> © <?php echo date('Y'); ?> Gulf Lab Expo  - All Rights Reserved</p>
				</div>

				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" style="margin-top:3px;">
					<ul class="social pull-right custom-list">
						<li><a href="https://www.facebook.com/" class="facebook" target="_blank"><span class="icon-facebook icon"></span></a></li>
						<li><a href="https://plus.google.com/" class="google-plus" target="_blank"><spani class="fab fa-google-plus icon"></span></a></li>
						<li><a href="https://twitter.com/" class="twitter" target="_blank"><span class="icon-twitter-bird icon"></span></a></li>
						<li><a href="https://www.linkedin.com/" class="linkedin" target="_blank"><span class="icon-linkedin icon"></span></a></li>
					</ul>
				</div>

			</div>
		</div>
		<!-- End Footer Copyrights -->

	</footer>

</div>
<!-- <footer class="main-footer">
	<div class="footer-content">
		<div class="container-fluid">
			<div class="row">

				@if (!config('settings.footer.hide_links'))
					<div class="{{ $colClass1 }}">
						<div class="footer-col">
							<h4 class="footer-title">{{ t('about_us') }}</h4>
							<ul class="list-unstyled footer-nav">
								@if (isset($pages) and $pages->count() > 0)
									@foreach($pages as $page)
										<li>
											<?php
												$linkTarget = '';
												if ($page->target_blank == 1) {
													$linkTarget = 'target="_blank"';
												}
											?>
											@if (!empty($page->external_link))
												<a href="{!! $page->external_link !!}" rel="nofollow" {!! $linkTarget !!}> {{ $page->name }} </a>
											@else
												<a href="{{ \App\Helpers\UrlGen::page($page) }}" {!! $linkTarget !!}> {{ $page->name }} </a>
											@endif
										</li>
									@endforeach
								@endif
							</ul>
						</div>
					</div>

					<div class="{{ $colClass2 }}">
						<div class="footer-col">
							<h4 class="footer-title">{{ t('Contact and Sitemap') }}</h4>
							<ul class="list-unstyled footer-nav">
								<li><a href="{{ \App\Helpers\UrlGen::contact() }}"> {{ t('Contact') }} </a></li>
								<li><a href="{{ \App\Helpers\UrlGen::sitemap() }}"> {{ t('sitemap') }} </a></li>
								@if (\App\Models\Country::where('active', 1)->count() > 1)
									<li><a href="{{ \App\Helpers\UrlGen::countries() }}"> {{ t('countries') }} </a></li>
								@endif
							</ul>
						</div>
					</div>

					<div class="{{ $colClass3 }}">
						<div class="footer-col">
							<h4 class="footer-title">{{ t('My Account') }}</h4>
							<ul class="list-unstyled footer-nav">
								@if (!auth()->user())
									<li>
										@if (config('settings.security.login_open_in_modal'))
											<a href="#quickLogin" data-toggle="modal"> {{ t('log_in') }} </a>
										@else
											<a href="{{ \App\Helpers\UrlGen::login() }}"> {{ t('log_in') }} </a>
										@endif
									</li>
									{{-- <li><a href="{{ \App\Helpers\UrlGen::register() }}"> {{ t('register') }} </a></li> --}}
									{{-- <li><a href="{{ \App\Helpers\UrlGen::addPost() }}"> {{ t('register') }} </a></li> --}}
									<li><a href="{{ url('create-1') }}"> {{ t('register') }} </a></li>

								@else
									<li><a href="{{ url('account') }}"> {{ t('Personal Home') }} </a></li>
									<li><a href="{{ url('account/my-posts') }}"> {{ 'My Profile' }} </a></li>
									<li><a href="{{ url('account/favourite') }}"> {{ 'Saved Profiles' }} </a></li>
								@endif
							</ul>
						</div>
					</div>

					@if (
						config('settings.other.ios_app_url') or
						config('settings.other.android_app_url') or
						config('settings.social_link.facebook_page_url') or
						config('settings.social_link.twitter_url') or
						config('settings.social_link.google_plus_url') or
						config('settings.social_link.linkedin_url') or
						config('settings.social_link.pinterest_url') or
						config('settings.social_link.instagram_url')
						)
						<div class="{{ $colClass4 }}">
							<div class="footer-col row">
								<?php
									$footerSocialClass = '';
									$footerSocialTitleClass = '';
								?>
								{{-- @todo: API Plugin --}}
								@if (config('settings.other.ios_app_url') or config('settings.other.android_app_url'))
									<div class="col-sm-12 col-xs-6 col-xxs-12 no-padding-lg">
										<div class="mobile-app-content">
											<h4 class="footer-title">{{ t('Mobile Apps') }}</h4>
											<div class="row ">
												@if (config('settings.other.ios_app_url'))
												<div class="col-xs-12 col-sm-6">
													<a class="app-icon" target="_blank" href="{{ config('settings.other.ios_app_url') }}">
														<span class="hide-visually">{{ t('iOS app') }}</span>
														<img src="{{ url('images/site/app-store-badge.svg') }}" alt="{{ t('Available on the App Store') }}">
													</a>
												</div>
												@endif
												@if (config('settings.other.android_app_url'))
												<div class="col-xs-12 col-sm-6">
													<a class="app-icon" target="_blank" href="{{ config('settings.other.android_app_url') }}">
														<span class="hide-visually">{{ t('Android App') }}</span>
														<img src="{{ url('images/site/google-play-badge.svg') }}" alt="{{ t('Available on Google Play') }}">
													</a>
												</div>
												@endif
											</div>
										</div>
									</div>
									<?php
										$footerSocialClass = 'hero-subscribe';
										$footerSocialTitleClass = 'no-margin';
									?>
								@endif

								@if (
									config('settings.social_link.facebook_page_url') or
									config('settings.social_link.twitter_url') or
									config('settings.social_link.google_plus_url') or
									config('settings.social_link.linkedin_url') or
									config('settings.social_link.pinterest_url') or
									config('settings.social_link.instagram_url')
									)
									<div class="col-sm-12 col-xs-6 col-xxs-12 no-padding-lg">
										<div class="{!! $footerSocialClass !!}">
											<h4 class="footer-title {!! $footerSocialTitleClass !!}">{{ t('Follow us on') }}</h4>
											<ul class="list-unstyled list-inline footer-nav social-list-footer social-list-color footer-nav-inline">
												@if (config('settings.social_link.facebook_page_url'))
												<li>
													<a class="icon-color fb" title="" data-placement="top" data-toggle="tooltip" href="{{ config('settings.social_link.facebook_page_url') }}" data-original-title="Facebook">
														<i class="fab fa-facebook"></i>
													</a>
												</li>
												@endif
												@if (config('settings.social_link.twitter_url'))
												<li>
													<a class="icon-color tw" title="" data-placement="top" data-toggle="tooltip" href="{{ config('settings.social_link.twitter_url') }}" data-original-title="Twitter">
														<i class="fab fa-twitter"></i>
													</a>
												</li>
												@endif
												@if (config('settings.social_link.instagram_url'))
													<li>
														<a class="icon-color pin" title="" data-placement="top" data-toggle="tooltip" href="{{ config('settings.social_link.instagram_url') }}" data-original-title="Instagram">
															<i class="icon-instagram-filled"></i>
														</a>
													</li>
												@endif
												@if (config('settings.social_link.google_plus_url'))
												<li>
													<a class="icon-color gp" title="" data-placement="top" data-toggle="tooltip" href="{{ config('settings.social_link.google_plus_url') }}" data-original-title="Google+">
														<i class="fab fa-google-plus"></i>
													</a>
												</li>
												@endif
												@if (config('settings.social_link.linkedin_url'))
												<li>
													<a class="icon-color lin" title="" data-placement="top" data-toggle="tooltip" href="{{ config('settings.social_link.linkedin_url') }}" data-original-title="LinkedIn">
														<i class="fab fa-linkedin"></i>
													</a>
												</li>
												@endif
												@if (config('settings.social_link.pinterest_url'))
												<li>
													<a class="icon-color pin" title="" data-placement="top" data-toggle="tooltip" href="{{ config('settings.social_link.pinterest_url') }}" data-original-title="Pinterest">
														<i class="fab fa-pinterest-p"></i>
													</a>
												</li>
												@endif
											</ul>
										</div>
									</div>
								@endif
							</div>
						</div>
					@endif

					<div style="clear: both"></div>
				@endif

				<div class="col-xl-12">
					@if (!config('settings.footer.hide_payment_plugins_logos') and isset($paymentMethods) and $paymentMethods->count() > 0)
						<div class="text-center paymanet-method-logo">
							{{-- Payment Plugins --}}
							@foreach($paymentMethods as $paymentMethod)
								@if (file_exists(plugin_path($paymentMethod->name, 'public/images/payment.png')))
									<img src="{{ url('images/' . $paymentMethod->name . '/payment.png') }}" alt="{{ $paymentMethod->display_name }}" title="{{ $paymentMethod->display_name }}">
								@endif
							@endforeach
						</div>
					@else
						@if (!config('settings.footer.hide_links'))
							<hr>
						@endif
					@endif

					<div class="copy-info text-center">
						© {{ date('Y') }} {{ config('settings.app.app_name') }}. {{ t('all_rights_reserved') }}.
						@if (!config('settings.footer.hide_powered_by'))
							@if (config('settings.footer.powered_by_info'))
								{{ t('Powered by') }} {!! config('settings.footer.powered_by_info') !!}
							@else
								{{ t('Powered by') }} <a href="https://bedigit.com" title="BedigitCom">Bedigit</a>.
							@endif
						@endif
					</div>
				</div>

			</div>
		</div>
	</div>
</footer> -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(function () {
        /*pages outer container*/
        // $('.main-container > .container').addClass('container-fluid').removeClass('container');
        /*pages outer container*/
		if($('body div').hasClass('faq-pg-content') || $('body div').hasClass('about-us-page')) {
			$('.inner-box').css({"background": "none", "border": "none"});	
			$('.page-content > h3, .title-1, hr.center-block').css({"display": "none"});
		}
    });
</script>