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
	//$new_admin = new Role; $new_admin->name = "Administrator"; $new_admin->save();
	//
	//$new_manager = new Role;
	//$new_manager->name = "Head of Unit";
	//$new_manager->save();
	//
	$new_fipriot = new Role; $new_fipriot->name = "Fipra International"; $new_fipriot->save();
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
	$manage_client_archives = new Permission; $manage_client_archives->name = "view_toolbox"; $manage_client_archives->display_name = "View Toolbox"; $manage_client_archives->save();
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

//	$manage_locations = new Permission;
//	$manage_locations->name = "manage_locations";
//	$manage_locations->display_name = "Manage Locations";
//	$manage_locations->save();
//
//	$manage_products = new Permission;
//	$manage_products->name = "manage_products";
//	$manage_products->display_name = "Manage Locations";
//	$manage_products->save();

//	$manage_cases = new Permission;
//	$manage_cases->name = "manage_cases";
//	$manage_cases->display_name = "Manage Cases";
//	$manage_cases->save();
////
//	Role::find(1)->attachPermissions([$manage_cases->id]);
//	Role::find(2)->attachPermissions([$manage_cases->id]);
//
	/*$manage_knowledge = new Permission; $manage_knowledge->name = "manage_knowledge"; $manage_knowledge->display_name = "Manage Knowledge Survey resources"; $manage_knowledge->save();

	$edit_knowledge = new Permission; $edit_knowledge->name = "edit_knowledge"; $edit_knowledge->display_name = "Edit Knowledge Survey details for their user profile"; $edit_knowledge->save();

	$view_knowledge = new Permission; $view_knowledge->name = "view_knowledge"; $view_knowledge->display_name = "View Knowledge Survey"; $view_knowledge->save();

	Role::find(1)->attachPermissions([$manage_knowledge->id]);
	Role::find(1)->attachPermissions([$edit_knowledge->id]); Role::find(2)->attachPermissions([$edit_knowledge->id]); Role::find(3)->attachPermissions([$edit_knowledge->id]); Role::find(4)->attachPermissions([$edit_knowledge->id]);
	Role::find(1)->attachPermissions([$view_knowledge->id]); Role::find(2)->attachPermissions([$view_knowledge->id]); Role::find(3)->attachPermissions([$view_knowledge->id]); Role::find(4)->attachPermissions([$view_knowledge->id]);

	return "All done!";*/
});

Route::controller('password', 'PasswordController');

// Route to add new users in a batch from a CSV file
Route::get('/usersupdate', function()
{
	$users = Leadofficelist\Users\User::whereDate('created_at', '>=', '2017-02-22')->get();
	foreach($users as $user) { $user->delete(); }

	echo "It Is Done.";
});

