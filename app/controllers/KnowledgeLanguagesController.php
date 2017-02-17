<?php

use Laracasts\Commander\CommanderTrait;
use Laracasts\Flash\Flash;
use Leadofficelist\Forms\AddEditKnowledgeLanguage as AddEditKnowledgeLanguageForm;
use Leadofficelist\Exceptions\ResourceNotFoundException;

class KnowledgeLanguagesController extends \BaseController
{
	use CommanderTrait;

	public $section = 'survey';
	protected $resource_key = 'knowledge_languages';
	protected $resource_permission = 'manage_knowledge';
	private $addEditKnowledgeLanguageForm;

	function __construct( AddEditKnowledgeLanguageForm $addEditKnowledgeLanguageForm )
	{
		parent::__construct();

		$this->check_perm( 'manage_knowledge' );

		$this->addEditKnowledgeLanguageForm = $addEditKnowledgeLanguageForm;

		View::share( 'page_title', 'Knowledge Languages' );
		View::share( 'key', 'knowledge_languages' );
	}

	/**
	 * Display a listing of knowledge languages.
	 * GET /knowledge_languages
	 *
	 * @return Response
	 */
	public function index()
	{
		$this->destroyCurrentPageNumber(true);

		if($this->searchCheck()) return Redirect::to($this->resource_key . '/search');

		$items      = KnowledgeLanguage::rowsSortOrder( $this->rows_sort_order )->paginate( $this->rows_to_view );
		$items->key = 'knowledge_languages';

		return View::make( 'knowledge_languages.index' )->with( compact( 'items' ) );
	}

	/**
	 * Show the form for creating a new knowledge language.
	 * GET /knowledge_languages/create
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make( 'knowledge_languages.create' );
	}

	/**
	 * Store a newly created knowledge language in storage.
	 * POST /knowledge_languages
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		$this->addEditKnowledgeLanguageForm->validate( $input );

		$this->execute( 'Leadofficelist\Knowledge_languages\AddKnowledgeLanguageCommand' );

		Flash::overlay( '"' . $input['name'] . '" added.', 'success' );

		return Redirect::route( 'knowledge_languages.index' );
	}

	/**
	 * Display the specified knowledge language.
	 * GET /knowledge_languages/{id}
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
	 * Show the form for editing the specified knowledge language.
	 * GET /knowledge_languages/{id}/edit
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function edit( $id )
	{
		if ( $language = $this->getKnowledgeLanguage($id) )
		{
			return View::make( 'knowledge_languages.edit' )->with(compact('language'));
		}
		else
		{
			throw new ResourceNotFoundException('knowledge_language');
		}
	}

	/**
	 * Update the specified knowledge language in storage.
	 * PUT /knowledge_languages/{id}
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function update( $id )
	{
		$input                                  = Input::all();
		$input['id']                            = $id;
		$this->addEditKnowledgeLanguageForm->rules['name'] = 'required|max:255|unique:knowledge_languages,name,' . $id;
		$this->addEditKnowledgeLanguageForm->validate( $input );

		$this->execute( 'Leadofficelist\Knowledge_languages\EditKnowledgeLanguageCommand', $input );

		Flash::overlay( 'Knowledge language updated.', 'success' );

		return Redirect::route( 'knowledge_languages.index' );
	}

	/**
	 * Remove the specified knowledge language from storage.
	 * DELETE /knowledge_languages/{id}
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function destroy( $id )
	{
		if ( $language = $this->getKnowledgeLanguage( $id ) )
		{
			KnowledgeLanguage::destroy( $id );
			Flash::overlay( '"' . $language->name . '" has been deleted.', 'info' );

			return Redirect::route( 'knowledge_languages.index' );
		} else
		{
			throw new ResourceNotFoundException( 'knowledge_language' );
		}
	}

	/**
	 * Process a knowledge_language search.
	 *
	 * @return $this
	 */
	public function search()
	{
		if($search_term = $this->findSearchTerm())
		{
			$items              = KnowledgeLanguage::where( 'name', 'LIKE', $search_term )->rowsSortOrder( $this->rows_sort_order )->paginate( $this->rows_to_view );

			if( ! $this->checkForSearchResults($items)) return Redirect::route( $this->resource_key . '.index' );
			$items->search_term = str_replace('%', '', $search_term);
			$items->key         = 'knowledge_languages';

			return View::make( 'knowledge_languages.index' )->with( compact( 'items' ) );
		}
		else
		{
			return View::make( 'knowledge_languages.index' );
		}
	}

	protected function getAll()
	{
		return KnowledgeLanguage::orderBy('name', 'ASC')->get();
	}

	protected function getSelection()
	{
		if ( $this->searchCheck() )
		{
			$search_term = $this->findSearchTerm();
			$this->search_term_clean = str_replace('%', '', $search_term);

			$items = KnowledgeLanguage::where( 'name', 'LIKE', $search_term )->rowsSortOrder( $this->rows_sort_order )->paginate( $this->rows_to_view );
		}
		else
		{
			$items = KnowledgeLanguage::rowsSortOrder( $this->rows_sort_order )->paginate( $this->rows_to_view );
		}

		return $items;
	}

	protected function getKnowledgeLanguage($id)
	{
		return KnowledgeLanguage::find( $id );
	}

}