<?php

use Leadofficelist\Units\Unit;

class ReportsController extends \BaseController {

	protected $resource_key = 'reports';
	protected $colours = ['#00257f', '#14b1cc', '#8dcc29', '#6f5ce5', '#007770', '#14990f', '#ccd3e5', '#5F697F','#00257f', '#14b1cc', '#8dcc29', '#6f5ce5', '#007770', '#14990f', '#ccd3e5', '#5F697F','#00257f', '#14b1cc', '#8dcc29', '#6f5ce5', '#007770', '#14990f', '#ccd3e5', '#5F697F','#00257f', '#14b1cc', '#8dcc29', '#6f5ce5', '#007770', '#14990f', '#ccd3e5', '#5F697F','#00257f', '#14b1cc', '#8dcc29', '#6f5ce5', '#007770', '#14990f', '#ccd3e5', '#5F697F','#00257f', '#14b1cc', '#8dcc29', '#6f5ce5', '#007770', '#14990f', '#ccd3e5', '#5F697F','#00257f', '#14b1cc', '#8dcc29', '#6f5ce5', '#007770', '#14990f', '#ccd3e5', '#5F697F','#00257f', '#14b1cc', '#8dcc29', '#6f5ce5', '#007770', '#14990f', '#ccd3e5', '#5F697F','#00257f', '#14b1cc', '#8dcc29', '#6f5ce5', '#007770', '#14990f', '#ccd3e5', '#5F697F','#00257f', '#14b1cc', '#8dcc29', '#6f5ce5', '#007770', '#14990f', '#ccd3e5', '#5F697F','#00257f', '#14b1cc', '#8dcc29', '#6f5ce5', '#007770', '#14990f', '#ccd3e5', '#5F697F','#00257f', '#14b1cc', '#8dcc29', '#6f5ce5', '#007770', '#14990f', '#ccd3e5', '#5F697F','#00257f', '#14b1cc', '#8dcc29', '#6f5ce5', '#007770', '#14990f', '#ccd3e5', '#5F697F','#00257f', '#14b1cc', '#8dcc29', '#6f5ce5', '#007770', '#14990f', '#ccd3e5', '#5F697F',];
	/**
	 * Display a listing of the resource.
	 * GET /reports
	 *
	 * @return Response
	 */
	public function index()
	{
		$units = Unit::all();
		$clients = [];
		$total_clients = 0;
		$count = 0;
		foreach($units as $unit)
		{
			$clients[] = ['unit_name' => $unit->name, 'client_count' => $unit->clients()->where('status', '=', 1)->count()];
			$count++;
			$total_clients += $unit->clients()->count();
		}

		uasort($clients, [$this, 'compare']);
		$count = 0;
		foreach($clients as &$client)
		{
			$client['id'] = $count;
			$client['percentage'] = number_format(($client['client_count'] / $total_clients) * 100, 2, '.', ',') ;
			$count++;
		}
		return View::make('reports.client_count_by_unit')->with(['colours' => $this->colours, 'clients' => $clients, 'total_clients' => number_format($total_clients, 0, '.', ',')]);
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /reports/create
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /reports
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 * GET /reports/{id}
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
	 * GET /reports/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /reports/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /reports/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}


	/**
	 * Used to compare values in an array uasort function
	 *
	 * @param $a
	 * @param $b
	 *
	 * @return int
	 */
	protected function compare($a, $b)
	{
		if($a['client_count'] == $b['client_count'])
		{
			return 0;
		}

		return ($a['client_count'] > $b['client_count']) ? -1 : 1;
	}

}