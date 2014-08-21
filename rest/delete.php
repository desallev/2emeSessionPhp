<?php
include('dbconnexion.php');

$_SESSION['id']=$id = $_GET['id'];
if($pageOwner = true){
		
		$delete=$db->prepare("DELETE FROM membres WHERE id=$id");
		$delete=$delete->bindValue(':id',$id,PDO::PARAM_INT);
		$delete=$delete->execute();
		header("Location: supp.php");	
}


?>
