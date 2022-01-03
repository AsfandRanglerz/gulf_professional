<?php
// Search parameters
$queryString = (request()->getQueryString() ? ('?' . request()->getQueryString()) : '');

// Check if the Multi-Countries selection is enabled
$multiCountriesIsEnabled = false;
$multiCountriesLabel = '';

// Logo Label
$logoLabel = '';
if (request()->segment(1) != 'countries') {
	if (isset($multiCountriesIsEnabled) and $multiCountriesIsEnabled) {
		$logoLabel = config('settings.app.app_name') . ((!empty(config('country.name'))) ? ' ' . config('country.name') : '');
	}
}
?>
<style>
	/*home page outer*/
	.owl-theme .owl-dots .owl-dot span {
		width: 8px;
		height: 8px;
	}

	.owl-theme .owl-dots .owl-dot.active span, .owl-theme .owl-dots .owl-dot:hover span {
		background: #ff7e19;
	}

	.owl-theme .owl-dots .owl-dot:focus {
		outline: none;
	}

	.featured-list-slider .item .item-name {
		background-color: #0b76a8;
		padding: 3px;
		min-height: unset;
		font-size: 14px;
		color: #FFF;
		overflow: hidden;
		display: -webkit-box;
		-webkit-box-orient: vertical;
		-webkit-line-clamp: 1;
		white-space: break-spaces;
	}

	.featured-list-slider .item .price {
		color: #7a7373;
	}

	.select2-dropdown {
		z-index: 1;
	}

	.make-grid .item-list .cornerRibbons {
		left: -75px;
		top: 15px;
	}

	span.detail-line-label,
	span.detail-line-value {
		font-size: 15px;
	}

	span.item-location a {
		font-size: 14px;
	}

	small, .small {
		font-size: 100%;
	}

	label[for="pictures"] {
		font-size: 14px;
	}

	.sidebar-card .list-check li {
		font-size: 14px;
	}

	.blue-text {
		color: #0b76a8;
	}

	#loginForm .card-footer {
		font-size: 15px;
	}

	.nav-pills>li.active>a  {
		border-color: #096791;
		background-color: #096791;
	}

	.nav-pills>li.active>a:hover,
	.nav-pills>li.active>a:focus {
		border-color: #118cca;
		background-color: #118cca!important;
	}

	.alert {
		margin-bottom: 16px;
	}

	.promo-text-box .paragraph, p {
		font-size: 15px;
	}

	.badge-danger {
		background: #00b050;
	}

	a.disabled {
		pointer-events: none;
		cursor: default;
	}

	#stepWizard ul.nav-wizard li a {
		color: #00b050;
	}

	#stepWizard ul.nav-wizard li:after {
		border-left: 16px solid #f5f5f5;
	}

	#stepWizard ul.nav-wizard .active ~ li,
	#stepWizard ul.nav-wizard {
		background: #f5f5f5;
		border-color: #00b050;
	}

	#stepWizard ul.nav-wizard li.active {
		background: #00b050;
	}

	#stepWizard ul.nav-wizard li.active:after {
		border-left: 16px solid #00b050;
	}

	#stepWizard ul.nav-wizard .active ~ li:after {
		border-left: 16px solid #f5f5f5;
	}

	#stepWizard ul.nav-wizard li:before {
		border-left: 16px solid #00b050;
	}

	#stepWizard ul.nav-wizard li.active a,
	#stepWizard ul.nav-wizard li.active a:active,
	#stepWizard ul.nav-wizard li.active a:visited,
	#stepWizard ul.nav-wizard li.active a:focus {
		color: #FFF;
		background: unset;
	}

	#stepWizard ul.nav-wizard .active ~ li a,
	#stepWizard ul.nav-wizard .active ~ li a:active,
	#stepWizard ul.nav-wizard .active ~ li a:visited,
	#stepWizard ul.nav-wizard .active ~ li a:focus {
		color: #00b050;
	}

	.sidebar-card .card-header {
		background: #ff7e19!important;
		color: #FFF;
		text-align: center;
	}

	.border-color-primary {
		border-color: #ff7e19!important;
	}

	.icon-picture, .icon-pencil-circled, .icon-heart-2 {
		color: #ff7e19;
	}

	.page-content .inner-box .title-2 {
		padding: 8px;
		font-size: 21px;
	}

	.modal-header {
		border-bottom: solid 1px #096791;
		background: #096791;
		border-top: solid 1px #096791;
	}

	.modal-header button.close {
		color: #FFF;
		text-shadow: 2px 0 6px #00000063;
		opacity: 1;
		transition: .3s ease;
		outline: none;
	}

	.modal-header .modal-title {
		color: #FFF;
	}

	.modal-header button.close:hover {
		color: #ff7c19!important;
	}

	.info-row,
	a.info-link {
		color: #7a7373;

	}

	.items-details h1, .items-details h2, .items-details h3, .items-details h4, .items-details h5, .items-details h6,
	.detail-line-lite div span, .promo-text-box h3,
	.detail-line div span:first-child, .detail-line-lite div span:first-child {
		color: #0b76a8;
	}

	.items-details .add-title a,
	.company-name {
		text-overflow: ellipsis;
		overflow: hidden;
		display: -webkit-box;
		-webkit-box-orient: vertical;
		-webkit-line-clamp: 1;
	}

	.post-promo h2 {
		color: #0b76a8;
		font-weight: 500;
		padding-bottom: 8px;
	}

	.post-promo h5 {
		font-size: 13px;
		padding-bottom: 8px;
	}

	.promo-text-box h3 {
		margin-top: 8px;
		padding-bottom: 4px;
	}

	.page-content .inner-box > h2,
	.content-subheading {
		background: #0b76a8;
		color: #FFF;
		padding: 8px;
	}

	.page-content .inner-box h2 {
		margin: 0px;
	}

	.page-content .inner-box h2 a {
		color: #FFF;
	}

	.page-content .inner-box h2 a:hover,
	.page-content .inner-box h2 a:focus {
		color: #ff8c00;
	}

	.pricetag {
		background: #096791;
	}

	.pricetag:before {
		border-top: 10px solid #096791;
	}

	.btn-add-listing {
		line-height: 12px!important;
	}

	#homepage a.btn-add-listing, a.btn-add-listing, button.btn-add-listing, li.postadd.nav-item>a.btn-add-listing {
		color: #FFF!important;
		background-image: unset!important;
		background-color: #ff7e19!important;
		border-color: #ff7e19!important;
	}

	#homepage a.btn-add-listing:hover,
	a.btn-add-listing:hover,
	button.btn-add-listing:hover,
	li.postadd.nav-item>a.btn-add-listing:hover,
	#homepage a.btn-add-listing:focus,
	a.btn-add-listing:focus,
	button.btn-add-listing:focus,
	li.postadd.nav-item>a.btn-add-listing:focus {
		color: #FFF!important;
		background-color: #f57008!important;
		border-color: #f57008!important;
	}

	.btn-grey {
		background-color: #f5f5f5;
	}

	.btn-grey:hover,
	.btn-grey:focus {
		background-color: #efe0e0;
	}

	.btn-default {
		color: #FFF!important;
		background-color: #ff7e19;
		border-color: #ff7e19;
	}

	.btn-default:hover,
	.btn-default:focus {
		background-color: #f57008;
		border-color: #f57008;
		box-shadow: unset;
	}

	.btn-danger,
	.btn-success,
	.btn-primary,
	.tags a {
		color: #fff;
		background-color: #00b050;
		border-color: #00b050;
	}

	.btn-danger:hover,
	.btn-danger:focus,
	.btn-success:hover,
	.btn-success:focus,
	.btn-primary:hover,
	.btn-primary:focus,
	.tags a:hover,
	.tags a:focus {
		background-color: #039746;
		border-color: #039746;
		box-shadow: unset;
	}

	.btn-warning,
	.btn-secondary {
		color: #FFF!important;
		border-color: #096791;
		background-color: #096791;
	}

	.btn-warning:hover,
	.btn-warning:focus,
	.btn-secondary:hover,
	.btn-secondary:focus {
		color: #FFF;
		border-color: #118cca;
		background-color: #118cca;
		box-shadow: unset;
	}

	.btn-default.active, .btn-default.active:focus, .btn-default:active, .btn-default:active:focus, .show>.btn-default.dropdown-toggle {
		background-color: #f57008!important;
		border-color: #f57008!important;
	}

	.btn-primary.active, .btn-primary.active:focus, .btn-primary:active, .btn-primary:active:focus, .show>.btn-primary.dropdown-toggle {
		background-color: #00b050!important;
		border-color: #00b050!important;
	}

	.btn-secondary.active, .btn-secondary.active:focus, .btn-secondary:active, .btn-secondary:active:focus, .show>.btn-secondary.dropdown-toggle,
	.btn-warning.active, .btn-warning.active:focus, .btn-warning:active, .btn-warning:active:focus, .show>.btn-warning.dropdown-toggle {
		background-color: #096791!important;
		border-color: #096791!important;
	}

	.items-details h5 {
		background-color: #0b76a8;
		margin-bottom: 8px;
	}

	.items-details h1 > a , .items-details h2 > a , .items-details h3 > a ,
	.items-details h4 > a , .items-details h5 > a , .items-details h6 > a {
		color: #FFF;
	}

	.box-title {
		background-color: #00b050;
		color: #FFF;
	}

	.box-title h2 {
		display: flex;
		justify-content: space-between;
		align-items: center;
		margin: 6px 0;
	}

	.box-title .sell-your-item {
		padding: 0;
		position: unset;
	}

	.box-title h2 span {
		text-transform: uppercase!important;
		font-size: 18px!important;
		font-weight: bold;
	}

	.sell-your-item {
		color: #FFF;
	}

	.h-spacer:first-child {
		padding-top: 10px;
	}

	.container-fluid {
		padding: 0 29px!important;
	}

	.icon-color.lin {
		background: #0e8ac4;
	}

	.footer-content {
		background: #0b76a8 !important;
	}

	.copy-info,
	.copy-info > a,
	.footer-title,
	.footer-nav li a {
		color: #FFF;
	}

	.copy-info > a:hover {
		color: #ff8c00;
	}
	/*home page outer*/

	.company-name {
		font-weight: 500;
	}

	.company-name-icon {
		margin: 0 3px;
	}

	.text-dots-four-line {
		overflow: hidden;
		display: -webkit-box;
		-webkit-box-orient: vertical;
		-webkit-line-clamp: 4;
		white-space: break-spaces;
	}

	.text-dots-one-line {
		overflow: hidden;
		display: -webkit-box;
		-webkit-box-orient: vertical;
		-webkit-line-clamp: 1;
		white-space: break-spaces;
	}

	.overflow-text-dots {
		overflow: hidden;
		text-overflow: ellipsis;
		-webkit-box-orient: vertical;
		-webkit-line-clamp: 2;
		height: 40px;
	}

	.overflow-hidden {
		overflow: hidden;
	}

	.line-height-one {
		line-height: 1;
	}

	.header {
		font-family: Arial;
		position: sticky;
		top: 0;
		z-index: 555;
	}

	.header-upper-section {
		width: 95.7%;
		margin: 0 auto;
	}

	.header .select2-container--default .select2-selection--single,
	.header .form-control {
		border-radius: 0;
		box-shadow: none;
		border: 0;
	}

	.header .category-search-outer {
		display: grid;
		grid-template-columns: 29% 29% 29% 13%;
	}

	.header .category-search-outer .category-search-inner:nth-child(2) {
		border-left: 1px solid #f1c4c4;
		border-right: 1px solid #f1c4c4;
	}

	.header .dropdown-nav {
		background: #0b76a8;
		border: none;
		outline: none;
		padding: 4px;
	}

	.header .dropdown-nav .fa-angle-down {
		font-size: 20px!important;
	}

	.header .mobile-search {
		display: none!important;
	}


	.dropdown-nav {
		display: none;
		width: 100%;
		cursor: pointer;
		color: #FFF;
		font-size: 24px;
		line-height: 1;
		padding: 8px 0;
		transition: .5s ease;
	}

	.dropdown-nav-icon {
		transform: rotate(
				180deg
		);
	}

	input, select {
		text-overflow: ellipsis;
		overflow: hidden;
		white-space: nowrap;
	}

	.nav-and-search-container .navbar-nav>li:not(:first-child) {
		padding: 0 30px;
	}

	.orange-btn {
		transition: 1s ease;
		text-shadow: 0px 2px 6px #0000007d;
		color: #FFF!important;
		background: #ff7e19;
		font-weight: 500;
		border-radius: 0;
	}

	.orange-btn:hover, .orange-btn:focus {
		background: #f57008;
	}

	.header .search-row .icon-append {
		top: 0;
		font-size: 20px;
		height: 100%;
		display: flex;
		align-items: center;
	}

	.header .select2-container--open .select2-dropdown--below {
		z-index: 55555;
	}

	.header .search-row .search-col .form-control,
	.header .search-row button.btn-search,
	.header .search-row-wrapper .form-control,
	.header .search-row-wrapper button.btn {
		height: 100%;
		font-size: 14px;
		border-radius: 0!important;
	}

	.header .navbar-left {
		padding: 4px 14px;
	}

	#wrapper {
		padding-top: 0;
	}

	.header-upper {
		padding: 10px 0 5px 0;
		margin: 0 !important;
	}

	.upper-links-main {
		display: flex;
		flex-direction: column;
		margin-left: 15px;
		align-items: center;
	}

	.header-upper-inner1 {
		display: flex;
	}

	.header-upper-inner2 {
		display: flex;
		flex-direction: column;
		align-items: flex-end;
	}

	.image {
		display: flex;
		align-items: center;
		border-right: 2px solid #a09c9c61;
	}

	.image img {
		height: 75px;
		width: 190px;
		padding-right: 15px;
	}

	.expo-txt {
		color: #ff7e19;
		font-weight: 700;
		font-size: 35px;
		margin-bottom: 0;
		line-height: 1;
	}

	.middle-txt {
		clear: left;
		padding: 15px 18px 0 15px;
		margin-bottom: 0;
		color: #a09c9c;
		font-weight: bold;
		font-size: 15px;
	}

	.navbar-left {
		width: 100%;
		display: flex;
		justify-content: space-between;
		align-items: center;
		padding: 1px 30px 1px 15px;
	}

	.nav-and-search-container .searchs form {
		display: flex;
		justify-content: flex-end;
	}

	.main-nav {
		display: flex;
		flex-direction: row;
		margin-bottom: 6px !important;
	}

	.main-nav>li>a {
		color: #0b76a8 !important;
		font-size: 18px !important;
		padding: 0 16px !important;
	}

	.main-nav>li {
		display: flex !important;
		justify-content: center;
		position: relative;
	}

	.main-nav>li:before {
		content: "";
		position: absolute;
		bottom: -5px;
		width: 15%;
		border-bottom: 1px solid #a09c9c;
	}

	.upper-links {
		display: flex;
		padding-left: 0;
		margin-bottom: 18px;
	}

	.upper-links .fa:not(.icon-down-open-big) {
		color: #0b76a8;
	}

	.upper-links .fa-icons {
		color: #0b76a8;
		margin-right: 3px;
	}

	.upper-links .link,
	.upper-links .link a {
		color: #a09c9c;
		font-size: 13px;
	}

	.main-nav>li.online-expo {
		border-left: 4px solid #0b76a8ab;
	}

	.main-nav>li.lab-news {
		border-left: 4px solid #ff7e19;
	}

	.main-nav>li.classified {
		border-left: 4px solid #00b050;
	}

	.main-nav>li.ask-advice {
		border-left: 4px solid #ed786f;
	}

	.navbar-brand,
	.navbar-nav>li>a {
		color: white;
	}

	.header .navbar {
		padding: 0 30px;
	}

	.navbar {
		border-radius: 0px !important;
		margin-bottom: 0px !important;
		border: 0px !important;

	}

	.navbar-nav>li>a {
		margin-top: 5px !important;
		padding-bottom: 5px !important;
		line-height: 15px !important;
		font-weight: bold;
	}

	.menubar-nav .navbar-nav>li>a {
		font-size: 15px;
		text-shadow: 0px 2px 6px #0000007d;
	}

	.nav>li>a:focus,
	.nav>li>a:hover {
		background: rgba(255, 255, 255, 0) !important;
	}

	.navbar-nav>li>a {
		padding-top: 8px;
		padding-bottom: 10px;
	}

	.header span.select2.select2-container.select2-container--default {
		height: 100%!important;
	}

	.header .select2-container--default .select2-selection--single {
		height: 100%!important;
	}

	.header .select2-container--default .select2-selection--single .select2-selection__rendered {
		line-height: unset;
		height: 100%;
		position: relative;
		top: 4px;
	}

	@media (min-width: 1200px) {
		.header .search-row {
			min-width: 775px;
		}
	}

	@media (max-width: 1199px) {
		.header .select2-container--default .select2-selection--single,
		.header .form-control,
		.header .search-row .search-col .form-control,
		.header .search-row button.btn-search,
		.header .search-row-wrapper .form-control,
		.header .search-row-wrapper button.btn,
		.orange-btn {
			font-size: 12px;
		}

		.upper-links .link,
		.upper-links .link a {
			color: #a09c9c;
			font-size: 11px;
		}

		.image img {
			height: 55px;
			width: 145px;
		}

		.nav-and-search-container .navbar-nav>li>a {
			font-size: 13px;
		}

		.expo-txt {
			font-size: 26px;
			text-align: center;
		}

		.main-nav>li>a {
			font-size: 14px !important;
		}

		.middle-txt {
			font-size: 12px;
			padding: 8px 5px 0 15px;
		}
	}

	@media (min-width: 992px) {
		.header .navbar-left .menubar-nav {
			display: flex;
			align-items: center;
		}
	}

	@media (max-width: 991px) {
		/*home page outer*/
		.container-fluid {
			padding: 0 15px!important;
		}
		/*home page outer*/

		.list-prof-btns {
			width: 145px;
		}

		.expo-txt {
			font-size: 24px;
		}

		.navbar-left {
			flex-direction: column;
			padding: 0 0 12px 0;
		}

		.header-upper {
			flex-direction: column;
		}

		.header-upper {
			display: flex;
			align-items: center;
		}

		.header-upper-inner1 {
			align-items: center;
			justify-content: center;
			margin-bottom: 10px;
		}

		.header-upper-inner2 {
			align-items: center;
		}

		.image {
			padding-bottom: 0;
		}

		.middle-txt {
			padding: 8px 5px 0 0;
		}

		.header .navbar-left {
			padding: 8px 0!important;
		}

		.header .navbar-left .navbar-nav {
			justify-content: center;
			column-gap: 8px;
			margin-bottom: 4px;
		}
	}

	@media (max-width: 767px) {
		.header .search-row {
			border: 1px solid #f1c4c4;
			padding: 2px;
		}

		.header .search-row .search-col .form-control.locinput {
			border: none;
			border-bottom: none!important;
		}

		.header .mobile-search {
			display: block!important;
		}

		.header .nav-and-search-container .navbar {
			padding: 0;
		}

		.header .search-row {
			display: none;
		}

		.header .navbar-left .navbar-nav {
			align-items: center;
		}

		.dropdown-nav .fa-angle-down {
			font-size: 24px!important;
		}

		.navbar-left {
			flex-direction: column;
			padding: 0!important;
		}

		.nav-and-search-container {
			margin-top: 8px;
		}

		.main-nav + .middle-txt {
			display: none;
		}

		.dropdown-nav {
			display: unset!important;
		}

		.dropdown-nav + .navbar-collapse {
			padding: 0px !important;
			border-top: 1px solid #FFF;
		}

		.main-nav>li.online-expo {
			border-left: 3px solid #0b76a8ab;
		}

		.main-nav>li.lab-news {
			border-left: 3px solid #ff7e19;
		}

		.main-nav>li.classified {
			border-left: 3px solid #00b050;
		}

		.main-nav>li.ask-advice {
			border-left: 3px solid #ed786f;
		}

		.main-nav>li>a {
			margin-top: 0!important;
			padding: 0 8px !important;
		}
	}

	@media (max-width: 575px) {
		/*home page outer*/
		.promo-text-box .paragraph, p, #loginForm .card-footer {
			font-size: 13px;
		}
		/*home page outer*/

		.header .search-row {
			width: 100%;
		}

		.header .category-search-outer {
			grid-template-columns: 25% 25% 25% 25%;
		}

		.list-prof-btns {
			width: 135px;
		}

		.header .search-row .search-col .form-control,
		.header .search-row button.btn-search,
		.header .search-row-wrapper .form-control,
		.header .search-row-wrapper button.btn,
		.orange-btn {
			font-size: 11px!important;
		}

		.orange-btn {
			font-size: 11px;
		}

		.header .header-upper {
			padding-left: 0!important;
			padding-right: 0!important;
		}

		.image img {
			height: 45px;
			width: 120px;
		}

		.expo-txt {
			font-size: 20px;
		}

		.main-nav>li.online-expo {
			border-left: 2px solid #0b76a8ab;
		}

		.main-nav>li.lab-news {
			border-left: 2px solid #ff7e19;
		}

		.main-nav>li.classified {
			border-left: 2px solid #00b050;
		}

		.main-nav>li.ask-advice {
			border-left: 2px solid #ed786f;
		}

		.main-nav>li>a {
			font-size: 12px!important;
			padding: 0 6px!important;
		}

		.main-nav>li:before {
			display: none;
		}

		.header-upper {
			padding-bottom: 0;
		}

		.upper-links-main {
			align-items: center;
		}

		.middle-txt {
			padding: 15px 0;
		}
	}

	@media (max-width: 370px) {
		.header-upper .main-nav>li>a {
			font-size: 11px!important;
		}

		.upper-links .link, .upper-links .link a {
			font-size: 10px!important;
		}
	}
