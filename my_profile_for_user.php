<?php

// error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);


require_once 'db_connection.php';


session_start();
if(!isset($_SESSION['email'])|| $_SESSION['user_page'] !== true){
    header("location:login.php");
}

include 'name_on_profile.php';


$token = $_SESSION['token'];
$queryforuserToken = "SELECT * from registrationdata WHERE token = '$token'";
$resultforuserToken = mysqli_query($conn, $queryforuserToken);

$userToken = mysqli_fetch_assoc($resultforuserToken);
$userDepartment = $userToken['department'];




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
        if($userDepartment === 'it_dept'){
            $querytoUpdateInfoInDept = "UPDATE it_dept SET emp_name = '$name', number = '$number', updated_at = NOW() WHERE token = '$token'";
            $querytoUpdateInfoInDeptResult = mysqli_query($conn, $querytoUpdateInfoInDept);
            
            if($querytoUpdateInfoInDeptResult){
                $_SESSION['updationOfDataOnly'] = "Your personal information has been updated";
                header("location:my_profile_for_user.php");
            }else{
                $_SESSION['notUpdated'] = "Your personal information has not been updated due to technical problems";
                header("location:my_profile_for_user.php");
            }
        }elseif($userDepartment === 'hr_dept'){
            $querytoUpdateInfoInDept = "UPDATE hr_dept SET emp_name = '$name', number = '$number', updated_at = NOW() WHERE token = '$token'";
            $querytoUpdateInfoInDeptResult = mysqli_query($conn, $querytoUpdateInfoInDept);
            
            if($querytoUpdateInfoInDeptResult){
                $_SESSION['updationOfDataOnly'] = "Your personal information has been updated";
                header("location:my_profile_for_user.php");
            }else{
                $_SESSION['notUpdated'] = "Your personal information has not been updated due to technical problems";
                header("location:my_profile_for_user.php");
            }
        }elseif($userDepartment === 'finance_dept'){
            $querytoUpdateInfoInDept = "UPDATE finance_dept SET emp_name = '$name', number = '$number', updated_at = NOW() WHERE token = '$token'";
            $querytoUpdateInfoInDeptResult = mysqli_query($conn, $querytoUpdateInfoInDept);
            
            if($querytoUpdateInfoInDeptResult){
                $_SESSION['updationOfDataOnly'] = "Your personal information has been updated";
                header("location:my_profile_for_user.php");
            }else{
                $_SESSION['notUpdated'] = "Your personal information has not been updated due to technical problems";
                header("location:my_profile_for_user.php");
            }
        }
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
        if($userDepartment === 'it_dept'){
            $querytoUpdateInfoInDept = "UPDATE it_dept SET emp_name = '$name', number = '$number', updated_at = NOW() WHERE token = '$token'";
            $querytoUpdateInfoInDeptResult = mysqli_query($conn, $querytoUpdateInfoInDept);
            
            if($querytoUpdateInfoInDeptResult){
                $_SESSION['updationOfDataandProfile'] = "Your personal information and profile picture has been updated";
                header("location:my_profile_for_user.php");
            }else{
                $_SESSION['notUpdated'] = "Your personal information has not been updated due to technical problems";
                header("location:my_profile_for_user.php");
            }
        }elseif($userDepartment === 'hr_dept'){
            $querytoUpdateInfoInDept = "UPDATE hr_dept SET emp_name = '$name', number = '$number', updated_at = NOW() WHERE token = '$token'";
            $querytoUpdateInfoInDeptResult = mysqli_query($conn, $querytoUpdateInfoInDept);
            
            if($querytoUpdateInfoInDeptResult){
                $_SESSION['updationOfDataandProfile'] = "Your personal information and profile picture has been updated";
                header("location:my_profile_for_user.php");
            }else{
                $_SESSION['notUpdated'] = "Your personal information has not been updated due to technical problems";
                header("location:my_profile_for_user.php");
            }
        }elseif($userDepartment === 'finance_dept'){
            $querytoUpdateInfoInDept = "UPDATE finance_dept SET emp_name = '$name', number = '$number', updated_at = NOW() WHERE token = '$token'";
            $querytoUpdateInfoInDeptResult = mysqli_query($conn, $querytoUpdateInfoInDept);
            
            if($querytoUpdateInfoInDeptResult){
                $_SESSION['updationOfDataandProfile'] = "Your personal information and profile picture has been updated";
                header("location:my_profile_for_user.php");
            }else{
                $_SESSION['notUpdated'] = "Your personal information has not been updated due to technical problems";
                header("location:my_profile_for_user.php");
            }
        }
        move_uploaded_file($tmp_name, $folder);
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
                        <div class="dropdown" style="position: relative; left: 500px;">
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
                        </div>

                        <div class="input-group mb-3">
                            <input type="file" class="form-control" id="inputGroupFile02" name="image">
                            <label class="input-group-text" for="inputGroupFile02">Upload</label>
                        </div>
                                <?php
                            if(isset($_SESSION['updationOfDataOnly'])){
                                echo $_SESSION['updationOfDataOnly'];
                                echo "<script>setTimeout(function(){unsetSession(); }, 5000);</script>";
                                if(isset($_GET['unset']) && $_GET['unset'] === '1'){
                                    unset($_SESSION['updationOfDataOnly']);
                                }
                            }else{
                                echo '';
                            }

                            if(isset($_SESSION['updationOfDataandProfile'])){
                                echo $_SESSION['updationOfDataandProfile'];
                                echo "<script>setTimeout(function(){unsetSession(); }, 5000);</script>";
                                if(isset($_GET['unset']) && $_GET['unset'] === '1'){
                                    unset($_SESSION['updationOfDataandProfile']);
                                }
                            }else{
                                echo '';
                            }
                            if(isset($_SESSION['notUpdated'])){
                                echo $_SESSION['notUpdated'];
                                echo "<script>setTimeout(function(){unsetSession(); }, 5000);</script>";
                                if(isset($_GET['unset']) && $_GET['unset'] === '1'){
                                    unset($_SESSION['notUpdated']);
                                }
                            }else{
                                echo '';
                            }
                            
                            ?>
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

    <?php
        echo 
    '<script>
    function unsetSession(){
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "my_profile_for_user.php?unset=1", true);
        xhr.send();
    }
    </script>';
    ?>

</body>

</html>