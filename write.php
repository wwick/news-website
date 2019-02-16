<html>
<body>
<?php
session_start();
if(!isset($_SESSION["user"])){
	echo "You are not currently logged in, you will be unable to post ";
}
?>

<form action="upload.php" id="story" method="post">
Author: <input type="text" name="author"></br>
Title: <input type="text" name="title"></br>
<input type="submit" value="Submit story"> 
</form>
<textarea name="story" form="story" placeholder="Enter your story here"></textarea>
</body>
</html>
