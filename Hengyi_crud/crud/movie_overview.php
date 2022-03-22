<?php

//connection to database

include("../config.php");

if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == true && $_SESSION['admin'] == 1){

} else {
    header("Location: ../error_page.php");
}

// $sql = "SELECT * FROM `movie`";

// $statement = $pdo->prepare($sql);

// try{
//     $statement->execute();
//     $statement->setFetchMode(PDO::FETCH_ASSOC);
//     $movie = $statement->fetchAll();
// }

// catch(PDOException $e) {
//     echo "<script>console.log(\"No results found: " .$e->getMessage() . "\")</script>";
// }

$select_all_movie = "SELECT * FROM `movie`";
$movie = sqlHandler($select_all_movie);


?>
<!DOCTYPE html>
<html lang="en">

<header>
<!-- adds navbar and bootstap link -->
    <?php include_once('../view/navbar_crud.php') ?>
</header>

<body>
    <div class="container">
        <br>
        <!-- <form method="get">
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="search for movie" name='search'>
                <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="submit" >search</button>
                </div>
            </div>
            </from> -->
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">title</th>
                    <th scope="col">url</th>
                    <th scope="col">year</th>
                    <th scope="col">
                        <p><a href="add.php" type="button" class="btn btn-sm btn-success">Add Product</a>
                        </p>
                    </th>
                </tr>
            </thead>
            <tbody>
            <!-- foreach loop that take all movie from movie and display it in a table -->
                <?php foreach ($movie as $i => $movie) { ?>
                <tr>
                    <th scope="row"><?php echo $i + 1 ?></th>
                    <td><?php echo $movie['title'] ?></td>
                    <td><?php echo $movie['url'] ?></td>
                    <td><?php echo $movie['year'] ?></td>
                    <td>
                        <a href="update.php?id=<?php echo $movie['id'] ?>"
                            class="btn btn-sm btn-outline-primary">Edit</a>
                        <form method="post" action="delete.php" style="display: inline-block">
                            <input type="hidden" name="id" value="<?php echo $movie['id'] ?>" >
                            <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                <?php } ?>
        </table>
    </div>
</body>

</html>