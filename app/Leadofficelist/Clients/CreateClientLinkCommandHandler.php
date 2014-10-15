<?php namespace Leadofficelist\Clients;

use Laracasts\Commander\CommandHandler;
use Laracasts\Commander\Events\DispatchableTrait;

class CreateClientLinkCommandHandler implements CommandHandler {

	use DispatchableTrait;

	private $clientLink;

	function __construct(ClientLink $clientLink) {

		$this->clientLink = $clientLink;
	}

	/**
	 * Handle the command
	 *
	 * @param $command
	 *
	 * @return mixed
	 */
	public function handle($command) {

		$this->clientLink->createLink($command);

		return $this->clientLink;
	}
}