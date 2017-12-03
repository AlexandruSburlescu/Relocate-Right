<?php
session_start();

?>

<!DOCTYPE html>
<html>
<head>
    <title>Relocate Right - Estate Agency</title>
    <meta name="viewport" content="width=device-width"/>
    <meta charset="utf-8" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="css/main.css" />
    <link href="https://fonts.googleapis.com/css?family=Lato|Montserrat|Open+Sans|Roboto" rel="stylesheet">
</head>
<body>
<?php
      require('header.php');
      require('body.php');
      require('footer.php'); ?>

<script type="text/javascript" src="js/jquery-3.2.1.js"></script>
<script type="text/javascript" src="js/myscripts.js"></script>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAfLvR5-Iyr-gqqUjWWBbP4FcNh3D5ZKFs&callback=myMap"></script>
</body>
</html>