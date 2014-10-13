<?php

use Laracasts\Commander\CommanderTrait;
use Laracasts\Flash\Flash;
use Leadofficelist\Client_archives\ClientArchive;
use Leadofficelist\Clients\Client;
use Leadofficelist\Exceptions\PermissionDeniedException;
use Leadofficelist\Exceptions\ResourceNotFoundException;
use Leadofficelist\Forms\AddEditClientArchive as AddEditClientArchiveForm;

class ClientArchivesController extends \BaseController
{
	use CommanderTrait;

	protected $resource_key = 'client_archives';
	/**
	 * @var
	 */
	private $addEditClientArchiveForm;

	function __construct(AddEditClientArchiveForm $addEditClientArchiveForm)
	{
		parent::__construct();
		$this->addEditClientArchiveForm = $addEditClientArchiveForm;
	}


	/**
	 * Display a listing of the resource.
	 * GET /clientarchives
	 *
	 * @return Response
	 */
	public function index()
	{
		$items = [];
		$client = [];

		if(Input::has('client_id'))
		{
			$items = ClientArchive::orderBy('start_date', 'DESC')->where('client_id', '=', Input::get('client_id'))->get();
			$client = Client::find(Input::get('client_id'));
		}

		if( ! Input::has('client_id') || ! $items || ! $client)
		{
			Flash::message("Sorry - I can't access that archive record.");

			return Redirect::route('clients.index');
		}

		return View::make( 'client_archives.index' )->with(compact('items', 'client'));
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /clientarchives/create
	 * @throws PermissionDeniedException
	 * @return Response
	 */
	public function create()
	{
		$client_id = Input::get('client_id');
		$client = Client::find($client_id);

		if(isset($client->id) && $client->unit_id == $this->user->unit_id || $this->user->hasRole('Administrator'))
		{
			return View::make('client_archives.create')->with(compact('client'));
		}
		else
		{
			throw new PermissionDeniedException();
		}
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /clientarchives
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		$this->addEditClientArchiveForm->validate( $input );

		$this->execute( 'Leadofficelist\Client_archives\AddClientArchiveCommand' );

		Flash::overlay( 'Archive record added.', 'success' );

		return Redirect::route( 'clients.index' );
	}

	/**
	 * Display the specified resource.
	 * GET /clientarchives/{id}
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function show( $id )
	{
		return Redirect::route('client_archives.index');
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /clientarchives/{id}/edit
	 *
	 * @param  int $id
	 *
	 * @throws ResourceNotFoundException
	 * @return Response
	 */
	public function edit( $id )
	{
		$client_id = Input::get('client_id');
		$client = Client::find($client_id);
		$client_archive = $this->getClientArchive( $id );

		if ( isset($client_archive->id) && isset($client->id) && $client->unit_id == $this->user->unit_id || $this->user->hasRole('Administrator') )
		{
			return View::make('client_archives.edit')->with(compact('client', 'client_archive'));
		}
		else
		{
			throw new ResourceNotFoundException( 'client_archives' );
		}
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /clientarchives/{id}
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function update( $id )
	{
		$input = Input::all();
		$input['id'] = $id;
		$this->addEditClientArchiveForm->validate($input);

		$this->execute('Leadofficelist\Client_archives\EditClientArchiveCommand', $input);

		Flash::overlay('Client archive record updated.', 'success');

		return Redirect::route('client_archives.index', ['client_id' => $input['client_id']]);
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /clientarchives/{id}
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function destroy( $id )
	{
		if($client_archive = $this->getClientArchive($id))
		{
			ClientArchive::destroy($id);
			Flash::overlay('Client archive record deleted.', 'info');

		}

		return Redirect::route('client_archives.index', ['client_id' => Input::get('client_id')]);
	}

	protected function getClientArchive( $id )
	{
		return ClientArchive::find( $id );
	}

}