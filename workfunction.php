<?php
require('fpdf.php');

session_start();

$db = mysqli_connect('localhost','root','','ow2p') or die('Unable to connect');

$fname='';
$lname='';
$email='';
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

  $fname=e($_POST['firstname']);
  $lname=e($_POST['lastname']);
  $email=e($_POST['email']);
  $password_1=e($_POST['password1']);
  $password_2=e($_POST['password2']);
  $location = e($_POST['location']);
  $Phonenumber = e($_POST['phonenumber']);

  if ($password_1 != $password_2){
    array_push($errors,"*The password did not match");
  }
  if (empty($fname)){
    array_push($errors,"*First name is required");
  }
  if (empty($lname)){
    array_push($errors,"*Last nmae is required");
  }
  if (empty($email)){
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
$user_type = e($_POST['user_type']);
$query = "INSERT INTO users (username, email, user_type, password)
      VALUES('$username', '$email', '$user_type', '$password')";
mysqli_query($db, $query);
$_SESSION['success']  = "New user successfully created!!";
header('location: home.php');
}else{
  //input data into the customers  table
    $query ="INSERT INTO customers ( firstname, lastname, Email, PhoneNumber, Password, user_type)
      VALUES ('$fname', '$lname', '$email','$Phonenumber','$password', 'user')";
      mysqli_query($db, $query);

      // $logged_in_user_id = mysqli_insert_id($db);
      // $_SESSION['user'] = getUserbyId($logged_in_user_id);
      // $_SESSION['success']='You are now logged in';
      // header("location: index.php" );


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
    if($_SESSION['user']['user_type'] == 'admin'){
		return true;
  }
	}else{
		return false;
	}
}
if (isset($_GET['logout'])) {
  //destroy the session when the logout link is clicked
  //it uses a get method that is linked with this function waiting to see is if it is true
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
      //set user session after successful logging in
      $_SESSION['user'] = $logged_in_user;
      $_SESSION['success'] = 'Welcome back ';
      header('location:workflow.php');
    }
    else{
      array_push($errors, 'Invalid Email/Password');


    }
  }

}
if(isset($_POST['btn1'])){
  download_ticket();

}
if(isset($_POST['btn'])){
  download_file();

}

if(isset($_POST['btn2'])){
  header('location:update.php');
}

if(isset($_POST['b'])){
  header('location:payment_update.php');
}
function download_ticket(){
  global $db;
$orderid= $_COOKIE['id'];
// echo $orderid;
$query = "SELECT * FROM orders WHERE OrderId=".$orderid;
$rslts = mysqli_query($db,$query);
$ordr = mysqli_fetch_assoc($rslts);

$que = "SELECT * FROM orderdetails WHERE order_id=".$orderid;
$rs = mysqli_query($db,$que);
$det = mysqli_fetch_assoc($rs);
// echo  '<br>'.$ordr['description'];
$quantity = $ordr['quantity'];
$papertype= $ordr['papertype'];
$prdetails = $ordr['description'];
$total = $ordr['amount'];
$sid = $det['printsides'];

$pdf = new FPDF('P', 'mm', array(100,150));
$pdf -> AddPage();
$pdf -> SetFont('Arial','B',16);
$pdf -> Cell(40,10,'Online Web2Print');
$pdf -> SetFont('Arial','',10);
$pdf ->Ln();
$pdf -> Cell(40,40,'Order id:  '.$orderid);

$pdf -> Ln();
$pdf -> Cell(10,-5,'Quantity:  '.$quantity);
$pdf -> Ln();
$pdf -> Cell(10,-10,'Papertype:  '.$papertype);
$pdf -> Ln();

$pdf -> Cell(10,45,'Printsides:  '.$sid);
$pdf -> Ln();
$pdf -> Cell(10,-30,'ProductDetails: '.$prdetails);
$pdf -> Ln();
$pdf -> Cell(10,50,'Total Amount: Ksh '.$total);

$filename= "$orderid ticket_.pdf";

$pdf->Output('D',$filename,true);

}

function download_file(){
  global $db;
  $orderid= $_COOKIE['idx'];

  $query = "SELECT * FROM orders WHERE OrderId=".$orderid;
  $rslts = mysqli_query($db,$query);
  $ordr = mysqli_fetch_assoc($rslts);
  $fileid = $ordr['file_Id'];
  $sql = "SELECT * FROM files WHERE fileId=".$fileid;
  $file_rslt = mysqli_query($db, $sql);
  $file = mysqli_fetch_assoc($file_rslt);
  $filepath = 'uploads/' .$file['name'];
  if(file_exists($filepath)){
		header('Content-Description: File Transfer');
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename=' .basename($filepath));
		header('Expires: 0');
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
		header('Content-Lenght: ' .filesize('uploads/' .$file['name']));
		readfile('uploads/' .$file['name']);

	}
}









?>
