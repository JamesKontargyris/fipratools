<?php


use Laracasts\Commander\CommanderTrait;
use Leadofficelist\Clients\Client;
use Leadofficelist\Eventlogs\EventLog;
use Leadofficelist\Exceptions\PermissionDeniedException;

class StatusCheckController extends BaseController
{
	use CommanderTrait;

	protected $resource_key = 'statuscheck';

	function __construct()
	{
		parent::__construct();

		//	This controller is only accessible by users with "Head of Unit" status
		$this->check_role(['Head of Unit', 'Administrator']);
	}

	public function getIndex()
	{
		$clients = Client::where('unit_id', '=', $this->user->unit()->pluck('id'))->orderBy('name')->get();
		return View::make('status_check.checklist')->with(compact('clients'));
	}

	public function postIndex()
	{
		$this->execute( 'Leadofficelist\Clients\EditClientStatusCommand');
		Eventlog::add('Client status check completed', $this->user->first_name . ' ' . $this->user->last_name, $this->user->unit()->pluck('name'), 'info' );

		return View::make('status_check.success');
	}

} 