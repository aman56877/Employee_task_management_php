<?php
$activePage = 'dashboard';

require_once 'db_connection.php';

session_start();
if(!isset($_SESSION['email'])|| $_SESSION['loggedin'] !== true){
    header("location:login.php");
}

include 'name_on_profile.php';

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

    .card-grid {
        display: flex;
        text-align: -webkit-center;
    }

    .card img {
        height: 200px;
        width: 286px;
    }

    .footer {
        background-color: cadetblue;
        text-align: center;
    }

    .container {
        width: 100%;
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }

    .footer-text {
        margin: 0;
    }
    </style>
</head>

<body>
    <?php include 'navbar.php'; ?>

    <!-- all cards -->
    <div class="container card-grid mt-3">
        <div class="row">
            <div class="col-4">
                <div class="card ml-3 mt-3" style="width: 18rem;">
                    <img src="images/department.png" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">Departments</h5>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of
                            the card's
                            content.</p>
                        <a href="#" class="btn btn-primary">Go somewhere</a>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="card ml-3 mt-3" style="width: 18rem;">
                    <img src="images/total_employees.png" class="card-img-top " alt="...">
                    <div class="card-body">
                        <h5 class="card-title">Total Employees</h5>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of
                            the
                            card's
                            content.</p>
                        <a href="#" class="btn btn-primary">Go somewhere</a>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="card ml-3 mt-3" style="width: 18rem;">
                    <img src="images/inprogress_tasks.png" class="card-img-top " alt="...">
                    <div class="card-body">
                        <h5 class="card-title">InProgress Task</h5>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of
                            the
                            card's
                            content.</p>
                        <a href="#" class="btn btn-primary">Go somewhere</a>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="card ml-3 mt-3" style="width: 18rem;">
                    <img src="images/completed_tasks.png" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">Completed Tasks</h5>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of
                            the
                            card's
                            content.</p>
                        <a href="#" class="btn btn-primary">Go somewhere</a>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="card ml-3 mt-3" style="width: 18rem;">
                    <img src="images/all_tasks.png" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">All Tasks</h5>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of
                            the
                            card's
                            content.</p>
                        <a href="#" class="btn btn-primary">Go somewhere</a>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="card ml-3 mt-3" style="width: 18rem;">
                    <img src="images/task_reports.png" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">Task Reports</h5>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of
                            the
                            card's
                            content.</p>
                        <a href="#" class="btn btn-primary">Go somewhere</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- cards ends -->

    <!-- footer starts -->
    <footer class="footer">
        <div class="container">
            <p class="footer-text">Employee Task management</p>
        </div>
    </footer>

    <!-- footer ends -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous">
    </script>
</body>

</html>