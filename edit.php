<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Edit</title>
	<link rel="stylesheet" type="text/css" href="stylesheet.css">
</head>
<body>
<div id='main'>


<?php
require "database.php";
session_start();
if(isset($_GET["c"])){//checks if you are editing a comment or story
	$stmt = $mysqli->prepare("select user_id from comments where comment_id=".$_GET["c"]);
	if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}
	$stmt->execute();
	$stmt->bind_result($user_id);
	while($stmt->fetch()){
		$id = $user_id;
	}
	if($_SESSION["user"]==$id){//you can only edit a comment that you wrote
		$stmt = $mysqli->prepare("select comment from comments where comment_id=".$_GET['c']);
		if(!$stmt){
			printf("Query Prep Failed: %s\n", $mysqli->error);
			exit;
		}
		$stmt->execute();
		$stmt->bind_result($comment);
		while($stmt->fetch()){
			$editing = $comment;
		}
		$stmt->close();
		printf("<form action=\"update.php?cid={$_GET['c']}&sid={$_GET['sid']}\" id=\"form\" method=\"post\">
				<input type=\"submit\" value=\"Update\" class=\"button\">
				</form>
				<textarea form=\"form\" name=\"comment\">{$editing}</textarea>");
		//your previous comment is in the text box for you to manipulate
	} else{
		printf(nl2br("Don't try to edit comments that aren't yours\n<a href=\"story.php?id={$_GET['sid']}\"> Go back to story? </a>"));
	}
} else{//you are editing a story
	$stmt = $mysqli->prepare("select user_id from stories where story_id={$_GET['id']}");
	if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}
	$stmt->execute();
	$stmt->bind_result($user_id);
	while($stmt->fetch()){
		$id = $user_id;
	}
	if($_SESSION["user"]==$id){//can't edit a story that isn't yours
		$stmt = $mysqli->prepare("select story from stories where story_id=".$_GET['id']);
		if(!$stmt){
			printf("Query Prep Failed: %s\n", $mysqli->error);
			exit;
		}
		$stmt->execute();
		$stmt->bind_result($comment);
		while($stmt->fetch()){
			$editing = $comment;
		}
		$stmt->close();//form is auto filled with the text from your previous story
		printf("<form action=\"update.php?sid={$_GET['id']}\" id=\"form\" method=\"post\">
				<input type=\"submit\" value=\"Update\" class=\"button\">
				</form>
				<textarea form=\"form\" name=\"story\">{$editing}</textarea>");
	} else{
		printf(nl2br("Don't try to edit comments that aren't yours\n<a href=\"story.php?id={$_GET['sid']}\"> Go back to story? </a>"));
	}
}
?>

</div>
</body>
</html>

