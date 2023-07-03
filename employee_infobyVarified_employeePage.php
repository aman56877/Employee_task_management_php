<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'db_connection.php';

$activePage = 'employees';

session_start();
if(!isset($_SESSION['email']) || $_SESSION['loggedin'] !== true){
    header("location:login.php");
}

$token = $_GET['token'];
$query = "SELECT * from registrationdata WHERE token = '$token'";
$result = mysqli_query($conn, $query);

$user = mysqli_fetch_assoc($result);

include 'name_on_profile.php';


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
    .form-select {
        width: 420px;
        /* Set the desired width here */
    }

    .dropdown:hover .dropdown-menu {
        display: block;
    }
    </style>

</head>

<body>
    <!-- Navbar starts -->
    <?php include 'navbar.php'; ?>
    <!-- Navbar ends -->

    <!-- Personal Info fields starts   -->
    <div class="container text-center mt-5">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Name</h5>
                        <p class="card-text"><?php echo $user['name'];?></p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Email</h5>
                        <p class="card-text"><?php echo $user['email'];?></p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Number</h5>
                        <p class="card-text"><?php echo $user['number'];?></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">City</h5>
                        <p class="card-text"><?php echo $user['city'];?></p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">State</h5>
                        <p class="card-text"><?php echo $user['state'];?></p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Country</h5>
                        <p class="card-text"><?php echo $user['country'];?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Personal Info fields ends -->

    <!-- Field for requested values -->
    <div class="container text-center mt-3" style="display: grid; justify-content: space-around;">
        <label for="" style="background-color:aquamarine; border-radius:10px;" class="mt-2">Values</label>
        <div class="row">
            <div class="col">
                <div class="card" style=" height: 80px;width: 411px;">
                    <div class="card-body">
                        <h5 class="card-title">Role</h5>
                        <p class="card-text"><?php echo ucfirst($user['role']);?></p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card" style="    height: 80px;width: 411px;">
                    <div class="card-body">
                        <h5 class="card-title">Verification Status</h5>
                        <p class="card-text"><?php echo ucfirst($user['verification_status']);?></p>
                    </div>
                </div>
            </div>


        </div>
    </div>
    <!-- field for role ends here -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous">
    </script>
</body>

</html>