<?php
require 'database.php';
session_start();
header("Content-Type: application/json");

$username = $_SESSION['username'];
$currentMonth = $_POST['currentMonth'];

$stmt = $mysqli->prepare("select eventTitle, eventMonth, eventDay from events where username=? and eventMonth=?");
    if(!$stmt){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }
    $stmt->bind_param('sd', $username, $currentMonth);
    $stmt->execute();
    $stmt->bind_result($eventTitle, $eventMonth, $eventDay);
    $index =0;
    $result = $stmt->get_result();
    $eventArray = array("success" => true);
    while($row=$result->fetch_assoc()){
       /* $event = array(
            "eventMonth" => $row['eventMonth'],
            "eventTitle" => $row['eventTitle'],
            "eventDay" => $row['eventDay']
        );
        $eventarray[$index] = $event;
        $index++;*/
    }
    $stmt->close();
    echo json_encode(array(
	"success" => true
	));
	exit;
	
?>