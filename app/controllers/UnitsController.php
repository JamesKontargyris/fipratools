<?php

use Laracasts\Commander\CommanderTrait;
use Laracasts\Flash\Flash;
use Leadofficelist\Exceptions\ResourceNotFoundException;
use Leadofficelist\Forms\AddEditUnit as AddEditUnitForm;
use Leadofficelist\Units\Unit;

class UnitsController extends \BaseController {

	use CommanderTrait;

	protected $resource_key = 'units';
	private $addEditUnitForm;

	public function __construct(AddEditUnitForm $addEditUnitForm)
	{
		parent::__construct();

		$this->addEditUnitForm = $addEditUnitForm;

		View::share('page_title', 'Units');
	}


	/**
	 * Display a listing of all units1.
	 * GET /units
	 *
	 * @return Response
	 */
	public function index()
	{
		$this->check_perm('manage_units');

		$items = Unit::rowsSortOrder($this->rows_sort_order)->paginate($this->rows_to_view);
		$items->key = 'units';
		return View::make('units.index')->with(compact('items'));
	}

	/**
	 * Show the form for adding a new unit.
	 * GET /units/create
	 *
	 * @return Response
	 */
	public function create()
	{
		$this->check_perm('manage_units');

		return View::make('units.create');

	}

	/**
	 * Store a newly created unit in storage.
	 * POST /units
	 *
	 * @return Response
	 */
	public function store()
	{
		$this->check_perm('manage_units');

		$input = Input::all();
		$this->addEditUnitForm->validate($input);

		$this->execute('Leadofficelist\Units\AddUnitCommand');

		Flash::overlay('"' . $input['name'] .'" added.', 'success');

		return Redirect::route('units.index');
	}

	/**
	 * Display the specified unit.
	 * GET /units/{id}
	 *
	 * @param  int $id
	 * @throws ResourceNotFoundException
	 * @throws \Leadofficelist\Exceptions\PermissionDeniedException
	 * @return Response
	 */
	public function show($id)
	{
		$this->check_perm('view_list');

		if($unit = $this->getUnit($id))
		{
			return View::make('units.show')->with(compact('unit'));
		}
		else
		{
			throw new ResourceNotFoundException('units');
		}
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /units/{id}/edit
	 *
	 * @param  int $id
	 * @throws ResourceNotFoundException
	 * @throws \Leadofficelist\Exceptions\PermissionDeniedException
	 * @return Response
	 */
	public function edit($id)
	{
		$this->check_perm('manage_units');

		if($unit = $this->getUnit($id))
		{
			return View::make('units.edit')->with(compact('unit'));
		}
		else
		{
			throw new ResourceNotFoundException('units');
		}
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /units/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$this->check_perm('manage_units');

		$input = Input::all();
		$input['id'] = $id;
		$this->addEditUnitForm->rules['name'] = 'required|max:255|unique:units,name,' . $id;
		$this->addEditUnitForm->validate($input);

		$this->execute('Leadofficelist\Units\EditUnitCommand', $input);

		Flash::overlay('"' . $input['name'] .'" updated.', 'success');

		return Redirect::route('units.index');
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /units/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$this->check_perm('manage_units');

		if($unit = $this->getUnit($id))
		{
			Unit::destroy($id);
			Flash::overlay('"' . $unit->name .'" deleted.', 'info');

		}

		return Redirect::route('units.index');
	}

	public function search()
	{
		$this->check_perm('manage_units');

		$items = Unit::where('name', 'LIKE', '%' . Input::get('search') . '%')->rowsSortOrder($this->rows_sort_order)->paginate($this->rows_to_view);
		$items->key = 'units';
		$items->search_term = Input::get('search');
		return View::make('units.index')->with(compact('items'));
	}

	protected function getUnit($id)
	{
		return Unit::find($id);
	}
}