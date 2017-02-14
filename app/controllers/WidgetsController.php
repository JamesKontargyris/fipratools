<?php

use Laracasts\Commander\CommanderTrait;
use Laracasts\Flash\Flash;
use Leadofficelist\Forms\AddEditWidget as AddEditWidgetForm;
use Leadofficelist\Widgets\Widget;

class WidgetsController extends \BaseController {

	use CommanderTrait;

	protected $resource_key = 'widgets';
	protected $resource_permission = 'manage_users';
	protected $addEditWidgetForm;

	function __construct( AddEditWidgetForm $addEditWidgetForm ) {
		parent::__construct();

		View::share( 'page_title', 'Widgets' );
		View::share( 'key', 'widgets' );
		$this->addEditWidgetForm = $addEditWidgetForm;
	}

	/**
	 * Display a listing of the resource.
	 * GET /widgets
	 *
	 * @return Response
	 */
	public function index()
	{
		$this->destroyCurrentPageNumber(true);
		if($this->searchCheck()) return Redirect::to($this->resource_key . '/search');

		$items = Widget::rowsSortOrder( $this->rows_sort_order )->paginate( $this->rows_to_view );
		$items->key = 'widgets';

		return View::make('widgets.index')->with(compact('items'));
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /widgets/create
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make( 'widgets.create' );
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /widgets
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		$this->addEditWidgetForm->validate( $input );

		$this->execute( 'Leadofficelist\Widgets\AddWidgetCommand' );

		Flash::overlay( '"' . $input['name'] . '" added.', 'success' );

		return Redirect::route( 'widgets.index' );
	}

	/**
	 * Display the specified resource.
	 * GET /widgets/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /widgets/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		if ( $widget = $this->getWidget($id) )
		{
			return View::make( 'widgets.edit' )->with(compact('widget'));
		}
		else
		{
			throw new ResourceNotFoundException('widgets');
		}
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /widgets/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$input                                  = Input::all();
		$input['id']                            = $id;
		$this->addEditWidgetForm->rules['name'] = 'required|max:255|unique:widgets,name,' . $id;
		$this->addEditWidgetForm->rules['slug'] = 'required|max:255|unique:widgets,slug,' . $id;
		$this->addEditWidgetForm->validate( $input );

		$this->execute( 'Leadofficelist\Widgets\EditWidgetCommand', $input );

		Flash::overlay( 'Widget updated.', 'success' );

		return Redirect::route( 'widgets.index' );
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /widgets/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		if ( $widget = $this->getWidget( $id ) )
		{
			Widget::destroy( $id );
			Flash::overlay( '"' . $widget->name . '" has been deleted.', 'info' );

			return Redirect::route( 'widgets.index' );
		} else
		{
			throw new ResourceNotFoundException( 'widgets' );
		}
	}

	/**
	 * Process a location search.
	 *
	 * @return $this
	 */
	public function search()
	{
		if($search_term = $this->findSearchTerm())
		{
			$items              = Widget::where( 'name', 'LIKE', $search_term )->orWhere('slug', 'LIKE', $search_term)->rowsSortOrder( $this->rows_sort_order )->paginate( $this->rows_to_view );

			if( ! $this->checkForSearchResults($items)) return Redirect::route( $this->resource_key . '.index' );
			$items->search_term = str_replace('%', '', $search_term);
			$items->key         = 'widgets';

			return View::make( 'widgets.index' )->with( compact( 'items' ) );
		}
		else
		{
			return View::make( 'widgets.index' );
		}
	}

	protected function getAll()
	{
		return Widget::all();
	}

	protected function getSelection()
	{
		if ( $this->searchCheck() )
		{
			$search_term = $this->findSearchTerm();
			$this->search_term_clean = str_replace('%', '', $search_term);

			$items = Widget::where( 'name', 'LIKE', $search_term )->orWhere('slug', 'LIKE', $search_term)->rowsSortOrder( $this->rows_sort_order )->paginate( $this->rows_to_view );
		}
		else
		{
			$items = Widget::rowsSortOrder( $this->rows_sort_order )->paginate( $this->rows_to_view );
		}

		return $items;
	}

	protected function getWidget($id)
	{
		return Widget::find( $id );
	}

}