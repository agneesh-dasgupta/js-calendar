<?php
require 'database.php';
session_start();
header("Content-Type: application/json");
$username = $_SESSION['username'];
$currentMonth = $_POST['currentMonth'];

if( !preg_match('/^[\w_\-]+$/', $username) ){
        echo json_encode(array(
		"success" => false,
		"message" => "Incorrect Username or Password"
	));
	exit;
}

if( !preg_match('/^[\w_\-]+$/', $currentMonth) ){
        echo json_encode(array(
		"success" => false,
		"message" => "Incorrect Username or Password"
	));
	exit;
}

$stmt = $mysqli->prepare("select eventid, eventTitle, eventMonth, eventDay from events where username=? and eventMonth=?");
    if(!$stmt){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }
    $stmt->bind_param('sd', $username, $currentMonth);
    $stmt->execute();
    $result = $stmt->get_result();
    $eventArray = array();
    $index = 0;
    while($row=$result->fetch_assoc()){
        $event = array(
            "eventid" => $row['eventid'],
            "eventMonth" => $row['eventMonth'],
            "eventTitle" => $row['eventTitle'],
            "eventDay" => $row['eventDay'],
            "currentUser" => $username
        );
        $eventArray[$index] = $event;
        $index++;
    }
    $stmt->close();
    echo json_encode($eventArray);
	exit;
	
?>