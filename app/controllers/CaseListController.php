<?php

use Leadofficelist\Account_directors\AccountDirector;
use Leadofficelist\Cases\CaseStudy;
use Leadofficelist\Products\Product;
use Leadofficelist\Sectors\Sector;

class CaseListController extends BaseController {
	public $resource_key = 'caselist';
	public $resource_permission = 'view_list';

	function __construct() {
		parent::__construct();
		$this->check_perm( 'view_list' );
		View::share( 'page_title', 'All Case Studies' );
		View::share( 'key', 'caselist' );
	}

	public function index() {
		$this->destroyCurrentPageNumber( true );

		if ( $this->searchCheck() ) {
			return Redirect::to( $this->resource_key . '/search' );
		}

		$this->getFormData();
		$account_directors = $this->account_directors;
		$units             = $this->units;
		$sectors           = $this->sectors;
		$locations         = $this->locations;
		$products          = $this->products;
		$years             = $this->years;

		$items      = CaseStudy::where('status', '=', 1)->rowsSortOrder( $this->rows_sort_order )->paginate( $this->rows_to_view );
		$items->key = 'caselist';

		return View::make( 'caselist.index' )->with( compact( 'items', 'account_directors', 'units', 'sectors', 'locations', 'products', 'years' ) );
	}

	/**
	 * Process a list search.
	 *
	 * @return $this
	 */
	public function search() {
		if ( $search_term = $this->findSearchTerm() ) {
			if ( Session::get( $this->resource_key . '.SearchType' ) == 'filter' ) {
				$items = CaseStudy::rowsListFilter( $this->rows_list_filter_field, $this->rows_list_filter_value )->rowsSortOrder( $this->rows_sort_order )->paginate( $this->rows_to_view );

				$model_name = $this->getFilterModelName();
				//If filter is an account director, then the model will need to pull first_name and last_name from account _directors
				//rather than just name.
				if ( strpos( $model_name, 'Account_directors' ) ) {
					$ad                  = AccountDirector::find( Session::get( $this->resource_key . '.rowsListFilterValue' ) );
					$items->filter_value = $ad->first_name . ' ' . $ad->last_name;

				} elseif ( strpos( $model_name, 'Years' ) ) {
					// If the filter is years, no need to instantiate a model as it is just a field dealt with by the CaseStudy model
					$items->filter_value = Session::get( $this->resource_key . '.rowsListFilterValue' );

				} elseif ( strpos( $model_name, 'Products' ) ) {
//					If the filter is a product, we need to compare the keyword to the serialized product array
//					Re-run the query on that basis
					$term = '%"' . Session::get($this->resource_key . '.SearchTerm') . '"%';
					$items        = CaseStudy::where( 'product_id', 'LIKE', $term)->rowsSortOrder( $this->rows_sort_order )->paginate( $this->rows_to_view );

					$items->filter_value = Product::find( Session::get( $this->resource_key . '.rowsListFilterValue' ) )->name;

				} elseif ( strpos( $model_name, 'Sectors' ) ) {
//					If the filter is a sector, we need to compare the keyword to the serialized sector array
//					Re-run the query on that basis
					$term  = '%"' . Session::get( $this->resource_key . '.SearchTerm' ) . '"%';
					$items = CaseStudy::where( 'sector_id', 'LIKE', $term )->rowsSortOrder( $this->rows_sort_order )->paginate( $this->rows_to_view );

					$items->filter_value = Sector::find( Session::get( $this->resource_key . '.rowsListFilterValue' ) )->name;
				} else {
					$model               = new $model_name;
					$items->filter_value = $model::find( Session::get( $this->resource_key . '.rowsListFilterValue' ) )->name;
				}
			} else {
				$items = CaseStudy::where( 'name', 'LIKE', $search_term )->rowsSortOrder( $this->rows_sort_order )->paginate( $this->rows_to_view );
			}

			if ( ! $this->checkForSearchResults( $items ) ) {
				return Redirect::route( 'caselist.index' );
			}

			$items->search_term = str_replace( '%', '', $search_term );
			$items->key         = 'caselist';

			$this->getFormData();
			$account_directors = $this->account_directors;
			$units             = $this->units;
			$sectors           = $this->sectors;
			$locations         = $this->locations;
			$products          = $this->products;
			$years             = $this->years;

			return View::make( 'caselist.index' )->with( compact( 'items', 'account_directors', 'units', 'sectors', 'locations', 'products', 'years' ) );
		} else {
			return Redirect::route( 'caselist.index' );
		}
	}

	protected function getAll()
	{
		return CaseStudy::where('status', '=', 1)->orderBy('id', 'DESC')->get();
	}

	protected function getSelection()
	{
		if ( $this->searchCheck() )
		{
			$search_term = $this->findSearchTerm();
			$this->search_term_clean = str_replace('%', '', $search_term);

			$items = CaseStudy::where('status', '=', 1)->where( 'name', 'LIKE', $search_term )->rowsSortOrder( $this->rows_sort_order )->paginate( $this->rows_to_view );
		}
		else
		{
			$items = CaseStudy::rowsSortOrder( $this->rows_sort_order )->paginate( $this->rows_to_view );
		}

		return $items;
	}

	protected function getFiltered() {
		$items = CaseStudy::rowsListFilter( $this->rows_list_filter_field, $this->rows_list_filter_value )->rowsSortOrder( $this->rows_sort_order )->get();

		$model_name = $this->getFilterModelName();
		//If filter is an account director, then the model will need to pull first_name and last_name from account _directors
		//rather than just name.
		if ( strpos( $model_name, 'Account_directors' ) ) {
			$model               = new $model_name;
			$ad                  = $model::find( Session::get( $this->resource_key . '.rowsListFilterValue' ) );
			$items->filter_value = $ad->first_name . ' ' . $ad->last_name;
		} elseif ( strpos( $model_name, 'Years' ) ) {
			$items->filter_value = 'Years';
		} else {
			$model               = new $model_name;
			$items->filter_value = $model::find( Session::get( $this->resource_key . '.rowsListFilterValue' ) )->name;
		}

		return $items;
	}

	/**
	 * Get all data required to populate the add/edit user forms.
	 *
	 * @return bool
	 */
	protected function getFormData() {
		$this->account_directors = $this->getAccountDirectorsFormData( true, 'Filter...' );
		$this->units             = $this->getUnitsFormData( true, 'Filter...' );
		$this->sectors           = $this->getSectorsFormData( true, 'Filter...' );
		$this->types             = $this->getTypesFormData( true, 'Filter...' );
		$this->services          = $this->getServicesFormData( true, 'Filter...' );
		$this->locations         = $this->getLocationsFormData( true, 'Filter...' );
		$this->products          = $this->getProductsFormData( true, 'Filter...' );
		$this->years             = $this->getYearsFormData( true, 'Filter...' );

		return true;
	}

	protected function getFilterModelName() {
		//Use the filter field value to instantiate the corresponding class and get the filter value's name
		$model_name        = ucfirst( str_replace( '_id', '', Session::get( $this->resource_key . '.rowsListFilterField' ) ) );
		$model_name_plural = $model_name . 's';
		$model_explode     = explode( '_', $model_name );
		$new_model_name    = "";
		foreach ( $model_explode as $part ) {
			$new_model_name .= ucfirst( $part );
		}
		$model_name_full = 'Leadofficelist\\' . $model_name_plural . '\\' . $new_model_name;

		return $model_name_full;
	}
}