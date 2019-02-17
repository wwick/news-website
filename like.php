<?php

require 'database.php';
session_start();
if (!(isset($_SESSION['story']))) {
    //header("Location:homepage.php");
    echo "story_id session variable not set";
    exit;
}
$story_id = $_SESSION['story'];
if (!(isset($_SESSION['user']))) {
    //header("Location:story.php?=".$story_id);
    echo "user_id session variable not set";
    exit;
}
$user_id = $_SESSION['user'];


$stmt = $mysqli->prepare("select liked_stories from users where user_id=".$user_id);
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

$stmt->execute();

$stmt->bind_result($liked_stories);

$already_liked = false;

if ($stmt->fetch()){
    $liked_array = explode(",", $liked_stories);
    $already_liked = in_array((string)$story_id,$liked_array);
}

$stmt->close();

if ($already_liked) {
   //header("Location:story.php?=".$story_id);
   echo "already liked";
	exit;
}

echo "continued past already liked if statement";

$stmt = $mysqli->prepare("UPDATE stories SET likes=likes+1 WHERE story_id=".$story_id);
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}
$stmt->execute();
$stmt->close();

$stmt = $mysqli->prepare("UPDATE users SET liked_stories=concat(liked_stories, \",\", ".$story_id.") WHERE user_id=".$user_id);
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}
$stmt->execute();
$stmt->close();

$mysqli->close();

//header("Location:story.php?=".$story_id);
echo "reached end";

?>
