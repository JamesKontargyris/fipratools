<?php namespace Leadofficelist\Cases;

use Leadofficelist\Account_directors\AccountDirector;
use Leadofficelist\Clients\Client;
use Leadofficelist\Units\Unit;
use Leadofficelist\Users\User;

class CaseStudy extends \BaseModel {

	protected $table = 'cases';
	protected $fillable = [
		'name',
		'challenges',
		'strategy',
		'result',
		'unit_id',
		'user_id',
		'account_director_id',
		'sector_id',
		'product_id'
	];

	public function user() {
		return $this->hasOne( '\Leadofficelist\Users\User', 'id', 'user_id' );
	}

	public function unit() {
		return $this->hasOne( '\Leadofficelist\Units\Unit', 'id', 'unit_id' );
	}

	public function sector() {
		return $this->hasOne( '\Leadofficelist\Sectors\Sector', 'id', 'sector_id' );
	}

	public function account_director() {
		return $this->hasOne( '\Leadofficelist\Account_directors\AccountDirector', 'id', 'account_director_id' );
	}

	public function client() {
		return $this->belongsTo( '\Leadofficelist\Clients\Client', 'client_id', 'id' );
	}

	public function add( $case ) {
		$this->status              = $case->status;
		$this->name                = $case->name;
		$this->year                = $case->year;
		$this->challenges          = $case->challenges;
		$this->strategy            = $case->strategy;
		$this->result              = $case->result;
		$this->unit_id             = $case->unit_id;
		$this->user_id             = $case->user_id;
		$this->account_director_id = $case->account_director_id;
		$this->client_id              = $case->client_id;
		$this->sector_id           = serialize( $case->sector_id );
		$this->product_id          = serialize( $case->product_id );

		// Add text entries in case unit / user / AD etc. is deleted
		$this->client = Client::find($this->client_id)->name;
		$this->unit_name = Unit::find($this->unit_id)->name;
		$this->user_name = User::find($this->user_id)->first_name . ' ' . User::find($this->user_id)->last_name;
		$this->account_director_name = AccountDirector::find($this->account_director_id)->first_name . ' ' . AccountDirector::find($this->account_director_id)->last_name;

		$this->save();

		return $this;
	}

	public function edit( $case ) {
		$update_case                      = $this->find( $case->id );
		$update_case->status              = $case->status;
		$update_case->name                = $case->name;
		$update_case->year                = $case->year;
		$update_case->challenges          = $case->challenges;
		$update_case->strategy            = $case->strategy;
		$update_case->result              = $case->result;
		$update_case->unit_id             = $case->unit_id;
		$update_case->user_id             = $case->user_id;
		$update_case->account_director_id = $case->account_director_id;
		$update_case->client_id             = $case->client_id;
		$update_case->sector_id           = serialize( $case->sector_id );
		$update_case->product_id          = serialize( $case->product_id );

		// Add text entries in case unit / user / AD etc. is deleted
		$update_case->client = Client::find($update_case->client_id)->name;
		$update_case->unit_name = Unit::find($update_case->unit_id)->name;
		$update_case->user_name = User::find($update_case->user_id)->first_name . ' ' . User::find($update_case->user_id)->last_name;
		$update_case->account_director_name = AccountDirector::find($update_case->account_director_id)->first_name . ' ' . AccountDirector::find($update_case->account_director_id)->last_name;

		$update_case->save();

		return $update_case;
	}

	public static function change_status( $case_id, $status = 1 ) {
		$case         = Static::find( $case_id );
		$case->status = $status;

		return ( $case->save() );
	}

	public static function getYearsForFormSelect( $blank_entry = false, $blank_message = 'Please select...', $prefix = "" ) {
		$years = [];
		//Remove whitespace from $prefix and add a space on the end, so there is a space
		//between the prefix and the unit name
		$prefix = trim( $prefix ) . ' ';
		//If $blank_entry == true, add a blank "Please select..." option
		if ( $blank_entry ) {
			$years[''] = $blank_message;
		}

		// Get all years and delete duplicates, then sort into descending order
		$unique_years = array_unique( CaseStudy::all()->lists( 'year' ) );
		arsort( $unique_years );

		foreach ( $unique_years as $year ) {
			$years[ $year ] = $prefix . $year;
		}


		if ( $blank_entry && count( $years ) == 1 ) {
			return false;
		} elseif ( ! $blank_entry && count( $years ) == 0 ) {
			return false;
		} else {
			return $years;
		}
	}
}