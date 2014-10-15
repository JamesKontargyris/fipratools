<?php

use Leadofficelist\Clients\Client;

class ListController extends BaseController
{
	public $resource_key = 'list';

	function __construct( )
	{
		parent::__construct();
		$this->check_perm('view_list');
		View::share( 'page_title', 'Client List' );
		View::share( 'key', 'list' );
	}

	public function index()
	{
		if ( $this->searchCheck() )
		{
			return Redirect::to( $this->resource_key . '/search' );
		}

		$this->getFormData();
		$units    = $this->units;
		$sectors  = $this->sectors;
		$types    = $this->types;
		$services = $this->services;

		$items = Client::rowsSortOrder( $this->rows_sort_order )->paginate( $this->rows_to_view );
		$items->key = 'list';

		return View::make( 'list.index' )->with( compact( 'items', 'units', 'sectors', 'types', 'services' ) );
	}

	/**
	 * Process a list search.
	 *
	 * @return $this
	 */
	public function search()
	{
		if ( $search_term = $this->findSearchTerm() )
		{
			if(Session::get( $this->resource_key . '.SearchType') == 'filter')
			{
				$items = Client::rowsListFilter($this->rows_list_filter_field, $this->rows_list_filter_value)->rowsSortOrder( $this->rows_sort_order )->paginate( $this->rows_to_view );

				$model_name = $this->getFilterModelName();
				$model = new $model_name;
				$items->filter_value = $model::find(Session::get($this->resource_key . '.rowsListFilterValue'))->name;
			}
			else
			{
				$items = Client::where( 'name', 'LIKE', $search_term )->rowsSortOrder( $this->rows_sort_order )->paginate( $this->rows_to_view );
			}

			if ( ! $this->checkForSearchResults( $items ) )
			{
				return Redirect::route( 'list.index' );
			}

			$items->search_term = str_replace( '%', '', $search_term );
			$items->key         = 'list';

			$this->getFormData();
			$units    = $this->units;
			$sectors  = $this->sectors;
			$types    = $this->types;
			$services = $this->services;

			return View::make( 'list.index' )->with( compact( 'items', 'units', 'sectors', 'types', 'services' ) );
		} else
		{
			return Redirect::route('list.index');
		}
	}

	/**
	 * Get all data required to populate the add/edit user forms.
	 *
	 * @return bool
	 */
	protected function getFormData()
	{
		$this->units    = $this->getUnitsFormData(true, 'Filter...');
		$this->sectors  = $this->getSectorsFormData(true, 'Filter...');
		$this->types    = $this->getTypesFormData(true, 'Filter...');
		$this->services = $this->getServicesFormData(true, 'Filter...');

		return true;
	}

	protected function getFilterModelName()
	{
		//Use the filter field value to instantiate to corresponding class and get the filter value's name
		$model_name = ucfirst(str_replace('_id', '', Session::get($this->resource_key . '.rowsListFilterField')));
		$model_name_plural = $model_name . 's';
		$model_name_full = 'Leadofficelist\\' . $model_name_plural . '\\' .$model_name;
		return $model_name_full;
	}
}