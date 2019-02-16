<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>News</title>
	<link rel="stylesheet" type="text/css" href="stylesheet.css">
</head>
<body>


	<?php
		session_start();
		if (isset($_SESSION['user'])) {
			echo "You are logged in as ".$user;
		} else {
			echo "
			Create New User
			<form action=\"login.php\" method=\"POST\">
				Username: <input type=\"text\" name=\"user\"><br>
				Password: <input type=\"password\" name=\"password\"><br>
				<input type=\"submit\" value=\"Login\"><br>
			</form>
			<h1> New users must login again after making their account! </h1></br>
			<a href=\"homepage.php\">Continue without logging in</a>
			";
		}

	?>
	<!-- <form action="login.php" method="POST">
		Username: <input type="text" name="user"><br>
		Password: <input type="password" name="password"><br>
		Are you a new user? <input type="radio" name="new" value="1">Yes <input type="radio" name="new" value="0">No<br>
		<input type="submit" value="Login"><br>
	</form>
	<h1> New users must login again after making their account! </h1></br>
	<a href="homepage.php">Continue without logging in</a> -->


	<table>
		<tr>
			<th>Title</th>
			<th>Author</th>
		</tr>  

<?php

require 'database.php';
session_start();
$stmt = $mysqli->prepare("select title, author, story_id from stories");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

$stmt->execute();

$stmt->bind_result($tile, $author, $story_id);

while($stmt->fetch()){
	echo "<tr>\n";
	printf("\t<td> <a href=\"story.php?id=$story_id\">%s</a></td>\n", htmlspecialchars($tile));
	printf("\t<td>%s</td>\n", htmlspecialchars($author));
	echo "</tr>\n";
}
echo "</tr>\n";
$stmt->close();
$mysqli->close();

?>

</table>
<a href="write.php">Click here to write a story</a>


</body>
</html>
