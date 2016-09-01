<?php namespace Leadofficelist\Validation;

use Illuminate\Validation\Validator;

class CustomValidator extends Validator
{
	/**
	 * Make sure the current and new passwords match
	 * when a user is changing their password
	 *
	 * @param $attribute
	 * @param $value
	 * @param $parameters
	 * @return mixed
	 */
	public function validateTempPasswordMatch($attribute, $value, $parameters)
	{
		$user_entered_current_password = $value;
		$actual_hashed_current_password = array_get($this->data, $parameters[0]);

		return \Hash::check($user_entered_current_password, $actual_hashed_current_password);
	}
}