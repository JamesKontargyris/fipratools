<!DOCTYPE html>
<html>
<head>
    <title>{{ $heading1 }}</title>
    <meta charset="utf-8">
    <style>
    	body {
    		font-family:Arial, sans-serif;
    		margin:0;
    		padding:0;
    	}
    	h1, h2, h3, h4, h5 {
    		margin:0;
    		padding:0 0 5px 0;
    	}
    	h1 {
    		font-size:18px;
    		color:#00257f;
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
    	.turquoise {
          color: #14b1cc !important;
        }
        .fa-asterisk {
        	font-weight: bold;
        	font-size:24px;
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
              border-left: 0 !important;
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
    @yield('content')
</body>
</html>