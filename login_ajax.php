<?php
require 'database.php';
header("Content-Type: application/json"); // Since we are sending a JSON response here (not an HTML document), set the MIME Type to application/json
$username = $_POST['username'];
$password = $_POST['password'];
$stmt = $mysqli->prepare("SELECT COUNT(*), username, password FROM users WHERE username=?");
// Bind the parameter
$stmt->bind_param('s', $user);
$user = $_POST['username'];
//$isGuest = (string) $_POST['isGuest'];
//$_SESSION['isGuest'] = $isGuest;
$stmt->execute();

$stmt->bind_result($cnt, $user_id, $pwd_hash);
$stmt->fetch();
$pwd_guess = $_POST['password'];

if($cnt == 1 && password_verify($pwd_guess, $pwd_hash)){
	// Login succeeded!
	$_SESSION['username'] = $username;
	$_SESSION['token'] = substr(md5(rand()), 0, 10);
	echo json_encode(array(
		"success" => true
	));
	exit;
} else{
    echo json_encode(array(
		"success" => false,
		"message" => "Incorrect Username or Password"
	));
	exit;
}

?>