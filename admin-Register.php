<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
    session_start();
    include ("db_connect.php");

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header("Location: ../admin-Register.php?error=invalid_access");
        exit();
    }

    $full_name = mysqli_real_escape_string($conn, $_POST['Name'] ?? '');
    $email = mysqli_real_escape_string($conn, $_POST['email'] ?? '');
    $contact = mysqli_real_escape_string($conn, $_POST['Contact_Number'] ?? '');
    $district = mysqli_real_escape_string($conn, $_POST['District'] ?? '');
    $password = $_POST['Pwd'] ?? '';
    $repeat_password = $_POST['repeatPwd'] ?? '';

    $errors = [];

    if (empty($full_name) || empty($email) || empty($password) || empty($repeat_password)) {
        $errors[] = "All fields are required";
    }

    if ($password !== $repeat_password) {
        $errors[] = "Passwords do not match";
    }

    if (strlen($password) < 8) {
        $errors[] = "Password must be at least 8 characters";
    }

    $check_email = "SELECT user_id FROM Users WHERE Email = '$email' AND role = 'admin'";
    $result = mysqli_query($conn, $check_email);
    if (mysqli_num_rows($result) > 0) {
        $errors[] = "Admin with this email already exists";
    }

    if (empty($errors)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $role = 'admin';
        
        $sql = "INSERT INTO Users (full_name, Email, password, role, contact_number, 
                district, created_at) 
                VALUES ('$full_name', '$email', '$hashed_password', '$role', 
                '$contact', '$district', NOW())";
        
        if (mysqli_query($conn, $sql)) {
            $_SESSION['success'] = "Admin account created!";
            header("Location: ../login.php?success=admin_registered");
            exit();
        } else {
            $errors[] = "Database error: " . mysqli_error($conn);
        }
    }

    $_SESSION['errors'] = $errors;
    header("Location: ../admin-Register.php");
    exit();
}

?>

<html>
<head>
 <title>Admin Registration</title>
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
 <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <label class="Admin">Admin Registration</label>
    <div class="form">
<h1>Enter the required details</h1>
 
 <form method="post" action="">
<label>Name</label>
<input type="text" id="adminname" name="Name" placeholder="Enter the full Name"> 

<label >Email</label>
<input type="text" id="adminemail" name="email" placeholder="....@gmail.com">

<label>Contact Number</label>
<input type="text" id="admincontact" name="Contact Number" placeholder="+94........">

<label>District</label>
<select name="District" id="admindistrict">
    <option value="Colombo">Colombo</option>
    <option value="Gampaha">Gampaha</option>
    <option value="Kalutara">Kalutara</option>
    <option value="Kandy">Kandy</option>
    <option value="Matale">Matale</option>
    <option value="Nuwara Eliya">Nuwara Eliya</option>
    <option value="Galle">Galle</option>
    <option value="Matara">Matara</option>
    <option value="Hambantota">Hambantota</option>
    <option value="Jaffna">Jaffna</option>
    <option value="Kilinochchi">Kilinochchi</option>
    <option value="Mannar">Mannar</option>
    <option value="Vavuniya">Vavuniya</option>
    <option value="Mullaitivu">Mullaitivu</option>
    <option value="Batticaloa">Batticaloa</option>
    <option value="Ampara">Ampara</option>
    <option value="Trincomalee">Trincomalee</option>
    <option value="Kurunegala">Kurunegala</option>
</select>

<label >Password</label>
<input type="password" id="adminpwd" name="Pwd" placeholder="Password">
<label >Repeat the password</label>
<input type="password" id="adminrepeatPwd" name="repeatPwd" placeholder="Password">
<button id="adminregbtn" onclick="user_details()" type="submit" name="submit">Register</button>
</div>
<a href="login.php" class="btn btn-relief">Already have an account?Click Here</a>

</html>