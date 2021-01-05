<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="shortcut icon" href="images/Shortcut2.png">
	<title>Home</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.js">
  <link rel="stylesheet" type="text/css" href="css/style_index.css?<?php echo time();?>">
</head>


<body>

<!-- NAVIGATION BAR  -->

<section>
<header>
  <nav class="navbar navbar-expand-lg navbar-dark fixed-top header">
  <a class="navbar-brand" href="#">CONNECT US</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse text-center" id="navbarSupportedContent">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item active">
        <a class="nav-link" href="login.php">Login<span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="signup.php">Signup</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#ourteamid">Our team</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#contactusid">Contact Us</a>
      </li>
    </ul>
  </div>
</nav>
</header>
</section>


<!-- CAROUSEL -->

<section>
<div id="carouselExampleIndicators" class="carousel slide c" data-ride="carousel">
  <ol class="carousel-indicators">
    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
    <!-- <li data-target="#carouselExampleIndicators" data-slide-to="2"></li> -->
  </ol>
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img class="d-block w-100" src="images/Artboard-01.png" alt="First slide">
    </div>
    <div class="carousel-item">
      <img class="d-block w-100" src="images/Artboard-02.png" alt="Second slide">
    </div>
   <!--  <div class="carousel-item">
      <img class="d-block w-100" src="images/photo3.jpg" alt="Third slide">
    </div> -->
  </div>
  <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>
</section>
	

  <!-- OUT TEAM -->

<section class="ourteam" id="ourteamid">
<div class="container-fluid">
	<h1 class="text-center pt-5">Our Team</h1>
	<hr class="w-25 mx-auto pt-5">

	<div class="row text-center pb-5">
  		<div class="col-lg-3 col-md-6 col-sm-12">
  			<div class="card">
  				<img class="card-img-top" src="images/usr.png" class="img-fluid" alt="Card image">
 				  <div class="card-body">
    				<h4 class="card-title">Abhishek Maru</h4>
            <a href="#"><i class="fa fa-instagram"> abhi_maru1111</span></i></a>
  			  </div>
			  </div> 
  		</div>

  		<div class="col-lg-3 col-md-6 col-sm-12">
  			<div class="card">
  				<img class="card-img-top" src="images/usr.png" class="img-fluid" alt="Card image">
 				  <div class="card-body">
    				<h4 class="card-title">Jay Chauhan</h4> 
            <a href="#"><i class="fa fa-instagram"> _chauhan.jay_</i></a>  				
  				</div>
			  </div>
  		</div>

  		<div class="col-lg-3 col-md-6 col-sm-12">
  			<div class="card">
  				<img class="card-img-top" src="images/usr.png" class="img-fluid" alt="Card image">
 				  <div class="card-body">
    				<h4 class="card-title">Dhiren Shiyani</h4>
            <a href="#"><i class="fa fa-instagram"> dhiren_shiyani</i></a>
  				</div>
			  </div>
  		</div>

  		<div class="col-lg-3 col-md-6 col-sm-12">
  			<div class="card">
  				<img class="card-img-top" src="images/usr.png" class="img-fluid" alt="Card image">
 				  <div class="card-body">
    				<h4 class="card-title">Tanjeel Gadhkai</h4>
            <a href="#"><i class="fa fa-instagram"> tanjeel_gadhkai</i></a>
  				</div>
			  </div>
  		</div>
  	</div>
</div>
</section>

<!-- CONTACT US FORM -->

<section class="contact-us" id="contactusid">
  
  <div class="container-fluid">

    <h1 class="text-center pt-5">Contact Us</h1>
    <hr class="w-25 mx-auto pt-5">

    <div class="container-fluid">
     <form action="" method="post" class="contact border">
        <div class="form-group">
          <label for="username">Your Name:</label>
          <input type="text" class="form-control w-100" placeholder="Enter name" name="username" id="username" required>
        </div>

        <div class="form-group">
          <label for="email">Email:</label>
          <input type="email" class="form-control w-100" placeholder="Enter your email" name="email" id="email" required>
        </div>

        <div class="form-group">
          <label for="pwd">Your Text:</label>
          <textarea class="form-control" placeholder="Enter your text" name="text" required></textarea>
        </div>

        <button type="submit" name="submit" class="btn btn-primary">Submit</button><br><br>

        <p class="text-center text-uppercase" style="color:green;">
        <?php
              include 'connection.php';
              if(isset($_POST['submit'])){
                $username = $_POST['username'];
                $email = $_POST['email'];
                $text = $_POST['text'];

                $to = "connectus1111@gmail.com";

                if(mail($to, $username, $text , $email)){
                  echo "*Your Response has been submitted thank you*";
                }
                else{
                  echo "Your Response not submitted due to some error please try again!";
                }
              }

          ?>
        </p>
      </form>
    </div>
  </div>

</section>


<!-- Footer -->

<footer>
<div class="footer-top">
   <div class="container-fluid">
      <div class="row">
          <div class="col-md-6 col-sm-6 col-xs-12 md-mb-30 sm-mb-30 segment-one">
            <h3 class="h3">CONNECT US</h3>
            <p class="p">Your Concern, Our Responsibility</p>
          </div>

          <div class="col-md-6 col-sm-6 col-xs-12 md-mb-30 sm-mb-30 segment-two">
            <h2 class="h2">Follow us</h2>
              <a href="#"><i class="fa fa-facebook"></i></a>
              <a href="#"><i class="fa fa-twitter"></i></a>
              <a href="#"><i class="fa fa-instagram"></i></a>
              <a href="#"><i class="fa fa-snapchat"></i></a>
          </div>
      </div>
    </div>
</div>

<p class="footer-bottom-text">Copyright @2020 All Right reserved by ConnectUs</p>
</footer>
    
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>