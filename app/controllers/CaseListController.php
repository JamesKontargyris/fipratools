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
			// Keep any flashed messages when redirecting
			Session::reflash();

			return Redirect::to( $this->resource_key . '/search' );
		}

		$this->getFormData();
		$account_directors = $this->account_directors;
		$units             = $this->units;
		$sectors           = $this->sectors;
		$locations         = $this->locations;
		$products          = $this->products;
		$years             = $this->years;

		$items      = CaseStudy::where( 'status', '=', 1 )->rowsSortOrder( $this->rows_sort_order )->paginate( $this->rows_to_view );
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
				$items               = $this->getFiltered();
				$items->filter_value = $this->getFilteredValues();
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

	protected function getAll() {
		return CaseStudy::where( 'status', '=', 1 )->orderBy( 'id', 'DESC' )->get();
	}

	protected function getSelection() {
		if ( $this->searchCheck() ) {
			$search_term             = $this->findSearchTerm();
			$this->search_term_clean = str_replace( '%', '', $search_term );

			$items = CaseStudy::where( 'status', '=', 1 )->where( 'name', 'LIKE', $search_term )->rowsSortOrder( $this->rows_sort_order )->paginate( $this->rows_to_view );
		} else {
			$items = CaseStudy::rowsSortOrder( $this->rows_sort_order )->paginate( $this->rows_to_view );
		}

		return $items;
	}

	protected function getFiltered( $for = 'screen' ) {
		if ( $for == 'export' ) {
			// Get all results for PDF export
			// Both sector_id and product_id are set
			if(Session::has( $this->resource_key . '.Filters.sector_id' ) && Session::has( $this->resource_key . '.Filters.product_id' )) {
				// Get the sector_id of the selected sector and prepare it for a LIKE SQL query
				$sector_term  = '%"' . Session::get( $this->resource_key . '.Filters.sector_id' ) . '"%';
				// Get the product_id of the selected product and prepare it for a LIKE SQL query
				$product_term  = '%"' . Session::get( $this->resource_key . '.Filters.product_id' ) . '"%';
				// Get the filters array then unset the sector and product filters, so they doesn't overwrite the where clauses below
				$filters_minus_sector_id_product_id = Session::get( $this->resource_key . '.Filters' );
				unset($filters_minus_sector_id_product_id['sector_id']);
				unset($filters_minus_sector_id_product_id['product_id']);
				// Get results with the modified sector_id and product_id where clauses
				$items = CaseStudy::where( 'sector_id', 'LIKE', $sector_term )->where( 'product_id', 'LIKE', $product_term )->rowsListFilter( $filters_minus_sector_id_product_id )->rowsSortOrder( $this->rows_sort_order )->get();
			}
			// sector_id is set
			elseif(Session::has( $this->resource_key . '.Filters.sector_id' ) && ! Session::has( $this->resource_key . '.Filters.product_id' )) {
				// Get the sector_id of the selected sector and prepare it for a LIKE SQL query
				$sector_term  = '%"' . Session::get( $this->resource_key . '.Filters.sector_id' ) . '"%';
				// Get the filters array then unset the sector filter, so it doesn't overwrite the where clause below
				$filters_minus_sector_id = Session::get( $this->resource_key . '.Filters' );
				unset($filters_minus_sector_id['sector_id']);
				// Get results with the modified sector_id where clause
				$items = CaseStudy::where( 'sector_id', 'LIKE', $sector_term )->rowsListFilter( $filters_minus_sector_id )->rowsSortOrder( $this->rows_sort_order )->get();
			}
			// product_id is set
			elseif(! Session::has( $this->resource_key . '.Filters.sector_id' ) && Session::has( $this->resource_key . '.Filters.product_id' )) {
				// Get the product_id of the selected sector and prepare it for a LIKE SQL query
				$sector_term  = '%"' . Session::get( $this->resource_key . '.Filters.product_id' ) . '"%';
				// Get the filters array then unset the sector filter, so it doesn't overwrite the where clause below
				$filters_minus_product_id = Session::get( $this->resource_key . '.Filters' );
				unset($filters_minus_product_id['product_id']);
				// Get results with the modified product_id where clause
				$items = CaseStudy::where( 'product_id', 'LIKE', $sector_term )->rowsListFilter( $filters_minus_product_id )->rowsSortOrder( $this->rows_sort_order )->get();
			}
			// Neither sector_id nor product_id are set
			else {
				$items = CaseStudy::rowsListFilter( Session::get( $this->resource_key . '.Filters' ) )->rowsSortOrder( $this->rows_sort_order )->get();
			}
		} else {
			// Paginate results for screen display
			// Both sector_id and product_id are set
			if(Session::has( $this->resource_key . '.Filters.sector_id' ) && Session::has( $this->resource_key . '.Filters.product_id' )) {
				// Get the sector_id of the selected sector and prepare it for a LIKE SQL query
				$sector_term  = '%"' . Session::get( $this->resource_key . '.Filters.sector_id' ) . '"%';
				// Get the product_id of the selected product and prepare it for a LIKE SQL query
				$product_term  = '%"' . Session::get( $this->resource_key . '.Filters.product_id' ) . '"%';
				// Get the filters array then unset the sector and product filters, so they doesn't overwrite the where clauses below
				$filters_minus_sector_id_product_id = Session::get( $this->resource_key . '.Filters' );
				unset($filters_minus_sector_id_product_id['sector_id']);
				unset($filters_minus_sector_id_product_id['product_id']);
				// Get results with the modified sector_id and product_id where clauses
				$items = CaseStudy::where( 'sector_id', 'LIKE', $sector_term )->where( 'product_id', 'LIKE', $product_term )->rowsListFilter( $filters_minus_sector_id_product_id )->rowsSortOrder( $this->rows_sort_order )->paginate( $this->rows_to_view );
			}
			// sector_id is set
			elseif(Session::has( $this->resource_key . '.Filters.sector_id' ) && ! Session::has( $this->resource_key . '.Filters.product_id' )) {
				// Get the sector_id of the selected sector and prepare it for a LIKE SQL query
				$sector_term  = '%"' . Session::get( $this->resource_key . '.Filters.sector_id' ) . '"%';
				// Get the filters array then unset the sector filter, so it doesn't overwrite the where clause below
				$filters_minus_sector_id = Session::get( $this->resource_key . '.Filters' );
				unset($filters_minus_sector_id['sector_id']);
				// Get results with the modified sector_id where clause
				$items = CaseStudy::where( 'sector_id', 'LIKE', $sector_term )->rowsListFilter( $filters_minus_sector_id )->rowsSortOrder( $this->rows_sort_order )->paginate( $this->rows_to_view );
			}
			// product_id is set
			elseif(! Session::has( $this->resource_key . '.Filters.sector_id' ) && Session::has( $this->resource_key . '.Filters.product_id' )) {
				// Get the product_id of the selected sector and prepare it for a LIKE SQL query
				$sector_term  = '%"' . Session::get( $this->resource_key . '.Filters.product_id' ) . '"%';
				// Get the filters array then unset the sector filter, so it doesn't overwrite the where clause below
				$filters_minus_product_id = Session::get( $this->resource_key . '.Filters' );
				unset($filters_minus_product_id['product_id']);
				// Get results with the modified product_id where clause
				$items = CaseStudy::where( 'product_id', 'LIKE', $sector_term )->rowsListFilter( $filters_minus_product_id )->rowsSortOrder( $this->rows_sort_order )->paginate( $this->rows_to_view );
			}
			// Neither sector_id nor product_id are set
			else {
				$items = CaseStudy::rowsListFilter( Session::get( $this->resource_key . '.Filters' ) )->rowsSortOrder( $this->rows_sort_order )->paginate( $this->rows_to_view );
			}
		}

		return $items;

	}

	protected function getFilteredValues() {
		// Get names of filtered values
		$values = '';
		foreach ( Session::get( $this->resource_key . '.Filters' ) as $filter_name => $filter_value ) {
			$model_name = $this->getFilterModelName( $filter_name );
			//If filter is an account director, then the model will need to pull first_name and last_name from account _directors
			//rather than just name.
			if ( strpos( $model_name, 'Account_directors' ) ) {
				$ad = AccountDirector::find( $filter_value );
				$values .= $ad->first_name . ' ' . $ad->last_name . ', ';

			} elseif ( strpos( $model_name, 'Years' ) ) {
				// If the filter is years, no need to instantiate a model as it is just a field dealt with by the CaseStudy model
				$values .= $filter_value . ', ';

			} elseif ( strpos( $model_name, 'Products' ) ) {
//					If the filter is a product, we need to compare the keyword to the serialized product array
//					Re-run the query on that basis
				$term  = '%"' . Session::get( $this->resource_key . '.Filters.product_id' ) . '"%';
				$items = CaseStudy::where( 'product_id', 'LIKE', $term )->rowsSortOrder( $this->rows_sort_order )->paginate( $this->rows_to_view );

				$values .= Product::find( $filter_value )->name . ', ';

			} elseif ( strpos( $model_name, 'Sectors' ) ) {
//					If the filter is a sector, we need to compare the keyword to the serialized sector array
//					Re-run the query on that basis
				$term  = '%"' . Session::get( $this->resource_key . '.Filters.sector_id' ) . '"%';
				$items = CaseStudy::where( 'sector_id', 'LIKE', $term )->rowsSortOrder( $this->rows_sort_order )->paginate( $this->rows_to_view );

				$values .= Sector::find( $filter_value )->name . ', ';
			} else {
				$model = new $model_name;
				$values .= $model::find( $filter_value )->name . ', ';
			}
		}

		return rtrim( $values, ', ' );
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
		$this->locations         = $this->getLocationsFormData( true, 'All' );
		$this->products          = $this->getProductsFormData( true, 'All' );
		$this->years             = $this->getYearsFormData( true, 'All' );

		return true;
	}
}