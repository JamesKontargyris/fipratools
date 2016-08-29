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
				<div class="row">
					<div class="col-12">
						<div id="page-header">
							<h2>@yield('page-header')</h2>
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

	@include('layouts.partials.scripts')

    </body>
</html>