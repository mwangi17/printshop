<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<?php include 'functions.php';
ob_start();
require('fpdf.php');
?>

<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'C:\xampp\composer\vendor\autoload.php';



if(isset($_SESSION['success']))
{
  echo $_SESSION['success'];
  print_r ( ' '.$_SESSION['user']['firstname']);
}

if(!isLoggedIn()){



  header('location:login.php');

}

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd" >
<html>
<head>
  <title>
    OW2P Order
    </title>
    <link rel="stylesheet" href="uload.css?version=51" type="text/css
    ">



  </head>

<div class="nav-bar">
  <a href="index.php"><i class="fa fa-th hm" style="font-size:40px;color:white; float:left; padding: 10px;"></i>
  </a>
  <ul class="main-ul">
    <li> <span class="fas fa-home " style="color:white;"></span> <a href="index.php">Home</a></li>
    <li><a href="order.php">Service</a></li>
    <?php if(isset($_SESSION['user']) && !empty($_SESSION['user'])) { ?>

  <?php }else{
    ?>
    <li><span class="fa fa-user " style="color:white;"></span> <a href="login.php">Login</a></li>

    <?php
  } ?>
    <li><a href="">About Us</a></li>
    <li>  <span class="fa fa-shopping-cart " style="color:white;"></span> <a href="shop.php">Shop</a></li>
  </ul>
</div>
  <body>
    <h3 align="center" style="border-top:0.05px solid gray;">
      Place your order/ Upload Artwork
    </h3>

    <div class="cal-up">
      <ul>
        <li>
      <h4>
        Upload the file that you would like to print
      </h4></li>
      <li>
    <h4>
    And provide any additional information below regarding the file and how it should be done
    </h4></li>
    <li>
  <h4>
    Click here to pay once the required fields are filled.
  </h4></li>
    </ul>
    <div class="upload">
      <form method="post" action='pay.php' enctype="multipart/form-data">
      <p style="color:red;">Please upload .pdf, .jpg, .jpeg, .png, .ai, .zip files only</p>
      <input class="up" type="file" name="file" value="" size="60px">
      <button name="save" type="button"onclick="getData()" id="btn1">Upload Artwork</button>
      <br>
      <br>
<form >
      <textarea id="txta" name='txta' type="text" placeholder="Type additional product details here"></textarea>

      <style>
      textarea{
      	resize:none;
      	width:500px;
      	height:100px;
      }
      </style>



    </div>

      <?php echo display_error(); ?>


 <div class="pay">
 <button id="save" name="save" >Click here to pay</button>
</div>



</form>
<form>
<span id="result1"></span>
</form>
  </div>
</div>
</form>

    </body>
    <div class="footer">
    <span>
      All Rights Reserved &copy 2021
     </span>
  </div>
</html>
<script>

$(function(){
  $("#save").click(function(){
    // var a = parseInt($("textarea#txta").val());
    var des = $('#txta').val();
    $("#result1").html(des);
    document.cookie = "des="+des;

  })
})

</script>
