<?php

require 'database.php';
session_start();
$user = $_POST["user"];
$password = $_POST["password"];
$hashedPass = password_hash($password, PASSWORD_DEFAULT);

$stmt = $mysqli->prepare("select user_id, user, password from users");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}
$stmt->execute();
$stmt->bind_result($user_id, $tableUser, $tablePass);
while($stmt->fetch()){
	if($user === $tableUser){
		if(password_verify($password, $tablePass)){
			$_SESSION["user"] = $user_id;
		}
	}
}
$stmt->close();
header("Location:homepage.php");

?>
