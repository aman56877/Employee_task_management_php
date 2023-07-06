<?php



$conn = mysqli_connect('localhost', 'root', 'root');

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$db = mysqli_select_db($conn, 'etm');

if(!$db){
    die("Database not selected");
}

?>