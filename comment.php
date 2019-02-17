<?php
require "database.php";
session_start();
$comment = $_POST["comment"];
$user = $_SESSION["user"];
$storyID = $_SESSION["story"];
echo $user;
echo $storyID;
echo $comment;
$stmt = $mysqli->prepare("insert into comments (story_id, user_id, comment) values (?, ?, ?)");
if(!stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}
$stmt->bind_param('iis', $storyID, $user, $comment);
$stmt->execute();
$stmt->close();
?>
