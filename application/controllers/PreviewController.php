<?php

class PreviewController extends Zend_Controller_Action
{

    public function init()
    {
       if (!Zend_Auth::getInstance()->hasIdentity()) { $this->_redirect('auth/'); }
    }

    public function indexAction()
    {
		$acUser = new Zend_Session_Namespace(); 
		if(!$this->getRequest()->isXmlHttpRequest()){ $this->_helper->layout()->enableLayout(); }   
		 else{$this->_helper->layout()->disableLayout();} 
        $pObj = new Application_Model_DbTable_Projects;
		$clientObj = new Application_Model_DbTable_ProjectClients;
		
		($acUser->level == 'admin')?$res = $pObj->getProjects(): $res = $clientObj->getClientProject($acUser->userID);
		
	
		$this->view->projectList = $res;
		$this->view->noAJpre = true;
    }

    public function projectAction()
    {
        $projectID = (int)$this->_getParam("v");
        $target = $this->_getParam("target"); 
		
	   $fullUrl = $_SERVER['REQUEST_URI'];
		$exVal = explode("/f/",$fullUrl,2);
		$fileToView = $exVal[1];
		
		
		
		if(!empty($projectID)){
			$dir = new Application_Model_Project_GetProject;
			$iFrameOBJ = new Application_Model_Project_Iframe;
			$reviewObj = new Application_Model_DbTable_Reviews;
			$this->view->letItFade = true;
			 
			$this->view->projectID = $projectID;
			$this->view->numberOfComments = " (".count($reviewObj->getReviews($projectID,"project_ID")).") ";
			if($target == 'iframe'){
				$this->_helper->layout()->disableLayout(); 
				$this->view->display = 'ifc';
				
				$this->view->projectContent = $dir->getProject($projectID,$fileToView);
				}
			}else{ $this->_redirect('preview');}
    }


}



