<?php

    $host = "localhost";
    $dbname = "sopranos_db";
    $user = "root";
    $password = "";

    try{
    $conn = new PDO("mysql:host=$host; dbnaam=$dbname;", $user, $password);

    $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    echo '<script>console.log(\'connection established\')</script>';
    }
    catch(PDOException $e)
    {
        echo '<script>console.log(\'connection failed:' . $e->getMessage() . '\)</script>';
    }
?>