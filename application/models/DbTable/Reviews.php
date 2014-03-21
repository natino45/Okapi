<?php

class Application_Model_DbTable_Reviews extends Zend_Db_Table_Abstract
{

    protected $_name = 'reviews';
	public function addNew($data){
		$this->insert($data);
		}
	public function getReviews($id, $target){
		$q = $this->select();
		$q->where($target." = ?", $id);
		$q->order("dateCreated DESC");
		return $this->fetchAll($q);
		
		}
		
	public function getAll(){
		
		}
	
	public function deleteUser($id){
		$this->delete("user_ID = ".$id);
		}

}

