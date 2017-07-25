<?php

include_once 'dbconfig.php';

$mysqli = new MySQLi(HOST, USER, PASSWORD, DATABASE);

if($mysqli->connect_error) {
	
	header("Location:../error.php?err=Unable to connect to MySQL");
	
	exit();
}