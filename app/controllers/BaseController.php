<?php

use Ignited\Pdf\Facades\Pdf;
use Laracasts\Flash\Flash;
use Leadofficelist\Account_directors\AccountDirector;
use Leadofficelist\Clients\Client;
use Leadofficelist\Exceptions\PermissionDeniedException;
use Leadofficelist\Sectors\Sector;
use Leadofficelist\Services\Service;
use Leadofficelist\Types\Type;
use Leadofficelist\Units\Unit;
use Leadofficelist\Users\User;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

class BaseController extends Controller
{

    protected $user;
    protected $rows_sort_order;
    protected $rows_to_view;
    protected $rows_list_filter_field;
    protected $rows_list_filter_value;
    protected $rows_hide_show_dormant;
    protected $rows_hide_show_active;
    protected $userFullName;
    protected $account_directors;
    protected $units;
    protected $sectors;
    protected $types;
    protected $services;
    protected $export_filename;
    protected $search_term_clean;

    /**
     * Array of filter keys to reset when "reset filters" is clicked
     *
     * @var array
     */
    protected $filter_keys = ['rowsToView', 'rowsSort', 'rowsNameOrder', 'rowsHideShowDormant'];

    function __construct()
    {
        $this->user = Auth::user();
        if (isset($this->user->id)) {
            View::share('user', $this->user);
            View::share('user_full_name', $this->user->getFullName());
            View::share('user_unit', $this->user->unit()->pluck('name'));
            View::share('user_role', $this->user->roles()->pluck('name'));
        }

        $this->setCurrentPageNumber();

        $this->reset_sorting();
        $this->rows_sort_order = $this->getRowsSortOrder($this->resource_key);
        $this->rows_to_view = $this->getRowsToView($this->resource_key);
        $this->name_order = $this->getNameOrder($this->resource_key);
        $this->rows_list_filter_field = $this->getRowsListFilterField($this->resource_key);
        $this->rows_list_filter_value = $this->getRowsListFilterValue($this->resource_key);
        $this->name_order = $this->getNameOrder($this->resource_key);
        $this->rows_hide_show_dormant = $this->getRowsHideShowDormant($this->resource_key);
        $this->rows_hide_show_active = $this->getRowsHideShowActive($this->resource_key);


//        if($this->rows_hide_show_dormant == 'hide' && $this->rows_hide_show_active == 'hide')
//        {
//            $this->rows_hide_show_active = 'show';
//        }

        $this->export_filename = date('ymd_H-i') . '_' . $this->resource_key;
    }

    /**
     * Export data to PDF or Excel
     *
     * @return bool|\Illuminate\Http\RedirectResponse
     * @throws Exception
     */
    public function export()
    {
        if (Input::has('filetype')) {
            $this->check_perm($this->resource_permission);

            switch (Input::get('filetype')) {
                case 'pdf_all':
                    $contents = $this->PDFExportAll($this->getAll());
                    $this->generatePDF($contents, $this->export_filename . '.pdf');
                    return true;
                    break;

                case 'pdf_selection':
                    $contents = $this->PDFExportSelection($this->getSelection());
                    $this->generatePDF($contents, $this->export_filename . '_selection.pdf');
                    return true;
                    break;

                case 'pdf_filtered':
                    $contents = $this->PDFExportFiltered($this->getFiltered());
                    $this->generatePDF($contents, $this->export_filename . '_filtered.pdf');
                    return true;
                    break;

                case 'pdf_duplicates':
                    $contents = $this->PDFExportDuplicates($this->getDuplicates());
                    $this->generatePDF($contents, $this->export_filename . '_duplicates.pdf');
                    return true;
                    break;

                case 'excel_all':
                    $contents = $this->getAll();
                    $this->generateExcel($contents, $this->export_filename);
                    return true;
                    break;

                case 'excel_selection':
                    $contents = $this->getSelection();
                    $this->generateExcel($contents, $this->export_filename . '_selection');
                    return true;
                    break;

                case 'excel_filtered':
                    $contents = $this->getFiltered();
                    $this->generateExcel($contents, $this->export_filename . '_filtered');
                    return true;
                    break;
            }
        } else {
            Flash::message('Error: no file type given or cannot export to that file type.');
            return Redirect::route($this->resource_key . '.index');
        }
    }

