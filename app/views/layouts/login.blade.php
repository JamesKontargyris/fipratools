<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
		@include('layouts.partials.page-head')
    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

		<section class="content-container">
			<div class="row">
				<div class="col-12">
					<header>
						<div id="logo">
							<img src="{{ asset('img/fipra_logo.png') }}" alt="Fipra - Professional Public Affairs in More Than 50 Countries">
						</div>
						<div id="page-title">
							<h1>{{ display_page_title() }}</h1>
						</div>
					</header>
				</div>
			</div>

			<section id="content">

				@yield('content')

			</section>

		</section>

		@include('layouts.partials.scripts')

    </body>
</html>