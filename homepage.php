<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Fake News</title>
	<link rel="stylesheet" type="text/css" href="stylesheet.css">
</head>
<body>
<div id='main'>

<?php
//checks to see if you are logged in
session_start();
$user_set = false;
if (isset($_SESSION['user'])) {//displays a welcome message if you are logged in
	$user_set = true;
	require 'database.php';
	$user_id=$_SESSION['user'];
	$stmt = $mysqli->prepare("select user from users where user_id=\"".$user_id."\"");
	if(!$stmt){
		header("Location:abort.php");
	}
	$stmt->execute();
	$stmt->bind_result($user);
	if($stmt->fetch()){
		printf("<p>You are now logged in as user %s</p>", htmlspecialchars($user));
	}
	$stmt->close();
	$mysqli->close();

} else {//if you are not logged in, creates forms to log in or create a new user

	echo "
		<p>Create New User</p>
		<form action=\"create.php\" method=\"POST\">
		Username: <input type=\"text\" name=\"user\"><br>
		Password: <input type=\"password\" name=\"password1\"><br>
		Confirm Password: <input type=\"password\" name=\"password2\"><br>
		<input type=\"submit\" value=\"Create new user\"><br>
		</form>
		<br>";

	echo "
		<p>Login as Existing User</p>
		<form action=\"login.php\" method=\"POST\">
		Username: <input type=\"text\" name=\"user\"><br>
		Password: <input type=\"password\" name=\"password\"><br>
		<input type=\"submit\" value=\"Login\"><br>
		</form>
		<br>
		";

}

?>
<?php
//displays all stories in a neat table 
require 'database.php';
$stmt = $mysqli->prepare("select title, author, story_id from stories");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

$stmt->execute();

$stmt->bind_result($title, $author, $story_id);

$count = 1;
while($stmt->fetch()){
	if ($count == 1){
		echo "<table>";
		echo "<thead>";
		echo "<tr>";
		echo "<th>Title</th>";
		echo "<th>Author</th>";
		if ($user_set) {
			echo "<th>Edit</th>";
			echo "<th>Delete</th>";
		}
		echo "</tr>";
		echo "</thead>";
		echo "<tbody>";
	}
	echo "<tr>\n";
	$story = $story_id;
	printf("\t<td> <a href=\"story.php?id=$story\">%s</a></td>\n", htmlspecialchars($title));
	printf("\t<td>%s</td>\n", htmlspecialchars($author));
	if ($user_set) {//if you are not logged in, you won't be given the option to edit or delete
		echo "\t<td> <a href=\"edit.php?id=$story\" class=\"button\">Edit</a></td>\n";
		echo "\t<td> <a href=\"delete.php?id=$story\" class=\"button\">Delete</a></td>\n";
	}
	echo "</tr>\n";
	$count = $count + 1;
}
if ($count != 1){
	echo "</tbody>
		</table>";
}else{//if there are no stories to show, then you are recommended to contribute
	echo "<h3>There are no stories to show. If you are a registered user, you can add a story for all users to view.</h3>";
}

$stmt->close();
$mysqli->close();

echo "<br>";
if (isset($_SESSION['user'])) {//click these to logout  or write an article
	echo " <a href=\"write.php\" class=\"button\">Write Story</a>\t";
	echo "<a href=\"abort.php\" class=\"button\">Logout</a>";
}

?>

</div>

</body>
</html>
