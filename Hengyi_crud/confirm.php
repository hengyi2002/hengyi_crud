<?php


//connection to database and header
require("config.php");
include_once('./view/navbar.php');

//Als er nog geen log in in de Session is opgeslagen, wordt het automatisch op false gezet
if(!isset($_SESSION["cart"])){
    $_SESSION["cart"] = array();
}


//select query voor het ophalen van alle movie arrays

$select_all_movie = "SELECT * FROM `movie`";
$movie = sqlHandler($select_all_movie);


?>
<!DOCTYPE html>
<html lang="en">


<body>
    <div class="container">
        <div class="row no-gutters">
            <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center">
                    <h1>Cart details</h1>
                </div>

                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">title</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- foreach loop voor elke array in cart, haalt het op en toon de aan in een table -->
                        <?php foreach ($_SESSION["cart"] as $i => $movie) { 


                            //select query voor het ophalen van array in cart  
                            $select_movie = "SELECT * from movie WHERE id =".$movie['movie_id'];
                            $returned_movie =  sqlHandler($select_movie);

                            // var_dump($returned_movie);
                            // echo "<br>";
                            // echo "<br>";

                            //unset de geselecteerde value in a href

                            if(isset($_GET['id'])){
                                // var_dump($_SESSION["cart"]);
                                // echo "<br>";
                                unset($_SESSION["cart"][$_GET['id']]);
                                }

                            //unset de hele cart
                            if(isset($_POST["order"])){
                                unset($_SESSION["cart"]);
                                }
                            
                        ?>
                        <tr>
                            <th scope="row"><?php echo $i + 1 ?></th>
                            <td><?php echo $returned_movie[0]["title"] ?></td>
                            <td><?php var_dump($returned_movie[0]['id']); ?></td>
                            <td>
                                <a href="confirm.php?id=<?php echo $i ?>">delete</a>
                            </td>
                        </tr>
                        <?php } ?>
                        <form method="post" action="" style="display: inline-block">
                            <input type="hidden" name="order">
                            <button name="submit" type="submit" class="btn btn-sm btn-outline-danger">delete</button>
                        </form>
                </table>
            </div>
        </div>
    </div>
</body>

</html>