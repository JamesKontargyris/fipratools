@if (Session::has('flash_notification.message'))
	@if( Session::has('flash_notification.message') && ! Session::has('flash_notification.overlay'))
    	<div class="row alert-container">
    @endif
		@if (Session::has('flash_notification.overlay'))
			<div class="alert alert-overlay alert-{{ Session::get('flash_notification.level') }}">
				{{ Session::get('flash_notification.message') }}
			</div>
		@else
			<div class="alert alert-{{ Session::get('flash_notification.level') }} @if(is_request('login')) with-margin-bottom @endif">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				{{ Session::get('flash_notification.message') }}
			</div>
		@endif
    @if( Session::has('flash_notification.message') && ! Session::has('flash_notification.overlay'))
		</div>
	@endif
@endif

@if($errors->all())
<div class="row alert-container">
	<div class="alert alert-error">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		Please address the following errors:
		<ul>
			@foreach($errors->all() as $error)
			<li><strong>{{ $error }}</strong></li>
			@endforeach
		</ul>
	</div>
</div>
@endif