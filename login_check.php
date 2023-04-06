<?php 
define('__IN_SCRIPT__', true);

require_once './helpers/base_url.php';
require_once './includes/connection.php';

session_start();

$username = $_POST['username'];
$password = $_POST['password'];

$login = $mysqli->query("select * from login where username='$username' and password='$password'");
$cek = mysqli_num_rows($login);

if($cek > 0){

	$data = mysqli_fetch_assoc($login);
	if($data['level']=="admin"){
 
		$_SESSION['username'] = $username;
		$_SESSION['level'] = "admin";
		header("location:dashboard.php");
 
	}else if($data['level']=="user"){
		$_SESSION['username'] = $username;
		$_SESSION['level'] = "user";
		header("location:details.php");
 
	}else{
		header("location:index.php");
	}
}else{
	header("location:index.php?gagal");
}
?>