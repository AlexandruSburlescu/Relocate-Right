<?php

$date = date("Y-m-d H:i:s");
if( isset($_SESSION['user_id']) ){
    header("Location: /index.php");
}

require 'users/database.php';
$_SESSION['message'] = '';
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
        $_SESSION['message'] = 'Welcome '.$name.' Please click <a href="/users/logout.php">here</a> to logout.';
        header("Location: /index.php");

    } else {
        $_SESSION['message'] = 'Sorry, those credentials do not match';
    }

endif;

?>
<div class = "container col-6">
    <div class="row login">
        <div class="data-form">
            <form class="form-vertical" action="<?=$_SERVER["PHP_SELF"]?>" method="POST">
                <div class="row form-group">
                    <label class="control-label col-2" for="email">Email: </label>
                    <div class="col-8">
                        <input type="email" class="form-control" id = "email" name="email" placeholder="Enter email">
                    </div>
                    <label class="col-2"></label>
                </div>
                <div class="row form-group">
                    <label class="control-label col-2" for="password">Password: </label>
                    <div class="col-8">
                        <input type="password" class="form-control" id = "password" name="password" placeholder="Enter password">
                    </div>
                    <label class="col-2"></label>
                </div>
                <div class="row form-group">
                    <label class = "col-6" for = "submit button" style = "display: ruby"> </label>
                    <div class= "col-4">
                        <input type="submit" class="button-submit" id="submit-button"></input>
                    </div>
                    <div class = "col-4"> </div>
                </div>
            </form>
        </div>
    </div>
</div>