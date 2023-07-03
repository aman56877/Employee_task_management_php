<?php
session_start();
ob_start();


error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'db_connection.php';

    if(isset($_POST['submit'])){

        if(isset($_GET['token'])){
            $token =  $_GET['token'];
            $checkfortokenindb = "SELECT * from registrationdata WHERE token = '$token'";
            $tokenexpire = mysqli_query($conn, $checkfortokenindb);
        
            if(mysqli_num_rows($tokenexpire)===1){
                $varforToken = rand(10000000000, 9999999999);
                $updatedtoken = uniqid($varforToken);

                $password = mysqli_real_escape_string($conn, $_POST['password']);
                $confpassword = mysqli_real_escape_string($conn, $_POST['confirmPassword']);
            
                $pass = password_hash($password, PASSWORD_BCRYPT);
                $cpass = password_hash($confpassword, PASSWORD_BCRYPT);  
            
                if($password === $confpassword){

                        if(strlen($password)>=8){
                        $query = "UPDATE registrationdata SET password = '$pass', token =  '$updatedtoken',  updated_at = NOW() WHERE token = '$token'";

                        $result = mysqli_query($conn, $query);

                            if($result){
                                $_SESSION['success'] = "Your password has been successfully updated";
                                header("location:login.php");
                                exit();
                            }else{
                                $errorforupdatefail = "Passwords has not been updated, try again";
                                header("location:reset_password.php?errorforupdatefail=" . urlencode($errorforupdatefail));
                            }


                        }else{
                            $_SESSION['pslen'] = "Password should be atleast 8 characters long";
                        }
                }else{
                    $_SESSION['pasmatch'] = "Your passwords are not matching";
                }
            }else{
                header("location:expiretoken.php");
            }
        }else{
            $_SESSION['token'] = "No token found";
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
    <link rel="icon" type="image/png" href="images/favicon.png">

    <title>Recover Email</title>
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
                <li class="nav-item ">
                    <a class="nav-link" href="login.php">Login</a>
                </li>
            </ul>
        </div>
    </nav>


    <!-- form -->
    <div class="container">
        <p>
            <?php
            if(isset($_SESSION['token'])){
                echo $_SESSION['token'];
                unset($_SESSION['token']);
            }else{
                echo $_SESSION['token'] = "";
            }

            ?>
        </p>
        <form action="" method="POST">
        <?php
        $errorforupdatefail = $_GET['errorforupdatefail'] ?? '';
        if(!empty($errorforupdatefail)){
            echo '<div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">';
            echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close" id="crossButton">';                echo '<span aria-hidden="true">&times;</span>';
            echo '</button>';
            echo $errorforupdatefail;
            echo '</div>';
        }
        ?>
            <div class="form-group">
                <label>New Password</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-shield-alt"></i></span>
                    </div>
                    <input type="password" class="form-control" name="password" autocomplete="off" required
                        placeholder="New Password">
                </div>
            </div>
            <div class="form-group">
                <label>Confirm Password</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-shield-alt"></i></span>
                    </div>
                    <input type="password" name="confirmPassword" class="form-control" required autocomplete="off"
                        placeholder="Confirm Password">
                </div>
            </div>
            <?php
            $errorforunmatchedpassword = $_GET['errorforunmatchedpassword'] ?? '';
            if(!empty($errorforunmatchedpassword)){
                echo '<div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">';
                echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close" id="crossButton">';                echo '<span aria-hidden="true">&times;</span>';
                echo '</button>';
                echo $errorforunmatchedpassword;
                echo '</div>';
            }
            ?>
            <p>
                <?php
                if(isset($_SESSION['pslen'])){
                    echo $_SESSION['pslen'];
                    unset($_SESSION['pslen']);
                }else{
                    echo $_SESSION['pslen'] = '';
                }
                ?>
            </p>
            <p>
                <?php
                if(isset($_SESSION['pasmatch'])){
                    echo $_SESSION['pasmatch'];
                    unset($_SESSION['pasmatch']);
                }else{
                    $_SESSION['pasmatch']= '';
                }
                ?>
            </p>
            <button class="btn btn-primary" name="submit">Change Password</button>
        </form>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>
</body>

</html>