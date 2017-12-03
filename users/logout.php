<?php
session_start();
session_destroy();
header("Location: /relocate-right/index.php");
?>