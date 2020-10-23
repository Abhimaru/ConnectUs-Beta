<?php
	session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Login Page</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">

	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">

	<link href="https://fonts.googleapis.com/css2?family=Inknut+Antiqua&display=swap" rel="stylesheet">
	
	<link href="https://fonts.googleapis.com/css2?family=Cairo&display=swap" rel="stylesheet">

	<link rel="stylesheet" type="text/css" href="fonts/iconic/css/material-design-iconic-font.min.css">

	<link rel="stylesheet" type="text/css" href="css/util.css">

	<link rel="stylesheet" type="text/css" href="css/main_login.css?<?php echo time();?>">
</head>
<body> 


<!-- HTML START -->

	<div class="limiter">
		<div class="container-login1" style="background-image: url('images/bg-01.jpg');">
			<div class="wrap-login1 p-l-55 p-r-55 p-t-65 p-b-54">
				<form class="login1-form" action="<?php echo htmlentities($_SERVER['PHP_SELF']);?>"method="post" > 

					<div class="container-fluid logo text-center">
						<!-- <img src="images/logo.png" class="img-fluid"> -->
						<p> CONNECT US </p>
					</div>
					<hr>

					<span class="login1-form-title p-b-19">
						Login
					</span>

					<p style="background: skyblue; font-size: 13px;" class="px-3 text-center"> <?php 
					if(isset($_SESSION['display'])){
						echo $_SESSION['display'];
					} 
					?>
					</p>
					<div class="wrap-input1 m-b-23">
						<span class="label-input1">Email</span>
						<input class="input1" type="email" name="email" placeholder="Type your Email" required value="<?php if(isset($_POST['email'])){echo htmlentities($_POST['email']);}?>"/>
						<span class="focus-input1" data-symbol="&#xf206;"></span>
					</div>

					<div class="wrap-input1">
						<span class="label-input1">Password</span>
						<input class="input1" type="password" name="password" placeholder="Type your password" required value="<?php if(isset($_POST['password'])){echo htmlentities($_POST['password']);}?>"/>
						<span class="focus-input1" data-symbol="&#xf190;"></span>
					</div>
					
					<div class="text-right p-t-8 p-b-31">
						<a href="inc/recover_email.php">
							Forgot password?
						</a>
					</div>
					
					<div class="container-login1-form-btn">
						<div class="wrap-login1-form-btn">
							<div class="login1-form-bgbtn"></div>
							<button class="login1-form-btn" name="submit">
								Login
							</button>
						</div>
					</div>

					<div class="txt1 text-center p-t-44">
						<span>
							Don't have an account? 
						<a href="signup.php" class="txt2">
							  Sign Up
						</a>
						</span>
					</div>

					<p class="text-center mb-0 mt-3" style="font-size: 14px; margin: 10px -55px -30px -55px !important; font-weight: bold; color: red;">

						<!-- PHP PART START-->

						<?php
							include "connection.php";
							if(isset($_POST['submit'])){

								$email = mysqli_real_escape_string($con, $_POST['email']);
								$pass = mysqli_real_escape_string($con, $_POST['password']);
								
								$email_s = "select * from signup where Email='$email' and Status='active' ";
								$query = mysqli_query($con, $email_s);

								$emailcount = mysqli_num_rows($query);

								if($emailcount){

									$email_pass = mysqli_fetch_assoc($query);
									$db_pass = $email_pass['Password']; 
									$_SESSION['Username'] = $email_pass['Username']; 

									$password_decode = password_verify($pass, $db_pass);

									if($password_decode){
										header("location:Home/index.php");
									}
									else{
										echo "*Password Inccorect*";
									}
								}
								else{
										echo "*Invalid email*";
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
<!-- HTML END -->