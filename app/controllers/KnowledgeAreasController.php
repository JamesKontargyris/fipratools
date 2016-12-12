<?php

use Laracasts\Commander\CommanderTrait;
use Laracasts\Flash\Flash;
use Leadofficelist\Forms\AddEditKnowledgeArea as AddEditKnowledgeAreaForm;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

class KnowledgeAreasController extends \BaseController
{
	use CommanderTrait;

	protected $resource_key = 'knowledge_areas';
	protected $resource_permission = 'manage_knowledge';
	private $addEditKnowledgeAreaForm;

	function __construct( AddEditKnowledgeAreaForm $addEditKnowledgeAreaForm )
	{
		parent::__construct();

		$this->check_perm( 'manage_knowledge' );

		$this->addEditKnowledgeAreaForm = $addEditKnowledgeAreaForm;

		View::share( 'page_title', 'Knowledge Areas' );
		View::share( 'key', 'knowledge_areas' );
	}

	/**
	 * Display a listing of knowledge areas.
	 * GET /knowledge_areas
	 *
	 * @return Response
	 */
	public function index()
	{
		$this->destroyCurrentPageNumber(true);

		if($this->searchCheck()) return Redirect::to($this->resource_key . '/search');

		$items      = KnowledgeArea::rowsSortOrder( $this->rows_sort_order )->paginate( $this->rows_to_view );
		$items->key = 'knowledge_areas';

		return View::make( 'knowledge_areas.index' )->with( compact( 'items' ) );
	}

	/**
	 * Show the form for creating a new knowledge area.
	 * GET /knowledge_areas/create
	 *
	 * @return Response
	 */
	public function create()
	{
		$groups = $this->getKnowledgeAreaGroups();
		return View::make( 'knowledge_areas.create' )->with(compact('groups'));
	}

	/**
	 * Store a newly created knowledge area in storage.
	 * POST /knowledge_areas
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		$this->addEditKnowledgeAreaForm->validate( $input );

		$this->execute( 'Leadofficelist\Knowledge_areas\AddKnowledgeAreaCommand' );

		Flash::overlay( '"' . $input['name'] . '" added.', 'success' );

		return Redirect::route( 'knowledge_areas.index' );
	}

	/**
	 * Display the specified knowledge area.
	 * GET /knowledge_areas/{id}
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function show( $id )
	{
		if ( $sector = $this->getSector($id) )
		{
			$clients = $this->getActiveClientsByField('sector_id', $id);

			return View::make( 'sectors.show' )->with( compact( 'sector', 'clients' ) );
		} else
		{
			throw new ResourceNotFoundException('sectors');
		}
	}

	/**
	 * Show the form for editing the specified knowledge area.
	 * GET /knowledge_areas/{id}/edit
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function edit( $id )
	{
		if ( $area = $this->getKnowledgeArea($id) )
		{
			$groups = $this->getKnowledgeAreaGroups();
			return View::make( 'knowledge_areas.edit' )->with(compact('area', 'groups'));
		}
		else
		{
			throw new ResourceNotFoundException('knowledge_area');
		}
	}

	/**
	 * Update the specified knowledge area in storage.
	 * PUT /knowledge_areas/{id}
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function update( $id )
	{
		$input                                  = Input::all();
		$input['id']                            = $id;
		$this->addEditKnowledgeAreaForm->rules['name'] = 'required|max:255|unique:knowledge_areas,name,' . $id;
		$this->addEditKnowledgeAreaForm->validate( $input );

		$this->execute( 'Leadofficelist\Knowledge_areas\EditKnowledgeAreaCommand', $input );

		Flash::overlay( 'Knowledge area updated.', 'success' );

		return Redirect::route( 'knowledge_areas.index' );
	}

	/**
	 * Remove the specified knowledge area from storage.
	 * DELETE /knowledge_areas/{id}
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function destroy( $id )
	{
		if ( $area = $this->getKnowledgeArea( $id ) )
		{
			KnowledgeArea::destroy( $id );
			Flash::overlay( '"' . $area->name . '" has been deleted.', 'info' );

			return Redirect::route( 'knowledge_areas.index' );
		} else
		{
			throw new ResourceNotFoundException( 'knowledge_area' );
		}
	}

	/**
	 * Process a knowledge_area search.
	 *
	 * @return $this
	 */
	public function search()
	{
		if($search_term = $this->findSearchTerm())
		{
			$items              = KnowledgeArea::where( 'name', 'LIKE', $search_term )->rowsSortOrder( $this->rows_sort_order )->paginate( $this->rows_to_view );

			if( ! $this->checkForSearchResults($items)) return Redirect::route( $this->resource_key . '.index' );
			$items->search_term = str_replace('%', '', $search_term);
			$items->key         = 'knowledge_areas';

			return View::make( 'knowledge_areas.index' )->with( compact( 'items' ) );
		}
		else
		{
			return View::make( 'knowledge_areas.index' );
		}
	}

	protected function getAll()
	{
		return KnowledgeArea::all();
	}

	protected function getSelection()
	{
		if ( $this->searchCheck() )
		{
			$search_term = $this->findSearchTerm();
			$this->search_term_clean = str_replace('%', '', $search_term);

			$items = KnowledgeArea::where( 'name', 'LIKE', $search_term )->rowsSortOrder( $this->rows_sort_order )->paginate( $this->rows_to_view );
		}
		else
		{
			$items = KnowledgeArea::rowsSortOrder( $this->rows_sort_order )->paginate( $this->rows_to_view );
		}

		return $items;
	}

	protected function getKnowledgeArea($id)
	{
		return KnowledgeArea::find( $id );
	}

	protected function getKnowledgeAreaGroups()
	{
		$groups = ['' => 'Select...'];
		foreach(KnowledgeAreaGroup::orderBy('order')->get() as $group)
		{
			$groups[$group->id] = $group->name;
		}

		return $groups;
	}
}