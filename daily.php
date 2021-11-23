<?php

echo $_POST['startdt'];

echo $_POST['enddt'];
 ?>
 <?php include 'workfunction.php';
 ?>
 <?php
 // echo "Filter clicked";
 // $filt = $_COOKIE['filter'];
 // // echo $filt;
 // if($filt == 'Processing' || $filt== 'Ready For Pickup' || $filt=='Pending'){
 //   echo $filt;
 //   // $id = $_COOKIE['idt'];
 // }
  ?>

  <?php
  if (isset($_SESSION['success'])){
    echo $_SESSION['success'];
    print_r( $_SESSION['user']['user_type']);
  }
  if(!isLoggedIn()){



    header('location:admin.php');

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

    </head>
    <h1>Admin Workflow</h1>

  <div class="nav-bar">
    <ul class="main-ul">

      <li><a href="workflow.php?logout=1">Logout</a></li>
    </ul>
  </div>
    <body>
      <div class="search">
        <input  class="srch" type="search" name="searchjob" value="" placeholder="Search">
        <button name="btn1"class="btn1" >Search</button>
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
      <form method="post" action="workflow.php">
      <button class="bck" name="bck"class="btn1" id="bck">Back</button>
    </form>
      </div>
      <script>
      $(function(){
        $("#sve").click(function(){
          var st = String($("#status").val());
          document.cookie= "filter="+st;
          $("#sp").html(st);
        });
      });
      </script>

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
          <th>Date</th>
        </tr>

        </thead>
  <form method="post">
          <?php
          $st = $_POST['startdt'];
          $ed = $_POST['enddt'];
          //whats happening here is we are convertin the date format to yy/mm/dd so that we can run a query to our database which
          //stores the date the orders were received in that particular number_format
          //using the strotime() which converts the date to a time and then after words we are able to create a new format using the methods
          //date()
          $st1 = date("Y-m-d",strtotime($st));
          $ed1 = date("Y-m-d",strtotime($ed));


          $q = "SELECT * FROM orders WHERE order_time BETWEEN '".$st1."' AND '".$ed1."'";
          $result = mysqli_query($db,$q);



          while($row = mysqli_fetch_assoc($result)){
            $ord = $row['OrderId'];
            $pepa = $row['papertype'];
            $qty = $row['quantity'];
            $st = $row['status'];
            $dt = date('d-m-Y',strtotime($row['order_time']));

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

              <td><button name='btn'>Download</button><button  class='inpt' id='".$row["OrderId"]."' name='btn1'>Ticket</button></td>
              <td><button  class='ipt' id='".$row["OrderId"]."' name='btn2'>Update</button></td>
              <td>$dt</td

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

  </script>
  <?php
  // if(isset($_POST['sv'])){
  //   header('location:preview.php');
  //
  // }
  if(isset($_POST['bck'])){
    header('location:workflow.php');
  }
   ?>
 <?php

 ?>
