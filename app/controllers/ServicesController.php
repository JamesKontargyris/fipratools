<?php

use Laracasts\Commander\CommanderTrait;
use Laracasts\Flash\Flash;
use Leadofficelist\Exceptions\ResourceNotFoundException;
use Leadofficelist\Forms\AddEditService as AddEditServiceForm;
use Leadofficelist\Services\Service;

class ServicesController extends \BaseController
{
	use CommanderTrait;

	public $section = 'list';
	protected $resource_key = 'services';
	protected $resource_permission = 'manage_services';
	private $addEditServiceForm;

	function __construct( AddEditServiceForm $addEditServiceForm )
	{
		parent::__construct();
		$this->check_perm( 'manage_services' );
		$this->addEditServiceForm = $addEditServiceForm;
		View::share( 'page_title', 'Services' );
		View::share( 'key', 'services' );
	}


	/**
	 * Display a listing of the service.
	 * GET /services
	 *
	 * @return Response
	 */
	public function index()
	{
		$this->destroyCurrentPageNumber(true);

		if ( $this->searchCheck() )
		{
			return Redirect::to( $this->resource_key . '/search' );
		}

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
		if ( $service = $this->getService( $id ) )
		{
			$clients = $this->getActiveClientsByField( 'service_id', $id );

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
		if ( $search_term = $this->findSearchTerm() )
		{
			$items = Service::where( 'name', 'LIKE', $search_term )->rowsSortOrder( $this->rows_sort_order )->paginate( $this->rows_to_view );

			if ( ! $this->checkForSearchResults( $items ) )
			{
				return Redirect::route( $this->resource_key . '.index' );
			}
			$items->search_term = str_replace( '%', '', $search_term );
			$items->key         = 'services';

			return View::make( 'services.index' )->with( compact( 'items' ) );
		} else
		{
			return View::make( 'services.index' );
		}
	}

	protected function getAll()
	{
		return Service::all();
	}

	protected function getSelection()
	{
		if ( $this->searchCheck() )
		{
			$search_term = $this->findSearchTerm();
			$this->search_term_clean = str_replace('%', '', $search_term);

			$items = Service::where( 'name', 'LIKE', $search_term )->rowsSortOrder( $this->rows_sort_order )->paginate($this->rows_to_view);
		}
		else
		{
			$items = Service::rowsSortOrder( $this->rows_sort_order )->paginate( $this->rows_to_view );
		}

		return $items;
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