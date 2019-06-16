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

	echo '<a href="' . htmlspecialchars($loginUrl) . '">Log in with Facebook!</a>';
?>