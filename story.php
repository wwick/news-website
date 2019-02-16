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

    require(database.php);
    $story_id = $_REQUEST["id"];

    $stmt = $mysqli->prepare("select title, story, author from stories where id=".$story_id);
    if(!$stmt){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }

    $stmt->execute();

    $stmt->bind_result($tile, $story, $author);
    printf("\t<p>%s</p>\n", htmlspecialchars($author));
    printf("\t<p>%s</p>\n", htmlspecialchars($story));

    


    ?>
</body>
</html>


