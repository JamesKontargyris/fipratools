<?php namespace Leadofficelist\Knowledge_surveys;

use Illuminate\Support\Facades\Auth;

class UpdateUserInfoCommand {

	public $dob_day;
	public $dob_month;
	public $dob_year;

	function __construct( $dob_day, $dob_month, $dob_year ) {
		$this->dob_day = $dob_day;
		$this->dob_month = $dob_month;
		$this->dob_year = $dob_year;
		$this->id = Auth::user()->id;
	}


}