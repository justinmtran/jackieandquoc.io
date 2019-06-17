<!DOCTYPE html>
<html lang="en">

<head>

	<?php
		require_once 'Facebook/autoload.php';

		session_start();
		$fb = new Facebook\Facebook([
		  'app_id' => '909515306050412', 
		  'app_secret' => '4d5fa8ed513b69eddb1144e115cb1322',
		  'default_graph_version' => 'v3.2',
		  ]);

		$helper = $fb->getRedirectLoginHelper();
		
		$permissions = ['email']; // Optional permissions
		$loginUrl = $helper->getLoginUrl('https://jandqsayido.com/fb-callback.php', $permissions); 
	?>

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
	
	<!-- Facebook Login Button --> 
	<div id="fb-root"></div>
	<script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.3&appId=909515306050412&autoLogAppEvents=1"></script>
</head>

<body>
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
        <section class="hero">
            <div class="hero-slider hero-slider-s1">
                <div class="slide-item">
                    <img src="images/slider/login.jpg" alt class="slider-bg">
                </div>
            </div>
            <div class="wedding-announcement">
                <div class="couple-name-merried-text">
                    <h2 class="wow slideInUp" data-wow-duration="1s">Welcome to the Admin Control</h2>
                    <div class="married-text wow fadeIn" data-wow-delay="1s">
                        <h4 class="">
                            <span class=" wow fadeInUp" data-wow-delay="1.05s">P</span>
                            <span class=" wow fadeInUp" data-wow-delay="1.10s">l</span>
                            <span class=" wow fadeInUp" data-wow-delay="1.15s">e</span>
                            <span class=" wow fadeInUp" data-wow-delay="1.20s">a</span>
                            <span class=" wow fadeInUp" data-wow-delay="1.25s">s</span>
                            <span class=" wow fadeInUp" data-wow-delay="1.30s">e</span>
                            <span>&nbsp;</span>						
                            <span class=" wow fadeInUp" data-wow-delay="1.35s">S</span>
                            <span class=" wow fadeInUp" data-wow-delay="1.40s">i</span>
                            <span class=" wow fadeInUp" data-wow-delay="1.45s">g</span>
                            <span class=" wow fadeInUp" data-wow-delay="1.50s">n</span>
                            <span>&nbsp;</span>
                            <span class=" wow fadeInUp" data-wow-delay="1.55s">i</span>
                            <span class=" wow fadeInUp" data-wow-delay="1.65s">n</span>
                        </h4> <br /> <br />
						<?php
							echo "<a class='fa fa-facebook' href='" . htmlspecialchars($loginUrl) . "'> Log in with Facebook!</a></button>";
						?>
                    </div>
                </div>
            </div>
        </section>
        <!-- end of hero slider -->

        <!-- Start header -->
        <header id="header" class="site-header header-style-1">
			<div class="container" align="center">
				<h1><a href="https://www.jandqsayido.com">J <i class="fi flaticon-shape-1"></i> Q</a></h1>
				<!-- end of nav-collapse -->
			</div>
			<!-- end of container -->
        </header>
        <!-- end of header -->
    </div>
    <!-- end of page-wrapper -->

    <!-- All JavaScript files
    ================================================== -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>

    <!-- Plugins for this template -->
    <script src="js/jquery-plugin-collection.js"></script>

    <!-- Custom script for this template -->
    <script src="js/script.js"></script>
</body>

</html>