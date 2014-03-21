<?php

class AuthController extends Zend_Controller_Action
{

    public function init()
    {
		
        $this->_helper->layout()->disableLayout();
    }

    public function indexAction()
    {
		if (Zend_Auth::getInstance()->hasIdentity()) { $this->_redirect('preview/project/'); }
        if ($this->getRequest()->isPost()) {
			$email = $this->_request->getPost('user-e');
			$password = $this->_request->getPost('user-p');
			 
					 $authAdapter = new Zend_Auth_Adapter_DbTable($this->db);
					 $authAdapter->setTableName('users');
					 
					 $authAdapter->setIdentityColumn('email');
					 $authAdapter->setCredentialColumn('password');
					 
					 $authAdapter->setCredentialTreatment('MD5(?)');
					 
					 $authAdapter->setIdentity($email);
					 $authAdapter->setCredential($password);
					 
					 $auth = Zend_Auth::getInstance();
					 $result = $auth->authenticate($authAdapter);
					 
					 if ($result->isValid()) {
						 $users = new Application_Model_DbTable_Users();
						$userRes = $users->getUserByEmail($email);
						 $userRes->lastLogin = date('Y-m-d H:i:s');
						 $userRes->save();
								//	$storage = $auth->getStorage();
								//	$storage->write($authAdapter->getResultRowObject( array('id', 'userName' , 'userRole' )));
							
									
							 //Client Info
							 $activeUser = new Zend_Session_Namespace();
							 $activeUser->userID = $userRes->id; 
							 $activeUser->fullName = $userRes->fullName;
							 $activeUser->level = $userRes->level;
							 $activeUser->email = $userRes->email;
							 
							 
							 $this->_redirect("preview");
					 } else {
						$this->view->valid = "noooo";
						$this->view->errorForm = "Email &amp; Password  Error."; 
					
					 }
		}
		
    }

    public function outAction()
    {
         $authAdapter = Zend_Auth::getInstance();
		$authAdapter->clearIdentity();
		$this->_redirect("auth");
    }

    public function settingsAction()
    {
        if(!$this->getRequest()->isXmlHttpRequest()){ $this->_helper->layout()->enableLayout(); }
		$acUser = new Zend_Session_Namespace(); 
		$this->view->noAJsettings = true;
		$userObj = new Application_Model_DbTable_Users;
		$uRes = $userObj->getUser($acUser->userID);
		$this->view->fName = $uRes->fullName;
		$this->view->notes = $uRes->notes;
		
		 
    }

    public function inAction()
    {
		$acUser = new Zend_Session_Namespace(); 
		 if ($this->getRequest()->isPost()) {
			 		//Incoming Variables
					$target = $this->_request->getPost('target');
     			  $oldPass = $this->_request->getPost('old-pass'); 
     			  $newPass = $this->_request->getPost('new-pass'); 
     			  $fullName = $this->_request->getPost('f-name'); 
     			  $uNotes = $this->_request->getPost('notes'); 
     			  $uEmail = $this->_request->getPost('email'); 
     			  $folderName = $this->_request->getPost('folder-name'); 
     			  $projectName = $this->_request->getPost('pro-name'); 
     			  $projectsAttached = $this->_request->getPost('projects-attached'); 
     			  $clientDetails = $this->_request->getPost('client-details');
     			  $bootLoaderFile = $this->_request->getPost('bLoader');
				  //Attachments
				  $idToAttach = $this->_request->getPost('selectedOptions'); 
				  $clientID =$this->_request->getPost('uid');
				  $projectID =$this->_request->getPost('pid');
				  //Reviews
				  $reviewContent = $this->_request->getPost('commentval');
				 
				  
				  switch($target){
					  case "personal":
					  $outc = $this->personalInfo($acUser->userID, $fullName, $uNotes);
					   if($outc) $this->view->success=true;
					   $this->view->noreload = true;
					  break;
					  
					  case "cred":
					  $outc = $this->credUpdate($acUser->userID,$oldPass, $newPass);
					  if($outc) $this->view->success=true;
					  break;
					  
					  case "nclient":
					  $inId = $this->newClient($fullName, $uEmail);
					  if($inId) $this->view->success=true;
					  break;
					  
					  case "npro":
					  $insertID = $this->newProject($projectName,$folderName, $clientDetails, $bootLoaderFile);
					   if($insertID) $this->view->success=true;
					  break;
					  
					  
					  //Projects Attachments
					  case "pattach": 
					  $this->view->noreload = false;
					  $attt = $this->iniAttachment($clientID,$idToAttach,'projects');
					  if($attt)$this->view->success=true;
					  break;
					  
					  //Clients Attachments
					  case "cattach": 
					  $this->view->noreload = false;
					   $attt = $this->iniAttachment($projectID,$idToAttach,'clients');
					  if($attt)$this->view->success=true;
					  break;
					  
					  case "comments": 
					   $this->view->noreload = true;
					  $revOut = $this->newReview($projectID, $acUser->userID, $reviewContent);
					  if($revOut){$this->view->success=true; }
					  $this->view->output = "Thank you! Your comments have been sent successfully.";
					  break;
					  
					  case "recover":
					  $this->view->noreload = true;
					  $restOut = $this->recoverPassword($uEmail);
					  $this->view->success=true;
					  break;
					  
					  default:
					  $this->view->target = 0;
					  }
		 }
		 
    }
	private function recoverPassword($email){
		if(!empty($email)){
			$userObj = new Application_Model_DbTable_Users;
			$uRes = $userObj->getUserByEmail($email);
			if($uRes){
				$upass = substr(md5(date('Y-m-d H:i:s')),0,8);
				$uRes->password = md5($upass);
				$uRes->save();
		//Mail
		$mail = new Zend_Mail();	
		$mail->setFrom("no-reply@dev45.net");  
		$mail->addTo($email);
		$mail->setSubject("Confidential: Account Recovery ");
		$emailBody = "
Dear Client,

You have reguested a password change on our system, please find below your new password.

Login Credentials:
 
Password : ".$upass."
(You can choose a new password when you login) 

	
Regards,
The Okapi Development Team.

 
";
		$mail->setBodyText($emailBody);
		$mail->send();
		return 1;		
				}else return 0;
			}else return 0;
		}

