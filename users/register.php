<?php

if( isset($_SESSION['user_id']) ){
    header("Location: /relocate-right/index.php");
}

require 'database.php';

if (!empty($_POST['password'])&& !empty($_POST['confirm_password']) ) {
    $verify = $_POST['password'] == $_POST['confirm_password'];



    if(!empty($_POST['email']) && $verify && !empty($_POST['fname'])&& !empty($_POST['lname'])):

        $message = '';

        $hash = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $first_name = $_POST['fname'];
        $last_name = $_POST['lname'];

        // Enter the new user in the database
        $sql = "INSERT INTO users (email, password, first_name, last_name) VALUES (:email, :password, :firstname, :lastname)";
        // Check if Email exists in database
        $sql2 = "SELECT email FROM users WHERE email = :email";


        $stmt = $connection->prepare($sql);
        $stmt->bindParam(':email', $_POST['email']);
        $stmt->bindParam(':password', $hash);
        $stmt->bindParam(':firstname', $first_name);
        $stmt->bindParam(':lastname', $last_name);

        $echeck = $connection->prepare($sql2);
        $echeck->bindParam(':email', $_POST['email']);

        $echeck->execute();
        $fcheck = $echeck->fetchAll(PDO::FETCH_ASSOC);

        // if User does not exist it inserts it into the database
        if( !count($fcheck) > 0 ){
            $stmt->execute();
            $message = 'Successfully created new user';
            $message .- 'Please click here to login <a href = '.header("Location: /relocate-right/users/login.php".'>.</a>');
        } else {
            $message = 'Username and/or password are incorrect or already in use.';
        }

    endif;
}
require '../header.php';
?>
<div class = "row">
<?php
require '../body/left-reel.php';
?>
<div class = "container col-6">
    <div class="row login">
        <div class="data-form">
            <form class="form-vertical" action= "<?=$_SERVER["PHP_SELF"]?> method="POST">
                <div class="form-group">
                    <label class="control-label col-4" for="fname">First Name:</label>
                    <div class="col-8">
                        <input type="text" class="form-control" id = "fname" name="fname" placeholder="Enter your first name">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-4" for="lname">Last Name:</label>
                    <div class="col-8">
                        <input type="text" class="form-control" id = "lname" name="lname" placeholder="Enter your last name">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-4" for = "email">Email: </label>
                    <div class="col-8">
                        <input type= "email" class= "form-control" id = "email" name= "email" placeholder="Enter email">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-4" for = "password">Password: </label>
                    <div class="col-8">
                        <input type= "password" class= "form-control" id = "password" name= "password" placeholder="Enter password">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-4">Confirm Password: </label>
                    <div class="col-8">
                        <input type= "password" class= "form-control" name= "confirm_password" placeholder="Confirm password">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-2">
                        <button type="submit" class="btn btn-submit">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php
require '../body/right-reel.php';
?>
</div>
<?php
require '../footer.php';
?>
