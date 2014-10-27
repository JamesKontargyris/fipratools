<?php

use Ignited\Pdf\Facades\Pdf;
use Laracasts\Flash\Flash;
use Leadofficelist\Account_directors\AccountDirector;
use Leadofficelist\Clients\Client;
use Leadofficelist\Exceptions\PermissionDeniedException;
use Leadofficelist\Sectors\Sector;
use Leadofficelist\Services\Service;
use Leadofficelist\Types\Type;
use Leadofficelist\Units\Unit;
use Leadofficelist\Users\User;

class BaseController extends Controller
{

	protected $user;
	protected $rows_sort_order;
	protected $rows_to_view;
	protected $rows_list_filter_field;
	protected $rows_list_filter_value;
	protected $rows_hide_show_dormant;
	protected $userFullName;
	protected $account_directors;
	protected $units;
	protected $sectors;
	protected $types;
	protected $services;
	protected $export_filename;
	protected $search_term_clean;

	/**
	 * Array of filter keys to reset when "reset filters" is clicked
	 *
	 * @var array
	 */
	protected $filter_keys = [ 'rowsToView', 'rowsSort', 'rowsNameOrder', 'rowsHideShowDormant' ];

	function __construct()
	{
		$this->user = Auth::user();
		if ( isset( $this->user->id ) )
		{
			View::share( 'user', $this->user );
			View::share( 'user_full_name', $this->user->getFullName() );
			View::share( 'user_unit', $this->user->unit()->pluck( 'name' ) );
			View::share( 'user_role', $this->user->roles()->pluck( 'name' ) );
		}

		$this->reset_sorting();
		$this->rows_sort_order        = $this->getRowsSortOrder( $this->resource_key );
		$this->rows_to_view           = $this->getRowsToView( $this->resource_key );
		$this->name_order             = $this->getNameOrder( $this->resource_key );
		$this->rows_list_filter_field = $this->getRowsListFilterField( $this->resource_key );
		$this->rows_list_filter_value = $this->getRowsListFilterValue( $this->resource_key );
		$this->name_order             = $this->getNameOrder( $this->resource_key );
		$this->rows_hide_show_dormant = $this->getRowsHideShowDormant( $this->resource_key );

		$this->export_filename = $this->resource_key . '_' . date('y-m-d_G-i');
	}

	/**
	 * Export data to PDF or Excel
	 *
	 * @return bool|\Illuminate\Http\RedirectResponse
	 * @throws Exception
	 */
	public function export()
	{
		if(Input::has('filetype'))
		{
			switch(Input::get('filetype'))
			{
				case 'pdf_all':
					$contents = $this->PDFExportAll($this->resource_permission, $this->getAll());
					$this->generatePDF($contents, $this->export_filename . '.pdf');
					return true;
					break;

				case 'pdf_selection':
					$contents = $this->PDFExportSelection($this->resource_permission, $this->getSelection());
					$this->generatePDF($contents, $this->export_filename . '_selection.pdf');
					return true;
					break;
			}
		}
		else
		{
			Flash::message('Error: no file type given or cannot export to that file type.');
			return Redirect::route($this->resource_key . '.index');
		}
	}

	/**
	 * Export all records for a resource to a PDF file
	 *
	 * @param string $permission
	 * @param $items
	 *
	 * @return string
	 * @throws PermissionDeniedException
	 */
	protected function PDFExportAll($permission = 'view_list', $items)
	{
		$this->check_perm( $permission );
		$key = is_request('list') ? 'clients' : $this->resource_key;
		//Clients and List specific variables
		$active_count = 0;
		$dormant_count = 0;

		$heading1 = is_request('list') ?
			'Full List' :
			'All ' . clean_key($key);

		$heading2 = number_format($items->count(), 0) . ' total ' . clean_key($key);
		if(is_request('clients') || is_request('list')) {
			$active_count = $this->getActiveCount();
			$dormant_count = $this->getDormantCount();
		}
		$view = View::make( 'export.' . $this->resource_key, ['items' => $items, 'heading1' => $heading1, 'heading2' => $heading2, 'active_count' => $active_count, 'dormant_count' => $dormant_count,] );

		return (string) $view;
	}

