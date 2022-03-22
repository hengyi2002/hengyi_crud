<?php

    $host = "localhost";
    $dbname = "sopranos_pizzeria";
    $user = "root";
    $password = "";

    try{
    $pdo = new PDO("mysql:host=$host; dbname=$dbname;", $user, $password);

    $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    echo '<script>console.log(\'connection established\')</script>';
    }
    catch(PDOException $e)
    {
        echo '<script>console.log(\'connection failed:' . $e->getMessage() . '\)</script>';
    }
?>