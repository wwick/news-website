<?php
require "database.php";
session_start();
if(isset($_GET['cid'])){
	$stmt = $mysqli->prepare("select user_id from comments where comment_id=".$_GET["cid"]);
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
		$stmt = $mysqli->prepare('update comments set comment=? where comment_id='.$_GET['cid']);
		if(!$stmt){
			printf("Query Prep Failed: %s\n", $mysqli->error);
			exit;
		}
		$stmt->bind_param('s',$_POST['comment']);
		$stmt->execute();
		$stmt->close();
		header("Location:story.php?id={$_GET['sid']}");
	}	
} else{
	$stmt = $mysqli->prepare("select user_id from stories where story_id=".$_GET["sid"]);
	if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}
	echo "passed first";
	$stmt->execute();
	$stmt->bind_result($userID);
	while($stmt->fetch()){
		$id = $userID;
	}
	if($_SESSION["user"]==$id){
		$stmt = $mysqli->prepare('update stories set story=? where story_id='.$_GET['sid']);
		if(!$stmt){
			printf("Query Prep Failed: %s\n", $mysqli->error);
			exit;
		}
		$stmt->bind_param('s',$_POST['story']);
		$stmt->execute();
		$stmt->close();
		header("Location:story.php?id={$_GET['sid']}");
	}
}
?>