    /**
     * Export all records for a resource to a PDF file
     *
     * @param $items
     *
     * @return string
     */
    protected function PDFExportAll($items)
    {
        $key = is_request('list') ? 'clients' : $this->resource_key;
        //Clients and List specific variables
        $active_count = 0;
        $dormant_count = 0;

        $heading1 = is_request('list') ?
            'Full List' :
            'All ' . clean_key($key);

        $heading2 = number_format($items->count(), 0) . ' total ' . clean_key($key);
        if (is_request('clients') || is_request('list')) {
            $active_count = $this->getActiveCount();
            $dormant_count = $this->getDormantCount();
        }
        $view = View::make(
            'export.pdf.' . $key,
            [
                'items' => $items,
                'heading1' => $heading1,
                'heading2' => $heading2,
                'active_count' => $active_count,
                'dormant_count' => $dormant_count,
            ]
        );

        return (string)$view;
    }

    /**
     * Export a visible selection of records for a resource to a PDF file
     *
     * @param $items
     *
     * @return string
     */
    protected function PDFExportSelection($items)
    {
        $key = is_request('list') ? 'clients' : $this->resource_key;

        $heading1 = ucfirst(clean_key($this->resource_key)) . ' Selection';
        $heading2 = isset($this->search_term_clean) ?
            'Showing ' . number_format($items->count(), 0) . ' ' . clean_key(
                $key
            ) . ' when searching for ' . Session::get(
                $this->resource_key . '.SearchType'
            ) . ' "' . $this->search_term_clean . '"' :
            'Showing ' . number_format($items->count(), 0) . ' ' . clean_key($key);
        $view = View::make('export.pdf.' . $key, ['items' => $items, 'heading1' => $heading1, 'heading2' => $heading2]);

        return (string)$view;
    }

    /**
     * Export a filtered selection of records from the main list to a PDF file
     *
     * @param $items
     *
     * @return string
     */
    protected function PDFExportFiltered($items)
    {
        $key = is_request('list') ? 'clients' : $this->resource_key;

        $heading1 = ucfirst(clean_key($this->resource_key)) . ' Selection';
        if(Session::get('list.rowsHideShowDormant') == 'show' && Session::get('list.rowsHideShowActive') == 'show') {
            $heading2 = 'Showing ' . number_format($items->count(), 0) . ' active and dormant ' . clean_key($key) . ' filtering on: ' . $items->filter_value;
        } elseif(Session::get('list.rowsHideShowDormant') == 'show' && Session::get('list.rowsHideShowActive') != 'show') {
            $heading2 = 'Showing ' . number_format($items->count(), 0) . ' dormant ' . clean_key($key) . ' filtering on: ' . $items->filter_value;
        } else {
            $heading2 = 'Showing ' . number_format($items->count(), 0) . ' active ' . clean_key($key) . ' filtering on: ' . $items->filter_value;
        }
        $view = View::make('export.pdf.' . $key, ['items' => $items, 'heading1' => $heading1, 'heading2' => $heading2]);

        return (string)$view;
    }

    /**
     * Export a listing of duplicate resource records to a PDF file
     *
     * @param $items
     *
     * @return string
     */
    protected function PDFExportDuplicates($items)
    {
        $heading1 = 'Duplicated ' . ucfirst(clean_key($this->resource_key));
        $heading2 = number_format($items->count(), 0) . ' total ' . clean_key($this->resource_key);
        $active_count = 0;
        $dormant_count = 0;

        if (is_request('list') || is_request('clients')) {
            $active_count = $this->getActiveCount();
            $dormant_count = $this->getDormantCount();
        }

        $view = View::make(
            'export.pdf.' . $key,
            [
                'items' => $items,
                'heading1' => $heading1,
                'heading2' => $heading2,
                'active_count' => $active_count,
                'dormant_count' => $dormant_count,
            ]
        );

        return (string)$view;
    }

