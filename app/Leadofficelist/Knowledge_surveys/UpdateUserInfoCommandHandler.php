<?php namespace Leadofficelist\Knowledge_surveys;

use Laracasts\Commander\CommandHandler;
use Laracasts\Commander\Events\DispatchableTrait;
use Leadofficelist\Users\User;
use Location;

class UpdateUserInfoCommandHandler implements CommandHandler {

	use DispatchableTrait;

	private $user;

	function __construct( User $user ) {

		$this->user = $user;
	}

	/**
	 * Handle the command
	 *
	 * @param $command
	 *
	 * @return mixed
	 */
	public function handle( $command ) {

		$this->user->updateUserKnowledgeInfo( $command );

		return $this->user;
	}
}