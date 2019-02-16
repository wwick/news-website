<?php
require 'database.php';
session_start();
$user = $_POST["user"];
$_SESSION["user"] = $user;
$password = $_POST["password"];
$hashedPass = password_hash($password, PASSWORD_DEFAULT);
if($_POST["new"]){
	$stmt = $mysqli->prepare("insert into users (user, password) values ('$user', '$hashedPass')");
	if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}
	$stmt->execute();
	$stmt->close();

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
				header("Location:login.html");
			} else{
				echo "wrong password";
				break;
			}

		}
	}
	$stmt->close();
}
?>
