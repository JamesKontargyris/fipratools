<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
		@include('layouts.partials.page-head')
    </head>
    <body class="login">
        <!--[if lt IE 7]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

		<div class="login-container">
			<div class="login-form">
				<div class="login-logo clearfix">
					<span class="login-title">FIPRA Tools</span>
					@if(is_request('login'))<div class="login-heading">Login</div>@endif
				</div>


				<div class="login-body">
					@yield('content')
				</div>

			</div>

			<div class="login-footer">
				&copy; Fipra <?php echo date("Y") ?> | <a href="http://fipra.com" target="_blank">fipra.com</a>
			</div>
		</div>

		@include('layouts.partials.scripts')

    </body>
</html>