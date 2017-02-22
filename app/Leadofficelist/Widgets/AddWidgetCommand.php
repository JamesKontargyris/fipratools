<?php namespace Leadofficelist\Widgets;

class AddWidgetCommand {
	public $name;
	public $slug;
	public $content;

	function __construct( $name, $slug, $content ) {
		$this->name = trim($name);
		$this->slug = trim($slug);
		$this->content = trim($content);
	}


}