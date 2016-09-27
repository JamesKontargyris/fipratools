<?php namespace Leadofficelist\Sectors;

class EditSectorCommand {
	public $name;
	public $category;
	public $new_category;
	public $id;
	public $show_list;
	public $show_case;

	function __construct( $name, $category, $new_category, $show_list, $show_case, $id ) {
		$this->name         = trim( $name );
		$this->category     = $category;
		$this->new_category = $new_category;
		$this->show_list = $show_list;
		$this->show_case = $show_case;
		$this->id           = $id;
	}

}