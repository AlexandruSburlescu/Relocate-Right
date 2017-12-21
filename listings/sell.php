<?php
if($_SERVER['REQUEST_METHOD'] == "POST"){
    $to = "sburlescu.alexandru@yahoo.co.uk"; // this is your Email address
    $from = $_POST['email']; // this is the sender's Email address
    $first_name = $_POST['fname'];
    $last_name = $_POST['lname'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $subject = "Evaluation request";
    $message = $first_name . " " . $last_name . " wrote the following:" . "\n\n" . $_POST['message'].
               "\n\n Address: ".$_POST['address']." and phone number: ".$_POST['phone'];
    $headers = "From:" . $from;
    mail($to,$subject,$message,$headers);
    echo "Mail Sent. Thank you " . $first_name . ", we will contact you shortly.";
    header("Location: /index.php");
}
require '../header.php';
?>
<div class = "row">
<?php
require '../body/left-reel.php';
?>
<div class="col-6 col-sm12 container">
    <div class ="evaluation-form">
        <div class = "row">
            <h3>Request evaluation</h3>
            Are you looking to sell your property?<br>
            Please request an evaluation by sending us the completed form below.
            One of our experts will contact you as soon as possible.
            <br>
            If you need any more information or have any questions, you can also use this form for enquiries.
        </div>
        <form class="form-vertical" action="/listings/sell.php" method="POST">
            <div class="row form-group">
                <label class="control-label col-3 col-sm3" for="fname" >Name: </label>
                <div class="col-8 col-sm8">
                    <input type="text" class="form-control" id = "fname" name="fname" placeholder="Enter your first name" required>
                </div>
                <label class="col-1 col-sm1"></label>
            </div>
            <div class="row form-group">
                <label class="control-label col-3 col-sm3" for="lname" >Name: </label>
                <div class="col-8 col-sm8">
                    <input type="text" class="form-control" id = "lname" name="lname" placeholder="Enter your last name" required>
                </div>
                <label class="col-1 col-sm1"></label>
            </div>
            <div class="row form-group">
                <label class="control-label col-3 col-sm3" for="email" >Email: </label>
                <div class="col-8 col-sm8">
                    <input type="email" class="form-control" id = "email" name="email" placeholder="Enter your email adress" required>
                </div>
                <label class="col-1 col-sm1"></label>
            </div>
            <div class="row form-group">
                <label class="control-label col-3 col-sm3" for="address" >Adress: </label>
                <div class="col-8 col-sm8">
                    <input type="text" class="form-control" id = "address" name="address" placeholder="Enter your address" required>
                </div>
                <label class="col-1 col-sm1"></label>
            </div>
            <div class="row form-group">
                <label class="control-label col-3 col-sm3" for="phone" >Phone number: </label>
                <div class="col-8 col-sm8">
                    <input type="text" class="form-control" id = "phone" name="address" placeholder="Enter your phone number" required>
                </div>
                <label class="col-1 col-sm1"></label>
            </div>
            <div class="row form-group">
                <label class="control-label col-3 col-sm3" for="message">Message: </label>
                <div class="col-8 col-sm8">
                    <textarea type="text" class="form-control" id = "evaluation-message" name="message" placeholder="Enter message" rows="6" required></textarea>
                </div>
                <label class="col-1 col-sm1"></label>
            </div>
            <div class="row form-group">
                <label class = "col-2 col-sm2" for = "evaluation-button" style = "display: ruby"> </label>
                <div class= "col-6 col-sm6">
                    <button type="submit" class="button-submit" id="evaluation-button">Send</button>
                </div>
                <label class = "col-4 col-sm4"> </label>
            </div>
        </form>
    </div>
</div>
<?php
require '../body/right-reel.php';
?>
</div>
<?php
require '../footer.php';
?>