    /**
     * Generate a PDF file
     *
     * @param      $contents
     * @param      $filename
     * @param bool $cover_page
     *
     * @throws Exception
     */
    protected function generatePDF($contents, $filename, $cover_page = true)
    {
        $header_right = 'Fipra Lead Office List';
        $footer_left = 'Generated at [time] on [date]';
//        $footer_center = 'Page [page] of [toPage]';
        $footer_center = 'Page [page]';
        $footer_right = 'Private and Confidential';
        $pdf = PDF::make();
        $pdf->setOptions(
            array(
                'orientation' => 'landscape',
                'margin-top' => '15',
                'header-font-size' => '8',
                'header-spacing' => '5',
                'header-right' => $header_right,
                'margin-bottom' => '15',
                'footer-spacing' => '5',
                'footer-font-size' => '8',
                'footer-left' => $footer_left,
                'footer-center' => $footer_center,
                'footer-right' => $footer_right,
                'image-quality' => '100',
                'images',
            )
        );
        if ($cover_page) {
            $heading1 = 'About the Lead Office List';
            $cover_page = View::make('export.pdf.coverpage')->with(compact('heading1'));
            $pdf->addPage($cover_page->render());
        }
        $pdf->addPage($contents);
        if (!$pdf->send($filename)) {
            throw new Exception('Could not create PDF: ' . $pdf->getError());
        }
    }


    /**
     * Generate an Excel file
     *
     * @param $contents
     * @param $filename
     *
     */
    protected function generateExcel($contents, $filename)
    {
        global $items;
        $items = $contents;

        Excel::create(
            $filename,
            function ($excel) {

                $excel->sheet(
                    clean_key($this->resource_key),
                    function ($sheet) {
                        global $items;
                        $user = Auth::user();

                        //If the main lead office list is being exported, it contains a message in the first cell
                        //Merge some cells so the messages doesn't make the first column too wide
                        if (is_request('list')) {
                            $sheet->mergeCells('A1:G1');
                        }
                        $sheet->loadView('export.excel.' . $this->resource_key)->with(
                            ['items' => $items, 'user' => $user]
                        );

                    }
                );

                $excel->download('xls');

            }
        );
    }

    /**
     * If reset_sorting is set to yes, reset all session keys
     * listed in $filter_keys
     *
     * @return bool
     */
    protected function reset_sorting()
    {
        if (Input::has('reset_sorting')) {
            foreach ($this->filter_keys as $key) {
                Session::forget($this->resource_key . '.' . $key);
            }
            //Start again on page 1 of results
            $this->destroyCurrentPageNumber();
        }

        return true;
    }

    /**
     * Process the 'view' value passed in the query string and return the correct value
     *
     * @return int|mixed
     */
    protected function getRowsToView($key)
    {
        //If the value passed in is 'all', set the valye to 99999. Otherwise,
        //use the value passed in, which should be numeric
        $value = (Input::get('view') == 'all') ? 99999 : Input::get('view');
        //Value passed in and it is numeric?
        if (Input::has('view') && is_numeric($value)) {
            //A new view range has been passed in, so destroy the existing page number which will now be wrong
            $this->destroyCurrentPageNumber();
            Session::set($key . '.rowsToView', $value);

            return $value;
        } //Session value exists for rowsToView?
        elseif (Session::get($key . '.rowsToView')) {
            return Session::get($key . '.rowsToView');
        } //If all else fails...
        else {
            return 10;
        }
    }

