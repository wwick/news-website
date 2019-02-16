<?php
    require 'database.php';
    session_start();
    $user = $_POST["user"];
    $_SESSION["user"] = $user;
    $password = $_POST["password"];
    
    $hashedPass = password_hash($password, PASSWORD_DEFAULT);
    //echo $hashedPass;
    $stmt = $mysqli->prepare("insert into users (user, password) values ('$user', '$hashedPass')");
    if(!$stmt){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }
    //$stmt->bind_param('ss', $user, $hashedpass);
    $stmt->execute();
    $stmt->close();
?>
