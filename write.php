<html>
<head>
    <link rel="stylesheet" type="text/css" href="stylesheet.css">
</head>

<body>
<div id='main'>

<?php
//checks to make sure you are logged in, if not redirected
//to homepage. If you are, you can submite a story
session_start();
if(!isset($_SESSION["user"])){
	header("Location:homepage.php");
}
?>

<form action="upload.php" id="story" method="post">
Author: <input type="text" name="author" required><br>
Title: <input type="text" name="title" required><br>
<input type="submit" value="Submit story"> 
</form>
<textarea name="story" form="story" placeholder="Enter your story here" required></textarea>
</body>

</div>
</html>
