<?
$server = 'localhost';
$username = 'root';
$password = '';
$database = 'relocate_right';

try{
	$conn = new PDO("mysql:host=$server;dbname=$database;", $username, $password);
} catch(PDOException $e){
	die( "Connection failed: " . $e->getMessage());
}