    /**
     * Process the 'sort' value passed in the query string and return the correct value
     *
     * @return array
     */
    protected function getRowsSortOrder($key)
    {
        //Array of column names that will be sorted on, and how they should be ordered
        $sort_on = ['az' => 'name.asc', 'za' => 'name.desc', 'newest' => 'id.desc', 'oldest' => 'id.asc'];
        //Different column names in the users and account_directors table
        $sort_on_users_ads = [
            'az' => 'last_name.asc',
            'za' => 'last_name.desc',
            'newest' => 'id.desc',
            'oldest' => 'id.asc'
        ];

        //Value passed in and exists in the $sort_on variable?
        if (Input::has('sort')) {
            //If a sort term is passed in in the query string, store it in the session
            //and return the column and order to sort on
            $sort_term = Input::get('sort');
            if (!$this->is_request('account_directors') && !$this->is_request('users') && isset($sort_on[Input::get(
                        'sort'
                    )])
            ) {
                $this->destroyCurrentPageNumber();
                Session::set($key . '.rowsSort', $sort_on[$sort_term]);

                return explode('.', $sort_on[$sort_term]);
            } elseif ($this->is_request('users') || $this->is_request('account_directors')) {
                $this->destroyCurrentPageNumber();
                Session::set($key . '.rowsSort', $sort_on_users_ads[$sort_term]);

                return explode('.', $sort_on_users_ads[$sort_term]);
            }
        } //Session value exists for rowsSort?
        elseif (Session::get($key . '.rowsSort')) {
            return explode('.', Session::get($key . '.rowsSort'));
        } //If all else fails...
        else {
            return ($this->is_request('users') || $this->is_request('account_directors')) ? [
                'last_name',
                'asc'
            ] : ['name', 'asc'];
        }

        return false;
    }

    /**
     * Process the 'dormant' value passed in the query string and return the correct value
     *
     * @return int|mixed
     */
    protected function getRowsHideShowDormant($key)
    {
        if (Input::has('dormant') && Input::get('dormant') == 'show') {
            $this->destroyCurrentPageNumber();
            Session::set($key . '.rowsHideShowDormant', 'show');

            return 'show';
        } elseif (Input::has('dormant') && Input::get('dormant') == 'hide' && Session::get($key . '.rowsHideShowActive') != 'hide') {
            $this->destroyCurrentPageNumber();
            Session::set($key . '.rowsHideShowDormant', 'hide');

            return 'hide';
        } elseif (Session::get($key . '.rowsHideShowDormant')) {
            return Session::get($key . '.rowsHideShowDormant');
        }

        //If all else fails...
        Session::set($key . '.rowsHideShowDormant', 'hide');
        return 'hide';
    }

    /**
     * Process the 'active' value passed in the query string and return the correct value
     *
     * @return int|mixed
     */
    protected function getRowsHideShowActive($key)
    {
        if (Input::has('active') && Input::get('active') == 'show') {
            $this->destroyCurrentPageNumber();
            Session::set($key . '.rowsHideShowActive', 'show');

            return 'show';
        } elseif (Input::has('active') && Input::get('active') == 'hide' && Session::get($key . '.rowsHideShowDormant') != 'hide') {
            $this->destroyCurrentPageNumber();
            Session::set($key . '.rowsHideShowActive', 'hide');

            return 'hide';
        } elseif (Session::get($key . '.rowsHideShowActive')) {
            return Session::get($key . '.rowsHideShowActive');
        }

        //If all else fails...
        Session::set($key . '.rowsHideShowActive', 'show');
        return 'show';
    }

    protected function getNameOrder($key)
    {
        $value = Input::get('name');
        //Value passed in?
        if ($value) {
            Session::set($key . '.rowsNameOrder', $value);
        }

        return $value;
    }

