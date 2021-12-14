<div class="reg-sidebar-inner text-center">
	
	@if (request()->segment(1) == 'create' or request()->segment(2) == 'create')
		{{-- Create Form --}}
		<div class="promo-text-box">
			<i class="icon-picture fa fa-4x icon-color-1"></i>
			<h3><strong>Post Free Profile</strong></h3>
			<p class="text-left">
				List yourself on Gulf Lab EXPO and discover networking opportunities in the MENA lab industry
			</p>
		</div>
	@else
		{{-- Edit Form --}}
		@if (config('settings.single.publication_form_type') == '2')
			{{-- Single Step Form --}}
			@if (auth()->check())
				@if (auth()->user()->id == $post->user_id)
					<div class="card sidebar-card panel-contact-seller">
						<div class="card-header">{{ t('author_actions') }}</div>
						<div class="card-content user-info">
							<div class="card-body text-center">
								<a href="{{ \App\Helpers\UrlGen::post($post) }}" class="btn btn-default btn-block">
									<i class="icon-right-hand"></i> {{ t('Return to the Ad') }}
								</a>
							</div>
						</div>
					</div>
				@endif
			@endif
			
		@else
			{{-- Multi Steps Form --}}
			@if (auth()->check())
				@if (auth()->user()->id == $post->user_id)
					<div class="card sidebar-card panel-contact-seller">
						<div class="card-header">{{ t('author_actions') }}</div>
						<div class="card-content user-info">
							<div class="card-body text-center">
								<a href="{{ \App\Helpers\UrlGen::post($post) }}" class="btn btn-default btn-block">
									<i class="icon-right-hand"></i> Return to the Profile
								</a>
								<a href="{{ url('posts/' . $post->id . '/photos') }}" class="btn btn-default btn-block">
									<i class="icon-camera-1"></i> {{ t('Update Photos') }}
								</a>
								{{-- @if (isset($countPackages) and isset($countPaymentMethods) and $countPackages > 0 and $countPaymentMethods > 0)
									<a href="{{ url('posts/' . $post->id . '/payment') }}" class="btn btn-success btn-block">
										<i class="icon-ok-circled2"></i> {{ t('Make It Premium') }}
									</a>
								@endif --}}
							</div>
						</div>
					</div>
				@endif
			@endif
			
		@endif
	@endif
	
	<div class="card sidebar-card border-color-primary">
		<div class="card-header bg-primary border-color-primary text-white uppercase">
			<small><strong>Keep your profile updated</strong></small>
		</div>
		<div class="card-content">
			<div class="card-body text-left">
				<ul class="list-check">
					<li>Add a professional photograph </li>
					<li>Include a brief profile summary</li>
					<li>Select the correct profile category</li>
					<li>Check everything before publishing</li>
				</ul>
			</div>
		</div>
	</div>
	
</div>