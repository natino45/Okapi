<?php

class ManageController extends Zend_Controller_Action
{

    public function init()
    {
        if (!Zend_Auth::getInstance()->hasIdentity()) { $this->_redirect('auth/'); }
		$acUser = new Zend_Session_Namespace(); 
		if($acUser->level!='admin'){$this->_redirect('preview/');}
		if(!$this->getRequest()->isXmlHttpRequest()){ $this->_helper->layout()->enableLayout(); }   
		 else{$this->_helper->layout()->disableLayout();} 
		 
    }

    public function indexAction()
    {
        $this->view->noAJmanage = true;
    }

    public function clientsAction()
    {
        $this->view->noAJclients = true;
		 $task = $this->_getParam("task"); 
		  $targetActionID = $this->_getParam("t"); 
	   switch($task){
		   case "attach":
		    $this->view->dis = "attach";
			$cu = new Application_Model_DbTable_Users; 
			$projectA = new Application_Model_DbTable_Projects; 
			 $pInfo = $cu->getUser($targetActionID);
			$cRes = $projectA->getProjects();
			$this->view->projects = $cRes;
			$this->view->userID = $targetActionID;
			$this->view->clientName = $pInfo->fullName;
			$this->view->clientEmail = $pInfo->email;
			
		   break;
		   
		   
		   
		   case "new":
		   $this->view->dis = "new";
		   break;
		   
		   case "del":
		   $this->view->dis = "del";
		   $t = $this->_request->getPost('target-id');
		    if ($this->getRequest()->isPost() && !empty($t)) {
			    $this->_helper->layout()->disableLayout();  
					$c = new Application_Model_DbTable_Users; 
					$c->delete("id = ".$t);
					$reviewsObj = new Application_Model_DbTable_Reviews;
					$DetachObj = new Application_Model_DbTable_ProjectClients;
					$reviewsObj->deleteUser($t);
					$DetachObj->deleteUser($t);
		   }
		   break;
		   
		   
		   default:
		   $this->view->dis = "list";
		   $usrObj = new Application_Model_DbTable_Users;
		   $res = $usrObj->fetchAll();
		   $this->view->clients = $res;
		   }
    }

    public function projectsAction()
    {
       $this->view->noAJmanpro = true;
	   $task = $this->_getParam("task"); 
	   $targetActionID = $this->_getParam("t"); 
	   switch($task){
		   case "attach":
		    $this->view->dis = "attach";
			$cu = new Application_Model_DbTable_Users; 
			$projectA = new Application_Model_DbTable_Projects; 
			 $pInfo = $projectA->getById($targetActionID);
			$cRes = $cu->getClients();
			$this->view->clients = $cRes;
			$this->view->projectID = $targetActionID;
			$this->view->projectName = $pInfo->projectName;
		   break;
		   
		   
		   case "new":
		   $this->view->dis = "new";
		   break;
		   
		   case "del":
		    $this->view->dis = "del";
		   $t = $this->_request->getPost('target-id');
		    if ($this->getRequest()->isPost() && !empty($t)) {
			    $this->_helper->layout()->disableLayout();  
					$p = new Application_Model_DbTable_Projects; 
					$p->delete("id = ".$t);
		   }
		   break;
		   
		   default:
		   $this->view->dis = "list";
		  $pObj = new Application_Model_DbTable_Projects;
		  $res = $pObj->getProjects();
		  $this->view->projectList = $res;
		   }
    }


}





