<?php

use Laracasts\Commander\CommanderTrait;
use Laracasts\Flash\Flash;
use Leadofficelist\Forms\AddUser as AddUserForm;
use Leadofficelist\Units\Unit;

class UsersController extends \BaseController {

	use CommanderTrait;
	/**
	 * @var AddUserForm
	 */
	private $addUserForm;

	function __construct(AddUserForm $addUserForm) {

		$this->addUserForm = $addUserForm;

	}

	/**
	 * Display a listing of the resource.
	 * GET /users
	 *
	 * @return Response
	 */
	public function index()
	{
		return Permission::getPermsForRole('Administrator', true);
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /users/create
	 *
	 * @return Response
	 */
	public function create()
	{
		if( ! $units = Unit::getUnitsForFormSelect(true)) $units = ['' => 'No units available to select'];
		if( ! $roles = Role::getRolesForFormSelect(true)) $roles = ['' => 'No roles available to select'];
		if( ! $admin_perms_list = Permission::getPermsForRole('Administrator', true)) $admin_perms_list = 'do nothing.';
		if( ! $editor_perms_list = Permission::getPermsForRole('Editor', true)) $editor_perms_list = 'do nothing.';
		if( ! $viewer_perms_list = Permission::getPermsForRole('Viewer', true)) $viewer_perms_list = 'do nothing.';

		return View::make('users.create')->with(compact('units', 'roles', 'admin_perms_list', 'editor_perms_list', 'viewer_perms_list'));
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /users
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		$this->addUserForm->validate($input);

		$this->execute('Leadofficelist\Users\AddUserCommand');

		Flash::success('New user added.');

		return Redirect::to('user');
	}

	/**
	 * Display the specified resource.
	 * GET /users/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /users/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /users/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /users/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}