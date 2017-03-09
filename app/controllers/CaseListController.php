<?php

use Leadofficelist\Account_directors\AccountDirector;
use Leadofficelist\Cases\CaseStudy;
use Leadofficelist\Products\Product;
use Leadofficelist\Sector_categories\Sector_category;
use Leadofficelist\Sectors\Sector;

class CaseListController extends BaseController {

	public $section = 'case';
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
		$sector_categories = $this->sector_categories;
		$products          = $this->products;
		$years             = $this->years;
		$items             = CaseStudy::where( 'status', '=', 1 )->rowsSortOrder( $this->rows_sort_order )->paginate( $this->rows_to_view );
		$items->key        = 'caselist';

		return View::make( 'caselist.index' )->with( compact( 'items', 'account_directors', 'units', 'sectors', 'sector_categories', 'locations', 'products', 'years' ) );
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
			$sector_categories = $this->sector_categories;
			$locations         = $this->locations;
			$products          = $this->products;
			$years             = $this->years;

			return View::make( 'caselist.index' )->with( compact( 'items', 'account_directors', 'units', 'sectors', 'sector_categories', 'locations', 'products', 'years' ) );
		} else {
			return Redirect::route( 'caselist.index' );
		}
	}

	protected function getAll() {
		return CaseStudy::where( 'status', '=', 1 )->orderBy( 'year', 'DESC' )->get();
	}

	protected function getSelection() {
		if ( $this->searchCheck() ) {
			$search_term             = $this->findSearchTerm();
			$this->search_term_clean = str_replace( '%', '', $search_term );

			$items = CaseStudy::where( 'status', '=', 1 )->where( 'name', 'LIKE', $search_term )->rowsSortOrder( $this->rows_sort_order )->paginate( $this->rows_to_view );
		} else {
			$items = CaseStudy::where( 'status', '=', 1 )->rowsSortOrder( $this->rows_sort_order )->paginate( $this->rows_to_view );
		}

		return $items;
	}

	protected function getFiltered( $for = 'screen' ) {
		// Get a replica of the filters so we can play with them, without affecting the original
		$filters = Session::get( $this->resource_key . '.Filters' );
		// Get a blank Eloquent model
		$items = CaseStudy::whereNotNull('id')->where('status', '=', 1);
		// Where functions are split across all columns to ensure filters work correctly
		$items->where(function($query) use ($filters)
		{
			if ( isset( $filters['sector_id'] ) ) {
				// Get the sector_id of the selected sector and prepare it for a LIKE SQL query
				foreach ( $filters['sector_id'] as $id ) {
					$query->orWhere( 'sector_id', 'LIKE', '%"' . $id . '"%' );
				}
				// Remove sector_id from the filters so it isn't included when the filters are run in a minute
				unset( $filters['sector_id'] );
			}

			if ( isset( $filters['sector_category_id'] ) ) {
				echo "Hello";
				// Iterate through sector category ids and grab sectors assigned to them
				foreach ( $filters['sector_category_id'] as $id ) {
					// Get the sector_ids of sectors assigned to the the selected sector category and prepare them for a LIKE SQL query
					foreach ( Sector::where( 'category_id', '=', $id )->get() as $sector ) {
						$query->orWhere( 'sector_id', 'LIKE', '%"' . $sector->id . '"%' );
					}
				}
				// Remove sector_category_id from the filters so it isn't included when the filters are run in a minute
				unset( $filters['sector_category_id'] );
			}
		})->where(function($query) use ($filters)
		{
			if ( isset( $filters['product_id'] ) ) {
				// Get the product_id of the selected sector and prepare it for a LIKE SQL query
				foreach ( $filters['product_id'] as $id ) {
					$product_ids[] = '%"' . $id . '"%';
				}
				foreach ( $product_ids as $id ) {
					$query->orWhere( 'product_id', 'LIKE', $id );
				}
			}
		})->where(function($query) use ($filters)
		{
			if ( isset( $filters['year'] ) ) {
				foreach ( $filters['year'] as $year ) {
					$query->orWhere( 'year', '=', $year );
				}
			}
		})->where(function($query) use ($filters)
		{
			if ( isset( $filters['unit_id'] ) ) {
				// Get the product_id of the selected sector and prepare it for a LIKE SQL query
				foreach ( $filters['unit_id'] as $id ) {
					$query->orWhere( 'unit_id', '=', $id );
				}
			}
		})->where(function($query) use ($filters)
		{
			if ( isset( $filters['account_director_id'] ) ) {
				// Get the product_id of the selected sector and prepare it for a LIKE SQL query
				foreach ( $filters['account_director_id'] as $id ) {
					$query->orWhere( 'account_director_id', '=', $id );
				}
			}
		})->where( 'status', '=', 1 )->rowsSortOrder( $this->rows_sort_order );

		if ( $for == 'export' ) {
			// Get all results for PDF export
			return $items->get();
		} else {
			// Paginate results for screen display
			return $items->paginate( $this->rows_to_view );
		}
	}

	protected function getFilteredValues() {
		// Get names of filtered values
		$values = '';
		foreach ( Session::get( $this->resource_key . '.Filters' ) as $filter_name => $filter_array ) {
			$model_name = $this->getFilterModelName( $filter_name );
			if ( strpos( $model_name, 'Account_directors' ) ) {
				//If filter is an account director, then the model will need to pull first_name and last_name from account _directors
				//rather than just name.
				foreach ( $filter_array as $id ) {
					$ad = AccountDirector::find( $id );
					$values .= $ad->first_name . ' ' . $ad->last_name . ', ';
				}

			} elseif ( strpos( $model_name, 'Years' ) ) {
				// If the filter is years, no need to instantiate a model as it is just a field dealt with by the CaseStudy model
				foreach ( $filter_array as $year ) {
					$values .= $year . ', ';
				}

			} elseif ( strpos( $model_name, 'Products' ) ) {
//					If the filter is a product, we need to compare the keyword to the serialized product array
//					Re-run the query on that basis
				foreach ( $filter_array as $id ) {
					$values .= Product::find( $id )->name . ', ';
				}

			} elseif ( strpos( $model_name, 'Sectors' ) ) {
//					If the filter is a sector, we need to compare the keyword to the serialized sector array
//					Re-run the query on that basis
				foreach ( $filter_array as $id ) {
					$values .= Sector::find( $id )->name . ', ';
				}
			} elseif ( strpos( $model_name, 'Sector_categories' ) ) {
//					If the filter is a sector category, we need to pull the name using a slightly different model name
				foreach ( $filter_array as $id ) {
					$values .= Sector_category::find( $id )->name . ', ';
				}
			} else {
				$model = new $model_name;
				foreach ( $filter_array as $id ) {
					$values .= $model::find( $id )->name . ', ';
				}
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
		$this->sector_categories = $this->getSectorCategoriesFormData( true, 'All' );
		$this->types             = $this->getTypesFormData( true, 'All' );
		$this->services          = $this->getServicesFormData( true, 'All' );
		$this->locations         = $this->getLocationsFormData( true, 'All' );
		$this->products          = $this->getProductsFormData( true, 'All' );
		$this->years             = $this->getYearsFormData( true, 'All' );

		return true;
	}
}