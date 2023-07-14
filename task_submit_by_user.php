<?php


// error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
if(!isset($_SESSION['email']) || $_SESSION['user_page']!==true){
    header("location:login.php");
}
require_once 'db_connection.php';

include 'name_on_profile.php';

$tokenofTask = $_GET['task_token'];


$tokenofUser = $_SESSION['token'];
$queryforUserToken = "SELECT * from registrationdata WHERE token = '$tokenofUser'";
$resultforUserToken = mysqli_query($conn, $queryforUserToken);
$UserToken = mysqli_fetch_assoc($resultforUserToken);
$userDept = $UserToken['department'];




// code to get task details starts
if($userDept === 'it_dept'){
    $querytogetTaskName = "SELECT * FROM it_tasks WHERE task_token = '$tokenofTask'";
    $querytogetTaskNameResult = mysqli_query($conn, $querytogetTaskName);
    $querytogetTaskNameResultFinal = mysqli_fetch_assoc($querytogetTaskNameResult);
    $manager_token = $querytogetTaskNameResultFinal['manager_token'];

    $querytogetManagerName = "SELECT * FROM it_dept WHERE token = '$manager_token' AND position = 'manager'";
    $querytogetManagerNameResult = mysqli_query($conn, $querytogetManagerName);
    $querytogetManagerNameResultFinal = mysqli_fetch_assoc($querytogetManagerNameResult);
    $managerName = $querytogetManagerNameResultFinal['emp_name'];



    // code to submit pdf report
    if(isset($_POST['submit'])){
        $pdf_file = $_FILES['pdf_report']['name'];
        $tmp_name = $_FILES['pdf_report']['tmp_name'];
        $folder = "report/" . $pdf_file;
        if($pdf_file === ""){
            $_SESSION['selectPdf'] = "Please select a file to continue";
            header("location:task_submit_by_user.php?task_token=" . $tokenofTask);
        }else{
            $querytouploadReport = "UPDATE it_tasks SET report = '$pdf_file', updated_at = NOW() WHERE task_token = '$tokenofTask'";
            $querytouploadReportResult = mysqli_query($conn, $querytouploadReport);
            move_uploaded_file($tmp_name, $folder);
            if($querytouploadReportResult){
                $_SESSION['reportSubmitted'] = "Your report has been submitted successfully";
                header("location:task_submit_by_user.php?task_token=" . $tokenofTask);
            }else{
                $_SESSION['reportNotSubmitted'] = "Your report has not submitted due to technical problems";
                header("location:task_submit_by_user.php?task_token=" . $tokenofTask);
            }
        }
    }
    // ends here


}elseif($userDept === 'hr_dept'){
    $querytogetTaskName = "SELECT * FROM hr_tasks WHERE task_token = '$tokenofTask'";
    $querytogetTaskNameResult = mysqli_query($conn, $querytogetTaskName);
    $querytogetTaskNameResultFinal = mysqli_fetch_assoc($querytogetTaskNameResult);

    // code to submit pdf report
    if(isset($_POST['submit'])){
        $pdf_file = $_FILES['pdf_report']['name'];
        $tmp_name = $_FILES['pdf_report']['tmp_name'];
        $folder = "report/" . $pdf_file;
        if($pdf_file === ""){
            $_SESSION['selectPdf'] = "Please select a file to continue";
            header("location:task_submit_by_user.php?task_token=" . $tokenofTask);
        }else{
            $querytouploadReport = "UPDATE hr_tasks SET report = '$pdf_file', updated_at = NOW() WHERE task_token = '$tokenofTask'";
            $querytouploadReportResult = mysqli_query($conn, $querytouploadReport);
            move_uploaded_file($tmp_name, $folder);
            if($querytouploadReportResult){
                $_SESSION['reportSubmitted'] = "Your report has been submitted successfully";
                header("location:task_submit_by_user.php?task_token=" . $tokenofTask);
            }else{
                $_SESSION['reportNotSubmitted'] = "Your report has not submitted due to technical problems";
                header("location:task_submit_by_user.php?task_token=" . $tokenofTask);
            }
        }
    }
    // ends here

}elseif($userDept === 'finance_dept'){
    $querytogetTaskName = "SELECT * FROM finance_tasks WHERE task_token = '$tokenofTask'";
    $querytogetTaskNameResult = mysqli_query($conn, $querytogetTaskName);
    $querytogetTaskNameResultFinal = mysqli_fetch_assoc($querytogetTaskNameResult);

    // code to submit pdf report
    if(isset($_POST['submit'])){
        $pdf_file = $_FILES['pdf_report']['name'];
        $tmp_name = $_FILES['pdf_report']['tmp_name'];
        $folder = "report/" . $pdf_file;
        if($pdf_file === ""){
            $_SESSION['selectPdf'] = "Please select a file to continue";
            header("location:task_submit_by_user.php?task_token=" . $tokenofTask);
        }else{
            $querytouploadReport = "UPDATE finance_tasks SET report = '$pdf_file', updated_at = NOW() WHERE task_token = '$tokenofTask'";
            $querytouploadReportResult = mysqli_query($conn, $querytouploadReport);
            move_uploaded_file($tmp_name, $folder);
            if($querytouploadReportResult){
                $_SESSION['reportSubmitted'] = "Your report has been submitted successfully";
                header("location:task_submit_by_user.php?task_token=" . $tokenofTask);
            }else{
                $_SESSION['reportNotSubmitted'] = "Your report has not submitted due to technical problems";
                header("location:task_submit_by_user.php?task_token=" . $tokenofTask);
            }
        }
    }
    // ends here
}

