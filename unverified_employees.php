<?php

require_once 'db_connection.php';

// variable to make the employees page active while on it.
$activePage = 'employees';


session_start();
if(!isset($_SESSION['email'])|| $_SESSION['loggedin'] !== true){
    header("location:login.php");
}

$query = "SELECT * FROM registrationdata WHERE (role = 'manager' OR role = 'user' OR role = 'admin') AND verification_status = 'unverify'";
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
                    <th>Requested Role</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $serialNumber = 1;
                 foreach($users as $user): 
                 ?>
                <tr>
                    <td> <?php echo $serialNumber ?> </td>
                    <td><a href="employee_info.php?token=<?php echo $user['token']; ?>" style="color: black;"
                            title="<?php echo ($user['name']); ?>"><?php echo ucfirst($user['name']);?>
                        </a></td>
                    <td><?php  echo ucfirst($user['role']) ?> </td>
                    <td> <?php  echo ucfirst($user['verification_status']) ?> </td>
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





    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous">
    </script>
</body>

</html>