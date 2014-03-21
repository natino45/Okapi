<?php

class Application_Model_DbTable_Users extends Zend_Db_Table_Abstract
{

 protected $_name = 'users';
 public function getUser($id){
	$id = (int)$id;
	$row = $this->fetchRow( 'id = ' . $id );
	return $row;
	}
 
 	
public function addUser($userData){
		return $this->insert($userData);	 	
	}
	
public function updateUser($id, $email, $password){
			$this->update($this->tblColumnNames($email, $password), 'id = ' . (int)$id);
	 }

public function deleteUser($id){
	$this->delete('id = '. (int) $id);
	}
	
public function getUserByEmail($email){
	$query = $this->select();
 	$query->where('email = ?', $email);
 	$result = $this->fetchRow($query);
 	return $result;
 }
 
 public function getClients(){
	 $q = $this->select()->where("level = 'client'");
	return $this->fetchAll($q);
	 }	

}

