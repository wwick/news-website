<<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<title>Story</title>
<link rel="stylesheet" type="text/css" href="stylesheet.css">

</head>
<body>

<?php

require 'database.php';
$story_id=$_REQUEST['id'];
session_start();
$_SESSION["story"] = $story_id;
$stmt = $mysqli->prepare("select title, author, story from stories where story_id=".$story_id);
if(!$stmt){
	header("Location:homepage.php");
}
$user_set = isset($_SESSION['user']);

$stmt->execute();

$stmt->bind_result($title, $author, $story);

while($stmt->fetch()){
	printf("\t<h1>%s</h1>\n", htmlspecialchars($title));
	printf("\t<p>By: %s<p>\n", htmlspecialchars($author));
	printf("\t<p>%s</p>\n", htmlspecialchars($story));
}
$stmt->close();
$mysqli->close();

?>
<h3>Comment here!</h3><br>
<form action="comment.php" method="post" id="comment">
<input type="submit" value="Comment">
</form>
<textarea placeholder="Type your comment here!" name="comment" form="comment"></textarea><br><br>,

<?php
require 'database.php';
$stmt = $mysqli->prepare("select comment, users.user, comment_id from comments join users on (comments.user_id=users.user_id) where story_id={$_SESSION['story']}");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

$stmt->execute();

$stmt->bind_result($comment, $user, $id);

$count = 1;

while($stmt->fetch()){
	if ($count == 1) {
		echo "
		<table>
		<thead>
		<tr>
			<th>Comment</th>
			<th>User</th>
			";
			if ($user_set) {
				echo "<th>Edit</th>";
				echo "<th>Delete</th>";
			}
		echo "
		</tr>
		</thead>
		</tbody>
		";
	}
	echo "<tr>\n";
	$comment_id = $id;
	printf("\t<td>%s</td>\n", htmlspecialchars($comment));
	printf("\t<td>%s</td>\n", htmlspecialchars($user));
	if ($user_set) {
	    printf("\t<td><a class=button href=\"edit.php?c=%s&sid={$_GET['id']}\">Edit</a></td>\n", htmlspecialchars($comment_id));
	    printf("\t<td><a class=button href=\"delete.php?c=%s&sid={$_GET['id']}\">Delete</a></td>\n", htmlspecialchars($comment_id));
	}
	echo "</tr>\n";
	$count = $count + 1;
}

if ($count != 1) {
	echo "
	<tbody>
	</table>
	";
}

$stmt->close();
$mysqli->close();

?>

</body>
</html>

