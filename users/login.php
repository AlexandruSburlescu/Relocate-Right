<?php

session_start();
$date = date("Y-m-d H:i:s");
if( isset($_SESSION['user_id']) ){
    header("Location: index.php");
}

require 'database.php';

if(!empty($_POST['email']) && !empty($_POST['password'])):
    //select the user from the table based on the email entered in the form
    $stat = "SELECT memberID,email,password FROM members WHERE email = :email";
    $records = $conn->prepare($stat);
    $records->bindParam(':email', $_POST['email']);
    $records->execute();
    $results = $records->fetch(PDO::FETCH_ASSOC);

    $_SESSION['message'] = '';
    //chech if the hashed password and the password in the form are a match
    $verify = password_verify($_POST['password'],$results['password']);
    //if the values match then modify the last login to the current date
    if(count($results) > 0 && $verify ){
        $sql = 'UPDATE members SET lastlogin = :date WHERE memberID = :id';
        $rec = $conn->prepare($sql);
        $rec->bindParam(':date', $date);
        $rec->bindParam(':id', $results['memberID']);
        $rec->execute();
        $_SESSION['user_id'] = $results['memberID'];
        header("Location: index.php");

    } else {
        $_SESSION['message'] = 'Sorry, those credentials do not match';
    }

endif;

?>

<section id="allmusic" class="parallax">
    <div class="container">
        <div class="row">
            <div class="heading text-center col-sm-8 col-sm-offset-2 wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="300ms">
                <h2>Our music, Your way.</h2>
                <?php if( !isset($_SESSION['user_id']) ) {  ?>
                    <p> Please login here using your email and password.</p>
                <?php } else { ?>
                    <p> You are already logged in. Select your favourite music and add it to your personalised playlist.</p> <?php } ?>
            </div>
        </div>
        <div class="contact-form wow fadeIn" data-wow-duration="1000ms" data-wow-delay="600ms">
            <div class="row">
                <div class="col-sm-6">
                    <form class="form-vertical" action="login.php" method="POST">
                        <div class="form-group">
                            <label class="control-label col-sm-4" for="email">Email: </label>
                            <div class="col-sm-8">
                                <input type="email" class="form-control" id = "email" name="email" placeholder="Enter email">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4" for="password">Password: </label>
                            <div class="col-sm-8">
                                <input type="password" class="form-control" id = "password" name="password" placeholder="Enter password">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn-submit">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</section>
