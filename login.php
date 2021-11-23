<?php
if(isset($_SESSION['success'])){
  echo $_SESSION['success'];
}

?>
<?php include 'functions.php';

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd" >
<html>
<head>
  <title>
    OW2P Login
    </title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="loginstyle.css" type="text/css
    ">
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>


    <!--
    <h1>Online Web2Print</h1> -->
    <i><font color="black">
      <strong><span id="time"></span></strong>  </font></i>
    <script>
    var today = new Date();
    document.getElementById('time').innerHTML = today;

    </script>
    <br>

  </head>

<div class="nav-bar">
<a href="index.php"><i class="fa fa-th hm" style="font-size:40px;color:white; float:left; padding: 10px;"></i>
</a>
  <ul class="main-ul">
    <li> <span class="fas fa-home  " style="color:white;"></span> <a href="index.php">Home</a></li>
    <li><a href="order.php">Services</a></li>
    <li> <span class="fa fa-user " style="color:white;"></span> <a href="login.php">Login</a></li>
    <li><a href="">About Us</a></li>
    <li>  <span class="fa fa-shopping-cart " style="color:white;"></span> <a href="shop.php">Shop</a></li>
  </ul>
</div>
  <body onload="loadFunction();">
    <?php echo display_error(); ?>

<div class="row">
  <form class="" action="login.php" method="post" autocomplete="off">
    <i class='fas fa-unlock-alt' style='font-size:40px;color:black; padding:10px;margin-top:50px;'></i>

<br>
    <span class="fa fa-user usr"></span>

    <input type="email" name="emailaddress" id="emailid" placeholder="Email ID" >
    <br>
    <span class="fas fa-key usr"></span>
    <input type="password" name="password" id="password" placeholder="Password">
    <br>

    <button name="login_btn"><b>Login</b></button>
    <br>
    <div class="forgot">

    <p>Not Registered? <a href="register.php">Register</a> </p>
  </br>
  <p><a href="">Forgot Password</a></p>
</div>

  </form>
  </div>

    </body>
<div>


</div>
    <div class="footer">


      <footer>
    <span>
      All Rights Reserved &copy 2021
     </span>
     </footer>
  </div>
</html>
