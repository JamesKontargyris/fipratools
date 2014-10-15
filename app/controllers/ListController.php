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

		$items = Client::rowsHideShowDormant( $this->rows_hide_show_dormant )->rowsSortOrder( $this->rows_sort_order )->paginate( $this->rows_to_view );
		$items->key = 'list';

		return View::make( 'list.index' )->with( compact( 'items' ) );
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
			$items = Client::where( 'name', 'LIKE', $search_term )->rowsSortOrder( $this->rows_sort_order )->paginate( $this->rows_to_view );

			if ( ! $this->checkForSearchResults( $items ) )
			{
				return Redirect::route( 'list.index' );
			}
			$items->search_term = str_replace( '%', '', $search_term );
			$items->key         = 'list';

			return View::make( 'list.index' )->with( compact( 'items' ) );
		} else
		{
			return Redirect::route('list.index');
		}
	}
}