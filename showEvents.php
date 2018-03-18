<?php
require 'database.php';
session_start();
header("Content-Type: application/json");

$username = $_SESSION['username'];
$currentMonth = $_POST['currentMonth'];

$stmt = $mysqli->prepare("select eventTitle, eventMonth, eventDay from events where username=? and month=?");
    if(!$stmt){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }
     $stmt->bind_param('sd', $username, $currentMonth);
    $stmt->execute();
    $stmt->bind_result($eventTitle, $eventMonth, $eventDay);
    $index =0;
    $eventArray = array();
    while($stmt->fetch()){
		//check to see if username is unique
        $eventArray[$index] = array ($eventMonth + "-" + $eventDay, $eventTitle);
        $index++;
       
    }
    echo json_encode($eventArray);
	$stmt->close();
?>