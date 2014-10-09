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

	protected $resource_key = 'sector_categories';
	/**
	 * @var AddEditSectorCategory
	 */
	private $addEditSectorCategoryForm;

	function __construct( AddEditSectorCategoryForm $addEditSectorCategoryForm )
	{
		parent::__construct();

		$this->check_perm( 'manage_sectors' );

		View::share( 'page_title', 'Sector Categories' );
		$this->addEditSectorCategoryForm = $addEditSectorCategoryForm;
	}

	/**
	 * Display a listing of sector categories.
	 * GET /sectorcategories
	 *
	 * @return Response
	 */
	public function index()
	{
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
			throw new ResourceNotFoundException( 'sector_category ' );
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

		Flash::overlay( 'Sector category updated.', 'success' );

		return Redirect::route( 'sector_categories.index' );
	}

	/**
	 * Remove the specified sector category from storage.
	 * DELETE /sectorcategories/{id}
	 *
	 * @param  int $id
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
			throw new ResourceNotFoundException( 'sector_category ' );
		}
	}

	/**
	 * Process a sector category search.
	 *
	 * @return $this
	 */
	public function search()
	{
		$items              = Sector_category::where( 'name', 'LIKE', '%' . Input::get( 'search' ) . '%' )->rowsSortOrder( $this->rows_sort_order )->paginate( $this->rows_to_view );
		$items->key         = 'sector_categories';
		$items->search_term = Input::get( 'search' );

		return View::make( 'sector_categories.index' )->with( compact( 'items' ) );
	}

	protected function getSectorCategory( $id )
	{
		return Sector_category::find( $id );
	}
}