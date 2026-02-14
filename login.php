<?php
session_start();
require_once("db_connect.php");

if(isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    
    if(empty($email) || empty($password)) {
        $_SESSION['error'] = "Please enter email and password";
        header("Location: login.php");
        exit();
    }
    
    $sql = "SELECT * FROM Users WHERE Email = '$email'";
    $result = mysqli_query($conn, $sql);
    
    if(mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        
        if(password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['email'] = $user['Email'];
            $_SESSION['fullname'] = $user['fullname'];
            $_SESSION['role'] = $user['role'];
            
            $_SESSION['success'] = "Login successful!";
            
            if($user['role'] == 'user') {
                header("Location: relief-request.php");
            } else {
                header("Location: admin-users.php");
            }
            exit();
        } else {
            $_SESSION['error'] = "Invalid password";
        }
    } else {
        $_SESSION['error'] = "User not found";
    }
    
    header("Location: login.php");
    exit();
}
?>

<?php include_once("header.php"); ?>

<div class="form-container">
    <h2>Login</h2>
    
    <form method="post" action="">
        <label>Email:</label>
        <input type="email" name="email" required>
        
        <label>Password:</label>
        <input type="password" name="password" required>
        
        <button type="submit">Login</button>
    </form>
    
    <p style="margin-top: 15px;">
        Don't have an account? 
        <a href="user-Register.php">Register as User</a> or 
        <a href="admin-Register.php">Register as Admin</a>
    </p>
</div>

<?php include_once("footer.php"); ?>