<?php
session_start();
require_once("db_connect.php");

if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
    $fullname = mysqli_real_escape_string($conn, $_POST['fullname'] ?? '');
    $email = mysqli_real_escape_string($conn, $_POST['email'] ?? '');
    $contact = mysqli_real_escape_string($conn, $_POST['contact'] ?? '');
    $district = mysqli_real_escape_string($conn, $_POST['district'] ?? '');
    $password = $_POST['password'] ?? '';
    $repeat_password = $_POST['repeat_password'] ?? '';

    $errors = [];

    if (empty($fullname) || empty($email) || empty($password)) {
        $errors[] = "All required fields must be filled";
    }

    if ($password !== $repeat_password) {
        $errors[] = "Passwords do not match";
    }

    if (strlen($password) < 8) {
        $errors[] = "Password must be at least 8 characters";
    }

    // Check if email exists
    $check_sql = "SELECT user_id FROM Users WHERE Email = '$email'";
    $check_result = mysqli_query($conn, $check_sql);
    if (mysqli_num_rows($check_result) > 0) {
        $errors[] = "Email already registered";
    }

    if (empty($errors)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $role = 'admin';

        $sql = "INSERT INTO Users (fullname, Email, password, role, contact, district) 
                VALUES ('$fullname', '$email', '$hashed_password', '$role', '$contact', '$district')";

        if (mysqli_query($conn, $sql)) {
            $_SESSION['success'] = "Admin registration successful! Please login.";
            header("Location: login.php");
            exit();
        } else {
            $errors[] = "Database error: " . mysqli_error($conn);
        }
    }

    if (!empty($errors)) {
        $_SESSION['error'] = implode("<br>", $errors);
        header("Location: admin-Register.php");
        exit();
    }
}
?>

<?php include_once("header.php"); ?>

<div class="form-container">
    <h2>Admin Registration</h2>

    <form method="post" action="" onsubmit="return validateForm()">
        <label>Full Name *</label>
        <input type="text" name="fullname" required>

        <label>Email *</label>
        <input type="email" name="email" required>

        <label>Contact Number</label>
        <input type="text" name="contact" placeholder="+94xxxxxxxxx">

        <label>District *</label>
        <select name="district" required>
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

        </select>

        <label>Password * (min 8 characters)</label>
        <input type="password" name="password" required>

        <label>Repeat Password *</label>
        <input type="password" name="repeat_password" required>

        <button type="submit" name="submit">Register as Admin</button>
    </form>

    <p style="margin-top: 15px;">
        Already have an account? <a href="login.php">Login here</a><br>
        Want to register as regular user? <a href="user-Register.php">Click here</a>
    </p>
</div>

<script>
    function validateForm() {
        let password = document.querySelector('input[name="password"]').value;
        let repeat = document.querySelector('input[name="repeat_password"]').value;

        if (password.length < 8) {
            alert("Password must be at least 8 characters");
            return false;
        }

        if (password !== repeat) {
            alert("Passwords do not match");
            return false;
        }

        return true;
    }
</script>

<?php include_once("footer.php"); ?>