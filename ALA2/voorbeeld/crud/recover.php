<?php
session_start();

include("config.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wachtwoord vergeten - Netfish</title>

    <link link rel="stylesheet" type="text/css" href='./assets/styles.css'>
</head>
<body>
    <?php include_once("navbar.php") ?>
    <!-- Voer email adres in voor email -->
    <form class="form-center" method="POST">
        <label>Gebruikersnaam of e-mail adres:</label>
        <input class="font-black" type="text" required>
        <br/>
        <input type="submit" class="submit-button" value="Reset">
    </form>
</body>
</html>