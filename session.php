<?php
session_start();
$location = $_SESSION['loggedin'];
$msg = $_SESSION['msg'];
echo "The email is: " . $location;




?>