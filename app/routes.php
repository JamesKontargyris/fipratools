<?php

use Ignited\Pdf\Facades\Pdf;
use Leadofficelist\Clients\Client;
use Leadofficelist\Sector_categories\Sector_category;
use Leadofficelist\Sectors\Sector;
use Leadofficelist\Units\Unit;
use Maatwebsite\Excel\Facades\Excel;

Route::get('/', ['as' => 'home', function()
{
	return Redirect::route('list.index');
}]);

Route::controller('login', 'LoginController');

Route::get('/logout', 'LoginController@logout');

Route::get('roles', function()
{
	//$new_admin = new Role;
	//$new_admin->name = "Administrator";
	//$new_admin->save();
	//
	//$new_manager = new Role;
	//$new_manager->name = "Head of Unit";
	//$new_manager->save();
	//
	//$new_fipriot = new Role;
	//$new_fipriot->name = "Fipriot";
	//$new_fipriot->save();
//
//    $new_spad = new Role;
//    $new_spad->name = "Special Adviser";
//    $new_spad->save();
	//
	//$manage_users = new Permission;
	//$manage_users->name = "manage_users";
	//$manage_users->display_name = "Manage Users";
	//$manage_users->save();
	//
	//$manage_units = new Permission;
	//$manage_units->name = "manage_units";
	//$manage_units->display_name = "Manage Units";
	//$manage_units->save();
	//
	//$manage_sectors = new Permission;
	//$manage_sectors->name = "manage_sectors";
	//$manage_sectors->display_name = "Manage Sectors";
	//$manage_sectors->save();
	//
	//$manage_services = new Permission;
	//$manage_services->name = "manage_services";
	//$manage_services->display_name = "Manage Services";
	//$manage_services->save();
	//
	//$manage_types = new Permission;
	//$manage_types->name = "manage_types";
	//$manage_types->display_name = "Manage Types";
	//$manage_types->save();
	//
	//$manage_clients = new Permission;
	//$manage_clients->name = "manage_clients";
	//$manage_clients->display_name = "Manage Clients";
	//$manage_clients->save();
	//
	//$manage_client_links = new Permission;
	//$manage_client_links->name = "manage_client_links";
	//$manage_client_links->display_name = "Manage Client Links";
	//$manage_client_links->save();
	//
	//$manage_client_archives = new Permission;
	//$manage_client_archives->name = "manage_client_archives";
	//$manage_client_archives->display_name = "Manage Client Archives";
	//$manage_client_archives->save();
	//
	//$manage_reports = new Permission;
	//$manage_reports->name = "manage_reports";
	//$manage_reports->display_name = "Manage Reports";
	//$manage_reports->save();
	//
	//$view_list = new Permission;
	//$view_list->name = "view_list";
	//$view_list->display_name = "View the Lead Office List";
	//$view_list->save();
	//
	//$new_admin->attachPermissions([$manage_users->id, $manage_units->id, $manage_sectors->id, $manage_services->id, $manage_types->id, $manage_clients->id, $manage_client_links->id, $manage_client_archives->id, $manage_reports->id, $view_list->id]);
//	$new_manager->attachPermissions([$manage_clients->id, $manage_client_archives->id, $view_list->id]);
//	$new_spad->attachPermissions([$manage_clients->id, $manage_client_archives->id, $view_list->id]);
	//$new_fipriot->attachPermissions([$view_list->id]);
	//
	//return "All done!";
});

Route::group(['before' => 'auth'], function()
{
	Route::any('list/export', 'ListController@export');
	Route::any('list/search', 'ListController@search');
	Route::get('about', ['as' => 'list.about', 'uses' => 'ListController@about']);
	Route::post('list/filter', ['as' => 'list.filter', 'uses' => 'ListController@filter']);
	Route::resource('list', 'ListController');

	Route::any('eventlog/export', 'EventLogController@export');
	Route::controller('eventlog', 'EventLogController');

	Route::any('users/export', 'UsersController@export');
	Route::any('users/search', 'UsersController@search');
	Route::resource('users', 'UsersController');

	Route::any('units/export', 'UnitsController@export');
	Route::any('units/search', 'UnitsController@search');
	Route::resource('units', 'UnitsController');

    Route::any('network_types/export', 'NetworkTypesController@export');
    Route::any('network_types/search', 'NetworkTypesController@search');
    Route::resource('network_types', 'NetworkTypesController');

    Route::any('unit_groups/export', 'UnitGroupsController@export');
    Route::any('unit_groups/search', 'UnitGroupsController@search');
    Route::resource('unit_groups', 'UnitGroupsController');

	Route::any('sectors/export', 'SectorsController@export');
	Route::any('sectors/search', 'SectorsController@search');
	Route::resource('sectors', 'SectorsController');

	Route::any('sector_categories/export', 'SectorCategoriesController@export');
	Route::any('sector_categories/search', 'SectorCategoriesController@search');
	Route::resource('sector_categories', 'SectorCategoriesController');

	Route::any('types/export', 'TypesController@export');
	Route::any('types/search', 'TypesController@search');
	Route::resource('types', 'TypesController');

    Route::any('type_categories/export', 'TypeCategoriesController@export');
    Route::any('type_categories/search', 'TypeCategoriesController@search');
    Route::resource('type_categories', 'TypeCategoriesController');

	Route::any('services/export', 'ServicesController@export');
	Route::any('services/search', 'ServicesController@search');
	Route::resource('services', 'ServicesController');

	Route::any('clients/export', 'ClientsController@export');
	Route::any('clients/search', 'ClientsController@search');
	Route::any('clients/status', ['as' => 'clients.change_status', 'uses' => 'ClientsController@changeStatus']);
	Route::resource('clients', 'ClientsController');

	Route::resource('client_links', 'ClientLinksController');
	Route::resource('client_archives', 'ClientArchivesController');

	Route::any('account_directors/export', 'AccountDirectorsController@export');
	Route::any('account_directors/search', 'AccountDirectorsController@search');
	Route::resource('account_directors', 'AccountDirectorsController');

	Route::controller('reports', 'ReportsController');
	Route::controller('statuscheck', 'StatusCheckController');
});

//Ajax requests
Route::get('/getclients', 'ClientLinksController@getClientsByUnit');