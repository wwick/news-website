<?php
require "database.php";
session_start();
$user_id =  $_SESSION["user"];
$story = $_POST["story"];
$author = $_POST["author"];
$title = $_POST["title"];


$stmt = $mysqli->prepare("insert into stories (story, title, author, user_id) values (?,?,?,?)");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

$stmt->bind_param('sssi', $story, $title, $author, $user_id);

$stmt->execute();

$stmt->close();
header("Location:homepage.php");
?>
