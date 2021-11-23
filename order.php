<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<?php include 'functions.php';
ob_start();
require('fpdf.php');
?>

<?php


if(isset($_SESSION['success']))
{
  echo $_SESSION['success'];
  print_r ( ' '.$_SESSION['user']['firstname']);
}

if(!isLoggedIn()){
//checks whether the user is logged in if not it redirects the user to the login page


  header('location:login.php');

}

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd" >
<html>
<head>
  <title>
    OW2P Order
    </title>
    <link rel="stylesheet" href="order.css?version=51" type="text/css
    ">



  </head>

<div class="nav-bar">
  <a href="index.php"><i class="fa fa-th hm" style="font-size:40px;color:white; float:left; padding: 10px;"></i>
  </a>
  <ul class="main-ul">
    <li> <span class="fas fa-home " style="color:white;"></span> <a href="index.php">Home</a></li>
    <li><a href="order.php">Service</a></li>
    <?php if (isset($_SESSION['user']) && !empty($_SESSION['user'])): ?>

    <?php else: ?>
      <li><span class="fa fa-user " style="color:white;"></span> <a href="login.php">Login</a></li>

    <?php endif; ?>
    <li><a href="">About Us</a></li>
    <li>  <span class="fa fa-shopping-cart " style="color:white;"></span> <a href="shop.php">Shop</a></li>
  </ul>
</div>
  <body>
    <h3 align="center" style="border-top:0.05px solid gray;">
      Place your order/ Upload Artwork
    </h3>'    <div class="cal-up">
'
    <div class="instruction">
      <ul>
      <li><h4>Input the number of Printouts you would like </h4></li>
      <li><h4>Select the papertype; artpaper is used for books and flier </h4></li>
      <li><h4>artboard is used for covers and business cards its heavier 300grams </h4></li>
      <li><h4>Stickers used for anthing (single sided) that you are go to stick somewhere </h4></li>
      <li><h4>Bond commonly used in photocopies and the cheapest </h4></li>
      <li><h4>Select print sides whether both side or single side  </h4></li>
      <li><h4>Click calculate to get the total amount </h4></li>
      <li><h4>If satisfied click upload file; which is the file you're looking to print</h4></li>



    </ul>



    </div>

    <div id="error_message" style="float:left; color:red"></div>

    <div class="pricecal">
      <?php echo display_error(); ?>
      <form action="order.php" method="post" autocomplete="off">
        <div id="error_message" style="float:left; color:red"></div>

      <h3>Price Calculator</h3>
      <br>
      <label>Quantity</label>
      <br>
    <input id="qnt_1" name="qnt_1" type="number"  value="1" >
    <br>
    <label>Paper Type</label>
    <br>
    <input id="papertype"name='papertype' type="text" list="paper" autocomplete="off" />
    <datalist id="paper" >
      <option name='papertype1' value="artpaper"></option>
      <option name='papertype2' value="artboard"> </option>
      <option name='papertype3' value="sticker"></option>
      <option name='papertype4' value="bond"></option>
    </datalist>
    <br>
    <label>Print Sides</label>
    <br>
    <input  id="printside"name="printside" type="text" list="sides" autocomplete="off">
    <datalist id="sides">
      <option name="4color(single)">4color(single)</option>
      <option name="4color(both sides)">4color(both sides)</option>
      <option name="B/white(single)">B/white(single)</option>
      <option name="B/white(both sides)">B/white(both sides)</option>
    </datalist>
    <br>
    <br>
    <!--<label>Minimum Amount</label>-->
    <!-- <label>Total: </label> -->
    <!-- <input id="search"placeholder="Total"/> -->
    <!-- <span ><b style="font-size:20px"><?php //echo display_amount(); ?></b></span> -->
    <span ><b style="font-size:20px"> </b></span>
    <p>
    </p>
    <div class="pay">
    <input  id="calc" name="calc" type="button" value="calculate"/>
  </div>
    <br>
    <br>
    <form method="post">

    <div class="pay"><ul>
      <button name="cnl_pay" >Cancel Order</button>
      <p></p>

    <button name="clk_pay" >Confirm Order</button>
  </ul>
  </div>
</form>
  <span id="result"></span>
  <span id="result1"></span>
  <span id="result2"></span><br>
  <span id="result4"></span>

  <span id="result3"></span><br>






</form>

  </div>
</div>
    </body>
    <div class="footer">
    <span>
      All Rights Reserved &copy 2021
     </span>
  </div>
</html>
<script>

//
// var price = <?php //echo $price ?>

$(function(){
  $("#calc").click(function(){

    var a = parseInt($("#qnt_1").val());
    var b = $("#papertype").val();
    var c = String($("#printside").val());


    //$.isNumeric() is a jquery function that returns true if the value is a numeric
    if (a =='' || !($.isNumeric(a)) || a <= 0 ){
      $("#error_message").html("Enter valid Quantity");
    }
    else if (b=='') {
      $("#error_message").html("Select Papertype");
    }
    else if (b!='artpaper' && b!='artboard' && b!='sticker' && b!='bond') {
      $("#error_message").html("Select valid Papertype");
    }
    else if (c=='') {
      $("#error_message").html("Select Printsides");
    }else{
      $("#error_message").html("");





    if (b == 'sticker' && c=='4color(single)'){
      var price = 25;

    }
    else if(b == 'artpaper' && c == '4color(single)'){
      var price= 20

    }

    else if (b == 'artpaper' && c == '4color(both sides)') {
      var price = 35;
    }
    else if(b == 'artboard' && c == '4color(single)'){
      var price = 24;
    }
    else if (b == 'artboard' && c == '4color(both sides)') {
      var price = 39;
    }
    else if(b == 'bond' && c == '4color(single)'){
      var price = 17.5;
    }
    else if (b == 'bond' && c == '4color(both sides)') {
      var price = 32.5;
    }

    else if(b == 'sticker' && c == 'B/white(single)'){
      var price= 13;

    }
    else if(b == 'artpaper' && c == 'B/white(single)'){
      var price= 8;

    }
    else if (b == 'artpaper' && c == 'B/white(both sides)') {
      var price = 11;
    }
    else if(b == 'artboard' && c == 'B/white(single)'){
      var price = 12;
    }
    else if (b == 'artboard' && c == 'B/white(both sides)') {
      var price = 15;
    }
    else if(b == 'bond' && c == 'B/white(single)'){
      var price = 5.5;
    }
    else if (b == 'bond' && c == 'B/white(both sides)') {
      var price = 8.5;
    }

    var Total = price * a;
    var k = '<?php echo "Ksh "; ?>';
    $("#result").html(a);
    $("#result1").html(b);
    $("#result2").html(c);
    $("#result4").html(k);

    $("#result3").html(Total);

    document.cookie= "Total="+Total;

    document.cookie= "a="+a;
    //storing the javascript quantity variable in a cookie in order to access it in php
    document.cookie= "b="+b;
    document.cookie= "c="+c;
  }

  });

});
</script>
