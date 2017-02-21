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
		// Make sure languages that are marked as fluent, but aren't included in $language_ids, are included in the sync data
		$language_ids = array_unique(array_merge($language_ids, $languages->fluent));
		// Create an array of ids and fluency flags for each language to add in to the pivot table
		$sync_data   = [];
		foreach ( $language_ids as $language_id ) {
			$sync_data[ $language_id ] = [ 'fluent' => in_array($language_id, $languages->fluent) ? 1 : 0 ];
		}
		$update_user->knowledge_languages()->sync($sync_data);

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