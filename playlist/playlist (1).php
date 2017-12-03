<?php

session_start();

require 'database.php';
$user = NULL;
$allsongs = simplexml_load_file("xmlPlaylist.xml"); 	
$_SESSION['message'] = '';

if( isset($_SESSION['user_id']) ){
	//if the sesion is set then select the users id
	$sql1 = 'SELECT memberID,name FROM users WHERE memberID = :id';
	$records = $conn->prepare($sql1);
	$records->bindParam(':id', $_SESSION['user_id']);
	$records->execute();
	$results = $records->fetch(PDO::FETCH_ASSOC);

	

	if( count($results) > 0){
		$user = $results;
	}
	//display only the songs that the current user has saved in the database
	$sql2 = 'SELECT saved_songs.* FROM saved_songs WHERE saved_songs.memberID = :id';	
	$rec = $conn->prepare($sql2);
	$rec->bindParam(':id', $_SESSION['user_id']);
	$rec->execute();
	$res = $rec->fetchAll(PDO::FETCH_ASSOC);
	$songs = $res;
	if (count($songs) == 0 ) {$_SESSION['message'] = 'Your playlist is empty. Return to the main page to add more songs.';}
	//if any of the checkboxes are clicked, delete the songs from the database
	if(!empty($_POST['titles'])){
		foreach ($_POST['titles'] as $title) {
				$sql3 = 'DELETE FROM saved_songs WHERE songID = :songID';
				$r = $conn->prepare($sql3);
				$r->bindParam(':songID',$title);
				$r->execute();
		}
		header("Location: playlist.php");
	}
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
	<?php if( !isset($_SESSION['user_id']) ){ ?> 
    <div id="home-slider" class="carousel slide carousel-fade" data-ride="carousel">
      <div class="carousel-inner">
        <div class="item active" style="background-image: url(images/slider/1.jpg)">
          <div class="caption">
            <h1 class="animated fadeInLeftBig">Welcome to <span>VDj</span></h1>
            <p class="animated fadeInRightBig">Your virtual music system.</p>
            <a data-scroll class="btn btn-start animated fadeInUpBig" href="#allmusic">Start now</a>
          </div>
        </div>
       <a id="tohash" href="#allmusic"><i class="fa fa-angle-down"></i></a>
	<?php } ?>
    </div><!--/index.php#home-slider-->
	</div>
  </header><!--/index.php#home-->
 
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
		
            <li class="scroll"><a href="#allmusic">Our Music</a></li> 
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
    <div class="container">
      <div class="row">
        <div class="col-sm-6">
          <div class="about-info wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="300ms">
            <h2>Our music, Your way.</h2>
			<?php if( count($user) == 0 ) {  ?>   
            <p> Our variety of genre and artists allow you to pick and choose your favourites. Just login and start selecting your favourite music.</p>
			<?php } else { ?>
			<p> <?php echo $_SESSION['message']; } ?> </p>
			</div>
        </div>

<?php
//if the user is logged in display the checkboxes near the songs and the submit button
if( count($user) > 0 ) {  ?>   
<form class="form-vertical" action="playlist.php" method="POST">    
<div class="col-sm-12">
	<div class="table-responsive">
		<table class="table">
		<tr><th>Select</th><th>Title</th><th>Artist</th><th>Year</th><th>Genre</th><th>Link</th></tr>
			<?php foreach ($songs as $item){ ?>
			<tr>
				<td><input type = "checkbox" name = "titles[]" value="<?php echo $item['songID']; ?>"></td>
				<td><?php echo $item['songtitle']; ?></td>
				<td><?php echo $item['artist']; ?></td>
				<td><?php echo $item['releaseYear']; ?></td>
				<td><?php echo $item['genre']; ?></td>
				<td><a href= " <?php echo $item['link']; ?> "><?php echo $item['link']; ?></a></td>
			</tr> 
			<?php } ?>     
		</table>    
	</div>  
	</div>
	<div class="row">
        <div class="col-sm-6">
			<div class="form-group">
				<button type="submit" class="btn btn-submit">Delete from Playlist</button>	
			</div>
		</div>
		<div class="col-sm-6">	
			<div class="form-group">
				<input type="button" class = "btn-submit" onclick="location.href='savexml.php';" value="Export XML" />
			</div>	
		</div>
		</div>
</div>    
</form> 
<?php   
} else {
//if the user is not logged in display just the songs
?> 
<div class="table-responsive">
	<table class="table">
		<tr><th>Title</th><th>Artist</th><th>Year</th><th>Genre</th><th>Link</th></tr>
			<?php foreach ($allsongs->item as $item){ ?>
			<tr>
				<td><?php echo $item->songtitle; ?></td>
				<td><?php echo $item->artist; ?></td>
				<td><?php echo $item->releaseyear; ?></td>
				<td><?php echo $item->genre; ?></td>
			<td><a href= " <?php echo $item->link; ?> "><?php echo $item->link; ?></a></td>
			</tr> 
			<?php } ?>     
	</table>    
</div>  
<?php } ?>   
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
