<?php

use Carbon\Carbon;
use Ignited\Pdf\Facades\Pdf;
use Laracasts\Commander\CommanderTrait;
use Laracasts\Flash\Flash;
use Leadofficelist\Account_directors\AccountDirector;
use Leadofficelist\Client_archives\ClientArchive;
use Leadofficelist\Clients\Client;
use Leadofficelist\Eventlogs\EventLog;
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
	protected $resource_permission = 'manage_clients';
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

		$this->destroyCurrentPageNumber(true);

		if ( $this->searchCheck() )
		{
			return Redirect::to( $this->resource_key . '/search' );
		}

		if ( $this->user->hasRole( 'Administrator' ) )
		{
			$items = Client::rowsHideShowDormant( $this->rows_hide_show_dormant )->rowsHideShowActive( $this->rows_hide_show_active )->rowsSortOrder( $this->rows_sort_order )->paginate( $this->rows_to_view );
		} else
		{
			$items = Client::rowsHideShowDormant( $this->rows_hide_show_dormant )->rowsHideShowActive( $this->rows_hide_show_active )->where( 'unit_id', '=', $this->user->unit_id )->rowsSortOrder( $this->rows_sort_order )->paginate( $this->rows_to_view );
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
		if( ! isset($input['pr_client'])) $input['pr_client'] = 0;
		$this->addEditClientForm->validate( $input );

		$this->execute( 'Leadofficelist\Clients\AddClientCommand', $input );

		Flash::overlay( '"' . $input['name'] . '" added.', 'success' );
		EventLog::add('Client created: ' . $input['name'], $this->user->getFullName(), Unit::find($input['unit_id'])->name, 'add');

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
			$archives     = ClientArchive::orderBy( 'date', 'DESC' )->where( 'client_id', '=', $id )->get();

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

		if ( $client = $this->getClient( $id ))
		{
			// Check permissions
			if( $this->user->hasRole('Administrator') || $this->user->id == $client->user_id)
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
				throw new PermissionDeniedException('clients');
			}

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
		if( ! isset($input['pr_client'])) $input['pr_client'] = 0;
		$this->addEditClientForm->rules['name'] = 'required|max:255|unique:clients,name,' . $id . ',id,unit_id,' . $input['unit_id'];
		$this->addEditClientForm->validate( $input );

		$this->execute( 'Leadofficelist\Clients\EditClientCommand', $input );

		Flash::overlay( '"' . $input['name'] . '" updated.', 'success' );
		EventLog::add('Client edited: ' . $input['name'], $this->user->getFullName(), Unit::find($input['unit_id'])->name, 'edit');

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
			EventLog::add('Client deleted: ' . $client->name, $this->user->getFullName(), Unit::find($client->unit_id)->name, 'delete');
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

		$this->destroyCurrentPageNumber(true);

		if ( $search_term = $this->findSearchTerm() )
		{
			//If the user is an administrator, search on all clients
			//If not, search on only the clients for the user's Unit ID
			if ( $this->user->hasRole( 'Administrator' ) )
			{
				$items = Client::where( 'name', 'LIKE', $search_term )->rowsHideShowDormant( $this->rows_hide_show_dormant )->rowsHideShowActive( $this->rows_hide_show_active )->rowsSortOrder( $this->rows_sort_order )->paginate( $this->rows_to_view );
			} else
			{
				$items = Client::where( 'unit_id', '=', $this->user->unit_id )->rowsHideShowDormant( $this->rows_hide_show_dormant )->rowsHideShowActive( $this->rows_hide_show_active )->where( 'name', 'LIKE', $search_term )->rowsSortOrder( $this->rows_sort_order )->paginate( $this->rows_to_view );
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

	protected function getAll()
	{
		if ( $this->user->hasRole( 'Administrator' ) )
		{
			return Client::orderBy('name', 'ASC')->rowsHideShowDormant( $this->rows_hide_show_dormant )->rowsHideShowActive( $this->rows_hide_show_active )->get();

		} else
		{
			return Client::orderBy('name', 'ASC')->rowsHideShowDormant( $this->rows_hide_show_dormant )->rowsHideShowActive( $this->rows_hide_show_active )->where( 'unit_id', '=', $this->user->unit_id )->get();
		}
	}

	protected function getSelection()
	{
		if ( $this->searchCheck() )
		{
			$search_term = $this->findSearchTerm();
			$this->search_term_clean = str_replace('%', '', $search_term);

			if ( $this->user->hasRole( 'Administrator' ) )
			{
				$items = Client::rowsHideShowDormant( $this->rows_hide_show_dormant )->rowsHideShowActive( $this->rows_hide_show_active )->where( 'name', 'LIKE', $search_term )->rowsSortOrder( $this->rows_sort_order )->paginate( $this->rows_to_view );
			} else
			{
				$items = Client::rowsHideShowDormant( $this->rows_hide_show_dormant )->rowsHideShowActive( $this->rows_hide_show_active )->where( 'unit_id', '=', $this->user->unit_id )->where( 'name', 'LIKE', $search_term )->rowsSortOrder( $this->rows_sort_order )->paginate( $this->rows_to_view );
			}
		}
		elseif ( $this->user->hasRole( 'Administrator' ) )
		{
			$items = Client::rowsHideShowDormant( $this->rows_hide_show_dormant )->rowsHideShowActive( $this->rows_hide_show_active )->rowsSortOrder( $this->rows_sort_order )->paginate( $this->rows_to_view );
		} else
		{
			$items = Client::rowsHideShowDormant( $this->rows_hide_show_dormant )->rowsHideShowActive( $this->rows_hide_show_active )->where( 'unit_id', '=', $this->user->unit_id )->rowsSortOrder( $this->rows_sort_order )->paginate( $this->rows_to_view );
		}

		return $items;
	}

	protected function getDuplicates()
	{
		$this->check_role('Administrator');

		$items = Client::orderBy('name', 'ASC')->whereRaw('LOWER(name) IN (SELECT LOWER(name) FROM clients GROUP BY name HAVING count(name)>1)')->get();

		return $items;
	}

	public function changeStatus()
	{
		if($client = Client::find(Input::get('client_id')))
		{
			$client->status = ($client->status) ? 0 : 1;
			$status = ($client->status) ? 'active' : 'dormant';
			$client->save();
			Flash::message('Status for client "' . $client->name . '" updated.', 'info');
			EventLog::add('Client status changed: ' . $client->name . ' is now ' . $status, $this->user->getFullName(),$client->unit->name, 'info');

            $this->execute( 'Leadofficelist\Client_archives\AddClientArchiveCommand', ['date' => Carbon::now(), 'unit' => $client->unit->name, 'account_director' => AccountDirector::find($client->account_director_id)->getFullName(), 'comment' => 'Became ' . $status, 'client_id' => $client->id] );
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