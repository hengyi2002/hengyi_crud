<!DOCTYPE html>
<html lang="en">

<head>
    <?php include_once "includes/head.php"; ?>
    <link rel="stylesheet" href="styling/style.css" type="text/css">
</head>

<body>
    <div class="wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="mt-5 mb-3 clearfix">
                        <h2 class="pull-left" style="color:blue">Spelers</h2>
                        <a href="crud/createplayer.php" class="btn pull-right" style="background-color:#ff9623;"><i
                                class="fa fa-plus"></i> Nieuwe Speler</a>
                    </div>
                    <input id="search" type="text" placeholder="Zoeken naar speler">
                    <?php

                    // Include config file
                    require_once "config/crud.php";

                    //select query voor het ophalen van array in cart  
                    $sql = "SELECT speler.ID, speler.callsign, speler.insertion, speler.lastname, speler.schoolID, school.name
                    FROM speler 
                    INNER JOIN school ON speler.schoolID=school.ID;";
                    $results =  sqlHandler($sql);

                    // var_dump($results);
                    ?>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">title</th>
                                <th scope="col">#</th>
                                <th scope="col">#</th>
                                <th scope="col">#</th>
                                <th scope="col">#</th>
                            </tr>
                        </thead>
                        <?php foreach ($results as $i => $result) { ?>
                        <tbody>
                            <!-- foreach loop voor elke array in cart, haalt het op en toon de aan in een table -->
                            <tr>
                                <th scope="row"><?php echo $i + 1 ?></th>
                                <th><?php echo $result["callsign"] ?></th>
                                <th><?php echo $result["insertion"] ?></th>
                                <th><?php echo $result["lastname"] ?></th>
                                <th><?php echo $result["name"] ?></th>
                                <th>
                                    <a href="crud/editplayer.php?id=<?php echo $result['ID'] ?>" class="mr-3"
                                        title="Speler Bewerken" data-toggle="tooltip"><span
                                            class="fa fa-pencil"></span></a>
                                    <a href="crud/deleteplayer.php?id=<?php echo $result['ID'] ?>" title="Speler Verwijderen"
                                        data-toggle="tooltip"><span class="fa fa-trash"></span></a>
                                </th>
                            </tr>
                            <?php } ?>
                    </table>
                </div>
            </div>
        </div>
    </body>
</html>