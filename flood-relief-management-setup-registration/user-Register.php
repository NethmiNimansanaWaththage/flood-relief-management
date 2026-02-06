<?php
session_start();

require_once("header.php");
require_once("db_connect.php");


if (isset($_SESSION['errors']) && !empty($_SESSION['errors'])) {
    echo '<div class="alert alert-danger">';
    foreach ($_SESSION['errors'] as $error) {
        echo '<p>' . htmlspecialchars($error) . '</p>';
    }
    echo '</div>';
    unset($_SESSION['errors']);
}

if (isset($_SESSION['success'])) {
    echo '<div class="alert alert-success">' . htmlspecialchars($_SESSION['success']) . '</div>';
    unset($_SESSION['success']);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {

    $full_name = mysqli_real_escape_string($conn, $_POST['Name'] ?? '');
    $email = mysqli_real_escape_string($conn, $_POST['email'] ?? '');
    $contact = mysqli_real_escape_string($conn, $_POST['Contact_Number'] ?? '');
    $district = mysqli_real_escape_string($conn, $_POST['District'] ?? '');
    $address = mysqli_real_escape_string($conn, $_POST['Address'] ?? '');
    $family_members = mysqli_real_escape_string($conn, $_POST['Family_Members'] ?? '');
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
                district, address, family_members, divisional_secretariat, gn_division, created_at) 
                VALUES ('$full_name', '$email', '$hashed_password', '$role', 
                '$contact', '$district', '$address', '$family_members', '$divisional_secretariat', '$gn_division', NOW())";

        if (mysqli_query($conn, $sql)) {
            $_SESSION['success'] = "Registration successful! Please login.";
            header("Location: login.php"); 
            exit();
        } else {
            $errors[] = "Database error: " . mysqli_error($conn);
        }
    }

    $_SESSION['errors'] = $errors;
    header("Location: user-Register.php");  
    exit();
}
?>

<div class="form">
    <h1>Enter the required details</h1>

    <form method="post" action="">
        <label>Name</label>
        <input type="text" id="fname" name="Name" placeholder="Enter the full Name" required>

        <label>Email</label>
        <input type="email" id="email" name="email" placeholder="....@gmail.com" required>

        <label>Contact Number</label>
        <input type="text" id="contact" name="Contact_Number" placeholder="+94........">

        <label>District</label>
        <select name="District" id="district" required>
            <option value="">Select District</option>
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

        <label>Address</label>
        <input type="text" id="address" name="Address" placeholder="Enter the Address">

        <label>Number of family members</label>
        <input type="text" id="family_members" name="Family_Members" placeholder="Enter the number of family members">

        <label>Divisional Secretariat</label>
        <input type="text" id="ds" name="Divisional_Secretariat" placeholder="Enter the Divisional Secretariat">

        <label>Grama Niladari Division</label>
        <input type="text" id="gnd" name="Grama_Niladari_Division" placeholder="Enter the Grama Niladari Division">

        <label>Password</label>
        <input type="password" id="pwd" name="Pwd" placeholder="Password" required>

        <label>Repeat the password</label>
        <input type="password" id="repeatPwd" name="repeatPwd" placeholder="Password" required>

        <button id="userregbtn" type="submit" name="submit">Register</button>
    </form>
</div>

<a href="login.php" class="btn btn-relief">Already have an account?Click Here</a>

<?php include_once("footer.php"); ?>