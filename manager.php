<?php
session_start();
if(!isset($_SESSION['email']) || $_SESSION['manager_page']!==true){
    header("location:login.php");
}

require_once 'db_connection.php';

$tokenofManager = $_SESSION['token'];
$queryforManagerToken = "SELECT * from registrationdata WHERE token = '$tokenofManager'";
$resultforManagerToken = mysqli_query($conn, $queryforManagerToken);
$ManagerToken = mysqli_fetch_assoc($resultforManagerToken);
$managerDept = $ManagerToken['department'];


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
                        <a class="nav-link active" aria-current="page" href="manager.php">Dashboard</a>
                    </li>
                    <?php
                        if($managerDept === 'it_dept'): ?>
                            <li>
                                <a class="nav-link " aria-current="page" href="it_dept_for_manager.php">Department</a>
                            </li>
                        <?php elseif($managerDept === 'hr_dept'): ?>
                            <li>
                                <a class="nav-link " aria-current="page" href="hr_dept_for_manager.php">Department</a>
                            </li>
                        <?php elseif($managerDept === 'finance_dept'):?>
                            <li>
                                <a class="nav-link " aria-current="page" href="finance_dept_for_manager.php">Department</a>
                            </li>
                        
                        <?php endif;?>
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
</body>

</html>