<?php

use Laracasts\Flash\Flash;
use Leadofficelist\Clients\Client;
use Leadofficelist\Exceptions\PermissionDeniedException;
use Leadofficelist\Users\User;

class BaseController extends Controller
{

	protected $user;
	protected $rows_sort_order;
	protected $rows_to_view;
	protected $userFullName;
	/**
	 * Array of filter keys to reset when "reset filters" is clicked
	 *
	 * @var array
	 */
	protected $filter_keys = [ 'rowsToView', 'rowsSort', 'rowsNameOrder', 'rowsHideShowDormant' ];

	function __construct()
	{
		$this->user = Auth::user();
		if ( isset( $this->user->id ) )
		{
			View::share( 'user', $this->user );
			View::share( 'user_full_name', $this->user->getFullName() );
			View::share( 'user_unit', $this->user->unit()->pluck( 'name' ) );
			View::share( 'user_role', $this->user->roles()->pluck( 'name' ) );
		}

		$this->reset_filters();
		$this->rows_sort_order        = $this->getRowsSortOrder( $this->resource_key );
		$this->rows_to_view           = $this->getRowsToView( $this->resource_key );
		$this->name_order             = $this->getNameOrder( $this->resource_key );
		$this->rows_hide_show_dormant = $this->getRowsHideShowDormant( $this->resource_key );
	}


	/**
	 * If reset_filters is set to yes, reset all session keys
	 * listed in $filter_keys
	 *
	 * @return bool
	 */
	protected function reset_filters()
	{
		if ( Input::has( 'reset_filters' ) )
		{
			foreach ( $this->filter_keys as $key )
			{
				Session::forget( $this->resource_key . '.' . $key );
			}
		}

		return true;
	}

	/**
	 * Process the 'view' value passed in the query string and return the correct value
	 *
	 * @return int|mixed
	 */
	protected function getRowsToView( $key )
	{
		//If the value passed in is 'all', set the valye to 99999. Otherwise,
		//use the value passed in, which should be numeric
		$value = ( Input::get( 'view' ) == 'all' ) ? 99999 : Input::get( 'view' );
		//Value passed in and it is numeric?
		if ( Input::has( 'view' ) && is_numeric( $value ) )
		{
			Session::set( $key . '.rowsToView', $value );

			return $value;
		} //Session value exists for rowsToView?
		elseif ( Session::get( $key . '.rowsToView' ) )
		{
			return Session::get( $key . '.rowsToView' );
		} //If all else fails...
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
	protected function getRowsSortOrder( $key )
	{
		//Array of column names that will be sorted on, and how they should be ordered
		$sort_on = [ 'az' => 'name.asc', 'za' => 'name.desc', 'newest' => 'id.desc', 'oldest' => 'id.asc' ];
		//Different column names in the user table
		$sort_on_users = [
			'az'     => 'last_name.asc',
			'za'     => 'last_name.desc',
			'newest' => 'id.desc',
			'oldest' => 'id.asc'
		];

		//Value passed in and exists in the $sort_on variable?
		if ( Input::has( 'sort' ) )
		{
			//If a sort term is passed in in the query string, store it in the session
			//and return the column and order to sort on
			$sort_term = Input::get( 'sort' );
			if ( ! $this->is_request( 'users' ) && isset( $sort_on[ Input::get( 'sort' ) ] ) )
			{
				Session::set( $key . '.rowsSort', $sort_on[ $sort_term ] );

				return explode( '.', $sort_on[ $sort_term ] );
			} elseif ( $this->is_request( 'users' ) )
			{
				Session::set( $key . '.rowsSort', $sort_on_users[ $sort_term ] );

				return explode( '.', $sort_on_users[ $sort_term ] );
			}
		} //Session value exists for rowsSort?
		elseif ( Session::get( $key . '.rowsSort' ) )
		{
			return explode( '.', Session::get( $key . '.rowsSort' ) );
		} //If all else fails...
		else
		{
			return ( $this->is_request( 'users' ) ) ? [ 'last_name', 'asc' ] : [ 'name', 'asc' ];
		}

		return false;
	}

	/**
	 * Process the 'view' value passed in the query string and return the correct value
	 *
	 * @return int|mixed
	 */
	protected function getRowsHideShowDormant( $key )
	{
		//If the value passed in is 'all', set the valye to 99999. Otherwise,
		//use the value passed in, which should be numeric
		//Value passed in and it is numeric?
		if ( Input::has( 'dormant' ) && Input::get( 'dormant' ) == 'show' )
		{
			Session::set( $key . '.rowsHideShowDormant', 'show' );

			return 'show';
		}
		elseif ( Input::has( 'dormant' ) && Input::get( 'dormant') == 'hide' )
		{
			Session::set( $key . '.rowsHideShowDormant', 'hide' );

			return 'hide';
		}
		elseif ( Session::get( $key . '.rowsHideShowDormant' ) )
		{
			return Session::get( $key . '.rowsHideShowDormant' );
		}

		//If all else fails...
		return 'hide';
	}

	protected function getNameOrder( $key )
	{
		$value = Input::get( 'name' );
		//Value passed in?
		if ( $value )
		{
			Session::set( $key . '.rowsNameOrder', $value );

			return $value;
		}
	}

	protected function check_perm( $perm )
	{
		if ( $this->user->can( $perm ) )
		{
			return true;
		}

		throw new PermissionDeniedException;
	}

	protected function is_request( $uri, $strict = false )
	{
		if ( $strict == true )
		{
			$request_is = Request::is( $uri );
		} else
		{
			$request_is = Request::is( $uri ) || Request::is( $uri . '/*' );
		}

		return $request_is;
	}

	protected function getActiveClientsByField( $field, $id )
	{
		return Client::orderBy( 'name' )->where( $field, '=', $id )->where( 'status', '=', 1 )->get();
	}

	protected function searchCheck()
	{
		if(Input::has('clear_search')) { Session::forget($this->resource_key . '.SearchTerm'); }
		elseif(Session::has($this->resource_key . '.SearchTerm')) { return true; }

		return false;
	}

	protected function findSearchTerm()
	{
		if(Input::has('search')) Session::set($this->resource_key . '.SearchTerm', Input::get('search'));
		return Session::get($this->resource_key . '.SearchTerm');
	}
}