	/**
	 * Export a visible selection of records for a resource to a PDF file
	 *
	 * @param string $permission
	 * @param $items
	 *
	 * @return string
	 * @throws PermissionDeniedException
	 */
	protected function PDFExportSelection($permission = 'view_list', $items)
	{
		$this->check_perm( $permission );
		$key = is_request('list') ? 'clients' : $this->resource_key;

		$heading1 = ucfirst(clean_key($this->resource_key)) . ' Selection';
		$heading2 = isset($this->search_term_clean) ?
			'Showing ' . number_format($items->count(), 0) . ' ' . clean_key($key) . ' when searching for ' . Session::get($this->resource_key . '.SearchType') . ' "' . $this->search_term_clean . '"' :
			'Showing ' . number_format($items->count(), 0) . ' ' . clean_key($key);
		$view = View::make( 'export.' . $this->resource_key, ['items' => $items, 'heading1' => $heading1, 'heading2' => $heading2] );

		return (string) $view;
	}

	/**
	 * Generate a PDF file
	 *
	 * @param $contents
	 * @param $filename
	 * @param bool $cover_page
	 *
	 * @throws Exception
	 */
	protected function generatePDF($contents, $filename, $cover_page = true)
	{
		$header_right = 'Fipra Lead Office List';
		$footer_left = 'Generated at [time] on [date]';
		$footer_center = 'Page [page] of [toPage]';
		$footer_right = 'Private and Confidential';
		$pdf = PDF::make();
		$pdf->setOptions(array(
			'orientation' => 'landscape',
			'margin-top' => '15',
			'header-font-size' => '8',
			'header-spacing' => '5',
			'header-right' => $header_right,
			'footer-font-size' => '8',
			'footer-left' => $footer_left,
			'footer-center' => $footer_center,
			'footer-right' => $footer_right,
			'image-quality' => '100',
			'images'
		));
		if($cover_page)
		{
			$heading1 = 'About the Lead Office List';
			$cover_page = View::make('export.coverpage')->with(compact('heading1'));
			$pdf->addPage($cover_page->render());
		}
		$pdf->addPage($contents);
		if(!$pdf->send()) throw new Exception('Could not create PDF: '.$pdf->getError());
	}


	/**
	 * If reset_sorting is set to yes, reset all session keys
	 * listed in $filter_keys
	 *
	 * @return bool
	 */
	protected function reset_sorting()
	{
		if ( Input::has( 'reset_sorting' ) )
		{
			foreach ( $this->filter_keys as $key )
			{
				Session::forget( $this->resource_key . '.' . $key );
			}
		}

		return true;
	}

	/**
	 * Process the 'view' value passed in the query string and return the correct value
	 *
	 * @return int|mixed
	 */
	protected function getRowsToView( $key )
	{
		//If the value passed in is 'all', set the valye to 99999. Otherwise,
		//use the value passed in, which should be numeric
		$value = ( Input::get( 'view' ) == 'all' ) ? 99999 : Input::get( 'view' );
		//Value passed in and it is numeric?
		if ( Input::has( 'view' ) && is_numeric( $value ) )
		{
			Session::set( $key . '.rowsToView', $value );

			return $value;
		} //Session value exists for rowsToView?
		elseif ( Session::get( $key . '.rowsToView' ) )
		{
			return Session::get( $key . '.rowsToView' );
		} //If all else fails...
		else
		{
			return 10;
		}
	}

	/**
	 * Process the 'sort' value passed in the query string and return the correct value
	 *
	 * @return array
	 */
	protected function getRowsSortOrder( $key )
	{
		//Array of column names that will be sorted on, and how they should be ordered
		$sort_on = [ 'az' => 'name.asc', 'za' => 'name.desc', 'newest' => 'id.desc', 'oldest' => 'id.asc' ];
		//Different column names in the users and account_directors table
		$sort_on_users_ads = [
			'az'     => 'last_name.asc',
			'za'     => 'last_name.desc',
			'newest' => 'id.desc',
			'oldest' => 'id.asc'
		];

		//Value passed in and exists in the $sort_on variable?
		if ( Input::has( 'sort' ) )
		{
			//If a sort term is passed in in the query string, store it in the session
			//and return the column and order to sort on
			$sort_term = Input::get( 'sort' );
			if ( ! $this->is_request( 'account_directors' ) && ! $this->is_request( 'users' ) && isset( $sort_on[ Input::get( 'sort' ) ] ) )
			{
				Session::set( $key . '.rowsSort', $sort_on[ $sort_term ] );

				return explode( '.', $sort_on[ $sort_term ] );
			} elseif ( $this->is_request( 'users' ) || $this->is_request( 'account_directors' ) )
			{
				Session::set( $key . '.rowsSort', $sort_on_users_ads[ $sort_term ] );

				return explode( '.', $sort_on_users_ads[ $sort_term ] );
			}
		} //Session value exists for rowsSort?
		elseif ( Session::get( $key . '.rowsSort' ) )
		{
			return explode( '.', Session::get( $key . '.rowsSort' ) );
		} //If all else fails...
		else
		{
			return ( $this->is_request( 'users' ) || $this->is_request('account_directors') ) ? [ 'last_name', 'asc' ] : [ 'name', 'asc' ];
		}

		return false;
	}

