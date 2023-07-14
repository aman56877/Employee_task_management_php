<?php
require_once 'db_connection.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);


session_start();
if(!isset($_SESSION['email']) || $_SESSION['manager_page']!==true){
    header("location:login.php");
}


$tokenofUser = $_GET['token'];

$tokenofManager = $_SESSION['token'];
$queryforManagerToken = "SELECT * from registrationdata WHERE token = '$tokenofManager'";
$resultforManagerToken = mysqli_query($conn, $queryforManagerToken);

$ManagerToken = mysqli_fetch_assoc($resultforManagerToken);
$ManagerDepartment = $ManagerToken['department'];


// code to get user information
if($ManagerDepartment === 'it_dept'){
    $querytogetUserName = "SELECT * FROM it_dept WHERE token = '$tokenofUser'";
    $querytogetUserNameResult = mysqli_query($conn, $querytogetUserName);
    if ($querytogetUserNameResult && mysqli_num_rows($querytogetUserNameResult) > 0) {
        $querytogetUserNameResultFinal = mysqli_fetch_assoc($querytogetUserNameResult);
        $empName = $querytogetUserNameResultFinal['emp_name'];
    }

    // code for the table
    $querytogetUserTasks= "SELECT * FROM it_tasks WHERE employee_token = '$tokenofUser'";
    $querytogetUserTasksResult = mysqli_query($conn, $querytogetUserTasks);
    $querytogetUserTasksResultFinal = array();
    
    if($querytogetUserTasksResult){
        while($row = mysqli_fetch_assoc($querytogetUserTasksResult)){
            $querytogetUserTasksResultFinal[] = $row;
        }
    }
    // ends here

    // code to delete the task 
    if(isset($_POST['submit'])){
        $all_task = $_POST['checkboxtoDeleteTask'];
        if(isset($all_task) && !empty($all_task)){
            $extract_taskToken = implode(',', $all_task);   
            $querytoDeleteTask = "UPDATE  it_tasks SET  employee_token = NULL, if_employee = NULL, updated_at = NOW() WHERE task_token IN('$extract_taskToken')";
            $querytoDeleteTaskResult = mysqli_query($conn, $querytoDeleteTask);
            if($querytoDeleteTaskResult){
                $_SESSION['taskAssigned'] = "Task has been deleted";
                header("location:employees_of_manager.php?token=" . $tokenofUser);
            }else{
                $_SESSION['notAssigned'] = "Task has not been deleted due to technical problems";
                header("location:employees_of_manager.php?token=" . $tokenofUser);
            }
        }else{
            $_SESSION['selectTask'] = "Please select at least one task.";
            header("location:employees_of_manager.php?token=" . $tokenofUser);
        }
    }
    // ends here


}elseif($ManagerDepartment === 'hr_dept'){
    $querytogetUserName = "SELECT * FROM hr_dept WHERE token = '$tokenofUser'";
    $querytogetUserNameResult = mysqli_query($conn, $querytogetUserName);
    if ($querytogetUserNameResult && mysqli_num_rows($querytogetUserNameResult) > 0) {
        $querytogetUserNameResultFinal = mysqli_fetch_assoc($querytogetUserNameResult);
        $empName = $querytogetUserNameResultFinal['emp_name'];
    }

    // code for the table
    $querytogetUserTasks= "SELECT * FROM hr_tasks WHERE employee_token = '$tokenofUser'";
    $querytogetUserTasksResult = mysqli_query($conn, $querytogetUserTasks);
    $querytogetUserTasksResultFinal = array();
    
    if($querytogetUserTasksResult){
        while($row = mysqli_fetch_assoc($querytogetUserTasksResult)){
            $querytogetUserTasksResultFinal[] = $row;
        }
    }
    // ends here

    // code to delete the task 
    if(isset($_POST['submit'])){
        $all_task = $_POST['checkboxtoDeleteTask'];
        if(isset($all_task) && !empty($all_task)){
            $extract_taskToken = implode(',', $all_task);   
            $querytoDeleteTask = "UPDATE  hr_tasks SET  employee_token = NULL, if_employee = NULL, updated_at = NOW() WHERE task_token IN('$extract_taskToken')";
            $querytoDeleteTaskResult = mysqli_query($conn, $querytoDeleteTask);
            if($querytoDeleteTaskResult){
                $_SESSION['taskAssigned'] = "Task has been deleted";
                header("location:employees_of_manager.php?token=" . $tokenofUser);
            }else{
                $_SESSION['notAssigned'] = "Task has not been deleted due to technical problems";
                header("location:employees_of_manager.php?token=" . $tokenofUser);
            }
        }else{
            $_SESSION['selectTask'] = "Please select at least one task.";
            header("location:employees_of_manager.php?token=" . $tokenofUser);
        }
    }
    // ends here

}elseif($ManagerDepartment === 'finance_dept'){
    $querytogetUserName = "SELECT * FROM finance_dept WHERE token = '$tokenofUser'";
    $querytogetUserNameResult = mysqli_query($conn, $querytogetUserName);
    if ($querytogetUserNameResult && mysqli_num_rows($querytogetUserNameResult) > 0) {
        $querytogetUserNameResultFinal = mysqli_fetch_assoc($querytogetUserNameResult);
        $empName = $querytogetUserNameResultFinal['emp_name'];
    }
    // code for the table
    $querytogetUserTasks= "SELECT * FROM finance_tasks WHERE employee_token = '$tokenofUser'";
    $querytogetUserTasksResult = mysqli_query($conn, $querytogetUserTasks);
    $querytogetUserTasksResultFinal = array();
    
    if($querytogetUserTasksResult){
        while($row = mysqli_fetch_assoc($querytogetUserTasksResult)){
            $querytogetUserTasksResultFinal[] = $row;
        }
    }
    // ends here

    // code to delete the task 
    if(isset($_POST['submit'])){
        $all_task = $_POST['checkboxtoDeleteTask'];
        if(isset($all_task) && !empty($all_task)){
            $extract_taskToken = implode(',', $all_task);   
            $querytoDeleteTask = "UPDATE  finance_tasks SET  employee_token = NULL, if_employee = NULL, updated_at = NOW() WHERE task_token IN('$extract_taskToken')";
            $querytoDeleteTaskResult = mysqli_query($conn, $querytoDeleteTask);
            if($querytoDeleteTaskResult){
                $_SESSION['taskAssigned'] = "Task has been deleted";
                header("location:employees_of_manager.php?token=" . $tokenofUser);
            }else{
                $_SESSION['notAssigned'] = "Task has not been deleted due to technical problems";
                header("location:employees_of_manager.php?token=" . $tokenofUser);
            }
        }else{
            $_SESSION['selectTask'] = "Please select at least one task.";
            header("location:employees_of_manager.php?token=" . $tokenofUser);
        }
    }
    // ends here
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
                    <?php
                        if($ManagerDepartment === 'it_dept'): ?>
                            <li>
                                <a class="nav-link active" aria-current="page" href="it_dept_for_manager.php">Department</a>
                            </li>
                        <?php elseif($ManagerDepartment === 'hr_dept'): ?>
                            <li>
                                <a class="nav-link active" aria-current="page" href="hr_dept_for_manager.php">Department</a>
                            </li>
                        <?php elseif($ManagerDepartment === 'finance_dept'):?>
                            <li>
                                <a class="nav-link active" aria-current="page" href="finance_dept_for_manager.php">Department</a>
                            </li>
                        
                        <?php endif;?>
                    <li>
                        <a class="nav-link " aria-current="page" href="manager_all_tasks.php">All Tasks</a>
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
                            <p class="card-text"><?php echo $empName; ?></p>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Blank</h5>
                            <p class="card-text"><?php echo "--";?></p>
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

    <!-- Table starts -->
    <form action="" method="post">
        <div class="container mt-5">
            <table id="myTable" class="display">
                <thead>
                    <tr>
                        <th>Action</th>
                        <th>Name</th>
                        <th>Report</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                $serialNumber = 1;
                 foreach($querytogetUserTasksResultFinal as $user): 
                 ?>
                    <tr>
                        <td>
                            <div class="form-check">
                                <input id="checkboxtodelete" name="checkboxtoDeleteTask[]" type="checkbox"
                                    class="form-check-input" value="<?php echo $user['task_token'] ?>">
                            </div>
                        </td>
                        <td><?php echo $user['task_name'];?></td>
                        <td><?php
                if($user['report'] === NULL){
                    echo "Not submitted";
                }else{
                    echo "Submitted";
                }
                ?> </td>
                    </tr>
                    <?php
                $serialNumber++;
                 endforeach; 
                 ?>
                </tbody>
            </table>
            <button id="buttontodelete" disabled name="submit" class="btn btn-info">Unassign</button>
            <?php
        if(isset($_SESSION['taskAssigned'])){
            echo $_SESSION['taskAssigned'];
            echo "<script>setTimeout(function(){unsetSession();}, 5000);</script>";
            if(isset($_GET['unset']) && $_GET['unset']=== '1'){
                unset($_SESSION['taskAssigned']);
            }
        }else{
            echo '';
        }
        if(isset($_SESSION['notAssigned'])){
            echo $_SESSION['notAssigned'];
            echo "<script> setTimeout(function(){unsetSession();}, 5000); </script>";
            if(isset($_GET['unset']) && $_GET['unset']=== '1'){
                unset($_SESSION['notAssigned']);
            }
        }else{
            echo '';
        }
        if(isset($_SESSION['selectTask'])){
            echo $_SESSION['selectTask'];
            echo "<script> setTimeout(function(){unsetSession();}, 5000); </script>";
            if(isset($_GET['unset']) && $_GET['unset']=== '1'){
                unset($_SESSION['selectTask']);
            }
        }else{
            echo '';
        }
        ?>
        </div>
    </form>
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

    <?php
    echo 
    '<script>
        function unsetSession(){
            var xhr = new XMLHttpRequest();
            xhr.open("GET", "employees_of_manager.php?unset=1", true)
            xhr.send();
            
        }
    </script>';
    ?>

    <script>
    var checkboxes = document.querySelectorAll('input[name="checkboxtoDeleteTask[]"]');
    var button = document.querySelector('#buttontodelete');

    checkboxes.forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            var isAnyChecked = Array.from(checkboxes).some(function(cb) {
                return cb.checked;
            });
            button.disabled = !isAnyChecked;
        });
    });
    </script>
</body>

</html>