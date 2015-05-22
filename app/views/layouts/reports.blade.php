<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Fipra Lead Office List {{ isset($page_title) ? ' :: ' . $page_title : '' }}</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link href="//netdna.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.css" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
        <!--jQuery-->
       	<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.0/themes/smoothness/jquery-ui.css" />
       	<link rel="stylesheet" href="{{ asset('css/jquery.modal.css') }}" type="text/css" media="screen" />

        @include('layouts.partials.favicon')
    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

		<section class="mobile-user-details-container">
			<div class="row">
				<div class="col-12">
					Logged in as <strong>{{ $user_full_name }}</strong><br/>
					{{ $user_unit }} &bull; {{ $user_role }}<br/><a href="/logout" class="primary">Logout</a>
				</div>
			</div>
		</section>

		<section class="mobile-site-nav-container">
			<div class="row">
				<div class="col-12">
					@include('layouts.partials.site_nav')
				</div>
			</div>
		</section>

		<section id="site-nav-container">
			<nav id="site-nav" class="container">
				<div class="mobile">
					<div class="row no-margin">
						<div class="col-8 logo">
							<img src="{{ asset('img/fipra_logo_s.png') }}" alt="Fipra" style="vertical-align:middle"/> <span>Lead Office List</span>
						</div>
						<div class="col-4 last">
							<ul class="mobile-nav-buttons">
								<li><a href="#" class="mobile-user-details-but"><i class="fa fa-2x fa-user"></i></a></li>
								<li><a href="#" class="mobile-site-nav-but"><i class="fa fa-2x fa-navicon"></i></a></li>
							</ul>
						</div>
					</div>
				</div>
				<div class="desktop">
					<div class="row">
					    <div class="col-8 logo">
					    	<img src="{{ asset('img/fipra_logo.png') }}" alt="Fipra" style="vertical-align:middle"/> <span>Lead Office List</span>
					    </div>
						<div class="col-4 last user-details">
							Logged in as <strong>{{ $user_full_name }}</strong><br/>
							<i class="fa fa-sitemap"></i> {{ $user_unit }} &nbsp;&nbsp;<i class="fa fa-user"></i> {{ $user_role }} &nbsp;&nbsp;<a href="/logout">Logout</a>
						</div>
					</div>
					<div class="col-12">
						@include('layouts.partials.site_nav')
					</div>
				</div>
			</nav>
		</section>

        <section class="content-container">

			<section id="content">
				<div class="row">
					<div class="col-12">
						<div id="page-header">
							<h2>@yield('page-header')</h2>
							<nav class="page-menu-nav">
								<ul class="small-font">
									<li><a class="secondary" href="{{ url('reports/bysector') }}"><i class="fa fa-pie-chart"></i> By Sector</a></li>
									<li><a class="secondary" href="{{ url('reports/byunit') }}"><i class="fa fa-pie-chart"></i> By Unit</a></li>
									<li><a class="secondary" href="{{ url('reports/bytype') }}"><i class="fa fa-pie-chart"></i> By Type</a></li>
									<li><a class="secondary" href="{{ url('reports/byservice') }}"><i class="fa fa-pie-chart"></i> By Service</a></li>
								</ul>
								<ul class="small-font">
									<li><a href="/reports/export?filetype=pdf&report_type={{ $report_type }}" class="grey-but pdf-export-button"><i class="fa fa-file-pdf-o"></i> Export to PDF</a></li>
									<li><a class="print-button grey-but" href="#"><i class="fa fa-print pdf-export-button"></i> Print</a></li>
									@yield('export-nav')
								</ul>
							</nav>
							<a href="#" class="page-menu-icon-s">
								Actions <i class="fa fa-lg fa-caret-down"></i>
							</a>
						</div>
					</div>
				</div>

				@yield('content')

			</section>

        </section>

        <div class="container">
            <footer>
                <p>&copy; Fipra <?php echo date("Y"); ?>. All Rights Reserved.<br><a href="http://fipra.com/other~3/code_of_conduct~7/" target="_blank">Code of conduct</a></p>
            </footer>
        </div>

	<!--jQuery-->
	{{--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>--}}
	<script src="{{ asset('js/jquery.min.js') }}"></script>
	{{--<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.0/jquery-ui.min.js"></script>--}}
	<script src="{{ asset('js/jquery-ui.min.js') }}"></script>
	{{--jQuery Modal plugin--}}
	<script src="{{ asset('js/jquery.modal.min.js') }}" type="text/javascript" charset="utf-8"></script>
	{{--Chart.js--}}
	<script src="{{ asset('js/Chart.min.js') }}"></script>
	{{--Site JS--}}
	<script src="{{ asset('js/site.js?141001') }}"></script>
	<script src="{{ asset('js/reports.js?141021') }}"></script>
	<!--Load the AJAX API-->
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