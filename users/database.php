<?php
$server = 'localhost';
$username = 'root';
$password = '';
$database = 'relocate-right';

try{
	$connection = new PDO("mysql:host=$server;dbname=$database;", $username, $password);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e){
	die( "Connection failed: " . $e->getMessage());
}
?>