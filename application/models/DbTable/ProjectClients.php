<?php

class Application_Model_DbTable_ProjectClients extends Zend_Db_Table_Abstract
{

    protected $_name = 'project_clients'; 

public function getClientProject($userID){ 
		
		$query = $this->select(); 
		$query->where('user_ID = ?', $userID); 
		$query->order("project_ID DESC");
		$result = $this->fetchAll($query);
		return $result;
		
		 		
		}

public function check($userID, $projectID){
	$query = $this->select(); 
		$query->where('user_ID = ?', $userID); 
		$query->where('project_ID = ?', $projectID);  		 
		$result = $this->fetchRow($query);
		if($result) return 1;
		else return 0;
	}

public function attachIt($userID, $projectID){
	$this->insert(array(
						"user_ID" => $userID,
						"project_ID" => $projectID 
						));
	}

public function detachAll($id, $target){
	if(!empty($id) && !empty($target))$this->delete($target." = ".$id);	
	}

public function deleteUser($id){
		$this->delete("user_ID = ".$id);
		}
}

