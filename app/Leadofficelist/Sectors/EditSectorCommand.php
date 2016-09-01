<?php namespace Leadofficelist\Sectors;

class EditSectorCommand {
	public $name;
	public $category;
	public $new_category;
	public $id;

	function __construct( $name, $category, $new_category, $id ) {
		$this->name         = trim( $name );
		$this->category     = $category;
		$this->new_category = $new_category;
		$this->id           = $id;
	}

}