// to check the task assigned or not
if($querytogetTaskNameResultFinal['report'] === NULL){
    $statusofTask = "Report Not Submitted";
}else{
    $statusofTask = "Report Submitted";
}
// ends here




?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css" />
    <link rel="icon" type="image/png" href="images/favicon.png">

    <title>Employee Management system</title>
    <style>
    .dropdown:hover .dropdown-menu {
        display: block;
    }

    body {
        background-color: orange;
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
                        <a class="nav-link " aria-current="page" href="user.php">Dashboard</a>
                    </li>
                    <li>
                        <a class="nav-link active" aria-current="page" href="user_all_tasks.php">All Tasks</a>
                    </li>
                    <li>
                        <div class="dropdown" style="position: relative; left: 750px;">
                            <button class="btn btn-outline-success dropdown-toggle" type="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <?php echo $UserToken['name']; ?>
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

    <!--  task info field start -->
    <div class="container">
        <div class="container text-center mt-5">
            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Name</h5>
                            <p class="card-text"><?php echo $querytogetTaskNameResultFinal['task_name']; ?></p>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Status</h5>
                            <p class="card-text"><?php echo $statusofTask;  ?></p>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Assigned By</h5>
                            <p class="card-text"><?php echo $managerName;  ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- task info field ends -->

    <!-- task submit by user -->
    <div class="container mt-4">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="input-group mb-3">
                <input type="file" class="form-control" id="inputGroupFile02" name="pdf_report" required>
                <label class="input-group-text" for="inputGroupFile02">Submit Report</label>
            </div>
            <button class="btn btn-info" name="submit">Submit Report</button>
        </form>
        <?php
                if(isset($_SESSION['reportSubmitted'])){
                    echo $_SESSION['reportSubmitted'];
                    echo "<script>setTimeout(function(){unsetSession(); }, 5000);</script>";
                    if(isset($_GET['unset']) && $_GET['unset'] === '1'){
                        unset($_SESSION['reportSubmitted']);
                    }
                }else{
                    echo '';
                }
                if(isset($_SESSION['reportNotSubmitted'])){
                    echo $_SESSION['reportNotSubmitted'];
                    echo "<script>setTimeout(function(){unsetSession(); }, 5000);</script>";
                    if(isset($_GET['unset']) && $_GET['unset'] === '1'){
                        unset($_SESSION['reportNotSubmitted']);
                    }
                }else{
                    echo '';
                }
                if(isset($_SESSION['selectPdf'])){
                    echo $_SESSION['selectPdf'];
                    echo "<script>setTimeout(function(){unsetSession(); }, 5000);</script>";
                    if(isset($_GET['unset']) && $_GET['unset'] === '1'){
                        unset($_SESSION['selectPdf']);
                    }
                }else{
                    echo '';
                }
                ?>
                </div>
    <!-- ends here -->
    
    <?php
        echo 
    '<script>
    function unsetSession(){
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "task_submit_by_user.php?unset=1", true);
        xhr.send();
    }
    </script>';
    ?>

</body>

</html>