<?php

session_start();

if( isset($_SESSION['user_id']) ){
    header("Location: index.php");
}

require 'database.php';

if (!empty($_POST['password'])&& !empty($_POST['confirm_password']) ) {
    $verify = $_POST['password'] == $_POST['confirm_password'];



    if(!empty($_POST['email']) && $verify && !empty($_POST['fname'])&& !empty($_POST['lname'])):

        $message = '';

        $hash = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $name = $_POST['fname'] . " " .$_POST['lname'];

        // Enter the new user in the database
        $sql = "INSERT INTO members (email, password, name) VALUES (:email, :password, :name)";
        // Check if Email exists in database
        $sql2 = "SELECT email FROM members WHERE email = :email";


        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':email', $_POST['email']);
        $stmt->bindParam(':password', $hash);
        $stmt->bindParam(':name', $name);

        $echeck = $conn->prepare($sql2);
        $echeck->bindParam(':email', $_POST['email']);

        $echeck->execute();
        $fcheck = $echeck->fetchAll(PDO::FETCH_ASSOC);

        // if User does not exist it inserts it into the database
        if( !count($fcheck) > 0 ){
            $stmt->execute();
            $message = 'Successfully created new user';
        } else {
            $message = 'Username and/or password are incorrect or already in use.';
        }

    endif;
}
?>

<div class="contact-form wow fadeIn" data-wow-duration="1000ms" data-wow-delay="600ms">
    <div class="row">
        <div class="col-sm-6">
            <form class="form-horizontal" action= "register.php" method="POST">
                <div class="form-group">
                    <label class="control-label col-sm-4" for="fname">First Name:</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id = "fname" name="fname" placeholder="Enter your first name">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4" for="lname">Last Name:</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id = "lname" name="lname" placeholder="Enter your last name">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4" for = "email">Email: </label>
                    <div class="col-sm-8">
                        <input type= "email" class= "form-control" id = "email" name= "email" placeholder="Enter email">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4" for = "password">Password: </label>
                    <div class="col-sm-8">
                        <input type= "password" class= "form-control" id = "password" name= "password" placeholder="Enter password">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4">Confirm Password: </label>
                    <div class="col-sm-8">
                        <input type= "password" class= "form-control" name= "confirm_password" placeholder="Confirm password">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-submit">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
