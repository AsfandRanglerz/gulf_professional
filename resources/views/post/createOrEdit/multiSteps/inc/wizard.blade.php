<div id="stepWizard" class="container-fluid">
    <div class="row">
        <div class="col-xl-12">
            <section>
                <div class="wizard">

                    <ul class="nav nav-wizard">
                        @if (request()->segment(2) == 'create')
                            <?php $uriPath = request()->segment(4); ?>
							@if (!in_array($uriPath, ['finish']))
								<li class="{{ ($uriPath == '') ? 'active' : (in_array($uriPath, ['photos', 'packages', 'finish']) or (isset($post) and !empty($post)) ? '' : 'disabled') }}">
									@if (isset($post) and !empty($post))
										<a href="{{ url('posts/create/' . $post->tmp_token) }}">{{ t('ad_details') }}</a>
									@else
										<a href="{{ url('posts/create') }}">{{ t('ad_details') }}</a>
									@endif
								</li>

								<li class="picturesBloc {{ ($uriPath == 'photos') ? 'active' : ((in_array($uriPath, ['photos', 'packages', 'finish']) or (isset($post) and !empty($post))) ? '' : 'disabled') }}">
									@if (isset($post) and !empty($post))
										<a href="{{ url('posts/create/' . $post->tmp_token . '/photos') }}">{{ t('Photos') }}</a>
									@else
										<a>{{ t('Photos') }}</a>
									@endif
								</li>

								<!-- to hide the payement method tab from the upper menu -->
								{{-- @if (isset($countPackages) and isset($countPaymentMethods) and $countPackages > 0 and $countPaymentMethods > 0)
								<li class="{{ ($uriPath == 'payment') ? 'active' : ((in_array($uriPath, ['finish']) or (isset($post) and !empty($post))) ? '' : 'disabled') }}">
									@if (isset($post) and !empty($post))
										<a href="{{ url('posts/create/' . $post->tmp_token . '/payment') }}">{{ t('Payment') }}</a>
									@else
										<a>{{ t('Payment') }}</a>
									@endif
								</li>
								@endif --}}
							@endif

                            @if ($uriPath == 'activation')
                            <li class="{{ ($uriPath == 'activation') ? 'active' : 'disabled' }}">
                                <a>{{ t('Activation') }}</a>
                            </li>
                            @else
                            <li class="{{ ($uriPath == 'finish') ? 'active' : 'disabled' }}">
                                <a>{{ t('Finish') }}</a>
                            </li>
                            @endif
                        @else
                            <?php $uriPath = request()->segment(3); ?>
							@if (!in_array($uriPath, ['finish']))
								<li class="{{ (in_array($uriPath, [null, 'edit'])) ? 'active' : '' }}">
									@if (isset($post) and !empty($post))
										<a href="{{ url('posts/' . $post->id . '/edit') }}">{{ t('ad_details') }}</a>
									@else
										<a href="{{ url('posts/create') }}">{{ t('ad_details') }}</a>
									@endif
								</li>

								<li class="picturesBloc {{ ($uriPath == 'photos') ? 'active' : '' }}">
									@if (isset($post) and !empty($post))
										<a href="{{ url('posts/' . $post->id . '/photos') }}">{{ t('Photos') }}</a>
									@else
										<a>{{ t('Photos') }}</a>
									@endif
								</li>

								{{-- @if (isset($countPackages) and isset($countPaymentMethods) and $countPackages > 0 and $countPaymentMethods > 0)
								<li class="{{ ($uriPath == 'payment') ? 'active' : '' }}">
									@if (isset($post) and !empty($post))
										<a href="{{ url('posts/' . $post->id . '/payment') }}">{{ t('Payment') }}</a>
									@else
										<a>{{ t('Payment') }}</a>
									@endif
								</li>
								@endif --}}
							@endif

                            <li class="{{ ($uriPath == 'finish') ? 'active' : 'disabled' }}">
                                <a>{{ t('Finish') }}</a>
                            </li>
                        @endif
                    </ul>

                </div>
            </section>
        </div>
    </div>
</div>

@section('after_styles')
    @parent
	@if (config('lang.direction') == 'rtl')
    	<link href="{{ url('assets/css/rtl/wizard.css') }}" rel="stylesheet">
	@else
		<link href="{{ url('assets/css/wizard.css') }}" rel="stylesheet">
	@endif
@endsection
@section('after_scripts')
    @parent
@endsection
