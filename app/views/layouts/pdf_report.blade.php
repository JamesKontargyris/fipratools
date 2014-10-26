<!DOCTYPE html>
<html>
<head>
    <title>{{ $heading1 }}</title>
    <link href="http://netdna.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.css" rel="stylesheet">
    <style>
    	body {
    		margin:0;
    		padding:0;
    	}
    	h1, h2, h3, h4, h5 {
    		margin:0;
    		padding:0 0 5px 0;
    	}
    	h1 {
    		font-size:18px;
    	}
    	h2 {
    		font-size:14px;
    	}
    	h3 {
    		font-size:12px;
    	}
    	h4 {
    		font-size:11px;
    	}
    	h5 {
    		font-size:10px;
    	}

    	.chart-print {
    		width:600px; height:600px; display:block; margin:0 auto;
    	}

		.index-table {
		margin-top:10px;
          font-size: 10px;
          width:100%;
          border-bottom:1px solid #dee0e6;
          }
          /* line 321, ../../app/assets/sass/_modules.scss */
          .index-table tr > td {
            border-left: 1px solid #e6e6e6;
            vertical-align: middle; }
            /* line 324, ../../app/assets/sass/_modules.scss */
            .index-table tr > td.content-center {
              text-align: center; }
            /* line 327, ../../app/assets/sass/_modules.scss */
            .index-table tr > td.content-right {
              text-align: right; }
            /* line 330, ../../app/assets/sass/_modules.scss */
            .index-table tr > td:last-child {
              border-right: 1px solid #e6e6e6; }
            /* line 333, ../../app/assets/sass/_modules.scss */
          /* line 364, ../../app/assets/sass/_modules.scss */
          .index-table thead tr > td {
            background-color: #5F697F;
            color: white;
            border-collapse: separate;
            text-transform: uppercase;
            font-weight: bold;
            padding: 5px 15px; }
            /* line 373, ../../app/assets/sass/_modules.scss */
            .index-table thead tr > td.sub-header {
              background-color: #dee0e6;
              color: #5F697F; }
          /* line 383, ../../app/assets/sass/_modules.scss */
          .index-table tbody tr > td {
            padding: 5px 15px; }
            /* line 385, ../../app/assets/sass/_modules.scss */
            .index-table tbody tr > td.actions, .index-table tbody tr > td.archive-count, .index-table tbody tr > td.client-links {
              padding: 5px;
              width: 1%;
              white-space: nowrap; }
            /* line 392, ../../app/assets/sass/_modules.scss */
            .index-table tbody tr > td.archive-count, .index-table tbody tr > td.client-links {
              padding-right: 10px;
              border-left: 0;
              color: #5F697F; }
            /* line 398, ../../app/assets/sass/_modules.scss */
            .index-table tbody tr > td .event-log-icon {
              padding-right: 10px; }
          /* line 402, ../../app/assets/sass/_modules.scss */
          .index-table tbody tr:nth-child(even) {
            background-color: #f2f2f2; }
          /* line 405, ../../app/assets/sass/_modules.scss */
          .index-table tbody tr:last-child {
            border-bottom: 1px solid #e6e6e6; }
          /* line 410, ../../app/assets/sass/_modules.scss */
          .index-table button {
            line-height: 1;
            }
          /* line 414, ../../app/assets/sass/_modules.scss */
          .index-table .status-active {
            background-color: #d5ff95;
            color: green;
            border: 1px solid white; }
          /* line 419, ../../app/assets/sass/_modules.scss */
          .index-table .status-dormant {
            background-color: white;
            color: #d3d3d3;
            border: 1px solid white; }
    </style>
</head>
<body>
	<div style="display:block; text-align: center; padding-bottom:10px">
    	<h1 style="display:inline-block; margin:0 auto;">{{ $heading1 }}</h1>
    </div>

    @yield('content')

    <script type="text/javascript" src="https://www.google.com/jsapi"></script>

	<script>
		{{--Colours used by the charts--}}
		var colours = [
			'#00257f', '#14b1cc', '#8dcc29', '#6f5ce5', '#007770', '#14990f', '#5F697F', '#cc0a12', '#cc00b0', '#cc7300', '#e5c75c',
			'#3355cc', '#c6e694', '#a0e9f6', '#b7aef2', '#80bbb8', '#8acc87', '#afb4bf', '#e68589', '#e680d8', '#e6b980', '#f2e3ae',
			'#99aacc', '#385110', '#1a545e', '#2c245b', '#002f2c', '#083d06', '#262a32', '#510407', '#510046', '#512e00', '#5b4f24',
			'#00257f', '#14b1cc', '#8dcc29', '#6f5ce5', '#007770', '#14990f', '#5F697F', '#cc0a12', '#cc00b0', '#cc7300', '#e5c75c',
			'#3355cc', '#c6e694', '#a0e9f6', '#b7aef2', '#80bbb8', '#8acc87', '#afb4bf', '#e68589', '#e680d8', '#e6b980', '#f2e3ae',
			'#99aacc', '#385110', '#1a545e', '#2c245b', '#002f2c', '#083d06', '#262a32', '#510407', '#510046', '#512e00', '#5b4f24',
			'#00257f', '#14b1cc', '#8dcc29', '#6f5ce5', '#007770', '#14990f', '#5F697F', '#cc0a12', '#cc00b0', '#cc7300', '#e5c75c',
			'#3355cc', '#c6e694', '#a0e9f6', '#b7aef2', '#80bbb8', '#8acc87', '#afb4bf', '#e68589', '#e680d8', '#e6b980', '#f2e3ae',
			'#99aacc', '#385110', '#1a545e', '#2c245b', '#002f2c', '#083d06', '#262a32', '#510407', '#510046', '#512e00', '#5b4f24',
		];
	</script>

	@yield('chart-script')
</body>
</html>