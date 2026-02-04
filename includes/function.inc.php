<?php
function emptyInputSignup($name, $email, $nicno, $pwd, $repeatpwd)
{
    $result;
    if (empty($name) || empty($email) || empty($nicno) || empty($pwd) || empty($repeatpwd)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function invalidNic($nicno)
{
    $result;
    if (preg_match("/^[0-9]+[vV]?$/", $nicno)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function invalidmobileno($mobileno)
{
    $result;
    if (preg_match("/[0-9]/", $mobileno)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function pwdMatch($pwd, $repeatpwd)
{
    $result;
    if ($pwd == $repeatpwd) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function uidExists($conn, $username, $mobileno)
{
    $sql = "SELECT * FROM userinfo WHERE userNic = ? OR userMobileNo =?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location:../Register.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "ss", $username, $mobileno);
    mysqli_stmt_execute($stmt);
    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_array($resultData)) {
        return $row;
    } else {
        return false;
    }
    mysqli_stmt_close($stmt);
}


function createUser($conn,$name,$mobileno,$nicno,$pwd)
{
   $sql = "INSERT INTO userinfo (usersName,UserMobileNo,userNic,UsersPwd) VALUES (?,?,?,?);";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location:../Register.php?error=stmtfailed");
        exit();
    }
    $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);
    mysqli_stmt_bind_param($stmt, "ssss", $name, $mobileno, $nicno, $hashedPwd);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("Location:../Register.php?error=none");
    exit();

}
