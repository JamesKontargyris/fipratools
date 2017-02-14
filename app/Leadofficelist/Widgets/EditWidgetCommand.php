<?php namespace Leadofficelist\Widgets;

class EditWidgetCommand
{
	public $name;
	public $slug;
	public $content;

	function __construct( $name, $slug, $content, $id )
	{
		$this->name = trim($name);
		$this->slug = trim($slug);
		$this->content = trim($content);
		$this->id   = $id;
	}

}