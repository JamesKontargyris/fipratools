<?php namespace Leadofficelist\Client_archives;

use Laracasts\Commander\CommandHandler;
use Laracasts\Commander\Events\DispatchableTrait;

class EditClientArchiveCommandHandler implements CommandHandler {

	use DispatchableTrait;

	private $client_archive;

	function __construct(ClientArchive $client_archive) {

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

		$this->client_archive->edit($command);

		return $this->client_archive;
	}
}