<?php

class Application_Model_DbTable_Projects extends Zend_Db_Table_Abstract
{

    protected $_name = 'projects';
	 
	
	public function getById($id){
		$id = (int)$id;
	$row = $this->fetchRow( 'id = ' . $id );
	return $row;
		}
	
	
	public function getProjects($userID="", $active=""){
		
		
		$query = $this->select();
		//$query->where('active = 1');
		$query->order("dateCreated DESC");
		$result = $this->fetchAll($query);
		return $result;
		
		
		}

}

