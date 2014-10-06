<?php

use Laracasts\Commander\CommanderTrait;
use Laracasts\Flash\Flash;
use Leadofficelist\Forms\AddUnit as AddUnitForm;
use Leadofficelist\Forms\EditUnit as EditUnitForm;
use Leadofficelist\Units\EditUnitCommand;
use Leadofficelist\Units\Unit;

class UnitsController extends \BaseController {

	use CommanderTrait;

	protected $resource_key = 'units';
	private $addUnitForm;
	private $editUnitForm;
	/**
	 * Array of filter keys to reset when "reset filters" is clicked
	 *
	 * @var array
	 */
	protected $filter_keys = ['units.rowsToView', 'units.rowsSort'];

	public function __construct(AddUnitForm $addUnitForm, EditUnitForm $editUnitForm) {

		parent::__construct();

		$this->addUnitForm = $addUnitForm;
		$this->editUnitForm = $editUnitForm;


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
		$this->addUnitForm->validate($input);

		$this->execute('Leadofficelist\Units\AddUnitCommand');

		Flash::overlay('Fipra Unit added.', 'success');

		return Redirect::route('units.index');
	}

	/**
	 * Display the specified resource.
	 * GET /units/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$this->check_perm('view_list');

		if($unit = Unit::find($id))
		{
			return View::make('units.show')->with(compact('unit'));
		}
		else
		{
			Flash::error('Sorry, that unit does not exist.');
			return Redirect::route('units.index');
		}
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /units/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$this->check_perm('manage_units');

		if($unit = Unit::find($id))
		{
			return View::make('units.edit')->with(compact('unit'));
		}
		else
		{
			Flash::error('Sorry, that unit does not exist.');
			return Redirect::route('units.index');
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
		$this->editUnitForm->validate($input);

		$this->execute('Leadofficelist\Units\EditUnitCommand', $input);

		Flash::overlay('Fipra Unit updated.', 'success');

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

		$unit = Unit::find($id);
		$unit_name = $unit->name;
		$unit = Unit::destroy($id);
		Flash::overlay('"' . $unit_name . '" has been deleted.', 'info');

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

}