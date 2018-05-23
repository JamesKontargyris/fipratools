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

        <section class="content-container" style="display: block; height: 100%; width: 100%;">

			<section id="content" style="display: block; height: 80%; width: 100%; margin:0 auto;">

				@yield('content')

			</section>

        </section>

        @include('layouts.partials.footer')

		@include('layouts.partials.scripts')

    </body>
</html>