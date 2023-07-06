<?php

require_once 'db_connection.php';

session_start();
if(!isset($_SESSION['email']) || $_SESSION['loggedin']!== true){
    header("location:login.php");
}

$activePage = 'tasks';

$query = "SELECT * FROM registrationdata WHERE role = 'manager' AND verification_status = 'verified'";
$resultforAllManagers = mysqli_query($conn, $query);
$allManagers = array();

if($resultforAllManagers){
    while($row = mysqli_fetch_assoc($resultforAllManagers)){
        $allManagers[] = $row;
    }
}else{
    echo "Error";
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
    </style>
</head>

<body>
    <!-- navbar -->
    <?php include 'navbar.php'; ?>
    <!-- Navbar finished -->


    <!-- Table starts -->
    <div class="container">
        <table id="myTable" class="display">
            <thead>
                <tr>
                    <th>S.No.</th>
                    <th>Name</th>
                    <th>Department</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $serialNumber = 1;
                 foreach($allManagers as $user): 
                 ?>
                <tr>
                    <td> <?php echo $serialNumber ?> </td>
                    <td> <a style="color: black;" href="assign_tasks_by_admin.php?token=<?php echo $user['token']; ?>"> <?php echo $user['name']; ?> </a> </td>
                    <td>
                    <?php 
                    if($user['department'] === 'it_dept'){ 
                        echo "Information and Technology";
                    }elseif($user['department'] === 'hr_dept'){
                        echo "Human Resource";
                    }elseif($user['department'] === 'finance_dept'){
                        echo "Finance";
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
