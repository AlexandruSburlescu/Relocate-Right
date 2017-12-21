<?php
$server = 'localhost';
$username = 'unn_w16037814';
$password = '1l3x1a9';
$database = 'unn_w16037814';

try{
	$connection = new PDO("mysql:host=$server;dbname=$database;", $username, $password);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e){
	die( "Connection failed: " . $e->getMessage());
}
?>