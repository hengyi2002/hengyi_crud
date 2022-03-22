<?php
session_start();

include("config.php");

//Als de gebruiker niet is ingelogd, wordt hij of zij naar de login pagina gestuurd
if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == false){
    echo "<script>location.href='login.php';</script>";
}

//Haald alle films op uit de carrousel
$sql = "SELECT * FROM `movie` WHERE id = ?";

$query = $conn->prepare($sql);

try{
    $query->execute(array($_GET['id']));
    $query->setFetchMode(PDO::FETCH_ASSOC);
    $results = $query->fetchAll();
}

catch(PDOException $e) {
    echo "<script>console.log(\"No results found: " .$e->getMessage() . "\")</script>";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Netfish</title>

    <link link rel="stylesheet" type="text/css" href='./assets/styles.css'>
</head>
<body>
    <?php include_once('navbar.php') ?>
    <!-- Dezelfde opbouw als bij index.php -->
    <div class='container'>
    <div class='video-showcase'>
            <div class='video-info'> 
                <?php //echo $results[0]['description'] ?>
             </div>
            <div class='video-player'>
                <video>
                    <source src= <?php // echo $results[0]['url'] ?> >
                    Er is iets misgegaan, probeer het later nogeens.
                </video>
            </div>
        </div>
    </div>
</body>
</html>