<?php namespace Leadofficelist\Eventlogs;

class EventLog extends \BaseModel
{
	public $table = 'eventlogs';
	protected $fillable = [ 'event', 'user_name', 'unit_name', 'type' ];

	public static function add( $event_message, $user_name, $unit_name, $type = 'info' )
	{
		$event            = new EventLog;
		$event->event     = $event_message;
		$event->user_name = $user_name;
		$event->unit_name = $unit_name;
		$event->type      = $type;
		$event->save();

		return true;
	}
} 