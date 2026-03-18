<?php include_once("header.php"); ?>

<img class="hero-banner" src="ChatGPT Image Feb 4, 2026, 09_05_30 PM.png" alt="Flood Relief">

<h1>Welcome to Flood Relief Management System</h1>
<p>A platform designed to support flood-affected communities by managing relief requests and coordinating emergency assistance efficiently.</p>

<?php if(!isset($_SESSION['user_id'])): ?>
    <div  class="guest-card">
        <h3>Get Started</h3>
        <p>Join the Flood Relief Management System to submit requests or manage relief operations.</p>
        <div class="guest-actions">
            <a href="login.php" class="btn-front">Login</a>
            <a href="user-Register.php" class="btn-front">Register as User</a>
            <a href="admin-Register.php" class="btn-front">Register as Admin</a>
            
        </div>

    </div>

        
<?php else: ?>
    
    <div style="margin: 30px 0; padding: 20px; background: #e9ffe9; border-radius: 5px;">
        <h3>Welcome, <?php echo $_SESSION['fullname'] ?? 'User'; ?>!</h3>
        <p>You are logged in as: <strong><?php echo $_SESSION['role']; ?></strong></p>
        
        <?php if($_SESSION['role'] == 'user'): ?>
            <div class="welcome-actions">
                 <p><a href="relief-request.php">Submit a new relief request</a></p>
                <p><a href="my-requests.php">View your existing requests</a></p>
            </div>
           
        
        <?php elseif($_SESSION['role'] == 'admin'): ?>
            <p><a href="admin-users.php">Manage registered users</a></p>
            <p><a href="admin-reports.php">View system reports</a></p>
        <?php endif; ?>
    </div>
<?php endif; ?>

<?php include_once("footer.php"); ?>