	/**
	 * Process the 'view' value passed in the query string and return the correct value
	 *
	 * @return int|mixed
	 */
	protected function getRowsHideShowDormant( $key )
	{
		//If the value passed in is 'all', set the valye to 99999. Otherwise,
		//use the value passed in, which should be numeric
		//Value passed in and it is numeric?
		if ( Input::has( 'dormant' ) && Input::get( 'dormant' ) == 'show' )
		{
			Session::set( $key . '.rowsHideShowDormant', 'show' );

			return 'show';
		} elseif ( Input::has( 'dormant' ) && Input::get( 'dormant' ) == 'hide' )
		{
			Session::set( $key . '.rowsHideShowDormant', 'hide' );

			return 'hide';
		} elseif ( Session::get( $key . '.rowsHideShowDormant' ) )
		{
			return Session::get( $key . '.rowsHideShowDormant' );
		}

		//If all else fails...
		return 'hide';
	}

	protected function getNameOrder( $key )
	{
		$value = Input::get( 'name' );
		//Value passed in?
		if ( $value )
		{
			Session::set( $key . '.rowsNameOrder', $value );
		}

		return $value;
	}

	/**
	 *
	 * @return int|mixed
	 */
	protected function getRowsListFilterField( $key )
	{
		//Value passed in?
		if ( Input::has( 'filter_field' ) )
		{
			Session::set( $key . '.rowsListFilterField', Input::get( 'filter_field' ) );

			return Input::get( 'filter_field' );
		} //Session value exists?
		elseif ( Session::get( $key . '.rowsListFilterField' ) )
		{
			return Session::get( $key . '.rowsListFilterField' );
		} //If all else fails...
		else
		{
			return 'status';
		}
	}

	/**
	 *
	 * @return int|mixed
	 */
	protected function getRowsListFilterValue( $key )
	{
		//Value passed in?
		if ( Input::has( 'filter_value' ) && is_numeric( Input::get( 'filter_value' ) ) )
		{
			Session::set( $key . '.rowsListFilterValue', Input::get( 'filter_value' ) );

			return Input::get( 'filter_value' );
		} //Session value exists?
		elseif ( Session::get( $key . '.rowsListFilterValue' ) )
		{
			return Session::get( $key . '.rowsListFilterValue' );
		} //If all else fails...
		else
		{
			return 1;
		}
	}

	protected function check_perm( $perm )
	{
		if ( $this->user->can( $perm ) )
		{
			return true;
		}

		throw new PermissionDeniedException;
	}

	protected function check_role( $role )
	{
		if ( $this->user->hasRole( $role ) )
		{
			return true;
		}

		throw new PermissionDeniedException;
	}

	protected function is_request( $uri, $strict = false )
	{
		if ( $strict == true )
		{
			$request_is = Request::is( $uri );
		} else
		{
			$request_is = Request::is( $uri ) || Request::is( $uri . '/*' );
		}

		return $request_is;
	}

	protected function getActiveClientsByField( $field, $id )
	{
		return Client::orderBy( 'name' )->where( $field, '=', $id )->where( 'status', '=', 1 )->get();
	}

	protected function searchCheck()
	{
		if ( Input::has( 'clear_search' ) || Session::has( 'clear_search' ) )
		{
			Session::forget( $this->resource_key . '.SearchTerm' );
			Session::forget( $this->resource_key . '.SearchType' );
			Session::forget( 'clear_search' );
		} elseif ( Session::has( $this->resource_key . '.SearchTerm' ) )
		{
			return true;
		}

		return false;
	}

