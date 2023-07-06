<?php
$token = $_SESSION['token'];
$query = "SELECT * FROM registrationdata WHERE token = '$token'";
$result = mysqli_query($conn, $query);
$alldata = mysqli_fetch_assoc($result);
$name = $alldata['name'];
$_SESSION['name'] = $name;
$role = $alldata['role'];
$_SESSION['role'] = $role;


?>