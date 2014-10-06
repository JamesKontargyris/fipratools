<?php

use Laracasts\Commander\CommanderTrait;
use Laracasts\Flash\Flash;
use Leadofficelist\Sectors\Sector;
use Leadofficelist\Forms\AddEditSector as AddEditSectorForm;

class SectorsController extends \BaseController
{
	use CommanderTrait;

	protected $resource_key = 'sectors';
	private $addEditSectorForm;

	function __construct(AddEditSectorForm $addEditSectorForm)
	{
		parent::__construct();

		$this->check_perm('manage_sectors');
		$this->addEditSectorForm = $addEditSectorForm;

		View::share('page_title', 'Sectors');
	}

	/**
	 * Display a listing of sectors.
	 * GET /sectors
	 *
	 * @return Response
	 */
	public function index()
	{
		$this->check_perm('manage_sectors');

		$items = Sector::rowsSortOrder($this->rows_sort_order)->paginate($this->rows_to_view);
		$items->key = 'sectors';
		return View::make('sectors.index')->with(compact('items'));
	}

	/**
	 * Show the form for creating a new sector.
	 * GET /sectors/create
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('sectors.create');
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
		$this->addEditSectorForm->validate($input);

		$this->execute('Leadofficelist\Sectors\AddSectorCommand');

		Flash::overlay('Sector added.', 'success');

		return Redirect::route('sectors.index');
	}

	/**
	 * Display the specified sector.
	 * GET /sectors/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		if($sector = Sector::find($id))
		{
			//TODO: get clients in this sector
			//TODO: convert array values to objects in view
			$clients[0] = ['name' => 'Joe Bloggs'];
			$clients[1] = ['name' => 'Helen Jones'];
			$clients[2] = ['name' => 'Will Kontargyris'];

			return View::make('sectors.show')->with(compact('sector', 'clients'));
		}
		else
		{
			Flash::error('Sorry, that sector does not exist.');
			return Redirect::route('sectors.index');
		}
	}

	/**
	 * Show the form for editing the specified sector.
	 * GET /sectors/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		if($sector = Sector::find($id))
		{
			return View::make('sectors.edit')->with(compact('sector'));
		}
		else
		{
			Flash::error('Sorry, that sector does not exist.');
			return Redirect::route('sectors.index');
		}
	}

	/**
	 * Update the specified sector in storage.
	 * PUT /sectors/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$input = Input::all();
		$input['id'] = $id;
		$this->addEditSectorForm->rules['name'] = 'required|max:255|unique:sectors,name,' . $id;
		$this->addEditSectorForm->validate($input);

		$this->execute('Leadofficelist\Sectors\EditSectorCommand', $input);

		Flash::overlay('Sector updated.', 'success');

		return Redirect::route('sectors.index');
	}

	/**
	 * Remove the specified sector from storage.
	 * DELETE /sectors/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$sector = Sector::find($id);
		$sector_name = $sector->name;
		$sector = Sector::destroy($id);
		Flash::overlay('"' . $sector_name . '" has been deleted.', 'info');

		return Redirect::route('sectors.index');
	}

	public function search()
	{
		$items = Sector::where('name', 'LIKE', '%' . Input::get('search') . '%')->rowsSortOrder($this->rows_sort_order)->paginate($this->rows_to_view);
		$items->key = 'sectors';
		$items->search_term = Input::get('search');
		return View::make('sectors.index')->with(compact('items'));
	}

}