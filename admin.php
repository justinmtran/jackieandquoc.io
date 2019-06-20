<!DOCTYPE html>
<html lang="en">

<?php
	require_once 'paginator.php'; 
	require 'config.php'; 
	require 'modules.php'; 
	
	$limit      = ( isset( $_GET['limit'] ) ) ? $_GET['limit'] : 25;
    $page       = ( isset( $_GET['page'] ) ) ? $_GET['page'] : 1;
    $links      = ( isset( $_GET['links'] ) ) ? $_GET['links'] : 7;
	
	$conn = createConnection(); 
	$Paginator = new Paginator($conn); 
	$results = $Paginator->getPendingData($page, $limit); 
	
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

        <div class="page-title" style="background-image: url('images/slider/admin.jpg'); background-size: cover;">
            <div class="container" >
                <div class="row">
                    <div class="col col-xs-12">
                        <h2>Admin Control Panel</h2>
                    </div>
                </div>
            </div>
            <!-- end container -->
        </div>
        <!-- end page-title -->

        <!-- Start header -->
        <header id="header" class="site-header header-style-1">
            <nav class="navigation navbar navbar-default">
                <div class="container">
                    <div class="navbar-header">
                        <button type="button" class="open-btn">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <div class="couple-logo">
                            <h1><a href="#home">J <i class="fi flaticon-shape-1"></i> Q</a></h1>
                        </div>
                    </div>
                    <div id="navbar" class="navbar-collapse collapse navbar-right navigation-holder">
                        <button class="close-navbar"><i class="fa fa-close"></i></button>
                        <ul class="nav navbar-nav">
                            <li><a href="https://jandqsayido.com">Home</a></li>
                            <li><a>Pending</a></li>
                            <li><a>Approved</a></li>
                            <li><a>Denied</a></li>
                            <li><a>Signout</a></li>
                        </ul>
                    </div>
                    <!-- end of nav-collapse -->
                </div>
                <!-- end of container -->
            </nav>
        </header>
        <!-- end of header -->


        <!-- start blog-main -->
        <section class="blog-main section-padding">
            <div class="container">
                <div class="col-md-10 col-md-offset-1">
					<h1>Pending</h1>
					<table class="table table-striped table-condensed table-bordered table-rounded">
						<thead>
							<tr>
								<th hidden>FormId</th>
								<th>First</th>
								<th>Middle</th>
								<th>Last</th>
								<th>Phone</th>
								<th>Email</th>
								<th>Relationship</th>
								<th>No. of Guests</th>
								<th>Status</th>
							</tr>
						</thead>
						<tbody>
						<?php for($i = 0; $i < count($results->data); $i++) : ?>
							<tr>
								<td hidden><?php echo $results->data[$i]['FormId']</td>
								<td><?php echo $results->data[$i]['FirstName']; ?></td>
								<td><?php echo $results->data[$i]['MiddleName']; ?></td>
								<td><?php echo $results->data[$i]['LastName']; ?></td>
								<td><?php echo $results->data[$i]['PhoneNumber']; ?></td>
								<td><?php echo $results->data[$i]['Email']; ?></td>
								<td><?php echo $results->data[$i]['RelationshipType']; ?></td>
								<td><?php echo $results->data[$i]['NumOfGuests']; ?></td>
								<td><?php echo $results->data[$i]['AttendingStatus']; ?></td>
							</tr>
						</tbody>
						<?php endfor; ?>
					</table>
					<?php echo $Paginator->createLinks($links, 'pagination pagination-sm'); ?>
				</div>
            </div>
            <!-- end of container -->
        </section>
        <!-- end of blog-main -->
		

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