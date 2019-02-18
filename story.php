<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<title>Story</title>
<link rel="stylesheet" type="text/css" href="stylesheet.css">

</head>
<body>

<a href="homepage.php" class="button">Homepage</a><br>

<?php
//acquires all necessary data for the story
require 'database.php';
$story_id=$_REQUEST['id'];
session_start();
$_SESSION["story"] = $story_id;//each story has a unique link based on a get variable
$stmt = $mysqli->prepare("select title, author, story, likes from stories where story_id=".$story_id);
if(!$stmt){
	header("Location:homepage.php");
}
$user_set = false;

if (isset($_SESSION['user'])) {
	$user_id = $_SESSION['user'];
	$user_set = true;
}

$stmt->execute();

$stmt->bind_result($title, $author, $story, $likes);


if ($stmt->fetch()){
	$title = $title;
	$author = $author;
	$story = $story;
	$likes = $likes;
}

$stmt->close();
$mysqli->close();

printf("\t<h3>%s likes</h3>\n", htmlspecialchars($likes));//shows likes

if ($user_set) {//you can only like or dislike if you are registered
	echo "
	<a href=\"like.php\" class=\"button\">Like</a><br>
	<a href=\"dislike.php\" class=\"button\">Dislike</a><br>
	";
}

//displays story
printf("\t<h1>%s</h1>\n", htmlspecialchars($title));
printf("\t<h2>By: %s</h2>\n", htmlspecialchars($author));
printf("\t<p>%s</p>\n", nl2br(htmlspecialchars($story)));

//if you are logged in you can comment
if ($user_set) {
echo "
<h3>Comment here!</h3><br>

<textarea placeholder=\"Type your comment here!\" name=\"comment\" form=\"comment\"></textarea><br>
</form>
<form action=\"comment.php\" method=\"post\" id=\"comment\">
<input type=\"submit\" value=\"Comment\">
</form><br>
";
}
require 'database.php';
//displays table with comment information
$stmt = $mysqli->prepare("select comment, users.user, comment_id, users.user_id from comments join users on (comments.user_id=users.user_id) where story_id={$_SESSION['story']}");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

$stmt->execute();

$stmt->bind_result($comment, $user, $id, $comment_user_id);

$count = 1;

while($stmt->fetch()){//if there are no comments, let's you know
	if ($count == 1) {
		echo "
		<table>
		<thead>
		<tr>
			<th>Comment</th>
			<th>User</th>
			";
			if ($user_set) {//if you are not logged in, you can't edit or delete
				echo "<th>Edit</th>";
				echo "<th>Delete</th>";
			}
		echo "
		</tr>
		</thead>
		<tbody>
		";
	}
	echo "<tr>\n";
	$comment_id = $id;
	printf("\t<td>%s</td>\n", htmlspecialchars($comment));
	printf("\t<td>%s</td>\n", htmlspecialchars($user));
	if ($comment_user_id == $user_id) {
	    printf("\t<td><a class=button href=\"edit.php?c=%s&sid={$_GET['id']}\">Edit</a></td>\n", htmlspecialchars($comment_id));
	    printf("\t<td><a class=button href=\"delete.php?c=%s&sid={$_GET['id']}\">Delete</a></td>\n", htmlspecialchars($comment_id));
	}
	echo "</tr>\n";
	$count = $count + 1;
}

if ($count != 1) {
	echo "
	</tbody>
	</table>
	";
} else {
	echo "<h3>There are no comments to show. If you are a registered user, you can add a comment for all users to view.</h3>";
}

$stmt->close();
$mysqli->close();

?>

</body>
</html>

