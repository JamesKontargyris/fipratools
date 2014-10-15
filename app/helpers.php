<?php

use Leadofficelist\Users\User;

function display_page_title($default = 'Lead Office List')
{
	if(isset($page_title)) {
		echo $page_title;
	}
	else
	{
		echo $default;
	}
}

/**
 * Format an array of strings into a nice list
 *
 * @param $items
 *
 * @return string
 */
function pretty_text_list($items)
{
	//Add commas between all items and a full stop on the end.
	$pretty_list = implode(', ', $items) . '.';

	//More than one item?
	if(count($items) > 1)
	{
		//Replace the final comma with ' and '.
		$pretty_list = str_lreplace(', ', ' and ', $pretty_list);
	}

	return $pretty_list;
}

/**
 * Format an array of unit short names into a nice list
 * for display in the clients list
 *
 * @param $items
 *
 * @return string
 */
function pretty_links_list($items)
{
	//Add commas between all items
	return implode(', ', $items);
}

/**
 * Find the last occurrence of a string within a string and replace it
 *
 * @param $search
 * @param $replace
 * @param $subject
 *
 * @return mixed
 */
function str_lreplace($search, $replace, $subject)
{
	$pos = strrpos($subject, $search);

	if($pos !== false)
	{
		$subject = substr_replace($subject, $replace, $pos, strlen($search));
	}

	return $subject;
}

/**
 * Check if we are adding a new resource or editing an existing one.
 *
 * @return bool
 */
function editing()
{
	//If we are on the edit page of a resource, and this is not a post request on the edit page (i.e. validation errors), return true
	if(Request::is() == "*/edit" && ! Request::isMethod('post'))
	{
		return true;
	}
	//Otherwise, this is not an edit page
	return false;
}

function is_search()
{
	if(Request::is('*/search')) { return true; }

	return false;
}

function is_filter()
{
	if(Session::get('list.SearchType') == 'filter') { return true; }

	return false;
}

function is_request($uri, $strict = false)
{
	if($strict == true) $request_is = Request::is($uri);
	else $request_is = Request::is($uri) || Request::is($uri . '/*');

	return $request_is;
}

function nav_item_is_active($uri)
{
	if(is_request($uri)) return true;

	return false;
}