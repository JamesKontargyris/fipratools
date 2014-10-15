<?php namespace Leadofficelist\Clients;

class ClientLink extends \BaseModel
{
	protected $fillable = [ 'client_id', 'unit_id' ];
	public $timestamps = false;

	public function client()
	{
		return $this->belongsTo( 'Leadofficelist\Clients\Client', 'client_id' );
	}

	public function unit()
	{
		return $this->belongsTo( 'Leadofficelist\Units\Unit', 'unit_id' );
	}

	public function createLink( $command )
	{
		//Save the first half of the link, linking client 1 to unit 2
		$link_1            = new static;
		$link_1->client_id = $command->client_1;
		$link_1->unit_id   = $command->unit_2;
		$link_1->save();
		//Save the other half of the link, linking client 2 to unit 1
		$link_2            = new static;
		$link_2->client_id = $command->client_2;
		$link_2->unit_id   = $command->unit_1;
		$link_2->save();
		//Add the id of each link to the other, so we can delete both
		//halves of the link when one half is deleted
		$link_1->link_to_id = $link_2->id;
		$link_1->save();
		$link_2->link_to_id = $link_1->id;
		$link_2->save();

		return [ $link_1, $link_2 ];
	}
}