<?php

include("config.php");

//Als er is gesubmit, voeg de data toe aan de database
if(isset($_POST['submit']) && !empty($_POST['submit'])){
    $title = $_POST['title'];
    $url = $_POST['url'];
    if(is_numeric($_POST['year'])){
        $year = $_POST['year'];
    } else{
        $year = "2020";
    }
    $desc = $_POST['description'];

    $sql = "INSERT INTO `movie` (`title`, `url`, `year`, `description`, `distributor`) 
    VALUES (:title, :url, :year, :description, 1)";

    $query = $conn->prepare($sql);

    $array = ['title'=>$title, 'url'=>$url, 'year'=>$year, 'description'=>$desc];

    try{
        $query->execute($array);
        //Na het uitvoeren van de query, ga naar de admin page
        echo "<script>location.href='admin.php?page=view';</script>";
    }

    catch(PDOException $e) {
        echo "<script>console.log(\"Error: " .$e->getMessage() . "\")</script>";
   }
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
        <!-- Form met de benodigde data voor de database -->
        <form class="form-center" method="POST">
            <label>Titel:
            <input class="font-black" name="title" type="text" required>
            </label>
            <br/>

            <label>Video-URL:
            <input class="font-black" name='url' type="text" required>
            </label>
            <br/>

            <label>Cover afbeelding:
            <input class="font-black" name="image" type="file">
            </label>
            <br/>

            <label>Jaar:
            <input class="font-black" name="year" type="text">
            </label>
            <br/>

            <label>Beschrijving:
            <input class="font-black" name='description' type="text">
            </label>
            <br/>

            <input type="submit" name="submit" class="submit-button" value="Toevoegen">
        </form>
        </div>
    </div>
</body>
</html>