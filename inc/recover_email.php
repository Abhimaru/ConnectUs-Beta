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
				<form class="login1-form" action="<?php echo htmlentities($_SERVER['PHP_SELF']);?>" method="POST">

					<div class="container-fluid logo text-center">
						<p> CONNECT US </p>
					</div>
					<hr>
					<span class="login1-form-title p-b-40">
						Recover Your Account
					</span>

					<div class="wrap-input1 m-b-20">
						<span class="label-input1">Email</span>
						<input class="input1" type="email" name="email" placeholder="Type your email"  required>
						<span class="focus-input1" data-symbol="&#xf15a;"></span>
					</div>
					
					<div class="container-login1-form-btn">
						<div class="wrap-login1-form-btn">
							<div class="login1-form-bgbtn"></div>
							<button class="login1-form-btn" name="submit">
								Send mail
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

								$email = $_POST['email'];

								$emailquery = "select * from signup where Email='$email' and Status='active'";
								$query = mysqli_query($con, $emailquery);

								$emailcount = mysqli_num_rows($query);

								if($emailcount){ 

										$userdata = mysqli_fetch_array($query);
										$username = $userdata['Username'];
										$token =  $userdata['Token'];

										$template_file = "../Mails/reset_pass.php";
										$subject = "Password Reset";
										// $body =  "Hi $username Click here to reset your password
										// http://localhost/Connect%20Us/inc/reset_password.php?token=$token";
										// $sender_email = "From: connectus1111@gmail.com";

										$headers ="MIME-Version: 1.0 " . "\r\n";
										$headers.="From: connectus1111@gmail.com  " ."\r\n";
										$headers.="Content-type: text/html; charset=UTF-8". "\r\n";
										$headers.="X-Priority: 3";
										$headers.="X-Mailer: smail-PHP ".phpversion()."	". "\r\n";

										$swap_var = array(
												"{CUSTOM_URL}" => "http://localhost/Connect%20Us/inc/reset_password.php?token=$token"
										);

										if (file_exists($template_file))
											$body = file_get_contents($template_file);
										else
											die ("Unable to locate your template file");

										foreach (array_keys($swap_var) as $key){
										if (strlen($key) > 2 && trim($swap_var[$key]) != '')
											$body = str_replace($key, $swap_var[$key], $body);
										}
										if(mail($email, $subject, $body, $headers)){
											$_SESSION['display'] = "Check your mail to reset your password $email";
											header("location:../login.php");
										}
										else{
											echo "*Email sending fail*";
										}
								}
								else{
									echo "*No email found*";
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