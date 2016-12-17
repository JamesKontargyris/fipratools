<?php

class KnowledgeLanguage extends \BaseModel {
	protected $fillable = [ 'name' ];

	public function add( $language ) {
		$this->name       = $language->name;
		$this->save();

		return $this;
	}

	public function edit( $language ) {
		$update_language             = $this->find( $language->id );
		$update_language->name       = $language->name;
		$update_language->save();

		return $update_language;
	}
}