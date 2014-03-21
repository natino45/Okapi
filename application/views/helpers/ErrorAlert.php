<?php
class Zend_View_Helper_ErrorAlert extends Zend_View_Helper_Abstract
{
	
public function errorAlert($headerT, $msg, $errType ="error"){
	?> 
          <div style="margin:10px 5px 10px 5px;" class="alert alert-<?php echo $errType;?>"><a class="close" data-dismiss="alert" href="#">×</a>
		   <h4 class="alert-heading"><?php echo $headerT;?></h4>
		  <?php echo $msg;?>	</div>
          
    <?php
	
}
	
}