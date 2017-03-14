<?php namespace Leadofficelist\Knowledge_data;

use Auth;

class KnowledgeData extends \BaseModel {
	protected $fillable = [ 'user_id', 'slug', 'data_title', 'data_value' ];
	protected $table = 'knowledge_data';

	public function user()
	{
		//One knowledge data entry belongs to one user
		return $this->belongsTo( '\Leadofficelist\Users\User', 'id', 'user_id' );
	}

	public static function addData( $user_id, $slug = '', $data_value = '', $serialized = 0 ) {
		if($user_id) {
			if ( KnowledgeData::where('user_id', '=', $user_id)->where( 'slug', '=', $slug )->get()->first() ) {
				// Slug already exists for this user so update instead of adding
				return KnowledgeData::updateData( $user_id, $slug, $data_value, $serialized );
			} else {
				$add_data = new KnowledgeData;
				$add_data->user_id = $user_id;
				$add_data->slug = $slug;
				$add_data->data_value = $data_value;
				$add_data->serialized = $serialized;
				$add_data->save();

				return $add_data;
			}
		} else {
			return false;
		}
	}

	public static function updateData( $user_id, $slug = '', $data_value = '', $serialized = 0 ) {
		if($update_data = KnowledgeData::where('user_id', '=', $user_id)->where('slug', '=', $slug)->get()->first()) {
			// User / slug combo exists
			$update_data->data_value = $data_value;
			$update_data->serialized = $serialized;
			$update_data->save();

			return $update_data;
		} else {
			return false;
		}
	}

	public static function deleteData($user_id, $slug = '')
	{
		if($delete_data = KnowledgeData::where('user_id', '=', $user_id)->where('slug', '=', $slug)->get()->first()) {
			// User / slug combo exists
			$delete_data->delete();

			return true;
		} else {
			return false;
		}
	}

	public static function deleteAllUserData($user_id = '')
	{
		$delete_data = KnowledgeData::where('user_id', '=', $user_id)->get();

		foreach($delete_data as $data) {
			$data->delete();
		}

		return true;
	}

	public function hasData($slug = '')
	{
		if(KnowledgeData::where('slug', '=', $slug)->where('user_id', '=', Auth::user()->id)->get()->first())
		{
			return true;
		}

		return false;
	}

	public function getData($slug) {
		return KnowledgeData::where('slug', '=', $slug)->where('user_id', '=', Auth::user()->id)->get()->first();
	}
}