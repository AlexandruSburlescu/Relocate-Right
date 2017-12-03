<?php

session_start();

require 'database.php';
$user = NULL;
$s = NULL;
//load xml file using simplexml
	$songsXML = simplexml_load_file("xmlPlaylist.xml"); 
	
	if(!empty($_POST['search']))
	{	
		$qry = "/rss/channel/item[contains(artist , '".$_POST['search']."') or contains(songtitle , '".$_POST['search']."')]"; 
		$songs = $songsXML->xpath($qry);
	} else {
		$qry2 = "/rss/channel/item";
		$songs = $songsXML->xpath($qry2);
	}	
	
if( isset($_SESSION['user_id']) ){
	//if the sesion is set then select the users id
	$sql1 = 'SELECT memberID, name FROM users WHERE memberID = :id';
	$records = $conn->prepare($sql1);
	$records->bindParam(':id', $_SESSION['user_id']);
	$records->execute();
	$results = $records->fetch(PDO::FETCH_ASSOC);

	

	if( count($results) > 0){
		$user = $results;
	}
	

	
	
	
if(!empty($_POST['titles'])){
// Loop through songs and send values of individual checked checkbox.
foreach ($_POST['titles'] as $title) {
	foreach ($songs as $song )
		{ 
		//check for each selected song id that it is not already in the saved_songs database
		$sql2 = 'SELECT songID FROM saved_songs WHERE songID = :songID AND memberID = :memberID';
		$rec = $conn->prepare($sql2);
		$rec->bindParam(':songID', $song->songid);
		$rec->bindParam(':memberID', $_SESSION['user_id']);
		$rec->execute();
		$res = $rec->fetchAll(PDO::FETCH_ASSOC);
		if (count($res) == 0 ) {	
			//if the selected song is not in the database, insert it from the simplexml loaded file
			if ( $song->songid == $title ) {
				$sql3 = 'INSERT INTO saved_songs (songID, memberID, artist, songtitle, link, genre, releaseYear, dateSaved) VALUES (:songID, :memberID, :artist, :songtitle, :link, :genre, :releaseYear, NOW())'; 
				$record = $conn->prepare($sql3);
				$record->bindParam(':songID', $song->songid);
				$record->bindParam(':memberID', $_SESSION['user_id']);
				$record->bindParam(':artist', $song->artist);
				$record->bindParam(':songtitle', $song->songtitle);
				$record->bindParam(':link', $song->link);
				$record->bindParam(':genre', $song->genre);
				$record->bindParam(':releaseYear', $song->releaseyear);
				$record->execute();	
				
			}
		}
    
}
}
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
    </div><!--/#home-slider-->
	</div>
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
            <li class="scroll active"><a href="#home">Home</a></li>
			 <?php //display playlist link only is the user is logged in
			if( !isset($_SESSION['user_id']) ){ ?> 
		
            <li class="scroll"><a href="#allmusic">Our Music</a></li> 
            <li class="scroll"><a href="login.php">Login</a></li> 
			<li class="scroll"><a href="register.php">Register</a></li> 
			<?php }  else { ?>	
			<li class="scroll"><a href="playlist.php">Your Music</a></li> 
            <li class="scroll"><a href="logout.php">Logout</a></li> <?php } ?>		
            <li class="scroll"><a href="#contact">Contact</a></li>       
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
			<p> Our variety of genre and artists allow you to pick and choose your favourites. Select your favourite music and add it to your personalised playlist.</p> <?php } ?>
			</div>
        </div>
       <?php
		//if the user is logged in display the checkboxes near the songs and the submit button
		if( count($user) > 0 ) {  ?>   
		<div class="row">
		<form class="form-horizontal" action="index.php" method="POST">  
			<div class="form-group">
				<div class="col-sm-6">
					<input type="text" class="form-control" name="search" placeholder="Search by artist name or song title(Case Sensitive).">
				
				
					<button type="submit" class="btn btn-submit">Search</button>
				</div>
			</div>	
		</form>
		</div>
		<form class="form-vertical" action="index.php" method="POST">    
		<div class="col-sm-12">
		<div class="table-responsive">
		<table class="table">
		<tr><th>Select</th><th>Title</th><th>Artist</th><th>Year</th><th>Genre</th><th>Link</th></tr>
			<?php foreach ($songs as $item){ ?>
			<tr>
				<td><input type = "checkbox" name = "titles[]" value="<?php echo $item->songid; ?>"></td>
				<td><?php echo $item->songtitle; ?></td>
				<td><?php echo $item->artist; ?></td>
				<td><?php echo $item->releaseyear; ?></td>
				<td><?php echo $item->genre; ?></td>
				<td><a href= " <?php echo $item->link; ?> "><?php echo $item->link; ?></a></td>
			</tr> 
			<?php } ?>     
		</table>    
	</div>  
		<button type="submit" class="btn-submit">Save to Playlist</button>
	</div>    
	</form> 
<?php   
} else {
//if the user is not logged in display just the songs
?> 
	<div class="table-responsive">
	<table class="table">
		<tr><th>Title</th><th>Artist</th><th>Year</th><th>Genre</th><th>Link</th></tr>
			<?php foreach ($songs as $item){ ?>
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
	</section><!--/#about-us-->

  <section id="contact">
    <div id="contact-us" class="parallax">
      <div class="container">
        <div class="row">
          <div class="heading text-center col-sm-8 col-sm-offset-2 wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="300ms">
            <h2>Contact Us</h2>
            <p>Get in touch and let us know what other type of music you would want to have access to.</p>
          </div>
        </div>
        <div class="contact-form wow fadeIn" data-wow-duration="1000ms" data-wow-delay="600ms">
          <div class="row">
            <div class="col-sm-6">
              <form id="main-contact-form" name="contact-form" method="post" action="#">
                <div class="row  wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="300ms">
                  <div class="col-sm-6">
                    <div class="form-group">
                      <input type="text" name="name" class="form-control" placeholder="Name" required="required">
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <input type="email" name="email" class="form-control" placeholder="Email Address" required="required">
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <input type="text" name="subject" class="form-control" placeholder="Subject" required="required">
                </div>
                <div class="form-group">
                  <textarea name="message" id="message" class="form-control" rows="4" placeholder="Enter your message" required="required"></textarea>
                </div>                        
                <div class="form-group">
                  <button type="submit" class="btn-submit">Send Now</button>
                </div>
              </form>   
            </div>
          </div>
        </div>
      </div>
    </div>        
  </section><!--/#contact-->
  <footer id="footer">
    <div class="footer-top wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="300ms">
      <div class="container text-center">
        <div class="footer-logo">
          <a href="#home"><img class="img-responsive" src="images/logo.png" alt=""></a>
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