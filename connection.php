<?php 

$username = 'root';
$password = '';
$server = 'localhost';
$database = 'connectus';
	
$con = mysqli_connect($server,$username,$password,$database);

if($con){
?>
	<script>
		alert("Connection Successful");
	</script>
<?php
}
 else {
?>
	<script>
		alert("Connection faild");
	</script>
<?php
}?>
