@extends('layouts.reports')

@section('page-header')
Reports
@stop

@section('page-nav')
@stop

@section('content')
<div class="row">
	<div class="col-8 border-box">
		<canvas id="leadOfficeListChart" width="1400" height="1000"></canvas>
	</div>
	<div class="col-4 border-box last">
		@foreach($clients as $client)
			<i class="fa fa-square fa-lg" style="color:{{ $colours[$client['id']] }}"></i> {{ $client['unit_name'] }} ({{ $client['client_count'] }})<br/>
		@endforeach
	</div>
</div>
@stop

@section('chart-script')

<script>
	(function()
    {
    	// Get context with jQuery - using jQuery's .get() method.
        var ctx = $("#leadOfficeListChart").get(0).getContext("2d");

    	var data = [
    		@foreach($clients as $client)
    		{
				value: {{ $client['client_count'] }},
				color:"{{ $colours[$client['id']] }}",
				highlight: applySat("{{ $colours[$client['id']] }}", 0.3),
				label: "{{ $client['unit_name'] }}"
			},
    		@endforeach
		];

		var myPieChart = new Chart(ctx).Pie(data);

//		Change saturation of colour
		function applySat(hex, lum) {

        	// validate hex string
        	hex = String(hex).replace(/[^0-9a-f]/gi, '');
        	if (hex.length < 6) {
        		hex = hex[0]+hex[0]+hex[1]+hex[1]+hex[2]+hex[2];
        	}
        	lum = lum || 0;

        	// convert to decimal and change luminosity
        	var rgb = "#", c, i;
        	for (i = 0; i < 3; i++) {
        		c = parseInt(hex.substr(i*2,2), 16);
        		c = Math.round(Math.min(Math.max(0, c + (c * lum)), 255)).toString(16);
        		rgb += ("00"+c).substr(c.length);
        	}

        	return rgb;
        }
    })();
</script>
@stop