<?php

//connection to database
include("../config.php");

//checks if post is submit and notempty
if(isset($_POST['submit']) && !empty($_POST['submit'])){

    $title = $_POST['title'];
    $url = $_POST['url'];
    $year = $_POST['year'];
    $desc = $_POST['description'];

    //insent query to add to movie and bindValue to the query
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
<h1>Create new Product</h1>


<!-- form to add movie's -->
<form method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label>Titel</label><br>
        <input type="text" name="title" class="form-control"required>
    </div>
    <div class="form-group">
        <label>Video-URL</label>
        <input type="text" name="url" class="form-control"required>
    </div>
    <div class="form-group">
        <label>Jaar</label>
        <input type="number" name="year" class="form-control"required>
    </div>
    <div class="form-group">
        <label>Product description</label>
        <input type="text" name='description' class="font-black"required>
    </div>
    <input type="submit" name="submit" class="submit-button btn btn-primary" value="Toevoegen">
</form>

</body>
</html>