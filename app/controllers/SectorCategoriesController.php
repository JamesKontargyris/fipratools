<?php

use Laracasts\Commander\CommanderTrait;
use Laracasts\Flash\Flash;
use Leadofficelist\Exceptions\ResourceNotFoundException;
use Leadofficelist\Forms\AddEditSectorCategory as AddEditSectorCategoryForm;
use Leadofficelist\Sector_categories\Sector_category;
use Leadofficelist\Sectors\Sector;

class SectorCategoriesController extends \BaseController
{
	use CommanderTrait;

	public $section = 'list';
	protected $resource_key = 'sector_categories';
	protected $resource_permission = 'manage_sectors';
	private $addEditSectorCategoryForm;

	function __construct( AddEditSectorCategoryForm $addEditSectorCategoryForm )
	{
		parent::__construct();

		$this->check_perm( 'manage_sectors' );

		$this->addEditSectorCategoryForm = $addEditSectorCategoryForm;
		View::share( 'page_title', 'Expertise Categories' );
		View::share( 'key', 'sector_categories' );
	}

	/**
	 * Display a listing of sector categories.
	 * GET /sectorcategories
	 *
	 * @return Response
	 */
	public function index()
	{
		$this->destroyCurrentPageNumber(true);

		if ( $this->searchCheck() )
		{
			return Redirect::to( $this->resource_key . '/search' );
		}

		$items      = Sector_category::rowsSortOrder( $this->rows_sort_order )->paginate( $this->rows_to_view );
		$items->key = 'sector_categories';

		return View::make( 'sector_categories.index' )->with( compact( 'items' ) );
	}

	/**
	 * Show the form for creating a new sector category.
	 * GET /sectorcategories/create
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make( 'sector_categories.create' );
	}

	/**
	 * Store a newly created sector category in storage.
	 * POST /sectorcategories
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		$this->addEditSectorCategoryForm->validate( $input );

		$this->execute( 'Leadofficelist\Sector_categories\AddSectorCategoryCommand' );

		Flash::overlay( '"' . $input['name'] . '" added.', 'success' );

		return Redirect::route( 'sector_categories.index' );
	}

	/**
	 * Display the specified sector category.
	 * GET /sectorcategories/{id}
	 *
	 * @param  int $id
	 *
	 * @throws ResourceNotFoundException
	 * @return Response
	 */
	public function show( $id )
	{
		if ( $sector_category = $this->getSectorCategory( $id ) )
		{
			$sectors = Sector::where( 'category_id', '=', $sector_category->id )->get();

			return View::make( 'sector_categories.show' )->with( compact( 'sector_category', 'sectors' ) );
		} else
		{
			throw new ResourceNotFoundException( 'sector_categories' );
		}
	}

	/**
	 * Show the form for editing the specified sector category.
	 * GET /sectorcategories/{id}/edit
	 *
	 * @param  int $id
	 *
	 * @throws ResourceNotFoundException
	 * @return Response
	 */
	public function edit( $id )
	{
		if ( $sector_category = $this->getSectorCategory( $id ) )
		{
			return View::make( 'sector_categories.edit' )->with( compact( 'sector_category' ) );
		} else
		{
			throw new ResourceNotFoundException( 'sector_category ' );
		}
	}

	/**
	 * Update the specified sector category in storage.
	 * PUT /sectorcategories/{id}
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function update( $id )
	{
		$input                                          = Input::all();
		$input['id']                                    = $id;
		$this->addEditSectorCategoryForm->rules['name'] = 'required|max:255|unique:sector_categories,name,' . $id;
		$this->addEditSectorCategoryForm->validate( $input );

		$this->execute( 'Leadofficelist\Sector_categories\EditSectorCategoryCommand', $input );

		Flash::overlay( 'Expertise category updated.', 'success' );

		return Redirect::route( 'sector_categories.index' );
	}

	/**
	 * Remove the specified sector category from storage.
	 * DELETE /sectorcategories/{id}
	 *
	 * @param  int $id
	 *
	 * @throws ResourceNotFoundException
	 * @return Response
	 */
	public function destroy( $id )
	{
		if ( $sector_category = $this->getSectorCategory( $id ) )
		{
			Sector_category::destroy( $id );
			Flash::overlay( '"' . $sector_category->name . '" has been deleted.', 'info' );

			return Redirect::route( 'sector_categories.index' );
		} else
		{
			throw new ResourceNotFoundException( 'sector_categories' );
		}
	}

	/**
	 * Process a sector category search.
	 *
	 * @return $this
	 */
	public function search()
	{
		if ( $search_term = $this->findSearchTerm() )
		{
			$items = Sector_category::where( 'name', 'LIKE', $search_term )->rowsSortOrder( $this->rows_sort_order )->paginate( $this->rows_to_view );

			if ( ! $this->checkForSearchResults( $items ) )
			{
				return Redirect::route( $this->resource_key . '.index' );
			}
			$items->search_term = str_replace( '%', '', $search_term );
			$items->key         = 'sector_categories';

			return View::make( 'sector_categories.index' )->with( compact( 'items' ) );
		} else
		{
			return View::make( 'sector_categories.index' );
		}
	}

	protected function getAll()
	{
		return Sector_category::all();
	}

	protected function getSelection()
	{
		if ( $this->searchCheck() )
		{
			$search_term = $this->findSearchTerm();
			$this->search_term_clean = str_replace('%', '', $search_term);

			//Search on both first_name and last_name
			$items = Sector_category::where('name', '=', $search_term)->rowsSortOrder( $this->rows_sort_order )->paginate( $this->rows_to_view );
		}
		else
		{
			$items = Sector_category::rowsSortOrder( $this->rows_sort_order )->paginate( $this->rows_to_view );
		}

		return $items;
	}

	protected function getSectorCategory( $id )
	{
		return Sector_category::find( $id );
	}
}