<?php

use Laracasts\Commander\CommanderTrait;
use Leadofficelist\Eventlogs\EventLog;
use Leadofficelist\Toolbox\Toolbox;
use Leadofficelist\Forms\AddEditToolbox as AddEditToolboxForm;
use Leadofficelist\Units\Unit;

class ToolboxController extends \BaseController {
	use CommanderTrait;

	public $section = 'toolbox';
	protected $resource_key = 'toolbox';
	public $addEditToolboxForm;

	public function __construct(AddEditToolboxForm $addEditToolboxForm)
	{
		parent::__construct();

		View::share( 'page_title', 'Toolbox' );
		View::share( 'key', 'toolbox' );
		$this->addEditToolboxForm = $addEditToolboxForm;
	}

	/**
	 * Display a listing of the resource.
	 * GET /toolbox
	 *
	 * @return Response
	 */
	public function index()
	{
		$this->check_perm( 'view_toolbox' );

		$links = Toolbox::where('type', '=', 'link')->orderBy('name')->get();
		$files = Toolbox::where('type', '=', 'file')->orderBy('name')->get();

		return View::make('toolbox.index')->with(compact('links', 'files'));
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /toolbox/create
	 *
	 * @return Response
	 */
	public function create()
	{
		$this->check_perm('manage_toolbox');

		return View::make('toolbox.create');
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /toolbox
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		$this->addEditToolboxForm->validate( $input );

		if($input['type'] == 'link') $resource = $this->execute( 'Leadofficelist\Toolbox\AddToolboxLinkCommand' );
		if($input['type'] == 'file') {
			if(Input::hasFile('file')) {
				$file = Input::file('file');
				$destination = 'uploads/';
				$filename = strtolower(str_replace(' ', '_', $file->getClientOriginalName()));
				$file->move($destination, $filename);
				Input::merge(['filename' => $destination . $filename]);
			}
			$resource = $this->execute( 'Leadofficelist\Toolbox\AddToolboxFileCommand' );
		}

		Flash::overlay( '"' . $input['name'] . '" ' . $input['type'] . ' added.', 'success' );

		EventLog::add( 'New toolbox ' . $input['type'] . ' created: "' . $input['name'] . '"', $this->user->getFullName(), Unit::find( $this->user->unit_id )->name, 'add' );

		return Redirect::route( 'toolbox.index' );
	}

	/**
	 * Display the specified resource.
	 * GET /toolbox/{id}
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
	 * GET /toolbox/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$this->check_perm( 'manage_toolbox' );

		if ( $edit_toolbox = $this->getResource( $id ) ) {

			return View::make( 'toolbox.edit' )->with(compact('edit_toolbox'));

		} else {
			throw new ResourceNotFoundException( 'toolbox' );
		}
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /toolbox/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$this->check_perm( 'manage_toolbox' );

		$input                              = Input::all();
		$input['id']                        = $id;
		$this->addEditToolboxForm->validate( $input );

		if($input['type'] == 'link') $this->execute( 'Leadofficelist\Toolbox\EditToolboxLinkCommand', $input );
		if($input['type'] == 'file') $this->execute( 'Leadofficelist\Toolbox\EditToolboxFileCommand', $input );

		Flash::overlay( '"' . $input['name'] . '" updated.', 'success' );

		EventLog::add( 'Toolbox ' . $input['type'] . ' edited: ' . $input['name'], $this->user->getFullName(), Unit::find( $this->user->unit_id )->name, 'edit' );

		return Redirect::route( 'toolbox.index' );
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /toolbox/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$this->check_perm( 'manage_toolbox' );

		if ( $resource = $this->getResource( $id ) ) {
			if($resource->type == 'file' && file_exists(public_path() . '/' . $resource->file)) unlink(public_path() . '/' . $resource->file);
			Toolbox::destroy( $id );
			Flash::overlay( '"' . $resource->name . '" deleted.', 'info' );

			EventLog::add( 'Toolbox ' . $resource->type . ' deleted: "' . $resource->name . '"', $this->user->getFullName(), Unit::find( $this->user->unit_id )->name, 'delete' );

		}

		return Redirect::route( 'toolbox.index' );
	}

	private function getResource($id)
	{
		return Toolbox::find($id);
	}

}