    /**
     *
     * @return int|mixed
     */
    protected function getRowsListFilterField($key)
    {
        //Value passed in?
        if (Input::has('filter_field')) {
            $this->destroyCurrentPageNumber();
            Session::set($key . '.rowsListFilterField', Input::get('filter_field'));

            return Input::get('filter_field');
        } //Session value exists?
        elseif (Session::get($key . '.rowsListFilterField')) {
            return Session::get($key . '.rowsListFilterField');
        } //If all else fails...
        else {
            return 'status';
        }
    }

    /**
     *
     * @return int|mixed
     */
    protected function getRowsListFilterValue($key)
    {
        //Value passed in?
        if (Input::has('filter_value') && is_numeric(Input::get('filter_value'))) {
            $this->destroyCurrentPageNumber();
            Session::set($key . '.rowsListFilterValue', Input::get('filter_value'));

            return Input::get('filter_value');
        } //Session value exists?
        elseif (Session::get($key . '.rowsListFilterValue')) {
            return Session::get($key . '.rowsListFilterValue');
        } //If all else fails...
        else {
            return 1;
        }
    }

    protected function check_perm($perm)
    {
        if ($this->user->can($perm)) {
            return true;
        }

        throw new PermissionDeniedException;
    }

    /**
     * Check if the logged in user has a particular role
     *
     * @param $role
     *
     * @return bool
     * @throws PermissionDeniedException
     */
    protected function check_role($role)
    {
        if (is_array($role)) {
            foreach ($role as $r) {
                if ($this->user->hasRole($r)) {
                    return true;
                }
            }
        } elseif ($this->user->hasRole($role)) {
            return true;
        }

        throw new PermissionDeniedException;
    }

    protected function is_request($uri, $strict = false)
    {
        if ($strict == true) {
            $request_is = Request::is($uri);
        } else {
            $request_is = Request::is($uri) || Request::is($uri . '/*');
        }

        return $request_is;
    }

    protected function getActiveClientsByField($field, $id)
    {
        return Client::orderBy('name')->where($field, '=', $id)->where('status', '=', 1)->get();
    }

    protected function searchCheck()
    {
        if (Input::has('clear_search') || Session::has('clear_search')) {
            Session::forget($this->resource_key . '.SearchTerm');
            Session::forget($this->resource_key . '.SearchType');
            Session::forget('clear_search');
            $this->destroyCurrentPageNumber();
        } elseif (Session::has($this->resource_key . '.SearchTerm')) {
            return true;
        }

        return false;
    }

    protected function findSearchTerm()
    {
        if (Input::has('search')) {
            //Start again on page 1 of the results
            $this->destroyCurrentPageNumber();

            if (Input::has('letter')) {
                Session::set($this->resource_key . '.SearchTerm', Input::get('search') . '%');
                Session::set($this->resource_key . '.SearchType', 'first letter');
            } else {
                Session::set($this->resource_key . '.SearchTerm', '%' . Input::get('search') . '%');
                Session::set($this->resource_key . '.SearchType', 'term');
            }
        } elseif (Input::has('filter_value') && Input::has('filter_field')) {
            Session::set($this->resource_key . '.SearchTerm', Input::get('filter_value'));
            Session::set($this->resource_key . '.SearchType', 'filter');
        }

        return Session::get($this->resource_key . '.SearchTerm');
    }

    protected function checkForSearchResults($items)
    {
        if (!count($items)) {
            Flash::message('No records found for that search term.');
            Session::set('clear_search', 'yes');

            return false;
        }

        return true;
    }


    /**
     * Get all data required.
     *
     * @return bool
     */
    protected function getFormData()
    {
        $this->account_directors = $this->getAccountDirectorsFormData();
        $this->units = $this->getUnitsFormData();
        $this->sectors = $this->getSectorsFormData();
        $this->types = $this->getTypesFormData();
        $this->services = $this->getServicesFormData();

        return true;
    }

