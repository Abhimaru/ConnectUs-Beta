<?php
	session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Signup Page</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">

	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">

	<link href="https://fonts.googleapis.com/css2?family=Inknut+Antiqua&display=swap" rel="stylesheet">

	<link href="https://fonts.googleapis.com/css2?family=Cairo&display=swap" rel="stylesheet">

	<link rel="stylesheet" type="text/css" href="fonts/iconic/css/material-design-iconic-font.min.css">

	<link rel="stylesheet" type="text/css" href="css/util.css">

	<link rel="stylesheet" type="text/css" href="css/main_signup.css?v=<?php echo time();?>">
	
</head>
<body> 

<!-- HTML START -->
	<div class="limiter">
		<div class="container-login1" style="background-image: url('images/bg-01.jpg');">
			<div class="wrap-login1 p-l-55 p-r-55 p-t-65 p-b-54">
				<form class="login1-form" action="<?php echo htmlentities($_SERVER['PHP_SELF']);?>" method="POST">

					<div class="container-fluid logo text-center">
						<!-- <img src="images/logo.png" class="img-fluid"> -->
						<p> CONNECT US </p>
					</div>
					<hr>
					<div class="login1-form-title p-b-40">
						Create Account
					</div>

					<div class="wrap-input1 m-b-20">
						<span class="label-input1">Username</span>
						<input class="input1" type="text" name="username" placeholder="Type your username" autocomplete="off" required="true" pattern="[A-Za-z_1-9]*" title="Only Alphabets and underscore allowed" value="<?php if(isset($_POST['username'])){echo htmlentities($_POST['username']);}?>"/>
						<span class="focus-input1" data-symbol="&#xf206;"></span>
					</div>

					<div class="wrap-input1 m-b-20">
						<span class="label-input1">Email</span>
						<input class="input1" type="email" name="email" placeholder="Type your email"  required value="<?php if(isset($_POST['email'])){echo htmlentities($_POST['email']);}?>"/>
						<span class="focus-input1" data-symbol="&#xf15a;"></span>
					</div>

					<div class="wrap-input1 m-b-20">
						<span class="label-input1">Date of birth</span>
						<input class="input1" type="date" name="date" min="1900-01-01" max="2007-12-31" 
						placeholder="Enter your date of birth" required value="<?php if(isset($_POST['date'])){echo htmlentities($_POST['date']);}?>"/>
						<span class="focus-input1" data-symbol=" &#xf32f;"></span>
					</div>

					<div class="wrap-input1 m-b-20">
						<span class="label-input1">Password</span>
						<input class="input1" type="password" name="password" placeholder="Type your password" minlength="8" required value="<?php if(isset($_POST['password'])){echo htmlentities($_POST['password']);}?>"/>
						<span class="focus-input1" data-symbol="&#xf190;"></span>
					</div>
					
					<div class="wrap-input1">
						<span class="label-input1">Confirm Password</span>
						<input class="input1" type="password" name="cpassword" placeholder="Type your password again" minlength="8" required value="<?php if(isset($_POST['cpassword'])){echo htmlentities($_POST['cpassword']);}?>"/>
						<span class="focus-input1" data-symbol="&#xf190;"></span>
					</div>

					<div class="txt1 text-center p-t-20 p-b-21 text-uppercase">
						<span>
							By signing up, you agree to our
						<a href="#" class="txt2">
							Terms & policy
						</a>
						</span>
					</div>
					
					<div class="container-login1-form-btn">
						<div class="wrap-login1-form-btn">
							<div class="login1-form-bgbtn"></div>
							<button class="login1-form-btn" name="submit">
								Signup
							</button>
						</div>
					</div>

					<div class="txt1 text-center p-t-34">
						<span>
							Already have an account? 
						<a href="login.php" class="txt2">
							  Login
						</a>
						</span>
					</div>


					<!-- PHP PART START-->

						<p class="text-center mb-0 mt-3" style="font-size: 14px; margin: 10px -55px -30px -55px !important; font-weight: bold; color: red;">
							<?php

							include "connection.php";
							if(isset($_POST['submit'])){
								$usrnm = mysqli_real_escape_string($con, $_POST['username']);
								$email = mysqli_real_escape_string($con, $_POST['email']);
								$dob = mysqli_real_escape_string($con, $_POST['date']);
								$pass = mysqli_real_escape_string($con, $_POST['password']);
								$cpass = mysqli_real_escape_string($con, $_POST['cpassword']);

								$h_pass = password_hash($pass, PASSWORD_BCRYPT);

								$token = bin2hex(random_bytes(15));


								$usernamequery = "select * from signup where Username='$usrnm'";
								$uquery = mysqli_query($con, $usernamequery);
								$usercount = mysqli_num_rows($uquery);

								if($usercount>0){
									echo "*Username is already taken please use different username*";
								}
								else{
									$emailquery = "select * from signup where Email='$email'";
									$query = mysqli_query($con, $emailquery);

									$emailcount = mysqli_num_rows($query);

									if($emailcount>0){ 
											echo "*Email Already Exist*";
									}
									else{
										if($pass === $cpass){

												$insertquery = "insert into signup(Username, Email, DOB, Password, Token, Status, Picture) values('$usrnm','$email','$dob','$h_pass','$token','inactive','dist/img/avatars/default.png')";
												$iquery = mysqli_query($con, $insertquery);

												if($iquery){

													$template_file = "Mails/active.php";

													$subject = "Account Activation";
													// $body = "Hi, $usrnm Click here to activate your account
													// http://localhost/Connect%20Us/inc/activate.php?token=$token";
													// $sendermail = "From: connectus1111@gmail.com";

													$headers ="MIME-Version: 1.0 " . "\r\n";
													$headers.="From: connectus1111@gmail.com  " ."\r\n";
													$headers.="Content-type: text/html; charset=UTF-8". "\r\n";
													$headers.="X-Priority: 3";
													$headers.="X-Mailer: smail-PHP ".phpversion()."	". "\r\n";

													$swap_var = array(
														"{CUSTOM_URL}" => "http://localhost/Connect%20Us/inc/activate.php?token=$token"
													);

													if (file_exists($template_file))
														$body = file_get_contents($template_file);
													else
														die ("Unable to locate your template file");

													foreach (array_keys($swap_var) as $key){
													if (strlen($key) > 2 && trim($swap_var[$key]) != '')
														$body = str_replace($key, $swap_var[$key], $body);
													}

													if (mail($email, $subject, $body, $headers)) {
													    $_SESSION['display'] ="Check your mail to activate your account $email";
													    header("location:login.php");
													} else {
													    echo "Email sending failed...";
													}
													
												}
												else{
													echo "*Failed to insert*";
												}
										}else{											
											echo "*Passwords are not matching*";
										}
									}
								}
							}
						?>
						</p>

					<!-- PHP PART END -->

				</form>
			</div>
		</div>
	</div>
</body>
</html>
<!-- HTML END -->