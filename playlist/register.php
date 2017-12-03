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

  <!--.preloader-->
  <div class="preloader"> <i class="fa fa-circle-o-notch fa-spin"></i></div>
  <!--/.preloader-->

  <header id="home">

  </header><!--/#home-->
 
  <section id="allmusic" class="parallax">
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
            <li class="scroll"><a href="../users/logout.php">Logout</a></li> <?php } ?>
            <li class="scroll"><a href="index.php#contact">Contact</a></li>       
          </ul>
        </div>
      </div>
    </div><!--/#main-nav-->
	
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
</section>

  <footer id="footer">
    <div class="footer-top wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="300ms">
      <div class="container text-center">
        <div class="footer-logo">
          <a href="index.php"><img class="img-responsive" src="images/logo.png" alt=""></a>
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

