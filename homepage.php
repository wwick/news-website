<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>News</title>
	<link rel="stylesheet" type="text/css" href="stylesheet.css">
</head>
<body>
	<div id='main'>

	<?php
		session_start();
		if (isset($_SESSION['user'])) {
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

		} else {

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
				<input type=\"submit\" value=\"Create new user\"><br>
			</form>
			";

		}

	?>
	<table>
		<thead>
		<tr>
			<th>Title</th>
			<th>Author</th>
			<th>Edit</th>
			<th>Delete</th>
		</tr>  
		</thead>
		<tbody>
<?php

require 'database.php';
$stmt = $mysqli->prepare("select title, author, story_id from stories");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

$stmt->execute();

$stmt->bind_result($title, $author, $story_id);

while($stmt->fetch()){
	echo "<tr>\n";
	printf("\t<td> <a href=\"story.php?id=$story_id\">%s</a></td>\n", htmlspecialchars($title));
	printf("\t<td>%s</td>\n", htmlspecialchars($author));
	echo "\t<td> <a class = button href=\"edit.php?id=$story_id\">Edit</a></td>\n";
	echo "\t<td> <a class = button href=\"delete.php?id=$story_id\">Delete</a></td>\n";
	echo "</tr>\n";
}
echo "</tbody>\n";
$stmt->close();
$mysqli->close();

echo "</table><br>";
if (isset($_SESSION['user'])) {
    echo " <a href=\"write.php\" class = button>Write Story</a>\t";
    echo "<a href=\"abort.php\" class = button>Logout</a>";
}

?>

</div>

</body>
</html>
