<?php
$serverName ="localhost";
$dbUsername ="Dhanuka123";
$dbPassword ="3264Dhanuka@";
$dbName ="floodmanagement";

$conn = mysqli_connect($serverName,$dbUsername,$dbPassword,$dbName);

if(!$conn)
    {
        die("Connection Failed : ". mysqli_connect_error());
    }