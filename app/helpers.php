<?php

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