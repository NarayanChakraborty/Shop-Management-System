<?php
$dbhost="localhost";
$dbname="walton";
$dbuser="root";
$dbpass="";

try{
 $db=new PDO("mysql:host=$dbhost;dbname=$dbname",$dbuser,$dbpass);
 $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
 }
 catch(PDOException $e)
 {
    echo "Connection Error".$e->getMessage();
	}
?>