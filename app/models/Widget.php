<?php namespace Leadofficelist\Widgets;

class Widget extends \BaseModel {

	protected $fillable = ['name', 'slug', 'content'];

	public function add( $widget ) {
		$this->name = $widget->name;
		$this->slug = $widget->slug;
		$this->content = $widget->content;
		$this->save();

		return $this;
	}

	public function edit( $widget ) {
		$update_widget       = $this->find( $widget->id );
		$update_widget->name = $widget->name;
		$update_widget->slug = $widget->slug;
		$update_widget->content = $widget->content;
		$update_widget->save();

		return $update_widget;
	}
}