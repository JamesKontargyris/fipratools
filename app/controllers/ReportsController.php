<?php

use Leadofficelist\Network_types\Network_type;
use Leadofficelist\Sector_categories\Sector_category;
use Leadofficelist\Sectors\Sector;
use Leadofficelist\Services\Service;
use Leadofficelist\Type_categories\Type_category;
use Leadofficelist\Types\Type;
use Leadofficelist\Unit_groups\Unit_group;
use Leadofficelist\Units\Unit;

class ReportsController extends \BaseController {

	public $section = 'list';
	protected $resource_key = 'reports';
	protected $resource_permision = 'view_list';
	protected $colours = [
		'#00257f', '#14b1cc', '#8dcc29', '#6f5ce5', '#007770', '#14990f', '#5F697F', '#cc0a12', '#cc00b0', '#cc7300', '#e5c75c',
		'#3355cc', '#c6e694', '#a0e9f6', '#b7aef2', '#80bbb8', '#8acc87', '#afb4bf', '#e68589', '#e680d8', '#e6b980', '#f2e3ae',
		'#99aacc', '#385110', '#1a545e', '#2c245b', '#002f2c', '#083d06', '#262a32', '#510407', '#510046', '#512e00', '#5b4f24',
		'#00257f', '#14b1cc', '#8dcc29', '#6f5ce5', '#007770', '#14990f', '#5F697F', '#cc0a12', '#cc00b0', '#cc7300', '#e5c75c',
		'#3355cc', '#c6e694', '#a0e9f6', '#b7aef2', '#80bbb8', '#8acc87', '#afb4bf', '#e68589', '#e680d8', '#e6b980', '#f2e3ae',
		'#99aacc', '#385110', '#1a545e', '#2c245b', '#002f2c', '#083d06', '#262a32', '#510407', '#510046', '#512e00', '#5b4f24',
		'#00257f', '#14b1cc', '#8dcc29', '#6f5ce5', '#007770', '#14990f', '#5F697F', '#cc0a12', '#cc00b0', '#cc7300', '#e5c75c',
		'#3355cc', '#c6e694', '#a0e9f6', '#b7aef2', '#80bbb8', '#8acc87', '#afb4bf', '#e68589', '#e680d8', '#e6b980', '#f2e3ae',
		'#99aacc', '#385110', '#1a545e', '#2c245b', '#002f2c', '#083d06', '#262a32', '#510407', '#510046', '#512e00', '#5b4f24',
	];

	/**
	 * Display a listing of the resource.
	 * GET /reports
	 *
	 * @return Response
	 */
	public function getIndex()
	{
		return Redirect::to('reports/bysector');
	}

	public function getByunit()
	{
		$data = $this->getClientsByUnit();

		return View::make('reports.client_count_by_unit')->with(['report_type' => 'unit', 'colours' => $this->colours, 'clients' => $data['clients'], 'total_clients' => number_format($data['total_clients'], 0, '.', ',')]);
	}

	public function getByexpertise()
	{
		$data = $this->getClientsByExpertise();

		return View::make('reports.client_count_by_expertise_area')->with(['report_type' => 'expertise', 'colours' => $this->colours, 'clients' => $data['clients'], 'total_clients' => number_format($data['total_clients'], 0, '.', ',')]);
	}

	public function getBysector()
	{
		$data = $this->getClientsBySector();

		return View::make('reports.client_count_by_sector')->with(['report_type' => 'sector', 'colours' => $this->colours, 'clients' => $data['clients'], 'total_clients' => number_format($data['total_clients'], 0, '.', ',')]);
	}

	public function getBytype()
	{
		$data = $this->getClientsByType();

		return View::make('reports.client_count_by_type')->with(['report_type' => 'type', 'colours' => $this->colours, 'clients' => $data['clients'], 'total_clients' => number_format($data['total_clients'], 0, '.', ',')]);
	}

	public function getByservice()
	{
		$data = $this->getClientsByService();

		return View::make('reports.client_count_by_service')->with(['report_type' => 'service', 'colours' => $this->colours, 'clients' => $data['clients'], 'total_clients' => number_format($data['total_clients'], 0, '.', ',')]);
	}

	/**
	 * Export report to PDF or Excel
	 *
	 * @return bool|\Illuminate\Http\RedirectResponse
	 * @throws Exception
	 */
	public function getExport()
	{
		if(Input::has('filetype') && Input::has('report_type'))
		{
			switch(Input::get('filetype'))
			{
				case 'pdf':
					$contents = $this->PDFExport(Input::get('report_type'));
					$this->generatePDF($contents, $this->export_filename . '.pdf');
					return true;
					break;
			}
		}
		else
		{
			Flash::message('Error: no file type given or cannot export to that file type.');
			return Redirect::route($this->resource_key . '.index');
		}
	}

