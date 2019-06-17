<head>
    <!-- Meta Tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Page Title -->
    <title>J&Q Admin</title>

    <!-- Icon fonts -->
    <link href="css/font-awesome.min.css" rel="stylesheet">
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

<!-- start page-wrapper -->
<div class="page-wrapper">

	<!-- start preloader -->
	<div class="preloader">
		<div class="inner">
			<span class="icon"><i class="fi flaticon-two"></i></span>
		</div>
	</div>
	<!-- end preloader -->

	<div class="page-title" style="background-image: url('images/slider/striking_vipers.jpg'); background-size: cover;">
		<div class="container" >
			<div class="row">
				<div class="col col-xs-12">
					<h2>Please Sign in</h2>			
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

						echo "<div class='fb-login-button' data-width='' data-size='large' data-button-type='continue_with' data-auto-logout-link='false' data-use-continue-as='false'></div>"
					?>
				</div>
			</div>
		</div>
		<!-- end container -->
	</div>
	<!-- end page-title -->
</div>