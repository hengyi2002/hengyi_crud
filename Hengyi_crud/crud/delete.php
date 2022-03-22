<?php

include("../config.php");

//checks if the selected id have been posted, if not return the user to overview
$id = $_POST['id'] ?? null;
if(!$id){
    header('Location: movie_overview.php');
    exit;

}  

//delete query that delete the selected row and return the user to overview
$sql = "DELETE FROM movie WHERE id = :id";

try{
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':id', $id);
    $statement->execute();
    header('Location: movie_overview.php');
    exit;
}
catch(PDOException $e) {
    echo "<script>console.log(\"No results found: " .$e->getMessage() . "\")</script>";
}


?>

