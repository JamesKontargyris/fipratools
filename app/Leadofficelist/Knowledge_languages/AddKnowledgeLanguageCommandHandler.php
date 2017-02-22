<?php namespace Leadofficelist\Knowledge_languages;

use Laracasts\Commander\CommandHandler;
use Laracasts\Commander\Events\DispatchableTrait;
use Location;

class AddKnowledgeLanguageCommandHandler implements CommandHandler {

	use DispatchableTrait;

	public $knowledge_language;

	function __construct( KnowledgeLanguage $knowledge_language) {

		$this->knowledge_language = $knowledge_language;
	}

	/**
	 * Handle the command
	 *
	 * @param $command
	 *
	 * @return mixed
	 */
	public function handle($command) {

		$this->knowledge_language->add($command);

		return $this->knowledge_language;
	}
}