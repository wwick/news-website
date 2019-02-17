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

	} else{
		echo "Don't try to delete comments that aren't yours";
	}
}
?>
