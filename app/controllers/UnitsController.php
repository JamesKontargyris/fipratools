<?php

use Laracasts\Commander\CommanderTrait;
use Laracasts\Flash\Flash;
use Leadofficelist\Forms\AddUnit as AddUnitForm;
use Leadofficelist\Units\Unit;

class UnitsController extends \BaseController {

	use CommanderTrait;

	/**
	 * @var AddUnitForm
	 */
	private $addUnitForm;

	public function __construct(AddUnitForm $addUnitForm) {

		$this->addUnitForm = $addUnitForm;
	}


	/**
	 * Display a listing of all units1.
	 * GET /units
	 *
	 * @return Response
	 */
	public function index()
	{
		$this->reset_filters();

		$rows_sort_order = $this->getRowsSortOrder();
		$rows_to_view = $this->getRowsToView();

		$units = Unit::rowsSortOrder($rows_sort_order)->paginate($rows_to_view);
		return View::make('units.index')->with(compact('units'));
	}

	/**
	 * Show the form for adding a new unit.
	 * GET /units/create
	 *
	 * @return Response
	 */
	public function create()
	{
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
		$input = Input::all();
		$this->addUnitForm->validate($input);

		$this->execute('Leadofficelist\Units\AddUnitCommand');

		Flash::overlay('Fipra Unit added.', 'success');

		return Redirect::to('unit');
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
		//
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
		//
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
		//
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
		//
	}

}