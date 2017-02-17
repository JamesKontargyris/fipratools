<?php

use Laracasts\Commander\CommanderTrait;
use Laracasts\Flash\Flash;
use Leadofficelist\Clients\Client;
use Leadofficelist\Exceptions\CannotEditException;
use Leadofficelist\Exceptions\ResourceNotFoundException;
use Leadofficelist\Forms\AddUser as AddUserForm;
use Leadofficelist\Forms\EditUser as EditUserForm;
use Leadofficelist\Units\Unit;
use Leadofficelist\Users\User;

class UsersController extends \BaseController
{
	use CommanderTrait;

	public $section = 'list';
	protected $resource_key = 'users';
	protected $resource_permission = 'manage_users';
	protected $units;
	protected $roles;
	protected $fipriot_perms_list;
	protected $admin_perms_list;
	protected $head_perms_list;
	protected $spad_perms_list;
	protected $export_filename;
	private $addUserForm;
	private $editUserForm;

	private $search_term;

	function __construct( AddUserForm $addUserForm, EditUserForm $editUserForm )
	{
		parent::__construct();

		$this->addUserForm = $addUserForm;
		$this->editUserForm = $editUserForm;
		$this->getFormData();

		View::share( 'page_title', 'Units' );
		View::share( 'key', 'users' );
	}

	/**
	 * Display a listing of users.
	 * GET /users
	 *
	 * @return Response
	 */
	public function index()
	{
		$this->destroyCurrentPageNumber(true);

		$this->check_perm( 'manage_users' );

		if ( $this->searchCheck() )
		{
			return Redirect::to( $this->resource_key . '/search' );
		}

		$items      = User::rowsSortOrder( $this->rows_sort_order )->paginate( $this->rows_to_view );
		$items->key = 'users';

		return View::make( 'users.index' )->with( compact( 'items' ) );
	}

	/**
	 * Show the form for creating a new user.
	 * GET /users/create
	 *
	 * @return Response
	 */
	public function create()
	{
		$this->check_perm( 'manage_users' );

		$this->getFormData();

		return View::make( 'users.create' )->with( [
			'units'             => $this->units,
			'roles'             => $this->roles,
			'admin_perms_list'  => $this->admin_perms_list,
			'head_perms_list' => $this->head_perms_list,
			'fipriot_perms_list' => $this->fipriot_perms_list,
			'spad_perms_list' => $this->spad_perms_list
		] );
	}

	/**
	 * Store a newly created user in storage.
	 * POST /users
	 *
	 * @return Response
	 */
	public function store()
	{
		$this->check_perm( 'manage_units' );

		$input = Input::all();
		$this->addUserForm->validate( $input );

		$this->execute( 'Leadofficelist\Users\AddUserCommand' );

		Flash::overlay( '"' . $input['first_name'] . ' ' . $input['last_name'] . '" added.', 'success' );

		return Redirect::route( 'users.index' );
	}

	/**
	 * Display the specified user.
	 * GET /users/{id}
	 *
	 * @param  int $id
	 *
	 * @throws ResourceNotFoundException
	 * @throws \Leadofficelist\Exceptions\PermissionDeniedException
	 * @return Response
	 */
	public function show( $id )
	{
		$this->check_perm( 'view_list' );

		if ( $show_user = $this->getUser( $id ) )
		{
			$clients = $this->getActiveClientsByField( 'user_id', $id );

			return View::make( 'users.show' )->with( compact( 'show_user', 'clients' ) );
		} else
		{
			throw new ResourceNotFoundException( 'users' );
		}
	}

	/**
	 * Show the form for editing the specified user.
	 * GET /users/{id}/edit
	 *
	 * @param  int $id
	 *
	 * @throws CannotEditException
	 * @throws ResourceNotFoundException
	 * @throws \Leadofficelist\Exceptions\PermissionDeniedException
	 * @return Response
	 */
	public function edit( $id )
	{
		$this->check_perm( 'manage_users' );

		if ( $this->editingCurrentUser( $id ) )
		{
			throw new CannotEditException( 'users' );
		}

		if ( $edit_user = $this->getUser( $id ) )
		{
			$this->getFormData();

			return View::make( 'users.edit' )->with( [
				'edit_user'         => $edit_user,
				'units'             => $this->units,
				'roles'             => $this->roles,
				'admin_perms_list'  => $this->admin_perms_list,
				'head_perms_list' => $this->head_perms_list,
				'fipriot_perms_list' => $this->fipriot_perms_list,
                'spad_perms_list' => $this->spad_perms_list
			] );
		} else
		{
			throw new ResourceNotFoundException( 'users' );
		}
	}

