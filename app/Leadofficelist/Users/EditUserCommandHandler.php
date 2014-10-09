<?php namespace Leadofficelist\Users;

use Laracasts\Commander\CommandHandler;
use Laracasts\Commander\Events\DispatchableTrait;

class EditUserCommandHandler implements CommandHandler {

	use DispatchableTrait;

	private $user;

	function __construct(User $user) {

		$this->user = $user;

	}

	/**
	 * Handle the command
	 *
	 * @param $command
	 *
	 * @return mixed
	 */
	public function handle($command) {

		$this->user->edit($command);

		return $this->user;
	}
}