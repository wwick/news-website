<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>News</title>
</head>
<body>
    <table>
        <tr>
            <th>Title</th>
            <th>Author</th>
        </tr>  

<?php

    require 'database.php';

    $stmt = $mysqli->prepare("select title, author from stories");
    if(!$stmt){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }

    $stmt->execute();

    $stmt->bind_result($tile, $author);

    while($stmt->fetch()){
        echo "<tr>\n";
        printf("\t<td>%s</td>\n", htmlspecialchars($tile));
        printf("\t<td>%s</td>\n", htmlspecialchars($author));
        echo "</tr>\n";
    }
    echo "</tr>\n";
    $stmt->close();

?>

</table>


        







</body>
</html>
