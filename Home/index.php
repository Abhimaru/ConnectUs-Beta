<?php
	session_start();

	if(!isset($_SESSION['Username'])){
		?>
			<script>
				alert("You are Logged out");
			</script>
		<?php
		header("location:../login.php");
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Home page</title>
</head>
<body>

	
		 <h1 style="text-align: center; font-size: 100px"> Welcome <?php echo $_SESSION['Username']; ?> </h1>
	
		 <a href="../inc/logout.php" style="margin-left: 48%; border:none; background: blue; color:white ; text-decoration: none; padding: 5px; border-radius: 10px;">LOGOUT</a>
		
</body>
</html>
		
		
		
		
		
		
		
		
		
		
		
		