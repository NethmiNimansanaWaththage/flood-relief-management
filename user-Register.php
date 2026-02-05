<?php
require_once("header.php");
include_once ("db_connect.php");
?>

<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
    session_start();
    require_once 'db_connect.php';

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header("Location: ../user-Register.php?error=invalid_access");
        exit();
    }

    $full_name = mysqli_real_escape_string($conn, $_POST['Name'] ?? '');
    $email = mysqli_real_escape_string($conn, $_POST['email'] ?? '');
    $contact = mysqli_real_escape_string($conn, $_POST['Contact_Number'] ?? '');
    $district = mysqli_real_escape_string($conn, $_POST['District'] ?? '');
    $divisional_secretariat = mysqli_real_escape_string($conn, $_POST['Divisional_Secretariat'] ?? '');
    $gn_division = mysqli_real_escape_string($conn, $_POST['Grama_Niladari_Division'] ?? '');
    $password = $_POST['Pwd'] ?? '';
    $repeat_password = $_POST['repeatPwd'] ?? '';

    $errors = [];

    $required = ['Name', 'email', 'Pwd', 'repeatPwd'];
    foreach ($required as $field) {
        if (empty($_POST[$field])) {
            $errors[] = ucfirst(str_replace('_', ' ', $field)) . " is required";
        }
    }

    if ($password !== $repeat_password) {
        $errors[] = "Passwords do not match";
    }

    if (strlen($password) < 8) {
        $errors[] = "Password must be at least 8 characters";
    }

    $check_email = "SELECT user_id FROM Users WHERE Email = '$email'";
    $result = mysqli_query($conn, $check_email);
    if (mysqli_num_rows($result) > 0) {
        $errors[] = "Email already registered";
    }

    if (empty($errors)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $role = 'user';
        
        $sql = "INSERT INTO Users (full_name, Email, password, role, contact_number, 
                district, divisional_secretariat, gn_division, created_at) 
                VALUES ('$full_name', '$email', '$hashed_password', '$role', 
                '$contact', '$district', '$divisional_secretariat', '$gn_division', NOW())";
        
        if (mysqli_query($conn, $sql)) {
            $_SESSION['success'] = "Registration successful! Please login.";
            header("Location: ../login.php?success=registered");
            exit();
        } else {
            $errors[] = "Database error: " . mysqli_error($conn);
        }
    }

    $_SESSION['errors'] = $errors;
    header("Location: ../user-Register.php");
    exit();
}

?>

<div class="form">
<h1>Enter the required details</h1>

 <form method="post" action="">
  <label>Name</label>
  <input type="text" id="fname" name="Name" placeholder="Enter the full Name">

  <label >Email</label>
  <input type="text" id="email" name="email" placeholder="....@gmail.com">

  <label>Contact Number</label>
  <input type="text" id="contact" name="Contact Number" placeholder="+94........">

  <label>District</label>
  <select name="District" id="district">
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

  <label>Divisional Secretariat</label>
    <input type="text" id="ds" name="Divisional Secretariat" placeholder="Enter the Divisional Secretariat">

    <label>Grama Niladari Division</label>
    <input type="text" id="gnd" name="Grama Niladari Division" placeholder="Enter the Grama Niladari Division">

    <label >Password</label>
  <input type="password" id="pwd" name="Pwd" placeholder="Password">
  
  <label >Repeat the password</label>
  <input type="password" id="repeatPwd" name="repeatPwd" placeholder="Password">

  <button id="userregbtn" type="submit" name="submit">Register</button>  
 </form>
</div>
<a href="login.php" class="btn btn-relief">Already have an account?Click Here</a>
 
<?php
include_once ("footer.php");
?>