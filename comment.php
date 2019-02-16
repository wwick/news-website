<?php
require "database.php";
session_start();
$comment = $_POST["comment"];
$user = $_SESSION["user_id"];
$storyID = $_SESSION["storyID"];
$stmt = mysqli->prepare("insert into comments (story_id, user_id, comment) values (?, ?, ?)");
if(!stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}
$stmt->bind_param('iis', $user, $storyID, $comment);
$stmt->execute();
$stmt->close();
?>
