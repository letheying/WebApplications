<?php
/*
*	Format The Date
*/

function formatDate($date){
	date_default_timezone_set('America/New_York');
	return date("F j, Y, g:i a",strtotime($date));
}


/*
*	Format The Date
*/
function shortenText($text, $chars = 450) {
	$text = $text." ";
	$text = substr($text, 0, $chars);
	$text = substr($text, 0, strrpos($text,' '));
	$text = $text."...";
	return $text;
}


?>