<?php


//connection to database and header
include("config.php");
include_once('./view/navbar.php');

//Als er nog geen log in in de Session is opgeslagen, wordt het automatisch op false gezet
if(!isset($_SESSION["cart"])){
    $_SESSION["cart"] = array();
}

if(isset($_POST["submit"])){

    $cartItem =  [ 
                "movie_id"=>$_POST["movie_id"]
                  ] ;
    array_push($_SESSION["cart"], $cartItem);
}

if(isset($_POST["order"])){

    session_destroy();
    unset( $_SESSION["cart"]);
    echo ' session_destroy';
}


//select query that all from movie

$select_all_movie = "SELECT * FROM `movie`";
$movie = sqlHandler($select_all_movie);

?>
<!DOCTYPE html>
<html lang="en">


<body>
    <div class="container">
        <div class="row no-gutters">
            <div class="col-md-8">
                <br>
                <form>
                    <!-- <div class="input-group mb-2">
                        <input type="text" class="form-control" placeholder="search for movie's" name="search">
                        <button class="btn btn-outline-secondary" type="submit">Button</button>
                    </div> -->
                    </from>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">title</th>
                                <th scope="col">url</th>
                                <th scope="col">year</th>
                                <td>
                                <input type="button" class="button_active" value="confirm" onclick="location.href='confirm.php';" />
                                </td>
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
                                    <form method="post" action="" style="display: inline-block">
                                        <input type="hidden" name="movie_id" hidden value="<?php echo $movie['id'] ?>">
                                        <button name="submit" type="submit" class="btn btn-sm btn-outline-danger">voeg
                                            toe</button>
                                    </form>
                                </td>
                            </tr>
                            <?php } ?>
                    </table>

            </div>
            <div class="col-md-4">
                <div class="d-flex justify-content-between align-items-center">
                    <span>cart details</span>
                </div>
                <?php
                foreach ($_SESSION["cart"] as $movie){
                    
                        // for each loop query var's 

                        $select_movie = "SELECT * from movie WHERE id =".$movie['movie_id'];
                        $returned_movie =  sqlHandler($select_movie);

                    ?>
                <div class="d-flex justify-content-between align-items-center mt-3 p-2 items rounded">
                    <div class="d-flex flex-row">
                        <div class="ml-2">
                            <span class="font-weight-bold d-block">
                                <?php                                  
                                        echo $returned_movie[0]["title"];
                                        // var_dump($returned_movie[0]);
                                        
                                    ?>
                            </span>
                        </div>
                    </div>
                </div>
                <?php
                };?>
            </div>
        </div>
    </div>
</body>

</html>