<?php
// Keywords
$keywords = rawurldecode(request()->get('q'));

// Category
$qCategory = (isset($cat) and !empty($cat)) ? $cat->tid : request()->get('c');

// Location
if (isset($city) and !empty($city)) {
	$qLocationId = (isset($city->id)) ? $city->id : 0;
	$qLocation = $city->name;
	$qAdmin = request()->get('r');
} else {
	$qLocationId = request()->get('l');
	$qLocation = (request()->filled('r')) ? t('area') . rawurldecode(request()->get('r')) : request()->get('location');
    $qAdmin = request()->get('r');
}
?>

<div class="container-fluid">
	<div class="search-row-wrapper rounded">
		<div class="container-fluid">
			<form id="seach" name="search" action="{{ \App\Helpers\UrlGen::search() }}" method="GET">
				<div class="row m-0">

					<div class="col-xl-3 col-md-3 col-sm-12 col-xs-12">
						<select name="c" id="catSearch" class="form-control selecter">
							<option value="" {{ ($qCategory=='') ? 'selected="selected"' : '' }}>
								{{ 'ALL PROFESSION CATEGORIES' }}
							</option>
							{{-- @if (isset($rootCats) and $rootCats->count() > 0) --}}
								@foreach (\App\Models\Category::trans()->where(function ($query) {
				$query->where('parent_id', 0)->orWhereNull('parent_id');
			})->orderBy('lft')->get() as $itemCat)
									<option {{ ($qCategory==$itemCat->tid) ? ' selected="selected"' : '' }} value="{{ $itemCat->tid }}">
										{{ $itemCat->name }}
									</option>
								@endforeach
							{{-- @endif --}}
						</select>
					</div>

					<div class="col-xl-3 col-md-3 col-sm-12 col-xs-12 search-col locationicon">
						<select name="country_search" id="country_search" class="form-control selecter">
							<option value="" {{ (request('country_search')=='') ? 'selected="selected"' : '' }}>
								{{ 'ALL MENA COUNTRIES' }}
							</option>

								@foreach (\App\Models\Country::all() as $country)
									<option {{ (request('country_search')==$country->code) ? ' selected="selected"' : '' }} value="{{ $country->code }}">
										{{ $country->asciiname }}
									</option>
								@endforeach

						</select>
					</div>

					<div class="col-xl-4 col-md-4 col-sm-12 col-xs-12">
						<input name="q" class="form-control keyword" type="text" placeholder="Name" value="{{ $keywords }}">
					</div>



					<input type="hidden" id="lSearch" name="l" value="{{ $qLocationId }}">
					<input type="hidden" id="rSearch" name="r" value="{{ $qAdmin }}">

					<div class="col-xl-2 col-md-2 col-sm-12 col-xs-12">
						<button class="btn btn-block btn-primary">
							<i class="fa fa-search"></i> <strong>{{ t('find') }}</strong>
						</button>
					</div>

				</div>
			</form>
		</div>
	</div>
</div>

@section('after_scripts')
	@parent
	<script>
		$(document).ready(function () {
			$('#locSearch').on('change', function () {
				if ($(this).val() == '') {
					$('#lSearch').val('');
					$('#rSearch').val('');
				}
			});
		});
	</script>
@endsection
