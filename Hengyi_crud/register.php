<?php
session_start();

include("config.php");

//Als er gesubmit is, controleer of de wachtwoorden overeenkomen en stuur dan de data naar de database
if(isset($_POST['submit']) && !empty($_POST['submit'])){
    if($_POST['pass'] == $_POST['verify']){

        $pass = password_hash($_POST['pass'], PASSWORD_DEFAULT);

        $sql = "INSERT INTO user (username, email, `password`, is_admin)
        VALUES (:username, :email, :password, :admin)";

        $query = $pdo->prepare($sql);
        $valueArray = ['username'=>$_POST['username'],'email'=>$_POST['email'], 'password'=>$pass, 'admin'=>1];

        try{
            $query->execute($valueArray);
        }

        catch(PDOException $e) {
             echo "<script>console.log(\"Error: " .$e->getMessage() . "\")</script>";
        }
        
        echo "<script>location.href='login.php';</script>";
    } else {
        echo "De wachtwoorden komen niet overeen";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registreren - Netfish</title>

    <link link rel="stylesheet" type="text/css" href='./assets/styles.css'>
</head>

<body>
    <?php include_once("./view/navbar.php") ?>
    <div class="container">
            <form method="POST">

                <label>Naam: </label>
                <input class="form-control rounded-4" type="text" name='name' required>

                <br />

                <label>Gebruikersnaam: </label>
                <input class="form-control rounded-4" type="text" name='username' required>

                <br />

                <label>E-mail adres:</label>
                <input class="form-control rounded-4" type="text" name='email' required>
                <br />

                <label>Wachtwoord: </label>
                <input class="form-control rounded-4" type="password" name='pass'>

                <br />

                <label>Wachtwoord ter controle: </label>
                <input class="form-control rounded-4" type="password" name='verify'>

                <br />
                <input type="submit" name='submit' class="submit-button" value="Registreer">
            </form>
        </div>
</body>

</html>