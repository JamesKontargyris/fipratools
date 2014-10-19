<?php namespace Leadofficelist\Account_directors;

use Laracasts\Commander\CommandHandler;
use Laracasts\Commander\Events\DispatchableTrait;
use Leadofficelist\Sector_categories\Sector_category;

class EditAccountDirectorCommandHandler implements CommandHandler {

	use DispatchableTrait;

	private $account_director;

	function __construct(AccountDirector $account_director) {

		$this->account_director = $account_director;
	}

	/**
	 * Handle the command
	 *
	 * @param $command
	 *
	 * @return mixed
	 */
	public function handle($command) {

		$this->account_director->edit($command);

		return $this->account_director;
	}
}