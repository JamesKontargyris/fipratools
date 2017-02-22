<?php namespace Leadofficelist\ServiceProviders;

use Illuminate\Support\ServiceProvider;
use Leadofficelist\Validation\CustomValidator;
use Validator;

class CustomValidationServiceProvider extends ServiceProvider {

	public function register() {}

	public function boot() {
		/*Validator::resolver(function($translator, $data, $rules, $messages)
		{
			return new CustomValidator($translator, $data, $rules, $messages);
		});*/
	}

}	//end of class