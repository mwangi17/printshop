<?php
session_start();
$db = mysqli_connect('localhost','root','','ow2p') or die('Unable to connect');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'C:\xampp\composer\vendor\autoload.php';

$flnm ='';
$fname='';
$lname='';
$email='';
//the following array is created to store all the errors
$errors=array();
$email='';
$Phonenumber='';
$location='';
$quantity=1;
$paper = '';
$sides ='';
$total=0;
$price=0;
$hash='';

if (isset($_POST['register_btn'])){
  register();
}

function register(){

  global $db, $fname, $lname, $email, $errors, $location, $Phonenumber;

  //the fucntion e() it receives a parameter i have created to use it easily by escaping special characters for sql query
  // mysqli_real_escape_string($db,trim())
  //it takes the connection of the database and the string you want to clean which we are passing it in function trim() which removes any whitespaces
  $fname=e($_POST['firstname']);
  $lname=e($_POST['lastname']);
  $email=e($_POST['email']);
  $password_1=e($_POST['password1']);
  $password_2=e($_POST['password2']);
  $location = e($_POST['location']);
  $Phonenumber = e($_POST['phonenumber']);


  //array_push() is method used to add or store a string in an array at the end
  if ($password_1 != $password_2){
    array_push($errors,"*The password did not match");
  }
  if (empty($password_1)){
    array_push($errors,"*The password did not match");
  }
  if (empty($password_2)){
    array_push($errors,"*The password did not match");
  }
  if (strlen($password_1) < 5){
    array_push($errors,"*The password is too short");
  }
  if (empty($fname)){
    array_push($errors,"*First name is required");
  }
  if (empty($lname) ){
    array_push($errors,"*Last nmae is required");
  }
  if (empty($email) || !(filter_var($email,FILTER_VALIDATE_EMAIL))){
    array_push($errors,"*Email is required");
  }
  if (empty($location)){
    array_push($errors,"*location/address is required");
  }
  if(empty($Phonenumber)){
    array_push($errors,"Phone number is required");
  }

  if(count($errors) == 0){
    $password= password_hash($password_1, PASSWORD_DEFAULT);
    if (isset($_POST['user_type'])) {
              //this part should be registering an admin
        $user_type = e($_POST['user_type']);
        $query = "INSERT INTO users (username, email, user_type, password, location)
              VALUES('$username', '$email', '$user_type', '$password','$location')";
        mysqli_query($db, $query);
        $_SESSION['success']  = "New user successfully created!!";
        header('location: home.php');


}else{
  //input data into the customers  table
  $q = "SELECT * FROM customers WHERE Email='$email'";
  $res_e = mysqli_query($db,$q);
  //checking if there is any row in the database that contain a similar emailaddress
  if(mysqli_num_rows($res_e) > 0){
    array_push($errors,"The following email is already taken:");

  }else{
    $query ="INSERT INTO customers ( firstname, lastname, Email, PhoneNumber, Password, user_type, location)
      VALUES ('$fname', '$lname', '$email','$Phonenumber','$password', 'user', '$location')";
      mysqli_query($db, $query);

      $logged_in_user_id = mysqli_insert_id($db);
      $_SESSION['user'] = getUserbyId($logged_in_user_id);
      $_SESSION['success']='You are now logged in';
      header("location: index.php" );
    }

    }
  }
}
function getUserbyId($id){
  global $db;

    $query = "SELECT * FROM customers WHERE CustomerId=".$id;
    $result = mysqli_query($db,$query);
    $user = mysqli_fetch_assoc($result);
    return $user;
}

function display_error() {
	global $errors;

	if (count($errors) > 0) {
			foreach ($errors as $error){
        echo '<div class="err">';
				echo $error .'<br>';
        echo '</div>';
			}
	}

}
function e($val){
	global $db;
	return mysqli_real_escape_string($db, trim($val));
}
function isLoggedIn()
{
	if (isset($_SESSION['user'])) {
		return true;
	}else{
		return false;
	}
}
if (isset($_GET['logout'])) {
	session_destroy();
	unset($_SESSION['user']);
	header("location: login.php");
}

