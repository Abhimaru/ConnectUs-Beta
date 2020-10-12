<?php
 session_start();

 include "../connection.php";

 if(isset($_GET['token'])){


 	$token = $_GET['token'];

 	$updatequery = " update signup set Status='active' where Token='$token' ";

 	$query = mysqli_query($con,$updatequery);

 	if($query){
 		if(isset($_SESSION['display'])){
 			$_SESSION['display']="Account activated Successfully";
 			header("location:../login.php");
 		}else{
 			$_SESSION['display'] = "You are logged out";
 			header("location:../login.php");
 		}
 	}else{
 		$_SESSION['display'] = "Account Not activated";
 			header("location:../signup.php");
 	}

 }

?>