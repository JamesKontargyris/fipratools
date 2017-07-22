@if (Session::has('alerts'))
	@foreach (Session::get('alerts') as $alert)
		<div class="alert alert-{{ $alert['type'] }} alert-dismissable with-margin-bottom">
			{{ $alert['message'] }}
		</div>
	@endforeach
@endif
