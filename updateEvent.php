<?php
    require 'database.php';
    ini_set("session.cookie_httponly", 1);
    session_start();
    header("Content-Type: application/json");
    $newTitle = $_POST['eventtitle'];
    $newDescription = $_POST['eventdescription'];
    $newYear = $_POST['eventyear'];
    $newMonth = $_POST['eventmonth'];
    $newDay = $_POST['eventday'];
    $newTime = $_POST['eventtime'];
    $username = $_SESSION['username'];
    $eventid = $_POST['eventid'];
    $stmt = $mysqli->prepare("update events set eventTitle=?, eventYear=?, eventMonth=?, eventDay=?, eventDescription=?, eventTime=? where username=? and eventid=?");
    if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	echo json_encode(array(
		"success" => false,
		"message" => "Event not updated"
	));
	exit;
}
$stmt->bind_param('siiisssi', $newTitle, $newYear, $newMonth,$newDay, $newDescription, $newTime, $username, $eventid);
$stmt->execute();
$stmt->close();
echo json_encode(array(
	"success" => true
	));
	exit;
?>