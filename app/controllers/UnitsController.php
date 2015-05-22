<?php

use Laracasts\Commander\CommanderTrait;
use Laracasts\Flash\Flash;
use Leadofficelist\Clients\Client;
use Leadofficelist\Exceptions\ResourceNotFoundException;
use Leadofficelist\Forms\AddEditUnit as AddEditUnitForm;
use Leadofficelist\Unit_groups\Unit_group;
use Leadofficelist\Units\Unit;

class UnitsController extends \BaseController
{

	use CommanderTrait;

	protected $resource_key = 'units';
	protected $resource_permission = 'manage_units';
	protected $export_filename;
	private $addEditUnitForm;

	public function __construct( AddEditUnitForm $addEditUnitForm )
	{
		parent::__construct();

		$this->addEditUnitForm = $addEditUnitForm;

		View::share( 'page_title', 'Units' );
		View::share( 'key', 'units' );
	}


	/**
	 * Display a listing of all units1.
	 * GET /units
	 *
	 * @return Response
	 */
	public function index()
	{
		$this->destroyCurrentPageNumber(true);

		$this->check_perm( 'manage_units' );

		if ( $this->searchCheck() )
		{
			return Redirect::to( $this->resource_key . '/search' );
		}

		$items      = Unit::rowsSortOrder( $this->rows_sort_order )->paginate( $this->rows_to_view );
		$items->key = 'units';

		return View::make( 'units.index' )->with( compact( 'items' ) );
	}

	/**
	 * Show the form for adding a new unit.
	 * GET /units/create
	 *
	 * @return Response
	 */
	public function create()
	{
		$this->check_perm( 'manage_units' );

        $unit_groups = $this->getUnitGroups();

		return View::make( 'units.create', compact('unit_groups') );

	}

	/**
	 * Store a newly created unit in storage.
	 * POST /units
	 *
	 * @return Response
	 */
	public function store()
	{
		$this->check_perm( 'manage_units' );

		$input = Input::all();
		$this->addEditUnitForm->validate( $input );

		$this->execute( 'Leadofficelist\Units\AddUnitCommand' );

		Flash::overlay( '"' . $input['name'] . '" added.', 'success' );

		return Redirect::route( 'units.index' );
	}

	/**
	 * Display the specified unit.
	 * GET /units/{id}
	 *
	 * @param  int $id
	 *
	 * @throws ResourceNotFoundException
	 * @throws \Leadofficelist\Exceptions\PermissionDeniedException
	 * @return Response
	 */
	public function show( $id )
	{
		$this->check_perm( 'view_list' );

		if ( $unit = $this->getUnit( $id ) )
		{
			$clients = $this->getActiveClientsByField( 'unit_id', $id );

			return View::make( 'units.show' )->with( compact( 'unit', 'clients' ) );
		} else
		{
			throw new ResourceNotFoundException( 'units' );
		}
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /units/{id}/edit
	 *
	 * @param  int $id
	 *
	 * @throws ResourceNotFoundException
	 * @throws \Leadofficelist\Exceptions\PermissionDeniedException
	 * @return Response
	 */
	public function edit( $id )
	{
		$this->check_perm( 'manage_units' );

		if ( $unit = $this->getUnit( $id ) )
		{
            $unit_groups = $this->getUnitGroups();
			return View::make( 'units.edit' )->with( compact( 'unit', 'unit_groups' ) );
		} else
		{
			throw new ResourceNotFoundException( 'units' );
		}
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /units/{id}
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function update( $id )
	{
		$this->check_perm( 'manage_units' );

		$input                                      = Input::all();
		$input['id']                                = $id;
		$this->addEditUnitForm->rules['name']       = 'required|max:255|unique:units,name,' . $id;
		$this->addEditUnitForm->rules['short_name'] = 'required|max:255|unique:units,short_name,' . $id;
		$this->addEditUnitForm->validate( $input );

		$this->execute( 'Leadofficelist\Units\EditUnitCommand', $input );

		Flash::overlay( '"' . $input['name'] . '" updated.', 'success' );

		return Redirect::route( 'units.index' );
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /units/{id}
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function destroy( $id )
	{
		$this->check_perm( 'manage_units' );

		if ( $unit = $this->getUnit( $id ) )
		{
			Unit::destroy( $id );
			Flash::overlay( '"' . $unit->name . '" deleted.', 'info' );

		}

		return Redirect::route( 'units.index' );
	}

	/**
	 * Process a unit search.
	 *
	 * @return $this
	 */
	public function search()
	{
		if ( $search_term = $this->findSearchTerm() )
		{
			$items = Unit::where( 'name', 'LIKE', $search_term )->rowsSortOrder( $this->rows_sort_order )->paginate( $this->rows_to_view );

			if ( ! $this->checkForSearchResults( $items ) )
			{
				return Redirect::route( $this->resource_key . '.index' );
			}
			$items->search_term = str_replace( '%', '', $search_term );
			$items->key         = 'units';

			return View::make( 'units.index' )->with( compact( 'items' ) );
		} else
		{
			return Redirect::route( 'units.index' );
		}
	}

	protected function getAll()
	{
		return Unit::all();
	}

	protected function getSelection()
	{
		if ( $this->searchCheck() )
		{
			$search_term = $this->findSearchTerm();
			$this->search_term_clean = str_replace('%', '', $search_term);

			$items = Unit::where( 'name', 'LIKE', $search_term )->rowsSortOrder( $this->rows_sort_order )->paginate( $this->rows_to_view );
		}
		else
		{
			$items = Unit::rowsSortOrder( $this->rows_sort_order )->paginate( $this->rows_to_view );
		}


		return $items;
	}

	protected function getUnit( $id )
	{
		return Unit::find( $id );
	}

    protected function getUnitGroups()
    {
        $unit_groups = ['' => 'None'];
        foreach(Unit_group::orderBy('name')->get() as $unit_group)
        {
            $unit_groups[$unit_group->id] = $unit_group->name;
        }

        return $unit_groups;
    }
}