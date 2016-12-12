<?php

use Laracasts\Commander\CommanderTrait;
use Leadofficelist\Cases\CaseStudy;
use Leadofficelist\Eventlogs\EventLog;
use Leadofficelist\Exceptions\CannotEditException;
use Leadofficelist\Exceptions\ResourceNotFoundException;
use Leadofficelist\Forms\AddEditCase as AddEditCaseForm;
use Leadofficelist\Units\Unit;

class CasesController extends \BaseController {

	use CommanderTrait;

	protected $resource_key = 'cases';
	protected $resource_permission = 'manage_cases';
	private $addEditCaseForm;
	private $case;

	function __construct( AddEditCaseForm $addEditCaseForm, CaseStudy $case ) {
		parent::__construct();
		View::share( 'page_title', 'Case Studies' );
		View::share( 'key', 'cases' );

		$this->addEditCaseForm = $addEditCaseForm;
		$this->case            = $case;
	}

	/**
	 * Display a listing of the resource.
	 * GET /cases
	 *
	 * @return Response
	 */
	public function index() {
		$this->check_perm( 'manage_cases' );

		$this->destroyCurrentPageNumber( true );

		if ( $this->searchCheck() ) {
			return Redirect::to( $this->resource_key . '/search' );
		}

		if ( $this->user->hasRole( 'Administrator' ) ) {
			$items = CaseStudy::where('status', '=', 1)->rowsSortOrder( $this->rows_sort_order )->paginate( $this->rows_to_view );
			$items_pending = CaseStudy::where('status', '=', 0)->orderBy('id', 'DESC')->get();
		} else {
			$items = CaseStudy::where('status', '=', 1)->where( 'unit_id', '=', $this->user->unit_id )->rowsSortOrder( $this->rows_sort_order )->paginate( $this->rows_to_view );

			$items_pending = CaseStudy::where('status', '=', 0)->where( 'unit_id', '=', $this->user->unit_id )->orderBy('id', 'DESC')->get();
		}

		$items->key = 'cases';

		return View::make( 'cases.index' )->with( compact( 'items', 'items_pending' ) );
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /cases/create
	 *
	 * @return Response
	 */
	public function create() {
		$this->check_perm( 'manage_cases' );

		$this->getFormData();

		return View::make( 'cases.create' )->with( [
			'account_directors' => $this->account_directors,
			'units'             => $this->units,
			'sectors'           => $this->sectors,
			'locations'         => $this->locations,
			'products'          => $this->products
		] );
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /cases
	 *
	 * @return Response
	 */
	public function store() {
		$this->check_perm( 'manage_cases' );

		$input = Input::all();
		$this->addEditCaseForm->validate( $input );

		$this->execute( 'Leadofficelist\Cases\AddCaseCommand', $input );

		Flash::overlay( '"' . $input['name'] . '" added.', 'success' );
		EventLog::add( 'Case study created: ' . $input['name'], $this->user->getFullName(), Unit::find( $input['unit_id'] )->name, 'add' );

		return Redirect::route( 'cases.index' );
	}

	/**
	 * Display the specified resource.
	 * GET /cases/{id}
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function show( $id ) {
		$this->check_perm( 'view_list' );

		if ( $case = CaseStudy::find( $id ) ) {

			return View::make( 'cases.show' )->with( compact( 'case' ) );
		} else {
			throw new ResourceNotFoundException( 'cases' );
		}
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /cases/{id}/edit
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function edit( $id ) {
		$this->getFormData();

		if ( $case = $this->getCase( $id ) ) {
			return View::make( 'cases.edit' )->with( [
				'account_directors' => $this->account_directors,
				'units'             => $this->units,
				'sectors'           => $this->sectors,
				'locations'         => $this->locations,
				'products'          => $this->products,
				'case'              => $case
			] );;
		} else {
			throw new ResourceNotFoundException( 'cases' );
		}
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /cases/{id}
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function update( $id ) {
		$input       = Input::all();
		$input['id'] = $id;
		$this->addEditCaseForm->validate( $input );

		$this->execute( 'Leadofficelist\Cases\EditCaseCommand', $input );

		Flash::overlay( 'Case study updated.', 'success' );
		EventLog::add( 'Case study edited: ' . $input['name'], $this->user->getFullName(), Unit::find( $input['unit_id'] )->name, 'edit' );

		return Redirect::route( 'cases.index' );
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /cases/{id}
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function destroy( $id ) {
		if ( $case = $this->getCase( $id ) ) {
			Flash::overlay( '"' . $case->name . '" has been deleted.', 'info' );
			EventLog::add( 'Case study deleted: ' . CaseStudy::find($id)->name, $this->user->getFullName(), $this->user->unit()->first()->name, 'delete' );
			CaseStudy::destroy( $id );

			return Redirect::route( 'cases.index' );
		} else {
			throw new ResourceNotFoundException( 'cases' );
		}
	}

	public function approve() {
		$case_id = Input::get( 'case_id' );

		if ( $case_id ) {
			if ( CaseStudy::change_status( $case_id, 1 ) ) {
				Flash::overlay( 'Case study approved.', 'success' );
				return Redirect::route('cases.index');
			} else {
				throw new CannotEditException;
			}
		}
		else {
			throw new ResourceNotFoundException;
		}
	}

	public function disapprove() {
		$case_id = Input::get( 'case_id' );

		if ( $case_id ) {
			if ( CaseStudy::change_status( $case_id, 0 ) ) {
				Flash::overlay( 'Case study disapproved.', 'success' );
				return Redirect::route('cases.index');
			} else {
				throw new CannotEditException;
			}
		}
		else {
			throw new ResourceNotFoundException;
		}
	}


	/**
	 * Process a case study search.
	 *
	 * @return $this
	 */
	public function search() {
		if ( $search_term = $this->findSearchTerm() ) {
			$items = CaseStudy::where('status', '=', 1)->where( 'name', 'LIKE', $search_term )->rowsSortOrder( $this->rows_sort_order )->paginate( $this->rows_to_view );
			$items_pending = CaseStudy::where('status', '=', 0)->where( 'name', 'LIKE', $search_term )->rowsSortOrder( $this->rows_sort_order )->paginate( $this->rows_to_view );

			if ( ! $this->checkForSearchResults( $items ) && ! $this->checkForSearchResults( $items_pending ) ) {
				return Redirect::route( $this->resource_key . '.index' );
			}
			$items->search_term = str_replace( '%', '', $search_term );
			$items->key         = 'cases';

			return View::make( 'cases.index' )->with( compact( 'items', 'items_pending' ) );
		} else {
			return View::make( 'cases.index' );
		}
	}

	protected function getAll() {
		return CaseStudy::all();
	}

	protected function getSelection() {
		if ( $this->searchCheck() ) {
			$search_term             = $this->findSearchTerm();
			$this->search_term_clean = str_replace( '%', '', $search_term );

			$items = CaseStudy::where( 'name', 'LIKE', $search_term )->rowsSortOrder( $this->rows_sort_order )->paginate( $this->rows_to_view );
		} else {
			$items = CaseStudy::rowsSortOrder( $this->rows_sort_order )->paginate( $this->rows_to_view );
		}

		return $items;
	}

	protected function getCase( $id ) {
		return CaseStudy::find( $id );
	}

}