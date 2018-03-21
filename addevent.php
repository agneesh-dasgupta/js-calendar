
<?php
//Adds a new event to the events database
require 'database.php';
ini_set("session.cookie_httponly", 1);
session_start();
header("Content-Type: application/json");
$username = $_SESSION['username'];
$eventtitle = $_POST['eventtitle'];
$eventdescription = null; 
if(isset($_POST['eventdescription'])){
    $eventdescription = $_POST['eventdescription'];
}
$eventyear = (int) $_POST['eventyear'];
$eventmonth = (int) $_POST['eventmonth'];
$eventday = (int) $_POST['eventday'];
$eventtime = $_POST['eventtime'];
$eventtag = $_POST['eventtag'];

if( !preg_match('/^[\w_\-]+$/', $username) ){
        echo json_encode(array(
		"success" => false,
		"message" => "Incorrect Username or Password"
	));
	exit;
}


$stmt = $mysqli->prepare("insert into events (username, eventTitle, eventYear, eventMonth, eventDay, eventDescription, eventtime, tag) values (?, ?, ?, ?, ?, ?, ?, ?)");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	echo json_encode(array(
		"success" => false,
		"message" => "Event not added"
	));
	exit;
}

$stmt->bind_param('ssiiisss', $username, $eventtitle, $eventyear,$eventmonth, $eventday, $eventdescription, $eventtime, $eventtag);
$stmt->execute();
$stmt->close();
echo json_encode(array(
	"success" => true
	));
	exit;
?>