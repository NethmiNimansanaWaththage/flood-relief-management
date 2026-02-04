<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_POST["submit"])) {
    $name = $_POST["Name"];
    $mobileno = $_POST["MobileNO"];
    $nicno = $_POST["NIC"];
    $pwd = $_POST["Pwd"];
    $repeatpwd = $_POST["repeatPwd"];

    require_once 'dbh.inc.php';
    require_once 'function.inc.php';

    $emptyInputs = emptyInputSignup($name, $mobileno, $nicno, $pwd, $repeatpwd);
    $invalidNic= invalidNic($nicno);
    $invalidmobileno = invalidmobileno($mobileno);
    $pwdMatch = pwdMatch($pwd, $repeatpwd);
    $uidExists = uidExists($conn, $name, $mobileno);


    if ($emptyInputs !== false) {
        header("Location:../Register.php?error=emptyinput");
        exit();
    }

    if ($invalidNic === false) {
        header("Location:../Register.php?error=Invaliduid");
        exit();
    }
    if ($invalidmobileno === false) {
        header("Location:../Register.php?error=Invalidmobileno");
        exit();
    }

    if ($pwdMatch === false) {
        header("Location:../Register.php?error=Passworddntmatch");
        exit();
    }

    if ($uidExists !== false) {
        header("Location:../Register.php?error=usernametaken");
        exit();
    }

    var_dump($mobileno);
    createUser($conn,$name,$mobileno,$nicno,$pwd);





    loginUser($username, $pwd);







} else {
    header("Location:../login.php");
    exit();
}