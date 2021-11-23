<?php include 'workfunction.php';
?>
<?php
if (isset($_SESSION['success'])){
  echo $_SESSION['success'];
  print_r( $_SESSION['user']['user_type']);
}
if(!isLoggedIn()){



  header('location:admin.php');

}
$filt='';
if($filt=='')
{
  $filt='Processing';
}


 ?>
 <?php
 echo "Filter clicked";
 // $filt = $_COOKIE['filter'];
 // echo $filt;
 if($filt == 'Processing' || $filt== 'Ready For Pickup' || $filt=='Pending'){
   echo $filt;
   // $id = $_COOKIE['idt'];
 }
  ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd" >
<html>
<head>
  <title>
    OW2P Workflow
    </title>
    <link rel="stylesheet" href="" type="text/css
    ">
    <link rel="stylesheet" href="work.css? version=51" type="text/css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>


  </head>
  <h1>Admin Workflow</h1>

<div class="nav-bar">
  <ul class="main-ul">
    <!-- <li> <span class="fas fa-home " style="color:white;"></span> <a href="index.php">Home</a></li>
    <li><a href="">Products</a></li>
    <li> <span class="fa fa-user " style="color:white;"></span> <a href="admin.php">Login</a></li>
    <li><a href="">About Us</a></li> -->
    <li ><a href="workflow.php?logout=1">Logout</a></li>

  </ul>
</div>


  <body>

    <div class="search">
      <form method="post" action="search.php" >
      <input  class="srch" type="search" name="searchjob" value="" placeholder="Search">
      <button name="button_1"class="btn1">Search</button>
      <h2>Payment Information</h2>

    </form>
    <form method="post" action="workflow.php">
    <button name="cls" id="cls">back</button>
  </form>
    </div>


    <table>
      <thead>
        <tr class="tablehe">
          <th>
            <input type="checkbox" name="checkbox" value="chkbx">
          </th>
          <th>
          Transaction id
        </th>

        <th>
          Amount
        </th>
        <th>
          Payment code
        </th>
        <th>
          Payment status
        </th>
        <th>
          Update
        </th>
        <th>
          Transaction time
        </th>

      </tr>

      </thead>
<form method="post">
        <?php
        $q = "SELECT * FROM payment ";
        $result = mysqli_query($db,$q);
        // $row = mysqli_fetch_assoc($result);
        // echo $row['Customer_Id'];
        while($row = mysqli_fetch_assoc($result)){
          $order_id = $row['order_id'];
          $trans = $row['transId'];
          $amount = number_format($row['amount']);
          $sts = $row['payment_status'];
          $tm = date('d-m-Y',strtotime($row['transTime']));
          $pay_code = $row['payment_code'];

          //perform a jquery using the class attribute and you can access the button clicked using the id which is
          //in this instance should be unique because we are looping through our order from the database
          //therefore it is imperative you give each row a unique id, make use of the ordreid in this case

          echo "

          <tr>
            <td><input type='checkbox' name='' value=''></td>
          <td>$trans</td>
            <td>$amount</td>
            <td>$pay_code</td>
            <td>$sts  </td>
            <td><button  class='ipt' id='".$row["order_id"]."' name='b'>Update</button></td>
            <td>$tm</tm>



          </tr>

          ";
        }

 ?>
       </form>
    </table>

    </body>
    <div class="tm">
    <i>
      <strong><span id="time"></span></strong>
    </i>
    <script>
    var today = new Date();
    document.getElementById('time').innerHTML= today;
    </script>
  </div>
    <div class="footer">
    <span>
      All Rights Reserved &copy 2021
     </span>
  </div>

</html>

<?php
if(isset($_POST["cls"])){
    header('location:workflow.php');
}
?>

<script>

$(function(){

  $(".inpt").click(function(){
    var val2 = $(this).attr("id");  // Get the ID of the button that was clicked on

    var s = val2;
    // $("#result1").html(s);
    document.cookie="id="+s;

  });

});
$(function(){

  $(".ipt").click(function(){
    var val = $(this).attr("id");  // Get the ID of the button that was clicked on

    var t = val;
    // $("#result1").html(s);
    document.cookie="idt="+t;

  });

});
$(function(){

  $(".ip").click(function(){
    var val3 = $(this).attr("id");  // Get the ID of the button that was clicked on

    var x = val3;
    // $("#result1").html(s);
    document.cookie="idx="+x;

  });

});

</script>
