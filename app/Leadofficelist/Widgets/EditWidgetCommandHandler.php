<?php namespace Leadofficelist\Widgets;

use Laracasts\Commander\CommandHandler;
use Laracasts\Commander\Events\DispatchableTrait;

class EditWidgetCommandHandler implements CommandHandler {

	use DispatchableTrait;

	private $widget;

	function __construct(Widget $widget) {

		$this->widget = $widget;

	}

	/**
	 * Handle the command
	 *
	 * @param $command
	 *
	 * @return mixed
	 */
	public function handle($command) {

		$this->widget->edit($command);

		return $this->widget;
	}
}