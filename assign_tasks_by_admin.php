<?php

session_start();
if(!isset($_SESSION['email']) || $_SESSION['loggedin']!== true){
    header("location:login.php");
}

// error handling
error_reporting(E_ALL);
ini_set('display_errors',1);

require_once 'db_connection.php';

$activePage = 'tasks';

$tokenOfManager = $_GET['token'];
$querytoGetUserData = "SELECT * FROM registrationdata WHERE token = '$tokenOfManager'";
$querytoGetUserDataResult = mysqli_query($conn, $querytoGetUserData);
$querytoGetUserDataFinal = mysqli_fetch_assoc($querytoGetUserDataResult);
$managerDept = $querytoGetUserDataFinal['department'];


// code for the table to show all tasks
if($managerDept === 'hr_dept'){
    // code to show all tasks starts
    $querytoShowAllTasks = "SELECT * from hr_tasks WHERE manager_token = '$tokenOfManager'";
    $querytoShowAllTasksResult = mysqli_query($conn, $querytoShowAllTasks);
    $querytoShowAllTasksResultFinal = array();
    if($querytoShowAllTasksResult){
        while($row = mysqli_fetch_assoc($querytoShowAllTasksResult)){
            $querytoShowAllTasksResultFinal[] = $row;
        }
    }
    }elseif($managerDept === 'it_dept'){
    // code to show all tasks starts
    $querytoShowAllTasks = "SELECT * from it_tasks WHERE manager_token = '$tokenOfManager'";
    $querytoShowAllTasksResult = mysqli_query($conn, $querytoShowAllTasks);
    $querytoShowAllTasksResultFinal = array();
    if($querytoShowAllTasksResult){
        while($row = mysqli_fetch_assoc($querytoShowAllTasksResult)){
            $querytoShowAllTasksResultFinal[] = $row;
        }
    }
    }elseif($managerDept === 'finance_dept'){
            // code to show all tasks starts
    $querytoShowAllTasks = "SELECT * from finance_tasks WHERE manager_token = '$tokenOfManager'";
    $querytoShowAllTasksResult = mysqli_query($conn, $querytoShowAllTasks);
    $querytoShowAllTasksResultFinal = array();
    if($querytoShowAllTasksResult){
        while($row = mysqli_fetch_assoc($querytoShowAllTasksResult)){
            $querytoShowAllTasksResultFinal[] = $row;
        }
    }
}
// ends here


// to upload task, code start here

