<?php

use Laracasts\Commander\CommanderTrait;
use Laracasts\Flash\Flash;
use Leadofficelist\Forms\AddEditLocation as AddEditLocationForm;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

class LocationsController extends \BaseController {
	use CommanderTrait;

	protected $resource_key = 'locations';
	protected $resource_permission = 'manage_locations';
	private $addEditLocationForm;

	function __construct( AddEditLocationForm $addEditLocationForm ) {
		parent::__construct();

		$this->check_perm( 'manage_locations' );

		$this->addEditLocationForm = $addEditLocationForm;

		View::share( 'page_title', 'Locations' );
		View::share( 'key', 'locations' );
	}

	/**
	 * Display a listing of the resource.
	 * GET /locations
	 *
	 * @return Response
	 */
	public function index() {
		$this->destroyCurrentPageNumber(true);

		if($this->searchCheck()) return Redirect::to($this->resource_key . '/search');

		$items      = Location::rowsSortOrder( $this->rows_sort_order )->paginate( $this->rows_to_view );
		$items->key = 'locations';

		return View::make( 'locations.index' )->with( compact( 'items' ) );
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /locations/create
	 *
	 * @return Response
	 */
	public function create() {
		return View::make( 'locations.create' );
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /locations
	 *
	 * @return Response
	 */
	public function store() {
		$input = Input::all();
		$this->addEditLocationForm->validate( $input );

		$this->execute( 'Leadofficelist\Locations\AddLocationCommand' );

		Flash::overlay( '"' . $input['name'] . '" added.', 'success' );

		return Redirect::route( 'locations.index' );
	}

	/**
	 * Display the specified resource.
	 * GET /locations/{id}
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function show( $id ) {
		// Don't need to show locations
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /locations/{id}/edit
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function edit( $id ) {
		if ( $location = $this->getLocation($id) )
		{
			return View::make( 'locations.edit' )->with(compact('location'));
		}
		else
		{
			throw new ResourceNotFoundException('locations');
		}
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /locations/{id}
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function update( $id ) {
		$input                                  = Input::all();
		$input['id']                            = $id;
		$this->addEditLocationForm->rules['name'] = 'required|max:255|unique:locations,name,' . $id;
		$this->addEditLocationForm->validate( $input );

		$this->execute( 'Leadofficelist\Locations\EditLocationCommand', $input );

		Flash::overlay( 'Location updated.', 'success' );

		return Redirect::route( 'locations.index' );
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /locations/{id}
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function destroy( $id ) {
		if ( $location = $this->getLocation( $id ) )
		{
			Location::destroy( $id );
			Flash::overlay( '"' . $location->name . '" has been deleted.', 'info' );

			return Redirect::route( 'locations.index' );
		} else
		{
			throw new ResourceNotFoundException( 'locations' );
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
			$items              = Location::where( 'name', 'LIKE', $search_term )->rowsSortOrder( $this->rows_sort_order )->paginate( $this->rows_to_view );

			if( ! $this->checkForSearchResults($items)) return Redirect::route( $this->resource_key . '.index' );
			$items->search_term = str_replace('%', '', $search_term);
			$items->key         = 'locations';

			return View::make( 'locations.index' )->with( compact( 'items' ) );
		}
		else
		{
			return View::make( 'locations.index' );
		}
	}

	protected function getAll()
	{
		return Location::all();
	}

	protected function getSelection()
	{
		if ( $this->searchCheck() )
		{
			$search_term = $this->findSearchTerm();
			$this->search_term_clean = str_replace('%', '', $search_term);

			$items = Location::where( 'name', 'LIKE', $search_term )->rowsSortOrder( $this->rows_sort_order )->paginate( $this->rows_to_view );
		}
		else
		{
			$items = Location::rowsSortOrder( $this->rows_sort_order )->paginate( $this->rows_to_view );
		}

		return $items;
	}

	protected function getLocation($id)
	{
		return Location::find( $id );
	}

}