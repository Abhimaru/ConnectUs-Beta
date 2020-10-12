<?php
	session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Forgot Password</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="stylesheet" type="text/css" href="../bootstrap/css/bootstrap.min.css">

	<link rel="stylesheet" type="text/css" href="../fonts/font-awesome-4.7.0/css/font-awesome.min.css">

	<link rel="stylesheet" type="text/css" href="../fonts/iconic/css/material-design-iconic-font.min.css">

	<link rel="stylesheet" type="text/css" href="../css/util.css">

	<link rel="stylesheet" type="text/css" href="../css/main_signup.css">

	<style type="text/css">
		
		.login1-form-title{
			font-size: 30px;
		}
	</style>
</head>
<body> 


<!-- HTML START -->
	<div class="limiter">
		<div class="container-login1" style="background-image: url('../images/bg-01.jpg');">
			<div class="wrap-login1 p-l-55 p-r-55 p-t-65 p-b-54">
				<form class="login1-form" action="" method="POST">

					<div class="container-fluid logo text-center">
						<p> CONNECT US </p>
					</div>
					<hr>
					<span class="login1-form-title p-b-40">
						Reset Password
					</span>

					<div class="wrap-input1 m-b-20">
						<span class="label-input1">Password</span>
						<input class="input1" type="password" name="password" placeholder="Type your new password" required>
						<span class="focus-input1" data-symbol="&#xf190;"></span>
					</div>
					
					<div class="wrap-input1  m-b-20">
						<span class="label-input1">Confirm Password</span>
						<input class="input1" type="password" name="cpassword" placeholder="Type your password again" required>
						<span class="focus-input1" data-symbol="&#xf190;"></span>
					</div>

					
					<div class="container-login1-form-btn">
						<div class="wrap-login1-form-btn">
							<div class="login1-form-bgbtn"></div>
							<button class="login1-form-btn" name="submit">
								Update Password
							</button>
						</div>
					</div>

					<div class="txt1 text-center p-t-34">
						<span>
							Already have an account? 
						<a href="../login.php" class="txt2">
							  Login
						</a>
						</span>
					</div>

					<p class="text-center mb-0 mt-3" style="font-size: 14px; margin: 10px -55px -30px -55px !important; font-weight: bold; color: red;">

						<!-- PHP PART START-->

						<?php

							include "../connection.php";

							if(isset($_POST['submit'])){

								if(isset($_GET['token'])){

									$token = $_GET['token'];
									$newpass = $_POST['password'];
									$cpass = $_POST['cpassword'];

									$newhpass = password_hash($newpass, PASSWORD_BCRYPT);

									if($newpass === $cpass){

											$updatequery = "update signup set Password='$newhpass' where Token='$token'";
											$iquery = mysqli_query($con, $updatequery);

											if($iquery){
												if(isset($_SESSION['display'])){
												$_SESSION['display'] = "Password Changed";
												header("location:../login.php");
												}
											}
											else{
												header("location:../login.php");
											}
									}
									else{
										echo "*Passwords are not matching*";
									}
								}
								else{
									header("location:../login.php");
								}
							}
						?>

						<!-- PHP PART END -->


					</p>
				</form>
			</div>
		</div>
	</div>
</body>
</html>