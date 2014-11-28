<?php namespace Leadofficelist\Clients;

use Auth;
use Laracasts\Commander\CommandHandler;
use Laracasts\Commander\Events\DispatchableTrait;
use Leadofficelist\Client_archives\ClientArchive;
use Leadofficelist\Eventlogs\EventLog;
use Leadofficelist\Units\Unit;

class EditClientStatusCommandHandler implements CommandHandler {

	use DispatchableTrait;

	private $client;
	private $client_archive;

	function __construct(Client $client, ClientArchive $client_archive) {

		$this->client = $client;
		$this->client_archive = $client_archive;
	}

	/**
	 * Handle the command
	 *
	 * @param $command
	 *
	 * @return mixed
	 */
	public function handle($command) {

		foreach($command->clients as $id => $status)
		{
			//Ensure both values are integers
			$id = (int) $id;
			$status = (int) $status;
			$status_text = ($status == 1) ? 'active' : 'dormant';

			//Run the updateStatus method on ClientController
			if($this->client->updateStatus($id, $status))
			{
				//	If updateStatus returned true, the status was updated
				//	Add a client archive record to reflect this change
				$client = $this->client->where('id', '=', $id)->first();
				$user = Auth::user();

				$data = new ClientArchive;
				$data->client_id = $id;
				$data->date = date('Y-m-d');
				$data->unit = $client->unit()->pluck('name');
				$data->account_director = $client->account_director()->pluck('first_name') . ' ' . $client->account_director()->pluck('last_name');
				$data->comment = 'Client became ' . $status_text;
				$this->client_archive->add($data);
				//Add an eventlog entry to indicate the status change
				EventLog::add('Client status changed: ' . $client->name . ' is now ' . $status_text, $user->getFullName(), Unit::find($client->unit_id)->name, 'info');
			}
		}

		return true;
	}
}