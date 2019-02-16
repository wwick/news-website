<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<title>News</title>
<link rel="stylesheet" type="text/css" href="stylesheet.css">
</head>
<body>
<table>
<tr>
<th>Title</th>
<th>Author</th>
</tr>  

<?php

require 'database.php';
session_start();
$stmt = $mysqli->prepare("select title, author, id from stories");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

$stmt->execute();

$stmt->bind_result($tile, $author, $story_id);

<<<<<<< HEAD
while($stmt->fetch()){
	echo "<tr>\n";
	printf("\t<td> <a href=\"story.php?id=$story_id\">%s</a></td>\n", htmlspecialchars($tile));
	printf("\t<td>%s</td>\n", htmlspecialchars($author));
	echo "</tr>\n";
}
echo "</tr>\n";
$stmt->close();
=======
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
>>>>>>> e3cc5020811821955460eacd2ac9b84d6a332bfc

?>

</table>
<a href="write.php">Click here to write a story</a>

<<<<<<< HEAD







=======
>>>>>>> e3cc5020811821955460eacd2ac9b84d6a332bfc

</body>
</html>
