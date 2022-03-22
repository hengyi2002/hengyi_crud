<?php

include("config.php");

//Selecteer de film via de meegegeven id
$sql = "SELECT * FROM `movie` WHERE id = ?";

$query = $conn->prepare($sql);

try{
    $query->execute(array($_GET['id']));
    $query->setFetchMode(PDO::FETCH_ASSOC);
    $result = $query->fetchAll();
}

catch(PDOException $e) {
    echo "<script>console.log(\"No results found: " .$e->getMessage() . "\")</script>";
}

function delete($id){
    global $conn;

    //Controleer of id een nummer is
    if(is_numeric($id)){
        $sql = "DELETE FROM `movie` WHERE id = ?";

        $query = $conn->prepare($sql);

        try{
            $query->execute(array($_GET['id']));
            //Nadat de query is uitgevoerd, ga terug naar de admin page
            header("Location: admin.php");
        }
        
        catch(PDOException $e) {
            echo "<script>console.log(\"No results found: " .$e->getMessage() . "\")</script>";
        }
    }
}

if(isset($_POST['submit']) && !empty($_POST['submit'])){
    delete($_POST['id']);
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
        <form class='form-center' method="POST">

            <input class="font-black" name="id" type="hidden" value="<?php echo $result[0]['id'] ?>" readonly> <br/>

            <input class="font-black" type='text' name="title" value="<?php echo $result[0]['title'] ?>" readonly> <br/>

            <input class="font-black" type='text' name="year" value="<?php echo $result[0]['year'] ?>" readonly> <br/>

            <input class="submit-button" name="submit" type="submit" value="Bevestig">
        </form>
    </div>
</body>
</html>