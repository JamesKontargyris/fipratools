<?php

use Laracasts\Flash\Flash;
use Leadofficelist\Exceptions\PermissionDeniedException;
use Leadofficelist\Users\User;

class BaseController extends Controller {

	protected $user;
	protected $rows_sort_order;
	protected $rows_to_view;
	protected $userFullName;

	function __construct()
	{
		$this->user = Auth::user();
		if(isset($this->user->id))
		{
			View::share('user_full_name', $this->user->getFullName());
			View::share('user_unit', $this->user->unit()->pluck('name'));
			View::share('user_role', $this->user->roles()->first()->pluck('name'));
		}

		$this->reset_filters();
		$this->rows_sort_order = $this->getRowsSortOrder($this->resource_key);
		$this->rows_to_view = $this->getRowsToView($this->resource_key);
	}


	/**
	 * If reset_filters is set to yes, reset all session keys
	 * listed in $filter_keys
	 *
	 * @return bool
	 */
	protected function reset_filters()
	{
		if(Input::has('reset_filters'))
		{
			foreach($this->filter_keys as $key)
			{
				Session::forget($key);
			}
		}

		return true;
	}

	/**
	 * Process the 'view' value passed in the query string and return the correct value
	 *
	 * @return int|mixed
	 */
	protected function getRowsToView($key)
	{
		//If the value passed in is 'all', set the valye to 99999. Otherwise,
		//use the value passed in, which should be numeric
		$value = (Input::get('view') == 'all') ? 99999 : Input::get('view');
		//Value passed in and it is numeric?
		if(Input::has('view') && is_numeric($value))
		{
			Session::set($key . '.rowsToView', $value);
			return $value;
		}
		//Session value exists for rowsToView?
		elseif(Session::get($key . '.rowsToView'))
		{
			return Session::get($key . '.rowsToView');
		}
		//If all else fails...
		else
		{
			return 10;
		}
	}

	/**
	 * Process the 'sort' value passed in the query string and return the correct value
	 *
	 * @return array
	 */
	protected function getRowsSortOrder($key)
	{
		//Array of column names that will be sorted on, and how they should be ordered
		$sort_on = ['az' => 'name.asc', 'za' => 'name.desc', 'newest' => 'id.desc', 'oldest' => 'id.asc'];

		//Value passed in and exists in the $sort_on variable?
		if(Input::has('sort') && isset($sort_on[Input::get('sort')]))
		{
			//If a sort term is passed in in the query string, store it in the session
			//and return the column and order to sort on
			$sort_term = Input::get('sort');
			Session::set($key . '.rowsSort', $sort_on[$sort_term]);
			return explode('.', $sort_on[$sort_term]);
		}
		//Session value exists for rowsSort?
		elseif(Session::get($key . '.rowsSort'))
		{
			return explode('.', Session::get($key . '.rowsSort'));
		}
		//If all else fails...
		else
		{
			return ['name', 'asc'];
		}
	}

	protected function check_perm($perm)
	{
		if($this->user->can($perm)) return true;

		throw new PermissionDeniedException;
	}

}
