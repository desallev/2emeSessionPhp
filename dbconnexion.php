<?php
	session_start();
	//////////////////////////////////////
	// connexion
	//////////////////////////////////////
	header('Content-type: text/html; charset=utf-8'); 
	/*** mysql hostname ***/
	$hostname = 'localhost';
	/*** mysql username ***/
	$dbusername = 'root';
	/*** mysql password ***/
	$password = "";
	/*** mysql database ***/
	$databaseName="tutoriel_membres";

	try {
	   $db = new PDO("mysql:host=$hostname;dbname=$databaseName", $dbusername,$password);
	   $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
	}
	catch(PDOException $e){
	    echo $e->getMessage();
	}
?>