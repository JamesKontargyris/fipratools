<?php

/*
|--------------------------------------------------------------------------
| Register The Laravel Class Loader
|--------------------------------------------------------------------------
|
| In addition to using Composer, you may use the Laravel class loader to
| load your controllers and models. This is useful for keeping all of
| your classes in the "global" namespace without Composer updating.
|
*/

use Laracasts\Flash\Flash;
use Laracasts\Validation\FormValidationException;
use Leadofficelist\Exceptions\CannotEditException;
use Leadofficelist\Exceptions\LoginFailedException;
use Leadofficelist\Exceptions\PermissionDeniedException;
use Leadofficelist\Exceptions\ResourceNotFoundException;

ClassLoader::addDirectories( array(

	app_path() . '/commands',
	app_path() . '/controllers',
	app_path() . '/models',
	app_path() . '/database/seeds',

) );

/*
|--------------------------------------------------------------------------
| Application Error Logger
|--------------------------------------------------------------------------
|
| Here we will configure the error logger setup for the application which
| is built on top of the wonderful Monolog library. By default we will
| build a basic log file setup which creates a single file for logs.
|
*/

Log::useFiles( storage_path() . '/logs/laravel.log' );

/*
|--------------------------------------------------------------------------
| Application Error Handler
|--------------------------------------------------------------------------
|
| Here you may handle any errors that occur in your application, including
| logging them or displaying custom views for specific errors. You may
| even register several error handlers to handle different types of
| exceptions. If nothing is returned, the default error view is
| shown, which includes a detailed stack trace during debug.
|
*/

App::error( function ( Exception $exception, $code ) {
	Log::error( $exception );
} );

App::error( function ( FormValidationException $exception ) {
	Log::error( $exception );

	return Redirect::back()->withInput()->withErrors( $exception->getErrors() );
} );

App::error( function ( PermissionDeniedException $exception ) {
	Log::error( $exception );
	Flash::error( 'Sorry - you do not have access to that page.' );

	if ( $exception->getKey() ) {
		return Redirect::route( $exception->getKey() . '.index' );
	} else {
		if ( section_is() == 'case' ) {
			return Redirect::route( 'caselist.index' );

		} else {
			return Redirect::route( 'list.index' );
		}
	}
} );

App::error( function ( LoginFailedException $exception ) {
	Log::error( $exception );

	return Redirect::back()->withInput()->withErrors( 'Incorrect login details entered. Please try again.' );
} );

App::error( function ( ResourceNotFoundException $exception ) {
	Log::error( $exception );
	Flash::error( $exception->getErrorMessage() );

	return Redirect::route( $exception->getResourceKey() . '.index' );
} );

App::error( function ( CannotEditException $exception ) {
	Log::error( $exception );
	Flash::error( $exception->getErrorMessage() );

	return Redirect::route( $exception->getResourceKey() . '.index' );
} );

/*
|--------------------------------------------------------------------------
| Maintenance Mode Handler
|--------------------------------------------------------------------------
|
| The "down" Artisan command gives you the ability to put an application
| into maintenance mode. Here, you will define what is displayed back
| to the user if maintenance mode is in effect for the application.
|
*/

App::down( function () {
	return Response::make( "Be right back!", 503 );
} );

/*
|--------------------------------------------------------------------------
| Require The Filters File
|--------------------------------------------------------------------------
|
| Next we will load the filters file for the application. This gives us
| a nice separate location to store our route and application filter
| definitions instead of putting them all in the main routes file.
|
*/

require app_path() . '/filters.php';

/*
|--------------------------------------------------------------------------
| Require The Helpers File
|--------------------------------------------------------------------------
|
| Next we will load the helpers file for the application.
|
*/

require app_path() . '/helpers.php';

/*
|--------------------------------------------------------------------------
| Custom validation rules
|--------------------------------------------------------------------------
|
| Register custom validation rules.
|
*/
Validator::resolver(function($translator, $data, $rules, $messages)
{
	return new Leadofficelist\Validation\CustomValidator($translator, $data, $rules, $messages);
});
