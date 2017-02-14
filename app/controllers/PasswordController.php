<?php

use Laracasts\Flash\Flash;
use Laracasts\Validation\FormValidationException;
use Leadofficelist\Eventlogs\EventLog;
use Leadofficelist\Exceptions\LoginFailedException;
use Leadofficelist\Forms\Login as LoginForm;
use Leadofficelist\Forms\PasswordChange;
use Leadofficelist\Forms\PasswordReset;
use Rych\Random\Random;

class PasswordController extends \BaseController
{
	private $passwordreset;
	private $passwordchange;

	function __construct(PasswordReset $passwordreset, PasswordChange $passwordchange)
	{
		$this->passwordreset = $passwordreset;
		$this->passwordchange = $passwordchange;

		View::share('user', Auth::user());
	}

	public function getIndex() {
		return Redirect::to('/');
	}

	public function getReset()
	{
		if( ! Auth::check())
		{
			return View::make('password.forgotform')->with('page_title', 'Reset your password');
		}
		else
		{
			return Redirect::to('/');
		}
	}

	public function postReset()
	{
		$input = Input::all();
		$this->passwordreset->validate($input);
		$data = [];

//        Does the user exist with a Fipriot account?
		if($user = $this->userExists($input['email']))
		{
//            Generate a new password
			$data['new_password'] = $this->generatePassword(10);
			$data['name'] = $user->first_name;
			$data['email'] = $input['email'];

//            Send the email
			Mail::queue('emails.password.reset', $data, function($message) use ($data) {
				$message->to($data['email'], $data['name'])->subject('Fipra Portal password reset');
			});

			$user->password = Hash::make($data['new_password']);
			$user->changed_password = 0;
			$user->save();

			Flash::overlay('Password has been reset successfully. Please check your email.', 'message');
			return Redirect::to('/login');
		}
		else
		{
			return Redirect::back()->withErrors(['User does not exist.']);
		}
	}

	/**
	 * Allow the user to change their password
	 *
	 * @return mixed
	 */
	public function getChange()
	{
		$user = Auth::user();
		// Temp password used for changing the password
		Session::put('temp_pass', $user->password);
		return View::make('password.change')->with(['page_title' => 'Change your password', 'pass' => Session::get('temp_pass')]);
	}

	public function postChange()
	{
		$input = Input::all();
		// Does the temporary password match the one in the DB?
		if(Hash::check(trim($input['current_password']), Session::get('temp_pass'))) {
			$this->passwordchange->validate($input);
		} else {
			throw new FormValidationException('Validation failed', ['Your current password is incorrect.']);
		}

		$user = Auth::user();
		$user->password = $input['new_password'];
		$user->changed_password = 1;
		$user->save();
//        Remove the temporary password from the session
		Session::forget('temp_pass');
		Flash::overlay('Password updated successfully. Please use your new password next time you login.', 'message');

		return Redirect::to('/list');
	}


	protected function userExists($email)
	{
		return User::where('email', '=', $email)->first();
	}

	/**
	 * Generate a new random string password
	 *
	 * @param $length
	 * @return string
	 */
	protected function generatePassword($length)
	{
		$random = new Random;
		return $random->getRandomString($length);
	}
}