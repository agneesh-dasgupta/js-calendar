<?php
//Returns all events for a user using a JSON array
require 'database.php';
ini_set("session.cookie_httponly", 1);
session_start();
header("Content-Type: application/json");
$username = $_SESSION['username'];
$currentMonth = $_POST['currentMonth'];

$stmt = $mysqli->prepare("select eventid, eventTitle, eventMonth, eventDay, tag from events where username=? and eventMonth=?");
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
            "eventid" => htmlentities($row['eventid']),
            "eventMonth" => htmlentities($row['eventMonth']),
            "eventTitle" => htmlentities($row['eventTitle']),
            "eventDay" => htmlentities($row['eventDay']),
            "tag" => htmlentities($row['tag']),
            "currentUser" => htmlentities($username)
        );
        $eventArray[$index] = $event;
        $index++;
    }
    $stmt->close();
    echo json_encode($eventArray);
	exit;
	
?>