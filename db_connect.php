<?php
$host = "localhost";
$user = "root";
$pass = ""; 
$dbname = "flood_relief_db";
$conn = mysqli_connect($host, $user, $pass, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$fname = "";
$email = "";
$password = "";
$role = "";
$contact = "";
$district = "";
$divisional_secretariat = "";
$gn_division = "";
$address = "";
$family_members = "";








$conn->set_charset("utf8");
?>