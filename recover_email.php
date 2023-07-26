<?php

// error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);


session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/SMTP.php';
require './PHPMailer/src/Exception.php';

// ini_set('display_errors', 1);
// error_reporting(E_ALL);

require_once 'db_connection.php';

if(isset($_POST['submit'])){
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    if(empty($email)){
        $_SESSION['emptyemail']= "Please input an email";
        
    }elseif(strpos($email, '.')=== false){
        $_SESSION['.missing'] = "Your email doesn't contain '.' sign. Please input a valid email";

    }elseif(strpos($email, '@')===false){
            $_SESSION['@missing'] = "Your email doesn't contain @ sign. Please input a valid email";

    }elseif(filter_var($email, FILTER_VALIDATE_EMAIL)){
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'guptakabir5687@gmail.com';
            $mail->Password= 'app_token';
            $mail->Port = 465;
            $mail->SMTPSecure = 'ssl';
            $mail->isHTML(true);
            $mail->setFrom($email);
            $mail->addAddress('guptakabir5687@gmail.com');
            $mail->Subject= "Reset Password";
            $mail->Body= "Reset Password";

            if ($mail->send()) {
                $emailQuery = "SELECT * from registrationdata WHERE email = '$email'";
                $query = mysqli_query($conn, $emailQuery);
                
                // EMail count
                $emailCount = mysqli_num_rows($query);

                
                if($emailCount===1){
                    
                    // verification status of email
                    $userdata = mysqli_fetch_array($query);
                    
                    if(strpos($userdata['verification_status'], "verified") !== false){

                        $email = $userdata['email'];
                        $username = $userdata['name'];
                        $token = $userdata['token'];
                        $subject = "To reset your password";
                        $body= "Hii,  $username CLick on the below link to reset your password
                        http://localhost/practice/reset_password.php?token=$token";
    
                        $sender_email = "guptakabir5687@gmail.com";
    
                        $mail = new PHPMailer(true);
                        $mail->isSMTP();
                        $mail->Host = 'smtp.gmail.com';
                        $mail->SMTPAuth = true;
                        $mail->Username = 'guptakabir5687@gmail.com';
                        $mail->Password= 'app_token';
                        $mail->Port = 465;
                        $mail->SMTPSecure = 'ssl';
                        $mail->isHTML(true);
                        $mail->setFrom($sender_email);
                        $mail->addAddress($email);
                        $mail->Subject= $subject;
                        $mail->Body= $body;
    
                        if ($mail->send()) {
                            $_SESSION['msg'] = "Check your mail to reset your account";
                            header("location:login.php");
                        } else {
                            echo "Email not sent. Error: " . $mail->ErrorInfo;
                        }
                    }else{
                        $_SESSION['unverified_email'] = "Your email is registered but not verified. You can not change the password for now";
                    }

                } else {
                    $_SESSION['noemail'] = "This email is not registered with us";
                }
            } else {
                echo "Email not sent. Error: " . $mail->ErrorInfo;
            }
        }else{
            $_SESSION['invalidemail'] = "Your email is not valid";
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

    <div class="container">
        <form method="post" action="">
            <div class="form-group">
                <label>Email address or number</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                    </div>
                    <input type="email" name="email" class="form-control" placeholder="Enter your Email/Number"
                        autocomplete="off" required id="email">
                </div>
            </div>
            <p>
                <?php
                if(isset($_SESSION['.missing'])){
                    echo $_SESSION['.missing'];
                    unset($_SESSION['.missing']);
                }else{
                    echo $_SESSION['.missing']= '';
                }
                ?>
            </p>
            <p>
                <?php
                if(isset($_SESSION['@missing'])){
                    echo $_SESSION['@missing'];
                    unset($_SESSION['@missing']);
                }else{
                    echo $_SESSION['@missing']= '';
                }
                ?>
            </p>
            <p>
                <?php
                if(isset($_SESSION['noemail'])){
                    echo $_SESSION['noemail'];
                    unset($_SESSION['noemail']);
                }else{
                    echo $_SESSION['noemail']='';
                }
                ?>
            </p>
            <p>
                <?php
                if(isset($_SESSION['invalidemail'])){
                    echo $_SESSION['invalidemail'];
                    unset($_SESSION['invalidemail']);
                }else{
                    echo $_SESSION['invalidemail']='';  
                }
                ?>
            </p>
            <p>
            <?php
                if(isset($_SESSION['unverified_email'])){
                    echo $_SESSION['unverified_email'];
                    unset($_SESSION['unverified_email']);
                }else{
                    echo $_SESSION['unverified_email']='';  
                }
                ?>
            </p>

            <p>
                <?php
                if(isset($_SESSION['emptyemail'])){
                    echo $_SESSION['emptyemail'];
                    unset($_SESSION['emptyemail']);
                }else{
                    echo $_SESSION['emptyemail']='';  
                }
                ?>
            </p>
            <button class="btn btn-primary" name="submit">Send Email</button>
        </form>
    </div>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    -->
</body>

</html>
