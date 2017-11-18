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

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>VDj - Playlist manager</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="css/animate.min.css" rel="stylesheet"> 
  <link href="css/font-awesome.min.css" rel="stylesheet">
  <link href="css/lightbox.css" rel="stylesheet">
  <link href="css/main.css" rel="stylesheet">
  <link id="css-preset" href="css/presets/preset1.css" rel="stylesheet">
  <link href="css/responsive.css" rel="stylesheet">

  <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
  <![endif]-->
  
  <link href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700' rel='stylesheet' type='text/css'>
  <link rel="shortcut icon" href="images/favicon.ico">
</head><!--/head-->

<body>

<header class="container">
<div class="main-nav">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php">
            <h1><img class="img-responsive" src="images/logo.png" alt="logo"></h1>
          </a>                    
        </div>
        <div class="collapse navbar-collapse">
          <ul class="nav navbar-nav navbar-right">                 
            <li class="scroll active"><a href="index.php">Home</a></li>
			 <?php //display playlist link only is the user is logged in
			if( !isset($_SESSION['user_id']) ){ ?> 
		
            <li class="scroll"><a href="index.php#allmusic">Our Music</a></li> 
            <li class="scroll"><a href="login.php">Login</a></li> 
			<li class="scroll"><a href="register.php">Register</a></li> 
			<?php }  else { ?>	
			<li class="scroll"><a href="playlist.php">Your Music</a></li> 
            <li class="scroll"><a href="logout.php">Logout</a></li> <?php } ?>		
            <li class="scroll"><a href="index.php#contact">Contact</a></li>       
          </ul>
        </div>
      </div>
    </div><!--/#main-nav-->
</header>
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

  <footer id="footer">
    <div class="footer-top wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="300ms">
      <div class="container text-center">
        <div class="footer-logo">
          <a href="index.php#allmusic"><img class="img-responsive" src="images/logo.png" alt=""></a>
        </div>
        <div class="social-icons">
          <ul>
            <li><a class="envelope" href="#"><i class="fa fa-envelope"></i></a></li>
            <li><a class="twitter" href="#"><i class="fa fa-twitter"></i></a></li> 
            <li><a class="dribbble" href="#"><i class="fa fa-dribbble"></i></a></li>
            <li><a class="facebook" href="#"><i class="fa fa-facebook"></i></a></li>
            <li><a class="linkedin" href="#"><i class="fa fa-linkedin"></i></a></li>
            <li><a class="tumblr" href="#"><i class="fa fa-tumblr-square"></i></a></li>
          </ul>
        </div>
      </div>
    </div>
    <div class="footer-bottom">
      <div class="container">
        <div class="row">
          <div class="col-sm-6">
            <p>&copy; VDj 2017.</p>
          </div>
          
        </div>
      </div>
    </div>
  </footer>

  <script type="text/javascript" src="js/jquery.js"></script>
  <script type="text/javascript" src="js/bootstrap.min.js"></script>
  <script type="text/javascript" src="js/jquery.inview.min.js"></script>
  <script type="text/javascript" src="js/wow.min.js"></script>
  <script type="text/javascript" src="js/mousescroll.js"></script>
  <script type="text/javascript" src="js/smoothscroll.js"></script>
  <script type="text/javascript" src="js/jquery.countTo.js"></script>
  <script type="text/javascript" src="js/lightbox.min.js"></script>
  <script type="text/javascript" src="js/main.js"></script>

</body>
</html>
