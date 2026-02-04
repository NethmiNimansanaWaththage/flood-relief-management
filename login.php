<?php
include_once ("header.php");

?>
<div class="form">

<h1 class="Login/Register">Enter the required details</h1>
 <form action="includes/login.inc.php" method="post">
  <label for="fname">Mobile Number</label>
  <input type="text" id="fname" name="MobileNo" placeholder="07........">

  <label for="lname">Password</label>
  <input type="password" id="lname" name="Pwd" placeholder="Password">
  
  <button type="submit" name="submit">Login</button>  
 </form>
  
  
</div>


<a href="Register.php" class="btn btn-relief">Don't have any account?Click Here</a>


  
  <?php
  include_once ("footer.php");
    ?>