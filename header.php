<?php

require '/relocate-right/users/database.php';

$user = NULL;

if( isset($_SESSION['user_id']) ) {

$sql = 'SELECT user_id, first_name, last_name FROM users WHERE user_id = :id';
$records = $connection->prepare($sql1);
$records->bindParam(':id', $_SESSION['user_id']);
$records->execute();
$results = $records->fetch(PDO::FETCH_ASSOC);
    if (count($results) > 0) {
    $user = $results;
    }
}
?>

<header>
    <div class="container header">
        <div class="row">
            <div class="col-3">
                <div class="logo-text" id="logo-pic">
                    <img src="img/logo.png"  alt="Logo" id="logo" style="horizo">Relocate Right
                </div>
            </div>
            <div class ="col-9">

                <label for="left-menu"></label>

                    <div id ="left-menu">
                        <ul>
                            <li><a href="/relocate-right/index.php" class="button">Home</a></li>
                            <?php
                            if( !isset($_SESSION['user_id']) ){
                            echo '<li><a href="/relocate-right/users/register.php" class="button">Register</a></li>
                                  <li><a href="/relocate-right/listings/buy.php" class="button">Buy</a></li>
                                  <li><a href="/relocate-right/about.php" class="button">About</a></li>
                                  <li><a href="/relocate-right/users/logout.php" class="button">Logout</a></li>   
                                  <li><a href="/relocate-right/listings/rent.php" class="button">Rent</a></li>
                                  <li><a href="/relocate-right/listings/sell.php" class="button">Sell</a></li>';
                            }
                            else {
                                echo '<li><a href="/relocate-right/users/register.php" class="button">Register</a></li>
                                  <li><a href="/relocate-right/listings/buy.php" class="button">Buy</a></li>
                                  <li><a href="/relocate-right/about.php" class="button">About</a></li>
                                  <li><a href="/relocate-right/users/logout.php" class="button">Logout</a></li>   
                                  <li><a href="/relocate-right/listings/rent.php" class="button">Rent</a></li>
                                  <li><a href="/relocate-right/listings/sell.php" class="button">Sell</a></li>';

                            }?>

                        </ul>
                    </div>
            </div>


            </div>
        <div class="row">
            <label class = "col-2" for = "heading text-center"></label>
            <div class="heading text-center col-8 fade">
                <h2>Relocate right - Find your perfect home.</h2>
                <?php
                if (!isset ($_SESSION['message'])) {
                    echo('<p> Please login here using your email and password.</p>');
                    } else {
                    echo($_SESSION['message']);
                }
                ?>
            </div>
            <label class = "col-2"> </label>
        </div>

    </div>
</header>