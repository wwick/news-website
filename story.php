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

    if ($stmt = $mysqli->prepare("SELECT \"title\" FROM stories")) {
        $stmt->execute();

        /* bind variables to prepared statement */
        if ($stmt->bind_result($title)) {
  	    echo "yay";
        }

        /* fetch values */
        while ($stmt->fetch()) {
            printf("%s\n", $title);
        }
    	$stmt->close();
    }
    $mysqli->close();

    ?>

</body>
</html>

