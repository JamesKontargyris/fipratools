<?php namespace Leadofficelist\Sectors;

class AddSectorCommand {
	public $name;
	public $category;
	public $new_category;
	public $show_list;
	public $show_case;

	function __construct( $name, $category, $new_category, $show_list, $show_case ) {
		$this->name         = trim( $name );
		$this->category     = $category;
		$this->new_category = $new_category;
		$this->show_list = (int)(bool)$show_list;
		$this->show_case = (int)(bool)$show_case;
	}


} 