    private function credUpdate($uID, $oldpass, $newPass)
    {
		$newPass = md5($newPass);
		$oldpass = md5($oldpass);
		$userObj = new Application_Model_DbTable_Users;
		 $where['id = ?'] = $uID;
		 $where['password = ?'] = $oldpass;
		$upout = $userObj->update(array( "password" => $newPass
									), $where);
									if($upout) return 1; 
									else return 0;
		} // Login information editor
    

    private function personalInfo($uID, $fullName, $notes)
    {
		$userObj = new Application_Model_DbTable_Users;
		 $where['id = ?'] = $uID;
		$out = $userObj->update(array(
								"fullName" => $fullName,
								"notes" => $notes
								), $where);
								if($out) return 1; 
									else return 0;
		}  //Personal Information
    

    private function newProject($title, $folder, $clientDetails, $bootLoaderFile)
    {
		 $proObj = new Application_Model_DbTable_Projects;
		 $inID = $proObj->insert(array(
		 					'folderName' => $folder,
							'bootLoader' =>  $bootLoaderFile,
							'projectName'=> $title,
							'clientDetails'=> $clientDetails,
							'dateCreated' => date('Y-m-d H:i:s'),	 
		 					));
						return $inID;
		}//New project additions
    

    private function newClient($fName, $emailAdd)
    {
		$userOBJ = new Application_Model_DbTable_Users;
		$upass = substr(md5(date('Y-m-d H:i:s')),0,8);
		$userID = $userOBJ->insert(
								array("fullName" => $fName,
								"email" => $emailAdd,
								"level" => "client",
								"password" => md5($upass),
								"dateCreated" => date('Y-m-d H:i:s'),
								));
$mail = new Zend_Mail();	
		$mail->setFrom("no-reply@dev45.net");  
		$mail->addTo($emailAdd);
		$mail->setSubject("Confidential: Access details from Okapi ");
		$emailBody = "
		
Dear Client,

Okapi Project Preview System 

In order to serve you better with your projects, we have created a Project Viewing System that you can access for collaboration. Please find below your login credentials to access the System.

Login Credentials:

Web Address: http://www.dev45.net

Registered E-Mail: ".$emailAdd."

Password : ".$upass."
(You can choose a new password when you login) 

If you have any questions please email info@dev45.net


Regards,
The Okapi Development Team.
		";
		$mail->setBodyText($emailBody);
		$mail->send();								
			return $userID;
		} //new clients additions
    

    private function iniAttachment($targetID, $attVals, $aType)
    {
		
					$attObj = new Application_Model_DbTable_ProjectClients;
				if(!empty($attVals)){
								$idEX = explode(',',$attVals); 
								switch($aType){
									case "projects":
									$attObj->detachAll($targetID, "user_ID");
									for($i =0; $i < count($idEX); $i++){
										if(!empty($idEX[$i]))$attObj->attachIt($targetID, $idEX[$i]); 
											 
										} return 1;
									break;
									
									case "clients": 
									$attObj->detachAll($targetID, "project_ID");
										for($i =0; $i < count($idEX); $i++){
										if(!empty($idEX[$i]))$attObj->attachIt( $idEX[$i],$targetID); 
										} return 1;
									break;
									
									default:
									return 0;
									}				 
						  } else {
							  switch($aType){
							  case "projects":
							  $attObj->detachAll($targetID, "user_ID");return 1;
							  break;
							  case "clients":
							  $attObj->detachAll($targetID, "project_ID");return 1;	
							  break;
							  default:
									return 0;
							  }
							  };
		} //Project and clients attachements
    

    private function newReview($projectID, $userID, $content)
    {
		if(!empty($projectID) && !empty($userID) && !empty($content)){
		$comObj = new Application_Model_DbTable_Reviews;
		$exData = array(
					  				"Browser" => $_SERVER['HTTP_USER_AGENT'],
									"IP" => $_SERVER['REMOTE_ADDR'],
									);
						$exDataJSON = json_encode($exData);	
		$revData = array(
							"project_ID" => $projectID,
							"user_ID" => $userID,
							"reviewContent" => $content,
							"extraData" => $exDataJSON,
							"dateCreated" =>  date('Y-m-d H:i:s'),
							);
			$comObj->addNew($revData);
			return 1;
		}else return 0;
	} //Reviews and Comments
    

    public function recoverAction()
    {
        if(!$this->getRequest()->isXmlHttpRequest()){ $this->_helper->layout()->enableLayout(); }
		
    }


}









