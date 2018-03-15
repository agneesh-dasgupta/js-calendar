<?php
// Content of database.php
$mysqli = new mysqli('localhost', 'calendarman', 'calendar', 'calendar');
if($mysqli->connect_errno) {
	printf("Connection Failed: %s\n", $mysqli->connect_error);
	exit;
}
?>