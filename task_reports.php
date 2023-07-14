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
$managerDept = $ManagerToken['department'];

// code for the table to show all tasks
if($managerDept === 'hr_dept'){
    // code to show all tasks starts
    $querytoShowAllTasks = "SELECT * from hr_tasks WHERE manager_token = '$tokenofManager' AND report IS NOT NULL";
    $querytoShowAllTasksResult = mysqli_query($conn, $querytoShowAllTasks);
    $querytoShowAllTasksResultFinal = array();
    if($querytoShowAllTasksResult){
        while($row = mysqli_fetch_assoc($querytoShowAllTasksResult)){
            $querytoShowAllTasksResultFinal[] = $row;
        }
    }
    }elseif($managerDept === 'it_dept'){
    // code to show all tasks starts
    $querytoShowAllTasks = "SELECT * from it_tasks WHERE manager_token = '$tokenofManager' AND report IS NOT NULL";
    $querytoShowAllTasksResult = mysqli_query($conn, $querytoShowAllTasks);
    $querytoShowAllTasksResultFinal = array();
    if($querytoShowAllTasksResult){
        while($row = mysqli_fetch_assoc($querytoShowAllTasksResult)){
            $querytoShowAllTasksResultFinal[] = $row;
        }
    }
    }elseif($managerDept === 'finance_dept'){
    // code to show all tasks starts
    $querytoShowAllTasks = "SELECT * from finance_tasks WHERE manager_token = '$tokenofManager' AND report IS NOT NULL";
    $querytoShowAllTasksResult = mysqli_query($conn, $querytoShowAllTasks);
    $querytoShowAllTasksResultFinal = array();
    if($querytoShowAllTasksResult){
        while($row = mysqli_fetch_assoc($querytoShowAllTasksResult)){
            $querytoShowAllTasksResultFinal[] = $row;
        }
    }
}
// ends here



