<?php include_once("header.php"); ?>
</div>
<div class="d-flex justify-content-center align-items-center"
     style="background-image:url('flood-image.png'); height:525px; padding: 25px; background-position:center;">

    <div class="bg-dark bg-opacity-75 text-white p-5 rounded shadow-lg text-center">
        <h1 class="fw-bold">Welcome to Flood Relief Management System</h1>
        </div >
        <p class="bg-light bg-opacity-75 text-dark p-3 rounded shadow fw-bold"style="font-size:20px;">

        A platform designed to support flood-affected communities by managing relief requests and coordinating emergency assistance efficiently.
        </p>
    
    </div>
   




<?php if(!isset($_SESSION['user_id'])): ?>  
   
    <div class="p-3 rounded shadow text-center" 
     style="width:100%; height:100px; background-color: #cecfd1; color:white; padding:0px;">
    
        <h3 style="margin: 0; color:#2c3e50; font-size:23px;">Get Started</h3>
    <p style="margin:5px 0 0 0;">
        <span style="font-family: 'Verdana', sans-serif; font-size:17px; color:#333;">
        Please 
        </span>
        <a href="login.php" class="btn btn-primary btn-sm" style="font-size:18px;">Login</a> 
       
         <span style="font-family: 'Verdana', sans-serif; font-size:17px; color:#333;">
       or </span>
  <a href="user-Register.php" class="btn btn-success btn-sm"style="font-size:18px;">Register</a> 
  <span style="font-family: 'Verdana', sans-serif; font-size:17px; color:#333;">
  to access the system.<span style="font-family: 'Verdana', sans-serif; font-size:18px; color:#333;">
</p>

</div> 
<?php else: ?>
    <div style=" margin: 8px 0; padding: 5px; background: #e9ffe9; border-radius: 5px;">
        <h3>Welcome, <?php echo $_SESSION['fullname'] ?? 'User'; ?>!</h3>
        <p style="font-size:20px;margin:0;">You are logged in as: <strong><?php echo $_SESSION['role']; ?></strong></p>
        
        <?php if($_SESSION['role'] == 'user'): ?>
            <p style="font-size:18px;margin:0;"><a href="relief-request.php" >Submit a new relief request</a></p>
            <p style="font-size:18px;margin:0;"><a href="my-requests.php">View your existing requests</a></p>
        <?php elseif($_SESSION['role'] == 'admin'): ?>
            <p style="font-size:18px;margin:0;"><a href="admin-users.php">Manage registered users</a></p>
            <p style="font-size:18px;margin:0;"><a href="admin-reports.php">View system reports</a></p>
        <?php endif; ?>
    </div>
<?php endif; ?>
        </div>
<?php include_once("footer.php"); ?>