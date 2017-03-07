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
					<img src="img/fipra-logo-login.png" alt="Fipra">
					<span class="login-title">Tools</span>
					<div class="login-heading">Login</div>
				</div>


				<div class="login-body">
					@include ('layouts.partials.messages')

					<div class="login-email-form">
						{{ Form::open(['url' => 'login', 'method' => 'POST']) }}
						{{ Form::label('email', 'Your Fipra email address:') }}
						{{ Form::text('email', Input::old('email'), ['placeholder' => 'your.name@fipra.com']) }}
						{{ Form::label('password', 'Password:') }}
						{{ Form::password('password', ['placeholder' => 'Password']) }}
						{{ Form::submit('Login', ['class' => 'secondary']) }}
						{{ Form::close() }}
					</div>
				</div>

			</div>
		</div>

		<div class="login-footer">
			&copy; Fipra <?php echo date("Y") ?> | <a href="http://fipra.com" target="_blank">fipra.com</a>
		</div>
		@include('layouts.partials.scripts')

    </body>
</html>