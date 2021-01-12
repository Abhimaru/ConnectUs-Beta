<!DOCTYPE html>
<?php
	session_start();
	if(!isset($_SESSION['Username'])){
		?>
			<script>
				alert("You are Logged out");
			</script>
		<?php
		header("location:../inc/logout.php");
	}
?>
<html lang="en">
<head>
		<meta charset="utf-8">
		<title>ConnectUs - The Messaging Site</title>
		<meta name="description" content="#">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<!-- Bootstrap core CSS -->
		<link href="dist/css/lib/bootstrap.min.css" type="text/css" rel="stylesheet">
		<!-- Swipe core CSS -->
		<link href="dist/css/swipe.min.css" type="text/css" rel="stylesheet">
		<!-- Favicon -->
		<link href="dist/img/favicon.png" type="image/png" rel="icon">

		<style type="text/css">
			#pbtn01:hover{
				color: red;
			}

			input[type="file"]{
				display: none;
			}

		</style>
	</head>


	<!-- PHP START-->

	<?php
		include "../connection.php";

		//for fetching information from database
		$usrnm = $_SESSION['Username'];
		$queryfetch = "select * from signup where Username = '$usrnm'";
		$fetchrun = mysqli_query($con, $queryfetch);
		$res = mysqli_fetch_array($fetchrun);

		//for notification menu
		
			if(isset($_POST['accept_request']))
			{
				$targetid = $_POST['Pass_Id'];
				$targetid2 = $_POST['Pass_Id2'];
				
				$cid = $targetid.".".$targetid2;
				$contactid = (double)$cid;
				$updateq = "update notification set Status = 'activated' where Id = $targetid and FriendId = $targetid2";
				$updatefq = mysqli_query($con,$updateq);
					$updateq2 = "update notification set Contact_id = $contactid where Id = $targetid and FriendId = $targetid2";
					$updatefq2 = mysqli_query($con,$updateq2);
						
				if($updatefq and $updatefq2)
				{
					$check_query = "select * from contact where Contact_id = $contactid";
					$check_queryf = mysqli_query($con,$check_query);
					$countcqf = mysqli_num_rows($check_queryf);
					if($countcqf==0)
					{
						$insertq = "insert into contact values ($contactid,$targetid,$targetid2,CURRENT_TIMESTAMP)";
						$insertfq = mysqli_query($con,$insertq);
						if($insertfq)
						{

								

							?>
							<script>
								alert("Request Successfully Accepted");
							</script>
							<?php

							$_SESSION['cid'] = $contactid;
							$_SESSION['$contactid'] = time()+(60*60*24);
							
						}
						else
						{
							?>
							<script>
								alert("Error Occurred.. Please try again later..");
							</script>
							<?php
						}
					}
					else
					{
						?>
						<script>
							alert("Error Occurred.. Please try again later..");
						</script>
						<?php
					}
					
				}
			}
			else if (isset($_POST['reject_request'])) {
				$targetid = $_POST['Pass_Id'];
				$targetid2 = $_POST['Pass_Id2'];
				
				$updateq = "delete from notification where Id = $targetid and FriendId = $targetid2";
				$updatefq = mysqli_query($con,$updateq);
				if($updatefq)
				{
					?>
					<script>
						alert("Request Successfully Rejected");
					</script>
					<?php
				}
				
			}
		



		//for adding friend
		if (isset($_POST['addfrd'])) {
			$addusername = $_POST['addusername'];
			$addusermsg = $_POST['addusermsg'];
			$userq = "select * from signup where Username = '$addusername' and Username != '$usrnm'";
			$userqrun = mysqli_query($con, $userq);
			$usercount = mysqli_num_rows($userqrun);
			if($usercount>0)
			{
				$fnd=mysqli_fetch_array($userqrun);
				$fndid=$fnd['Id'];
				$resid=$res['Id'];
				$verifyrq="select Id from notification where Id = '$resid' and FriendId = '$fndid'";
				$verifyq=mysqli_query($con,$verifyrq);
				$verifyq_count=mysqli_num_rows($verifyq);

				if($verifyq_count==0)
				{
					$verifyrq="select FriendId from notification where FriendId='$resid' and Id = '$fndid' ";
					$verifyq=mysqli_query($con,$verifyrq);
					$verifyq_count=mysqli_num_rows($verifyq);
					if($verifyq_count==0)
					{
						$sendrq="insert into notification values($resid,'Sent',$fndid,CURRENT_TIMESTAMP,'$addusermsg','deactivated',0)";
						$sendq=mysqli_query($con,$sendrq);
						
						if($sendq)
						{
						?>
							<script>
								alert("Friend request successfully sent to <?php echo $addusername; ?> and your message is: <?php echo $addusermsg?>");
							</script>
						<?php
						}
						else
						{
						?>
							<script>
								alert("Error Occurred.. Please try again later..");
							</script>
						<?php	
						}
					}
					else
					{
						$verify_statusrq = "select Status from notification where FriendId='$resid' and Id = '$fndid' and Status = 'activated'";
						$verify_statusfrq = mysqli_query($con,$verify_statusrq);
						$verifycount = mysqli_num_rows($verify_statusfrq);
						if($verifycount==1)
						{
							?>
								<script>
									alert("Can't send Friend request to your existing friend..");
								</script>
							<?php	
						}
						else
						{

							?>
								<script>
									alert("Request already received to you.. Check your Notification box");
								</script>
							<?php
						}	
					}
				}
				else
				{

					?>
						<script>
							alert("Friend request already sent to the user");
						</script>
					<?php	
				}
			}		
			else{
				?>
					<script>
						alert("USER NOT FOUND");
					</script>
				<?php 
			}
		}

		//for changing personal information
		if(isset($_POST['applychanges'])){
			$newusername = $_POST['username'];
			$dob = $_POST['dob'];
			$userq = "select * from signup where Username = '$newusername' and Username != '$usrnm'";
			$userqrun = mysqli_query($con, $userq);
			$usercount = mysqli_num_rows($userqrun);
			if($usercount>0){
				$_SESSION['wrongusernm'] = "Username is already taken Please use different username";
			}
			else{
				$userupdatequery = "update signup set Username = '$newusername', DOB = '$dob' where Username = '$usrnm'";
				$userquery = mysqli_query($con, $userupdatequery);
				if($userquery){
					$_SESSION['Username'] = $newusername;
					unset($_SESSION['wrongusernm']);
					?>
					<script>
						alert("Username and dob changed Please refresh page");
					</script>
					<?php			
				}	
			}
		}

		//for changing password
		if(isset($_POST['changepwd'])){
			$db_oldpwd = $res['Password'];  //password from database
			$oldpwd = $_POST['oldpwd'];  //password fromm oldpassword field
			$password_decode = password_verify($oldpwd, $db_oldpwd);
			if ($password_decode) {
				$newpwd = $_POST['newpwd'];
				$anewpwd = $_POST['anewpwd'];

				$h_newpwd = password_hash($newpwd, PASSWORD_BCRYPT);
				$h_anewpwd = password_hash($anewpwd, PASSWORD_BCRYPT);

				if($newpwd === $anewpwd){
					$updatepassquery = "update signup set Password = '$h_newpwd' where Username = '$usrnm'";
					$upquery = mysqli_query($con, $updatepassquery);
					if($upquery){
						unset($_SESSION['passchange']);
						header("location:../login.php");
					}
				}
				else{
					$_SESSION['passchange'] = "Passwords are not match";
				}
			}
			else{
				$_SESSION['passchange'] = "Old password is incorrect";
			}
		}

		//for delete account

		if (isset($_POST['deletemyaccountbtn']))
		{
			$selectq = "select * from signup where Username = '$usrnm'";
			$selectfq = mysqli_query($con,$selectq);
			$victim = mysqli_fetch_array($selectfq);
			$victim_id = (int)$victim['Id'];
			$deletepq1 = "delete from notification where Id = '$victim_id' or FriendId = '$victim_id'";
			$deletefq1 = mysqli_query($con,$deletepq1);
			if ($deletefq1) {
			$deletepq2 = "delete from contact where Friend_id1 = '$victim_id' or Friend_id2 = '$victim_id'";
			$deletefq2 = mysqli_query($con,$deletepq2);
			if ($deletefq2) {
				$deleteaccquery = "delete from signup where Username = '$usrnm'";
				$deleteaccqueryrun = mysqli_query($con, $deleteaccquery);
				if ($deleteaccqueryrun) {
					$email = $res['Email'];
					$template_file = "../Mails/deleteacc.php";
					$subject = "Delete Account";
					$headers ="MIME-Version: 1.0 " . "\r\n";
					$headers.="From: connectus1111@gmail.com  " ."\r\n";
					$headers.="Content-type: text/html; charset=UTF-8". "\r\n";
					$headers.="X-Priority: 3";
					$headers.="X-Mailer: smail-PHP ".phpversion()."	". "\r\n";
					$swap_var = array(
					"{CUSTOM_URL}" => "http://localhost/Connect%20Us%20-%20Beta"
					);
					if (file_exists($template_file))
					$body = file_get_contents($template_file);
					else
					die ("Unable to locate your template file");
					foreach (array_keys($swap_var) as $key){
					if (strlen($key) > 2 && trim($swap_var[$key]) != '')
					$body = str_replace($key, $swap_var[$key], $body);
					}
					if (mail($email, $subject, $body, $headers))
					{
					session_destroy();
					header("location:../index.php");
					} else {
					echo "Email sending failed...";
					}
					}
			}
			else{
			?>
				<script>
					alert("Delete Query2 Failed");
				</script>
			<?php
			}
		}
		else{
		?>
			<script>
				alert("Delete Query1 Failed");
			</script>
		<?php
		}

		}

		// For set profile picture

		if (isset($_POST['myavatardefault'])){

	        $avatardefaultquery = "update signup set Picture = 'dist/img/avatars/default.png' where Username = '$usrnm'";
	        $avatardefaultqueryrun = mysqli_query($con, $avatardefaultquery);

	        if($avatardefaultqueryrun)
	        {
				?>
					<script>
						alert("DEFAULT PROFILE PICTURE SETED");
					</script>
				<?php
			}
			else
			{
				?>
					<script>
						alert("FAILED");
					</script>
				<?php 
			}
	    }

		if (isset($_POST['myavatar1'])){

	        $avatar1query = "update signup set Picture = 'dist/img/avatars/user1.png' where Username = '$usrnm'";
	        $avatar1queryrun = mysqli_query($con, $avatar1query);

	        if($avatar1queryrun)
	        {
				?>
					<script>
						alert("PROFILE PICTURE SETED SUCCESSFULLY");
					</script>
				<?php
			}
			else
			{
				?>
					<script>
						alert("FAILED");
					</script>
				<?php 
			}
	    }

	    if (isset($_POST['myavatar2']))
		{
	        $avatar2query = "update signup set Picture = 'dist/img/avatars/user2.png' where Username = '$usrnm'";
	        $avatar2queryrun = mysqli_query($con, $avatar2query);

	        if($avatar2queryrun)
	        {
				?>
					<script>
						alert("PROFILE PICTURE SETED SUCCESSFULLY");
					</script>
				<?php
			}
			else
			{
				?>
					<script>
						alert("FAILED");
					</script>
				<?php 
			}
	    }

		if (isset($_POST['myavatar3']))
		{
	        $avatar3query = "update signup set Picture = 'dist/img/avatars/user3.png' where Username = '$usrnm'";
	        $avatar3queryrun = mysqli_query($con, $avatar3query);

	        if($avatar3queryrun)
	        {
				?>
					<script>
						alert("PROFILE PICTURE SETED SUCCESSFULLY");
					</script>
				<?php
			}
			else
			{
				?>
					<script>
						alert("FAILED");
					</script>
				<?php 
			}
	    }

		if (isset($_POST['myavatar4']))
		{
	        $avatar4query = "update signup set Picture = 'dist/img/avatars/user4.png' where Username = '$usrnm'";
	        $avatar4queryrun = mysqli_query($con, $avatar4query);

	        if($avatar4queryrun)
	        {
				?>
					<script>
						alert("PROFILE PICTURE SETED SUCCESSFULLY");
					</script>
				<?php
			}
			else
			{
				?>
					<script>
						alert("FAILED");
					</script>
				<?php 
			}
	    }

	    if (isset($_POST['myavatar5']))
		{
	        $avatar5query = "update signup set Picture = 'dist/img/avatars/user5.png' where Username = '$usrnm'";
	        $avatar5queryrun = mysqli_query($con, $avatar5query);

	        if($avatar5queryrun)
	        {
				?>
					<script>
						alert("PROFILE PICTURE SETED SUCCESSFULLY");
					</script>
				<?php
			}
			else
			{
				?>
					<script>
						alert("FAILED");
					</script>
				<?php 
			}
	    }

	    if (isset($_POST['myavatar6']))
		{
	        $avatar6query = "update signup set Picture = 'dist/img/avatars/user6.png' where Username = '$usrnm'";
	        $avatar6queryrun = mysqli_query($con, $avatar6query);

	        if($avatar6queryrun)
	        {
				?>
					<script>
						alert("PROFILE PICTURE SETED SUCCESSFULLY");
					</script>
				<?php
			}
			else
			{
				?>
					<script>
						alert("FAILED");
					</script>
				<?php 
			}
	    }

		if (isset($_POST['myavatar7']))
		{
	        $avatar7query = "update signup set Picture = 'dist/img/avatars/user7.png' where Username = '$usrnm'";
	        $avatar7queryrun = mysqli_query($con, $avatar7query);

	        if($avatar7queryrun)
	        {
				?>
					<script>
						alert("PROFILE PICTURE SETED SUCCESSFULLY");
					</script>
				<?php
			}
			else
			{
				?>
					<script>
						alert("FAILED");
					</script>
				<?php 
			}
	  
	    }

		if (isset($_POST['myavatar8']))
		{
	        $avatar8query = "update signup set Picture = 'dist/img/avatars/user8.png' where Username = '$usrnm'";
	        $avatar8queryrun = mysqli_query($con, $avatar8query);

	        if($avatar8queryrun)
	        {
				?>
					<script>
						alert("PROFILE PICTURE SETED SUCCESSFULLY");
					</script>
				<?php
			}
			else
			{
				?>
					<script>
						alert("FAILED");
					</script>
				<?php 
			}
	    }
	?>


	<!-- PHP END -->
	

	<body>
		<main>
			<div class="layout">
				<!-- Start of Navigation -->
				<div class="navigation">
					<div class="container">
						<div class="inside">
							<div class="nav nav-tab menu">
								<a href="#members" data-toggle="tab"><i class="material-icons">account_circle</i></a>
								<a href="#discussions" data-toggle="tab" class="active"><i class="material-icons active">chat_bubble_outline</i></a>
								<a href="#notifications" data-toggle="tab" class="f-grow1"><i class="material-icons">notifications_none</i></a>
								<a href="#settings" data-toggle="tab"><i class="material-icons">settings</i></a>
								<!-- <button class="btn power" onclick="visitPage();"> -->
								<a href="../inc/logout.php" id="pbtn01">
								<i class="material-icons">power_settings_new</i>
								</a>
							</div>
						</div>
					</div>
				</div>
				<!-- End of Navigation -->
				<!-- Start of Sidebar -->
				<div class="sidebar" id="sidebar">
					<div class="container">
						<div class="col-md-12">
							<div class="tab-content">
								<!-- Start of Contacts -->
								<div class="tab-pane fade" id="members">
									<div class="search">
										<form class="form-inline position-relative">
											<input type="search" class="form-control" id="people" placeholder="Search for people...">
											<button type="button" class="btn btn-link loop"><i class="material-icons">search</i></button>
										</form>
										<button class="btn create" data-toggle="modal" data-target="#exampleModalCenter"><i class="material-icons">person_add</i></button>
									</div>						
									<div class="contacts">
										<h1>Contacts</h1>
										<div class="list-group" id="contacts" role="tablist">
										<?php

											$usrnm = $_SESSION['Username'];
											$queryfetch = "select * from signup where Username = '$usrnm'";
											$fetchrun = mysqli_query($con, $queryfetch);
											$res = mysqli_fetch_array($fetchrun);
											$resid = $res['Id'];
											$respic = $res['Picture'];
											$notifyq = "select * from notification where FriendId='$resid' or Id = '$resid' and status='activated'";
											$notifyfq = mysqli_query($con,$notifyq);
											$propcount = mysqli_num_rows($notifyfq);
											if($propcount>0)
											{
												
												while ($notifyarray = mysqli_fetch_array($notifyfq)) 
												{
													$cid = $notifyarray['Contact_id'];
													$propq = "select * from contact where Contact_id = $cid ";
													$propfq= mysqli_query($con,$propq);
													if($propfq)		
													{
														$propinfo = mysqli_fetch_array($propfq);	
														$user1 = $propinfo['Friend_id1'];
														$user2 = $propinfo['Friend_id2'];
														if($user1 == $resid)
														{
															
															$findq = "select * from signup where Id = $user2";
															$findfq = mysqli_query($con,$findq);
															$findcount = mysqli_num_rows($findfq);
															if($findcount==1)
															{
																$propinfo = mysqli_fetch_array($findfq);
																$profilepic = $propinfo['Picture'];
																echo "<a href='#' class='filterMembers all online contact'>
																		<img class='avatar-md' src='$profilepic' data-toggle='tooltip' data-placement='top' alt='avatar'>
																		<div class='data'>
																			<h5>"; echo $propinfo['Username']; echo "</h5>
																		
																		</div>
																		<div class='person-add'>
																			<i class='material-icons'>person</i>
																		</div>
																	</a>";
															}
														}
														elseif ($user2 == $resid) 
														{
															$findq = "select * from signup where Id = $user1";
															$findfq = mysqli_query($con,$findq);
															$findcount = mysqli_num_rows($findfq);
															if($findcount==1)
															{
																$propinfo = mysqli_fetch_array($findfq);	
																$profilepic = $propinfo['Picture'];
																echo "<a href='#' class='filterMembers all online contact'>
																		<img class='avatar-md' src='$profilepic' data-toggle='tooltip' data-placement='top' alt='avatar'>
																		<div class='data'>
																			<h5>"; echo $propinfo['Username']; echo "</h5>
																		
																		</div>
																		<div class='person-add'>
																			<i class='material-icons'>person</i>
																		</div>
																	</a>";
															}
														}		
													}
												}
											}
										?>

											<!-- <a href="#" class="filterMembers all online contact" data-toggle="list">
												<img class="avatar-md" src="dist/img/Card.jpg" data-toggle="tooltip" data-placement="top"alt="avatar">
												<div class="status">
													<i class="material-icons online">fiber_manual_record</i>
												</div>
												<div class="data">
													<h5>Chauhan Jay</h5>
													
												</div>
												<div class="person-add">
													<i class="material-icons">person</i>
												</div>
											</a>
											<a href="#" class="filterMembers all online contact" data-toggle="list">
												<img class="avatar-md" src="dist/img/Card.jpg" data-toggle="tooltip" data-placement="top" alt="avatar">
												<div class="status">
													<i class="material-icons online">fiber_manual_record</i>
												</div>
												<div class="data">
													<h5>Maru Abhishek</h5>
													
												</div>
												<div class="person-add">
													<i class="material-icons">person</i>
												</div>
											</a>
											<a href="#" class="filterMembers all online contact" data-toggle="list">
												<img class="avatar-md" src="dist/img/Card.jpg" data-toggle="tooltip" data-placement="top" alt="avatar">
												<div class="status">
													<i class="material-icons online">fiber_manual_record</i>
												</div>
												<div class="data">
													<h5>Gadhkai Tanjeel</h5>
													
												</div>
												<div class="person-add">
													<i class="material-icons">person</i>
												</div>
											</a>
											<a href="#" class="filterMembers all online contact" data-toggle="list">
												<img class="avatar-md" src="dist/img/Card.jpg" data-toggle="tooltip" data-placement="top" alt="avatar">
												<div class="status">
													<i class="material-icons online">fiber_manual_record</i>
												</div>
												<div class="data">
													<h5>Shiyani Dhiren</h5>
													
												</div>
												<div class="person-add">
													<i class="material-icons">person</i>
												</div>
											</a> -->
                                            <a href="#" class="filterMembers all online contact" data-toggle="list">
											</a>
											
										</div>
									</div>
								</div>
								<!-- End of Contacts -->
								<!-- Start of Discussions -->
								<div id="discussions" class="tab-pane fade active show">
									<div class="search">
										<form class="form-inline position-relative">
											<input type="search" class="form-control" id="conversations" placeholder="Search for conversations...">
											<button type="button" class="btn btn-link loop"><i class="material-icons">search</i></button>
										</form>
									</div>						
									<div class="discussions">
										<h1>Discussions</h1>
										<div class="list-group" id="chats" role="tablist">
											<a href="#list-chat" class="filterDiscussions all unread single active" id="list-chat-list" data-toggle="list" role="tab">
												<img class="avatar-md" src="dist/img/Card.jpg" data-toggle="tooltip" data-placement="top" alt="avatar">
												<div class="status">
													<i class="material-icons online">fiber_manual_record</i>
												</div>
												<div class="new bg-yellow">
													<span>+7</span>
												</div>
												<div class="data">
													<h5>Person1</h5>
													<span>Mon</span>
													<p>Hello World From Person 1.</p>
												</div>
											</a>									
											<a href="#list-empty" class="filterDiscussions all unread single" id="list-empty-list" data-toggle="list" role="tab">
												<img class="avatar-md" src="dist/img/Card.jpg" data-toggle="tooltip" data-placement="top" alt="avatar">
												<div class="status">
													<i class="material-icons offline">fiber_manual_record</i>
												</div>
												<div class="new bg-pink">
													<span>+10</span>
												</div>
												<div class="data">
													<h5>Person 2</h5>
													<span>Sun</span>
													<p>Hello World From Person 2.</p>
												</div>
											</a>									
											<a href="#list-chat" class="filterDiscussions all read single" id="list-chat-list2" data-toggle="list" role="tab">
												<img class="avatar-md" src="dist/img/Card.jpg" data-toggle="tooltip" data-placement="top" alt="avatar">
												<div class="status">
													<i class="material-icons offline">fiber_manual_record</i>
												</div>
												<div class="data">
													<h5>Person 3</h5>
													<span>Tus</span>
													<p>Hello World From Person 3.</p>
												</div>
											</a>
										</div>
									</div>
								</div>
								<!-- End of Discussions -->
								<!-- Start of Notifications -->
								

								<div id="notifications" class="tab-pane fade">
															
									<div class="notifications">
										<h1>Notifications</h1>
										<div class="list-group" id="alerts" role="tablist">
												
												
												<div>			
													<?php
														$usrnm = $_SESSION['Username'];
														$queryfetch = "select * from signup where Username = '$usrnm'";
														$fetchrun = mysqli_query($con, $queryfetch);
														$res = mysqli_fetch_array($fetchrun);
														$resid = $res['Id'];
														$notifyq = "select * from notification where FriendId='$resid' and status='deactivated'";
														$notifyfq = mysqli_query($con,$notifyq);
														$propcount = mysqli_num_rows($notifyfq);
														if($propcount>0)
														{
															$Friend = mysqli_fetch_array($notifyfq);
															$FriendId = $Friend['Id'];
															$propq = "select * from signup where Id in (select Id from notification where FriendId='$resid' and status='deactivated')";
															$propfq= mysqli_query($con,$propq);		
															//$propinfo = mysqli_fetch_array($propfq);	
															
															
															$notifyfq = mysqli_query($con,$notifyq);
															while ($temp = mysqli_fetch_array($notifyfq) and $propinfo = mysqli_fetch_array($propfq)) 
															{

																$profilepic = $propinfo['Picture'];
																echo 
																"<a href='#'' class='filterNotifications all oldest notification'>
																	<img class='avatar-md' src='$profilepic' data-toggle='tooltip' data-placement='top' alt='avatar'>	
																	<div class='data'>
																		<p>";echo $propinfo['Username']; echo " has sent you a friend request</p> 
																		<p style='font-weight:normal;'> Message: "; echo $temp['Message']; echo"
																		</p>
																		<p>";

																		?>
																		<form action="<?php echo htmlentities($_SERVER['PHP_SELF']);?>" method="post">	
																			<button type="submit" class="btn btn-outline-success btn-lg" name="accept_request">Accept</button>
																			<button type="submit" class="btn btn-outline-danger btn-lg" name="reject_request">Reject</button>
																			<input type="hidden" name="Pass_Id" value="<?php echo $temp['Id']?>">
																			<input type="hidden" name="Pass_Id2" value="<?php echo $res['Id']?>">
																		</form>
																				
																		<?php
																		 echo "
																		</p>
																		<span>"; 
																		echo $temp['Time']; echo "</span>
																	</div>						
																</a>";
																
															}


														}
														else
														{
															echo "<p style='color: black; font-size: 20px;'>No new notifications.</p>";
															
														}
														// if(isset($_SESSION['cid']))
														// 	{
																
														// 		if(isset($_SESSION['$contactid']))
														// 		{
																		
														// 		}
														// 		else
														// 		{}

														// 	}
														// else
														// {
														// 	echo "not work";
														// }
														

													?>
												</div>
												
											
												<!-- <img class="avatar-md" src="<?php if(isset($res['Picture'])){echo $res['Picture'];} ?>" data-toggle="tooltip" data-placement="top" alt="avatar"> -->
												<!-- <div class="status">
													<i class="material-icons online">fiber_manual_record</i>
												</div> -->
												<!-- <div class="data">
													<p>Anonymous Has accepted You Request</p>
													<span>Oct 17, 2018</span>
												</div> -->
											
											
											<!-- <a href="#" class="filterNotifications all oldest notification" data-toggle="list">
												<img class="avatar-md" src="dist/img/Card.jpg" data-toggle="tooltip" data-placement="top" alt="avatar">
												<div class="status">
													<i class="material-icons offline">fiber_manual_record</i>
												</div>
												<div class="data">
													<p>Ryan have just sent you a new message.</p>
													<span>Sep 31, 2017</span>
												</div>
											</a> -->
											<!-- <a href="#" class="filterNotifications all oldest notification" data-toggle="list">
												<img class="avatar-md" src="dist/img/Card.jpg" data-toggle="tooltip" data-placement="top" alt="avatar">
												<div class="status">
													<i class="material-icons offline">fiber_manual_record</i>
												</div>
												<div class="data">
													<p>Mildred has a birthday today. Wish him all the best.</p>
													<span>Jul 19, 2017</span>
												</div>
											</a> -->
                                            <a href="" class="filterNotifications all oldest notification"></a>
										</div>
									</div>
								</div>
							
								<!-- End of Notifications -->
								<!-- Start of Settings -->
								<div class="tab-pane fade" id="settings">			
									<div class="settings">
										<div class="profile">
											<img class="avatar-xl" src="<?php if(isset($res['Picture'])){echo $res['Picture'];} ?>" alt="avatar">
											<h1><a href="#"><?php if(isset($res['Username'])){echo $res['Username'];} ?></a></h1>
											<!-- <span>Gujarat,India</span> -->
											
										</div>
										<div class="categories" id="accordionSettings">
											<h1>Settings</h1>
											<!-- Start of My Account -->
											<div class="category">
												<a href="#" class="title collapsed" id="headingOne" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
													<i class="material-icons md-30 online">person_outline</i>
													<div class="data">
														<h5>My Account</h5>
														<p>Update your profile details</p>
													</div>
													<i class="material-icons">keyboard_arrow_right</i>
												</a>
												<div class="collapse" id="collapseOne" aria-labelledby="headingOne" data-parent="#accordionSettings">
													<div class="content">
														<div class="upload">
															<div class="data">
																<button name="uploadimg" data-toggle="modal" data-target="#myavatarimg" class="btn button">Change Avatar</button>
															</div>
															<p>Change your profile picture here</p>
														</div>
														<form action="<?php echo htmlentities($_SERVER['PHP_SELF']);?>" method="post">
															<div class="parent">
																<div class="field">
																	<label for="firstName">Username<span>*</span></label>
																	<input type="text" class="form-control" id="firstName" placeholder="First name" pattern="[A-Za-z_1-9]*" title="Only Alphabets and underscore allowed" minlength="5" maxlength="15" value="<?php if(isset($res['Username'])){echo $res['Username'];} ?>" name="username">
																	<p style="color: #dc3545; font-size: 14px; margin-top:15px;">
																	<?php
																	   if(isset($_SESSION['wrongusernm']))
																	   {
																	   	echo $_SESSION['wrongusernm'];
																	   }
																	?>
																</p>
																</div>
															</div>
															<div class="field">
																<label for="email">Email <span>*</span></label>
																<input type="email" class="form-control" id="email" placeholder="Enter your email address" value="<?php if(isset($res['Email'])){echo $res['Email'];} ?>" readonly>
																<p style="font-weight: lighter;">You can't change your email address</p>
															</div>

															<div class="field">
																<label for="dob">Date of birth<span>*</span></label>
																<input type="date" class="form-control" id="dob" name="dob"value="<?php if(isset($res['DOB'])){echo $res['DOB'];} ?>">
															</div>
															<!-- <div class="field">
																<label for="password">Password</label>
																<input type="password" class="form-control" id="password" placeholder="Enter a new password" value="password" required>
															</div> -->
															<!-- <div class="field">
																<label for="location">Location</label>
																<input type="text" class="form-control" id="location" placeholder="Enter your location" value="Gujarat, India" required>
															</div> -->
														<!-- 	<button class="btn btn-link w-100">Delete Account</button> -->
															<button type="submit" class="btn button w-100 mb-5" name="applychanges">Apply Changes</button>
														</form>

														<form action="<?php echo htmlentities($_SERVER['PHP_SELF']);?>" method="post">
															<div class="field">
																<label for="password">Password</label>
																<input type="password" class="form-control" id="password" placeholder="Old password" name="oldpwd" minlength="8" required>
															</div>
															<div class="field">
																<input type="password" class="form-control" id="password" placeholder="Enter New password" name="newpwd" minlength="8" required>
															</div>
															<div class="field">
																<input type="password" class="form-control" id="password" placeholder="Re-Enter New password" name="anewpwd" minlength="8" required>
																<p style="color: #dc3545; font-size: 14px; margin-top:15px;">
																	<?php
																	   if(isset($_SESSION['passchange']))
																	   {
																	   	echo $_SESSION['passchange'];
																	   }
																	?>
																</p>
															</div>
																<button type="submit" class="btn button w-100" name="changepwd">Change Password</button>
														</form>
													</div>
												</div>
											</div>
											<!-- End of My Account -->
											<!-- Start of Chat History -->
											<div class="category">
												<a href="#" class="title collapsed" id="headingTwo" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
													<i class="material-icons md-30 online">mail_outline</i>
													<div class="data">
														<h5>Chats</h5>
														<p>Delete your chat history</p>
													</div>
													<i class="material-icons">keyboard_arrow_right</i>
												</a>
												<div class="collapse" id="collapseTwo" aria-labelledby="headingTwo" data-parent="#accordionSettings">
													<div class="content layer">
														<div class="history">
															<p>When you clear your conversation history, the messages will be deleted from your own device.</p>
															<p>The messages won't be deleted or cleared on the devices of the people you chatted with.</p>
															<button type="submit" class="btn button w-100">Clear All Chat</button>
														</div>
													</div>
												</div>
											</div>
											<!-- End of Chat History -->


											<!-- Start of delete account -->
											<div class="category">
												<a href="#" class="title collapsed" id="headingSix" data-toggle="collapse" data-target="#collapseSix" aria-expanded="true" aria-controls="collapseSix">
													<i class="material-icons md-30 online">delete</i>
													<div class="data">
														<h5>Delete Account</h5>
														<p>Delete yout account permanently</p>
													</div>
													<i class="material-icons">keyboard_arrow_right</i>
												</a>
												<div class="collapse" id="collapseSix" aria-labelledby="headingSix" data-parent="#accordionSettings">
													<p>Are you sure you want to delete your account permanently?</p></br>
													<button class="btn button w-100 bg-warning" data-toggle="modal" data-target="#deletemyacc">Delete Account</button>
												</div>
											</div>
											<!-- End of delete account -->

											<!-- Start of Language -->
											<!-- <div class="category">
												<a href="#" class="title collapsed" id="headingSix" data-toggle="collapse" data-target="#collapseSix" aria-expanded="true" aria-controls="collapseSix">
													<i class="material-icons md-30 online">language</i>
													<div class="data">
														<h5>Language</h5>
														<p>Select preferred language</p>
													</div>
													<i class="material-icons">keyboard_arrow_right</i>
												</a>
												<div class="collapse" id="collapseSix" aria-labelledby="headingSix" data-parent="#accordionSettings">
													<div class="content layer">
														<div class="language">
															<label for="country">Language</label>
															<select class="custom-select" id="country" required>
																<option value="">Select an language...</option>
																<option>English, UK</option>
																<option>English, US</option>
															</select>
														</div>
													</div>
												</div>
											</div> -->
											<!-- End of Language -->
											<!-- Start of Privacy & Safety -->
											<!-- <div class="category">
												<a href="#" class="title collapsed" id="headingSeven" data-toggle="collapse" data-target="#collapseSeven" aria-expanded="true" aria-controls="collapseSeven">
													<i class="material-icons md-30 online">lock_outline</i>
													<div class="data">
														<h5>Privacy & Safety</h5>
														<p>Control your privacy settings</p>
													</div>
													<i class="material-icons">keyboard_arrow_right</i>
												</a>
												<div class="collapse" id="collapseSeven" aria-labelledby="headingSeven" data-parent="#accordionSettings">
													<div class="content no-layer">
														<div class="set">
															<div class="details">
																<h5>Everyone can add me</h5>
																<p>If enabled anyone in or out your friends of friends list can send you a friend request.</p>
															</div>
															<label class="switch">
																<input type="checkbox" checked>
																<span class="slider round"></span>
															</label>
														</div>
														<div class="set">
															<div class="details">
																<h5>Friends of Friends</h5>
																<p>Only your friends or your mutual friends will be able to send you a friend reuqest.</p>
															</div>
															<label class="switch">
																<input type="checkbox" checked>
																<span class="slider round"></span>
															</label>
														</div>
													</div>
												</div>
											</div> -->
											<!-- End of Privacy & Safety -->
											<!-- Start of Logout -->
											<div class="category">
												<a href="../inc/logout.php" class="title collapsed">
													<!-- <i class="material-icons md-30 online">power_settings_new</i>
													<div class="data">
														<h5>Power Off</h5>
														<p>Log out of your account</p>
													</div>
													<i class="material-icons">keyboard_arrow_right</i> -->
												</a>
											</div>
											<!-- End of Logout -->
										</div>
									</div>
								</div>
								<!-- End of Settings -->
							</div>
						</div>
					</div>
				</div>
				<!-- End of Sidebar -->
				<!-- Start of Add Friends -->
				<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-hidden="true">
					<div class="modal-dialog modal-dialog-centered" role="document">
						<div class="requests">
							<div class="title">
								<h1>Add your friends</h1>
								<button type="button" class="btn" data-dismiss="modal" aria-label="Close"><i class="material-icons">close</i></button>
							</div>
							<div class="content">
								<form action="<?php echo htmlentities($_SERVER['PHP_SELF']);?>" method="post">
									<div class="form-group">
										<label for="user">Username<span style="color: red">*</span></label>
										<input type="text" class="form-control" id="user" placeholder="Add recipient..." name="addusername" required>
									</div>
									<div class="form-group">
										<label for="welcome">Message(optional)</label>
										<textarea class="text-control" id="welcome" placeholder="Send your welcome message..." name="addusermsg">Hi, Would you like to be my Friend!</textarea>
									</div>
									<button type="submit" class="btn button w-100" name="addfrd">Send Friend Request</button>
								</form>
							</div>
						</div>
					</div>
				</div>
				<!-- End of Add Friends -->

				<!-- Start of delete account -->
				<div class="modal fade" id="deletemyacc" tabindex="-1" role="dialog" aria-hidden="true">
					<div class="modal-dialog modal-dialog-centered" role="document">
						<div class="requests">
							<div class="title">
								<h1>Delete Account Confirm?</h1>
								<button type="button" class="btn" data-dismiss="modal" aria-label="Close"><i class="material-icons">close</i></button>
							</div>
							<div class="content">
								<form action="<?php echo htmlentities($_SERVER['PHP_SELF']);?>" method="post">
									<label style="font-size: 20px; margin-bottom:25px ">All your account data will be lost permanently are you sure?</label>
									<button type="submit" class="btn btn-link button w-100" name="deletemyaccountbtn" style="background-color: rgb(255, 52, 38);">Sure, Delete Account</button>
								</form>
							</div>
						</div>
					</div>
				</div>

				<!-- End of delete account -->

				<!-- Start of Image upload -->
				<div class="modal fade" id="myavatarimg" tabindex="-1" role="dialog" aria-hidden="true">
					<div class="modal-dialog modal-dialog-centered" role="document">
						<div class="requests">
							 <div class="title">
								<h1>Select your avatar</h1>
								<button type="button" class="btn" data-dismiss="modal" aria-label="Close"><i class="material-icons">close</i></button>
							</div>
							<div class="content">
							<label style="font-size: 17px; margin-bottom:25px;">Choose your avatar and click set button to set as your profile picture</label>
							<div class="row text-center pb-5">
						  		<div class="col-3">
						  				<form action="<?php echo htmlentities($_SERVER['PHP_SELF']);?>" method="post">
											<img src="dist/img/avatars/user1.png" height="60px" width="60px">
											<button value="submit" name="myavatar1" class="btn button w-100 mt-3" style="padding: 5px 10px 5px 10px">Set</button>
										</form> 
						  		</div>

						  		<div class="col-3">
						  				<form action="<?php echo htmlentities($_SERVER['PHP_SELF']);?>" method="post">
											<img src="dist/img/avatars/user2.png" height="60px" width="60px">
											<button value="submit" name="myavatar2" class="btn button w-100 mt-3"
											style="padding: 5px 10px 5px 10px">Set</button>
										</form>
						  		</div>

						  		<div class="col-3">
						  				<form action="<?php echo htmlentities($_SERVER['PHP_SELF']);?>" method="post">
											<img src="dist/img/avatars/user3.png" height="60px" width="60px">
											<button value="submit" name="myavatar3" class="btn button w-100 mt-3"
											style="padding: 5px 10px 5px 10px">Set</button>
										</form>
						  		</div>

						  		<div class="col-3">
						  				<form action="<?php echo htmlentities($_SERVER['PHP_SELF']);?>" method="post">
											<img src="dist/img/avatars/user4.png" height="60px" width="60px">
											<button value="submit" name="myavatar4" class="btn button w-100 mt-3"
											style="padding: 5px 10px 5px 10px">Set</button>
										</form>
								</div>
							</div>

							<div class="row text-center pb-5">
						  		<div class="col-3">
						  				<form action="<?php echo htmlentities($_SERVER['PHP_SELF']);?>" method="post">
											<img src="dist/img/avatars/user5.png" height="60px" width="60px">
											<button value="submit" name="myavatar5" class="btn button w-100 mt-3"
											style="padding: 5px 10px 5px 10px">Set</button>
										</form> 
						  		</div>

						  		<div class="col-3">
						  				<form action="<?php echo htmlentities($_SERVER['PHP_SELF']);?>" method="post">
											<img src="dist/img/avatars/user6.png" height="60px" width="60px">
											<button value="submit" name="myavatar6" class="btn button w-100 mt-3"
											style="padding: 5px 10px 5px 10px">Set</button>
										</form>
						  		</div>

						  		<div class="col-3">
						  				<form action="<?php echo htmlentities($_SERVER['PHP_SELF']);?>" method="post">
											<img src="dist/img/avatars/user7.png" height="60px" width="60px">
											<button value="submit" name="myavatar7" class="btn button w-100 mt-3"
											style="padding: 5px 10px 5px 10px">Set</button>
										</form>
						  		</div>

						  		<div class="col-3">
						  				<form action="<?php echo htmlentities($_SERVER['PHP_SELF']);?>" method="post">
											<img src="dist/img/avatars/user8.png" height="60px" width="60px">
											<button value="submit" name="myavatar8" class="btn button w-100 mt-3"
											style="padding: 5px 10px 5px 10px;">Set</button>
										</form>
								</div>
							</div>
							<form action="<?php echo htmlentities($_SERVER['PHP_SELF']);?>" method="post">
								<button name="myavatardefault" class="btn button">Set Default</button>
							</form>
							</div>
						</div>
					</div>
				</div>
				<!-- End of Image upload -->

				<!-- Start of Create Chat -->
				<div class="modal fade" id="startnewchat" tabindex="-1" role="dialog" aria-hidden="true">
					<div class="modal-dialog modal-dialog-centered" role="document">
						<div class="requests">
							<div class="title">
								<h1>Start new chat</h1>
								<button type="button" class="btn" data-dismiss="modal" aria-label="Close"><i class="material-icons">close</i></button>
							</div>
							<div class="content">
								<form>
									<div class="form-group">
										<label for="participant">Recipient:</label>
										<input type="text" class="form-control" id="participant" placeholder="Add recipient..." required>
										<div class="user" id="recipient">
											<img class="avatar-sm" src="dist/img/avatars/avatar-female-5.jpg" alt="avatar">
											<h5>Keith Morris</h5>
											<button class="btn"><i class="material-icons">close</i></button>
										</div>
									</div>
									<div class="form-group">
										<label for="topic">Topic:</label>
										<input type="text" class="form-control" id="topic" placeholder="What's the topic?" required>
									</div>
									<div class="form-group">
										<label for="message">Message:</label>
										<textarea class="text-control" id="message" placeholder="Send your welcome message...">Hmm, are you friendly?</textarea>
									</div>
									<button type="submit" class="btn button w-100">Start New Chat</button>
								</form>
							</div>
						</div>
					</div>
				</div>
				<!-- End of Create Chat -->
				<div class="main">
					<div class="tab-content" id="nav-tabContent">
						<!-- Start of Babble -->
						<div class="babble tab-pane fade active show" id="list-chat" role="tabpanel" aria-labelledby="list-chat-list">
							<!-- Start of Chat -->
							<div class="chat" id="chat1">
								<div class="top">
									<div class="container">
										<div class="col-md-12">
											<div class="inside">
												<a href="#"><img class="avatar-md" src="dist/img/Card.jpg" data-toggle="tooltip" data-placement="top" title="Keith" alt="avatar"></a>
												<div class="status">
													<i class="material-icons online">fiber_manual_record</i>
												</div>
												<div class="data">
													<h5><a href="#">Admin</a></h5>
													<span>Active now</span>
												</div>
												<button class="btn d-md-block d-none"><i class="material-icons md-30">info</i></button>
												
											</div>
										</div>
									</div>
								</div>
								<div class="content" id="content">
									<div class="container">
										<div class="col-md-12">
											<!--<div class="date">
												<hr>
												<span>Yesterday</span>
												<hr>
											</div>-->
											
											
											
											<div class="date">
												<hr>
												<span>Today</span>
												<hr>
											</div>
											<div class="message me">
												<div class="text-main">
													<div class="text-group me">
														<div class="text me">
															<p>First Dummy Message</p>
														</div>
													</div>
													<span>10:21 PM</span>
												</div>
											</div>
											<div class="message">
												<img class="avatar-md" src="dist/img/Card.jpg" data-toggle="tooltip" data-placement="top" title="Keith" alt="avatar">
												<div class="text-main">
													<div class="text-group me">
														<div class="text me">
															<p>Reply Dummy Message</p>
														</div>
													</div>
													<span>10:21 PM</span>
												</div>
											</div>
											
											
										</div>
									</div>
								</div>
								<div class="container">
									<div class="col-md-12">
										<div class="bottom">
											<form class="position-relative w-100">
												<textarea class="form-control" placeholder="Type Your Message Here." rows="1"></textarea>
												
												<button type="submit" class="btn send"><i class="material-icons">send</i></button>
											</form>
											<label>
												<input type="file">
												<span class="btn attach d-sm-block d-none"><i class="material-icons">attach_file</i></span>
											</label> 
										</div>
									</div>
								</div>
							</div>
							<!-- End of Chat -->
						</div>
						<!-- End of Babble -->
						<!-- Start of Babble -->
						<div class="babble tab-pane fade" id="list-empty" role="tabpanel" aria-labelledby="list-empty-list">
							<!-- Start of Chat -->
							<div class="chat" id="chat2">
								<div class="top">
									<div class="container">
										<div class="col-md-12">
											<div class="inside">
												<a href="#"><img class="avatar-md" src="dist/img/Card.jpg" data-toggle="tooltip" data-placement="top" title="Lean" alt="avatar"></a>
												<div class="status">
													<i class="material-icons offline">fiber_manual_record</i>
												</div>
												<div class="data">
													<h5><a href="#">Person 2</a></h5>
													<span>Inactive</span>
												</div>
												<!-- <button class="btn connect d-md-block d-none" name="2"><i class="material-icons md-30">phone_in_talk</i></button>
												<button class="btn connect d-md-block d-none" name="2"><i class="material-icons md-36">videocam</i></button> -->
												<button class="btn d-md-block d-none"><i class="material-icons md-30">info</i></button>
												<!-- <div class="dropdown">
													<button class="btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="material-icons md-30">more_vert</i></button>
													<div class="dropdown-menu dropdown-menu-right">
														<button class="dropdown-item connect" name="2"><i class="material-icons">phone_in_talk</i>Voice Call</button>
														<button class="dropdown-item connect" name="2"><i class="material-icons">videocam</i>Video Call</button>
														<hr>
														<button class="dropdown-item"><i class="material-icons">clear</i>Clear History</button>
														<button class="dropdown-item"><i class="material-icons">block</i>Block Contact</button>
														<button class="dropdown-item"><i class="material-icons">delete</i>Delete Contact</button>
													</div>
												</div> -->
											</div>
										</div>
									</div>
								</div>
								<div class="content empty">
									<div class="container">
										<div class="col-md-12">
											<div class="no-messages">
												<i class="material-icons md-48">forum</i>
												<p>Seems people are shy to start the chat. Break the ice send the first message.</p>
											</div>
										</div>
									</div>
								</div>
								<div class="container">
									<div class="col-md-12">
										<div class="bottom">
											<form class="position-relative w-100">
												<textarea class="form-control" placeholder="Start typing for reply..." rows="1"></textarea>
												<!-- <button class="btn emoticons"><i class="material-icons">insert_emoticon</i></button> -->
												<button type="submit" class="btn send"><i class="material-icons">send</i></button>
											</form>
											<label>
												<input type="file">
												<span class="btn attach d-sm-block d-none"><i class="material-icons">attach_file</i></span>
											</label> 
										</div>
									</div>
								</div>
							</div>
							<!-- End of Chat -->
							<!-- Start of Call -->
							<!-- <div class="call" id="call2">
								<div class="content">
									<div class="container">
										<div class="col-md-12">
											<div class="inside">
												<div class="panel">
													<div class="participant">
														<img class="avatar-xxl" src="dist/img/avatars/avatar-female-2.jpg" alt="avatar">
														<span>Connecting</span>
													</div>							
													<div class="options">
														<button class="btn option"><i class="material-icons md-30">mic</i></button>
														<button class="btn option"><i class="material-icons md-30">videocam</i></button>
														<button class="btn option call-end"><i class="material-icons md-30">call_end</i></button>
														<button class="btn option"><i class="material-icons md-30">person_add</i></button>
														<button class="btn option"><i class="material-icons md-30">volume_up</i></button>
													</div>
													<button class="btn back" name="2"><i class="material-icons md-24">chat</i></button>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div> -->
							<!-- End of Call -->
						</div>
						<!-- End of Babble -->
						<!-- Start of Babble -->
						<!-- <div class="babble tab-pane fade" id="list-request" role="tabpanel" aria-labelledby="list-request-list"> -->
							<!-- Start of Chat -->
							<!-- <div class="chat" id="chat3">
								<div class="top">
									<div class="container">
										<div class="col-md-12">
											<div class="inside">
												<a href="#"><img class="avatar-md" src="dist/img/Card.jpg" data-toggle="tooltip" data-placement="top" title="Louis" alt="avatar"></a>
												<div class="status">
													<i class="material-icons offline">fiber_manual_record</i>
												</div>
												<div class="data">
													<h5><a href="#">Louis Martinez</a></h5>
													<span>Inactive</span>
												</div>
												<button class="btn disabled d-md-block d-none" disabled><i class="material-icons md-30">phone_in_talk</i></button>
												<button class="btn disabled d-md-block d-none" disabled><i class="material-icons md-36">videocam</i></button>
												<button class="btn d-md-block disabled d-none" disabled><i class="material-icons md-30">info</i></button>
												<div class="dropdown">
													<button class="btn disabled" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" disabled><i class="material-icons md-30">more_vert</i></button>
													<div class="dropdown-menu dropdown-menu-right">
														<button class="dropdown-item"><i class="material-icons">phone_in_talk</i>Voice Call</button>
														<button class="dropdown-item"><i class="material-icons">videocam</i>Video Call</button>
														<hr>
														<button class="dropdown-item"><i class="material-icons">clear</i>Clear History</button>
														<button class="dropdown-item"><i class="material-icons">block</i>Block Contact</button>
														<button class="dropdown-item"><i class="material-icons">delete</i>Delete Contact</button>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="content empty">
									<div class="container">
										<div class="col-md-12">
											<div class="no-messages request">
												<a href="#"><img class="avatar-xl" src="dist/img/avatars/avatar-female-6.jpg" data-toggle="tooltip" data-placement="top" title="Louis" alt="avatar"></a>
												<h5>Louis Martinez would like to add you as a contact. <span>Hi Keith, I'd like to add you as a contact.</span></h5>
												<div class="options">
													<button class="btn button"><i class="material-icons">check</i></button>
													<button class="btn button"><i class="material-icons">close</i></button>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="container">
									<div class="col-md-12">
										<div class="bottom">
											<form class="position-relative w-100">
												<textarea class="form-control" placeholder="Messaging unavailable" rows="1" disabled></textarea>
												<button class="btn emoticons disabled" disabled><i class="material-icons">insert_emoticon</i></button>
												<button class="btn send disabled" disabled><i class="material-icons">send</i></button>
											</form>
											<label>
												<input type="file" disabled>
												<span class="btn attach disabled d-sm-block d-none"><i class="material-icons">attach_file</i></span>
											</label> 
										</div>
									</div>
								</div>
							</div> -->
							<!-- End of Chat -->
						<!-- </div> -->
						<!-- End of Babble -->
					</div>
				</div>
			</div> <!-- Layout -->
		</main>
		<!-- Bootstrap/Swipe core JavaScript
		================================================== -->
		<!-- Placed at the end of the document so the pages load faster -->
		<script src="dist/js/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script>window.jQuery || document.write('<script src="dist/js/vendor/jquery-slim.min.js"><\/script>')</script>
		<script src="dist/js/vendor/popper.min.js"></script>
		<script src="dist/js/swipe.min.js"></script>
		<script src="dist/js/bootstrap.min.js"></script>
		<script>
			function scrollToBottom(el) { el.scrollTop = el.scrollHeight; }
			scrollToBottom(document.getElementById('content'));
		</script>
	</body>
</html>