<?php
//used to create the php mailer class
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;
//if the phpmailer libraryis installed automatically using the composer use the following
require 'C:\xampp\composer\vendor\autoload.php';

include 'functions.php';
$id = $_COOKIE['idt'];

$query = "SELECT status FROM orders WHERE OrderId=".$id;
$result = mysqli_query($db,$query);
$v = mysqli_fetch_assoc($result);

echo "Order Number: ".$id;
echo "<br>Current Status: ".$v['status'];

 ?>
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

 <br>

 <!-- <span id="sp">111111</span> -->
 <div class="content">
 <form method="post" action="update.php" >
 <br>
 <input  id="status"name="status" type="text" list="sts" placeholder="Update status" autocomplete="off"/>
 <datalist id="sts">
   <option name="Processing">Processing</option>
   <option name="Ready For Pickup">Ready For Pickup</option>
   <option name="Pending">Pending</option>
 </datalist>
 <input type="checkbox" name="notify" value="Notify Customer" checked>Notify Customer</input>
<button name="sve" id="sve">Save</button>
<button name="cls" id="cls">Close</button>
</form>
</div>
<!-- <input  id="sve" name="sve" type="button" value="Save"/> -->
<style>
.content{
padding-left:  500px;
}
</style>
<script>
$(function(){
  $("#sve").click(function(){
    var st = String($("#status").val());
    document.cookie= "updated_status="+st;
    // $("#sp").html(st);
  });
});
</script>
<?php
if(isset($_POST["sve"])){


$up_st = $_COOKIE['updated_status'];
if($up_st == 'Processing' || $up_st== 'Ready For Pickup' || $up_st=='Pending'){
  echo $up_st;
  $id = $_COOKIE['idt'];

  $query= "UPDATE orders SET status='$up_st' WHERE OrderId=".$id;
  $reslt = mysqli_query($db,$query);

  if($reslt){
    echo "update success";
    //if the data is successfully updated in the database i want to check if notify customer is checked and send an email
    if(isset($_POST['notify'])){
    if ($_POST['notify'] == 'Notify Customer'){
      echo "notify customer is checked";
      notify_mail();


    }}
  }else{
    die("unable to connect");
  }

}
}

if(isset($_POST["cls"])){
    header('location:workflow.php');
}
function notify_mail(){
  global $db;

  $id = $_COOKIE['idt'];
  $q = "SELECT Customer_Id FROM orders WHERE OrderId=".$id;
  $res = mysqli_query($db,$q);
  $rel = mysqli_fetch_assoc($res);
  echo $rel['Customer_Id'];
  $cu_id = $rel['Customer_Id'];

  $q2 = "SELECT * FROM customers WHERE CustomerId=".$cu_id;
  $res2 = mysqli_query($db,$q2);
  $rel2 = mysqli_fetch_assoc($res2);
  $cust_mail = $rel2['Email'];
  $na = $rel2['firstname'];
  $up_st = $_COOKIE['updated_status'];


//create an instance/object mail from the PHPMailer() class
//which you will utilise in
$mail = new PHPMailer(true);
try{
  //exception handling try to send an email dba_first
  // this code we assume might run into some form  error so we place it in a try statement

$mail->isSMTP();
//what follows are all th smtp protocol configurations
$mail->Mailer = "smtp";


$mail->SMTPDebug =0;
$mail->SMTPAuth =TRUE;
$mail->Port =587;
//the server of the email provider it is different for yahoo and gmail
$mail-> Host ="smtp.gmail.com";
$mail->Username ="mkdennnis@gmail.com";
$mail->Password ="u)p6FY%3!RKpI)";
//use the transport layer security
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
//set the email format to IsHTML(true) to true
$mail-> IsHTML(true);
$mail-> addAddress("$cust_mail","Kayd");
$mail-> setFrom("mkdennnis@gmail.com","Dennis");
$mail-> Subject = "Online Web2Print";
$mail-> Body = "<b style=font-size:50px;>Hello $na your order $id is $up_st</b> ";
$mail-> addAttachment('C:\xampp\htdocs\new\images\46.pdf');

$mail->Send();


	echo "Email was sent successfully".$id;
} catch(Exception $e){
  //the catch (Exception e) is a javascript method which  is executed once the try block code runs into an error, handle the errors
  //this is very useful and helps your code to run without crushing



	echo "Message could not be sent.Mailer Error: {$mail->ErrorInfo}";
}
}
 ?>
