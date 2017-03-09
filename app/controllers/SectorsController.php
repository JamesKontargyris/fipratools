<?php

use Laracasts\Commander\CommanderTrait;
use Laracasts\Flash\Flash;
use Leadofficelist\Clients\Client;
use Leadofficelist\Sector_categories\Sector_category;
use Leadofficelist\Sectors\Sector;
use Leadofficelist\Forms\AddEditSector as AddEditSectorForm;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

class SectorsController extends \BaseController
{
	use CommanderTrait;

	public $sitewide = 1;
	protected $resource_key = 'sectors';
	protected $resource_permission = 'manage_sectors';
	private $addEditSectorForm;

	function __construct( AddEditSectorForm $addEditSectorForm )
	{
		parent::__construct();

		$this->check_perm( 'manage_sectors' );

		$this->addEditSectorForm = $addEditSectorForm;

		View::share( 'page_title', 'Sectors' );
		View::share( 'key', 'sectors' );
	}

	/**
	 * Display a listing of sectors.
	 * GET /sectors
	 *
	 * @return Response
	 */
	public function index()
	{
		$this->destroyCurrentPageNumber(true);

		if($this->searchCheck()) return Redirect::to($this->resource_key . '/search');

		$items      = Sector::rowsSortOrder( $this->rows_sort_order )->paginate( $this->rows_to_view );
		$items->key = 'sectors';

		return View::make( 'sectors.index' )->with( compact( 'items' ) );
	}

	/**
	 * Show the form for creating a new sector.
	 * GET /sectors/create
	 *
	 * @return Response
	 */
	public function create()
	{
		$categories = $this->getSectorCategories();
		return View::make( 'sectors.create' )->with(compact('categories'));
	}

	/**
	 * Store a newly created sector in storage.
	 * POST /sectors
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		$this->addEditSectorForm->validate( $input );

		$this->execute( 'Leadofficelist\Sectors\AddSectorCommand' );

		Flash::overlay( '"' . $input['name'] . '" added.', 'success' );

		return Redirect::route( 'sectors.index' );
	}

	/**
	 * Display the specified sector.
	 * GET /sectors/{id}
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function show( $id )
	{
		if ( $sector = $this->getSector($id) )
		{
			$clients = $this->getActiveClientsByField('sector_id', $id);

			return View::make( 'sectors.show' )->with( compact( 'sector', 'clients' ) );
		} else
		{
			throw new ResourceNotFoundException('sectors');
		}
	}

	/**
	 * Show the form for editing the specified sector.
	 * GET /sectors/{id}/edit
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function edit( $id )
	{
		if ( $sector = $this->getSector($id) )
		{
			$categories = $this->getSectorCategories();
			return View::make( 'sectors.edit' )->with(compact('sector', 'categories'));
		}
		else
		{
			throw new ResourceNotFoundException('sectors');
		}
	}

	/**
	 * Update the specified sector in storage.
	 * PUT /sectors/{id}
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function update( $id )
	{
		$input                                  = Input::all();
		$input['id']                            = $id;
		$this->addEditSectorForm->rules['name'] = 'required|max:255|unique:sectors,name,' . $id;
		$this->addEditSectorForm->validate( $input );

		$this->execute( 'Leadofficelist\Sectors\EditSectorCommand', $input );

		Flash::overlay( 'Sector updated.', 'success' );

		return Redirect::route( 'sectors.index' );
	}

	/**
	 * Remove the specified sector from storage.
	 * DELETE /sectors/{id}
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function destroy( $id )
	{
		if ( $sector = $this->getSector( $id ) )
		{
			Sector::destroy( $id );
			Flash::overlay( '"' . $sector->name . '" has been deleted.', 'info' );

			return Redirect::route( 'sectors.index' );
		} else
		{
			throw new ResourceNotFoundException( 'sectors' );
		}
	}

	/**
	 * Process a sector search.
	 *
	 * @return $this
	 */
	public function search()
	{
		if($search_term = $this->findSearchTerm())
		{
			$items              = Sector::where( 'name', 'LIKE', $search_term )->rowsSortOrder( $this->rows_sort_order )->paginate( $this->rows_to_view );

			if( ! $this->checkForSearchResults($items)) return Redirect::route( $this->resource_key . '.index' );
			$items->search_term = str_replace('%', '', $search_term);
			$items->key         = 'sectors';

			return View::make( 'sectors.index' )->with( compact( 'items' ) );
		}
		else
		{
			return View::make( 'sectors.index' );
		}
	}

	protected function getAll()
	{
		return Sector::all();
	}

	protected function getSelection()
	{
		if ( $this->searchCheck() )
		{
			$search_term = $this->findSearchTerm();
			$this->search_term_clean = str_replace('%', '', $search_term);

			$items = Sector::where( 'name', 'LIKE', $search_term )->rowsSortOrder( $this->rows_sort_order )->paginate( $this->rows_to_view );
		}
		else
		{
			$items = Sector::rowsSortOrder( $this->rows_sort_order )->paginate( $this->rows_to_view );
		}

		return $items;
	}

	protected function getSector($id)
	{
		return Sector::find( $id );
	}

	protected function getSectorCategories()
	{
		$categories = ['' => 'Select existing category or create new...', 'new' => 'New...'];
		foreach(Sector_category::orderBy('name')->get() as $category)
		{
			$categories[$category->id] = $category->name;
		}

		return $categories;
	}
}