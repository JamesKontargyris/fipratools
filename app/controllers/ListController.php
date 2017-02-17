<?php

use Leadofficelist\Clients\Client;

class ListController extends BaseController {

	public $section = 'list';
	public $resource_key = 'list';
	public $resource_permission = 'view_list';

	function __construct() {
		parent::__construct();
		$this->check_perm( 'view_list' );
		View::share( 'page_title', 'Client List' );
		View::share( 'key', 'list' );
	}

	public function index() {
		$this->destroyCurrentPageNumber( true );

		if ( $this->searchCheck() ) {
			// Keep any flashed messages when redirecting
			Session::reflash();

			return Redirect::to( $this->resource_key . '/search' );
		}

		$this->getFormData();
		$account_directors = $this->account_directors;
		$units             = $this->units;
		$sectors           = $this->sectors;
		$types             = $this->types;
		$services          = $this->services;

		$items      = Client::rowsHideShowDormant( $this->rows_hide_show_dormant )->rowsHideShowActive( $this->rows_hide_show_active )->rowsSortOrder( $this->rows_sort_order )->paginate( $this->rows_to_view );
		$items->key = 'list';

		return View::make( 'list.index' )->with( compact( 'items', 'account_directors', 'units', 'sectors', 'types', 'services' ) );
	}

	/**
	 * Process a list search.
	 *
	 * @return $this
	 */
	public function search() {
		if ( $search_term = $this->findSearchTerm() ) {
			if ( Session::get( $this->resource_key . '.SearchType' ) == 'filter' ) {
				$items = $this->getFiltered();
				$items->filter_value = $this->getFilteredValues();
			} else {
				$items = Client::where( 'name', 'LIKE', $search_term )->rowsHideShowDormant( Session::get( $this->resource_key . '.rowsHideShowDormant' ) )->rowsHideShowActive( Session::get( $this->resource_key . '.rowsHideShowActive' ) )->rowsSortOrder( $this->rows_sort_order )->paginate( $this->rows_to_view );
			}

			if ( ! $this->checkForSearchResults( $items ) ) {
				return Redirect::route( 'list.index' );
			}

			$items->search_term = str_replace( '%', '', $search_term );
			$items->key         = 'list';

			$this->getFormData();
			$account_directors = $this->account_directors;
			$units             = $this->units;
			$sectors           = $this->sectors;
			$types             = $this->types;
			$services          = $this->services;

			return View::make( 'list.index' )->with( compact( 'items', 'account_directors', 'units', 'sectors', 'types', 'services' ) );
		} else {
			return Redirect::route( 'list.index' );
		}
	}

	/**
	 * Display the about page.
	 *
	 * @return \Illuminate\View\View
	 */
	public function about() {
		return View::make( 'list.about' );
	}

	protected function getAll() {
		return Client::orderBy( 'name', 'ASC' )->rowsHideShowDormant( $this->rows_hide_show_dormant )->rowsHideShowActive( $this->rows_hide_show_active )->get();
	}

	protected function getSelection() {
		if ( $this->searchCheck() ) {
			$search_term             = $this->findSearchTerm();
			$this->search_term_clean = str_replace( '%', '', $search_term );

			$items = Client::rowsHideShowDormant( $this->rows_hide_show_dormant )->rowsHideShowActive( $this->rows_hide_show_active )->where( 'name', 'LIKE', $search_term )->rowsSortOrder( $this->rows_sort_order )->paginate( $this->rows_to_view );
		} else {
			$items = Client::rowsHideShowDormant( $this->rows_hide_show_dormant )->rowsHideShowActive( $this->rows_hide_show_active )->rowsSortOrder( $this->rows_sort_order )->paginate( $this->rows_to_view );
		}

		return $items;
	}

	protected function getFiltered($for = 'screen') {
		if($for == 'export') {
			// Get all results for PDF export
			$items = Client::rowsListFilter( Session::get( $this->resource_key . '.Filters' ) )->rowsHideShowDormant( Session::get( $this->resource_key . '.rowsHideShowDormant' ) )->rowsHideShowActive( Session::get( $this->resource_key . '.rowsHideShowActive' ) )->rowsSortOrder( $this->rows_sort_order )->get();
		} else {
			// Paginate results for screen display
			$items = Client::rowsListFilter( Session::get( $this->resource_key . '.Filters' ) )->rowsHideShowDormant( Session::get( $this->resource_key . '.rowsHideShowDormant' ) )->rowsHideShowActive( Session::get( $this->resource_key . '.rowsHideShowActive' ) )->rowsSortOrder( $this->rows_sort_order )->paginate( $this->rows_to_view );
		}

		return $items;
	}

	/**
	 * Get all data required to populate the add/edit user forms.
	 *
	 * @return bool
	 */
	protected function getFormData() {
		$this->account_directors = $this->getAccountDirectorsFormData( true, 'All' );
		$this->units             = $this->getUnitsFormData( true, 'All' );
		$this->sectors           = $this->getSectorsFormData( true, 'All' );
		$this->types             = $this->getTypesFormData( true, 'All' );
		$this->services          = $this->getServicesFormData( true, 'All' );

		return true;
	}

	protected function getFilterModelName($filter_name) {
		//Use the filter field value to instantiate the corresponding class and get the filter value's name
		$model_name        = ucfirst( str_replace( '_id', '', $filter_name ) );
		$model_name_plural = $model_name . 's';
		// Split model name by _
		$model_explode  = explode( '_', $model_name );
		$new_model_name = "";
		// Put model name back together without underscores
		foreach ( $model_explode as $part ) {
			$new_model_name .= ucfirst( $part );
		}
		$model_name_full = 'Leadofficelist\\' . $model_name_plural . '\\' . $new_model_name;

		return $model_name_full;
	}

	protected function getFilteredValues() {
		// Get names of filtered values
		$values = '';
		foreach(Session::get($this->resource_key . '.Filters') as $filter_name => $filter_value) {
			$model_name = $this->getFilterModelName($filter_name);
			$model      = new $model_name;
			//If filter is on account director, then the model will need to pull first_name and last_name from account _directors
			//rather than just name.
			if ( strpos( $model_name, 'Account_directors' ) ) {
				$ad                  = $model::find( $filter_value );
				$values .= $ad->first_name . ' ' . $ad->last_name . ', ';
			} else {
				$values .= $model::find( $filter_value )->name . ', ';
			}
		}

		 return rtrim($values, ', ');
	}
}