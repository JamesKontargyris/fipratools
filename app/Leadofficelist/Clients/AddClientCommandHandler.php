<?php namespace Leadofficelist\Clients;

use Laracasts\Commander\CommandHandler;
use Laracasts\Commander\Events\DispatchableTrait;

class AddClientCommandHandler implements CommandHandler {

	use DispatchableTrait;

	private $client;

	function __construct(Client $client) {

		$this->client = $client;
	}

	/**
	 * Handle the command
	 *
	 * @param $command
	 *
	 * @return mixed
	 */
	public function handle($command) {

		$this->client->add($command);

		return $this->client;
	}
}