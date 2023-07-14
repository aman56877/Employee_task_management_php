<?php
require_once 'db_connection.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);


session_start();
if(!isset($_SESSION['email']) || $_SESSION['manager_page']!==true){
    header("location:login.php");
}


$tokenofTask = $_GET['task_token'];

$tokenofManager = $_SESSION['token'];
$queryforManagerToken = "SELECT * from registrationdata WHERE token = '$tokenofManager'";
$resultforManagerToken = mysqli_query($conn, $queryforManagerToken);

$ManagerToken = mysqli_fetch_assoc($resultforManagerToken);
$ManagerDepartment = $ManagerToken['department'];


// code to get task details starts
if($ManagerDepartment === 'it_dept'){
    $querytogetTaskName = "SELECT * FROM it_tasks WHERE task_token = '$tokenofTask'";
    $querytogetTaskNameResult = mysqli_query($conn, $querytogetTaskName);
    $querytogetTaskNameResultFinal = mysqli_fetch_assoc($querytogetTaskNameResult);

    $querytogetallEmployees = "SELECT * FROM it_dept WHERE position = 'user'";
    $querytogetallEmployeesResult = mysqli_query($conn, $querytogetallEmployees);
    $querytogetallEmployeesResultFinal = array();

    if($querytogetallEmployeesResult){
        while($row = mysqli_fetch_assoc($querytogetallEmployeesResult)){
            $querytogetallEmployeesResultFinal[] = $row;
        }
    }

        // to check the task assigned or not
    if($querytogetTaskNameResultFinal['employee_token'] === NULL && $querytogetTaskNameResultFinal['status']=== 'completed'){
        $statusofTask = "Completed";
        $disableAssignTaskBUtton = false;
    }elseif($querytogetTaskNameResultFinal['employee_token'] === NULL && $querytogetTaskNameResultFinal['status']=== NULL){
        $statusofTask = "Not assigned";
        $disableAssignTaskBUtton = false;
    }else{
        $statusofTask = "Assigned";
        $disableAssignTaskBUtton = true;
    }
    // ends here

    // to assign task
    if(isset($_POST['submit'])){
        $EmployeeToken = mysqli_real_escape_string($conn, $_POST['selectEmployee']);
        $querytoassignTask = "UPDATE it_tasks SET employee_token = '$EmployeeToken', if_employee = 'yes', updated_at = NOW() WHERE task_token = '$tokenofTask'";
        $querytoassignTaskResult = mysqli_query($conn, $querytoassignTask);

        if($querytoassignTaskResult){
            $_SESSION['task_assigned'] = "Task has been assigned";
            header("location:assign_tasks_by_manager.php?task_token=" . $tokenofTask);
        }else{
            $_SESSION['task_notAssigned'] = "Task has not been assigned due to technical problems";
            header("location:assign_tasks_by_manager.php?task_token=" . $tokenofTask);
        }
    }
    // ends here
}elseif($ManagerDepartment === 'hr_dept'){
    $querytogetTaskName = "SELECT * FROM hr_tasks WHERE task_token = '$tokenofTask'";
    $querytogetTaskNameResult = mysqli_query($conn, $querytogetTaskName);
    $querytogetTaskNameResultFinal = mysqli_fetch_assoc($querytogetTaskNameResult);

    $querytogetallEmployees = "SELECT * FROM hr_dept WHERE position = 'user'";
    $querytogetallEmployeesResult = mysqli_query($conn, $querytogetallEmployees);
    $querytogetallEmployeesResultFinal = array();

    if($querytogetallEmployeesResult){
        while($row = mysqli_fetch_assoc($querytogetallEmployeesResult)){
            $querytogetallEmployeesResultFinal[] = $row;
        }
    }


    // to check the task assigned or not
    if($querytogetTaskNameResultFinal['employee_token'] === NULL && $querytogetTaskNameResultFinal['status']=== 'completed'){
        $statusofTask = "Completed";
        $disableAssignTaskBUtton = false;
    }elseif($querytogetTaskNameResultFinal['employee_token'] === NULL && $querytogetTaskNameResultFinal['status']=== NULL){
        $statusofTask = "Not assigned";
        $disableAssignTaskBUtton = false;
    }else{
        $statusofTask = "Assigned";
        $disableAssignTaskBUtton = true;
    }
    // ends here


    // to assign task
    if(isset($_POST['submit'])){
        $EmployeeToken = mysqli_real_escape_string($conn, $_POST['selectEmployee']);
        $querytoassignTask = "UPDATE hr_tasks SET employee_token = '$EmployeeToken', if_employee = 'yes', updated_at = NOW() WHERE task_token = '$tokenofTask'";
        $querytoassignTaskResult = mysqli_query($conn, $querytoassignTask);

        if($querytoassignTaskResult){
            $_SESSION['task_assigned'] = "Task has been assigned";
            header("location:assign_tasks_by_manager.php?task_token=" . $tokenofTask);
        }else{
            $_SESSION['task_notAssigned'] = "Task has not been assigned due to technical problems";
            header("location:assign_tasks_by_manager.php?task_token=" . $tokenofTask);
        }
    }
    // ends here
}elseif($ManagerDepartment === 'finance_dept'){
    $querytogetTaskName = "SELECT * FROM finance_tasks WHERE task_token = '$tokenofTask'";
    $querytogetTaskNameResult = mysqli_query($conn, $querytogetTaskName);
    $querytogetTaskNameResultFinal = mysqli_fetch_assoc($querytogetTaskNameResult);

    $querytogetallEmployees = "SELECT * FROM finance_dept WHERE position = 'user'";
    $querytogetallEmployeesResult = mysqli_query($conn, $querytogetallEmployees);
    $querytogetallEmployeesResultFinal = array();

    if($querytogetallEmployeesResult){
        while($row = mysqli_fetch_assoc($querytogetallEmployeesResult)){
            $querytogetallEmployeesResultFinal[] = $row;
        }
    }


    // to check the task assigned or not
    if($querytogetTaskNameResultFinal['employee_token'] === NULL && $querytogetTaskNameResultFinal['status']=== 'completed'){
        $statusofTask = "Completed";
        $disableAssignTaskBUtton = true;
    }elseif($querytogetTaskNameResultFinal['employee_token'] === NULL && $querytogetTaskNameResultFinal['status']=== NULL){
        $statusofTask = "Not assigned";
        $disableAssignTaskBUtton = false;
    }else{
        $statusofTask = "Assigned";
        $disableAssignTaskBUtton = true;
    }
    // ends here
   


        // to assign task
    if(isset($_POST['submit'])){
        $EmployeeToken = mysqli_real_escape_string($conn, $_POST['selectEmployee']);
        $querytoassignTask = "UPDATE finance_tasks SET employee_token = '$EmployeeToken', if_employee = 'yes', updated_at = NOW() WHERE task_token = '$tokenofTask'";
        $querytoassignTaskResult = mysqli_query($conn, $querytoassignTask);

        if($querytoassignTaskResult){
            $_SESSION['task_assigned'] = "Task has been assigned";
            header("location:assign_tasks_by_manager.php?task_token=" . $tokenofTask);
        }else{
            $_SESSION['task_notAssigned'] = "Task has not been assigned due to technical problems";
            header("location:assign_tasks_by_manager.php?task_token=" . $tokenofTask);
        }
    }
    // ends here   
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
                        <a class="nav-link" aria-current="page" href="manager.php">Dashboard</a>
                    </li>
                    <?php
                        if($ManagerDepartment === 'it_dept'): ?>
                            <li>
                                <a class="nav-link " aria-current="page" href="it_dept_for_manager.php">Department</a>
                            </li>
                        <?php elseif($ManagerDepartment === 'hr_dept'): ?>
                            <li>
                                <a class="nav-link " aria-current="page" href="hr_dept_for_manager.php">Department</a>
                            </li>
                        <?php elseif($ManagerDepartment === 'finance_dept'):?>
                            <li>
                                <a class="nav-link " aria-current="page" href="finance_dept_for_manager.php">Department</a>
                            </li>
                        
                        <?php endif;?>
                    <li>
                        <a class="nav-link active" aria-current="page" href="manager_all_tasks.php">All Tasks</a>
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
                            <p class="card-text"><?php  echo $statusofTask;  ?></p>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Blank</h5>
                            <p class="card-text">h</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- task info field ends -->

    <!-- assign task to employee -->
    <div class="container border mt-5">
        <form action="" method="post">
            <h4><label for="">Assign this task...</label></h4>
            <div class="input-group mb-3">
                <label class="input-group-text" for="inputGroupSelect01">Options</label>
                <select class="form-select" id="inputGroupSelect01" name="selectEmployee">
                    <?php foreach($querytogetallEmployeesResultFinal as $user):  ?>
                    <option value="<?php echo $user['token']; ?>">
                        <?php
                            echo $user['emp_name'];
                            ?>
                    </option>
                    <?php endforeach;  ?>
                </select>
            </div>
            <button name="submit" class="btn btn-info" <?php if ($disableAssignTaskBUtton) echo 'disabled' ;?>>Assign Task</button>
            <?php
                if(isset($_SESSION['task_assigned'])){
                    echo $_SESSION['task_assigned'];
                    echo "<script> setTimeout(function(){unsetSession();}, 5000); </script>";
                    if(isset($_GET['unset'])&& $_GET['unset']==='1'){
                        unset($_SESSION['task_assigned']);
                    }
                }else{
                    echo '';
                }
                if(isset($_SESSION['task_notAssigned'])){
                    echo $_SESSION['task_notAssigned'];
                    echo "<script> setTimeout(function(){unsetSession();}, 5000); </script>";
                    if(isset($_GET['unset'])&& $_GET['unset']==='1'){
                        unset($_SESSION['task_notAssigned']);
                    }
                }else{
                    echo '';
                }


            ?>
        </form>
    </div>
    <!-- assign task to employee ends-->


    <?php
    echo 
    '<script>
        function unsetSession(){
            var xhr = new XMLHttpRequest();
            xhr.open("GET", "assign_tasks_by_manager.php?unset=1", true)
            xhr.send();
            
        }
    </script>';
    ?>
</body>

</html>