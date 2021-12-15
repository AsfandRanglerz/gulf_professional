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
					<div class="inner-box">
						<h2 class="title-2"><i class="icon-star-circled"></i> {{ t('Saved searches') }} </h2>
						<div class="row">

							<div class="col-md-4">
								<ul class="list-group list-group-unstyle">
									@if (isset($savedSearch) and $savedSearch->getCollection()->count() > 0)
										@foreach ($savedSearch->items() as $search)
											<li class="list-group-item {{ (request()->get('q')==$search->keyword) ? 'active' : '' }}">
												<a href="{{ url('account/saved-search/?'.$search->query.'&pag='.request()->get('pag')) }}" class="">
													<span> {{ \Illuminate\Support\Str::limit(strtoupper($search->keyword), 20) }} </span>
													<span class="badge badge-pill badge-warning" id="{{ $search->id }}">{{ $search->count }}+</span>
												</a>
												<span class="delete-search-result">
                                                    <a href="{{ url('account/saved-search/'.$search->id.'/delete') }}">&times;</a>
                                                </span>
											</li>
										@endforeach
									@else
										<div>
											{{ t('You have no saved search') }}
										</div>
									@endif
								</ul>
                                <div class="pagination-bar text-center">
                                    {{ (isset($savedSearch)) ? $savedSearch->links() : '' }}
                                </div>
							</div>

							<div class="col-md-8">
								<div class="adds-wrapper category-list">

                                    @if (isset($savedSearch) and $savedSearch->getCollection()->count() > 0)
                                        @if (isset($posts) and $posts->total() > 0)
											@foreach($posts->items() as $key => $post)
												@continue(isset($countries) and !$countries->has($post->country_code))
												@continue(empty($post->city))
												<?php
													// Main Picture
													if ($post->pictures->count() > 0) {
														$postImg = imgUrl($post->pictures->get(0)->filename, 'medium');
													} else {
														$postImg = imgUrl(config('larapen.core.picture.default'), 'medium');
													}
												?>
												<div class="item-list">
													<div class="row">
														<div class="col-md-2 no-padding photobox">
															<div class="add-image">
																<span class="photo-count">
																	<i class="fa fa-camera"></i> {{ $post->pictures->count() }}
																</span>
																<a href="{{ \App\Helpers\UrlGen::post($post) }}">
																	<img class="img-thumbnail no-margin" src="{{ $postImg }}" alt="img">
																</a>
															</div>
														</div>

														<div class="col-md-8 add-desc-box">
															<div class="items-details">
																<h5 class="add-title">
																	<a href="{{ \App\Helpers\UrlGen::post($post) }}"> {{ $post->title }} </a>
																</h5>

																<span class="info-row">
																	@if (isset($post->postType) and !empty($post->postType))
																		<span class="add-type business-ads tooltipHere"
																			  data-toggle="tooltip"
																			  data-placement="right"
																			  title="{{ $post->postType->name }}"
																		>
																			{{ strtoupper(mb_substr($post->postType->name, 0, 1)) }}
																		</span>
																	@endif
																	<span class="date">
																		<i class="icon-clock"></i> {!! $post->created_at_formatted !!}
																	</span>
																	@if (!empty($post->category))
																		@if ($cats->has($post->category->parent_id))
																			&nbsp<span class="category">
																				<i class="icon-folder-circled"></i>
																				{{ $cats->get($post->category->parent_id)->name }}
																			</span>
																		@else
																			@if (empty($post->category->parent_id))
																				&nbsp;<span class="category">
																					<i class="icon-folder-circled"></i> {{ $post->category->name }}
																				</span>
																			@endif
																		@endif
																	@endif
																	@if (!empty($post->city))
																		&nbsp;<span class="item-location">
																			<i class="icon-location-2"></i> {{ $post->city->name }}
																		</span>
																	@endif
																</span>
															</div>
														</div>

														<div class="col-md-2 text-right text-center-xs price-box">
															<h4 class="item-price">
																{!! \App\Helpers\Number::money($post->price) !!}
															</h4>
														</div>
													</div>
												</div>
											@endforeach
                                        @else
											<div class="text-center mt10 mb30">
												{{ t('Please select a saved search to show the result') }}
											</div>
                                        @endif
                                    @else
                                        <div class="text-center">
                                            {{-- t('no_result_refine_your_search') --}}
                                        </div>
                                    @endif
								</div>

								<div style="clear:both;"></div>

								<nav class="pagination-bar mb-4" aria-label="">
                                    <?php
									if (isset($posts)) {
										echo $posts->appends(collect(request()->query())->map(function($item) {
											return is_null($item) ? '' : $item;
										})->toArray())->links();
									}
									?>
								</nav>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('after_scripts')
	<script>
		/* Default view (See in /js/script.js) */
		@if (isset($posts) and count($posts) > 0)
			@if (config('settings.listing.display_mode') == '.grid-view')
				gridView('.grid-view');
			@elseif (config('settings.listing.display_mode') == '.list-view')
				listView('.list-view');
			@elseif (config('settings.listing.display_mode') == '.compact-view')
				compactView('.compact-view');
			@else
				gridView('.grid-view');
			@endif
		@else
			listView('.list-view');
		@endif
		/* Save the Search page display mode */
		var listingDisplayMode = readCookie('listing_display_mode');
		if (!listingDisplayMode) {
			createCookie('listing_display_mode', '{{ config('settings.listing.display_mode', '.grid-view') }}', 7);
		}
	</script>
	<!-- include footable   -->
	<script src="{{ url('assets/js/footable.js?v=2-0-1') }}" type="text/javascript"></script>
	<script src="{{ url('assets/js/footable.filter.js?v=2-0-1') }}" type="text/javascript"></script>
	<script type="text/javascript">
        $(function () {
			$('#addManageTable').footable().bind('footable_filtering', function (e) {
				var selected = $('.filter-status').find(':selected').text();
				if (selected && selected.length > 0) {
					e.filter += (e.filter && e.filter.length > 0) ? ' ' + selected : selected;
					e.clear = !e.filter;
				}
			});

			$('.clear-filter').click(function (e) {
				e.preventDefault();
				$('.filter-status').val('');
				$('table.demo').trigger('footable_clear_filter');
			});

		});
	</script>
	<!-- include custom script for ads table [select all checkbox]  -->
	<script>
		function checkAll(bx) {
			var chkinput = document.getElementsByTagName('input');
			for (var i = 0; i < chkinput.length; i++) {
				if (chkinput[i].type == 'checkbox') {
					chkinput[i].checked = bx.checked;
				}
			}
		}
	</script>
@endsection
