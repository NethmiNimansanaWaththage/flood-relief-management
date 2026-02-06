<?php
include_once("header.php");
?>

<div class="form">

<h1>Enter the required details</h1>
 <form action="includes/Register.inc.php" method="post">
  <label>Name</label>
  <input type="text" id="fname" name="Name" placeholder="Enter the full Name">

  <label >Mobile Number</label>
  <input type="text" id="lage" name="MobileNO" placeholder="07........">

  <label>NIC Number</label>
  <input type="text" id="nic" name="NIC" placeholder="National Idenification Number">

  <label >Password</label>
  <input type="password" id="lem" name="Pwd" placeholder="Password">
  
  <label >Repeat the password</label>
  <input type="password" id="lpssword" name="repeatPwd" placeholder="Password">
  
  <button type="submit" name="submit">Register</button>  
 </form>
  
   
</div>
<a href="login.php" class="btn btn-relief">Already have an account?Click Here</a>

  
<?php
include_once("footer.php");
?>