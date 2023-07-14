<?php


// error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
if(!isset($_SESSION['email']) || $_SESSION['manager_page']!==true){
    header("location:login.php");
}
require_once 'db_connection.php';

$tokenofManager = $_SESSION['token'];
$queryforManagerToken = "SELECT * from registrationdata WHERE token = '$tokenofManager'";
$resultforManagerToken = mysqli_query($conn, $queryforManagerToken);

$ManagerToken = mysqli_fetch_assoc($resultforManagerToken);


$query = "SELECT * from it_dept WHERE position = 'user'";
$result = mysqli_query($conn, $query);

$users = array();

if($result){
    while ($row = mysqli_fetch_assoc($result)){
        $users[] = $row;
    }
}else{
    echo "Database error:" . mysqli_error($conn);
}








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
                        <a class="nav-link" aria-current="page" href="manager.php">Dashboard</a>
                    </li>
                    <li>
                        <a class="nav-link active" aria-current="page" href="it_dept_for_manager.php">Department</a>
                    </li>
                    <li>
                        <a class="nav-link" aria-current="page" href="manager_all_tasks.php">All Tasks</a>
                    </li>
                    <li>
                        <a class="nav-link" aria-current="page" href="task_reports.php">Submitted Reports</a>
                    </li>
                    <li>
                        <div class="dropdown" style="position: relative; left: 500px;">
                            <button class="btn btn-outline-success dropdown-toggle" type="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <?php echo $ManagerToken['name']; ?>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="my_profile.php">My Profile</a></li>
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
                <th>Total Assigned Tasks</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $serialNumber = 1;
                 foreach($users as $user): 
                 ?>
            <tr>
                <td> <?php echo $serialNumber ?> </td>
                <td><a style="color: black;"
                        href="employees_of_manager.php?token=<?php echo $user['token']; ?>"><?php echo $user['emp_name'];?></a>
                </td>
                <td><?php 
                $userToken = $user['token'];
                $queryforTotalTasks = "SELECT * from it_tasks WHERE employee_token = '$userToken'";
                $queryforTotalTasksResult = mysqli_query($conn, $queryforTotalTasks);
                $queryforTotalTasksResultFinal = mysqli_num_rows($queryforTotalTasksResult);
                echo $queryforTotalTasksResultFinal;
                ?></td>
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