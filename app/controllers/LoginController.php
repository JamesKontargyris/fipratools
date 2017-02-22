<?php

use Laracasts\Flash\Flash;
use Leadofficelist\Eventlogs\EventLog;
use Leadofficelist\Exceptions\LoginFailedException;
use Leadofficelist\Forms\Login as LoginForm;

class LoginController extends \BaseController
{
	private $loginForm;

	function __construct(LoginForm $loginForm)
	{
		$this->loginForm = $loginForm;
	}

	public function getIndex()
	{
		return View::make('login');
	}

	public function postIndex()
	{
		$input = Input::all();
		$this->loginForm->validate($input);

		if( ! Auth::attempt( ['email' => Input::get('email'), 'password' => Input::get('password')] ))
		{
			/*EventLog::add('Failed login attempt by ' . $input['email'], '-', '-', 'error');*/
			throw new LoginFailedException;
		}

		$user = Auth::user();

		// Has the user changed their password to something memorable?
		if( ! $user->changed_password )
		{
			// Temp password used for changing the password
			Session::put('temp_pass', $user->password);
			return Redirect::to('/password/change');
		}

		return Redirect::to('/');
	}

	public function logout()
	{
		//Destroy all session data
		Session::flush();
		//Log the user out
		Auth::logout();
		Flash::message('You have been logged out.');

		return Redirect::to('login');
	}



}