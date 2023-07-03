<?php
session_start();
if(!isset($_SESSION['email']) || $_SESSION['user_page']!==true ){
    header("location:login.php");
}



?>













<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="images/favicon.png">
    <title>Document</title>
</head>
<body>
    <p>
        this is user page
    </p>
    <a href="logout.php" class="btn btn-primary">Logout</a>

</body>
</html>