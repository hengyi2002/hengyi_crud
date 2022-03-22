<?php
session_start();

//Als er nog geen log in in de Session is opgeslagen, wordt het automatisch op false gezet
if(!isset($_SESSION['loggedIn'])){
    $_SESSION['loggedIn'] = false;
}

//PDO code
include("config.php");

//Het ophalen van alle films uit de database om te verwerken in de pagina en carrousel
$sql = "SELECT * FROM `movie`";

$query = $conn->prepare($sql);

try{
    $query->execute();
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
    <!-- Navbar ophalen uit z'n eigen bestand sind het een herhalend component is -->
    <?php include_once('navbar.php') ?>
    
    <!-- Hoofd content container -->
    <div class='container'>
        <!-- Als de gebruiker is ingelogd, krijgt hij de film informatie te zien met een media player om de film al af te kunnen spelen -->
        <?php if($_SESSION['loggedIn'] == true){ ?>
        <div class='video-showcase'>
            <div class='video-info'> <?php echo $results[0]['description'] ?> </div>
            <div class='video-player'>
                <video>
                    <source src= <?php echo $results[0]['url'] ?> >
                    Er is iets misgegaan, probeer het later nogeens.
                </video>
            </div>
        </div>

        <div class='video-carrosel'>
            <?php
                //Loopt door alle films heen om zo een afbeelding neer te zetten met een href die een GET meestuurd met de film id
                foreach($results as $movie){
                   echo "<a class='video-banner' href='video.php?id=". $movie['id'] ."'><img src='' width=100vw
                    height=150vh background-color='grey'></img></a>";
                }
            ?>
        </div>
        <!-- Als de gebruiker nog niet is ingelogd, krijg hij of zij alleen de beschrijving te zien met de carrousel -->
        <?php } else{ ?>
            <div class='video-showcase'>
                <div class='video-info'> <?php echo $results[0]['description'] ?> </div>
            </div>

            <div class='video-carrosel'>
                <?php
                foreach($results as $movie){
                    echo "<a class='video-banner' href='video.php?id=". $movie['id'] ."'><img src='' width=100vw
                    height=150vh background-color='grey'></img></a>";
                }
                ?>
            </div>
        <?php } ?>
    </div>
</body>
</html>