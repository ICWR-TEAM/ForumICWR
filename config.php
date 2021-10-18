<?php

// error_reporting(0);

//description
$forum_name="R&D Forum";
$from_email="silendprojeck@gmail.com";
$url_host="http://localhost/project/forum/forum2/index.php";

$host_mysql="localhost";
$username_mysql="root";
$password_mysql="";
$db_name="forum";

$conn=mysqli_connect($host_mysql,$username_mysql,$password_mysql,$db_name);

function sql($value=null){
  global $conn;
  return mysqli_real_escape_string($conn,$value);
}

function xss($value=null){
  return htmlentities($value);
}

function sql_xss($value=null)
{
  global $conn;
  return htmlentities(mysqli_real_escape_string($conn,$value));
}

function page_404(){
  header("HTTP/1.0 404 Not Found");
  // $retitle="404 Pages Not Found";
  echo "
  <div class='card mt-3 border-dark'>
    <div class='card-body'>
      <div class='text-center' style='padding: 50px;'>
        <h1>404 Pages Not Found</h1>
      </div>
    </div>
  </div>
  ";
  // exit;
}

function header_404()
{
  header("HTTP/1.0 404 Not Found");
  // $retitle="404 Pages Not Found";
  echo "
  <div class='text-center' style='padding: 50px;'>
    <h1>404 Pages Not Found</h1>
  </div>
  ";
  // exit;
}

function createToken()
{
	$token= base64_encode(openssl_random_pseudo_bytes(32));
	$_SESSION['csrfvalue']=$token;
	return $token;
}

function unsetToken()
{
	unset($_SESSION['csrfvalue']);
}

function validation(){
  $csrfvalue = isset($_SESSION['csrfvalue']) ? mysqli_real_escape_string($conn,$_SESSION['csrfvalue']) : '';
  if(isset($_POST['csrf_name'])){
    $value_input=$_POST['csrf_name'];
		if($value_input==$csrfvalue){
			unsetToken();
			return true;
    }else{
			unsetToken();
			return false;
		}
	}else{
		unsetToken();
		return false;
	}
}

 ?>
