<?php

use Laracasts\Commander\CommanderTrait;
use Laracasts\Flash\Flash;
use Leadofficelist\Forms\AddEditKnowledgeAreaGroup as AddEditKnowledgeAreaGroupForm;
use Leadofficelist\Exceptions\ResourceNotFoundException;
use Leadofficelist\Knowledge_area_groups\KnowledgeAreaGroup;

class KnowledgeAreaGroupsController extends \BaseController
{
	use CommanderTrait;

	public $section = 'survey';
	protected $resource_key = 'knowledge_area_groups';
	protected $resource_permission = 'manage_knowledge';
	private $addEditKnowledgeAreaGroupForm;

	function __construct( AddEditKnowledgeAreaGroupForm $addEditKnowledgeAreaGroupForm )
	{
		parent::__construct();

		$this->check_perm( 'manage_knowledge' );

		$this->addEditKnowledgeAreaGroupForm = $addEditKnowledgeAreaGroupForm;

		View::share( 'page_title', 'Knowledge Area Groups' );
		View::share( 'key', 'knowledge_area_groups' );
		$this->addEditKnowledgeAreaGroupForm = $addEditKnowledgeAreaGroupForm;
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

		$items      = KnowledgeAreaGroup::orderBy('order', 'ASC')->paginate( $this->rows_to_view );
		$items->key = 'knowledge_area_groups';

		return View::make( 'knowledge_area_groups.index' )->with( compact( 'items' ) );
	}

	/**
	 * Show the form for creating a new sector.
	 * GET /sectors/create
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make( 'knowledge_area_groups.create' );
	}

	/**
	 * Store a newly created sector in storage.
	 * POST /sectors
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		$this->addEditKnowledgeAreaGroupForm->validate( $input );

		$this->execute( 'Leadofficelist\Knowledge_area_groups\AddKnowledgeAreaGroupCommand' );

		Flash::overlay( '"' . $input['name'] . '" added.', 'success' );

		return Redirect::route( 'knowledge_area_groups.index' );
	}

	/**
	 * Display the specified sector.
	 * GET /sectors/{id}
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
	 * Show the form for editing the specified sector.
	 * GET /sectors/{id}/edit
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function edit( $id )
	{
		if ( $group = $this->getGroup($id) )
		{
			return View::make( 'knowledge_area_groups.edit' )->with(compact('group'));
		}
		else
		{
			throw new ResourceNotFoundException('knowledge_area_groups');
		}
	}

	/**
	 * Update the specified sector in storage.
	 * PUT /sectors/{id}
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function update( $id )
	{
		$input                                  = Input::all();
		$input['id']                            = $id;
		$this->addEditKnowledgeAreaGroupForm->rules['name'] = 'required|max:255|unique:knowledge_area_groups,name,' . $id;
		$this->addEditKnowledgeAreaGroupForm->validate( $input );

		$this->execute( 'Leadofficelist\Knowledge_area_groups\EditKnowledgeAreaGroupCommand', $input );

		Flash::overlay( 'Group updated.', 'success' );

		return Redirect::route( 'knowledge_area_groups.index' );
	}

	/**
	 * Remove the specified sector from storage.
	 * DELETE /sectors/{id}
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function destroy( $id )
	{
		if ( $group = $this->getGroup( $id ) )
		{
			KnowledgeAreaGroup::destroy( $id );
			Flash::overlay( '"' . $group->name . '" has been deleted.', 'info' );

			return Redirect::route( 'knowledge_area_groups.index' );
		} else
		{
			throw new ResourceNotFoundException( 'knowledge_area_groups' );
		}
	}

	/**
	 * Process a sector search.
	 *
	 * @return $this
	 */
	public function search()
	{
		if($search_term = $this->findSearchTerm())
		{
			$items              = KnowledgeAreaGroup::where( 'name', 'LIKE', $search_term )->orderBy('order', 'ASC')->paginate( $this->rows_to_view );

			if( ! $this->checkForSearchResults($items)) return Redirect::route( $this->resource_key . '.index' );
			$items->search_term = str_replace('%', '', $search_term);
			$items->key         = 'knowledge_area_groups';

			return View::make( 'knowledge_area_groups.index' )->with( compact( 'items' ) );
		}
		else
		{
			return View::make( 'knowledge_area_groups.index' );
		}
	}

	protected function getAll()
	{
		return KnowledgeAreaGroup::all();
	}

	protected function getSelection()
	{
		if ( $this->searchCheck() )
		{
			$search_term = $this->findSearchTerm();
			$this->search_term_clean = str_replace('%', '', $search_term);

			$items = KnowledgeAreaGroup::where( 'name', 'LIKE', $search_term )->orderBy('order', 'ASC')->paginate( $this->rows_to_view );
		}
		else
		{
			$items = KnowledgeAreaGroup::orderBy('order', 'ASC')->paginate( $this->rows_to_view );
		}

		return $items;
	}

	protected function getGroup($id)
	{
		return KnowledgeAreaGroup::find( $id );
	}
}