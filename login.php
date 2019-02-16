<?php
require 'database.php';
session_start();
$user = $_POST["user"];
$password = $_POST["password"];
$hashedPass = password_hash($password, PASSWORD_DEFAULT);
$taken = 0;
if($_POST["new"]){
	$stmt = $mysqli->prepare("select user from users");
	if(!$stmt) {
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}
	$stmt->execute();
	$stmt->bind_result($tableUser);
	while($stmt->fetch()){
		if($user === $tableUser){
			$taken = true;
			break;        
		}
	}
	if ($taken) {
		echo "This username is taken. <a href=\"login.html\"> Try again? </a>";
	} else { 
		$stmt->close();
		$stmt = $mysqli->prepare("insert into users (user, password) values ('$user', '$hashedPass')");
		if(!$stmt){
			printf("Query Prep Failed: %s\n", $mysqli->error);
			exit;
		}
		$stmt->execute();
		$stmt->close();
		header("Location:login.html");
	}

} else {
	$stmt = $mysqli->prepare("select user_id, user, password from users");
	if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}
	$stmt->execute();
	$stmt->bind_result($id, $tableUser, $tablePass);
	while($stmt->fetch()){
		if($user === $tableUser){
			if(password_verify($password, $tablePass)){
				$_SESSION["user"] = $id;
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
