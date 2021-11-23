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
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">

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
<div id="mySidebar" class="sidebar">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">×</a>
  <a href="sales.php">Sales</a>
  <a href="customers.php">Customers</a>
  <a href="payment.php">Payments</a>
</div>
<div id="main">
  <button class="openbtn" onclick="openNav()">☰ Open Summary</button>

</div>
<script>
function openNav() {
  document.getElementById("mySidebar").style.width = "250px";
  document.getElementById("main").style.marginLeft = "250px";
}

function closeNav() {
  document.getElementById("mySidebar").style.width = "0";
  document.getElementById("main").style.marginLeft= "0";
}
</script>
  <body>

    <div class="search">
      <form method="post" action="search.php" >
      <input  class="srch" type="search" name="searchjob" value="" placeholder="Search">
      <button name="button_1"class="btn1">Search</button>
    </form>

    <!-- </div> -->

    <!-- <div class="dtn"> -->
      <form method="post" action="preview.php">
      <input  id="status"name="status" type="text" list="sts" placeholder="Update status" autocomplete="off"/>
      <datalist id="sts">
        <option name="Processing">Processing</option>
        <option name="Ready For Pickup">Ready For Pickup</option>
        <option name="Pending">Pending</option>
      </datalist>
      <button name="sve"class="btn1" id="sve">Filter</button>
    </form>

    <!-- </div> -->
    <!-- <div class="dt"> -->
    <form method="post" action="daily.php">
    From Date: <input type="text" name="startdt" id="datepicker" autocomplete="off">
    To Date: <input type="text" name="enddt"id="datepicker1" autocomplete="off">
    <button class="btn1">Search</button>
  </form>
  </div>
  <!-- below is a script to associate the date input with a jquery that pops a calendar -->
  <!-- there is also a a script of jquery library in the href -->
  <script>
$( function() {
  $( "#datepicker" ).datepicker();
  $( "#datepicker1" ).datepicker();

} );
</script>

   <!-- below is a script to save the selection of status in a cookie which we will access when performin filtering -->
    <script>
    $(function(){
      $("#sve").click(function(){
        var st = String($("#status").val());
        document.cookie= "filter="+st;
        $("#sp").html(st);
      });
    });
    </script>
    <!-- <span id="sp">2222222</span>

    <span id="result1">111</span>
    <span id="result2">111</span> -->

    <table>
      <thead>
        <tr class="tablehe">
          <th>
            <input type="checkbox" name="checkbox" value="chkbx">
          </th>
          <th>
          OrderId
        </th>
        <th>
          Product
        </th>
        <th>
          Quantity
        </th>
        <th>Status</th>
        <th>Download</th>
        <th>Update Status</th>
      </tr>
        <!-- <tr>
          <td><input type="checkbox" name="" value=""></td>
        <td>1001</td>
          <td>Sticker</td>
          <td>20</td>
          <td> Processing</td>

          <td><button >Download</button>     <button>Ticket</button></td>
        </tr> -->
      </thead>
<form method="post">
        <?php
        $q = "SELECT * FROM orders ";
        $result = mysqli_query($db,$q);
        // $row = mysqli_fetch_assoc($result);
        // echo $row['Customer_Id'];
        while($row = mysqli_fetch_assoc($result)){
          $ord = $row['OrderId'];
          $pepa = $row['papertype'];
          $qty = $row['quantity'];
          $st = $row['status'];


          //perform a jquery using the class attribute and you can access the button clicked using the id which is
          //in this instance should be unique because we are looping through our order from the database
          //therefore it is imperative you give each row a unique id, make use of the ordreid in this case
          echo "

          <tr>
            <td><input type='checkbox' name='' value=''></td>
          <td>$ord</td>
            <td>$pepa</td>
            <td>$qty</td>
            <td> $st</td>

            <td><button id='".$row["OrderId"]."' name='btn' class='ip'>Download</button><button  class='inpt' id='".$row["OrderId"]."' name='btn1'>Ticket</button></td>
            <td><button  class='ipt' id='".$row["OrderId"]."' name='btn2'>Update</button></td>
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
<?php
if(isset($_POST['sv'])){
  header('location:preview.php');

}
if (isset($_POST['button_1'])) {
  header('location:search.php');

}
 ?>
