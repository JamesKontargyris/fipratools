<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
		@include('layouts.partials.page-head')
    </head>
    <body>

		@include('layouts.partials.nav')

        <section class="content-container">

			<section id="content">
				<div class="row no-margin">
					<div class="col-12">
						<div id="page-header" class="section-{{ section_is() }}">
							<h2>@yield('page-header')</h2>
							<nav class="page-menu-nav">
								<ul class="small-font">
									<li><a class="primary" href="{{ url('reports/bysector') }}"><i class="fa fa-pie-chart"></i> By Sector</a></li>
									<li><a class="primary" href="{{ url('reports/byexpertise') }}"><i class="fa fa-pie-chart"></i> By Expertise Area</a></li>
									<li><a class="primary" href="{{ url('reports/byunit') }}"><i class="fa fa-pie-chart"></i> By Unit</a></li>
									<li><a class="primary" href="{{ url('reports/bytype') }}"><i class="fa fa-pie-chart"></i> By Type</a></li>
									<li><a class="primary" href="{{ url('reports/byservice') }}"><i class="fa fa-pie-chart"></i> By Service</a></li>
								</ul>
								<ul class="small-font">
									<li><a class="print-button secondary" href="#"><i class="fa fa-print pdf-export-button"></i> Print</a></li>
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

		@include('layouts.partials.footer')

	@include('layouts.partials.scripts')

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