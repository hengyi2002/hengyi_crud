<?php

include("../config.php");

//checks if the selected id have been posted, if not return the user to overview
$id = $_GET['id'] ?? null;
if(!$id){
    header('Location: movie_overview.php');
    exit;

}  
    $sql = "SELECT * FROM movie WHERE id = :id";

    $statement = $pdo->prepare($sql);
    $statement->bindValue(':id', $id);
    $statement->execute();
    $movie = $statement->fetch(PDO::FETCH_ASSOC);
    // var_dump($movie);
    // }

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

    $statement = $pdo->prepare($sql);

        $statement = $pdo->prepare("UPDATE movie SET title = :title, 
                                        url = :url, 
                                        year = :year,
                                        description = :description,  
                                        distributor = 1 
                                        WHERE id = :id");
        $statement->bindValue(':title', $title);
        $statement->bindValue(':url', $url);
        $statement->bindValue(':year', $year);
        $statement->bindValue(':description', $desc);
        $statement->bindValue(':id', $id);

        $statement->execute();
        header('Location: movie_overview.php');

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
