<?php namespace Leadofficelist\Knowledge_surveys;

use Illuminate\Support\Facades\Auth;

class UpdateUserInfoCommand {

	public $dob_day;
	public $dob_month;
	public $dob_year;
	public $joined_fipra_day;
	public $joined_fipra_month;
	public $joined_fipra_year;
	public $total_fipra_working_time;
	public $other_network;
	public $formal_positions;

	function __construct( $dob_day, $dob_month, $dob_year, $joined_fipra_day, $joined_fipra_month, $joined_fipra_year, $total_fipra_working_time, $other_network, $formal_positions ) {
		$this->dob_day = $dob_day;
		$this->dob_month = $dob_month;
		$this->dob_year = $dob_year;
		$this->joined_fipra_day = $joined_fipra_day;
		$this->joined_fipra_month = $joined_fipra_month;
		$this->joined_fipra_year = $joined_fipra_year;
		$this->total_fipra_working_time = $total_fipra_working_time;
		$this->other_network = trim($other_network);
		$this->formal_positions = trim($formal_positions);
		$this->id = Auth::user()->id;
	}


}