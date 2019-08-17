
<?php
    require_once 'modules.php'; 

    // Initialize the session
    session_start(); 

    // Define variables and initialize with empty values
    $user = $pass = ""; 

    // Check if user is already logged in, if yes, then redirect user to admin page.
    if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
        header("location: admin.php"); 
        exit; 
    }

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(isset($_POST["user"]) && isset($_POST["pass"])){
            $user = trim($_POST["user"]);
            $pass = trim($_POST["pass"]); 
            validateCredentials($user, $pass); 
        }
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Meta Tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Page Title -->
    <title> J&Q Admin </title>

    <!-- Icon fonts -->
    <link href="css/font-awesome.min.css" rel="stylesheet">
	<link href="css/font-waltograph.css" rel="stylesheet">
    <link href="css/flaticon.css" rel="stylesheet">

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Plugins for this template -->
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/owl.carousel.css" rel="stylesheet">
    <link href="css/owl.theme.css" rel="stylesheet">
    <link href="css/slick.css" rel="stylesheet">
    <link href="css/slick-theme.css" rel="stylesheet">
    <link href="css/owl.transitions.css" rel="stylesheet">
    <link href="css/jquery.fancybox.css" rel="stylesheet">
    <link href="css/magnific-popup.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/style.css" rel="stylesheet">
</head>

<body id="home">
    <!-- start page-wrapper -->
    <div class="page-wrapper">

        <!-- start preloader -->
        <div class="preloader">
            <div class="inner">
                <span class="icon"><i class="fi flaticon-two"></i></span>
            </div>
        </div>
        <!-- end preloader -->

        <!-- start of hero -->
        <section class="hero" style="height: calc(100vh);">
            <div class="hero-slider hero-slider-s1">
                <div class="slide-item">
                    <img src="images/slider/login.jpg"  class="slider-bg">
                </div>
			</div>
			
            <div class="wedding-announcement">
                <div class="couple-name-merried-text">
                    <h2 class="wow slideInUp" data-wow-duration="1s">J & Q Administration</h2>
                    <div class="married-text wow fadeIn" data-wow-delay="1s">
                        <h4>
                            <span class="wow fadeInUp" data-wow-delay="1.05s">P</span>
                            <span class="wow fadeInUp" data-wow-delay="1.10s">l</span>
                            <span class="wow fadeInUp" data-wow-delay="1.15s">e</span>
                            <span class="wow fadeInUp" data-wow-delay="1.20s">a</span>
							<span class="wow fadeInUp" data-wow-delay="1.25s">s</span>
							<span class="wow fadeInUp" data-wow-delay="1.30s">e</span>
                            <span>&nbsp;</span>
                            <span class="wow fadeInUp" data-wow-delay="1.35s">L</span>
                            <span class="wow fadeInUp" data-wow-delay="1.40s">o</span>
                            <span class="wow fadeInUp" data-wow-delay="1.45s">g</span>
                            <span class="wow fadeInUp" data-wow-delay="1.50s">i</span>
                            <span class="wow fadeInUp" data-wow-delay="1.55s">n</span>
                        </h4>
					</div>
					
					<br /> <br />
					<form class="form" method="post" action="<?='login.php'?>">
						<div class="container form-group" align="center">
							<div class="row" style="width: 25%;">
                                <div class="col col-sm-12 wow fadeInUp" data-wow-delay="1.70s" style="margin-bottom: 10px;"> 
                                    <input type="text" name="user" class="form-control" placeholder="User Name*" value="">
                                </div> 
                                <div class="col col-sm-12 wow fadeInUp" data-wow-delay="1.70s" style="margin-bottom: 10px;">
                                    <input type="password" name="pass" class="form-control" placeholder="Password*" value="">
                                </div> 
                                <div class="col col-sm-12 wow fadeInUp" data-wow-delay="2.10s">
                                    <button type="submit" class="btn btn-primary">LOGIN</button>
                                </div>
                                <div hidden class="col col-md-12 success-error-message" style="width: 50%;">
                                    <div id="error"> Incorrect Login Credentials. </div>
                                </div>
							</div>
						</div>
					</form>
                </div>
			</div>
        </section>
        <!-- end of hero slider -->
    </div>
    <!-- end of page-wrapper -->
</body>

<footer>
    <!-- All JavaScript files
    ================================================== -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>

    <!-- Plugins for this template -->
    <script src="js/jquery-plugin-collection.js"></script>

    <!-- Custom script for this template -->
    <script src="js/script.js"></script>
</footer>

</html>