Route::group(['before' => 'auth'], function()
{
	// Temporary IWO route
	Route::any('iwo', 'PagesController@iwo');

	// Privacy notice route
	Route::any('privacynotice', 'PagesController@privacynotice');

	Route::get('password/change', 'PasswordController@getChange');
	Route::post('password/change', 'PasswordController@postChange');

	Route::any('list/export', 'ListController@export');
	Route::any('list/search', 'ListController@search');
	Route::get('about', ['as' => 'list.about', 'uses' => 'ListController@about']);
	Route::post('list/filter', ['as' => 'list.filter', 'uses' => 'ListController@filter']);
	Route::resource('list', 'ListController');

	Route::any('caselist/export', 'CaseListController@export');
	Route::any('caselist/search', 'CaseListController@search');
	Route::post('caselist/filter', ['as' => 'caselist.filter', 'uses' => 'CaseListController@filter']);
	Route::resource('caselist', 'CaseListController');

	Route::any('survey/export', 'KnowledgeSurveysController@export');
	Route::any('survey/search', 'KnowledgeSurveysController@search');
	Route::post('survey/filter', ['as' => 'knowledge_surveys.filter', 'uses' => 'KnowledgeSurveysController@filter']);
	Route::get('survey/profile', 'KnowledgeSurveysController@getShowProfile');
	Route::get('survey/profile/edit', 'KnowledgeSurveysController@getUpdateProfile');
	Route::post('survey/profile/edit', 'KnowledgeSurveysController@postUpdateProfile');
	Route::resource('survey', 'KnowledgeSurveysController');

	Route::any('headofunitsurvey/export', 'HeadofUnitSurveyController@export');
	Route::any('headofunitsurvey/search', 'HeadofUnitSurveyController@search');
	Route::get('headofunitsurvey/profile/edit', 'HeadofUnitSurveyController@getUpdateProfile');
	Route::post('headofunitsurvey/profile/edit', 'HeadofUnitSurveyController@postUpdateProfile');
	Route::get('headofunitsurvey/overview', 'HeadofUnitSurveyController@getOverview');
	Route::resource('headofunitsurvey', 'HeadofUnitSurveyController');

	Route::any('knowledge_areas/export', 'KnowledgeAreasController@export');
	Route::any('knowledge_areas/search', 'KnowledgeAreasController@search');
	Route::post('knowledge_areas/filter', ['as' => 'knowledge_areas.filter', 'uses' => 'KnowledgeAreasController@filter']);
	Route::resource('knowledge_areas', 'KnowledgeAreasController');

	Route::any('knowledge_area_groups/export', 'KnowledgeAreaGroupsController@export');
	Route::any('knowledge_area_groups/search', 'KnowledgeAreaGroupsController@search');
	Route::post('knowledge_area_groups/filter', ['as' => 'knowledge_area_groups.filter', 'uses' => 'KnowledgeAreaGroupsController@filter']);
	Route::resource('knowledge_area_groups', 'KnowledgeAreaGroupsController');

	Route::any('knowledge_languages/export', 'KnowledgeLanguagesController@export');
	Route::any('knowledge_languages/search', 'KnowledgeLanguagesController@search');
	Route::post('knowledge_languages/filter', ['as' => 'knowledge_languages.filter', 'uses' => 'KnowledgeLanguagesController@filter']);
	Route::resource('knowledge_languages', 'KnowledgeLanguagesController');

	Route::any('widgets/export', 'WidgetsController@export');
	Route::any('widgets/search', 'WidgetsController@search');
	Route::resource('widgets', 'WidgetsController');

	Route::any('cases/export', 'CasesController@export');
	Route::any('cases/search', 'CasesController@search');
	Route::any('cases/status_approve', 'CasesController@approve');
	Route::any('cases/status_disapprove', 'CasesController@disapprove');
	Route::resource('cases', 'CasesController');

	Route::any('locations/export', 'LocationsController@export');
	Route::any('locations/search', 'LocationsController@search');
	Route::resource('locations', 'LocationsController');

	Route::any('products/export', 'ProductsController@export');
	Route::any('products/search', 'ProductsController@search');
	Route::resource('products', 'ProductsController');

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

	Route::resource('toolbox', 'ToolboxController');
});

//Ajax requests
Route::get('/getclients', 'ClientLinksController@getClientsByUnit');

// TinyMCE Image Upload
Route::post('/imageupload', function()
{
  /*******************************************************
   * Only these origins will be allowed to upload images *
   ******************************************************/
  $accepted_origins = array("http://localhost", "http://192.168.1.1", "http://ftools.app", "http://tools.fipra.com", "https://fipratools.com");

  /*********************************************
   * Change this line to set the upload folder *
   *********************************************/
  $imageFolder = "uploads/forum/";

  reset ($_FILES);
  $temp = current($_FILES);
  if (is_uploaded_file($temp['tmp_name'])){
	  if (isset($_SERVER['HTTP_ORIGIN'])) {
		  // same-origin requests won't set an origin. If the origin is set, it must be valid.
		  if (in_array($_SERVER['HTTP_ORIGIN'], $accepted_origins)) {
			  header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
		  } else {
			  header("HTTP/1.0 403 Origin Denied");
			  return;
		  }
	  }

	  /*
		If your script needs to receive cookies, set images_upload_credentials : true in
		the configuration and enable the following two headers.
	  */
	  // header('Access-Control-Allow-Credentials: true');
	  // header('P3P: CP="There is no P3P policy."');

	  // Sanitize input
	  if (preg_match("/([^\w\s\d\-_~,;:\[\]\(\).])|([\.]{2,})/", $temp['name'])) {
		  header("HTTP/1.0 500 Invalid file name.");
		  return;
	  }

	  // Verify extension
	  if (!in_array(strtolower(pathinfo($temp['name'], PATHINFO_EXTENSION)), array("gif", "jpg", "png"))) {
		  header("HTTP/1.0 500 Invalid extension.");
		  return;
	  }

	  // Accept upload if there was no origin, or if it is an accepted origin
	  $filetowrite = $imageFolder . $temp['name'];
	  move_uploaded_file($temp['tmp_name'], $filetowrite);

	  // Respond to the successful upload with JSON.
	  // Use a location key to specify the path to the saved image resource.
	  // { location : '/your/uploaded/image/file'}
	  echo json_encode(array('location' => '/uploads/forum/' . $temp['name']));
  } else {
	  // Notify editor that the upload failed
	  header("HTTP/1.0 500 Server Error");
  }

});