</style>

<div class="header">
	<div class="bg-white" style="box-shadow: 0 0 10px rgb(0 0 0 / 10%)">
		<div class="header-upper-section">
			<div class="row header-upper">
				<div class="col-lg-6 col-md-12 header-upper-inner1 px-0">
					<div class="mb-0 image">
						<a href="{{ url('/') }}"><img src="https://gulflabexpo.com/public/img/gulf-new-header.png"></a>
					</div>
					<div class="upper-links-main">
						<ul class="upper-links">
							<li class="link">
								<span class="fa fa-envelope fa-icons" aria-hidden="true"></span>
								<a href="{{url('contact')}}">Contact Us</a>
							</li>
							@if (!auth()->check())
								<li class="link" style="margin-left: 10px">
									@if (config('settings.security.login_open_in_modal'))
										<span class="icon-user fa fa-icons"></span><a href="#quickLogin" data-toggle="modal">{{ t('log_in') }}</a>
									@else
										<span class="icon-user fa fa-icons"></span><a href="{{ \App\Helpers\UrlGen::login() }}">{{ t('log_in') }}</a>
									@endif
								</li>
								<li class="link hidden-sm" style="margin-left: 10px">
									<span class="icon-user-add fa fa-icons"></span><a href="{{ \App\Helpers\UrlGen::register() }}">{{ t('register') }}</a>
								</li>
							@else
								<li class="link hidden-sm" style="margin-left: 10px">
									@if (app('impersonate')->isImpersonating())
										<span class="fa icon-logout hidden-sm"></span><a href="{{ route('impersonate.leave') }}">{{ t('Leave') }}</a>
									@else
										<span class="fa icon-logout hidden-sm"></span><a href="{{ \App\Helpers\UrlGen::logout() }}">{{ t('log_out') }}</a>
									@endif
								</li>
								<li class="link dropdown no-arrow" style="margin-left: 10px">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown">
										<span class="icon-user fa hidden-sm"></span>
										<span>{{ auth()->user()->name }}</span>
										<span class="badge badge-pill badge-important count-threads-with-new-messages hidden-sm">0</span>
										<span class="icon-down-open-big fa"></span>
									</a>
									<ul id="userMenuDropdown" class="dropdown-menu user-menu dropdown-menu-right shadow-sm">
										<li class="dropdown-item active">
											<a href="{{ url('account') }}">
												<span class="icon-home"></span> {{ t('Personal Home') }}
											</a>
										</li>
										<li class="dropdown-item"><a href="{{ url('account/my-posts') }}"><span class="icon-th-thumb"></span> {{ t('my_ads') }} </a></li>
										<li class="dropdown-item"><a href="{{ url('account/favourite') }}"><span class="icon-heart"></span> {{ t('favourite_ads') }} </a></li>
										<li class="dropdown-item"><a href="{{ url('account/saved-search') }}"><span class="icon-star-circled"></span> {{ t('Saved searches') }} </a></li>
										<li class="dropdown-item"><a href="{{ url('account/pending-approval') }}"><span class="icon-hourglass"></span> {{ t('pending_approval') }} </a></li>
										<li class="dropdown-item"><a href="{{ url('account/archived') }}"><span class="icon-folder-close"></span> {{ t('archived_ads') }}</a></li>
										<li class="dropdown-item">
											<a href="{{ url('account/messages') }}">
												<i class="icon-mail-1"></i> {{ t('messenger') }}
												<span class="badge badge-pill badge-important count-threads-with-new-messages">0</span>
											</a>
										</li>
										<li class="dropdown-item"><a href="{{ url('account/transactions') }}"><span class="icon-money"></span> {{ t('Transactions') }}</a></li>
										<li class="dropdown-divider"></li>
										<li class="dropdown-item">
											@if (app('impersonate')->isImpersonating())
												<a href="{{ route('impersonate.leave') }}"><span class="icon-logout"></span> {{ t('Leave') }}</a>
											@else
												<a href="{{ \App\Helpers\UrlGen::logout() }}"><span class="icon-logout"></span> {{ t('log_out') }}</a>
											@endif
										</li>
									</ul>
								</li>
							@endif
							@if (request()->segment(1) != 'countries')
								@if (config('settings.geo_location.country_flag_activation'))
									@if (!empty(config('country.icode')))
										@if (file_exists(public_path() . '/images/flags/32/' . config('country.icode') . '.png'))
											{{--                                        <li class="flag-menu country-flag tooltipHere hidden-xs nav-item" data-toggle="tooltip" data-placement="{{ (config('lang.direction') == 'rtl') ? 'bottom' : 'right' }}" {!! $multiCountriesLabel !!}>--}}
											<li class="flag-menu country-flag tooltipHere hidden-xs nav-item" data-toggle="tooltip" data-placement="{{ (config('lang.direction') == 'rtl') ? 'bottom' : 'right' }}">
												@if (isset($multiCountriesIsEnabled) and $multiCountriesIsEnabled)
													{{--                                                <a href="#selectCountry" data-toggle="modal" class="p-0 ml-3 line-height-one nav-link">--}}
													<a href="#selectCountry" data-toggle="modal" class="p-0 ml-3 line-height-one nav-link">
														<img class="flag-icon"
															 src="{{ url('images/flags/32/' . config('country.icode') . '.png') . getPictureVersion() }}"
															 alt="{{ config('country.name') }}"
														>
														<span class="caret hidden-sm"></span>
														{{--                                                    <span class="caret hidden-sm"></span>--}}
													</a>
												@else
													<a style="cursor: default;">
														<img class="flag-icon no-caret"
															 src="{{ url('images/flags/32/' . config('country.icode') . '.png') . getPictureVersion() }}"
															 alt="{{ config('country.name') }}"
														>
													</a>
												@endif
											</li>
										@endif
									@endif
								@endif
							@endif
						</ul>
						<p class="expo-txt">PROFESSIONALS</p>
					</div>
				</div>
				<div class="col-lg-6 col-md-12 header-upper-inner2 px-0">
					<ul class="nav navbar-nav main-nav">
                        <li class="online-expo"><a href="https://gulflabexpo.com/online/expo">Online Exhibition</a></li>
                        <li class="lab-news"><a href="https://professionals.gulflabexpo.com">Networking</a></li>
                        <li class="classified active"><a href="http://classifieds.gulflabexpo.com">Classifieds</a></li>
                        <li class="ask-advice"><a href="https://gulflabexpo.com/news">Industry News</a></li>
                    </ul>
                    <p class="middle-txt">Online Expo for Clinical Lab Equipment, Products and Services for MENA Region</p>

					<div class="w-100 nav-and-search-container">
						<div class="search-row mobile-search">
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="bordr nav-and-search-container">
			<nav class="py-0 navbar navbar-expand-md" style="background-color:#0b76a8 !important">
				<button data-toggle="collapse" data-target="#navbarText" class="dropdown-nav"><span class="fa fa-angle-down"></span></button>
				<div class="collapse navbar-collapse" id="navbarText">
					<div class="navbar-left px-0">

						<div class="menubar-nav">
							<ul class="nav navbar-nav hov">
								<li class="coll"><a class="botom-navabr" href="{{ url('/') }}">Home</a></li>
								<li class="coll"><a class="botom-navabr" href="#">About Us</a></li>
							</ul>
						</div>
						<div class="mx-0 search-row">
						</div>
						<div class="mt-lg-0 mt-md-2 d-flex align-items-center">
							<!-- <a class="mr-1 postadd btn orange-btn list-prof-btns" href="#quickLogin" data-toggle="modal">
                                <span class="fa fa-plus-circle mr-2"></span> Add Listing
                            </a> -->
							<div class="d-inline-block menubar-nav mr-3">
								<ul class="nav navbar-nav hov">
									<li class="coll mr-3"><a class="botom-navabr" href="#">FAQs</a></li>
								</ul>
							</div>

							@if(auth()->user())
								<a class="postadd btn orange-btn list-prof-btns" href="{{ url('create-1') }}"{{ url('create-1') }}>
									<span class="fa fa-plus-circle mr-2"></span> {{ ('Post an Ad') }}
								</a>
							@else
								<a class="postadd btn orange-btn list-prof-btns" href="{{ url('login') }}"{{ url('create-1') }}>
									<span class="fa fa-plus-circle mr-2"></span> {{ ('Post an Ad') }}
								</a>
							@endif
							<!-- <a class="btn orange-btn list-prof-btns"><span class="fa fa-plus-circle mr-2"></span>Create an Ad</a> -->
						</div>
					</div>
				</div>
			</nav>
		</div>
		<div class="row bordr" style="border:3px solid #ff8533;background: #ff8533;margin: 0"></div>
	</div>
