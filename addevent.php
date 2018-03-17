<?php
require 'database.php';
session_start();
header("Content-Type: application/json");
$username = $_SESSION['username'];
$eventtitle = $_POST['eventtitle'];
$eventdescription = null;
if(isset($_POST['eventdescription'])){
    $eventdescription = $_POST['eventdescription'];
}
$eventyear = $_POST['eventyear'];
$eventmonth = $_POST['eventmonth'];
$eventday = $_POST['eventday'];
$stmt = $mysqli->prepare("insert into events (username, eventTitle, eventYear, eventMonth, eventDay, eventDescription) values (?, ?, ?, ?, ?, ?)");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	echo json_encode(array(
		"success" => false,
		"message" => "Event not added"
	));
	exit;
}

$stmt->bind_param('ssiiis', $username, $eventtitle, $eventyear,$eventmonth, $eventday, $eventdescription);
$stmt->execute();
$stmt->close();
echo json_encode(array(
	"success" => true
	));
	exit;
?>