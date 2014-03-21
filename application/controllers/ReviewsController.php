<?php

class ReviewsController extends Zend_Controller_Action
{

    public function init()
    {
        if (!Zend_Auth::getInstance()->hasIdentity()) { $this->_redirect('auth/'); }
		if(!$this->getRequest()->isXmlHttpRequest()){ $this->_helper->layout()->enableLayout(); }   
		 else{$this->_helper->layout()->disableLayout();} 
		 
		 $ac = $this->_getParam('action');
		if(is_numeric($ac))	$this->_forward("index");
		
    }

    public function indexAction()
    {
         $pid = $this->_getParam('action');
		 if($pid !=0){
		 $this->view->project = $pid;
		 $this->view->showForm = true;
		 }else{
			 
			 }
    }

    public function readAction()
    {
        $targetID = $this->_getParam('t');
        $getWhat = $this->_getParam('g');
		if(!empty($targetID) && !empty($getWhat)){
			$rObj = new Application_Model_DbTable_Reviews;
			switch($getWhat){
				case "client":
				$userOBJ = new Application_Model_DbTable_Users;
				$userInfo =  $userOBJ->getUser($targetID);
				$pRes =  $rObj->getReviews($targetID, 'user_ID');
				if($pRes) $this->view->projectsReviews = $pRes;
				$this->view->success = 1;
				$this->view->targetName = $userInfo->fullName." - ". $userInfo->email;
				$this->view->targetType= "client";
				break;
				
				case "project":
				$projectObj = new Application_Model_DbTable_Projects;
				$pinfo = $projectObj->getById($targetID);
				$pRes =  $rObj->getReviews($targetID, 'project_ID');
				if($pRes) $this->view->projectsReviews = $pRes;
				$this->view->success = 1;
				$this->view->targetName =$pinfo->projectName;
				break;
				
				default:
				$this->view->success = 0;
				}
			}
    }


}



