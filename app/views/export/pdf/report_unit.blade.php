@extends('......layouts.pdf_report')

@section('content')
<div id="chart_div_print" class="chart-print"></div>

<table class="index-table">
	<thead>
		<tr>
			<td class="content-center"><i class="fa fa-paint-brush"></i></td>
			<td>Unit Name</td>
			<td>Clients</td>
			<td class="content-center">&percnt;</td>
		</tr>
		<tr>
			<td colspan="4" class="sub-header">Active clients: {{ $total_clients }}</td>
		</tr>
	</thead>
	<tbody>
		@foreach($clients as $client)
			<tr>
				<td class="actions content-center"><i class="fa fa-square fa-lg" style="color:{{ $colours[$client['id']] }}"></i></td>
				<td>{{ $client['unit_name'] }}</td>
				<td>{{ $client['client_count'] }}</td>
				<td>{{ $client['percentage'] }}&percnt;</td>
			</tr>
		@endforeach
	</tbody>
</table>
@stop

@section('chart-script')
<script type="text/javascript">

      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart1);
      function drawChart1() {
		  var data = google.visualization.arrayToDataTable([
			['Unit', 'Clients'],
			@foreach($clients as $client)
				['{{ $client['unit_short_name'] }}', {{ $client['client_count'] }}],
			@endforeach

		  ]);

        var optionsPrint = {
		  legend: 'none',
		  pieSliceText: 'label',
		  pieSliceTextStyle: {color: 'white', fontSize: 9},
		  chartArea:{left:0,top:0,width:'100%',height:'100%'},
		  colors: colours
		};

		  var chartDiv = document.getElementById('chart_div_print');
		  var chartPrint = new google.visualization.PieChart(chartDiv);

		  // Wait for the chart to finish drawing before calling the getImageURI() method.
		  google.visualization.events.addListener(chartPrint, 'ready', function () {
			chartDiv.innerHTML = '<img src="' + chartPrint.getImageURI() + '">';
			console.log(chartDiv.innerHTML);
		  });

		  chartPrint.draw(data, optionsPrint);
	  }
</script>
@stop