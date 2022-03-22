<?php
session_start();

include("config.php");

//Als er gesubmit is, controlleer of de ingevoerde username en password overeenkomen
if(isset($_POST['submit']) && !empty($_POST['submit'])){
    $user = $_POST['user'];
    $pass = htmlspecialchars($_POST['pass']);

    $sql = "SELECT * FROM user WHERE username = ?";
    $query = $conn->prepare($sql);
    try{
        $query->execute(array($user));
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $result = $query->fetchAll();

        //Bij succes set Session user en admin naar username en naar is_admin. Zet Session login naar true
        if(count($result) == 1 && password_verify($pass, $result[0]['password'])){
            $_SESSION['user'] = $result[0]['username'];
            $_SESSION['admin'] = $result[0]['is_admin'];
            $_SESSION['loggedIn'] = true;

            header("Location: index.php");
        } else {
            echo "Er is iets misgegaan, probeer het opnieuw";
        }
    }

    catch(PDOException $e) {
        echo "<script>console.log(\"No results found: " .$e->getMessage() . "\")</script>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log in - Netfish</title>

    <link link rel="stylesheet" type="text/css" href='./assets/styles.css'>
</head>
<body>
    <?php include_once("navbar.php") ?>

    <form class="form-center" method="POST">
        <label>Gebruikersnaam:
        <input class="font-black" name='user' type="text" required>
        </label>
        <br/>

        <label>Wachtwoord:
        <input class="font-black" name='pass' type="password">
        </label>
        <br/>
        <input class="submit-button" type="submit" name="submit" class="submit-button" value="Login">
        <a class="right no-deco" href="recover.php">Wachtwoord vergeten?</a>
    </form>
</body>
</html>