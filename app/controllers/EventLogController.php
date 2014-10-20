<?php

use Laracasts\Flash\Flash;
use Leadofficelist\Eventlogs\EventLog;

class EventLogController extends \BaseController
{
	function __construct()
	{
		parent::__construct();
		$this->check_role('Administrator');
	}

	public $resource_key = 'eventlog';

	public function getIndex()
	{
		$items = EventLog::orderBy('created_at', 'DESC')->paginate(30);
		return View::make('eventlogs.index')->with(compact('items'));
	}

	public function postDelete()
	{
		EventLog::destroy(Input::get('log_id'));
		Flash::overlay('Log entry deleted.', 'info');

		return Redirect::to('logs');
	}

	public function getTrash()
	{
		EventLog::truncate();
		Flash::overlay('Entry logs trashed.', 'info');

		return Redirect::to('logs');
	}
} 