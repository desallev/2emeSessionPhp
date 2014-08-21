<?php
session_start();
header('Content-type: text/html; charset=utf-8'); 
//////////////////////////////////////
// connexion
//////////////////////////////////////

/*** mysql hostname ***/
$hostname = 'localhost';
/*** mysql username ***/
$username = 'vincentdesalle';
/*** mysql password ***/
$password = "aSsxHZE3wHQNC5sd";
/*** mysql database ***/
$databaseName="vincentdesalle";

try {
   $db = new PDO("mysql:host=$hostname;dbname=$databaseName", $username,$password);
   $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    }
catch(PDOException $e)
    {
    echo $e->getMessage();
    }
?>