if(isset($_POST['submit'])){
    $task_name = mysqli_real_escape_string($conn, $_POST['task_name']);
    $task_token = bin2hex(random_bytes(16));
    $timestamp = date('Y-m-d H:i:s'); 
    $task_file = $_FILES['task_file']['name'];
    $tmp_name = $_FILES['task_file']['tmp_name'];
    $folder = "task_file/" . $task_file;
    
    if($managerDept === 'hr_dept'){
        if($task_name !== '' && (isset($task_file))){
            $querytoChecksimilarTask = "SELECT * from hr_tasks WHERE task_address = '$task_file'";
            $querytoChecksimilarTaskResult = mysqli_query($conn, $querytoChecksimilarTask);
            if(mysqli_num_rows($querytoChecksimilarTaskResult)>0){
                $_SESSION['alreadyAssignedTask'] = "This task has already been assigned";
                header("location:assign_tasks_by_admin.php?token=" . $tokenOfManager);
            }else{
                $querytoAssignTask = "INSERT INTO hr_tasks  (task_name, task_token, manager_token, if_manager, task_address, created_at, updated_at)VALUES('$task_name', '$task_token', '$tokenOfManager', 'yes', '$task_file', '$timestamp', '$timestamp')";
                $querytoAssignTaskResult = mysqli_query($conn, $querytoAssignTask);
                move_uploaded_file($tmp_name, $folder);
                if( $querytoAssignTaskResult){
                    $_SESSION['successoftaskUpdation'] = "Task has been assigned.";
                    header("location:assign_tasks_by_admin.php?token=" . $tokenOfManager);
                }else{
                    $_SESSION['failureOfTaskUpdation'] = "Task has not been assigned.";
                    header("location:assign_tasks_by_admin.php?token=" . $tokenOfManager);
                }
            }
        }else{
            $_SESSION['emotyFileOrName'] = "Please enter a name and select a file";
        }
    }elseif($managerDept === 'it_dept'){
        if($task_name !== '' && (isset($task_file))){
            $querytoChecksimilarTask = "SELECT * from it_tasks WHERE task_address = '$task_file'";
            $querytoChecksimilarTaskResult = mysqli_query($conn, $querytoChecksimilarTask);
            $querytoChecksimilarTaskResultFinal = mysqli_fetch_all($querytoChecksimilarTaskResult, MYSQLI_ASSOC);
            if(mysqli_num_rows($querytoChecksimilarTaskResult)>0){
                $_SESSION['alreadyAssignedTask'] = "This task has already been assigned";
                header("location:assign_tasks_by_admin.php?token=" . $tokenOfManager);
            }else{
                $querytoAssignTask = "INSERT INTO it_tasks  (task_name, task_token, manager_token, if_manager, task_address, created_at, updated_at)VALUES('$task_name', '$task_token', '$tokenOfManager', 'yes', '$task_file', '$timestamp', '$timestamp')";
                $querytoAssignTaskResult = mysqli_query($conn, $querytoAssignTask);
                move_uploaded_file($tmp_name, $folder);
            
                if( $querytoAssignTaskResult){
                    $_SESSION['successoftaskUpdation'] = "Task has been assigned.";
                    header("location:assign_tasks_by_admin.php?token=" . $tokenOfManager);
                }else{
                    $_SESSION['failureOfTaskUpdation'] = "Task has not been assigned.";
                    header("location:assign_tasks_by_admin.php?token=" . $tokenOfManager);
                }
            }
        }else{
            $_SESSION['emotyFileOrName'] = "Please enter a name and select a file";
        }
    }elseif($managerDept === 'finance_dept' && $task_name !== '' && (isset($task_file))){
        if($task_name !== '' && (isset($task_file))){
            $querytoChecksimilarTask = "SELECT * from finance_tasks WHERE task_address = '$task_file'";
            $querytoChecksimilarTaskResult = mysqli_query($conn, $querytoChecksimilarTask);
            $querytoChecksimilarTaskResultFinal = mysqli_fetch_all($querytoChecksimilarTaskResult, MYSQLI_ASSOC);
            if(mysqli_num_rows($querytoChecksimilarTaskResult)>0){
                $_SESSION['alreadyAssignedTask'] = "This task has already been assigned";
                header("location:assign_tasks_by_admin.php?token=" . $tokenOfManager);
            }else{
                $querytoAssignTask = "INSERT INTO finance_tasks  (task_name, task_token, manager_token, if_manager,  task_address, created_at, updated_at)VALUES('$task_name', '$task_token', '$tokenOfManager', 'yes', '$task_file', '$timestamp', '$timestamp')";
                $querytoAssignTaskResult = mysqli_query($conn, $querytoAssignTask);
                move_uploaded_file($tmp_name, $folder);
            
                if( $querytoAssignTaskResult){
                    $_SESSION['successoftaskUpdation'] = "Task has been assigned.";
                    header("location:assign_tasks_by_admin.php?token=" . $tokenOfManager);
                }else{
                    $_SESSION['failureOfTaskUpdation'] = "Task has not been assigned.";
                    header("location:assign_tasks_by_admin.php?token=" . $tokenOfManager);
                }
            }
        }else{
            $_SESSION['emotyFileOrName'] = "Please enter a name and select a file";
        }
    }

}

// to upload task, code ends here

// code to delete selected tasks
if(isset($_POST['deleteButton']) && $managerDept === 'it_dept'){
    $all_task = $_POST['checkboxtoDeleteTask'];
    $extract_id = implode(',', $all_task);
    $querytoDeleteTasks = "DELETE FROM it_tasks WHERE task_token IN('$extract_id')";
    $querytoDeleteTasksResult = mysqli_query($conn, $querytoDeleteTasks);
    if($querytoDeleteTasksResult){
        $_SESSION['taskDeleted'] = "Tasks have been deleted successfully";
        header("location:assign_tasks_by_admin.php?token=" . $tokenOfManager);
    }else{
        $_SESSION['taskNotDeleted'] = "Tasks have not been deleted due to technical problems";
        header("location:assign_tasks_by_admin.php?token=" . $tokenOfManager);
    }
}elseif(isset($_POST['deleteButton']) && $managerDept === 'hr_dept'){
    $all_task = $_POST['checkboxtoDeleteTask'];
    $extract_id = implode(',', $all_task );
    $querytoDeleteTasks = "DELETE FROM hr_tasks WHERE task_token IN('$extract_id')";
    $querytoDeleteTasksResult = mysqli_query($conn, $querytoDeleteTasks);
    if($querytoDeleteTasksResult){
        $_SESSION['taskDeleted'] = "Tasks have been deleted successfully";
        header("location:assign_tasks_by_admin.php?token=" . $tokenOfManager);
    }else{
        $_SESSION['taskNotDeleted'] = "Tasks have not been deleted due to technical problems";
        header("location:assign_tasks_by_admin.php?token=" . $tokenOfManager);
    }
}elseif(isset($_POST['deleteButton']) && $managerDept === 'finance_dept'){
    $all_task = $_POST['checkboxtoDeleteTask'];
    $extract_id = implode(',', $all_task );
    $querytoDeleteTasks = "DELETE FROM finance_tasks WHERE task_token IN('$extract_id')";
    $querytoDeleteTasksResult = mysqli_query($conn, $querytoDeleteTasks);
    if($querytoDeleteTasksResult){
        $_SESSION['taskDeleted'] = "Tasks have been deleted successfully";
        header("location:assign_tasks_by_admin.php?token=" . $tokenOfManager);
    }else{
        $_SESSION['taskNotDeleted'] = "Tasks have not been deleted due to technical problems";
        header("location:assign_tasks_by_admin.php?token=" . $tokenOfManager);
    }
}