// code to complete task by manager
if($managerDept = 'it_dept'){
    if(isset($_POST['submit'])){
        $all_task = $_POST['checkboxtoCompleteTask'];
        $extract_token = implode(',', $all_task);

        $querytoCompleteTaskByManager = "UPDATE it_tasks SET employee_token = NULL, if_employee = NULL, status = 'completed', updated_at = NOW() WHERE task_token IN('$extract_token')";
        $querytoCompleteTaskByManagerResult = mysqli_query($conn, $querytoCompleteTaskByManager);
        if($querytoCompleteTaskByManagerResult){
            $_SESSION['completed'] = "This task has been assigned as completed";
            header("location:task_reports.php");
        }else{
            $_SESSION['notCompleted'] = "Your task has not been completed";
        }
    }
}elseif($managerDept = 'hr_dept'){
    if(isset($_POST['submit'])){
        $all_task = $_POST['checkboxtoCompleteTsask'];
        $extract_token = implode(',', $all_task);

        $querytoCompleteTaskByManager = "UPDATE hr_tasks SET employee_token = NULL, if_employee = NULL, status = 'completed', updated_at = NOW() WHERE task_token IN('$extract_token')";
        $querytoCompleteTaskByManagerResult = mysqli_query($conn, $querytoCompleteTaskByManager);
        if($querytoCompleteTaskByManagerResult){
            $_SESSION['completed'] = "This task has been assigned as completed";
            header("location:task_reports.php");
        }else{
            $_SESSION['notCompleted'] = "Your task has not been completed";
        }
    }

}elseif($managerDept = 'finance_dept'){
    if(isset($_POST['submit'])){
        $all_task = $_POST['checkboxtoCompleteTask'];
        $extract_token = implode(',', $all_task);

        $querytoCompleteTaskByManager = "UPDATE finance_tasks SET employee_token = NULL, if_employee = NULL, status = 'completed', updated_at = NOW() WHERE task_token IN('$extract_token')";
        $querytoCompleteTaskByManagerResult = mysqli_query($conn, $querytoCompleteTaskByManager);
        if($querytoCompleteTaskByManagerResult){
            $_SESSION['completed'] = "This task has been assigned as completed";
            header("location:task_reports.php");
        }else{
            $_SESSION['notCompleted'] = "Your task has not been completed";
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
                        <a class="nav-link" aria-current="page" href="manager.php">Dashboard</a>
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
                        <a class="nav-link " aria-current="page" href="manager_all_tasks.php">All Tasks</a>
                    </li>
                    <li>
                        <a class="nav-link active" aria-current="page" href="task_reports.php">Submitted Reports</a>
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
        <form action="" method="post">
            <table id="myTable" class="display">
                <thead>
                    <tr>
                        <th>Action</th>
                        <th> Task Name</th>
                        <th> Submitted By</th>
                        <th>Completed Report</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                 foreach($querytoShowAllTasksResultFinal as $user): 
                    ?>
                    <tr>
                        <td>
                            <?php
                            if($user['employee_token']=== NULL && $user['if_employee'] === NULL && $user['report'] !== NULL): ?>
                                <?php echo "Completed"; ?>
                            <?php elseif($user['employee_token']!== NULL && $user['if_employee'] !== NULL && $user['report'] !== NULL):   ?>
                                <div class="form-check">
                                <input id="checkboxtocompletetask" name="checkboxtoCompleteTask[]" type="checkbox"
                                    class="form-check-input" value="<?php echo $user['task_token'] ?>">
                            </div>
                            <?php endif;  ?>
                        </td>
                        <td><?php echo ucfirst($user['task_name']);?></a></td>
                        <td>
                            <?php
                    $taskToken = $user['task_token'];
                    if($managerDept === 'it_dept'){
                        $querytocheckTaskAssignee = "SELECT * FROM it_tasks WHERE task_token = '$taskToken'";
                        $querytocheckTaskAssigneeResult = mysqli_query($conn, $querytocheckTaskAssignee);
                        if ($querytocheckTaskAssigneeResult && mysqli_num_rows($querytocheckTaskAssigneeResult) > 0) {
                            $querytocheckTaskAssigneeResultFinal = mysqli_fetch_assoc($querytocheckTaskAssigneeResult);
                            $assigneeToken = $querytocheckTaskAssigneeResultFinal['employee_token'];
                            if ($assigneeToken === NULL && $querytocheckTaskAssigneeResultFinal['status']=== NULL) {
                                echo "None";
                            }elseif($assigneeToken === NULL && $querytocheckTaskAssigneeResultFinal['status']=== 'completed'){
                                echo "Completed";
                            }else{
                                $querytocheckTaskAssigneeName = "SELECT * FROM it_dept WHERE token = '$assigneeToken' AND position = 'user'";
                                $querytocheckTaskAssigneeNameResult = mysqli_query($conn, $querytocheckTaskAssigneeName);
                                $querytocheckTaskAssigneeNameResultFinal = mysqli_fetch_assoc($querytocheckTaskAssigneeNameResult);
                                $assigneeName = $querytocheckTaskAssigneeNameResultFinal['emp_name'];
                                echo $assigneeName;

                            }
                        }
                        
                    }elseif($managerDept === 'hr_dept'){
                        $querytocheckTaskAssignee = "SELECT * FROM hr_tasks WHERE task_token = '$taskToken'";
                        $querytocheckTaskAssigneeResult = mysqli_query($conn, $querytocheckTaskAssignee);
                        if ($querytocheckTaskAssigneeResult && mysqli_num_rows($querytocheckTaskAssigneeResult) > 0) {
                            $querytocheckTaskAssigneeResultFinal = mysqli_fetch_assoc($querytocheckTaskAssigneeResult);
                            $assigneeToken = $querytocheckTaskAssigneeResultFinal['employee_token'];
                            if ($assigneeToken === NULL && $querytocheckTaskAssigneeResultFinal['status']=== NULL) {
                                echo "None";
                            }elseif($assigneeToken === NULL && $querytocheckTaskAssigneeResultFinal['status']=== 'completed'){
                                echo "Completed";
                            }else{
                                $querytocheckTaskAssigneeName = "SELECT * FROM hr_dept WHERE token = '$assigneeToken' AND position = 'user'";
                                $querytocheckTaskAssigneeNameResult = mysqli_query($conn, $querytocheckTaskAssigneeName);
                                $querytocheckTaskAssigneeNameResultFinal = mysqli_fetch_assoc($querytocheckTaskAssigneeNameResult);
                                $assigneeName = $querytocheckTaskAssigneeNameResultFinal['emp_name'];
                                echo $assigneeName;

                            }
                        }

                    }elseif($managerDept === 'finance_dept'){
                        $querytocheckTaskAssignee = "SELECT * FROM finance_tasks WHERE task_token = '$taskToken'";
                        $querytocheckTaskAssigneeResult = mysqli_query($conn, $querytocheckTaskAssignee);
                        if ($querytocheckTaskAssigneeResult && mysqli_num_rows($querytocheckTaskAssigneeResult) > 0) {
                            $querytocheckTaskAssigneeResultFinal = mysqli_fetch_assoc($querytocheckTaskAssigneeResult);
                            $assigneeToken = $querytocheckTaskAssigneeResultFinal['employee_token'];
                            if ($assigneeToken === NULL && $querytocheckTaskAssigneeResultFinal['status']=== NULL) {
                                echo "None";
                            }elseif($assigneeToken === NULL && $querytocheckTaskAssigneeResultFinal['status']=== 'completed'){
                                echo "Completed";
                            }else{
                                $querytocheckTaskAssigneeName = "SELECT * FROM finance_dept WHERE token = '$assigneeToken' AND position = 'user'";
                                $querytocheckTaskAssigneeNameResult = mysqli_query($conn, $querytocheckTaskAssigneeName);
                                $querytocheckTaskAssigneeNameResultFinal = mysqli_fetch_assoc($querytocheckTaskAssigneeNameResult);
                                $assigneeName = $querytocheckTaskAssigneeNameResultFinal['emp_name'];
                                echo $assigneeName;

                            }
                        }

                    }
                ?>
                        </td>

                        <td><a style="color: black;" href="report/<?php echo ($user['report']); ?>"
                                target="_blank"><?php echo ucfirst($user['report']);?></a></td>
                    </tr>
                    <?php
                 endforeach; 
                 ?>
                </tbody>
            </table>
            <button class="btn btn-info" name="submit">Mark as Complete</button>
        </form>
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