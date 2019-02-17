<?php
require "database.php";
session_start();
if(isset($_GET["c"])){
	$stmt = $mysqli->prepare("select user_id from comments where comment_id=".$_GET["c"]);
	if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}
	$stmt->execute();
	$stmt->bind_result($userID);
	while($stmt->fetch()){
		$id = $userID;
	}
	if($_SESSION["user"]==$id){
		$stmt = $mysqli->prepare("delete from comments where comment_id=".$_GET['c']);
		if(!$stmt){
			printf("Query Prep Failed: %s\n", $mysqli->error);
			exit;
		}
		$stmt->execute();
		$stmt->close();
		header("Location:story.php?id=".$_GET["sid"]);
	} else{
		printf(nl2br("Don't try to delete comments that aren't yours\n<a href=\"story.php?id={$_GET['sid']}\"> Go back to story? </a>"));
	}
} else{
	$stmt = $mysqli->prepare("select user_id from stories where story_id=".$_GET["id"]);
	if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}
	$stmt->execute();
	$stmt->bind_result($userID);
	while($stmt->fetch()){
		$id = $userID;
	}
	if($_SESSION["user"]==$id){
		$stmt = $mysqli->prepare("delete from stories where story_id=".$_GET['id']);
		if(!$stmt){
			printf("Query Prep Failed: %s\n", $mysqli->error);
			exit;
		}
		$stmt->execute();
		$stmt->close();
		header("Location:homepage.php");
	} else{
		printf(nl2br("Don't try to delete stories that aren't yours\n<a href=\"homepage.php\"> Go back to homepage? </a>"));
	}
}
?>
