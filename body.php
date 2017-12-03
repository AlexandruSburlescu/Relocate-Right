<div class ="row">
<?php require('body/left-reel.php');
if( !isset($_SESSION['user_id']) ){
    require('users/login.php');
}
else {
    require('body/gallery.php');
}
      require('body/right-reel.php'); ?>
</div>
