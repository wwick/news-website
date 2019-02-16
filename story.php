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

    // require 'database.php';
    // $story_id = $_REQUEST["id"];

    // if ($stmt = $mysqli->prepare("SELECT \"title\" FROM stories")) {
    //     $stmt->execute();

    //     /* bind variables to prepared statement */
    //     if ($stmt->bind_result($title)) {
  	//     echo "yay";
    //     }

    //     /* fetch values */
    //     while ($stmt->fetch()) {
    //         printf("%s\n", $title);
    //     }
    // 	$stmt->close();
    // }
    // $mysqli->close();

    require 'database.php';
    $story_id=$_REQUEST['id'];

    $stmt = $mysqli->prepare("select title, author, story from stories where id=".$story_id);
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
<textarea placeholder="Type your comment here!" name="comment" form="comment"></textarea></br>
<form action="comment.php" method="post">
<input type="submit" value="Comment">
</form>
</body>
</html>

