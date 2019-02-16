<?php
require "database.php";
session_start();
$userID =  $_SESSION["userid"];
$story = $_POST["story"];
$author = $_POST["author"];
$title = $_POST["title"];


$stmt = $mysqli->prepare("insert into stories (story, title, author) values (?,?,?)");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

$stmt->bind_param('sss', $story, $title, $author);

$stmt->execute();

$stmt->close();
header("Location:homepage.php");
?>
