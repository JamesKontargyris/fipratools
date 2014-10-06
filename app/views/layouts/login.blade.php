<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Fipra :: {{ display_page_title() }}</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link href="//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.css" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('css/style.min.css') }}">
        <!--jQuery-->
       	<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.0/themes/smoothness/jquery-ui.css" />
       	<link rel="stylesheet" href="{{ asset('css/jquery.modal.css') }}" type="text/css" media="screen" />

        <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
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

	<!--jQuery-->
	{{--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>--}}
	<script src="{{ asset('js/jquery.min.js') }}"></script>
	{{--<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.0/jquery-ui.min.js"></script>--}}
	<script src="{{ asset('js/jquery-ui.min.js') }}"></script>
	{{--jQuery Modal plugin--}}
	<script src="{{ asset('js/jquery.modal.min.js') }}" type="text/javascript" charset="utf-8"></script>
	{{--Site JS--}}
	<script src="{{ asset('js/site.js?141001') }}"></script>

    </body>
</html>