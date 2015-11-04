<?php
	session_start();
	require_once('db.php');
	
	// Handle incorrect requests
	if (!isset($_POST['raptor-content'])) {
	    header('HTTP/1.0 400 Bad Request');
	    exit;
	}
	if ($_SESSION['v2Admin'] != 1) {
	    header('HTTP/1.0 400 Bad Request');
	    exit;
	}
	
	$mysqli = DB::getMysqli();

	$raptorContent = json_decode($_POST['raptor-content']);
	$id 	 = $mysqli->real_escape_string($raptorContent->{'id'});
	$lan 	 = $mysqli->real_escape_string($raptorContent->{'lan'});
	$content = $mysqli->real_escape_string($raptorContent->{'content'});
	$token 	 = $mysqli->real_escape_string($raptorContent->{'token'});
	
	if ($_SESSION['token'] != $token) {
	    header('HTTP/1.0 400 Bad Request');
	    exit;
	}

	$mysqli->query("update sites set $lan='$content' where id=$id");

	
	header('HTTP/1.0 200');
	 
	// Report success
	echo json_encode(array(
	    'status' => 'ok'
	));

?>