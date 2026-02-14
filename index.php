<?php include_once("header.php"); ?>

<h1>Welcome to Flood Relief Management System</h1>
<p>A platform designed to support flood-affected communities by managing relief requests and coordinating emergency assistance efficiently.</p>

<img src="ChatGPT Image Feb 4, 2026, 09_05_30 PM.png" alt="Flood Relief Management" class="relief-banner">
<?php if(!isset($_SESSION['user_id'])): ?>
    <div style="margin: 30px 0; padding: 20px; background: #f8f9fa; border-radius: 5px;">
        <h3>Get Started</h3>
        <p>Please <a href="login.php">login</a> or <a href="user-Register.php">register</a> to access the system.</p>
    </div>
<?php else: ?>
    <div style="margin: 30px 0; padding: 20px; background: #e9ffe9; border-radius: 5px;">
        <h3>Welcome, <?php echo $_SESSION['fullname'] ?? 'User'; ?>!</h3>
        <p>You are logged in as: <strong><?php echo $_SESSION['role']; ?></strong></p>
        
        <?php if($_SESSION['role'] == 'user'): ?>
            <p><a href="relief-request.php">Submit a new relief request</a></p>
            <p><a href="my-requests.php">View your existing requests</a></p>
        <?php elseif($_SESSION['role'] == 'admin'): ?>
            <p><a href="admin-users.php">Manage registered users</a></p>
            <p><a href="admin-reports.php">View system reports</a></p>
        <?php endif; ?>
    </div>
<?php endif; ?>

<?php include_once("footer.php"); ?>