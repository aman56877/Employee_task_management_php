<?php


// error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'db_connection.php';

$activePage = 'departments';

$query = "SELECT * from hr_dept WHERE position = 'manager'";
$users = mysqli_query($conn, $query);

$user = mysqli_fetch_assoc($users);

session_start();
if(!isset($_SESSION['email']) || $_SESSION['loggedin']!==true){
    header("location:login.php");
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
                    <th>Role</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $serialNumber = 1;
                 foreach($users as $user): 
                 ?>
                <tr>
                    <td> <?php echo $serialNumber ?> </td>
                    <td><?php echo ucfirst($user['emp_name']);?></td>
                    <td><?php echo ucfirst($user['position']);?></td>
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