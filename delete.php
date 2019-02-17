<?php
require "database.php";
//deletes stories and comments
session_start();
if(isset($_GET["c"])){//checks if you are deleting a comment or story
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
	if($_SESSION["user"]==$id){//checks if you are trying to delete a comment that isn't yours
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
} else{//item to delete is a story
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
	if($_SESSION["user"]==$id){//checks if you are the user who wrote the story
		$stmt = $mysqli->prepare("set foreign_key_checks=0");//comments have a foreign key to stories, overrides the foreign key check
		if(!$stmt){
			printf("Query Prep Failed: %s\n", $mysqli->error);
			exit;
		}
		$stmt->execute();
		$stmt->close();
		$stmt = $mysqli->prepare("delete from stories where story_id=".$_GET['id']);//deleted the story
		if(!$stmt){
			printf("Query Prep Failed: %s\n", $mysqli->error);
			exit;
		}
		$stmt->execute();
		$stmt->close();
		$stmt = $mysqli->prepare("set foreign_key_checks=1");//turn those checks back on!
                if(!$stmt){
                        printf("Query Prep Failed: %s\n", $mysqli->error);
                        exit;
                }
                $stmt->execute();
                $stmt->close();

		header("Location:homepage.php");//redirects you back
	} else{
		printf(nl2br("Don't try to delete stories that aren't yours\n<a href=\"homepage.php\"> Go back to homepage? </a>"));
	}
}
?>
