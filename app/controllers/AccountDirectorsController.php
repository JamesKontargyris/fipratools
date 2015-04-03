<?php

use Laracasts\Commander\CommanderTrait;
use Laracasts\Flash\Flash;
use Leadofficelist\Account_directors\AccountDirector;
use Leadofficelist\Exceptions\ResourceNotFoundException;
use Leadofficelist\Forms\AddEditAccountDirector as AddEditAccountDirectorForm;

class AccountDirectorsController extends \BaseController
{

	use CommanderTrait;

	protected $resource_key = 'account_directors';
	protected $resource_permission = 'manage_users';
	private $addEditAccountDirectorForm;
	private $search_term;

	function __construct( AddEditAccountDirectorForm $addEditAccountDirectorForm )
	{
		parent::__construct();

		$this->check_role( 'Administrator' );
		View::share( 'page_title', 'Account Directors' );
		View::share( 'key', 'account_directors' );
		$this->addEditAccountDirectorForm = $addEditAccountDirectorForm;
	}

	/**
	 * Display a listing of the resource.
	 * GET /account_directors
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

		$items      = AccountDirector::rowsSortOrder( $this->rows_sort_order )->paginate( $this->rows_to_view );
		$items->key = 'account_directors';

		return View::make( 'account_directors.index' )->with( compact( 'items' ) );
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /account_directors/create
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make( 'account_directors.create' );
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /account_directors
	 *
	 * @return Response
	 */
	public function store()
	{
		$input                                                 = Input::all();
		$this->addEditAccountDirectorForm->rules['first_name'] = 'required|max:255|unique:account_directors,first_name,NULL,id,first_name,' . $input['first_name'] . ',last_name,' . $input['last_name'];
		$this->addEditAccountDirectorForm->validate( $input );

		$this->execute( 'Leadofficelist\Account_directors\AddAccountDirectorCommand' );

		Flash::overlay( '"' . $input['first_name'] . ' ' . $input['last_name'] . '" added.', 'success' );

		return Redirect::route( 'account_directors.index' );
	}

	/**
	 * Display the specified resource.
	 * GET /account_directors/{id}
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function show( $id )
	{
		return View::make( 'account_directors.index' );
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /account_directors/{id}/edit
	 *
	 * @param  int $id
	 *
	 * @throws ResourceNotFoundException
	 * @return Response
	 */
	public function edit( $id )
	{
		if ( $account_director = $this->getAccountDirector( $id ) )
		{
			return View::make( 'account_directors.edit' )->with( [ 'account_director' => $account_director ] );
		} else
		{
			throw new ResourceNotFoundException( 'account_directors' );
		}
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /account_directors/{id}
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function update( $id )
	{
		$input                                                 = Input::all();
		$input['id']                                           = $id;
		$this->addEditAccountDirectorForm->rules['first_name'] = 'required|max:255|unique:account_directors,first_name,NULL,id,first_name,' . $input['first_name'] . ',last_name,' . $input['last_name'];
		$this->addEditAccountDirectorForm->validate( $input );

		$this->execute( 'Leadofficelist\Account_directors\EditAccountDirectorCommand', $input );

		Flash::overlay( '"' . $input['first_name'] . ' ' . $input['last_name'] . '" updated.', 'success' );

		return Redirect::route( 'account_directors.index' );
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /account_directors/{id}
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function destroy( $id )
	{
		if ( $account_director = $this->getAccountDirector( $id ) )
		{
			AccountDirector::destroy( $id );
			Flash::overlay( '"' . $account_director->getFullName() . '" deleted.', 'info' );

		}

		return Redirect::route( 'account_directors.index' );
	}

	/**
	 * Process an account director search.
	 *
	 * @return $this
	 */
	public function search()
	{
		if ( $this->search_term = $this->findSearchTerm() )
		{
			//Search on both first_name and last_name
			$items = AccountDirector::where( function ( $query )
			{
				$query->where( 'first_name', 'LIKE', $this->search_term );
			} )->rowsSortOrder( $this->rows_sort_order )->paginate( $this->rows_to_view );

			if ( ! $this->checkForSearchResults( $items ) )
			{
				return Redirect::route( $this->resource_key . '.index' );
			}

			$items->key         = 'account_directors';
			$items->search_term = str_replace( '%', '', $this->search_term );

			return View::make( 'account_directors.index' )->with( compact( 'items' ) );
		} else
		{
			return Redirect::route( 'account_directors.index' );
		}
	}

	protected function getAll()
	{
		return AccountDirector::all();
	}

	protected function getSelection()
	{
		if ( $this->searchCheck() )
		{
			$this->search_term = $this->findSearchTerm();
			$this->search_term_clean = str_replace('%', '', $this->search_term);

			//Search on both first_name and last_name
			$items = AccountDirector::where( function ( $query )
			{
				$query->where( 'first_name', 'LIKE', $this->search_term )->orWhere( 'last_name', 'LIKE', $this->search_term );
			} )->rowsSortOrder( $this->rows_sort_order )->paginate( $this->rows_to_view );
		}
		else
		{
			$items = AccountDirector::rowsSortOrder( $this->rows_sort_order )->paginate( $this->rows_to_view );
		}

		return $items;
	}

	protected function getAccountDirector( $id )
	{
		$account_director = AccountDirector::find( $id );

		return $account_director;
	}

}