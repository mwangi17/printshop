<?php
if(isset($_SESSION['success'])){
  echo $_SESSION['success'];
}
?>
<?php include 'admlogin.php' ?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd" >
<html>
<head>
  <title>
    OW2P Login
    </title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="adm.css" type="text/css
    ">
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>


    <!--
    <h1>Online Web2Print</h1> -->


  </head>

<div class="nav-bar">
<!-- <a href="index.php"><i class="fa fa-th hm" style="font-size:40px;color:white; float:left; padding: 10px;"></i>
</a> -->
  <body >
<div class="row">
  <?php echo display_error(); ?>
  <form class="" action="admin.php" method="post" autocomplete="off">
    <i class='fas fa-unlock-alt' style='font-size:40px;color:black; padding:10px;margin-top:50px;'></i>

<br>
    <span class="fa fa-user usr"></span>

    <input type="text" name="username" id="username" placeholder="User Name">
    <br>
    <span class="fas fa-key usr"></span>
    <input type="password" name="password" id="password" placeholder="Password">
    <br>

    <button type='submit' name="login"><b>Login</b></button>


  </form>
  </div>

    </body>
<div class="tm">

  <i><font color="black">
    <strong><span id="time"></span></strong>  </font></i>
  <script>
  var today = new Date();
  document.getElementById('time').innerHTML = today;

  </script>
</div>
    <div class="footer">


      <footer>
    <span>
      All Rights Reserved &copy 2021
     </span>
     </footer>
  </div>
</html>
