<?php
	require_once 'Facebook/autoload.php';

	session_start();
	$fb = new Facebook\Facebook([
	  'app_id' => '909515306050412', 
	  'app_secret' => '4d5fa8ed513b69eddb1144e115cb1322',
	  'default_graph_version' => 'v3.2',
	  ]);

	$helper = $fb->getRedirectLoginHelper();
	
	if (isset($_GET['state'])) { $helper->getPersistentDataHandler()->set('state', $_GET['state']); }

	try {
	  $accessToken = $helper->getAccessToken();
	} catch(Facebook\Exceptions\FacebookResponseException $e) {
		// When Graph returns an error
		die('Graph returned an error: ' . $e->getMessage());
	} catch(Facebook\Exceptions\FacebookSDKException $e) {
		// When validation fails or other local issues
		die('Facebook SDK returned an error: ' . $e->getMessage());
	}

	if (! isset($accessToken)) {
	  if ($helper->getError()) {
		header('HTTP/1.0 401 Unauthorized');
		echo "Error: " . $helper->getError() . "\n";
		echo "Error Code: " . $helper->getErrorCode() . "\n";
		echo "Error Reason: " . $helper->getErrorReason() . "\n";
		echo "Error Description: " . $helper->getErrorDescription() . "\n";
	  } else {
		header('HTTP/1.0 400 Bad Request');
		echo 'Bad request';
	  }
	  exit;
	}

	// The OAuth 2.0 client handler helps us manage access tokens
	$oAuth2Client = $fb->getOAuth2Client();

	// Get the access token metadata from /debug_token
	$tokenMetadata = $oAuth2Client->debugToken($accessToken);

	// Validation (these will throw FacebookSDKException's when they fail)
	$tokenMetadata->validateAppId('909515306050412'); // Replace {app-id} with your app id
	// If you know the user ID this access token belongs to, you can validate it here
	//$tokenMetadata->validateUserId('123');
	$tokenMetadata->validateExpiration();

	if (! $accessToken->isLongLived()) {
	  // Exchanges a short-lived access token for a long-lived one
	  try {
		$accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
	  } catch (Facebook\Exceptions\FacebookSDKException $e) {
		die("Error getting long-lived access token: " . $e->getMessage());
	  }
	}

	$_SESSION['fb_access_token'] = (string) $accessToken;

	// User is logged in with a long-lived access token.
	// You can redirect them to a members-only page.
	// header('Location: https://jandqsayido.com/admin');
?>

