<?php

use Laracasts\Commander\CommanderTrait;
use Laracasts\Flash\Flash;
use Leadofficelist\Clients\Client;
use Leadofficelist\Forms\AddEditClient as AddEditClientForm;
use Leadofficelist\Sectors\Sector;
use Leadofficelist\Services\Service;
use Leadofficelist\Types\Type;
use Leadofficelist\Units\Unit;

class ClientsController extends \BaseController
{

	use CommanderTrait;

	protected $resource_key = 'clients';
	protected $units;
	protected $sectors;
	protected $types;
	protected $services;
	private $addEditClientForm;

	function __construct( AddEditClientForm $addEditClientForm )
	{
		parent::__construct();
		$this->check_perm( 'manage_clients' );
		View::share( 'page_title', 'Clients' );
		$this->addEditClientForm = $addEditClientForm;
	}

	/**
	 * Display a listing of clients.
	 * GET /clients
	 *
	 * @return Response
	 */
	public function index()
	{
		if ( $this->user->hasRole( 'Administrator' ) )
		{
			$items = Client::rowsSortOrder( $this->rows_sort_order )->paginate( $this->rows_to_view );
		} else
		{
			$items = Client::where( 'unit_id', '=', $this->user->unit_id )->rowsSortOrder( $this->rows_sort_order )->paginate( $this->rows_to_view );
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
		$this->getFormData();

		return View::make( 'clients.create' )->with( [
			'units'    => $this->units,
			'sectors'  => $this->sectors,
			'types'    => $this->types,
			'services' => $this->services
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
	 * @return Response
	 */
	public function show( $id )
	{
		//
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
		//
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
		//
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
		//
	}

	/**
	 * Process a client search.
	 *
	 * @return $this
	 */
	public function search()
	{
		$items              = Client::where( 'name', 'LIKE', '%' . Input::get( 'search' ) . '%' )->rowsSortOrder( $this->rows_sort_order )->paginate( $this->rows_to_view );
		$items->key         = 'clients';
		$items->search_term = Input::get( 'search' );

		return View::make( 'clients.index' )->with( compact( 'items' ) );
	}

	protected function getClient($id)
	{
		return Client::find( $id );
	}

	/**
	 * Get all data required to populate the add/edit user forms.
	 *
	 * @return bool
	 */
	protected function getFormData()
	{
		$this->units    = $this->getUnitsFormData();
		$this->sectors  = $this->getSectorsFormData();
		$this->types    = $this->getTypesFormData();
		$this->services = $this->getServicesFormData();

		return true;
	}

	/**
	 * Get all the units in a select element-friendly collection.
	 *
	 * @return array
	 */
	protected function getUnitsFormData()
	{
		if ( ! Unit::getUnitsForFormSelect( true ) )
		{
			return [ '' => 'No units available to select' ];
		}

		return Unit::getUnitsForFormSelect( true );
	}

	/**
	 * Get all the sectors in a select element-friendly collection.
	 *
	 * @return array
	 */
	protected function getSectorsFormData()
	{
		if ( ! Sector::getSectorsForFormSelect( true ) )
		{
			return [ '' => 'No sectors available to select' ];
		}

		return Sector::getSectorsForFormSelect( true );
	}

	/**
	 * Get all the types in a select element-friendly collection.
	 *
	 * @return array
	 */
	protected function getTypesFormData()
	{
		if ( ! Type::getTypesForFormSelect( true ) )
		{
			return [ '' => 'No types available to select' ];
		}

		return Type::getTypesForFormSelect( true );
	}

	/**
	 * Get all the types in a select element-friendly collection.
	 *
	 * @return array
	 */
	protected function getServicesFormData()
	{
		if ( ! Service::getServicesForFormSelect( true ) )
		{
			return [ '' => 'No services available to select' ];
		}

		return Service::getServicesForFormSelect( true );
	}

}