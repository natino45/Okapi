<?php
class Application_Model_Project_GetProject

{

public function getProject($id, $fileName=""){
	$projectObj = new Application_Model_DbTable_Projects;
	$project = $projectObj->getById($id);
	if($project){
		if(substr($project->folderName,0, 7) == "http://"){ $external = true;}
	$projectsDir = "../projects/".$project->folderName;
	
	if($external):
				$ct = $this->get_mime_type($fileContent);
				header("content-type:". $ct);
				readfile( $project->folderName."".$fileName);
				exit;
	else:
	
	if(is_dir($projectsDir)){
	//$dirScan = scandir($projectsDir);
	if($fileName==""){
		if(is_file($projectsDir."/index.html")){ $defaultFile = $projectsDir."/index.html";}
		else{$defaultFile = $projectsDir."/index.php"; }
			$fileContent = ($defaultFile);
		}else{
			$fx = explode("?",$fileName);
			$fileName = $fx[0];
			$fileContent = ($projectsDir."/".$fileName);
			}
			
	  
			
			if(is_file($fileContent)){  
			 $extVal = $this->getExt($fileName);
		switch ($extVal)
		{
			case "php":
			case "php5":
			case "phtml":
				ob_start();
				$ct = $this->get_mime_type($fileContent);
				header("content-type:". $ct);
				include $fileContent;
				return ob_get_clean(); 	
				break;
				
			default:  
				$ct = $this->get_mime_type($fileContent);
				header("content-type:". $ct);
				readfile( $fileContent);
				exit;
			break;
			  
			
					
			}	
			}else {
				$ct = $this->get_mime_type($fileContent);
				header("content-type:". $ct);
				exit;
				}
        
	
		}else return 0;
		endif;
	}else return 0;
	}
	

private function getExt($fn){
	 
			 $fileN = strtolower($fn) ; 
			 $exts = explode('.',$fileN);
			 $n = count($exts)-1;
			 $qEx = explode("?",$exts[$n]);
			 $fileEXT =  $qEx[0];     	
			 return $fileEXT;  
	
	}	
	
	private function get_mime_type($file)
{

        // our list of mime types
        $mime_types = array(
                "pdf"=>"application/pdf"
                ,"exe"=>"application/octet-stream"
                ,"zip"=>"application/zip"
                ,"docx"=>"application/msword"
                ,"doc"=>"application/msword"
                ,"xls"=>"application/vnd.ms-excel"
                ,"ppt"=>"application/vnd.ms-powerpoint"
                ,"gif"=>"image/gif"
                ,"png"=>"image/png"
                ,"jpeg"=>"image/jpg"
                ,"jpg"=>"image/jpg"
                ,"mp3"=>"audio/mpeg"
                ,"wav"=>"audio/x-wav"
                ,"mpeg"=>"video/mpeg"
                ,"mpg"=>"video/mpeg"
                ,"mpe"=>"video/mpeg"
                ,"mov"=>"video/quicktime"
                ,"avi"=>"video/x-msvideo"
                ,"3gp"=>"video/3gpp"
                ,"css"=>"text/css"
                ,"jsc"=>"application/javascript"
                ,"js"=>"application/javascript"
                ,"php"=>"text/html"
                ,"htm"=>"text/html"
                ,"html"=>"text/html"
                ,"phtml"=>"text/html"
                ,"py"=>"text/html"
        ); 
        $extension = $this->getExt($file);
 
        return $mime_types[$extension];
}
}