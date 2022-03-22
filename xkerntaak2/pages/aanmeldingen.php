<!DOCTYPE html>
<html lang="en">

<head>
    <?php include_once "includes/head.php"; ?>
    <link rel="stylesheet" href="styling/style.css" type="text/css">
</head>

<body>
    <div class="wrapperpx">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="mt-5 mb-3 clearfix">
                        <h2 class="pull-left" style="color:blue">Aanmeldingen</h2>
                        <a href="?page=handmatig" class="btn pull-right" style="background-color:#ff9623;"><i
                                class="fa fa-plus"></i> Nieuwe aanmelding</a>
                    </div>
                </div>
                <?php
                    // Include config file
                    require_once "config/crud.php";

                    $sql = "SELECT * FROM aanmelding INNER JOIN speler 
                    ON aanmelding.playerID=speler.ID INNER JOIN toernooi 
                    ON aanmelding.tournamentID=toernooi.ID;";
                    $results =  sqlHandler($sql);

                    // var_dump($results);
                    ?>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">title</th>
                            <th scope="col">#</th>

                        </tr>
                    </thead>
                    <?php foreach ($results as $i => $result) { ?>
                    <tbody>
                        <!-- foreach loop voor elke array in cart, haalt het op en toon de aan in een table -->
                        <tr>
                            <th scope="row"><?php echo $i + 1 ?></th>
                            <th><?php echo $result["callsign"] ?></th>
                            <th><?php echo $result["description"] ?></th>
                            <th>
                                <a href="crud/editplayer.php?id=<?php echo $result['ID'] ?>" class="mr-3" title="Speler Bewerken"
                                    data-toggle="tooltip"><span class="fa fa-pencil"></span></a>
                                <a href="crud/deleteplayer.php?id=<?php echo $result['ID'] ?>" title="Speler Verwijderen"
                                    data-toggle="tooltip"><span class="fa fa-trash"></span></a>
                            </th>
                        </tr>
                        <?php } ?>
                </table>
            </div>
        </div>
    </div>
    <script src="includes/js/functions.js"></script>
</body>

</html>