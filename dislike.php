<?php

// checks that story session variable is set
session_start();
if (!(isset($_SESSION['story']))) {
    header("Location:homepage.php");
}
$story_id = $_SESSION['story'];

// checks that user session variable is set
if (!(isset($_SESSION['user']))) {
    header("Location:story.php?id=".$story_id);
}
$user_id = $_SESSION['user'];

// logs into MySQL
require 'database.php';

// gets list of stories user has already liked
$stmt = $mysqli->prepare("select liked_stories from users where user_id=".$user_id);
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}
$stmt->execute();
$stmt->bind_result($liked_stories);

// checks if user has already liked the story
$already_liked = false;
if ($stmt->fetch()){
    $liked_array = explode("_", $liked_stories);
    $already_liked = in_array((string)$story_id,$liked_array);
}
$stmt->close();

// likes story if story is not already liked
if ($already_liked) {

	// increments story liked count
	$stmt = $mysqli->prepare("UPDATE stories SET likes=likes-1 WHERE story_id=".$story_id);
	if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}
	$stmt->execute();
	$stmt->close();

	// add this story to the user's list of liked stories
	$stmt = $mysqli->prepare("UPDATE users SET liked_stories=concat(liked_stories, \",\", ".$story_id.") WHERE user_id=".$user_id);
	if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}
	$stmt->execute();
	$stmt->close();

	// removes story_id from list of user's liked stories
	$search_string = "_".$story_id."_";
	$stmt = $mysqli->prepare("UPDATE users SET liked_stories=REPLACE(liked_stories,\"".$search_string."\",\"\") WHERE user_id=".$user_id);
	if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}
	$stmt->execute();
	$stmt->close();
	
}

// logs out of MySQL and returns to story
$mysqli->close();
header("Location:story.php?id=".$story_id);

?>
