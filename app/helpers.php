<?php

use Leadofficelist\Products\Product;
use Leadofficelist\Sectors\Sector;
use Leadofficelist\Users\User;

function display_page_title($default = 'Fipra Portal')
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

function is_filter($key = 'list')
{
	if(Session::get($key . '.SearchType') == 'filter') { return true; }

	return false;
}

function is_request($uri, $strict = false)
{
	if($strict == true) $request_is = Request::is($uri);
	else $request_is = Request::is($uri) || Request::is($uri . '/*');

	return $request_is;
}

function section_is() {
	return Session::get('section');
}

function current_section_name() {
	$sections = [
		'list' => 'Lead Office List',
		'case' => 'Case Study Database',
		'survey' => 'Knowledge Survey'
	];
	return $sections[Session::get('section') ? Session::get('section') : 'list'];
}

function nav_item_is_active($uri)
{
	if(is_request($uri)) return true;

	return false;
}

function clean_key($key, $uppercase_all_words = true)
{
	if($uppercase_all_words)
	{
		$words = explode('_', $key);
		$new_key = '';

		foreach($words as $word)
		{
			$new_key .= ucfirst($word) . ' ';
		}

		return trim($new_key);
	}
	else
	{
		return str_replace('_', ' ', $key);
	}
}

function ContentToTwoColumns($fullContent){
    //Get character length of content
    $fullContentLength = strlen($fullContent);
    //Set the ratio of column size
    $column1Percent = .50;
    $column2Percent = .50;

    //Break the content into two columns using the ratios given.
    $columnsContent = array();
    $columnBreak = round($column1Percent * $fullContentLength);
    $columnsContent[0] = substr($fullContent, 0, $columnBreak);
    $columnsContent[1] = substr($fullContent, $columnBreak);

    //Check for unclosed tags in the first column by comparing
    //the number of open tags with closed tags.
    $numTags = countOpenClosedTags($columnsContent[0]);
    $numOpened = $numTags[0];
    $numClosed = $numTags[1];
    $unclosedTags = $numOpened - $numClosed;

    //echo '<p>Opened Tags: '.$numTags[0].'</p>';
    //echo '<p>Closed Tags: '.$numTags[1].'</p>';
    //echo '<p>Unclosed Tags: '.$unclosedTags.'</p>';

    //If there are unclosed tags recalculate the column break.
    if($unclosedTags > 0){

        //Return the identity of all open tags in the first column.
        preg_match_all("#<([a-z]+)( .*)?(?!/)>#iU", $columnsContent[0], $result);
        $openedTags = $result[1];

        //Return the identity of all closed tags in the first column.
        preg_match_all("#</([a-z]+)>#iU", $columnsContent[0], $result);
        $closedTags = $result[1];

        //Reverse array of open tags so they can be matched against the closed tags.
        $openedTags = array_reverse($openedTags);

        //Loop through open/closed tags to identify first unclosed tag
        //in first column on content.
        for( $i = 0; $i < $numOpened; $i++ ){
            if ( !in_array ( $openedTags[$i], $closedTags ) ){
                $firstOpenTag = $openedTags[$i];
                //echo '<p>Open Tag: &lt;'.$firstOpenTag.'&gt;</p>';
            } else {
                unset ( $closedTags[array_search ( $openedTags[$i], $closedTags)] );
            }
        }

        //Get name of first open tag and create a closed version.
        //$firstOpenTag = $openedTags[$tagNum][0];
        $firstOpenTagClosed = '</'.$firstOpenTag.'>';

        //Calculate the tag length of the closed version.
        $tagLength = strlen($firstOpenTagClosed);

        //Locate the position of the first closed tag in the second column
        //content that matches the first opened tag in the first column
        $positionCloseTag = strpos($columnsContent[1], $firstOpenTagClosed);

        //Calculate the position of the new column break using the
        //position of and length the final closing tag.
        $columnBreak = $columnBreak + $positionCloseTag + $tagLength;

        //echo '<p>Final Closing Tag: &lt;/'.$firstOpenTag.'&gt;</p>';
        //echo '<p>Column Break Point: '.$columnBreak.'</p>';

        // Break the content into two columns using the new break point.
        $columnsContent[0] = substr($fullContent, 0, $columnBreak);
        $columnsContent[1] = substr($fullContent, $columnBreak);
    }

    // Return the two columns as an array
    return $columnsContent;
}

function countOpenClosedTags($html){
    //Return the identity and position of all open tags in the HTML.
    preg_match_all("#<([a-z]+)( .*)?(?!/)>#iU", $html, $result, PREG_OFFSET_CAPTURE);

    //Check that the returned result array isn't empty.
    if (!isset($result[1])){
        $numOpened = 0;
    } else {
        //If the result array isn't empty get the number of open tags.
        $openedTags = $result[1];
        $numOpened = (!$openedTags) ? 0 : count($openedTags);
    }

    //Return the identity and position of all close tags in the HTML.
    preg_match_all("#</([a-z]+)>#iU", $html, $result, PREG_OFFSET_CAPTURE);

    //Check that the returned result array isn't empty.
    if (!isset($result[1])){
        $numClosed = 0;
    } else {
        //If the result array isn't empty get the number of close tags.
        $closedTags = $result[1];
        $numClosed = (!$closedTags) ? 0 : count($closedTags);
    }

    //Create an array to return the open and close counts.
    $numTags = array($numOpened, $numClosed);
    return $numTags;
}

// Use an array of product IDs to get product names,
// then return a comma-separated string of all names
function get_pretty_product_names($product_ids)
{
	if( is_array($product_ids) && count($product_ids) >= 1) {
		$product_names = [];
		foreach($product_ids as $product_id)
		{
			if($product_id) $product_names[] = Product::find($product_id)->name;
		}

		return implode(', ', $product_names);
	}

	return false;
}

// Use an array of sector IDs to get sector names,
// then return a comma-separated string of all names
function get_pretty_sector_names($sector_ids)
{
	if( is_array($sector_ids) && count($sector_ids) >= 1) {
		$sector_names = [];
		foreach($sector_ids as $sector_id)
		{
			if($sector_id) $sector_names[] = Sector::find($sector_id)->name;
		}

		return implode(', ', $sector_names);
	}

	return false;
}