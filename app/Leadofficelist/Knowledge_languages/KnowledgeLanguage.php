<?php namespace Leadofficelist\Knowledge_languages;

use Leadofficelist\Users\User;

class KnowledgeLanguage extends \BaseModel {
	protected $fillable = [ 'name' ];

	public function users()
	{
		//Many users have many knowledge languages
		return $this->belongsToMany( '\Leadofficelist\Users\User' )->withPivot('fluent');
	}

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

	public function updateKnowledgeLanguageInfo( $languages ) {
		$update_user = User::find( $languages->id );
		$language_ids = $languages->languages;
		$update_user->knowledge_languages()->sync($language_ids);

		return $update_user;
	}

	public static function getKnowledgeLanguagesForFormSelect( $blank_entry = false, $blank_message = 'Please select...', $prefix = "" )
	{
		$languages = [ ];
		//Remove whitespace from $prefix and add a space on the end, so there is a space
		//between the prefix and the area name
		$prefix = trim( $prefix ) . ' ';
		//If $blank_entry == true, add a blank "Please select..." option
		if ( $blank_entry )
		{
			$languages[''] = $blank_message;
		}

		foreach (
			KnowledgeLanguage::orderBy( 'name', 'ASC' )->get( [
				'id',
				'name'
			] ) as $language
		)
		{
			$languages[ $language->id ] = $prefix . $language->name;
		}



		if ( $blank_entry && count( $languages ) == 1 )
		{
			return false;
		} elseif ( ! $blank_entry && count( $languages ) == 0 )
		{
			return false;
		} else
		{
			return $languages;
		}
	}
}