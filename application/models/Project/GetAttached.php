<?php
class Application_Model_Project_GetAttached

{

public function items($id, $fetch){
	$pcOBJ = new Application_Model_DbTable_ProjectClients;
	$q = $pcOBJ->select();
	$q->where($fetch." = ?", $id);
	$res = $pcOBJ->fetchAll($q);
	return $res;	
	}
 
}