<!DOCTYPE html>
<html lang="en">

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
                            <li><a href="index.html#home">Home</a></li>
                            <li><a href="index.html#couple">Pending</a></li>
                            <li><a href="index.html#story">Approved</a></li>
                            <li><a href="index.html#events">Denied</a></li>
                            <li><a href="index.html#people">Signout</a></li>
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
                <div class="row">
                    <div class="blog-content col col-md-8">
                        <div class="post">
                            <div class="entry-header">
                                <div class="entry-date-media">
                                    <div class="entry-date">25 <span>july</span></div>
                                    <div class="entry-media">
                                        <img src="images/blog/img-1.jpg" class="img img-responsive" alt>
                                    </div>
                                </div>

                                <div class="entry-formet">
                                    <div class="entry-meta">
                                        <div class="cat">
                                            <i class="fa fa-tags"></i> <a href="#">Uncategorize</a>, <a href="#">Photography</a>
                                        </div>
                                        <div class="cat">
                                            <i class="fa fa-comments"></i> <a href="#">Comments: 5</a>
                                        </div>
                                    </div>
                                </div>

                                <div class="entry-title">
                                    <h3><a href="#">Wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper quis nostrud exerci tation ullamcorper</a></h3>
                                </div>
                            </div>
                            <!-- end of entry-header -->

                            <div class="entry-content">
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                                    consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse</p>
                                <a href="#" class="read-more">Read more</a>
                            </div>
                            <!-- end of entry-content -->
                        </div>
                        <!-- end of post -->

                        <div class="post">
                            <div class="entry-header">
                                <div class="entry-date-media">
                                    <div class="entry-date">03 <span>Aug</span></div>
                                    <div class="entry-media media-carousel">
                                        <div class="item">
                                            <img src="images/blog/img-2.jpg" class="img img-responsive" alt>
                                        </div>
                                        <div class="item">
                                            <img src="images/blog/img-3.jpg" class="img img-responsive" alt>
                                        </div>
                                    </div>
                                </div>

                                <div class="entry-formet">
                                    <div class="entry-meta">
                                        <div class="cat">
                                            <i class="fa fa-tags"></i> <a href="#">Uncategorize</a>, <a href="#">Photography</a>
                                        </div>
                                        <div class="cat">
                                            <i class="fa fa-comments"></i> <a href="#">Comments: 5</a>
                                        </div>
                                    </div>
                                </div>

                                <div class="entry-title">
                                    <h3><a href="#">Wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper quis nostrud exerci tation ullamcorper</a></h3>
                                </div>
                            </div>
                            <!-- end of entry-header -->

                            <div class="entry-content">
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Vitae enim, quo excepturi tempora ea deleniti nihil odio, reiciendis similique totam, dolore deserunt amet.</p>
                                <a href="#" class="read-more">Read more</a>
                            </div>
                            <!-- end of entry-content -->
                        </div>
                        <!-- end of post -->

                        <div class="page-pagination">
                            <ul class="pagination">
                                <li>
                                    <a href="#" aria-label="Previous">
                                        <span class="fa fa-arrow-left"></span>
                                    </a>
                                </li>
                                <li><a href="#">1</a></li>
                                <li class="current"><a href="#">2</a></li>
                                <li><a href="#">4</a></li>
                                <li>
                                    <a href="#" aria-label="Next">
                                        <span class="fa fa-arrow-right"></span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- end of blog-content -->

                    <div class="blog-sidebar col col-md-4">
                        <div class="widget search-widget">
                            <h3>Search</h3>
                            <form>
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Search your keyword">
                                </div>
                                <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                            </form>
                        </div>

                        <div class="widget categories-widget">
                            <h3>Categories</h3>
                            <ul>
                                <li><a href="#">Our story</a></li>
                                <li><a href="#">Wedding ceremony</a></li>
                                <li><a href="#">Wedding events</a></li>
                                <li><a href="#">Gift</a></li>
                                <li><a href="#">Party</a></li>
                                <li><a href="#">Receiption ceremony</a></li>
                            </ul>
                        </div>

                        <div class="widget popular-posts-widget">
                            <h3>Popular postes</h3>
                            <ul>
                                <li>
                                    <div>
                                        <span class="date">01 Aug 2016</span>
                                        <h6><a href="#">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</a></h6>
                                    </div>
                                </li>
                                <li>
                                    <div>
                                        <span class="date">01 Aug 2016</span>
                                        <h6><a href="#">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</a></h6>
                                    </div>
                                </li>
                                <li>
                                    <div>
                                        <span class="date">01 Aug 2016</span>
                                        <h6><a href="#">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</a></h6>
                                    </div>
                                </li>
                            </ul>
                        </div>

                        <div class="widget populer-tags-widget">
                            <h3>Popular tags</h3>
                            <ul>
                                <li><a href="#">Wedding ceremony</a></li>
                                <li><a href="#">Love</a></li>
                                <li><a href="#">Story</a></li>
                                <li><a href="#">Events</a></li>
                                <li><a href="#">Love</a></li>
                                <li><a href="#">First Metting</a></li>
                                <li><a href="#">Couple</a></li>
                                <li><a href="#">Gift</a></li>
                            </ul>
                        </div>
                    </div>
                    <!-- end of sidebar -->
                </div>
                <!-- end of row -->
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