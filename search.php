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

    </form>
    <form method="post" action="workflow.php">
    <button name="cls" id="cls">back</button>
  </form>
    </div>
    <h2>Search</h2>


    <table>
      <thead>
        <tr class="tablehe">
          <th>
            <input type="checkbox" name="checkbox" value="chkbx">
          </th>
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
      </thead>
<form method="post">
        <?php
        $srch = $_POST['searchjob'];
        //make use of the wild card %% surrounding the variable we are searching an it is used with like locale_get_keywords
        //it return all the results that have the given search in any given position.
        $q = "SELECT * FROM orders WHERE  papertype LIKE '%$srch%' OR  OrderId LIKE '%$srch%'" ;
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


         "; }?>
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
