<?php
include 'functions.php';

    if(isset($_SESSION['success']))
    {
        echo $_SESSION['success'];
    }
    unset($_SESSION['success']);

if(!isLoggedIn()){
  header('location:index.php');
}

//commented the below code to allow the user to access the home page even if they are not logged in
// if (!isLoggedIn()) {
// 	$_SESSION['msg'] = "You must log in first";
// 	header('location: login.php');
// }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd" >
<html>
<head>
  <title>
    Online Web2Print
  </title>
  <link href="work.css?version=51" rel="stylesheet" type="text/css">
  <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>


  <h1>Online Web2Print</h1>
</head>
<div class="h-mail">
  <span>Email us:   mkdennnis@gmail.com</span>
</div>
<div>
  <!-- if a user is logged in  session is created and the $_SESSION['user'] is set
  to an array holding the user information.
  php if statement is wrapped in php tags and uses indentation instead of curly braces. -->
      <?php  if (isset($_SESSION['user'])) : ?>
        <strong><?php echo $_SESSION['user']['firstname']; ?></strong>

        <small>
          <i  style="color: #888;">(<?php echo ucfirst($_SESSION['user']['user_type']); ?>)</i>
          <br>
          <a href="index.php?logout='1'" style="color: red;">logout</a>
        </small>

      <?php endif ?>
    </div>
<div class="nav-bar">
  <!--<a href="index.html"><i class="fa fa-th" style="font-size:40px;color:white; float:left; padding: 10px;"></a>-->
  <ul class="main-ul">
    <li> <span class="fas fa-home " style="color:white;"></span> <a href="index.php">Home</a></li>
    <li><a href="order.php">Service</a></li>
    <?php if (isset($_SESSION['user']) && !empty($_SESSION['user'])){ ?>

    <?php }else {?>
      <li> <span class="fa fa-user " style="color:white;"></span> <a href="login.php">Login</a></li>

    <?php } ?>
    <li><a href="">About Us</a></li>
    <li>  <span class="fa fa-shopping-cart " style="color:white;"></span> <a href="shop.php">Shop</a></li>
  </ul>
</div>
<body class="bod">

<h4> Placed Orders</h4>

    <table>
      <thead>
        <tr class="tablehe">

        </th>
        <th>
        OrderId
      </th>
      <th>
        Quantity
      </th>
      <th>Status</th>
      <th> Order details </th>

    </tr>
      </thead>
<?php
$id = $_SESSION['user']['CustomerId'];

echo $id;

$query = "SELECT * FROM orders WHERE Customer_Id=".$id;
$res = mysqli_query($db,$query);
while ($row = mysqli_fetch_assoc($res)) {
  $ordid = $row['OrderId'];
  $qunt = $row['quantity'];
  $sts = $row['status'];
  echo "
  <tr>
  <td>#$ordid</td>
  <td>$qunt</td>
  <td>$sts</td>
  <td><button>View Details</button></td>
  </tr>


  ";

}
 ?>
</table>

</body>
  <div class="footer">
  <span>
    All Rights Reserved &copy 2021
   </span>
</div>
</html>
