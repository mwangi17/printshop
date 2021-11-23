<?php
session_start();
$db = mysqli_connect('localhost','root','','ow2p') or die('Unable to connect');

$fname='';
$lname='';
$email='';
$errors=array();
$hash='';


if(isset($_POST['login'])){
  Login();

}
function Login(){
  global $errors, $fname,$db,$hash;
  $fname = mysqli_real_escape_string($db, trim($_POST['username']));
  $password1 =e($_POST['password']);

  if (empty($fname)){
    array_push($errors,"User name is required");
  }
  if (empty($password1)){
    array_push($errors, "Password is required");
  }
  //if there are no errors ie empty email or password
  if(count($errors) == 0){
    $query = "SELECT Password FROM customers WHERE firstname='$fname'  AND user_type='admin'";
    $quer = "SELECT * FROM customers WHERE firstname='$fname'  AND user_type='admin'";
    $r = mysqli_query($db,$quer);
    $logged_in_user = mysqli_fetch_assoc($r);

    $results = mysqli_query($db, $query);
    $var = mysqli_fetch_assoc($results);
    // echo 'you know   ' .$var['Password'] ;

    if (isset($var['Password'])){
        $hash = $var['Password'];
    }else{

    }
    //$pass = password_verify($password1,$hash);

    //$query = "SELECT * FROM customers WHERE Email='$email' AND Password='$pass' LIMIT 1 ";

    //check if the user exist in the database

    // echo 'you know   ' .$hash ;

    if(password_verify($password1,$hash))
    {
      //for a normal user, perform another if foar admin
      $_SESSION['user'] = $logged_in_user;
      $_SESSION['success'] = 'Welcome back ';
      header('location:workflow.php');
    }
    else{
      array_push($errors, 'Invalid Email/Password');


    }
  }


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
if (isset($_GET['logout'])) {
	session_destroy();
	unset($_SESSION['user']);
	header("location: admin.php");
}

?>
