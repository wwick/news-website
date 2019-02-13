<?php
    $mysqli = new myswli('localhost', 'module3', 'module3', 'module3');
    if($mysqli->connect_errno){
    printf("Connection Failed: %s\n", $mysqli->connect_error);
    exit;
    }
?>