    /**
     * Get all the units in a select element-friendly collection.
     *
     * @return array
     */
    protected function getAccountDirectorsFormData($blank_entry = true, $blank_message = 'Please select...')
    {
        if (!AccountDirector::getAccountDirectorsForFormSelect($blank_entry, $blank_message)) {
            return ['' => 'No units available to select'];
        }

        return AccountDirector::getAccountDirectorsForFormSelect($blank_entry, $blank_message);
    }

    /**
     * Get all the units in a select element-friendly collection.
     *
     * @return array
     */
    protected function getUnitsFormData($blank_entry = true, $blank_message = 'Please select...')
    {
        if (!Unit::getUnitsForFormSelect($blank_entry, $blank_message)) {
            return ['' => 'No units available to select'];
        }

        return Unit::getUnitsForFormSelect($blank_entry, $blank_message);
    }

    /**
     * Get all the sectors in a select element-friendly collection.
     *
     * @return array
     */
    protected function getSectorsFormData($blank_entry = true, $blank_message = 'Please select...')
    {
        if (!Sector::getSectorsForFormSelect($blank_entry, $blank_message)) {
            return ['' => 'No sectors available to select'];
        }

        return Sector::getSectorsForFormSelect($blank_entry, $blank_message);
    }

    /**
     * Get all the types in a select element-friendly collection.
     *
     * @return array
     */
    protected function getTypesFormData($blank_entry = true, $blank_message = 'Please select...')
    {
        if (!Type::getTypesForFormSelect($blank_entry, $blank_message)) {
            return ['' => 'No types available to select'];
        }

        return Type::getTypesForFormSelect($blank_entry, $blank_message);
    }

    /**
     * Get all the types in a select element-friendly collection.
     *
     * @return array
     */
    protected function getServicesFormData($blank_entry = true, $blank_message = 'Please select...')
    {
        if (!Service::getServicesForFormSelect($blank_entry, $blank_message)) {
            return ['' => 'No services available to select'];
        }

        return Service::getServicesForFormSelect($blank_entry, $blank_message);
    }

    protected function getActiveCount()
    {
        if ($this->user->hasRole('Administrator')) {
            return Client::where('status', '=', 1)->count();
        } else {
            return Client::where('unit_id', '=', $this->user->unit_id)->where('status', '=', 1)->count();
        }
    }

    protected function getDormantCount()
    {
        if ($this->user->hasRole('Administrator')) {
            return Client::where('status', '=', 0)->count();
        } else {
            return Client::where('unit_id', '=', $this->user->unit_id)->where('status', '=', 0)->count();
        }
    }

    /**
     * Set the current page number for paginated results, so users can return to the same page
     * when they visit a client page, edit a client, change a client's status etc.
     * @return bool
     */
    protected function setCurrentPageNumber()
    {
        //If a value for 'page' is passed in, set that as the current page number
        if (Input::has('page')) {
            Session::set($this->resource_key . '.currentPageNumber', Input::get('page'));
        }
        //If a session variable for the current page number exists, set that as the current page
        if (Session::has($this->resource_key . '.currentPageNumber')) {
            Paginator::setCurrentPage(Session::get($this->resource_key . '.currentPageNumber'));
        }

        return true;
    }

    /**
     * Delete the current page number stored in the session, either for the current resource or for every other resource
     * (used when moving from one resource index page to another, so the user lands back on page one when switching back again)
     * @param bool $for_other_resources
     *
     * @return bool
     */
    protected function destroyCurrentPageNumber($for_other_resources = false)
    {
        $resources = [
            'list',
            'clients',
            'client_links',
            'client_archives',
            'users',
            'units',
            'sectors',
            'sector_categories',
            'types',
            'services',
            'account_directors',
            'eventlogs'
        ];

        if ($for_other_resources) {
            foreach ($resources as $resource) {
                if ($this->resource_key != $resource) {
                    Session::forget($resource . '.currentPageNumber');
                }
            }
        } else {
            Session::forget($this->resource_key . '.currentPageNumber');
            Paginator::setCurrentPage(1);
        }

        return true;
    }
}
