<?php

require 'users/database.php';

$user = NULL;
session_start();
if( isset($_SESSION['user_id']) ) {

    $sql = 'SELECT * FROM users WHERE user_id = :id';
    $records = $connection->prepare($sql);
    $records->bindParam(':id', $_SESSION['user_id']);
    $records->execute();
    $results = $records->fetch(PDO::FETCH_ASSOC);
    if (count($results) > 0) {
        $user = $results;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Relocate Right - Estate Agency</title>
    <meta name="viewport" content="width=device-width"/>
    <meta charset="utf-8" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="/css/main.css" />
    <link href="https://fonts.googleapis.com/css?family=Lato|Montserrat|Open+Sans|Roboto" rel="stylesheet">
</head>
<body>
<header>
    <div class="header container">
        <div class="row">
            <div class="col-3">
                <div class="logo-text" id="logo-pic">
                    <img src="/img/logo.png"  alt="Logo" id="logo">
                </div>
            </div>
            <div class ="col-9">
                <label for="left-menu"></label>
                    <div id ="left-menu">
                        <ul>
                            <li><a href="/index.php" class="button">Home</a></li>
                            <?php
                            if( !isset($_SESSION['user_id']) ){
                                echo '
                                      <li><a href="/listings/buy.php" class="button">Buy</a></li>                                 
                                      <li><a href="/listings/rent.php" class="button">Rent</a></li>
                                      <li><a href="/about.php" class="button">About</a></li>  
                                       <li><a href="/users/register.php" class="button">Register</a></li>
                                      ';
                            }
                            else {
                                echo ' 
                                      <li><a href="/listings/rent.php" class="button">Rent</a></li>
                                      <li><a href="/listings/sell.php" class="button">Sell</a></li>
                                      <li><a href="/listings/buy.php" class="button">Buy</a></li>   
                                      <li><a href="/about.php" class="button">About</a></li>                                                          
                                 ';

                            }?>

                        </ul>
                    </div>
            </div>


            </div>

    </div>
</header>