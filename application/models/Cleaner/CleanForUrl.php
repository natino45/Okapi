<?php
class Application_Model_Cleaner_CleanForUrl 

{
	
 public function cleanForUrl($str){
	 /*$str = str_replace("'","-",$str);
	 $str = str_replace(" ", "-", $str);
	 $str = str_replace("--", "-", $str);
	 $str = str_replace(",", "-", $str);
	 $str = str_replace("--", "-", $str);
	 $str = str_replace("--", "-", $str);
	 $str = str_replace("%", "", $str);
	 $str = str_replace(",", "", $str);
	 $str = str_replace("\"", "", $str);
	 $str = strtolower($str);
	 $str = strip_tags($str);
	 $str = stripslashes($str);
	 $str = html_entity_decode($str);
	 $str = str_replace('\'', '', $str);
	 
	 //Replace non-alpha numeric with hyphens
	 $match = '/[^a-z0-9]+/';
    $replace = '-';
    $str = preg_replace($match, $replace, $str);
	 
	 $str = trim($str);
	 
	*/
	return strtolower(
			trim(
				preg_replace('~[^0-9a-z]+~i', '-', 
												html_entity_decode(preg_replace('~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i', '$1',
												 htmlentities($str, ENT_QUOTES, 'UTF-8')), ENT_QUOTES, 'UTF-8')), '-'));
	 
	 }	
	
}