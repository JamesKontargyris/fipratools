<?php namespace Leadofficelist\Users;

use Laracasts\Commander\CommandHandler;
use Laracasts\Commander\Events\DispatchableTrait;

class AddUserCommandHandler implements CommandHandler {

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

		$this->user->add($command);
		$this->user->attachRole($command->role_id);
		if($command->send_email)
		{
			//$this->dispatchEventsFor($this->user);
		}

		return $this->user;
	}
}