	protected function findSearchTerm()
	{
		if ( Input::has( 'search' ) )
		{
			if ( Input::has( 'letter' ) )
			{
				Session::set( $this->resource_key . '.SearchTerm', Input::get( 'search' ) . '%' );
				Session::set( $this->resource_key . '.SearchType', 'first letter' );
			} else
			{
				Session::set( $this->resource_key . '.SearchTerm', '%' . Input::get( 'search' ) . '%' );
				Session::set( $this->resource_key . '.SearchType', 'term' );
			}
		} elseif ( Input::has( 'filter_value' ) && Input::has( 'filter_field' ) )
		{
			Session::set( $this->resource_key . '.SearchTerm', Input::get( 'filter_value' ) );
			Session::set( $this->resource_key . '.SearchType', 'filter' );
		}

		return Session::get( $this->resource_key . '.SearchTerm' );
	}

	protected function checkForSearchResults( $items )
	{
		if ( ! count( $items ) )
		{
			Flash::message( 'No records found for that search term.' );
			Session::set( 'clear_search', 'yes' );

			return false;
		}

		return true;
	}


	/**
	 * Get all data required.
	 *
	 * @return bool
	 */
	protected function getFormData()
	{
		$this->account_directors = $this->getAccountDirectorsFormData();
		$this->units             = $this->getUnitsFormData();
		$this->sectors           = $this->getSectorsFormData();
		$this->types             = $this->getTypesFormData();
		$this->services          = $this->getServicesFormData();

		return true;
	}

	/**
	 * Get all the units in a select element-friendly collection.
	 *
	 * @return array
	 */
	protected function getAccountDirectorsFormData( $blank_entry = true, $blank_message = 'Please select...' )
	{
		if ( ! AccountDirector::getAccountDirectorsForFormSelect( $blank_entry, $blank_message ) )
		{
			return [ '' => 'No units available to select' ];
		}

		return AccountDirector::getAccountDirectorsForFormSelect( $blank_entry, $blank_message );
	}

	/**
	 * Get all the units in a select element-friendly collection.
	 *
	 * @return array
	 */
	protected function getUnitsFormData( $blank_entry = true, $blank_message = 'Please select...' )
	{
		if ( ! Unit::getUnitsForFormSelect( $blank_entry, $blank_message ) )
		{
			return [ '' => 'No units available to select' ];
		}

		return Unit::getUnitsForFormSelect( $blank_entry, $blank_message );
	}

	/**
	 * Get all the sectors in a select element-friendly collection.
	 *
	 * @return array
	 */
	protected function getSectorsFormData( $blank_entry = true, $blank_message = 'Please select...' )
	{
		if ( ! Sector::getSectorsForFormSelect( $blank_entry, $blank_message ) )
		{
			return [ '' => 'No sectors available to select' ];
		}

		return Sector::getSectorsForFormSelect( $blank_entry, $blank_message );
	}

	/**
	 * Get all the types in a select element-friendly collection.
	 *
	 * @return array
	 */
	protected function getTypesFormData( $blank_entry = true, $blank_message = 'Please select...' )
	{
		if ( ! Type::getTypesForFormSelect( $blank_entry, $blank_message ) )
		{
			return [ '' => 'No types available to select' ];
		}

		return Type::getTypesForFormSelect( $blank_entry, $blank_message );
	}

	/**
	 * Get all the types in a select element-friendly collection.
	 *
	 * @return array
	 */
	protected function getServicesFormData( $blank_entry = true, $blank_message = 'Please select...' )
	{
		if ( ! Service::getServicesForFormSelect( $blank_entry, $blank_message ) )
		{
			return [ '' => 'No services available to select' ];
		}

		return Service::getServicesForFormSelect( $blank_entry, $blank_message );
	}

	protected function getActiveCount()
	{
		if($this->user->hasRole('Administrator'))
		{
			return Client::where('status' , '=', 1)->count();
		}
		else
		{
			return Client::where('unit_id', '=', $this->user->unit_id)->where('status' , '=', 1)->count();
		}
	}

	protected function getDormantCount()
	{
		if($this->user->hasRole('Administrator'))
		{
			return Client::where('status' , '=', 0)->count();
		}
		else
		{
			return Client::where('unit_id', '=', $this->user->unit_id)->where('status' , '=', 0)->count();
		}
	}
}
