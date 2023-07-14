<?php

// error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);


require_once 'db_connection.php';


session_start();
if(!isset($_SESSION['email'])|| $_SESSION['loggedin'] !== true){
    header("location:login.php");
}

include 'name_on_profile.php';

$token = $_SESSION['token'];

if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $number = mysqli_real_escape_string($conn, $_POST['number']);
    $city = mysqli_real_escape_string($conn, $_POST['city']);
    $zip = mysqli_real_escape_string($conn, $_POST['zip']);
    $image = $_FILES['image']['name'];
    $tmp_name = $_FILES['image']['tmp_name'];
    $folder = "profile/" . $image;
    if($image == ""){
        $query = "UPDATE registrationdata SET name = '$name', number = '$number', city = '$city', zip = '$zip', updated_at = NOW() WHERE token = '$token'";
        $result = mysqli_query($conn, $query);
        $_SESSION['updationOfDataOnly'] = "Your personal information has been updated";
    }else{
        $selectQuery = "SELECT * FROM registrationdata WHERE token = '$token'";
        $selectResult = mysqli_query($conn, $selectQuery);
        if($selectResult && mysqli_num_rows($selectResult)>0){
            $user = mysqli_fetch_assoc($selectResult);
            $previousProfile = $user['profile'];
            if($previousProfile !== NULL){
                unlink("profile/" . $previousProfile);
            }
        }
        $query = "UPDATE registrationdata SET name = '$name', number = '$number', city = '$city', zip = '$zip', profile = '$image', updated_at = NOW() WHERE token = '$token'";
        $result = mysqli_query($conn, $query);
        move_uploaded_file($tmp_name, $folder);
        $_SESSION['updationOfDataandProfile'] = "Your personal information and profile picture has been updated";

    }


}





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
    </style>

</head>

<body>
    <!-- Navbar starts -->
    <?php include 'navbar.php'; ?>
    <!-- Navbar ends -->


    <!-- FIelds starts here -->
    <form action="" method="post" enctype="multipart/form-data">
        <div class="container mt-5">
            <div class="container text-center mt-2">
                <div class="row justify-content-start">
                    <div class="col-4">
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="inputGroup-sizing-default">Name</span>
                            <input type="text" class="form-control" aria-label="Sizing example input"
                                aria-describedby="inputGroup-sizing-default" value="<?php echo $alldata['name'];  ?>"
                                name="name">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="inputGroup-sizing-default">Email</span>
                            <input type="text" class="form-control" aria-label="Sizing example input"
                                aria-describedby="inputGroup-sizing-default" value="<?php echo $alldata['email'];  ?>"
                                name="email" readonly>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container text-center mt-2 ">
                <div class="row justify-content-start">
                    <div class="col-4">
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="inputGroup-sizing-default">Number</span>
                            <input type="text" class="form-control" aria-label="Sizing example input"
                                aria-describedby="inputGroup-sizing-default" value="<?php echo $alldata['number'];  ?>"
                                name="number">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="inputGroup-sizing-default">City</span>
                            <input type="text" class="form-control" aria-label="Sizing example input"
                                aria-describedby="inputGroup-sizing-default" value="<?php echo $alldata['city'];  ?>"
                                name="city">
                        </div>
                    </div>
                </div>
            </div>
            <div class="container text-center mt-2">
                <div class="row justify-content-start">
                    <div class="col-4">
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="inputGroup-sizing-default">Pincode</span>
                            <input type="text" class="form-control" aria-label="Sizing example input"
                                aria-describedby="inputGroup-sizing-default" value="<?php echo $alldata['zip'];  ?>"
                                name="zip">
                            <p>
                                <?php
                            if(isset($_SESSION['updationOfDataOnly'])){
                                echo $_SESSION['updationOfDataOnly'];
                                unset($_SESSION['updationOfDataOnly']);
                            }else{
                                echo $_SESSION['updationOfDataOnly'] = '';
                            }
                            ?>
                            </p>
                        </div>

                        <div class="input-group mb-3">
                            <input type="file" class="form-control" id="inputGroupFile02" name="image">
                            <label class="input-group-text" for="inputGroupFile02">Upload</label>
                            <p>
                                <?php
                            if(isset($_SESSION['updationOfDataandProfile'])){
                                echo $_SESSION['updationOfDataandProfile'];
                                unset($_SESSION['updationOfDataandProfile']);
                            }else{
                                echo $_SESSION['updationOfDataandProfile'] = '';
                            }
                            ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <button class="btn btn-info" name="submit"
            style="display: block; width: -webkit-fill-available; position:relative; top:50px; width: 414px;left: 464px;">Update</button>
    </form>

    <div class="container" style=" position: relative;left: 300px;top: -270px; width: 10vh; height:5vh">
        <div class="card" style="width: 18rem;">
            <img src="./profile/<?php echo $alldata['profile'];  ?>" class="card-img-top" alt="...">
            <div class="card-body">
            </div>
        </div>
    </div>
    <!-- Field ends here -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous">
    </script>
</body>

</html>