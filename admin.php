<!DOCTYPE html>
<html lang="en">

<?php
	// Initialize the session
	session_start();
	
	// Check if the user is logged in, if not then redirect him to login page
	if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
		header("location: login.php");
		exit;
	}
?>

<?php
	require_once 'paginator.php'; 
	require 'modules.php'; 
	 
    $page       = ( isset( $_GET['page'] ) ) ? $_GET['page'] : 1; 
    $links      = ( isset( $_GET['links'] ) ) ? $_GET['links'] : 7;
	
	$conn = createConnection(); 
	$Paginator = new Paginator($conn); 
	
	$results = $Paginator->getPendingData('all', $page);
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
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/bootstrap-dialog.min.css" rel="stylesheet"> 
	<link href="css/data-tables.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/style.css" rel="stylesheet">
	
    <!-- All JavaScript files
    ================================================== -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
	<script src="js/bootstrap-dialog.min.js"></script>  
	<script src="js/data-tables.min.js"></script>
	
    <!-- Plugins for this template -->
    <script src="js/jquery-plugin-collection.js"></script>

    <!-- Custom script for this template -->
	<script src="js/script.js"></script>
	<script src="js/crud.js"></script>

</head>

<body onload="setActiveTab()">
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
				<div class="row" style="display:inline;">
					<div class="couple-logo" align="center">
						<h1><a href="#home">J <i class="fi flaticon-shape-1"></i> Q</a></h1>
					</div>
					<div align="right">
						<a href="logout.php" class="btn btn-danger">Sign Out of <?php echo $_SESSION["user"]; ?></a>
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
					<ul id="tabs" class="nav nav-tabs">
					  <li class="active" id="pending-tab" class="nav-item"><a data-toggle="tab" href="#pending">Pending</a></li>
					  <li id="approved-tab" class="nav-item"><a data-toggle="tab" href="#approved">Approved</a></li>
					  <li id="denied-tab" class="nav-item"><a data-toggle="tab" href="#denied">Denied</a></li>
					</ul>
				</div>
			</div>
		</div>

		<div class="tab-content">
			<br />
			<!-- PENDING TAB CONTENT --> 
			<div id="pending" class="tab-pane fade in active" aria-labelledby="pending-tab">
				<div class="container">
					<div class="row">
						<div class="col-md-12">
							<table style="width: 100%;" class="table table-striped table-condensed table-bordered table-rounded">
								<thead>
									<tr>
										<th hidden>Form Id</th>
										<th>First</th>
										<th>Last</th>
										<th>Phone</th>
										<th>Email</th>
										<th>Relationship</th>
										<th>Status</th>
										<th>Party Size</th>
										<th></th> <!-- Action Column --> 
									</tr>
								</thead>
								<tbody>
								<?php for($i = 0; $i < count($results->data); $i++) : ?>
									<tr>
										<td hidden><?php echo $results->data[$i]['FormId']; ?></td>
										<td><?php echo $results->data[$i]['FirstName']; ?></td>
										<td><?php echo $results->data[$i]['LastName']; ?></td>
										<td><?php echo $results->data[$i]['PhoneNumber']; ?></td>
										<td><?php echo $results->data[$i]['Email']; ?></td>
										<td><?php echo $results->data[$i]['Relationship']; ?></td>
										<td><?php echo $results->data[$i]['AttendingStatus']; ?></td>
										<td><?php echo $results->data[$i]['PartySize']; ?></td>
										<td>
											<a onclick="viewGuests(<?= $results->data[$i]['FormId'] ?>)" class="btn btn-info btn-uniform"><i class="fa fa-search-plus"></i> View</a> <!-- Read -->
											<a onclick="viewAttendeeMessage('<?=$results->data[$i]['FirstName']?>','<?= $results->data[$i]['Message']?>')" class="btn btn-primary btn-uniform" style="padding: 6px 12px;"><i class="fa fa-comment"></i> Message</a> <!-- Message --> 
											<a onclick="approveForm(<?=$results->data[$i]['FormId']?>,'<?=$results->data[$i]['FirstName']?>','<?=$results->data[$i]['Email']?>');" class="btn btn-success btn-uniform"><i class="fa fa-check"></i> Approve</a> <!-- Approve --> 
											<a onclick="denyForm(<?=$results->data[$i]['FormId']?>, '<?=$results->data[$i]['FirstName']?>','<?=$results->data[$i]['Email']?>');" class="btn btn-danger btn-uniform"><i class="fa fa-times"></i> Deny</a> <!-- Disaprove -->
										</td>
									</tr>
								<?php endfor; ?>	
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
			<!-- APPROVED TAB CONTENT --> 
			<div id="approved" class="tab-pane fade" aria-labelledby="approved-tab">
				<?php $results = $Paginator->getApprovedData('all', $page); ?>
				<div class="container">
					<div class="row">
						<div class="col-md-12">
							<table style="width: 100%;" class="table table-striped table-condensed table-bordered table-rounded">
								<thead>
									<tr>
										<th hidden>Form Id</th>
										<th>First</th>
										<th>Last</th>
										<th>Phone</th>
										<th>Email</th>
										<th>Relationship</th>
										<th>Status</th>
										<th>Party Size</th>
										<th></th> <!-- Action Column --> 
									</tr>
								</thead>
								<tbody>
								<?php for($i = 0; $i < count($results->data); $i++) : ?>
									<tr>
										<td hidden><?php echo $results->data[$i]['FormId']; ?></td>
										<td><?php echo $results->data[$i]['FirstName']; ?></td>
										<td><?php echo $results->data[$i]['LastName']; ?></td>
										<td><?php echo $results->data[$i]['PhoneNumber']; ?></td>
										<td><?php echo $results->data[$i]['Email']; ?></td>
										<td><?php echo $results->data[$i]['Relationship']; ?></td>
										<td><?php echo $results->data[$i]['AttendingStatus']; ?></td>
										<td><?php echo $results->data[$i]['PartySize']; ?></td>
										<td>
											<a onclick="viewGuests(<?= $results->data[$i]['FormId']?>)" class="btn btn-info btn-uniform"><i class="fa fa-search-plus"></i> View</a> <!-- Read -->
											<a onclick="viewAttendeeMessage('<?=$results->data[$i]['FirstName']?>','<?= $results->data[$i]['Message']?>')" class="btn btn-primary btn-uniform" style="padding: 6px 12px;"><i class="fa fa-comment"></i> Message</a> <!-- Message --> 
											<a onclick="denyForm(<?=$results->data[$i]['FormId']?>, '<?=$results->data[$i]['FirstName']?>','<?=$results->data[$i]['Email']?>');" class="btn btn-danger btn-uniform"><i class="fa fa-times"></i> Deny</a> <!-- Disaprove -->
										</td>
									</tr>
								<?php endfor; ?>									
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
			<!-- DENIED TAB CONTENT --> 
			<div id="denied" class="tab-pane fade" aria-labelledby="denied-tab">
				<?php $results = $Paginator->getDeniedData('all', $page); ?>
				<div class="container">
					<div class="row">
						<div class="col-md-12">
							<table style="width: 100%;" class="table table-striped table-condensed table-bordered table-rounded table-hover">
								<thead>
									<tr>
										<th hidden>Form Id</th>
										<th>First</th>
										<th>Last</th>
										<th>Phone</th>
										<th>Email</th>
										<th>Relationship</th>
										<th>Status</th>
										<th>Party Size</th>
										<th></th> <!-- Action Column --> 
									</tr>
								</thead>
								<tbody>
								<?php for($i = 0; $i < count($results->data); $i++) : ?>
									<tr>
										<td hidden><?php echo $results->data[$i]['FormId']; ?></td>
										<td><?php echo $results->data[$i]['FirstName']; ?></td>
										<td><?php echo $results->data[$i]['LastName']; ?></td>
										<td><?php echo $results->data[$i]['PhoneNumber']; ?></td>
										<td><?php echo $results->data[$i]['Email']; ?></td>
										<td><?php echo $results->data[$i]['Relationship']; ?></td>
										<td><?php echo $results->data[$i]['AttendingStatus']; ?></td>
										<td><?php echo $results->data[$i]['PartySize']; ?></td>
										<td>
											<a onclick="viewGuests(<?= $results->data[$i]['FormId'] ?>)" class="btn btn-info btn-uniform"><i class="fa fa-search-plus"></i> View</a> <!-- Read -->
											<a onclick="viewAttendeeMessage('<?=$results->data[$i]['FirstName']?>','<?= $results->data[$i]['Message']?>')" class="btn btn-primary btn-uniform" style="padding: 6px 12px;"><i class="fa fa-comment"></i> Message</a> <!-- Message --> 
											<a onclick="approveForm(<?=$results->data[$i]['FormId']?>,'<?=$results->data[$i]['FirstName']?>','<?=$results->data[$i]['Email']?>');" class="btn btn-success btn-uniform"><i class="fa fa-check"></i> Approve</a> <!-- Approve --> 
											<a onclick="return deleteForm(<?=$results->data[$i]['FormId'] ?>)" class="btn btn-danger btn-uniform"><i class="fa fa-trash"></i> Delete</a> <!-- Delete -->
										</td>
									</tr>
								<?php endfor; ?>
								</tbody>
							</table>			
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<script>
		$(document).ready(function(){
			$("table").DataTable(); 
		}); 

	</script>
</body>

</html>