// code to delete selected tasks ends here


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
    </style>
</head>

<body>
    <!-- navbar -->
    <?php include 'navbar.php'; ?>
    <!-- Navbar finished -->


    <!--  personal info field start -->
    <div class="container">
        <div class="container text-center mt-5">
            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Name</h5>
                            <p class="card-text"><?php echo $querytoGetUserDataFinal['name']; ?></p>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Total Assigned Tasks</h5>
                            <p class="card-text">h</p>
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
    <!-- personal info field ends -->


    <!-- assign task starts here -->
    <div class="container mt-3 border">
        <h4><label for="">Assign Task</label></h4>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Task name</label>
                <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                    name="task_name" required>
            </div>
            <div class="input-group mb-3">
                <input type="file" class="form-control" id="inputGroupFile02" name="task_file" required>
                <label class="input-group-text" for="inputGroupFile02">Upload</label>
            </div>
            <button name="submit" class="btn btn-primary">Assign task</button>
        </form>
        <?php
                if(isset($_SESSION['successoftaskUpdation'])){
                    echo $_SESSION['successoftaskUpdation'];
                    echo "<script>setTimeout(function(){unsetSession(); }, 5000);</script>";
                    if (isset($_GET['unset']) && $_GET['unset'] === '1') {
                        unset($_SESSION['successoftaskUpdation']);
                    } 
                }else{
                    echo '';
                }
                
                if(isset($_SESSION['failureOfTaskUpdation'])){
                    echo $_SESSION['failureOfTaskUpdation'];
                    echo "<script>setTimeout(function(){unsetSession(); }, 5000);</script>";
                    if (isset($_GET['unset']) && $_GET['unset'] === '1') {
                        unset($_SESSION['failureOfTaskUpdation']);
                    } 
                }else{
                    echo '';
                }
                if(isset($_SESSION['alreadyAssignedTask'])){
                    echo $_SESSION['alreadyAssignedTask'];
                    echo "<script>setTimeout(function(){unsetSession(); }, 5000);</script>";
                    if (isset($_GET['unset']) && $_GET['unset'] === '1') {
                        unset($_SESSION['alreadyAssignedTask']);
                    }                
                }else{
                    echo '';
                }
                if(isset($_SESSION['emotyFileOrName'])){
                    echo $_SESSION['emotyFileOrName'];
                    echo "<script>setTimeout(function(){unsetSession(); }, 5000);</script>";
                    if (isset($_GET['unset']) && $_GET['unset'] === '1') {
                        unset($_SESSION['emotyFileOrName']);
                    } 
                }else{
                    echo '';
                }
                ?>
    </div>
    <!-- assign task ends here -->

    <!-- table for all tasks starts -->
    <form action="" method="post">
        <div class="container mt-5">
            <?php
            if(isset($_SESSION['taskDeleted'])){
                echo $_SESSION['taskDeleted'];
                echo "<script>setTimeout(function(){unsetSession(); }, 5000);</script>";
                if(isset($_GET['unset']) && $_GET['unset'] === '1'){
                    unset($_SESSION['taskDeleted']);
                }
            }else{
                echo '';
            }
            if(isset($_SESSION['taskNotDeleted'])){
                echo $_SESSION['taskNotDeleted'];
                echo "<script>setTimeout(function(){unsetSession(); }, 5000);</script>";
                if(isset($_GET['unset']) && $_GET['unset'] === '1'){
                    unset($_SESSION['taskNotDeleted']);
                }
            }else{
                echo '';
            }








            ?>
            <h2><label for="">All Tasks</label></h2>
            <table id="myTable" class="display">
                <thead>
                    <tr>
                        <th>Action</th>
                        <th>Task Name</th>
                        <th>Assigned At</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                 foreach($querytoShowAllTasksResultFinal as $user): 
                 ?>
                    <tr>
                        <td>
                            <div class="form-check">
                                <input name="checkboxtoDeleteTask[]" type="checkbox" class="form-check-input"
                                    value="<?php echo $user['task_token'] ?>">
                            </div>
                        </td>
                        <td><?php echo ucfirst($user['task_name']);?></td>
                        <td><?php echo date('j M Y' , strtotime(($user['created_at'])));?></td>
                    </tr>
                    <?php
                 endforeach; 
                 ?>
                </tbody>
            </table>
            <button type="submit" name="deleteButton" class="btn btn-danger">Delete</button>
        </div>
    </form>
    <!-- table for all tasks ends -->

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
        xhr.open("GET", "assign_tasks_by_admin.php?unset=1", true);
        xhr.send();
    }
    </script>';
    ?>
</body>

</html>