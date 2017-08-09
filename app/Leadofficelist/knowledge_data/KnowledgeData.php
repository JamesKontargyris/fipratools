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

	public static function addData( $user_id, $slug = '', $data_value = '', $survey_name = '', $serialized = 0 ) {
		if($user_id) {
			if ( KnowledgeData::where('user_id', '=', $user_id)->where( 'slug', '=', $slug )->where( 'survey_name', '=', $survey_name )->get()->first() ) {
				// Slug already exists for this user so update instead of adding
				return KnowledgeData::updateData( $user_id, $slug, $data_value, $survey_name, $serialized );
			} else {
				$add_data = new KnowledgeData;
				$add_data->user_id = $user_id;
				$add_data->slug = $slug;
				$add_data->data_value = $data_value;
				$add_data->survey_name = $survey_name;
				$add_data->serialized = $serialized;
				$add_data->save();

				return $add_data;
			}
		} else {
			return false;
		}
	}

	public static function updateData( $user_id, $slug = '', $data_value = '', $survey_name = '', $serialized = 0 ) {
		if($update_data = KnowledgeData::where('user_id', '=', $user_id)->where('slug', '=', $slug)->where('survey_name', '=', $survey_name)->get()->first()) {
			// User / slug combo exists
			$update_data->data_value = $data_value;
			$update_data->survey_name = $survey_name;
			$update_data->serialized = $serialized;
			$update_data->save();

			return $update_data;
		} else {
			return false;
		}
	}

	public static function deleteData($user_id, $slug = '', $survey_name = '')
	{
		if($delete_data = KnowledgeData::where('user_id', '=', $user_id)->where('slug', '=', $slug)->where('survey_name', '=', $survey_name)->get()->first()) {
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

	/**
	 * Work out if a head of unit survey section has been completed by the Head of Unit
	 *
	 * @param array $sections
	 * @param string $section_name
	 * @param int $user_id
	 *
	 * @return bool
	 */
	protected static function sectionIsComplete($sections = [], $section_name = '', $user_id = 0)
	{
		if($sections && $section_name && $user_id)
		{
			if($section_name == 'perception audit')
			{
				// treat the perception audit section differently, as all entries are stored as a serialized array in the DB, not as separate records
				if(KnowledgeData::where('user_id', '=', $user_id)->where('slug', '=', 'perception_audit')->count() > 0)
				{
					// a perception audit entry exists for this user, so carry on to get the data value and unserialize it
					$perception_audit_array = unserialize(KnowledgeData::where('user_id', '=', $user_id)->where('slug', '=', 'perception_audit')->pluck('data_value'));

					// get just the keys in an array
					$perception_audit_array_keys = array_keys($perception_audit_array);
					// if this array matches the $sections['perception audit'] array, all fields have been filled in by the user. Return true
					// if not, return false
					return $perception_audit_array_keys == $sections['perception audit'];
				}

			} else {
				// All other sections apart from perception audit
				// Generate a query that limits knowledge data results to the user's ID and the fields listed in the relevant sections array
				$count = \DB::table('knowledge_data')
				            ->where('user_id', '=', $user_id)
				            ->where(function($query) use ($section_name, $sections)
				            {
					            foreach($sections[$section_name] as $field)
					            {
						            $query->orWhere('slug', '=', $field);
					            }
				            })
				            ->count();

				// Does the count of the relevant sections array equal the record count of the query?
				// If so, all section questions have been answered
				return ($count == count($sections[$section_name])) ? true : false;
			}
		} else {
			return false;
		}
	}
}