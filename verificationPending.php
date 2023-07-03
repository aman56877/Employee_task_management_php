<?php
session_start();
if(!isset($_SESSION['not_verified'])){
    header("location:login.php");
}

require_once 'db_connection.php';

$email = $_SESSION['email'];

$query = "SELECT * FROM registrationdata WHERE email ='$email'";
$result = mysqli_query($conn, $query);
$alldata = mysqli_fetch_assoc($result);
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
    body {
        background-image: url('images/bg.jpg');
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center;
        height: 100vh;
        width: 100vh;
    }

    .centered-text {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: white;
        font-size: 24px;
        text-align: center;
    }
    </style>
</head>

<body>








    <div class="centered-text">
        <?php
    if ($alldata['created_at'] < $alldata['updated_at']) {
        echo "Your role for " . $alldata['role'] . " has been confirmed but you are still not verified. Please be patient and be in contact with your administrator";
    } elseif ($alldata['created_at'] === $alldata['updated_at'] && strpos($alldata['verification_status'], "unverify") !== false) {
        echo "Neither your role for " . $alldata['role'] . " nor your verification status has been confirmed. Please be patient and be in contact with your administrator";
    }
    ?>
    <a href="logout.php" class="btn btn-danger" style="display: flex;"><span style="position: relative; left: 300px;">Logout</span></a>
    </div>




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous">
    </script>
</body>

</html>