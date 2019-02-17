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
</body>
</html>

