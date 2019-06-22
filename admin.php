<!DOCTYPE html>
<html lang="en">

<?php
	require_once 'paginator.php'; 
	require 'config.php'; 
	require 'modules.php'; 
	
	$limit      = ( isset( $_GET['limit'] ) ) ? $_GET['limit'] : array(10,10,10); // pending, approved, denied
    $page       = ( isset( $_GET['page'] ) ) ? $_GET['page'] : array(1,1,1);
    $links      = ( isset( $_GET['links'] ) ) ? $_GET['links'] : array(7,7,7);
	
	$conn = createConnection(); 
	$Paginator = new Paginator($conn); 
	
	$results = $Paginator->getPendingData($limit[0], $page[0]);
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

		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<ul class="nav nav-tabs">
					  <li class="active"><a data-toggle="tab" href="#pending">Pending</a></li>
					  <li><a data-toggle="tab" href="#approved">Approved</a></li>
					  <li><a data-toggle="tab" href="#denied">Denied</a></li>
					</ul>
				</div>
			</div>
		</div>

		<div class="tab-content">
			<br />
			<!-- PENDING TAB CONTENT --> 
			<div id="pending" class="tab-pane fade in active">
				<div class="container">
					<div class="row">
						<div class="col-md-12">
							<table class="table table-striped table-condensed table-bordered table-rounded">
								<thead>
									<tr>
										<th hidden>Form Id</th>
										<th>First</th>
										<th>Middle</th>
										<th>Last</th>
										<th>Phone</th>
										<th>Email</th>
										<th>Relationship</th>
										<th>No. of Guests</th>
										<th>Status</th>
										<th></th> <!-- Action Column --> 
									</tr>
								</thead>
								<tbody>
								<?php for($i = 0; $i < count($results->data); $i++) : ?>
									<tr>
										<td hidden><?php echo $results->data[$i]['FormId']; ?></td>
										<td><?php echo $results->data[$i]['FirstName']; ?></td>
										<td><?php echo $results->data[$i]['MiddleName']; ?></td>
										<td><?php echo $results->data[$i]['LastName']; ?></td>
										<td><?php echo $results->data[$i]['PhoneNumber']; ?></td>
										<td><?php echo $results->data[$i]['Email']; ?></td>
										<td><?php echo $results->data[$i]['RelationshipType']; ?></td>
										<td><?php echo $results->data[$i]['NumOfGuests']; ?></td>
										<td><?php echo $results->data[$i]['AttendingStatus']; ?></td>
										<td>
											<a href="" class="btn btn-info"><i class="fa fa-search-plus"></i> View</a> <!-- Read -->
											<a href="" class="btn btn-primary"><i class="fa fa-edit"></i> Edit</a> <!-- Edit --> 
											<a href="approve.php?id=<?php echo $results->data[$i]['FormId']; ?>" class="btn btn-success"><i class="fa fa-check"></i> Approve</a> <!-- Approve --> 
											<a href="" class="btn btn-danger"><i class="fa fa-times"></i> Deny</a> <!-- Disaprove -->
										</td>
									</tr>
								</tbody>
								<?php endfor; ?>
							</table>
							<?php echo $Paginator->createLinks($links[0], 'pagination pagination-sm'); ?>
						</div>
					</div>
				</div>
			</div>
			<!-- APPROVED TAB CONTENT --> 
			<div id="approved" class="tab-pane fade">
				<?php $results = $Paginator->getApprovedData($limit[1], $page[1]); ?>
				<div class="container">
					<div class="row">
						<div class="col-md-12">
							<table class="table table-striped table-condensed table-bordered table-rounded">
								<thead>
									<tr>
										<th hidden>Form Id</th>
										<th>First</th>
										<th>Middle</th>
										<th>Last</th>
										<th>Phone</th>
										<th>Email</th>
										<th>Relationship</th>
										<th>No. of Guests</th>
										<th>Status</th>
										<th></th> <!-- Action Column --> 
									</tr>
								</thead>
								<tbody>
								<?php for($i = 0; $i < count($results->data); $i++) : ?>
									<tr>
										<td hidden><?php echo $results->data[$i]['FormId']; ?></td>
										<td><?php echo $results->data[$i]['FirstName']; ?></td>
										<td><?php echo $results->data[$i]['MiddleName']; ?></td>
										<td><?php echo $results->data[$i]['LastName']; ?></td>
										<td><?php echo $results->data[$i]['PhoneNumber']; ?></td>
										<td><?php echo $results->data[$i]['Email']; ?></td>
										<td><?php echo $results->data[$i]['RelationshipType']; ?></td>
										<td><?php echo $results->data[$i]['NumOfGuests']; ?></td>
										<td><?php echo $results->data[$i]['AttendingStatus']; ?></td>
										<td>
											<a href="" class="btn btn-info"><i class="fa fa-search-plus"></i> View</a> <!-- Read -->
											<a href="" class="btn btn-primary"><i class="fa fa-edit"></i> Edit</a> <!-- Edit --> 
											<a href="" class="btn btn-danger"><i class="fa fa-times"></i> Deny</a> <!-- Disaprove -->
										</td>
									</tr>
								</tbody>
								<?php endfor; ?>
							</table>
							<?php echo $Paginator->createLinks($links[1], 'pagination pagination-sm'); ?>
						</div>
					</div>
				</div>
			</div>
			<!-- DENIED TAB CONTENT --> 
			<div id="denied" class="tab-pane fade">
				<div class="container">
					<div class="row">
						<div class="col-md-12">
							<p>Coming Soon.</p>					
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

		
		
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