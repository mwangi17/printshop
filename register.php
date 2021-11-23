<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd" >
<?php include 'functions.php'?>

<html>
<head>
  <title>
    OW2P Register
    </title>
    <link rel="stylesheet" href="registerstyle.css" type="text/css
    ">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    <i><font color="black">
      <strong><span id="time"></span></strong>  </font></i>
    <script>
    var today = new Date();
    document.getElementById('time').innerHTML = today;

    </script>
  </head>

<div class="nav-bar">
  <a href="index.php"><i class="fa fa-th hm" style="font-size:40px;color:white; float:left; padding: 10px;"></i>
  </a>
  <ul class="main-ul">
    <li> <span class="fas fa-home " style="color:white;"></span> <a href="index.php">Home</a></li>
    <li><a href="order.php">Service</a></li>
    <li> <span class="fa fa-user " style="color:white;"></span> <a href="login.php">Login</a></li>
    <li><a href="">About Us</a></li>
    <li>  <span class="fa fa-shopping-cart " style="color:white;"></span> <a href="">Shop</a></li>
  </ul>
</div>
  <body>
    <?php echo display_error(); ?>

    <div class="row">

      <form class="" action="register.php" method="post" autocomplete="off">
        <input type="text" name="firstname" id="fname" placeholder="Enter First Name " value="" >
        <span class="fas fa-user-circle usr"></span>
        <br>
        <input type="text" name="lastname" id="lname" placeholder="Enter last Name " value="" autofocus="" >
        <span class="fas fa-user-circle usr"></span>
        <br>
        <span class="fa fa-envelope usr"></span>

        <input type="email" name="email" id="emailid" placeholder="Enter Email Address" value="" autofocus="">
        <br>
        <input type="number" name="phonenumber" id="phonenumber" placeholder="Enter Phone number" value="" autofocus="">
        <span class="fas fa-address-book usr"></span>
        <br>
        <input type="text" name="location" id="location" placeholder="Enter Address/Location " autofocus="">
        <span class="fas fa-home usr"></span>
        <br>
        <span class="fas fa-key usr"></span>

        <input type="password" name="password1" id="password1" placeholder="Password" autofocus="">
        <br>
        <input  type="password" name="password2" id="password2" placeholder="Confirm password" autofocus="">
        <span class="cpass"></span>
        <br>

        <button name="register_btn"><b>Submit</b></button>
        <br>
        <div class="forgot">

        <p>Already Registered? <a href="login.php">login</a> </p>
      </br>
      <p><a href="">Forgot Password</a></p>
    </div>

      </form>
      </div>
    </body>
    <div class="footer">
    <span>
      All Rights Reserved &copy 2021
     </span>
  </div>
</html>
