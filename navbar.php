

<?php

$name = $_SESSION['name'];


?>





<style>
    body {
        background-color:orange;
    }
</style>

<!-- navbar starts -->
<nav class="navbar navbar-expand-lg bg-body-tertiary border-bottom border-bottom-dark mb-2">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Navbar</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link <?php echo ($activePage === 'dashboard') ? 'active': ''; ?>" aria-current="
                        page" href="admin.php">Dashboard</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle <?php echo ($activePage === 'departments') ? 'active': ''; ?>"
                        href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Departments
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="it_dept.php">IT Department</a></li>
                        <li><a class="dropdown-item" href="hr_dept.php">HR Department</a></li>
                        <li><a class="dropdown-item" href="finance_dept.php">Finance Department</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle <?php echo ($activePage === 'employees') ? 'active': '';?> "
                        href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Employees
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="verified_employees.php">Verified Employees</a></li>
                        <li><a class="dropdown-item" href="unverified_employees.php">Unverified Employees</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="#">Something else here</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle <?php echo ($activePage === 'tasks') ? 'active': '';?>" href="#"
                        role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Tasks
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="tasks_by_admin.php">Assign Tasks</a></li>
                        <li><a class="dropdown-item" href="#">Another action</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="#">Something else here</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle <?php echo ($activePage === 'task_status') ? 'active': '';?>"
                        href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Task status
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Action</a></li>
                        <li><a class="dropdown-item" href="#">Another action</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="#">Something else here</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle <?php echo ($activePage === 'pages') ? 'active': '';?>" href="#"
                        role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Pages
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Action</a></li>
                        <li><a class="dropdown-item" href="#">Another action</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="#">Something else here</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($activePage === 'task_reports') ? 'active': '';?>" href="#">Task
                        Reports</a>
                </li>
                <li>
                    <div class="dropdown" style="position: relative; left: 280px;">
                        <button class="btn btn-outline-success dropdown-toggle"  type="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <?php echo $name; ?>
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