if (isset($_POST['login_btn'])){
  Login();
}

function Login(){
  global $errors, $email,$db,$hash;
  $email = mysqli_real_escape_string($db, trim($_POST['emailaddress']));
  $password1 = e($_POST['password']);

  if (empty($email)){
    array_push($errors,"Email is required");
  }
  if (empty($password1)){
    array_push($errors, "Password is required");
  }
  //if there are no errors ie empty email or password
  if(count($errors) == 0){
    $query = "SELECT Password FROM customers WHERE Email='$email'";

    $results = mysqli_query($db, $query);
    $var = mysqli_fetch_assoc($results);
    $query1= "SELECT* FROM customers WHERE Email='$email' ";
    // echo 'you know   ' .$var['Password'] ;
    $res = mysqli_query($db, $query1 );

    $logged_in_user = mysqli_fetch_assoc($res);

    if (isset($var['Password'])){
      $hash = $var['Password'];

    }
    else {

    }
    //$pass = password_verify($password1,$hash);

    //$query = "SELECT * FROM customers WHERE Email='$email' AND Password='$pass' LIMIT 1 ";

    //check if the user exist in the database
    // echo '<br>you know   ' .$hash ;


    if(password_verify($password1,$hash))
    {
      //for a normal user, perform another if foar admin
      $_SESSION['user'] = $logged_in_user;
      $_SESSION['success'] = 'Welcome back ';
      header('location:order.php');
    }
    else{
      array_push($errors, 'Invalid Email/Password');


    }
  }

}

if(isset($_POST['calc'])){

  calc();
}


function calc(){
  global $quantity, $paper,$sides,$errors,$total,$price;

  if(isset($_POST['qnt_1'])) {

    $quantity= $_POST['qnt_1'];
       $qty = "<br>Quantity  ".$quantity."<br>";
  }
  if(empty($quantity)) {
    array_push($errors, 'please enter Quantity');
  }
  if(isset($_POST['papertype']))
  {
    $paper=$_POST['papertype'];
    $ppt = "Paper type  ".$paper;
  }
  if(empty($paper)) {
    array_push($errors,'please select paper type');
  }
  if(isset($_POST['printside'])){
    $sides=$_POST['printside'];
    $pts= "<br>Print side  ".$sides."<br>";
  }
  if(empty($sides)) {
    array_push($errors,'Please select print sides');

  }

  if ($paper == 'sticker' && $sides=='4color(single)'){
    $price = 25;

  }
  elseif($paper == 'artpaper' && $sides == '4color(single)'){
    $price= 20;

  }
  elseif ($paper == 'artpaper' && $sides == '4color(both sides)') {
    $price = 35;
  }
  elseif($paper == 'artboard' && $sides == '4color(single)'){
    $price = 24;
  }
  elseif ($paper == 'artboard' && $sides == '4color(both sides)') {
    $price = 39;
  }
  elseif($paper == 'bond' && $sides == '4color(single)'){
    $price = 17.5;
  }
  elseif ($paper == 'bond' && $sides == '4color(both sides)') {
    $price = 32.5;
  }

  elseif($paper == 'sticker' && $sides == 'B/white(single)'){
    $price= 13;

  }
  elseif($paper == 'artpaper' && $sides == 'B/white(single)'){
    $price= 8;

  }
  elseif ($paper == 'artpaper' && $sides == 'B/white(both sides)') {
    $price = 11;
  }
  elseif($paper == 'artboard' && $sides == 'B/white(single)'){
    $price = 12;
  }
  elseif ($paper == 'artboard' && $sides == 'B/white(both sides)') {
    $price = 15;
  }
  elseif($paper == 'bond' && $sides == 'B/white(single)'){
    $price = 5.5;
  }
  elseif ($paper == 'bond' && $sides == 'B/white(both sides)') {
    $price = 8.5;
  }


  // $total = $price * $quantity;
  //
  // return $qty.$ppt.$pts."Ksh ".$total;

}
function display_amount(){

  echo calc();
}





