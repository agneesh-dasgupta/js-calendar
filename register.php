<?php
require database.php;
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
	//query that will insert the new user into the user table
	$stmt = $mysqli->prepare("insert into users (username, password) values (?, ?)"); 
	if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
	}
	$stmt->bind_param('ss', $username, $password);
	$stmt->execute();
      echo json_encode(array(
	"success" => true
	));
	$stmt->close();
	exit;
    ?>