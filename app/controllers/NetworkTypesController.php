<?php

use Laracasts\Commander\CommanderTrait;
use Laracasts\Flash\Flash;
use Leadofficelist\Exceptions\ResourceNotFoundException;
use Leadofficelist\Forms\AddEditNetworkType as AddEditNetworkTypeForm;
use Leadofficelist\Network_types\Network_type;
use Leadofficelist\Units\Unit;

class NetworkTypesController extends \BaseController
{
    use CommanderTrait;

	public $section = 'list';
    protected $resource_key = 'network_types';
    protected $resource_permission = 'manage_units';
    private $addEditNetworkTypeForm;

    function __construct(AddEditNetworkTypeForm $addEditNetworkTypeForm)
    {
        parent::__construct();

        $this->check_perm('manage_units');

        $this->addEditNetworkTypeForm = $addEditNetworkTypeForm;
        View::share('page_title', 'Network Types');
        View::share('key', 'network_types');
    }

    /**
     * Display a listing of network types.
     * GET /unitgroups
     *
     * @return Response
     */
    public function index()
    {
        $this->destroyCurrentPageNumber(true);

        if ($this->searchCheck()) {
            return Redirect::to($this->resource_key . '/search');
        }

        $items = Network_type::rowsSortOrder($this->rows_sort_order)->paginate($this->rows_to_view);
        $items->key = 'network_types';

        return View::make('network_types.index')->with(compact('items'));
    }

    /**
     * Show the form for creating a new network type.
     * GET /unitgroups/create
     *
     * @return Response
     */
    public function create()
    {
        return View::make('network_types.create');
    }

    /**
     * Store a newly created network type in storage.
     * POST /unitgroups
     *
     * @return Response
     */
    public function store()
    {
        $input = Input::all();
        $this->addEditNetworkTypeForm->validate($input);

        $this->execute('Leadofficelist\Network_types\AddNetworkTypeCommand');

        Flash::overlay('"' . $input['name'] . '" added.', 'success');

        return Redirect::route('network_types.index');
    }

    /**
     * Display the specified network type.
     * GET /unitgroups/{id}
     *
     * @param  int $id
     *
     * @throws ResourceNotFoundException
     * @return Response
     */
    public function show($id)
    {
        return Redirect::route('network_types.index');
    }

    /**
     * Show the form for editing the specified network type.
     * GET /unitgroups/{id}/edit
     *
     * @param  int $id
     *
     * @throws ResourceNotFoundException
     * @return Response
     */
    public function edit($id)
    {
        if ($network_type = $this->getNetworkType($id)) {
            return View::make('network_types.edit')->with(compact('network_type'));
        }
        else {
            throw new ResourceNotFoundException('network_types');
        }
    }

    /**
     * Update the specified network type in storage.
     * PUT /unitgroups/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function update($id)
    {
        $input = Input::all();
        $input['id'] = $id;
        $this->addEditNetworkTypeForm->rules['name'] = 'required|max:255|unique:network_types,name,' . $id;
        $this->addEditNetworkTypeForm->validate($input);

        $this->execute('Leadofficelist\Network_types\EditNetworkTypeCommand', $input);

        Flash::overlay('Network type updated.', 'success');

        return Redirect::route('network_types.index');
    }

    /**
     * Remove the specified network type from storage.
     * DELETE /unitgroups/{id}
     *
     * @param  int $id
     *
     * @throws ResourceNotFoundException
     * @return Response
     */
    public function destroy($id)
    {
        if ($network_type = $this->getNetworkType($id)) {
            Network_type::destroy($id);
            //            Reset the unit grouping of any units linked to this group
            foreach (Unit::where('network_type_id', '=', $id)->get() as $unit) {
                $unit->network_type_id = 0;
                $unit->save();
            }

            Flash::overlay('"' . $network_type->name . '" has been deleted.', 'info');

            return Redirect::route('network_types.index');
        }
        else {
            throw new ResourceNotFoundException('network_types');
        }
    }

    /**
     * Process a network type search.
     *
     * @return $this
     */
    public function search()
    {
        if ($search_term = $this->findSearchTerm()) {
            $items = Network_type::where('name', 'LIKE', $search_term)->rowsSortOrder($this->rows_sort_order)->paginate($this->rows_to_view);

            if (!$this->checkForSearchResults($items)) {
                return Redirect::route($this->resource_key . '.index');
            }
            $items->search_term = str_replace('%', '', $search_term);
            $items->key = 'network_types';

            return View::make('network_types.index')->with(compact('items'));
        }
        else {
            return View::make('network_types.index');
        }
    }

    protected function getAll()
    {
        return Network_type::all();
    }

    protected function getSelection()
    {
        if ($this->searchCheck()) {
            $search_term = $this->findSearchTerm();
            $this->search_term_clean = str_replace('%', '', $search_term);

            //Search on both first_name and last_name
            $items = Network_type::where('name', '=', $search_term)->rowsSortOrder($this->rows_sort_order)->paginate($this->rows_to_view);
        }
        else {
            $items = Network_type::rowsSortOrder($this->rows_sort_order)->paginate($this->rows_to_view);
        }

        return $items;
    }

    protected function getNetworkType($id)
    {
        return Network_type::find($id);
    }
}