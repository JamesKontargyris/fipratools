@extends('layouts.reports')

@section('page-header')
Active Clients by Unit
@stop

@section('page-nav')
@stop

@section('content')
<div class="row">
	<div class="col-8 border-box">
		{{--<canvas id="leadOfficeListChart" width="400" height="200"></canvas>--}}
		<div id="chart_div" class="chart"></div>
		<div id="chart_div_print" class="chart-print"></div>
	</div>
	<div class="col-4 border-box last">

		<table class="index-table">
			<thead>
				<tr>
					<td><i class="fa fa-paint-brush"></i></td>
					<td>Unit Name</td>
					<td>Clients</td>
					<td>&percnt;</td>
				</tr>
				<tr>
					<td colspan="4" class="sub-header">Total clients: {{ $total_clients }}</td>
				</tr>
			</thead>
			@foreach($clients as $client)
				<tr>
					<td class="actions content-center"><i class="fa fa-square fa-lg" style="color:{{ $colours[$client['id']] }}"></i></td>
					<td>{{ $client['unit_name'] }}</td>
					<td>{{ $client['client_count'] }}</td>
					<td>{{ $client['percentage'] }}&percnt;</td>
				</tr>
			@endforeach
		</table>
	</div>
</div>
@stop

@section('chart-script')

<script type="text/javascript">

      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart1);
      function drawChart1() {
        var data = google.visualization.arrayToDataTable([
          ['Unit', 'Clients'],
          @foreach($clients as $client)
          	['{{ $client['unit_name'] }}', {{ $client['client_count'] }}],
          @endforeach

        ]);

        var options = {
          legend: 'none',
          chartArea:{left:0,top:0,width:'100%',height:'100%'},
          colors: ['#00257f', '#14b1cc', '#8dcc29', '#6f5ce5', '#007770', '#14990f', '#ccd3e5', '#5F697F','#00257f', '#14b1cc', '#8dcc29', '#6f5ce5', '#007770', '#14990f', '#ccd3e5', '#5F697F','#00257f', '#14b1cc', '#8dcc29', '#6f5ce5', '#007770', '#14990f', '#ccd3e5', '#5F697F','#00257f', '#14b1cc', '#8dcc29', '#6f5ce5', '#007770', '#14990f', '#ccd3e5', '#5F697F','#00257f', '#14b1cc', '#8dcc29', '#6f5ce5', '#007770', '#14990f', '#ccd3e5', '#5F697F','#00257f', '#14b1cc', '#8dcc29', '#6f5ce5', '#007770', '#14990f', '#ccd3e5', '#5F697F','#00257f', '#14b1cc', '#8dcc29', '#6f5ce5', '#007770', '#14990f', '#ccd3e5', '#5F697F','#00257f', '#14b1cc', '#8dcc29', '#6f5ce5', '#007770', '#14990f', '#ccd3e5', '#5F697F','#00257f', '#14b1cc', '#8dcc29', '#6f5ce5', '#007770', '#14990f', '#ccd3e5', '#5F697F','#00257f', '#14b1cc', '#8dcc29', '#6f5ce5', '#007770', '#14990f', '#ccd3e5', '#5F697F','#00257f', '#14b1cc', '#8dcc29', '#6f5ce5', '#007770', '#14990f', '#ccd3e5', '#5F697F','#00257f', '#14b1cc', '#8dcc29', '#6f5ce5', '#007770', '#14990f', '#ccd3e5', '#5F697F','#00257f', '#14b1cc', '#8dcc29', '#6f5ce5', '#007770', '#14990f', '#ccd3e5', '#5F697F','#00257f', '#14b1cc', '#8dcc29', '#6f5ce5', '#007770', '#14990f', '#ccd3e5', '#5F697F']
       };

      var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }

      var chartPrint = new google.visualization.PieChart(document.getElementById('chart_div_print'));
              chart.draw(data, options);
            }

      $(window).resize(function(){
        drawChart1();
      });

    </script>

{{--<script>--}}
	{{--(function()--}}
    {{--{--}}
    	{{--// Get context with jQuery - using jQuery's .get() method.--}}
        {{--var ctx = $("#leadOfficeListChart").get(0).getContext("2d");--}}

    	{{--var data = [--}}
    		{{--@foreach($clients as $client)--}}
    		{{--{--}}
				{{--value: {{ $client['client_count'] }},--}}
				{{--color:"{{ $colours[$client['id']] }}",--}}
				{{--highlight: applySat("{{ $colours[$client['id']] }}", 0.3),--}}
				{{--label: "{{ $client['unit_name'] }}"--}}
			{{--},--}}
    		{{--@endforeach--}}
		{{--];--}}

		{{--var myPieChart = new Chart(ctx).Pie(data);--}}

{{--//		Change saturation of colour--}}
		{{--function applySat(hex, lum) {--}}

        	{{--// validate hex string--}}
        	{{--hex = String(hex).replace(/[^0-9a-f]/gi, '');--}}
        	{{--if (hex.length < 6) {--}}
        		{{--hex = hex[0]+hex[0]+hex[1]+hex[1]+hex[2]+hex[2];--}}
        	{{--}--}}
        	{{--lum = lum || 0;--}}

        	{{--// convert to decimal and change luminosity--}}
        	{{--var rgb = "#", c, i;--}}
        	{{--for (i = 0; i < 3; i++) {--}}
        		{{--c = parseInt(hex.substr(i*2,2), 16);--}}
        		{{--c = Math.round(Math.min(Math.max(0, c + (c * lum)), 255)).toString(16);--}}
        		{{--rgb += ("00"+c).substr(c.length);--}}
        	{{--}--}}

        	{{--return rgb;--}}
        {{--}--}}
    {{--})();--}}
{{--</script>--}}
@stop