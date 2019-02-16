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
    $story_id = $_REQUEST["id"];

    $stmt = $mysqli->prepare("SELECT \"title\", \"story\", \"author\" FROM stories WHERE id=".$story_id);
    if(!$stmt){
        echo "command failed";
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }

    $stmt->execute();

    $stmt->bind_result($tile, $story, $author);
    echo $title;
    printf("\t<p>%s</p>\n", htmlspecialchars($author));
    printf("\t<p>%s</p>\n", htmlspecialchars($story));

    


    ?>
</body>
</html>


