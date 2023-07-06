<?php

session_start();

// error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once  'db_connection.php';


// Check if the login form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the entered credentials from the login form
    $email = trim(strtolower($_POST['email']));
    $password = ($_POST['password']);

    // Query the database to retrieve the user with the entered email/number
    $query = "SELECT * FROM registrationdata WHERE email = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) === 1) {
        $user = mysqli_fetch_assoc($result);


        // validation to allow verified admin in admin page
        if(strpos($user['verification_status'], "verified")!==false && strpos($user['role'], "admin")!==false){

            // Verify the entered password with the stored hashed password
            if (password_verify($password, $user['password'])) {
                // Passwords match, login successful

                // Start a session or set a cookie to maintain the user's logged-in state
                $_SESSION['token'] = $user['token'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['loggedin'] = true;

                // Redirect the user to the appropriate page after login
                header("location:admin.php");
                exit();
            } else {
                // Passwords do not match, display an error message
                $errorMessageforpassmismatch = "Wrong Password. Please enter the correct password";
                header("location:login.php?errorMessageforpassmismatch=" . urlencode(($errorMessageforpassmismatch)));
                exit();
            }

        // validation to allow verified manager in manager page
        }elseif(strpos($user['verification_status'], "verified")!==false && strpos($user['role'], "manager")!==false){
            if($user['department']=== 'it_dept'){
                // Verify the entered password with the stored hashed password
                if (password_verify($password, $user['password'])) {
                    // Passwords match, login successful
    
                    // Start a session or set a cookie to maintain the user's logged-in state
                    $_SESSION['token'] = $user['token'];
                    $_SESSION['email'] = $user['email'];
                    $_SESSION['manager_page'] = true;
    
                    // Redirect the user to the appropriate page after login
                    header("location:it_dept_for_manager.php");
                    exit();
                } else {
                    // Passwords do not match, display an error message
                    $errorMessageforpassmismatch = "Wrong Password. Please enter the correct password";
                    header("location:login.php?errorMessageforpassmismatch=" . urlencode(($errorMessageforpassmismatch)));
                    exit();
                }

            }elseif($user['department'] === 'hr_dept'){
                // Verify the entered password with the stored hashed password
                if (password_verify($password, $user['password'])) {
                    // Passwords match, login successful
    
                    // Start a session or set a cookie to maintain the user's logged-in state
                    $_SESSION['token'] = $user['token'];
                    $_SESSION['email'] = $user['email'];
                    $_SESSION['manager_page'] = true;
    
                    // Redirect the user to the appropriate page after login
                    header("location:hr_dept_for_manager.php");
                    exit();
                } else {
                    // Passwords do not match, display an error message
                    $errorMessageforpassmismatch = "Wrong Password. Please enter the correct password";
                    header("location:login.php?errorMessageforpassmismatch=" . urlencode(($errorMessageforpassmismatch)));
                    exit();
                }
            }elseif($user['department'] === 'finance_dept'){
                // Verify the entered password with the stored hashed password
                if (password_verify($password, $user['password'])) {
                    // Passwords match, login successful
    
                    // Start a session or set a cookie to maintain the user's logged-in state
                    $_SESSION['token'] = $user['token'];
                    $_SESSION['email'] = $user['email'];
                    $_SESSION['manager_page'] = true;
    
                    // Redirect the user to the appropriate page after login
                    header("location:finance_dept_for_manager.php");
                    exit();
                } else {
                    // Passwords do not match, display an error message
                    $errorMessageforpassmismatch = "Wrong Password. Please enter the correct password";
                    header("location:login.php?errorMessageforpassmismatch=" . urlencode(($errorMessageforpassmismatch)));
                    exit();
                }
            }
        // validation to allow verified user in user page
        }elseif(strpos($user['verification_status'], "verified")!==false && strpos($user['role'], "user")!==false){
            // Verify the entered password with the stored hashed password
            if (password_verify($password, $user['password'])) {
                // Passwords match, login successful

                // Start a session or set a cookie to maintain the user's logged-in state
                $_SESSION['token'] = $user['token'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['user_page'] = true;

                // Redirect the user to the appropriate page after login
                header("location:user.php");
                exit();
            } else {
                // Passwords do not match, display an error message
                $errorMessageforpassmismatch = "Wrong Password. Please enter the correct password";
                header("location:login.php?errorMessageforpassmismatch=" . urlencode(($errorMessageforpassmismatch)));
                exit();
            }


        // validation to not allow unverify admin in user page
        }elseif(strpos($user['verification_status'], "unverify")!==false && strpos($user['role'], "admin")!==false){
            // Verify the entered password with the stored hashed password
            if (password_verify($password, $user['password'])) {
                // Passwords match, login successful

                // Start a session or set a cookie to maintain the user's logged-in state
                $_SESSION['token'] = $user['token'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['not_verified'] = true;

                // Redirect the user to the appropriate page after login
                header("location:verificationPending.php");
                exit();
            } else {
                // Passwords do not match, display an error message
                $errorMessageforpassmismatch = "Wrong Password. Please enter the correct password";
                header("location:login.php?errorMessageforpassmismatch=" . urlencode(($errorMessageforpassmismatch)));
                exit();
            }


        // validation to not allow unverify manager in user page
        }elseif(strpos($user['verification_status'], "unverify")!==false && strpos($user['role'], "manager")!==false){
            // Verify the entered password with the stored hashed password
            if (password_verify($password, $user['password'])) {
                // Passwords match, login successful

                // Start a session or set a cookie to maintain the user's logged-in state
                $_SESSION['token'] = $user['token'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['not_verified'] = true;

                // Redirect the user to the appropriate page after login
                header("location:verificationPending.php");
                exit();
            } else {
                // Passwords do not match, display an error message
                $errorMessageforpassmismatch = "Wrong Password. Please enter the correct password";
                header("location:login.php?errorMessageforpassmismatch=" . urlencode(($errorMessageforpassmismatch)));
                exit();
            }


        // validation to not allow unverify user in user page
        }elseif(strpos($user['verification_status'], "unverify")!==false && strpos($user['role'], "user")!==false){
            // Verify the entered password with the stored hashed password
            if (password_verify($password, $user['password'])) {
                // Passwords match, login successful

                // Start a session or set a cookie to maintain the user's logged-in state
                $_SESSION['token'] = $user['token'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['not_verified'] = true;

                // Redirect the user to the appropriate page after login
                header("location:verificationPending.php");
                exit();
            } else {
                // Passwords do not match, display an error message
                $errorMessageforpassmismatch = "Wrong Password. Please enter the correct password";
                header("location:login.php?errorMessageforpassmismatch=" . urlencode(($errorMessageforpassmismatch)));
                exit();
            }
        }
        
    }else {
        // User not found, display an error message
        $errorMessagenouser = "User has not been found";
        header("location:login.php?errorMessagenouser=" . urlencode(($errorMessagenouser)));
        exit();
    }
}
?>























<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/png" href="images/favicon.png">

    <title>Employee Management system</title>
</head>

<body>
    <!-- navbar -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <a class="navbar-brand" href="#">Employee task</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item ">
                    <a class="nav-link" href="home.php">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="about.php">About</a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link" href="register.php">Register</a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link" href="contact_us.php">Contact Us</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="login.php">Login</a>
                </li>
            </ul>
        </div>
    </nav>



    <div class="container">
        <form method="post" action="">
            <p>
                <?php
                if(isset($_SESSION['success'])){
                    echo $_SESSION['success'];
                    unset($_SESSION['success']);
                }
                ?>
            </p>
            <p>
                <?php
                if(isset($_SESSION['msg'])){
                    echo $_SESSION['msg'];
                    unset($_SESSION['msg']);
                }
                ?>
            </p>
            <div class="form-group">
                <label>Email address or number</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                    </div>
                    <input type="email" name="email" class="form-control" placeholder="Enter your Email/Number" autocomplete="off" required id="email" oninput="updateButton()">
                </div>
            </div>
            <?php
            $errorMessagenouser = $_GET['errorMessagenouser'] ?? '';
            if(!empty($errorMessagenouser)){
                    echo '<div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">';
                    echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close" id="crossButton">';
                    echo '<span aria-hidden="true">&times;</span>';
                    echo '</button>';
                    echo $errorMessagenouser;
                    echo '</div>';
            }
            ?>
            <div class="form-group">
                <label >Password</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class=" fas fa-shield-alt"></i></span>
                    </div>
                    <input type="password" placeholder="Password" name="password" class="form-control" autocomplete="off" required id="password" oninput="updateButton()">
                </div>
                <i class="far fa-eye" id="togglePassword" style="margin-left: 1076px; cursor: pointer; position: relative; top: -29px;" title="Show Password"></i>
            </div>
            <?php
            $errorMessageforpassmismatch = $_GET['errorMessageforpassmismatch'] ?? '';
            if(!empty($errorMessageforpassmismatch)){
                    echo '<div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">';
                    echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close" id="crossButton">';
                    echo '<span aria-hidden="true">&times;</span>';
                    echo '</button>';
                    echo $errorMessageforpassmismatch;
                    echo '</div>';
            }
            ?>
            <button type="submit" class="btn btn-primary" disabled id="submitBtn">Submit</button>
        </form>
        <a href="recover_email.php" type="submit" class="btn btn-warning" style="position: relative; right: -965px;top: -35px;">Forgot Password</a>
    </div>
















    <!-- script for refreshing page after the error -->
    <script>
    var crossButton = document.getElementById('crossButton')
    crossButton.addEventListener('click', function() {
        window.location.href = 'login.php';
    })
    </script>

    <!-- script for show password eye icon -->
    <script>
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#password');

    togglePassword.addEventListener('click', function (e) {
    // toggle the type attribute
    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
    password.setAttribute('type', type);
    // toggle the eye slash icon
    this.classList.toggle('fa-eye-slash');
    });
    </script>

    <!-- script for disbaling submit button until all fields are filled -->
    <script>
        function updateButton(){
            var email = document.getElementById('email').value;
            var password = document.getElementById('password').value;
            var button = document.getElementById('submitBtn');

            if(email != '' && password != ''){
                button.disabled = false;
            }else{
                button.disabled = false;
            }

        }
    </script>








    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous">
    </script>


</body>

</html>