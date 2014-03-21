<?php
class Application_Model_Project_Iframe

{

public function iframe($url){
	?>
<iframe src=" <?php echo $url;?>" frameborder="0" class="span12"  allowtransparency="1" scrolling="auto" name="p-box" style=" overflow:auto; height: 95%; " id="preview" ></iframe>    
    <?php
	}
}