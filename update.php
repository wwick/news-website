<?php
require "database.php";
session_start();
if(isset($_GET['cid'])){
	echo "cid is set";
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
		//header("Location:story.php?s={$_GET['sid']}");
	}	
}
?>