if (isset($_POST['save']))
{
  //echo 'Your file is uploading';
  //define a superglobal $_FILES[] and pass in the name of the file
  if($_FILES['file']['size'] == 0 ){
    array_push($errors,'Please select a file');
  }
  else{

  $file = $_FILES['file']; //this gives you an array about the file

  $filename = $_FILES['file']['name'];
  $filesize = $_FILES['file']['size'];
  $filetemp_loc =$_FILES['file']['tmp_name'];
  $fileerror = $_FILES['file']['error'];
  $filetype = $_FILES['file']['type'];

  $fileextension = explode('.',$filename);//explode function returns an array that has individual string that were generated
  //from the filename separated by the '.'
  //explode() function takes the seperator and the string you want to explode in reference to the seperator
  //the array can be accessed as usual with the indices [0][1], depending on the number of string that  are the in between

  $fileExt = strtolower($fileextension[1]);
  //coverted all the file exxtension to lower case so as to have a common ground when verifying the correct files have been uploaded.
  echo "file is not empty";
  upload_file();
}
}

function upload_file()
{
  global $ordid;
  //superglobal for php to get the name of the file uploaded
  global $fileExt, $filesize, $fileerror, $filename, $filetemp_loc, $file,$db,$errors,$flnm;
  $usrid = $_SESSION['user']['CustomerId'];


  print_r ($file);
  echo "<br>".$filetemp_loc;
  echo "<br>".$fileExt;
  //create an array called allowed that has all the file extension that the user is allowed to upload
  $allowed = array('jpg','jpeg','pdf','ai','word','docx','png','zip');


  //use the inbuilt function in_array to check whether the file extension is amember in allowed array.
  //it takes the variable and the array list you want to check to as parameters
  if(in_array($fileExt,$allowed))
  {
    if($fileerror === 0){
      //if the file doesnot contain any error go ahead and check the file size is less than 100mb
      //1000kb is equal to 1mb
      if($filesize < 5000000){
        //create an uniqid  but in future this will be the order number, for the file being uploaded
        //we add the extension at the by concatenating

        $filenewName = uniqid('',True).'.'.$fileExt;
        //create a file destination variable and set it to a folder you want to upload the file to
        //in future he file should be upoaded to the database
        //upload the file in a temporary location

        $destination = 'uploads/'.$filenewName;
        //move_uploaded_file($filetemp_loc, $destination);
        //if the file is moved to the folder known as uploads we woul want to move the file to our database too

        if (move_uploaded_file($filetemp_loc, $destination)){
          //run a mysql query to insert the file to our database

          $query = "INSERT INTO files (name,size,UserId,OrderNo)  VALUES ('$filenewName',$filesize,$usrid,23000)";

          //insert the order in to the database after calculation



          //pass the query into mysqli_query() as a parameter and the database connection and check if it was a successs
          if(mysqli_query($db,$query)){
            //echo "File was uploaded successfully";
            array_push($errors,'File was uploaded successfully');
          }else{
            //echo "File failed to upload";
            array_push($errors,'File failed to upload');
          }

          $quantity = $_COOKIE['a'];
          $papertype= $_COOKIE['b'];
          $printside = $_COOKIE['c'];
          $total = $_COOKIE['Total'];
          $description = $_COOKIE['des'];
          echo $description;
          $flnm = $filenewName;
          $qry = "SELECT * FROM files WHERE name='$filenewName' ";
          $re = mysqli_query($db,$qry);

          if(mysqli_num_rows($re) > 0 ){
            $row = mysqli_fetch_assoc($re);
            $n = $row['fileId'];
            // echo $n;
            $query3 = "INSERT INTO orders (Customer_Id,file_Id,papertype,quantity,status,amount,description,order_time) VALUES ($usrid,$n,'$papertype',$quantity,'Processing',$total,'$description',NOW())";

                        if(mysqli_query($db,$query3)){
                          array_push($errors,"order received".$flnm);
                        }else{
                          array_push($errors,"order not received");
                        }

            $qr = "SELECT * FROM orders WHERE file_id=".$n;
            $relt = mysqli_query($db,$qr);
            $res = mysqli_fetch_assoc($relt);
            $ordid = $res['OrderId'];

            $query4 = "INSERT INTO orderdetails(customer_id,file_id,printsides,order_id) VALUES ($usrid,$n,'$printside',$ordid)";


            if(mysqli_query($db,$query4)){
              array_push($errors,"order details received".$flnm);
            }else{
              array_push($errors,"order details not received");
            }



          }



        }

      }else {
        //echo "the file is too big";
        array_push($errors,'The file is too big');
      }
    }else{
      //echo "The file has an error";
      array_push($errors,'The file has an error');
    }
  }else {
    //echo "the file extension is not allowed";
    array_push($errors,'The file extension is not allowed');
  }
  send_mail();


}
if(isset($_POST['clk_pay'])){
  calc();
  if(count($errors) > 0){
    header('location:order.php');
  }else{
  header('location:uload.php');
  echo 'Payment in process';
}
}