	/**
	 * Export a report to a PDF file
	 *
	 * @throws \Leadofficelist\Exceptions\PermissionDeniedException
	 * @internal param string $permission
	 * @internal param $items
	 *
	 * @return string
	 */
	protected function PDFExport($report_type)
	{
		$this->check_perm( 'view_list' );


		if(isset($report_type))
		{
			switch($report_type)
			{
				case 'unit':
					$data = $this->getClientsByUnit();
					$heading1 = 'Active Clients by Unit';
					$view = View::make('export.pdf.report_unit')->with(['heading1' => $heading1, 'colours' => $this->colours, 'clients' => $data['clients'], 'total_clients' => number_format($data['total_clients'], 0, '.', ',')]);
					return (string) $view;
					break;

				case 'type':
					$data = $this->getClientsByType();
					$heading1 = 'Active Clients by Type';
					$view = View::make('export.pdf.report_type')->with(['heading1' => $heading1, 'colours' => $this->colours, 'clients' => $data['clients'], 'total_clients' => number_format($data['total_clients'], 0, '.', ',')]);
					return (string) $view;
					break;

				case 'service':
					$data = $this->getClientsByService();
					$heading1 = 'Active Clients by Service';
					$view = View::make('export.pdf.report_service')->with(['heading1' => $heading1, 'colours' => $this->colours, 'clients' => $data['clients'], 'total_clients' => number_format($data['total_clients'], 0, '.', ',')]);
					return (string) $view;
					break;

				case 'expertise':
					$data = $this->getClientsByExpertise();
					$heading1 = 'Active Clients by Expertise Area';
					$view = View::make('export.pdf.report_sector')->with(['heading1' => $heading1, 'colours' => $this->colours, 'clients' => $data['clients'], 'total_clients' => number_format($data['total_clients'], 0, '.', ',')]);
					return (string) $view;
					break;

				default:
					$data = $this->getClientsBySector();
					$heading1 = 'Active Clients by Sector';
					$view = View::make('export.pdf.report_sector')->with(['heading1' => $heading1, 'colours' => $this->colours, 'clients' => $data['clients'], 'total_clients' => number_format($data['total_clients'], 0, '.', ',')]);
					return (string) $view;
					break;
			}
		}
		else
		{
			Flash::message('Error: no report type given or cannot export to that file type.');
			return Redirect::route($this->resource_key . '.index');
		}
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

	protected function getClientsBySector()
	{
		$sectors = Sector::all();
		$clients = [];
		$total_clients = 0;
		$count = 0;
		foreach($sectors as $sector)
		{
			$clients[] = ['sector_name' => $sector->name, 'client_count' => $sector->clients()->where('status', '=', 1)->count()];
			$total_clients += $sector->clients()->where('status', '=', 1)->count();
		}

		uasort($clients, [$this, 'compare']);
		foreach($clients as &$client)
		{
			$client['id'] = $count;
			$client['percentage'] = $this->formatPercentage($client['client_count'], $total_clients);
			$count++;
		}

		$data['clients'] = $clients;
		$data['total_clients'] = $total_clients;

		return $data;
	}

	protected function getClientsByExpertise()
	{
		$sector_cats = Sector_category::all();
		$clients = [];
		$total_clients = 0;
		$count = 0;
		foreach($sector_cats as $sector_cat)
		{
			//Get all the sectors in this category, then iterate through them to get the client count in each sector
			//Add the total to the clients array.
			$sectors_in_category = Sector::where('category_id', '=', $sector_cat->id)->get();
			$total_in_category = 0;
			foreach($sectors_in_category as $sector)
			{
				$total_in_category += $sector->clients()->where('status', '=', 1)->count();
			}
			$clients[] = ['sector_name' => $sector_cat->name, 'client_count' => $total_in_category];
			$count++;
			$total_clients += $total_in_category;
		}

		uasort($clients, [$this, 'compare']);
		$count = 0;
		foreach($clients as &$client)
		{
			$client['id'] = $count;
			$client['percentage'] = $this->formatPercentage($client['client_count'], $total_clients);
			$count++;
		}

		$data['clients'] = $clients;
		$data['total_clients'] = $total_clients;

		return $data;
	}

	protected function getClientsByUnit()
	{
		$clients = [];
			$total_clients = 0;
//        First, get all units that are not included in a unit group (i.e. unit_group_id equals 0)
//        Then grab the number of clients assigned to each unit
		if(Network_type::where('name', '=', 'Unit / New Unit')->first()) {

			$units = Unit::where('unit_group_id', '=', 0)->where('network_type_id', '=', Network_type::where('name', '=', 'Unit / New Unit')->first()->id)->get();
			$count = 0;
			foreach($units as $unit)
			{
				$clients[] = ['unit_short_name' => $unit->short_name, 'unit_name' => $unit->name, 'client_count' => $unit->clients()->where('status', '=', 1)->count()];
				$count++;
				$total_clients += $unit->clients()->where('status', '=', 1)->count();
			}
		}
//        Second, get all the unit groups and work out how many clients are assigned to the units in each group
        $unit_groups = Unit_group::all();
        foreach($unit_groups as $group)
        {
        	if(Network_type::where('name', '=', 'Unit / New Unit')->first()) {

//            Get all the units in the current group and find out how many clients they have between them
            $units_in_group = Unit::where('unit_group_id', '=', $group->id)->where('network_type_id', '=', Network_type::where('name', '=', 'Unit / New Unit')->first()->id)->get();
            $group_client_count = 0;
            foreach($units_in_group as $group_unit)
            {
                $group_client_count += $group_unit->clients()->where('status', '=', 1)->count();
            }

//            Add the current group into the clients array with the other units
            $clients[] = ['unit_short_name' => $group->short_name, 'unit_name' => $group->name, 'client_count' => $group_client_count];
            $total_clients += $group_client_count;

	        }
        }

//        Sort the clients into order, highest number of clients first
		uasort($clients, [$this, 'compare']);
		$count = 0;
		foreach($clients as &$client)
		{
			$client['id'] = $count;
			$client['percentage'] = $this->formatPercentage($client['client_count'], $total_clients);
			$count++;
		}

		$data['clients'] = $clients;
		$data['total_clients'] = $total_clients;

		return $data;
	}

	protected function getClientsByType()
	{
        //        First, get all types that are not included in a type category (i.e. category_id equals 0)
        //        Then grab the number of clients assigned to each type
        $types = Type::where('category_id', '=', 0)->get();
        $clients = [];
        $total_clients = 0;
        $count = 0;
        foreach($types as $type)
        {
            $clients[] = ['type_short_name' => $type->short_name, 'type_name' => $type->name, 'client_count' => $type->clients()->where('status', '=', 1)->count()];
            $count++;
            $total_clients += $type->clients()->where('status', '=', 1)->count();
        }

        //        Second, get all the type categories and work out how many clients are assigned to the types in each group
        $type_categories = Type_category::all();
        foreach($type_categories as $type_cat)
        {
            //            Get all the units in the current group and find out how many clients they have between them
            $types_in_category = Type::where('category_id', '=', $type_cat->id)->get();
            $type_cat_client_count = 0;
            foreach($types_in_category as $type)
            {
                $type_cat_client_count += $type->clients()->where('status', '=', 1)->count();
            }

            //            Add the current group into the clients array with the other types
            $clients[] = ['type_short_name' => $type_cat->short_name, 'type_name' => $type_cat->name, 'client_count' => $type_cat_client_count];
            $total_clients += $type_cat_client_count;
        }

        //        Sort the clients into order, highest number of clients first
        uasort($clients, [$this, 'compare']);
        $count = 0;
        foreach($clients as &$client)
        {
            $client['id'] = $count;
            $client['percentage'] = $this->formatPercentage($client['client_count'], $total_clients);
            $count++;
        }

        $data['clients'] = $clients;
        $data['total_clients'] = $total_clients;

        return $data;
	}

	protected function getClientsByService()
	{
		$services = Service::all();
		$clients = [];
		$total_clients = 0;
		$count = 0;
		foreach($services as $service)
		{
			$clients[] = ['service_name' => $service->name, 'client_count' => $service->clients()->where('status', '=', 1)->count()];
			$count++;
			$total_clients += $service->clients()->where('status', '=', 1)->count();
		}

		uasort($clients, [$this, 'compare']);
		$count = 0;
		foreach($clients as &$client)
		{
			$client['id'] = $count;
			$client['percentage'] = $this->formatPercentage($client['client_count'], $total_clients);
			$count++;
		}

		$data['clients'] = $clients;
		$data['total_clients'] = $total_clients;

		return $data;
	}

	protected function formatPercentage($client_count, $total_clients)
	{
		return number_format(round(($client_count / $total_clients) * 100, 1), 1);
	}

	public function missingMethod($parameters = [])
	{
		return Redirect::to('reports');
	}

}