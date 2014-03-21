<?php
class Application_Model_Sanitize_Sanitize 

{

public function sanitize($str){
	$str = htmlspecialchars($str); 
	return stripslashes($str);
	}
}