if(isset($_POST['cnl_pay'])){
  header('location:index.php');
}


// if(isset('save')){
//   header('location:payment.php')
//   echo 'payment in process';
// }
function send_mail(){
global $flnm,$db;

$q = "SELECT fileId FROM files WHERE name='$flnm'";
$res = mysqli_query($db,$q);
$d = mysqli_fetch_assoc($res);
$na = $_SESSION['user']['firstname'];
$c_id = $_SESSION['user']['CustomerId'];
$l = "SELECT OrderId FROM orders WHERE file_Id=".$d['fileId'];
$res2 = mysqli_query($db,$l);
$ord_id = mysqli_fetch_assoc($res2);
$ordid = $ord_id['OrderId'];

$k = "SELECT Email FROM customers WHERE CustomerId=".$c_id;
$res3 = mysqli_query($db,$k);
$c_mail = mysqli_fetch_assoc($res3);
$cust_mail = $c_mail['Email'];

$mail = new PHPMailer(true);
try{
$mail->isSMTP();
$mail->Mailer = "smtp";


$mail->SMTPDebug =0;
$mail->SMTPAuth =TRUE;
$mail->Port =587;
$mail-> Host ="smtp.gmail.com";
$mail->Username ="mkdennnis@gmail.com";
$mail->Password ="u)p6FY%3!RKpI)";
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
$mail-> IsHTML(true);
$mail-> addAddress("$cust_mail","Kayd");
$mail-> setFrom("mkdennnis@gmail.com","Dennis");
$mail-> Subject = "Online Web2Print";
$mail-> Body = "<b style=font-size:50px;>Thankyou $na your order number is $ordid</b> ";
$mail-> addAttachment('C:\xampp\htdocs\new\images\46.pdf');

$mail->Send();


	echo "Email was sent successfully".$c_id;
} catch(Exception $e){



	echo "Message could not be sent.Mailer Error: {$mail->ErrorInfo}";
}
}


if(isset($_POST["clk"])){
  global $db;

    $ordid = $_COOKIE['id'];
    $query = "SELECT * FROM orders WHERE OrderId=".$ordid;
    $result = mysqli_query($db,$query);
    $find = mysqli_fetch_assoc($result);
    // echo $find;
    $amnt = $find['amount'];
    $ord = $find['OrderId'];
    $usrid = $find['Customer_Id'];
    $pay_code = $_POST['code'];

    $que = "INSERT INTO payment (amount,order_id,user_id,payment_code,transTime,payment_status) VALUES($amnt,$ord,$usrid,'$pay_code',NOW(),'Pending')";
    if(mysqli_query($db,$que)){
      echo "payment info success";

    }else {
      echo "payment info unsuccessfull";
    }

header('location:index.php');
}
?>
