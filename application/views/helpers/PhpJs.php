<?php
class Zend_View_Helper_PhpJs extends Zend_View_Helper_Abstract
{  
	public function phpJs($ftn){ 
	 ?>
	<iframe onload="<?php echo $ftn;?>" style="width:0; height:0;" frameborder="0">
 <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>	
	</iframe>
<?php 
	}
}