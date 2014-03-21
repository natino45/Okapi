<?php
class Zend_View_Helper_BaseUrl  extends Zend_View_Helper_Abstract
{  
    function baseUrl($useStatic=false)  
    {  
		if($useStatic==false){
        $base_url = substr($_SERVER['PHP_SELF'], 0, -9);  
        return "http://".$_SERVER['HTTP_HOST'].$base_url."";  
		}else{
			 return 0; 
			}
    }  
}   
?>