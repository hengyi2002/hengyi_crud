<?php

include("config.php");

//Select alle films
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
    <title>Beheer - Netfish</title>

    <link link rel="stylesheet" type="text/css" href='./assets/styles.css'>
</head>
<body>
    <?php include_once('navbar.php') ?>
    
    <div class='container'>
        <!-- Een table om alles gestructureed te laten zien -->
        <table class="">
            <tr>
                <th>Jaar</th>
                <th>Titel</th>
                <th>Actie</th>
            </tr>
        <?php
            //Voor elke film, maak een nieuwe regel aan met een verwijder link met een GET.
            foreach($results as $movie){
                echo "<tr>
                    <td>". $movie['year'] ."</td>
                    <td>". $movie['title'] ."</td>
                    <td><a class='no-deco' href='admin.php?page=delete&id=" . $movie['id'] . "'>Verwijderen</a></td>
                </tr>";
            }
        ?>
        </table>
    </div>
</body>
</html>