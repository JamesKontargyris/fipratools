<?php

use Laracasts\Commander\CommanderTrait;
use Laracasts\Flash\Flash;
use Leadofficelist\Exceptions\ResourceNotFoundException;
use Leadofficelist\Forms\AddEditService as AddEditServiceForm;
use Leadofficelist\Services\Service;

class ServicesController extends \BaseController
{
	use CommanderTrait;

	protected $resource_key = 'sectors';
	private $addEditServiceForm;

	function __construct( AddEditServiceForm $addEditServiceForm )
	{
		parent::__construct();
		$this->check_perm( 'manage_services' );
		$this->addEditServiceForm = $addEditServiceForm;
		View::share( 'page_title', 'Services' );
	}


	/**
	 * Display a listing of the service.
	 * GET /services
	 *
	 * @return Response
	 */
	public function index()
	{
		$items      = Service::rowsSortOrder( $this->rows_sort_order )->paginate( $this->rows_to_view );
		$items->key = 'services';

		return View::make( 'services.index' )->with( compact( 'items' ) );
	}

	/**
	 * Show the form for creating a new service.
	 * GET /services/create
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make( 'services.create' );
	}

	/**
	 * Store a newly created service in storage.
	 * POST /services
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		$this->addEditServiceForm->validate( $input );

		$this->execute( 'Leadofficelist\Services\AddServiceCommand' );

		Flash::overlay( '"' . $input['name'] . '" added.', 'success' );

		return Redirect::route( 'services.index' );
	}

	/**
	 * Display the specified service.
	 * GET /services/{id}
	 *
	 * @param  int $id
	 *
	 * @throws ResourceNotFoundException
	 * @return Response
	 */
	public function show( $id )
	{
		if ( $this->getService( $id ) )
		{
			//TODO: get clients in this sector
			//TODO: convert array values to objects in view
			$clients[0] = [ 'name' => 'Joe Bloggs' ];
			$clients[1] = [ 'name' => 'Helen Jones' ];
			$clients[2] = [ 'name' => 'Will Kontargyris' ];

			return View::make( 'services.show' )->with( compact( 'service', 'clients' ) );
		} else
		{
			throw new ResourceNotFoundException( 'services' );
		}
	}

	/**
	 * Show the form for editing the specified service.
	 * GET /services/{id}/edit
	 *
	 * @param  int $id
	 *
	 * @throws ResourceNotFoundException
	 * @return Response
	 */
	public function edit( $id )
	{
		if ( $service = $this->getService( $id ) )
		{
			return View::make( 'services.edit' )->with( compact( 'service' ) );
		} else
		{
			throw new ResourceNotFoundException( 'services' );
		}
	}

	/**
	 * Update the specified service in storage.
	 * PUT /services/{id}
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function update( $id )
	{
		$input                                   = Input::all();
		$input['id']                             = $id;
		$this->addEditServiceForm->rules['name'] = 'required|max:255|unique:services,name,' . $id;
		$this->addEditServiceForm->validate( $input );

		$this->execute( 'Leadofficelist\Services\EditServiceCommand', $input );

		Flash::overlay( '"' . $input['name'] . '" updated.', 'success' );

		return Redirect::route( 'services.index' );
	}

	/**
	 * Remove the specified service from storage.
	 * DELETE /services/{id}
	 *
	 * @param  int $id
	 *
	 * @throws ResourceNotFoundException
	 * @return Response
	 */
	public function destroy( $id )
	{
		if ( $service = $this->getService( $id ) )
		{
			Service::destroy( $id );
			Flash::overlay( '"' . $service->name . '" has been deleted.', 'info' );

			return Redirect::route( 'services.index' );
		} else
		{
			throw new ResourceNotFoundException( 'services' );
		}
	}

	/**
	 * Process a services search.
	 *
	 * @return $this
	 */
	public function search()
	{
		$items              = Service::where( 'name', 'LIKE', '%' . Input::get( 'search' ) . '%' )->rowsSortOrder( $this->rows_sort_order )->paginate( $this->rows_to_view );
		$items->key         = 'services';
		$items->search_term = Input::get( 'search' );

		return View::make( 'services.index' )->with( compact( 'items' ) );
	}

	/**
	 * Get the current service
	 *
	 * @param $id
	 *
	 * @return mixed
	 */
	protected function getService( $id )
	{
		return Service::find( $id );
	}
}