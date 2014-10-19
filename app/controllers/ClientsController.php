<?php

use Laracasts\Commander\CommanderTrait;
use Laracasts\Flash\Flash;
use Leadofficelist\Client_archives\ClientArchive;
use Leadofficelist\Clients\Client;
use Leadofficelist\Exceptions\PermissionDeniedException;
use Leadofficelist\Forms\AddEditClient as AddEditClientForm;
use Leadofficelist\Sectors\Sector;
use Leadofficelist\Services\Service;
use Leadofficelist\Types\Type;
use Leadofficelist\Units\Unit;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

class ClientsController extends \BaseController
{

	use CommanderTrait;

	protected $resource_key = 'clients';
	private $addEditClientForm;
	private $client;

	function __construct( AddEditClientForm $addEditClientForm, Client $client )
	{
		parent::__construct();
		View::share( 'page_title', 'Clients' );
		View::share( 'key', 'clients' );
		$this->addEditClientForm = $addEditClientForm;
		$this->client            = $client;
	}

	/**
	 * Display a listing of clients.
	 * GET /clients
	 *
	 * @return Response
	 */
	public function index()
	{
		$this->check_perm( 'manage_clients' );

		if ( $this->searchCheck() )
		{
			return Redirect::to( $this->resource_key . '/search' );
		}

		if ( $this->user->hasRole( 'Administrator' ) )
		{
			$items = Client::rowsHideShowDormant( $this->rows_hide_show_dormant )->rowsSortOrder( $this->rows_sort_order )->paginate( $this->rows_to_view );
		} else
		{
			$items = Client::rowsHideShowDormant( $this->rows_hide_show_dormant )->where( 'unit_id', '=', $this->user->unit_id )->rowsSortOrder( $this->rows_sort_order )->paginate( $this->rows_to_view );
		}
		$items->key = 'clients';

		return View::make( 'clients.index' )->with( compact( 'items' ) );
	}

	/**
	 * Show the form for creating a new client.
	 * GET /clients/create
	 *
	 * @return Response
	 */
	public function create()
	{
		$this->check_perm( 'manage_clients' );

		$this->getFormData();

		return View::make( 'clients.create' )->with( [
			'account_directors' => $this->account_directors,
			'units'             => $this->units,
			'sectors'           => $this->sectors,
			'types'             => $this->types,
			'services'          => $this->services
		] );
	}

	/**
	 * Store a newly created client in storage.
	 * POST /clients
	 *
	 * @return Response
	 */
	public function store()
	{
		$this->check_perm( 'manage_clients' );

		$input = Input::all();
		$this->addEditClientForm->validate( $input );

		$this->execute( 'Leadofficelist\Clients\AddClientCommand' );

		Flash::overlay( '"' . $input['name'] . '" added.', 'success' );

		return Redirect::route( 'clients.index' );
	}

	/**
	 * Display the specified client.
	 * GET /clients/{id}
	 *
	 * @param  int $id
	 *
	 * @throws PermissionDeniedException
	 * @return Response
	 */
	public function show( $id )
	{
		$this->check_perm( 'view_list' );

		if ( $client = Client::find( $id ) )
		{

			$linked_units = $this->client->getLinkedUnits( $id );
			$archives     = ClientArchive::orderBy( 'start_date', 'DESC' )->where( 'client_id', '=', $id )->get();

			return View::make( 'clients.show' )->with( compact( 'client', 'archives', 'linked_units' ) );
		} else
		{
			throw new ResourceNotFoundException( 'clients' );
		}
	}

	/**
	 * Show the form for editing the specified client.
	 * GET /clients/{id}/edit
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function edit( $id )
	{
		$this->check_perm( 'manage_clients' );

		if ( $client = $this->getClient( $id ) )
		{
			$this->getFormData();

			return View::make( 'clients.edit' )->with( [
				'account_directors' => $this->account_directors,
				'units'             => $this->units,
				'sectors'           => $this->sectors,
				'types'             => $this->types,
				'services'          => $this->services,
				'client'            => $client
			] );
		} else
		{
			throw new ResourceNotFoundException( 'clients' );
		}
	}

	/**
	 * Update the specified client in storage.
	 * PUT /clients/{id}
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function update( $id )
	{
		$this->check_perm( 'manage_clients' );

		$input                                  = Input::all();
		$input['id']                            = $id;
		$this->addEditClientForm->rules['name'] = 'required|max:255|unique:clients,name,' . $id;
		$this->addEditClientForm->validate( $input );

		$this->execute( 'Leadofficelist\Clients\EditClientCommand', $input );

		Flash::overlay( '"' . $input['name'] . '" updated.', 'success' );

		return Redirect::route( 'clients.index' );
	}

	/**
	 * Remove the specified client from storage.
	 * DELETE /clients/{id}
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function destroy( $id )
	{
		$this->check_role( 'Administrator' );

		if ( $client = $this->getClient( $id ) )
		{
			Client::destroy( $id );
			Flash::overlay( '"' . $client->name . '" deleted.', 'info' );

		}

		return Redirect::route( 'clients.index' );
	}

	/**
	 * Process a client search.
	 *
	 * @return $this
	 */
	public function search()
	{
		$this->check_perm( 'manage_clients' );

		if ( $search_term = $this->findSearchTerm() )
		{
			//If the user is an administrator, search on all clients
			//If not, search on only the clients for the user's Unit ID
			if ( $this->user->hasRole( 'Administrator' ) )
			{
				$items = Client::where( 'name', 'LIKE', $search_term )->rowsSortOrder( $this->rows_sort_order )->paginate( $this->rows_to_view );
			} else
			{
				$items = Client::where( 'unit_id', '=', $this->user->unit_id )->where( 'name', 'LIKE', $search_term )->rowsSortOrder( $this->rows_sort_order )->paginate( $this->rows_to_view );
			}

			if ( ! $this->checkForSearchResults( $items ) )
			{
				return Redirect::route( $this->resource_key . '.index' );
			}

			$items->key         = 'clients';
			$items->search_term = str_replace( '%', '', $search_term );

			return View::make( 'clients.index' )->with( compact( 'items' ) );
		} else
		{
			return Redirect::route( 'clients.index' );
		}
	}

	public function changeStatus()
	{
		if($client = Client::find(Input::get('client_id')))
		{
			$client->status = ($client->status) ? 0 : 1;
			$client->save();
			Flash::message('Status for client "' . $client->name . '" updated.', 'info');
		}
		else
		{
			Flash::message('Client not found.', 'info');
		}

		return Redirect::route('clients.index');
	}

	protected function getClient( $id )
	{
		$client = Client::find( $id );
		if ( ! $this->user->hasRole( 'Administrator' ) && $client->unit()->pluck( 'id' ) != $this->user->unit_id )
		{
			throw new PermissionDeniedException( 'clients' );
		}

		return $client;
	}

}