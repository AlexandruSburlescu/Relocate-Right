<?php
$date = date("Y-m-d H:i:s");
require 'database.php';
if(!isset($_SESSION))
{
    session_start();
}
if(!empty($_POST['email']) && !empty($_POST['password'])):
    //select the user from the table based on the email entered in the form
    $stat = "SELECT * FROM users WHERE email = :email";
    $records = $connection->prepare($stat);
    $records->bindParam(':email', $_POST['email']);
    $records->execute();
    $results = $records->fetch(PDO::FETCH_ASSOC);
    //check if the hashed password and the password in the form are a match
    $verify = password_verify($_POST['password'],$results['password']);
    //if the values match then modify the last login to the current date
    if(count($results) > 0 && $verify ){
        $sql = 'UPDATE users SET lastlogin = :date WHERE user_id = :id';
        $rec = $connection->prepare($sql);
        $rec->bindParam(':date', $date);
        $rec->bindParam(':id', $results['user_id']);
        $rec->execute();
        $name = $results['first_name'].' '. $results['last_name'];
        $_SESSION['user_id'] = $results['user_id'];
        $_SESSION['message'] = 'Welcome '.$name.'.';
        header("Location: /index.php");
    } else {
        echo 'Sorry, those credentials do not match';
        header("Location: /index.php");
    }
endif;
?>
<div class="row" id = "login-form">
    <form class="form-vertical" action="/users/login.php" method="POST">
        <div class="row form-group">
            <label class="control-label col-3 col-sm3" for="email" >Email: </label>
            <div class="col-8 col-sm8">
                <input type="email" class="form-control" id = "email" name="email" placeholder="Enter email" required>
            </div>
            <label class="col-1 col-sm1"></label>
        </div>
        <div class="row form-group">
            <label class="control-label col-3 col-sm3" for="password">Password: </label>
            <div class="col-8 col-sm8">
                <input type="password" class="form-control" id = "password" name="password" placeholder="Enter password" required>
            </div>
            <label class="col-1 col-sm1"></label>
        </div>
        <div class="row form-group">
            <label class = "col-2 col-sm2" for = "login-button" style = "display: ruby"> </label>
            <div class= "col-6 col-sm8">
                <button type="submit" class="button-submit" id="login-button">Login</button>
                <button type="submit" class="button-submit" id="register-button" onclick="return false">Register</button>
            </div>
            <label class = "col-4 col-sm2"> </label>
        </div>
    </form>
</div>
