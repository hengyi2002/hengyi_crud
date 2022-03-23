<?php

include("../config.php");

//checks if the selected id have been posted, if not return the user to overview
$id = $_GET['id'] ?? null;
if(!$id){
    header('Location: movie_overview.php');
    exit;

}  
    $sql = "SELECT * FROM movie WHERE id = :id";
    try{
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':id', $id);
    $statement->execute();
    $movie = $statement->fetch(PDO::FETCH_ASSOC);
    }

    catch(PDOException $e) {
        echo "<script>console.log(\"No results found: " .$e->getMessage() . "\")</script>";
    }

    $title = $movie['title'];
    $url = $movie['url'];
    $year = $movie['year'];
    $desc = $movie['description'];

//checks if the post has been submit, if it is select the data from the form and INSERT it
if(isset($_POST['submit']) && !empty($_POST['submit'])){

    $title = $_POST['title'];
    $url = $_POST['url'];
    $year = $_POST['year'];
    $desc = $_POST['description'];


    $sql = "INSERT INTO movie (title, url, year, description, distributor) 
            VALUES (:title, :url, :year, :description, 1)";

    $statement = $pdo->prepare($sql);

    try{
        $statement->bindValue(':title', $title);
        $statement->bindValue(':url', $url);
        $statement->bindValue(':year', $year);
        $statement->bindValue(':description', $desc);

        $statement->execute();
        echo "<script>location.href='movie_overview.php';</script>";
    }
    catch(PDOException $e) {
            echo "<script>console.log(\"No results found: " .$e->getMessage() . "\")</script>";
    }

}


?>

<!doctype html>
<html lang="en">

<header>

<!-- adds navbar and bootstap link -->
<?php include_once('../view/navbar_crud.php') ?>

</header>

<body>
    <h1>Update movie <b><?php echo $movie['title'] ?></b></h1>
    <form method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label>Titel</label><br>
            <input type="text" name="title" class="form-control" value="<?php echo $title ?>" required>
        </div>
        <div class="form-group">
            <label>Video-URL</label>
            <input type="text" name="url" class="form-control" value="<?php echo $url ?>" required>
        </div>
        <div class="form-group">
            <label>Jaar</label>
            <input type="number" name="year" class="form-control" value="<?php echo $year ?>" required>
        </div>
        <div class="form-group">
            <label>Product description</label>
            <input type="text" name='description' class="form-control" value="<?php echo $desc ?>" required>
        </div>
         <a href="movie_overview.php" class="btn btn-default">Back to products</a>
        <input type="submit" name="submit" class="submit-button btn btn-primary" value="Toevoegen">
    </form>

</body>

</html>
