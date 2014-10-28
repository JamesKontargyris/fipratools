@extends('layouts.reports')

@section('page-header')
Active Clients by Type
@stop

@section('page-nav')
@stop

@section('content')
<div class="row">
	<div class="col-7 border-box">
		<div id="chart_div" class="chart"></div>
		<div id="chart_div_print" class="chart-print"></div>
	</div>
	<div class="col-5 last">

		<table class="index-table">
			<thead>
				<tr>
					<td class="content-center"><i class="fa fa-paint-brush"></i></td>
					<td>Type</td>
					<td>Clients</td>
					<td class="hide-m">&percnt;</td>
				</tr>
				<tr>
					<td colspan="4" class="sub-header">Active clients: {{ $total_clients }}</td>
				</tr>
			</thead>
			<tbody>
				@foreach($clients as $client)
					<tr>
						<td class="actions content-center"><i class="fa fa-square fa-lg" style="color:{{ $colours[$client['id']] }}"></i></td>
						<td>{{ $client['type_name'] }}</td>
						<td>{{ $client['client_count'] }}</td>
						<td class="hide-m">{{ $client['percentage'] }}&percnt;</td>
					</tr>
				@endforeach
			</tbody>
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
          ['Type', 'Clients'],
          @foreach($clients as $client)
          	['{{ $client['type_short_name'] }}', {{ $client['client_count'] }}],
          @endforeach

        ]);

        var options = {
          legend: 'none',
          pieSliceText: 'label',
          pieStartAngle: -60,
          pieSliceTextStyle: {color: 'white', fontSize: 14},
          chartArea:{left:10,top:10,width:'95%',height:'95%'},
          colors: colours
        };
        var optionsPrint = {
		  legend: 'none',
		  pieSliceText: 'label',
		  pieStartAngle: -60,
		  pieSliceTextStyle: {color: 'white', fontSize: 10},
		  chartArea:{left:0,top:0,width:'100%',height:'100%'},
		  colors: colours
		};

		  var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
		  chart.draw(data, options);

		  var chartPrint = new google.visualization.PieChart(document.getElementById('chart_div_print'));
		  chartPrint.draw(data, optionsPrint);

	  }
      $(window).resize(function(){
        drawChart1();
      });

    </script>

@stop