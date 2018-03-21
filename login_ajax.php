<?php
require 'database.php';
header("Content-Type: application/json"); // Since we are sending a JSON response here (not an HTML document), set the MIME Type to application/json
$username = $_POST['username'];

if( !preg_match('/^[\w_\-]+$/', $username) ){
        echo json_encode(array(
		"success" => false,
		"message" => "Incorrect Username or Password"
	));
	exit;
}

$stmt = $mysqli->prepare("SELECT COUNT(*), username, password FROM users WHERE username=?");
// Bind the parameter
$stmt->bind_param('s', $username);
$stmt->execute();
$stmt->bind_result($cnt, $user_id, $pwd_hash);
$stmt->fetch();
$password_guess = $_POST['password'];
if($cnt == 1 && password_verify($password_guess, $pwd_hash)){
	// Login succeeded!
	ini_set("session.cookie_httponly", 1);
	session_start();
	$_SESSION['username'] = $user_id;
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