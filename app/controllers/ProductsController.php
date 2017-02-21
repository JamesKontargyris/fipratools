<?php

use Laracasts\Commander\CommanderTrait;
use Laracasts\Flash\Flash;
use Leadofficelist\Forms\AddEditProduct as AddEditProductForm;
use Leadofficelist\Products\Product;
use Leadofficelist\Exceptions\ResourceNotFoundException;

class ProductsController extends \BaseController {
	use CommanderTrait;

	public $section = 'case';
	protected $resource_key = 'products';
	protected $resource_permission = 'manage_products';
	private $addEditProductForm;

	function __construct( AddEditProductForm $addEditProductForm ) {
		parent::__construct();

		$this->check_perm( 'manage_products' );

		$this->addEditProductForm = $addEditProductForm;

		View::share( 'page_title', 'Products' );
		View::share( 'key', 'products' );
	}
	/**
	 * Display a listing of the resource.
	 * GET /products
	 *
	 * @return Response
	 */
	public function index()
	{
		$this->destroyCurrentPageNumber(true);

		if($this->searchCheck()) return Redirect::to($this->resource_key . '/search');

		$items      = Product::rowsSortOrder( $this->rows_sort_order )->paginate( $this->rows_to_view );
		$items->key = 'products';

		return View::make( 'products.index' )->with( compact( 'items' ) );
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /products/create
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make( 'products.create' );
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /products
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		$this->addEditProductForm->validate( $input );

		$this->execute( 'Leadofficelist\Products\AddProductCommand' );

		Flash::overlay( '"' . $input['name'] . '" added.', 'success' );

		return Redirect::route( 'products.index' );
	}

	/**
	 * Display the specified resource.
	 * GET /products/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		// Don't need to show products
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /products/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		if ( $product = $this->getProduct($id) )
		{
			return View::make( 'products.edit' )->with(compact('product'));
		}
		else
		{
			throw new ResourceNotFoundException('products');
		}
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /products/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$input                                  = Input::all();
		$input['id']                            = $id;
		$this->addEditProductForm->rules['name'] = 'required|max:255|unique:products,name,' . $id;
		$this->addEditProductForm->validate( $input );

		$this->execute( 'Leadofficelist\Products\EditProductCommand', $input );

		Flash::overlay( 'Product updated.', 'success' );

		return Redirect::route( 'products.index' );
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /products/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		if ( $product = $this->getProduct( $id ) )
		{
			Product::destroy( $id );
			Flash::overlay( '"' . $product->name . '" has been deleted.', 'info' );

			return Redirect::route( 'products.index' );
		} else
		{
			throw new ResourceNotFoundException( 'products' );
		}
	}

	/**
	 * Process a product search.
	 *
	 * @return $this
	 */
	public function search()
	{
		if($search_term = $this->findSearchTerm())
		{
			$items              = Product::where( 'name', 'LIKE', $search_term )->rowsSortOrder( $this->rows_sort_order )->paginate( $this->rows_to_view );

			if( ! $this->checkForSearchResults($items)) return Redirect::route( $this->resource_key . '.index' );
			$items->search_term = str_replace('%', '', $search_term);
			$items->key         = 'products';

			return View::make( 'products.index' )->with( compact( 'items' ) );
		}
		else
		{
			return View::make( 'products.index' );
		}
	}

	protected function getAll()
	{
		return Product::all();
	}

	protected function getSelection()
	{
		if ( $this->searchCheck() )
		{
			$search_term = $this->findSearchTerm();
			$this->search_term_clean = str_replace('%', '', $search_term);

			$items = Product::where( 'name', 'LIKE', $search_term )->rowsSortOrder( $this->rows_sort_order )->paginate( $this->rows_to_view );
		}
		else
		{
			$items = Product::rowsSortOrder( $this->rows_sort_order )->paginate( $this->rows_to_view );
		}

		return $items;
	}

	protected function getProduct($id)
	{
		return Product::find( $id );
	}

}