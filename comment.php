<?php
require "database.php";
session_start();
$comment = $_POST["comment"];
$user = $_SESSION["user"];
$story_id = $_SESSION["story"];
echo $user;
echo $story_id;
echo $comment;
$stmt = $mysqli->prepare("insert into comments (story_id, user_id, comment) values (?, ?, ?)");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}
$stmt->bind_param('iis', $story_id, $user, $comment);
$stmt->execute();
$stmt->close();
?>
