<?php
class Zend_View_Helper_Aj extends Zend_View_Helper_Abstract
{
	function aj($displayLoc, $url, $formName, $rtnFalse ="false") {
		if(!empty($rtnFalse)){ $rtn = "return false;";}else{ $rtn="";}
 echo "link('nully','','".$displayLoc."','p','".$formName."','". $url ."');".$rtn;
	}
}