<?php
require "database.php";
session_start();
$comment = $_POST["comment"];

if (!(isset($_SESSION['story'])))  {
	header("Location:homepage.php");
}
if (!(isset($_SESSION['user'])))  {
	header("Location:story.php");
}

$user = $_SESSION["user"];
$story_id = $_SESSION["story"];
$stmt = $mysqli->prepare("insert into comments (story_id, user_id, comment) values (?, ?, ?)");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}
$stmt->bind_param('iis', $story_id, $user, $comment);
$stmt->execute();
$stmt->close();
header("Location=story.php?id=".$story_id);
?>
