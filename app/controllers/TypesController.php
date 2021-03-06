<?php


use Laracasts\Commander\CommanderTrait;
use Laracasts\Flash\Flash;
use Leadofficelist\Exceptions\ResourceNotFoundException;
use Leadofficelist\Forms\AddEditType as AddEditTypeForm;
use Leadofficelist\Type_categories\Type_category;
use Leadofficelist\Types\Type;

class TypesController extends \BaseController
{
	use CommanderTrait;

	public $section = 'list';
	protected $resource_key = 'types';
	protected $resource_permission = 'manage_types';
	private $addEditTypeForm;

	function __construct( AddEditTypeForm $addEditTypeForm )
	{
		parent::__construct();

		$this->check_perm( 'manage_types' );
		$this->addEditTypeForm = $addEditTypeForm;

		View::share( 'page_title', 'Types' );
		View::share( 'key', 'types' );
	}

	/**
	 * Display a listing of the type.
	 * GET /types
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

		$items      = Type::rowsSortOrder( $this->rows_sort_order )->paginate( $this->rows_to_view );
		$items->key = 'types';

		return View::make( 'types.index' )->with( compact( 'items' ) );
	}

	/**
	 * Show the form for creating a new type.
	 * GET /types/create
	 *
	 * @return Response
	 */
	public function create()
	{
        $type_categories = $this->getTypeCategories();
		return View::make( 'types.create' )->with(compact('type_categories'));
	}

	/**
	 * Store a newly created type in storage.
	 * POST /types
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		$this->addEditTypeForm->validate( $input );

		$this->execute( 'Leadofficelist\Types\AddTypeCommand' );

		Flash::overlay( '"' . $input['name'] . '" added.', 'success' );

		return Redirect::route( 'types.index' );
	}

	/**
	 * Display the specified type.
	 * GET /types/{id}
	 *
	 * @param  int $id
	 *
	 * @throws ResourceNotFoundException
	 * @return Response
	 */
	public function show( $id )
	{
		if ( $type = $this->getType( $id ) )
		{
			$clients = $this->getActiveClientsByField( 'type_id', $id );

			return View::make( 'types.show' )->with( compact( 'type', 'clients' ) );
		} else
		{
			throw new ResourceNotFoundException( 'types' );
		}
	}

	/**
	 * Show the form for editing the specified type.
	 * GET /types/{id}/edit
	 *
	 * @param  int $id
	 *
	 * @throws ResourceNotFoundException
	 * @return Response
	 */
	public function edit( $id )
	{
		if ( $type = $this->getType( $id ) )
		{
            $type_categories = $this->getTypeCategories();
			return View::make( 'types.edit' )->with( compact( 'type', 'type_categories' ) );
		} else
		{
			throw new ResourceNotFoundException( 'types' );
		}
	}

	/**
	 * Update the specified type in storage.
	 * PUT /types/{id}
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function update( $id )
	{
		$input                                = Input::all();
		$input['id']                          = $id;
		$this->addEditTypeForm->rules['name'] = 'required|max:255|unique:types,name,' . $id;
		$this->addEditTypeForm->rules['short_name'] = 'required|max:255|unique:types,short_name,' . $id;
		$this->addEditTypeForm->validate( $input );

		$this->execute( 'Leadofficelist\Types\EditTypeCommand', $input );

		Flash::overlay( '"' . $input['name'] . '" updated.', 'success' );

		return Redirect::route( 'types.index' );
	}

	/**
	 * Remove the specified type from storage.
	 * DELETE /types/{id}
	 *
	 * @param  int $id
	 *
	 * @throws ResourceNotFoundException
	 * @return Response
	 */
	public function destroy( $id )
	{
		if ( $type = $this->getType( $id ) )
		{
			Type::destroy( $id );
			Flash::overlay( '"' . $type->name . '" deleted.', 'info' );

			return Redirect::route( 'types.index' );
		} else
		{
			throw new ResourceNotFoundException( 'types' );
		}
	}

	/**
	 * Process a type search.
	 *
	 * @return $this
	 */
	public function search()
	{
		if ( $search_term = $this->findSearchTerm() )
		{
			$items = Type::where( 'name', 'LIKE', $search_term )->rowsSortOrder( $this->rows_sort_order )->paginate( $this->rows_to_view );

			if ( ! $this->checkForSearchResults( $items ) )
			{
				return Redirect::route( $this->resource_key . '.index' );
			}
			$items->search_term = str_replace( '%', '', $search_term );
			$items->key         = 'types';

			return View::make( 'types.index' )->with( compact( 'items' ) );
		} else
		{
			return View::make( 'types.index' );
		}
	}

	protected function getAll()
	{
		return Type::all();
	}

	protected function getSelection()
	{
		if ( $this->searchCheck() )
		{
			$search_term = $this->findSearchTerm();
			$this->search_term_clean = str_replace('%', '', $search_term);

			$items = Type::where( 'name', 'LIKE', $search_term )->rowsSortOrder( $this->rows_sort_order )->paginate($this->rows_to_view);
		}
		else
		{
			$items = Type::rowsSortOrder( $this->rows_sort_order )->paginate( $this->rows_to_view );
		}

		return $items;
	}

	protected function getType( $id )
	{
		return Type::find( $id );
	}

    protected function getTypeCategories()
    {
        $type_categories = [0 => 'None'];
        foreach(Type_category::orderBy('name')->get() as $type_category)
        {
            $type_categories[$type_category->id] = $type_category->name;
        }

        return $type_categories;
    }
}