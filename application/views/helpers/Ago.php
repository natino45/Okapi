<?php
class Zend_View_Helper_Ago extends Zend_View_Helper_Abstract
{
	function ago($tm,$rcs = 0) {
		$tm = strtotime($tm);
	    $cur_tm = time(); 
	   $dif = $cur_tm - $tm;
	   $pds = array('second','minute','hour','day','week','month','year','decade');
	   $lngh = array(1,60,3600,86400,604800,2630880,31570560,315705600);
	   for($v = sizeof($lngh)-1; 
	   ($v >= 0)&&(($no = $dif/$lngh[$v])<=1); $v--); 
	   
	   if($v < 0) $v = 0; $_tm = $cur_tm-($dif%$lngh[$v]);
	
	   $no = floor($no); if($no <> 1) $pds[$v] .='s'; 
	   $x = sprintf("%d %s ",$no,$pds[$v]);
	   if(($rcs == 1)&&($v >= 1)&&(($cur_tm-$_tm) > 0)) $x .= ago($_tm);
	   return $x;
	}
}
