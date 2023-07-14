<?php

// error reporting
error_reporting(E_ALL);
ini_set("display_errors", 1);

require_once 'db_connection.php';


session_start();
if(!isset($_SESSION['email']) || $_SESSION['user_page']!==true ){
    header("location:login.php");
}
include 'name_on_profile.php';

$token = $_SESSION['token'];
$queryforuserToken = "SELECT * from registrationdata WHERE token = '$token'";
$resultforuserToken = mysqli_query($conn, $queryforuserToken);

$userToken = mysqli_fetch_assoc($resultforuserToken);
$userDepartment = $userToken['department'];

?>













<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Employee Management system</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="icon" type="image/png" href="images/favicon.png">
    <style>
    .dropdown:hover .dropdown-menu {
        display: block;
    }
    body {
        background-color:orange;
    }
    </style>
</head>
<body>
    <!-- navbar starts -->
    <nav class="navbar navbar-expand-lg bg-body-tertiary border-bottom border-bottom-dark mb-2">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Navbar</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="user.php">Dashboard</a>
                    </li>
                    <li>
                        <a class="nav-link" aria-current="page" href="user_all_tasks.php">All Tasks</a>
                    </li>
                    <li>
                        <div class="dropdown" style="position: relative; left: 750px;">
                            <button class="btn btn-outline-success dropdown-toggle" type="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <?php echo $userToken['name']; ?>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="my_profile_for_user.php">My Profile</a></li>
                                <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                                <li><a class="dropdown-item" href="#">Something else here</a></li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- navbar ends -->

</body>
</html>