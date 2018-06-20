<?php
/*
  function db_connect() {
		$host = "localhost";
		$dbname = "codyitescia";
		$user = "root";
		$password = "";
		//$db = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
		$db = new PDO("mysql:host=$host;dbname=$dbname",$user,$password,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8", PDO::MYSQL_ATTR_DIRECT_QUERY=>true));
		return $db;
  }
*/


function db_connect() {
$db = new PDO('mysql:host=sql4.cluster1.easy-hebergement.net;dbname=codyitescia', 'codyitescia', 'codybdd',array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8", PDO::MYSQL_ATTR_DIRECT_QUERY=>true));
return $db;
}

?>