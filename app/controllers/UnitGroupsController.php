<?php

use Laracasts\Commander\CommanderTrait;
use Laracasts\Flash\Flash;
use Leadofficelist\Exceptions\ResourceNotFoundException;
use Leadofficelist\Forms\AddEditUnitGroup as AddEditUnitGroupForm;
use Leadofficelist\Unit_groups\Unit_group;
use Leadofficelist\Units\Unit;

class UnitGroupsController extends \BaseController
{
    use CommanderTrait;

	public $section = 'list';
    protected $resource_key = 'unit_groups';
    protected $resource_permission = 'manage_units';
    private $addEditUnitGroupForm;

    function __construct( AddEditUnitGroupForm $addEditUnitGroupForm )
    {
        parent::__construct();

        $this->check_perm( 'manage_units' );

        $this->addEditUnitGroupForm = $addEditUnitGroupForm;
        View::share( 'page_title', 'Unit Groups' );
        View::share( 'key', 'unit_groups' );
    }

    /**
     * Display a listing of sector categories.
     * GET /unitgroups
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

        $items      = Unit_group::rowsSortOrder( $this->rows_sort_order )->paginate( $this->rows_to_view );
        $items->key = 'unit_groups';

        return View::make( 'unit_groups.index' )->with( compact( 'items' ) );
    }

    /**
     * Show the form for creating a new sector category.
     * GET /unitgroups/create
     *
     * @return Response
     */
    public function create()
    {
        return View::make( 'unit_groups.create' );
    }

    /**
     * Store a newly created sector category in storage.
     * POST /unitgroups
     *
     * @return Response
     */
    public function store()
    {
        $input = Input::all();
        $this->addEditUnitGroupForm->validate( $input );

        $this->execute( 'Leadofficelist\Unit_groups\AddUnitGroupCommand' );

        Flash::overlay( '"' . $input['name'] . '" added.', 'success' );

        return Redirect::route( 'unit_groups.index' );
    }

    /**
     * Display the specified sector category.
     * GET /unitgroups/{id}
     *
     * @param  int $id
     *
     * @throws ResourceNotFoundException
     * @return Response
     */
    public function show( $id )
    {
        if ( $unit_group = $this->getUnitGroup( $id ) )
        {
            $items = Unit::where( 'unit_group_id', '=', $unit_group->id )->get();

            return View::make( 'unit_groups.show' )->with( compact( 'unit_group', 'items' ) );
        } else
        {
            throw new ResourceNotFoundException( 'unit_groups' );
        }
    }

    /**
     * Show the form for editing the specified sector category.
     * GET /unitgroups/{id}/edit
     *
     * @param  int $id
     *
     * @throws ResourceNotFoundException
     * @return Response
     */
    public function edit( $id )
    {
        if ( $unit_group = $this->getUnitGroup( $id ) )
        {
            return View::make( 'unit_groups.edit' )->with( compact( 'unit_group' ) );
        } else
        {
            throw new ResourceNotFoundException( 'unit_groups' );
        }
    }

    /**
     * Update the specified sector category in storage.
     * PUT /unitgroups/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function update( $id )
    {
        $input                                          = Input::all();
        $input['id']                                    = $id;
        $this->addEditUnitGroupForm->rules['name'] = 'required|max:255|unique:unit_groups,name,' . $id;
        $this->addEditUnitGroupForm->validate( $input );

        $this->execute( 'Leadofficelist\Unit_groups\EditUnitGroupCommand', $input );

        Flash::overlay( 'Unit reporting group updated.', 'success' );

        return Redirect::route( 'unit_groups.index' );
    }

    /**
     * Remove the specified sector category from storage.
     * DELETE /unitgroups/{id}
     *
     * @param  int $id
     *
     * @throws ResourceNotFoundException
     * @return Response
     */
    public function destroy( $id )
    {
        if ( $unit_group = $this->getUnitGroup( $id ) )
        {
            Unit_group::destroy( $id );
//            Reset the unit grouping of any units linked to this group
            foreach(Unit::where('unit_group_id', '=', $id)->get() as $unit)
            {
                $unit->unit_group_id = 0;
                $unit->save();
            }

            Flash::overlay( '"' . $unit_group->name . '" has been deleted.', 'info' );

            return Redirect::route( 'unit_groups.index' );
        } else
        {
            throw new ResourceNotFoundException( 'unit_groups' );
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
            $items = Unit_group::where( 'name', 'LIKE', $search_term )->rowsSortOrder( $this->rows_sort_order )->paginate( $this->rows_to_view );

            if ( ! $this->checkForSearchResults( $items ) )
            {
                return Redirect::route( $this->resource_key . '.index' );
            }
            $items->search_term = str_replace( '%', '', $search_term );
            $items->key         = 'unit_groups';

            return View::make( 'unit_groups.index' )->with( compact( 'items' ) );
        } else
        {
            return View::make( 'unit_groups.index' );
        }
    }

    protected function getAll()
    {
        return Unit_group::all();
    }

    protected function getSelection()
    {
        if ( $this->searchCheck() )
        {
            $search_term = $this->findSearchTerm();
            $this->search_term_clean = str_replace('%', '', $search_term);

            //Search on both first_name and last_name
            $items = Unit_group::where('name', '=', $search_term)->rowsSortOrder( $this->rows_sort_order )->paginate( $this->rows_to_view );
        }
        else
        {
            $items = Unit_group::rowsSortOrder( $this->rows_sort_order )->paginate( $this->rows_to_view );
        }

        return $items;
    }

    protected function getUnitGroup( $id )
    {
        return Unit_group::find( $id );
    }
}