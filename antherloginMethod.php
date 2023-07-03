<?php

// error_reporting(E_ALL);
// ini_set('display_errors', 1);
// session_start();
// // check if user is already logged in
// if(isset($_SESSION['email'])){
//     header("location:user.php");
//     exit;
// }
// require_once 'db_connection.php';

// $email = $hashedPassword = "";
// $err = "";

// // if request methos is post
// if($_SERVER['REQUEST_METHOD']=="POST"){
//     if(empty(trim($_POST['email'])) || empty(trim($_POST['password'])) ){
//         $err = "Please enter email or password";
//     }else{
//         $email = trim (strtolower($_POST['email']));
//         $password = trim($_POST['password']);
//     }
    
    
// if(empty($err)){
//     $sql = "SELECT id, email, password FROM registrationdata WHERE email = ?";
//     $stmt = mysqli_prepare($conn, $sql);
//     mysqli_stmt_bind_param($stmt, "s", $param_username);
//     $param_username = $email;
//     if(mysqli_stmt_execute($stmt)){
//         mysqli_stmt_store_result($stmt);
//         if(mysqli_stmt_num_rows($stmt)==1){
//             mysqli_stmt_bind_result($stmt, $id, $email, $hashedPassword);
//             if(mysqli_stmt_fetch($stmt)){
//                 if(password_verify($password, $hashedPassword)){
//                     session_start();
//                     $_SESSION['email']= $email;
//                     $_SESSION['id']= $id;
//                     $_SESSION['loggedin']= true;

//                     header("location:user.php");
//             }
//         }
//     }
// }
// }




// }

?>