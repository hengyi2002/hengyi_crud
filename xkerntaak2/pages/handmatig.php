<?php
include_once('crud/functions.php');
require_once "config/crud.php";

// If user has submitted form run aanmeldingHandmatig() function
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    aanmeldingHandmatig();
}

?>

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
                    <h2 class="mt-5 text-primary">Aanmelden - Handmatig</h2>
                    <!-- Form to insert registration to database -->
                    <form method="POST" action="">
                        
                        <div class="form-group">
                            <label>Naam</label>
                            <!-- Select all players to fill dropdown -->
                            <select name="player">
                                <?php
                                $sql = "SELECT * FROM speler";
                                $results =  sqlHandler($sql);
                                foreach ($speler as $spelers) {
                                    // echo "<option value=\"{$row['ID']}\">{$row['callsign']} {$row['lastname']}</option>";
                                    // var_dump($results);
                                    ?>
                                    <option value="<?php echo $row['ID']; ?>"><?php echo $row['callsign']; echo ' '; echo $row['insertion']; echo ' '; echo $row['lastname']; ?></option>
                                    <?php
                                    } ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Toernooi</label>
                            <!-- Select all tournaments to fill dropdown -->
                            <select name="tournament">
                                <?php
                                $sql = "SELECT * FROM toernooi";
                                $results =  sqlHandler($sql);
                                while ($row = $results->fetch_assoc()) {
                                    echo "<option value=\"{$row['ID']}\">{$row['description']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <!-- Submit Form -->
                        <input type="submit" class="btn btn-primary" value="Aanmelden">
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>