	/**
	 * Update the specified user in storage.
	 * PUT /users/{id}
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function update( $id )
	{
		$this->check_perm( 'manage_users' );

		$input                              = Input::all();
		$input['id']                        = $id;
		$this->editUserForm->rules['email'] = 'required|email|max:255|unique:users,email,' . $id;
		$this->editUserForm->validate( $input );

		$this->execute( 'Leadofficelist\Users\EditUserCommand', $input );

		Flash::overlay( '"' . $input['first_name'] . ' ' . $input['last_name'] . '" updated.', 'success' );

		return Redirect::route( 'users.index' );
	}

	/**
	 * Remove the specified user from storage.
	 * DELETE /users/{id}
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function destroy( $id )
	{
		$this->check_perm( 'manage_users' );

		if ( $user = $this->getUser( $id ) )
		{
			User::destroy( $id );
			Flash::overlay( '"' . $user->getFullName() . '" deleted.', 'info' );

		}

		return Redirect::route( 'users.index' );
	}

	/**
	 * Show search results.
	 *
	 * @return $this
	 * @throws \Leadofficelist\Exceptions\PermissionDeniedException
	 */
	public function search()
	{
		$this->check_perm( 'manage_users' );

		if ( $this->search_term = $this->findSearchTerm() )
		{
			$items = User::where( 'id', '!=', $this->user->id )->where( function ( $query )
			{
				$query->where( 'first_name', 'LIKE', $this->search_term )->orWhere( 'last_name', 'LIKE', $this->search_term );
			} )->rowsSortOrder( $this->rows_sort_order )->paginate( $this->rows_to_view );

			if ( ! $this->checkForSearchResults( $items ) )
			{
				return Redirect::route( $this->resource_key . '.index' );
			}
			$items->search_term = str_replace( '%', '', $this->search_term );
			$items->key         = 'users';

			return View::make( 'users.index' )->with( compact( 'items' ) );
		} else
		{
			return Redirect::route( 'users.index' );
		}

	}

	protected function getAll()
	{
		return User::all();
	}

	protected function getSelection()
	{
		if ( $this->searchCheck() )
		{
			$this->search_term = $this->findSearchTerm();
			$this->search_term_clean = str_replace('%', '', $this->search_term);

			$items = User::where( 'id', '!=', $this->user->id )->where( function ( $query )
			{
				$query->where( 'first_name', 'LIKE', $this->search_term )->orWhere( 'last_name', 'LIKE', $this->search_term );
			} )->rowsSortOrder( $this->rows_sort_order )->paginate($this->rows_to_view);
		}
		else
		{
				$items = User::rowsSortOrder( $this->rows_sort_order )->paginate( $this->rows_to_view );
		}

		return $items;
	}

	/**
	 * Get the user we're trying to modify/view.
	 *
	 * @param $id
	 *
	 * @return \Illuminate\Support\Collection|static
	 */
	protected function getUser( $id )
	{
		return User::find( $id );
	}

	/**
	 * Get all data required to populate the add/edit user forms.
	 *
	 * @return bool
	 */
	protected function getFormData()
	{
		$this->units             = $this->getUnitsFormData();
		$this->roles             = $this->getRolesFormData();
		$this->admin_perms_list  = $this->getPerms( 'Administrator' );
		$this->head_perms_list = $this->getPerms( 'Head of Unit' );
		$this->fipriot_perms_list = $this->getPerms( 'Fipriot' );
        $this->spad_perms_list = $this->getPerms('Special Adviser');

		return true;
	}

	/**
	 * Get all the roles in a select element-friendly collection.
	 *
	 * @return array
	 */
	protected function getRolesFormData()
	{
		if ( ! Role::getRolesForFormSelect( true ) )
		{
			return [ '' => 'No roles available to select' ];
		}

		return Role::getRolesForFormSelect( true );
	}

	/**
	 * Get the permissions for a role name.
	 *
	 * @param $role
	 *
	 * @return array|string
	 */
	protected function getPerms( $role )
	{
		if ( ! Permission::getPermsForRole( $role, true ) )
		{
			return 'do nothing.';
		}

		return Permission::getPermsForRole( $role, true );
	}

	/**
	 * Are we trying to edit the currently logged-in user?
	 *
	 * @param $id
	 *
	 * @return bool
	 */
	private function editingCurrentUser( $id )
	{
		return ( $id == $this->user->id );
	}
}