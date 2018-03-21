<?php
//Deletes an event from the database by event ID and username
require 'database.php';
ini_set("session.cookie_httponly", 1);
session_start();
header("Content-Type: application/json");
$username = $_SESSION['username'];
$eventid = $_POST['eventid'];
$token = $_POST['token'];
  if(!hash_equals($_SESSION['token'], $token)){
	die("Request forgery detected");
}
if( !preg_match('/^[\w_\-]+$/', $username) ){
        echo json_encode(array(
		"success" => false,
		"message" => "Incorrect Username or Password"
	));
	exit;
}

$stmt = $mysqli->prepare("delete from events where eventid=? and username=?");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	echo json_encode(array(
		"success" => false,
		"message" => "Event not deleted"
	));
	exit;
}
    
$stmt->bind_param('is', $eventid, $username);

$stmt->execute();
    
$stmt->close();

echo json_encode(array(
	"success" => true
	));
	exit;

?>