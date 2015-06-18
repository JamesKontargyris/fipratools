<?php

use Laracasts\Commander\CommanderTrait;
use Laracasts\Flash\Flash;
use Leadofficelist\Exceptions\ResourceNotFoundException;
use Leadofficelist\Forms\AddEditTypeCategory as AddEditTypeCategoryForm;
use Leadofficelist\Type_categories\Type_category;
use Leadofficelist\Types\Type;

class TypeCategoriesController extends \BaseController
{
    use CommanderTrait;

    protected $resource_key = 'type_categories';
    protected $resource_permission = 'manage_types';
    private $addEditTypeCategoryForm;

    function __construct( AddEditTypeCategoryForm $addEditTypeCategoryForm )
    {
        parent::__construct();

        $this->check_perm( 'manage_types' );

        $this->addEditTypeCategoryForm = $addEditTypeCategoryForm;
        View::share( 'page_title', 'Type Categories' );
        View::share( 'key', 'type_categories' );
    }

    /**
     * Display a listing of sector categories.
     * GET /type_categories
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

        $items      = Type_category::rowsSortOrder( $this->rows_sort_order )->paginate( $this->rows_to_view );
        $items->key = 'type_categories';

        return View::make( 'type_categories.index' )->with( compact( 'items' ) );
    }

    /**
     * Show the form for creating a new sector category.
     * GET /type_categories/create
     *
     * @return Response
     */
    public function create()
    {
        return View::make( 'type_categories.create' );
    }

    /**
     * Store a newly created sector category in storage.
     * POST /type_categories
     *
     * @return Response
     */
    public function store()
    {
        $input = Input::all();
        $this->addEditTypeCategoryForm->validate( $input );

        $this->execute( 'Leadofficelist\Type_categories\AddTypeCategoryCommand' );

        Flash::overlay( '"' . $input['name'] . '" added.', 'success' );

        return Redirect::route( 'type_categories.index' );
    }

    /**
     * Display the specified sector category.
     * GET /type_categories/{id}
     *
     * @param  int $id
     *
     * @throws ResourceNotFoundException
     * @return Response
     */
    public function show( $id )
    {
        if ( $type_category = $this->getTypeCategory( $id ) )
        {
            $items = Type::where( 'category_id', '=', $type_category->id )->get();

            return View::make( 'type_categories.show' )->with( compact( 'type_category', 'items' ) );
        } else
        {
            throw new ResourceNotFoundException( 'type_categories' );
        }
    }

    /**
     * Show the form for editing the specified sector category.
     * GET /type_categories/{id}/edit
     *
     * @param  int $id
     *
     * @throws ResourceNotFoundException
     * @return Response
     */
    public function edit( $id )
    {
        if ( $type_category = $this->getTypeCategory( $id ) )
        {
            return View::make( 'type_categories.edit' )->with( compact( 'type_category' ) );
        } else
        {
            throw new ResourceNotFoundException( 'type_category ' );
        }
    }

    /**
     * Update the specified sector category in storage.
     * PUT /type_categories/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function update( $id )
    {
        $input                                          = Input::all();
        $input['id']                                    = $id;
        $this->addEditTypeCategoryForm->rules['name'] = 'required|max:255|unique:type_categories,name,' . $id;
        $this->addEditTypeCategoryForm->validate( $input );

        $this->execute( 'Leadofficelist\Type_categories\EditTypeCategoryCommand', $input );

        Flash::overlay( 'Type category updated.', 'success' );

        return Redirect::route( 'type_categories.index' );
    }

    /**
     * Remove the specified sector category from storage.
     * DELETE /type_categories/{id}
     *
     * @param  int $id
     *
     * @throws ResourceNotFoundException
     * @return Response
     */
    public function destroy( $id )
    {
        if ( $type_category = $this->getTypeCategory( $id ) )
        {
            Type_category::destroy( $id );
            Flash::overlay( '"' . $type_category->name . '" has been deleted.', 'info' );

            return Redirect::route( 'type_categories.index' );
        } else
        {
            throw new ResourceNotFoundException( 'type_categories' );
        }
    }

    /**
     * Process a type category search.
     *
     * @return $this
     */
    public function search()
    {
        if ( $search_term = $this->findSearchTerm() )
        {
            $items = Type_category::where( 'name', 'LIKE', $search_term )->rowsSortOrder( $this->rows_sort_order )->paginate( $this->rows_to_view );

            if ( ! $this->checkForSearchResults( $items ) )
            {
                return Redirect::route( $this->resource_key . '.index' );
            }
            $items->search_term = str_replace( '%', '', $search_term );
            $items->key         = 'type_categories';

            return View::make( 'type_categories.index' )->with( compact( 'items' ) );
        } else
        {
            return View::make( 'type_categories.index' );
        }
    }

    protected function getAll()
    {
        return Type_category::all();
    }

    protected function getSelection()
    {
        if ( $this->searchCheck() )
        {
            $search_term = $this->findSearchTerm();
            $this->search_term_clean = str_replace('%', '', $search_term);

            //Search on both first_name and last_name
            $items = Type_category::where('name', '=', $search_term)->rowsSortOrder( $this->rows_sort_order )->paginate( $this->rows_to_view );
        }
        else
        {
            $items = Type_category::rowsSortOrder( $this->rows_sort_order )->paginate( $this->rows_to_view );
        }

        return $items;
    }

    protected function getTypeCategory( $id )
    {
        return Type_category::find( $id );
    }
}