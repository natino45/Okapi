<?php
class Zend_View_Helper_DateFormat  extends Zend_View_Helper_Abstract{
	
	public function dateFormat($val){
		if(!is_numeric($val)) $val = strtotime($val);
		if($val!=0){
		return date("j F , Y @ g:i a",$val); 
		}
		}
	
	}