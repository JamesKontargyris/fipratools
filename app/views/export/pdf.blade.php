<html>
	<body>
		@foreach($items as $item)
			{{ $item->name }}, {{ $item->unit()->pluck('name') }} <br/>
		@endforeach
	</body>
</html>
