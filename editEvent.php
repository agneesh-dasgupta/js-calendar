<?php
    //Returns all the details on an event to be used in the view/edit dialog box
    require 'database.php';
    ini_set("session.cookie_httponly", 1);
    session_start();
    header("Content-Type: application/json");
    $eventid = $_POST['eventid'];
    $username = $_SESSION['username'];
    $stmt = $mysqli->prepare("SELECT eventTitle, eventYear, eventMonth, eventDay, eventDescription, eventTime FROM events WHERE username=? and eventid=?");
// Bind the parameter
$stmt->bind_param('si', $username,$eventid);
$stmt->execute();
$result = $stmt->get_result();
$event = array();
  while($row=$result->fetch_assoc()){
        $event = array(
            "success" => "true",
            "eventTitle" => $row['eventTitle'],
            "eventYear" => $row['eventYear'],
            "eventMonth" => $row['eventMonth'],
            "eventDay" => $row['eventDay'],
            "eventDescription" => $row['eventDescription'],
            "eventTime" => $row['eventTime']
        );
    }
    $stmt->close();
    echo json_encode($event);
	exit;
?>