<?php
// Search parameters
$queryString = (request()->getQueryString() ? ('?' . request()->getQueryString()) : '');

// Check if the Multi-Countries selection is enabled
$multiCountriesIsEnabled = false;
$multiCountriesLabel = '';
if (config('settings.geo_location.country_flag_activation')) {
	if (!empty(config('country.code'))) {
		if (\App\Models\Country::where('active', 1)->count() > 1) {
			$multiCountriesIsEnabled = true;
			$multiCountriesLabel = 'title="' . t('Select a Country') . '"';
		}
	}
}


// Logo Label
$logoLabel = '';
if (request()->segment(1) != 'countries') {
	if (isset($multiCountriesIsEnabled) and $multiCountriesIsEnabled) {
		$logoLabel = config('settings.app.app_name') . ((!empty(config('country.name'))) ? ' ' . config('country.name') : '');
	}
}
?>
<style>
	 .faq-pg-content .card {
        border: none;
        background: none;
        margin-bottom: 10px;
    }
    
    .faq-pg-content .card-header {
        padding: 0;
        border: none;
        border-radius: 8px;
    }

    .faq-pg-content h5 {
        background-color: #fff;
        border: 2px solid #0b76a8;
        border-radius: 4px;
        color: #444;
        cursor: pointer;
        width: 100%;
        text-align: left;
        outline: none;
        transition: 0.4s;
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0;
    }

    .faq-pg-content .card-body {
        padding: 8px 16px;
        border: 1px solid #ddd;
        margin: 8px 0;
        text-align: justify;
        font-size: 16px;
        font-weight: 300;
    }

    .faq-pg-content button.btn.btn-link.collapsed:after {
        content: "\2795";
        font-size: 13px;
        color: #777;
        float: right;
        margin-left: 5px;
    }

    .faq-pg-content button.btn.btn-link:after {
        content: "\2796";
        font-size: 13px;
        color: #777;
        float: right;
        margin-left: 5px;
    }

    .faq-pg-content button.btn.btn-link {
        color: #000;
        width: 100%;
        text-align: left;
        font-weight: bold;
        font-size: 16px;
        text-decoration: none;
        padding: 12px;
    }

    .faq-pg-content button.btn.btn-link:hover, .faq-pg-content button.btn.btn-link:focus,  .faq-pg-content button.btn.btn-link:active {
        background-color: #eee;
    }

	.category-list.make-grid .item-list .make-favorite.btn-success {
		background: #c89b0555;
		border: none;
		border-radius: 0;
		margin-right: 3px;
	}

	.category-list.make-grid .item-list .make-favorite.btn-default {
		background: unset;
		border: none;
	}

	.save-into-fav {
		position: absolute;
		right: 2px;
		padding-top: 0;
	}

	.category-list.make-grid .item-list {
		height: fit-content!important;
		padding: 4px;
	}

	.post-contact-ask-imgs {
		height: 125px;
	}

	.post-contact-ask-imgs + .heading {
		color: #0b76a8;
		font-weight: bold;
		padding: 8px 0;
	}

	.mena-country-heading {
		background: #0b76a8;
		color: #FFF;
		margin: 0;
		padding: 12px 8px;
		font-size: 20px;
	}

	.photo-count {
		display: none;
	}

	.item-location, .item-location .info-link {
		color: #0b76a8;
	}

	.overflow-hidden-one-line {
		overflow: hidden;
		display: -webkit-box;
		-webkit-box-orient: vertical;
		-webkit-line-clamp: 1;
	}

	.overflow-hidden-two-lines {
		overflow: hidden;
		display: -webkit-box;
		-webkit-box-orient: vertical;
		-webkit-line-clamp: 2;
	}

	.sidebar-header, .sidebar-header * {
		background: #0b76a8!important;
		color: #FFF!important;
	}

	.select2-container {
		z-index: 2;
	}
	
	.select2-container--default .select2-selection--single .select2-selection__rendered,
	.select2-container--default .select2-selection--single .select2-selection__arrow {
		background-color: #FFF;
	}

	.items-details h5 {
		text-align: center;
	}

	.add-image a {
		text-align: center;
		background-image: url(https://professionals.gulflabexpo.com/images/back-profile-img.bmp);
		background-size: 100% 50%;
		background-repeat: no-repeat;
		object-fit: cover;
	}

	.price-box {
		text-align: right!important;
	}

	#homepage .add-image a img {
		width: 185px;
		height: 185px;
		object-fit: cover;
		object-position: top;
		border-radius: 50%;
		margin-top: 15px!important;
	}
	
	.add-image a img {
		width: 155px;
		height: 155px;
		object-fit: cover;
		object-position: top;
		border-radius: 50%;
		margin-top: 15px!important;
	}

	#homepage .f-category img {
		height: 85px;
	}

	#homepage .box-title .sell-your-item {
		display: none;
	}

	.page-sidebar .inner-box {
		background: #f5f5f5;
	}

	.page-sidebar .inner-box .collapse-title {
		color: #0b76a8;
		font-weight: bold;
	}

	.user-panel-sidebar ul li a.active, .user-panel-sidebar ul li a:hover {
    	background-color: #0b76a8;
	}

	.user-panel-sidebar ul li a {
		color: #4e575d;
	}

	.card-header {
		background: #0b76a8;
	}

	.collapse-box .badge {
		background-color: #ff7e19;
		color: #fff;
	}

	.card .card-header .card-title a {
		color: #FFF;
	}

	.sidebar-modern-inner * {
		background: #f1eeee;
		margin-bottom: 0!important;
	}

	.sidebar-modern-inner .block-title {
    	padding: 8px 16px;
	}

	.sidebar-modern-inner .block-title h5 {
		color: #0b76a8;
	}

	.sidebar-modern-inner .block-title.has-arrow:after {
		border-color: #0b76a8 transparent transparent;
	}

	.list-filter ul ul {
		padding-left: 0;
	}

	.filter-content ul li {
		display: flex;
		align-items: center;
	}

	.sidebar-modern-inner .form-control::placeholder {
		color: #ffffff9e;
	}

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
		border-color: #cbc6c6;
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
		border-left: 16px solid #cbc6c6;
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
		background: #0b76a8!important;
		color: #FFF;
		text-align: center;
	}

	.border-color-primary {
		border-color: #dfdfdf!important;
	}

	.file-drop-zone .file-preview-thumbnails {
		display: flex;
	    justify-content: center;
	}

	#picturesBloc .control-label {
		text-align: center;
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

	.detail-line div {
		background-color: unset;
	}

	.items-details .add-title a,
	.company-name {
		text-overflow: ellipsis;
		overflow: hidden;
		display: -webkit-box;
		-webkit-box-orient: vertical;
		-webkit-line-clamp: 1;
		color: #0b76a8;
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
		margin-bottom: 4px;
		font-size: 16px;
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
		.add-image a img {
			width: 125px;
			height: 125px;
		}

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
		#homepage .add-image a img {
			width: 125px;
			height: 125px;
		}

		.add-image a img {
			width: 95px;
			height: 95px;
		}

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

	.toggle-btn-for-links {
		border: 2px solid #ccc;
		border-radius: 4px;
		padding: 5px;
		color: #b2b1b1!important;
		font-size: 20px;
	}

	@media (min-width: 768px) {
		.max-767-content {
			display: none !important;
		}
	}

	@media (max-width: 767px) {
		#homepage .add-image a img {
			width: 115px;
			height: 115px;
		}

		.mobile-search {
			box-shadow: inset 0 1px 0 #fafafa9c;
		}

		#navbarText {
			box-shadow: inset 0 1px 0 #fafafa9c;
		}

		.nav-and-search-container .searchs form input[type='text'] {
			border-radius: 4px;
		}

		.searchs form input[type='text'] {
			padding-left: 5px;
			-webkit-appearance: auto !important;
			border: 1px solid #fff;
		}

		.search-dropdown {
			border-radius: 4px;
			border: 2px solid #ff8533;
			background: #ff7e19;
			color: white;
			padding: 8px 0;
			padding-right: 1.1rem;
			width: 100%;
			cursor: pointer;
		}
		.searching-container {
			position: relative;
		}

		.searching-container:after {
			border-radius: 0 4px 4px 0;
			content: '\F107';
			font-family: "Font Awesome\ 5 Free";
			color: #ff7e19;
			background: #FFF;
			right: 0;
			height: 100%;
			display: flex;
			align-items: center;
			padding: 5px;
			border-left: 1px solid #ff7e19;
			position: absolute;
			top: 0;
			pointer-events: none;
			font-weight: 900;
			font-size: 18px;
		}

		.nav-and-search-container .searchs form {
			flex-direction: column;
			padding: 0 8px;
			padding-top: 12px;
		}

		.header .dropdown-nav .fa-angle-down {
			font-size: 18px!important;
		}

		.header .dropdown-nav {
			padding: 8px 16px;
			font-size: 12px;
			display: flex!important;
			justify-content: space-between;
			align-items: center;
		}

		.header-upper-inner2 .main-nav {
			flex-wrap: nowrap;
		}

		.border-bottom-767 {
			display: none;
		}

		.header .navbar-left {
			padding: 0!important;
		}

		.header .navbar-left .navbar-nav li {
			padding-left: 16px;
		}

		.list-prof-btns {
			width: 100%;
		}

		.header .navbar-left .menubar-nav {
			width: 100%;
			margin: 8px 0;
		}

		.links-container-767 {
			width: 100%;
			flex-direction: column;
		}

		.max-767-content {
			display: block !important;
		}

		.header-upper-inner1 {
			justify-content: space-between;
			width: 100%;
			padding: 0;
		}

		.upper-links-main {
			margin-left: 0;
		}

		.mini-tab-mobile-hidden {
			display: none;
		}

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
		span.item-location a {
			font-size: 12px;
		}

		#stepWizard ul.nav-wizard li {
			font-size: 14px;
			padding: 0 10px 0 20px;
		}

		.page-content .inner-box .title-2 {
			font-size: 16px;
		}

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

		.header .search-row .search-col .form-control,
		.header .search-row button.btn-search,
		.header .search-row-wrapper .form-control,
		.header .search-row-wrapper button.btn,
		.orange-btn {
			font-size: 12px!important;
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
			padding: 0 4px!important;
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
						<ul class="upper-links mini-tab-mobile-hidden">
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
									{{--									<span class="icon-user-add fa fa-icons"></span><a href="{{ \App\Helpers\UrlGen::register() }}">{{ t('register') }}</a>--}}
									<span class="icon-user-add fa fa-icons"></span><a href="{{ url('create-1') }}">{{ t('register') }}</a>
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
										<!-- <span class="badge badge-pill badge-important count-threads-with-new-messages hidden-sm">0</span> -->
										<span class="icon-down-open-big fa"></span>
									</a>
									<?php
									$xf = \XF::app();
									$user = $xf->finder('XF:User')
											->where('email',auth()->user()->email)->fetchOne();
									$fulllink ='https://professionals.gulflabexpo.com/public/forum/index.php?members/'.strtolower(str_replace(' ','-',$user['username'])).'.'.$user['user_id'].'/';

									?>
									<ul id="userMenuDropdown" class="dropdown-menu user-menu dropdown-menu-right shadow-sm">
										<li class="dropdown-item active">
											<a href="{{ url('account') }}">
												<span class="icon-user-1"></span> My Account
											</a>
										</li>
										<li class="dropdown-item"><a href="{{ url('account/my-posts') }}"><span class="icon-user"></span> My Profile </a></li>
										<li class="dropdown-item"><a href="{{$fulllink}}"><span class="icon-clipboard"></span> My Posts </a></li>
										<li class="dropdown-item"><a href="{{ url('account/favourite') }}"><span class="icon-vcard"></span> Contact Directory </a></li>
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
						</ul>

						<p class="expo-txt">NETWORKING</p>
					</div>
					<a role="buttons" data-toggle="collapse" data-target="#navbarText" aria-expanded="true" class="fa fa-bars toggle-btn-for-links max-767-content"></a>
				</div>
				<div class="col-lg-6 col-md-12 header-upper-inner2 px-0">
					<ul class="nav navbar-nav main-nav">
						<li class="online-expo"><a href="https://gulflabexpo.com">Online Expo</a></li>
						<li class="lab-news"><a href="https://professionals.gulflabexpo.com">Networking</a></li>
						<li class="classified active"><a href="http://classifieds.gulflabexpo.com">Classifieds</a></li>
						<li class="ask-advice"><a href="https://gulflabexpo.com/news">News</a></li>
					</ul>
					<p class="middle-txt">Virtual Expo for Lab Equipment, Products and Services for MENA region</p>
				</div>
			</div>
		</div>
		<div class="bordr nav-and-search-container">
			<nav class="py-0 navbar navbar-expand-md" style="background-color:#0b76a8 !important">
				<button data-toggle="collapse" data-target="#navbarText1" class="dropdown-nav">
					<b>FIND A PROFESSIONAL</b><span class="fa fa-angle-down"></span></button>
				<div class="d-md-none w-100">
					<div class="mt-0 navbar-collapse nav-and-search-container collapse in" id="navbarText1" aria-expanded="true" style="">
						<div class="searchs mobile-search">
							@includeFirst([config('larapen.core.customizedViewPath') . 'search.inc.mobile-header-search', 'search.inc.mobile-header-search'])
						</div>
					</div>
				</div>
				<div class="collapse navbar-collapse" id="navbarText">
					<div class="navbar-left px-0">

						<div class="menubar-nav">
							<ul class="nav navbar-nav hov">
								<li class="coll mb-md-0 mb-2"><a class="botom-navabr" href="{{ url('/') }}">Home</a></li>
								<li class="coll mb-md-0 mb-2"><a class="botom-navabr" href="{{ url('page/about-us') }}">About Us</a></li>
								<li class="coll mb-md-0 mb-2 pl-md-0"><a class="botom-navabr" href="{{ url('page/faq') }}">FAQs</a></li>
								@if (auth()->check())
									<li class="coll mb-md-0 mb-2 d-none"><a class="botom-navabr" href="{{ url('account') }}">{{ auth()->user()->name }}</a></li>
									<li class="coll mb-md-0 mb-2 d-none"><a class="botom-navabr" href="{{ url('account') }}">My Account</a></li>
									<li class="coll mb-md-0 mb-2 d-none"><a class="botom-navabr" href="{{ url('account/my-posts') }}">My Profile</a></li>
									<li class="coll mb-md-0 mb-2 d-none"><a class="botom-navabr" href="{{$fulllink}}">My Posts</a></li>
									<li class="coll mb-md-0 mb-2 d-none"><a class="botom-navabr" href="{{ url('account/favourite') }}">Contact Directory</a></li>
									@if (app('impersonate')->isImpersonating())
										<li class="coll mb-md-0 mb-2 max-767-content"><a class="botom-navabr" href="{{ route('impersonate.leave') }}">{{ t('Leave') }}</a></li>										
									@endif
								@endif
							
								<li class="coll mb-md-0 mb-2 max-767-content"><a class="botom-navabr" href="#">FAQs</a></li>
								<li class="coll mb-md-0 max-767-content"><a class="botom-navabr" href="{{url('contact')}}">Contact Us</a></li>
							</ul>
						</div>
						<div class="mx-0 search-row">
							@includeFirst([config('larapen.core.customizedViewPath') . 'search.inc.header-search', 'search.inc.header-search'])
						</div>
						<div class="mt-lg-0 mt-md-2 d-flex align-items-center links-container-767">
							<!-- <a class="mr-1 postadd btn orange-btn list-prof-btns" href="#quickLogin" data-toggle="modal">
                                <span class="fa fa-plus-circle mr-2"></span> Add Listing
                            </a> -->
							<div class="d-inline-md-block d-none menubar-nav mr-md-3">
								<ul class="nav navbar-nav hov">
									<li class="coll mr-3"><a class="botom-navabr" href="#">FAQs</a></li>
								</ul>
							</div>

							@if(auth()->user())
								{{--								<a class="postadd btn orange-btn list-prof-btns" href="{{ url('create-1') }}"{{ url('create-1') }}>--}}
									<a class="postadd btn orange-btn list-prof-btns max-767-content" href="{{ url('account') }}" style="border-bottom: 1px solid #FFF">My Account</a>
									<a class="postadd btn orange-btn list-prof-btns max-767-content" href="{{ url('account/my-posts') }}" style="border-bottom: 1px solid #FFF">My Profile</a>
									<a class="postadd btn orange-btn list-prof-btns max-767-content" href="{{$fulllink}}" style="border-bottom: 1px solid #FFF">My Posts</a>
									<a class="postadd btn orange-btn list-prof-btns max-767-content" href="{{ url('account/favourite') }}" style="border-bottom: 1px solid #FFF">Contact Directory</a>
									<a class="postadd btn orange-btn list-prof-btns" href="https://professionals.gulflabexpo.com/forum/index.php" style="border-bottom: 1px solid #FFF">
										<span class="fa fa-plus-circle d-md-inline-block d-none mr-2"></span><span class="fa fa-plus d-md-none d-inline-block mr-2"></span> {{ ('Join a Discussion') }}
									</a>
									<a class="postadd btn orange-btn list-prof-btns max-767-content" href="{{ \App\Helpers\UrlGen::logout() }}">{{ t('log_out') }}</a>
							@else
									<a class="postadd btn orange-btn list-prof-btns max-767-content" href="{{url('login')}}" style="border-bottom: 1px solid #FFF">Profile Log In</a>
									<a class="postadd btn orange-btn list-prof-btns max-767-content" href="{{url('register')}}" style="border-bottom: 1px solid #FFF">Create Your Profile</a>
									<a class="postadd btn orange-btn list-prof-btns max-767-content" href="{{ url('account/favourite') }}" style="border-bottom: 1px solid #FFF">Contact Directory</a>
									<a class="postadd btn orange-btn list-prof-btns" href="{{ url('login') }}"{{ url('create-1') }}>
										<span class="fa fa-plus-circle d-md-inline-block d-none mr-2"></span><span class="fa fa-plus d-md-none d-inline-block mr-2"></span> {{ ('Join a Discussion') }}
									</a>
						@endif
						<!-- <a class="btn orange-btn list-prof-btns"><span class="fa fa-plus-circle mr-2"></span>Create an Ad</a> -->
						</div>
					</div>
				</div>
			</nav>
		</div>
		<div class="row bordr border-bottom-767" style="border:3px solid #ff8533;background: #ff8533;margin: 0"></div>
	</div>
</div>

{{-- Header backup till the date of 12/13/2021 --}}
{{--<div class="header">
	<nav class="navbar fixed-top navbar-site navbar-light bg-light navbar-expand-md" role="navigation">
		<div class="container-fluid">

			<div class="navbar-identity">
				 Logo
				<a href="{{ url('/') }}" class="navbar-brand logo logo-title">
					<img src="{{ imgUrl(config('settings.app.logo'), 'logo') }}"
						 alt="{{ strtolower(config('settings.app.app_name')) }}" class="tooltipHere main-logo" title="" data-placement="bottom"
						 data-toggle="tooltip"
						 data-original-title="{!! isset($logoLabel) ? $logoLabel : '' !!}"/>
				</a>
				 Toggle Nav (Mobile)
				<button data-target=".navbar-collapse" data-toggle="collapse" class="navbar-toggler pull-right" type="button">
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30" width="30" height="30" focusable="false">
						<title>{{ t('Menu') }}</title>
						<path stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-miterlimit="10" d="M4 7h22M4 15h22M4 23h22"></path>
					</svg>
				</button>
				 Country Flag (Mobile)
				@if (request()->segment(1) != 'countries')
					@if (isset($multiCountriesIsEnabled) and $multiCountriesIsEnabled)
						@if (!empty(config('country.icode')))
							@if (file_exists(public_path() . '/images/flags/24/' . config('country.icode') . '.png'))
								<button class="flag-menu country-flag d-block d-md-none btn btn-secondary hidden pull-right" href="#selectCountry" data-toggle="modal">
									<img src="{{ url('images/flags/24/' . config('country.icode') . '.png') . getPictureVersion() }}"
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
					 Country Flag
					@if (request()->segment(1) != 'countries')
						@if (config('settings.geo_location.country_flag_activation'))
							@if (!empty(config('country.icode')))
								@if (file_exists(public_path() . '/images/flags/32/' . config('country.icode') . '.png'))
									<li class="flag-menu country-flag tooltipHere hidden-xs nav-item" data-toggle="tooltip" data-placement="{{ (config('lang.direction') == 'rtl') ? 'bottom' : 'right' }}" {!! $multiCountriesLabel !!}>
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
				<?php
						$addListingUrl = \App\Helpers\UrlGen::addPost();
						$addListingAttr = '';
						if (!auth()->check()) {
							if (config('settings.single.guests_can_post_ads') != '1') {
								$addListingUrl = '#quickLogin';
								$addListingAttr = ' data-toggle="modal"';
							}
						}
						if (config('settings.single.pricing_page_enabled') == '1') {
							$addListingUrl = \App\Helpers\UrlGen::pricing();
							$addListingAttr = '';
						}
					?>

				<ul class="nav navbar-nav ml-auto navbar-right">
					@if (!auth()->check())
						<li class="nav-item">
							@if (config('settings.security.login_open_in_modal'))
								<a href="#quickLogin" class="nav-link" data-toggle="modal"><i class="icon-user fa"></i> {{ t('log_in') }}</a>
							@else
								<a href="{{ \App\Helpers\UrlGen::login() }}" class="nav-link"><i class="icon-user fa"></i> {{ t('log_in') }}</a>
							@endif
						</li>
						<li class="nav-item hidden-sm">
							<a href="{{ \App\Helpers\UrlGen::register() }}" class="nav-link"><i class="icon-user-add fa"></i> {{ t('register') }}</a>
							 <a href="{{ $addListingUrl }}" class="nav-link"><i class="icon-user-add fa"></i> {{ t('register') }}</a>
							<a href="{{url('create-1')}}" class="nav-link"><i class="icon-user-add fa"></i> {{ t('register') }}</a>

						</li>
					@else

						<li class="nav-item hidden-sm">
							@if (app('impersonate')->isImpersonating())
								<a href="{{ route('impersonate.leave') }}" class="nav-link">
									<i class="icon-logout hidden-sm"></i> {{ t('Leave') }}
								</a>
							@else
							@if(\Auth::user()->is_admin == 0)
								<a href="{{ \App\Helpers\UrlGen::logout() }}" class="nav-link">
									<i class="icon-logout hidden-sm"></i> {{ t('log_out') }}
								</a>
							@endif
							@endif
						</li>
						<li class="nav-item dropdown no-arrow">
							<a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
								<i class="icon-user fa hidden-sm"></i>
								<span>{{ auth()->user()->name }}</span>
								<!-- <span class="badge badge-pill badge-important count-threads-with-new-messages hidden-sm">0</span> -->
								@if(\Auth::user()->is_admin == 0)<i class="icon-down-open-big fa hidden-sm"></i>@endif
							</a>
							@if(\Auth::user()->is_admin == 0)
							<ul id="userMenuDropdown" class="dropdown-menu user-menu dropdown-menu-right shadow-sm">
								<li class="dropdown-item active">
									<a href="{{ url('account') }}">
										<i class="icon-home"></i> {{ t('Personal Home') }}
									</a>
								</li>
								<li class="dropdown-item"><a href="{{ url('account/my-posts') }}"><i class="icon-th-thumb"></i> My Profile </a></li>
								<li class="dropdown-item"><a href="{{ url('account/favourite') }}"><i class="icon-heart"></i> Saved Profiles </a></li>
								<li class="dropdown-item"><a href="{{ url('account/saved-search') }}"><i class="icon-star-circled"></i> {{ t('Saved searches') }} </a></li>
								<li class="dropdown-item"><a href="{{ url('account/pending-approval') }}"><i class="icon-hourglass"></i> {{ t('pending_approval') }} </a></li>
								<li class="dropdown-item"><a href="{{ url('account/archived') }}"><i class="icon-folder-close"></i> {{ t('archived_ads') }}</a></li>
								<li class="dropdown-item">
									<a href="{{ url('account/messages') }}">
										<i class="icon-mail-1"></i> {{ t('messenger') }}
										<span class="badge badge-pill badge-important count-threads-with-new-messages">0</span>
									</a>
								</li>
								<li class="dropdown-item"><a href="{{ url('account/transactions') }}"><i class="icon-money"></i> {{ t('Transactions') }}</a></li>
								<li class="dropdown-divider"></li>
								<li class="dropdown-item">
									@if (app('impersonate')->isImpersonating())
										<a href="{{ route('impersonate.leave') }}"><i class="icon-logout"></i> {{ t('Leave') }}</a>
									@else
										<a href="{{ \App\Helpers\UrlGen::logout() }}"><i class="icon-logout"></i> {{ t('log_out') }}</a>
									@endif
								</li>
							</ul>
							@endif
						</li>

					@endif

					@if (config('plugins.currencyexchange.installed'))
						@include('currencyexchange::select-currency')
					@endif

					@if (config('settings.single.pricing_page_enabled') == '2')
						<li class="nav-item pricing">
							<a href="{{ \App\Helpers\UrlGen::pricing() }}" class="nav-link">
								<i class="fas fa-tags"></i> {{ t('pricing_label') }}
							</a>
						</li>
					@endif


					 {{dd(\Auth::user())}}

					@if(\Auth::user())
					@if(\Auth::user()->is_admin == 0)
					@if(count(\Auth::user()->posts) == 0)

						@if(\App\Models\Post::withoutGlobalScope('App\Models\Scopes\ReviewedScope')->withoutGlobalScope('App\Models\Scopes\VerifiedScope')->withoutGlobalScope('App\Models\Scopes\LocalizedScope')->where('user_id', \Auth::id())->count() == 0)
						<li class="nav-item postadd">
							 <a class="btn btn-block btn-border btn-post btn-add-listing" href="{{ $addListingUrl }}"{!! $addListingAttr !!}>
								<i class="fa fa-plus-circle"></i> Create Your Profile
							</a>
							<a class="btn btn-block btn-border btn-post btn-add-listing" href="{{ url('create-1') }}"{!! $addListingAttr !!}>
								<i class="fa fa-plus-circle"></i> Create Your Profile
							</a>
						</li>
						@endif

					@else

					<li class="nav-item postadd">
						<a class="btn btn-block btn-border btn-post btn-add-listing" href="{{ \App\Helpers\UrlGen::post(\Auth::user()->posts[0]) }}"{!! $addListingAttr !!}>
							<i class="fa fa-plus-circle"></i> View Your Profile
						</a>
					</li>
					@endif
					@endif
					@else
					<li class="nav-item postadd">
						<a class="btn btn-block btn-border btn-post btn-add-listing" href="{{ url('create-1') }}"{!! $addListingAttr !!}>
							<i class="fa fa-plus-circle"></i> Create Your Profile
						</a>
					</li>
					@endif





					@includeFirst([config('larapen.core.customizedViewPath') . 'layouts.inc.menu.select-language', 'layouts.inc.menu.select-language'])

				</ul>
			</div>


		</div>
	</nav>
</div>--}}
