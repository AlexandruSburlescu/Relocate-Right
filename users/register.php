<?php

require 'database.php';

if (!empty($_POST['password'])&& !empty($_POST['confirm_password']) ) {
    $verify = $_POST['password'] == $_POST['confirm_password'];
    if(!empty($_POST['email']) && $verify && !empty($_POST['fname'])&& !empty($_POST['lname'])):
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
            $_SESSION['message'] = 'Successfully created new user';
            header("Location: /index.php");
        } else {
            $_SESSION['message'] = 'Username and/or password are incorrect or already in use.';
            header("Location: /index.php");
        }
    endif;
}
?>
<div class="row" id="register-form" style = "display:none">
    <div class="data-form">
        <form class="form-vertical" action= "/users/register.php" method="POST">
        <div class="form-group">
            <label class="control-label col-4 col-sm4" for="fname">First Name:</label>
            <div class="col-8 col-sm8">
                <input type="text" class="form-control" id = "fname" name="fname" placeholder="Enter your first name" required>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-4 col-sm4" for="lname">Last Name:</label>
            <div class="col-8 col-sm8">
                <input type="text" class="form-control" id = "lname" name="lname" placeholder="Enter your last name" required>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-4 col-sm4" for = "email">Email: </label>
            <div class="col-8 col-sm8">
                <input type= "email" class= "form-control" id = "register-email" name= "email" placeholder="Enter email" required>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-4 col-sm4" for = "password">Password: </label>
            <div class="col-8 col-sm8">
                <input type= "password" class= "form-control" id = "register-password" name= "password" placeholder="Enter password" required>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-4 col-sm4">Confirm Password: </label>
            <div class="col-8 col-sm8">
                <input type= "password" class= "form-control" name= "confirm_password" placeholder="Confirm password" required>
            </div>
        </div>
        <div class="form-group">
            <div class="col-2">
                <button type="submit" class="button-submit">Register</button>
            </div>
        </div>
        </form>
    </div>
</div>
