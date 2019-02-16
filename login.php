<?php
require 'database.php';
session_start();
$user = $_POST["user"];
$_SESSION["user"] = $user;
$password = $_POST["password"];
$hashedPass = password_hash($password, PASSWORD_DEFAULT);
$taken = 0;
if($_POST["new"]){
	$stmt = $mysqli->prepare("select id, user, password from users");
	if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}
	$stmt->execute();
	$stmt->bind_result($id, $tableUser, $tablePass);
	while($stmt->fetch()){
		if($user === $tableUser){
			$taken = 1;
			break;        
		}

	}if
	$stmt->close;
	$stmt = $mysqli->prepare("insert into users (user, password) values ('$user', '$hashedPass')");
	if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}
	$stmt->execute();
	$stmt->close();
	//header("Location:homepage.php");

} else {
	$stmt = $mysqli->prepare("select id, user, password from users");
	if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}
	$stmt->execute();
	$stmt->bind_result($id, $tableUser, $tablePass);
	while($stmt->fetch()){
		if($user === $tableUser){
			if(password_verify($password, $tablePass)){
				header("Location:homepage.php");
			} else{
				echo "wrong password";
				break;
			}

		}
	}
	$stmt->close();
}
?>