</div>
{{-- Header backup till the date of 12/13/2021 --}}
<!-- <div class="header">
	<nav class="navbar fixed-top navbar-site navbar-light bg-light navbar-expand-md" role="navigation">
        <div class="container-fluid">

			<div class="navbar-identity">
				{{-- Logo --}}
				<a href="{{ url('/') }}" class="navbar-brand logo logo-title">
					<img src="{{ imgUrl(config('settings.app.logo', config('larapen.core.logo')), 'logo') }}" class="tooltipHere main-logo" />
				</a>
				{{-- Toggle Nav (Mobile) --}}
				<button data-target=".navbar-collapse" data-toggle="collapse" class="navbar-toggler pull-right" type="button">
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30" width="30" height="30" focusable="false">
						<title>{{ t('Menu') }}</title>
						<path stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-miterlimit="10" d="M4 7h22M4 15h22M4 23h22"></path>
					</svg>
				</button>
				{{-- Country Flag (Mobile) --}}
				@if (request()->segment(1) != 'countries')
					@if (isset($multiCountriesIsEnabled) and $multiCountriesIsEnabled)
						@if (!empty(config('country.icode')))
							@if (file_exists(public_path() . '/images/flags/24/' . config('country.icode') . '.png'))
								<button class="flag-menu country-flag d-block d-md-none btn btn-secondary hidden pull-right" href="#selectCountry" data-toggle="modal">
									<img src="{{ url('images/flags/24/'.config('country.icode').'.png') . getPictureVersion() }}"
										 alt="{{ config('country.name') }}"
										 style="float: left;"
									>
									<span class="caret hidden-xs"></span>
								</button>
							@endif
						@endif
					@endif
				@endif
            </div>

			<div class="navbar-collapse collapse">
				<ul class="nav navbar-nav navbar-left">
					{{-- Country Flag --}}
					@if (request()->segment(1) != 'countries')
						@if (config('settings.geo_location.country_flag_activation'))
							@if (!empty(config('country.icode')))
								@if (file_exists(public_path() . '/images/flags/32/' . config('country.icode') . '.png'))
									<li class="flag-menu country-flag tooltipHere hidden-xs nav-item" data-toggle="tooltip" data-placement="{{ (config('lang.direction') == 'rtl') ? 'bottom' : 'right' }}">
										@if (isset($multiCountriesIsEnabled) and $multiCountriesIsEnabled)
											<a href="#selectCountry" data-toggle="modal" class="nav-link">
												<img class="flag-icon"
													 src="{{ url('images/flags/32/' . config('country.icode') . '.png') . getPictureVersion() }}"
													 alt="{{ config('country.name') }}"
												>
												<span class="caret hidden-sm"></span>
											</a>
										@else
											<a style="cursor: default;">
												<img class="flag-icon no-caret"
													 src="{{ url('images/flags/32/' . config('country.icode') . '.png') . getPictureVersion() }}"
													 alt="{{ config('country.name') }}"
												>
											</a>
										@endif
									</li>
								@endif
							@endif
						@endif
					@endif
				</ul>

				<ul class="nav navbar-nav ml-auto navbar-right">
                    @if (!auth()->check())
                        <li class="nav-item">
							<a href="{{ \App\Helpers\UrlGen::login() }}" class="nav-link">
								<i class="icon-user fa"></i> {{ t('log_in') }}
							</a>
						</li>
                        <li class="nav-item">
							<a href="{{ \App\Helpers\UrlGen::login() }}" class="nav-link">
								<i class="icon-user-add fa"></i> {{ t('register') }}
							</a>
						</li>
                    @else
                        <li class="nav-item">
							@if (app('impersonate')->isImpersonating())
								<a href="{{ route('impersonate.leave') }}" class="nav-link">
									<i class="icon-logout hidden-sm"></i> {{ t('Leave') }}
								</a>
							@else
								<a href="{{ \App\Helpers\UrlGen::logout() }}" class="nav-link">
									<i class="glyphicon glyphicon-off"></i> {{ t('log_out') }}
								</a>
							@endif
						</li>
						<li class="nav-item dropdown no-arrow">
							<a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
								<i class="icon-user fa hidden-sm"></i>
                                <span>{{ auth()->user()->name }}</span>
								<i class="icon-down-open-big fa hidden-sm"></i>
                            </a>
							<ul id="userMenuDropdown" class="dropdown-menu user-menu dropdown-menu-right shadow-sm">
                                <li class="dropdown-item active">
                                    <a href="{{ url('account') }}">
                                        <i class="icon-home"></i> {{ t('Personal Home') }}
                                    </a>
                                </li>
                                <li class="dropdown-item">
									<a href="{{ url('account/my-posts') }}">
										<i class="icon-th-thumb"></i> {{ t('my_ads') }}
									</a>
								</li>
                                <li class="dropdown-item">
									<a href="{{ url('account/favourite') }}">
										<i class="icon-heart"></i> {{ t('favourite_ads') }}
									</a>
								</li>
                                <li class="dropdown-item">
									<a href="{{ url('account/saved-search') }}">
										<i class="icon-star-circled"></i> {{ t('Saved searches') }}
									</a>
								</li>
                                <li class="dropdown-item">
									<a href="{{ url('account/pending-approval') }}">
										<i class="icon-hourglass"></i> {{ t('pending_approval') }}
									</a>
								</li>
                                <li class="dropdown-item">
									<a href="{{ url('account/archived') }}">
										<i class="icon-folder-close"></i> {{ t('archived_ads') }}
									</a>
								</li>
                                <li class="dropdown-item">
									<a href="{{ url('account/messages') }}">
										<i class="icon-mail-1"></i> {{ t('messenger') }}
									</a>
								</li>
                                <li class="dropdown-item">
									<a href="{{ url('account/transactions') }}">
										<i class="icon-money"></i> {{ t('Transactions') }}
									</a>
								</li>
                            </ul>
                        </li>
                    @endif

					<li class="nav-item postadd">
						@if (!auth()->check())
							@if (config('settings.single.guests_can_post_ads') != '1')
								<a class="btn btn-block btn-border btn-post btn-add-listing" href="#quickLogin" data-toggle="modal">
									<i class="fa fa-plus-circle"></i> {{ t('Add Listing') }}
								</a>
							@else
								<a class="btn btn-block btn-border btn-post btn-add-listing" href="{{ \App\Helpers\UrlGen::addPost(true) }}">
									<i class="fa fa-plus-circle"></i> {{ t('Add Listing') }}
								</a>
							@endif
						@else
							<a class="btn btn-block btn-border btn-post btn-add-listing" href="{{ \App\Helpers\UrlGen::addPost(true) }}">
								<i class="fa fa-plus-circle"></i> {{ t('Add Listing') }}
							</a>
						@endif
					</li>

                    @if (!empty(config('lang.abbr')))
                        @if (is_array(getSupportedLanguages()) && count(getSupportedLanguages()) > 1)
							<li class="dropdown lang-menu nav-item">
								<button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown">
									<span class="lang-title">{{ strtoupper(config('app.locale')) }}</span>
                                </button>
								<ul id="langMenuDropdown" class="dropdown-menu dropdown-menu-right user-menu shadow-sm" role="menu">
                                    @foreach(getSupportedLanguages() as $langCode => $lang)
										@continue(strtolower($langCode) == strtolower(config('app.locale')))
										<li class="dropdown-item">
											<a href="{{ url('lang/' . $langCode) }}" tabindex="-1" rel="alternate" hreflang="{{ $langCode }}">
												<span class="lang-name">{{{ $lang['native'] }}}</span>
											</a>
										</li>
                                    @endforeach
                                </ul>
                            </li>
                        @endif
                    @endif
                </ul>
            </div>
        </div>
    </nav>
</div> -->
