<?php
if (!isset($cacheExpiration)) {
    $cacheExpiration = (int)config('settings.optimization.cache_expiration');
}
$hideOnMobile = '';
if (isset($featuredOptions, $featuredOptions['hide_on_mobile']) and $featuredOptions['hide_on_mobile'] == '1') {
	$hideOnMobile = ' hidden-sm';
}
?>
@if (isset($featured) and !empty($featured) and $featured->posts->count() > 0)
	@includeFirst([config('larapen.core.customizedViewPath') . 'home.inc.spacer', 'home.inc.spacer'], ['hideOnMobile' => $hideOnMobile])
	<div class="container-fluid{{ $hideOnMobile }}">
		<div class="col-xl-12 content-box layout-section">
			<div class="row row-featured row-featured-category">
				<div class="col-xl-12 box-title">
					<div class="inner">

						<h2>
							<!-- <span class="title-3">{!! $featured->title !!}</span> -->
							<span class="title-3"><span style="font-weight: bold;">Similar Profiles </span> {{isset($post) && $post? '- '.$post->post_country->asciiname:''}}</span>
							<a href="{{ $featured->link }}" class="sell-your-item">
								{{ t('View more') }} <i class="icon-th-list"></i>
							</a>
						</h2>
					</div>
				</div>

				<div style="clear: both"></div>

				<div class="relative content featured-list-row clearfix">

					<div class="large-12 columns">
						<div class="no-margin featured-list-slider owl-carousel owl-theme">
							@foreach($featured->posts as $key => $post)
								@continue(empty($countries) or !$countries->has($post->country_code))
								<?php
								// Main Picture
								if ($post->pictures->count() > 0) {
									$postImg = imgUrl($post->pictures->get(0)->filename, 'medium');
								} else {
									$postImg = imgUrl(config('larapen.core.picture.default'), 'medium');
								}
								?>
								<div class="item">
									<a href="{{ \App\Helpers\UrlGen::post($post) }}">
										<span class="item-carousel-thumb">
											<img class="img-fluid" src="{{ $postImg }}" alt="{{ $post->title }}" style="border: 1px solid #e7e7e7; margin-top: 2px;">
										</span>
										<span class="item-name">{{ \Illuminate\Support\Str::limit($post->title, 70) }}</span>
												{{-- @if ( $post->getPostFieldsValues($post->category->tid, $post->id)->count() > 0)
									<?php $valid_array = ['Employer','Designation']; ?>
									@foreach($post->getPostFieldsValues($post->category->tid, $post->id)->sortByDesc('fields.name') as $field)
										@if(in_array($field->name , $valid_array))
										<?php
										if (in_array($field->type, ['radio', 'select'])) {
											if (is_numeric($field->default)) {
												$option = \App\Models\FieldOption::findTrans($field->default);
												if (!empty($option)) {
													$field->default = $option->value;
												}
											}
										} ?>
										<div class="detail-line pb-2 ">
											<div class="rounded-small ">
												<span class="px-2 detail-line-value " style="color: #333;float: unset">
													@if($field->name == 'Employer')
													<i class="fas fa-building"></i>
													@else
													<i class="fas fa-briefcase"></i>
													@endif
													{{ $field->default }}</span>
											</div>
										</div>


										@endif
									@endforeach
									@endif --}}

									<div class="detail-line pb-2 ">
										<div class="rounded-small ">
											<span class="px-2 detail-line-value" style="float: unset">

												<i class="fas fa-briefcase"></i>

												{{ $post->designation? $post->designation : 'Not Entered'}}</span>
										</div>
									</div>

									<div class="detail-line pb-2 ">
										<div class="rounded-small ">
											<span class="px-2 detail-line-value" style="float: unset">

												<i class="fas fa-building"></i>

												{{ $post->employer? $post->employer : 'Not Entered'}}</span>
										</div>
									</div>

									<span class="item-location">
										<i class="icon-location-2"></i>&nbsp;
										@if($post->city)
										{{ $post->post_country->asciiname.' - '.$post->city->name }}
										@else
											{{ $post->post_country->asciiname }}
										@endif
									</span>


										@if (config('plugins.reviews.installed'))
											@if (view()->exists('reviews::ratings-list'))
												@include('reviews::ratings-list')
											@endif
										@endif


									</a>
								</div>
							@endforeach
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
@endif

@section('after_style')
	@parent
@endsection

@section('before_scripts')
	@parent
	<script>
		/* Carousel Parameters */
		var carouselItems = {{ (isset($featured) and isset($featured->posts)) ? collect($featured->posts)->count() : 0 }};
		var carouselAutoplay = {{ (isset($featuredOptions) && isset($featuredOptions['autoplay'])) ? $featuredOptions['autoplay'] : 'false' }};
		var carouselAutoplayTimeout = {{ (isset($featuredOptions) && isset($featuredOptions['autoplay_timeout'])) ? $featuredOptions['autoplay_timeout'] : 1500 }};
		var carouselLang = {
			'navText': {
				'prev': "{{ t('prev') }}",
				'next': "{{ t('next') }}"
			}
		};
	</script>
@endsection
