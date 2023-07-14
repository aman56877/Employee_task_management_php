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


$tokenofUser = $_SESSION['token'];
$queryforUserToken = "SELECT * from registrationdata WHERE token = '$tokenofUser'";
$resultforUserToken = mysqli_query($conn, $queryforUserToken);
$UserToken = mysqli_fetch_assoc($resultforUserToken);
$userDept = $UserToken['department'];

// code for the table to show all tasks
if($userDept === 'hr_dept'){
    // code to show all tasks starts
    $querytoShowAllTasks = "SELECT * from hr_tasks WHERE employee_token = '$tokenofUser'";
    $querytoShowAllTasksResult = mysqli_query($conn, $querytoShowAllTasks);
    $querytoShowAllTasksResultFinal = array();
    if($querytoShowAllTasksResult){
        while($row = mysqli_fetch_assoc($querytoShowAllTasksResult)){
            $querytoShowAllTasksResultFinal[] = $row;
        }
    }
    }elseif($userDept === 'it_dept'){
    // code to show all tasks starts
    $querytoShowAllTasks = "SELECT * from it_tasks WHERE employee_token = '$tokenofUser'";
    $querytoShowAllTasksResult = mysqli_query($conn, $querytoShowAllTasks);
    $querytoShowAllTasksResultFinal = array();
    if($querytoShowAllTasksResult){
        while($row = mysqli_fetch_assoc($querytoShowAllTasksResult)){
            $querytoShowAllTasksResultFinal[] = $row;
        }
    }
    }elseif($userDept === 'finance_dept'){
    // code to show all tasks starts
    $querytoShowAllTasks = "SELECT * from finance_tasks WHERE employee_token = '$tokenofUser'";
    $querytoShowAllTasksResult = mysqli_query($conn, $querytoShowAllTasks);
    $querytoShowAllTasksResultFinal = array();
    if($querytoShowAllTasksResult){
        while($row = mysqli_fetch_assoc($querytoShowAllTasksResult)){
            $querytoShowAllTasksResultFinal[] = $row;
        }
    }
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

<!-- Table starts -->
<div class="container">
    <table id="myTable" class="display">
        <thead>
            <tr>
                <th>S.No.</th>
                <th>Name</th>
                <th>Question</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $serialNumber = 1;
                 foreach($querytoShowAllTasksResultFinal as $user): 
                    ?>
            <tr>
                <td> <?php echo $serialNumber ?> </td>
                <td><a style="color: black;" href="task_submit_by_user.php?task_token=<?php echo $user['task_token']; ?>"><?php echo ucfirst($user['task_name']);?></a></td>
                <td><a style="color: black;" href="task_file/<?php echo ($user['task_address']); ?>" target="_blank"><?php echo ucfirst($user['task_address']);?></a></td>
                <td> <?php
                if($user['report'] === NULL){
                    echo "Not submitted";
                }else{
                    echo "Submitted";
                }
                ?> 
                </td>
            </tr>
            <?php
                $serialNumber++;
                 endforeach; 
                 ?>
        </tbody>
    </table>
</div>
<!-- Table ends -->





<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
    integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
</script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>

<!-- script for the datatable plugin -->
<script>
$(document).ready(function() {
    $('#myTable').DataTable();
});
</script>

</body>
</html>