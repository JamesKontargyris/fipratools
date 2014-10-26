<?php

use Ignited\Pdf\Facades\Pdf;
use Laracasts\Commander\CommanderTrait;
use Laracasts\Flash\Flash;
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
	private $addEditClientForm;
	private $client;

	function __construct( AddEditClientForm $addEditClientForm, Client $client )
	{
		parent::__construct();
		View::share( 'page_title', 'Clients' );
		View::share( 'key', 'clients' );

		$this->export_filename = $this->resource_key . '_' . date('y-m-d_G-i');
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

	public function export()
	{
		if(Input::has('filetype'))
		{
			switch(Input::get('filetype'))
			{
				case 'pdf_all':
					$contents = $this->PDFExportAll();
					$this->generatePDF($contents, $this->export_filename . '.pdf');
					return true;
					break;

				case 'pdf_selection':
					$contents = $this->PDFExportSelection();
					$this->generatePDF($contents, $this->export_filename . '_selection.pdf');
					return true;
					break;
			}
		}
		else
		{
			Flash::message('Error: cannot export to that file type.');
			return Redirect::route('clients.index');
		}
	}

	protected function generatePDF($contents, $filename)
	{
		$footer_left = 'Generated at [time] on [date]';
		$footer_center = 'Page [page] of [toPage]';
		$footer_right = 'Private and Confidential';
		$pdf = PDF::make();
		$pdf->setOptions(array(
			'orientation' => 'landscape',
			'footer-font-size' => '8',
			'footer-left' => $footer_left,
			'footer-center' => $footer_center,
			'footer-right' => $footer_right,
		));
		$pdf->addPage($contents);
		if(!$pdf->send()) throw new Exception('Could not create PDF: '.$pdf->getError());
	}

	protected function PDFExportAll()
	{
		if ( $this->user->hasRole( 'Administrator' ) )
		{
			$items = Client::all();
			$active_count = Client::where('status', '=', 1)->count();
			$dormant_count = Client::where('status', '=', 0)->count();

		} else
		{
			$items = Client::where( 'unit_id', '=', $this->user->unit_id )->get();
			$active_count = Client::where( 'unit_id', '=', $this->user->unit_id )->where('status', '=', 1)->count();
			$dormant_count = Client::where( 'unit_id', '=', $this->user->unit_id )->where('status', '=', 0)->count();
		}

		$heading1 = $this->user->hasRole('Administrator') ?
			'Clients: All' :
			$this->user->unit()->pluck('name') . " Clients";
		$heading2 = number_format($items->count(), 0) . ' total clients: ' . number_format($active_count, 0) . ' active, ' . number_format($dormant_count, 0) . ' dormant';
		$view = View::make( 'export.clients', ['items' => $items, 'heading1' => $heading1, 'heading2' => $heading2] );

		return (string) $view;
	}

	protected function PDFExportSelection()
	{
		if ( $this->searchCheck() )
		{
			$search_term = $this->findSearchTerm();
			$search_term_clean = str_replace('%', '', $search_term);

			if ( $this->user->hasRole( 'Administrator' ) )
			{
				$items = Client::where( 'name', 'LIKE', $search_term )->rowsSortOrder( $this->rows_sort_order )->paginate( $this->rows_to_view );
			} else
			{
				$items = Client::where( 'unit_id', '=', $this->user->unit_id )->where( 'name', 'LIKE', $search_term )->rowsSortOrder( $this->rows_sort_order )->paginate( $this->rows_to_view );
			}
		}
		elseif ( $this->user->hasRole( 'Administrator' ) )
		{
			$items = Client::rowsHideShowDormant( $this->rows_hide_show_dormant )->rowsSortOrder( $this->rows_sort_order )->paginate( $this->rows_to_view );
		} else
		{
			$items = Client::rowsHideShowDormant( $this->rows_hide_show_dormant )->where( 'unit_id', '=', $this->user->unit_id )->rowsSortOrder( $this->rows_sort_order )->paginate( $this->rows_to_view );
		}

		$heading1 = $this->user->hasRole('Administrator') ? 'Clients Selection' : $this->user->unit()->pluck('name') . " Clients Selection";
		$heading2 = isset($search_term_clean) ?
			'Showing ' . number_format($items->count(), 0) . ' clients when searching for ' . Session::get('clients.SearchType') . ' "' . $search_term_clean . '"' :
			'Showing ' . number_format($items->count(), 0) . ' clients';
		$view = View::make( 'export.clients', ['items' => $items, 'heading1' => $heading1, 'heading2' => $heading2] );

		return (string) $view;
	}

	public function changeStatus()
	{
		if($client = Client::find(Input::get('client_id')))
		{
			$client->status = ($client->status) ? 0 : 1;
			$status = ($client->status) ? 'active' : 'dormant';
			$client->save();
			Flash::message('Status for client "' . $client->name . '" updated.', 'info');
			EventLog::add('Client status changed: ' . $client->name . ' is now ' . $status, $this->user->getFullName(), Unit::find($client->unit_id)->name, 'info');
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