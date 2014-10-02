<?php

Route::get('/', ['as' => 'home', function()
{
//	TODO: add in auth filter before
	return View::make('home');
}]);

Route::get('/login', function()
{
	return View::make('login');
});

Route::post('/login', function()
{
	// Validation? Not in my quickstart!
	// No, but really, I'm a bad person for leaving that out
	Auth::attempt( array('email' => Input::get('email'), 'password' => Input::get('password')) );

	return Redirect::to('/');
});

Route::get('roles', function()
{
	$new_admin = new Role;
	$new_admin->name = "Administrator";
	$new_admin->save();

	$new_editor = new Role;
	$new_editor->name = "Editor";
	$new_editor->save();

	$new_viewer = new Role;
	$new_viewer->name = "Viewer";
	$new_viewer->save();

	$manage_users = new Permission;
	$manage_users->name = "manage_users";
	$manage_users->display_name = "Manage Users";
	$manage_users->save();

	$manage_units = new Permission;
	$manage_units->name = "manage_units";
	$manage_units->display_name = "Manage Units";
	$manage_units->save();

	$manage_sectors = new Permission;
	$manage_sectors->name = "manage_sectors";
	$manage_sectors->display_name = "Manage Sectors";
	$manage_sectors->save();

	$manage_services = new Permission;
	$manage_services->name = "manage_services";
	$manage_services->display_name = "Manage Services";
	$manage_services->save();

	$manage_types = new Permission;
	$manage_types->name = "manage_types";
	$manage_types->display_name = "Manage Types";
	$manage_types->save();

	$manage_clients = new Permission;
	$manage_clients->name = "manage_clients";
	$manage_clients->display_name = "Manage Clients";
	$manage_clients->save();

	$manage_client_archives = new Permission;
	$manage_client_archives->name = "manage_client_archives";
	$manage_client_archives->display_name = "Manage Client Archives";
	$manage_client_archives->save();

	$manage_reports = new Permission;
	$manage_reports->name = "manage_reports";
	$manage_reports->display_name = "Manage Reports";
	$manage_reports->save();

	$view_list = new Permission;
	$view_list->name = "view_list";
	$view_list->display_name = "View the Lead Office List";
	$view_list->save();

	$new_admin->attachPermissions([$manage_users->id, $manage_units->id, $manage_sectors->id, $manage_services->id, $manage_types->id, $manage_clients->id, $manage_client_archives->id, $manage_reports->id, $view_list->id]);
	$new_editor->attachPermissions([$manage_clients->id, $manage_client_archives->id, $view_list->id]);
	$new_viewer->attachPermissions([$view_list->id]);

	return "All done!";
});

Route::resource('unit', 'UnitsController');
Route::resource('user', 'UsersController');