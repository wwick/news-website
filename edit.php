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
		printf("<form action=\"update.php\" id=\"form\" method=\"post\">
			<input type=\"submit\" value=\"Update\">
			</form>
			<textarea form=\"form\">{$editing}</textarea>");
                //header("Location:story.php?id=".$_GET["sid"]);
        } else{
                printf(nl2br("Don't try to delete comments that aren't yours\n<a href=\"story.php?id={$_GET['sid']}\"> Go back to story? </a>"));
        }
}
?>
