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
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

$stmt->execute();

$stmt->bind_result($title, $author, $story);

while($stmt->fetch()){
	printf("\t<p>%s</p>\n", htmlspecialchars($title));
	printf("\t<p>%s<p>\n", htmlspecialchars($author));
	printf("\t<p>%s</p>\n", htmlspecialchars($story));

}
$stmt->close();
$mysqli->close();

?>
<h3>Comment here!</h3></br>
<form action="comment.php" method="post" id="comment">
<input type="submit" value="Comment">
</form>
<textarea placeholder="Type your comment here!" name="comment" form="comment"></textarea></br>
<table>
<tr>
<th>Comments</th>
<th>Users</th>
<th>Delete?</th>
</tr>
<?php
require 'database.php';
session_start();
$stmt = $mysqli->prepare("select comment, users.user, comment_id from comments join users on (comments.user_id=users.user_id) where story_id={$_SESSION['story']}");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

$stmt->execute();

$stmt->bind_result($comment, $user, $id);

while($stmt->fetch()){
	echo "<tr>\n";
	printf("\t<td>%s</td>\n", htmlspecialchars($comment));
	printf("\t<td>%s</td>\n", htmlspecialchars($user));
	printf("\t<td><a href=\"delete.php?c=%s\"> Delete comment </a></td>\n", htmlspecialchars($id));
	echo "</tr>\n";
}
echo "</tr>\n";
$stmt->close();
$mysqli->close();

?>
</table>
</body>
</html>

