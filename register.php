<?php
//a
require 'database.php';
header("Content-Type: application/json");
    $username = $_POST['username'];
	$password = $_POST['password'];
	if( !preg_match('/^[\w_\-]+$/', $username) ){
        echo json_encode(array(
		"success" => false,
		"message" => "Incorrect Username or Password"
	));
	exit;
	}
	if( !preg_match('/^[\w_\-]+$/', $password) ){
        echo json_encode(array(
		"success" => false,
		"message" => "Incorrect Username or Password"
	));
	exit;
	}
	$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
	//gets username to match against
	$stmt = $mysqli->prepare("select username from users");
    if(!$stmt){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }
     
    $stmt->execute();
    $stmt->bind_result($founduser);
    while($stmt->fetch()){
		//check to see if username is unique
        if(strcmp($founduser,$username)==0) {
            echo json_encode(array(
		"success" => false,
		"message" => "Username is already taken"
        ));
	exit;
        }
    }
    $stmt->close();
	//query that will insert the new user into the user table
	$stmt2 = $mysqli->prepare("insert into users (username, password) values (?, ?)"); 
	if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
	}
	$stmt2->bind_param('ss', $username, $password);
	$stmt2->execute();
      echo json_encode(array(
	"success" => true
	));
	$stmt2->close();
    ?>