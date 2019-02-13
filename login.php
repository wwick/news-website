<?php
    require 'database.php';
    session_start();
    $user = $_POST["user"];
    $_SESSION["user"] = $user;
    $password = $_POST["password"];
    
    if (password_verify($password, $hash)) {
        header("website.php");
    } else {
        header("login.html");
    }
    
