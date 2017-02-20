<?php namespace Leadofficelist\Knowledge_surveys;

use Laracasts\Commander\CommandHandler;
use Laracasts\Commander\Events\DispatchableTrait;
use Leadofficelist\Knowledge_languages\KnowledgeLanguage;

class UpdateLanguageInfoCommandHandler implements CommandHandler {

	use DispatchableTrait;

	public $knowledge_language;

	function __construct( KnowledgeLanguage $knowledge_language ) {

		$this->knowledge_language = $knowledge_language;
	}

	/**
	 * Handle the command
	 *
	 * @param $command
	 *
	 * @return mixed
	 */
	public function handle( $command ) {

		$this->knowledge_language->updateKnowledgeLanguageInfo( $command );

		return $this->knowledge_language;
	}
}