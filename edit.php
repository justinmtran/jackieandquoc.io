<!DOCTYPE html>
<html lang="en">

<?php 
	require "config.php"; 
	require "modules.php";
	
	$formId = 0; 
	
	if(isset($_GET["id"])){
		$formId = $_GET["id"]; 
	}
?> 

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
	
    <!-- All JavaScript files
    ================================================== -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
	<script src="js/crud.js"></script>
	<script type="text/html" src="js/bootstrap-dialog.min.js"></script>
	
    <!-- Plugins for this template -->
    <script src="js/jquery-plugin-collection.js"></script>

    <!-- Custom script for this template -->
    <script src="js/script.js"></script>
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

        <!-- Start header -->
        <header id="header" class="site-header header-style-1">
			<div class="container">
				<div class="row">
					<div class="couple-logo" align="center">
						<h1><a href="#home">J <i class="fi flaticon-shape-1"></i> Q</a></h1>
					</div>
				</div>
				<!-- end of nav-collapse -->
			</div>
			<!-- end of container -->
        </header>
        <!-- end of header -->
		
		<form>
			<div class="form-group">
				<label>Form Status</label>
				<?php getFormStatusDropdown($formId) ?>
			</div>
			<div class="form-group"> 
			
			</div> 
		</form>
		
	</div>
</body>