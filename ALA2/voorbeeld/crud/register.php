<?php
session_start();

include("config.php");

//Als er gesubmit is, controleer of de wachtwoorden overeenkomen en stuur dan de data naar de database
if(isset($_POST['submit']) && !empty($_POST['submit'])){
    if($_POST['pass'] == $_POST['verify']){

        $pass = password_hash($_POST['pass'], PASSWORD_DEFAULT);

        $sql = "INSERT INTO user (username, email, `password`, is_admin)
        VALUES (:username, :email, :password, :admin)";

        $query = $conn->prepare($sql);
        $valueArray = ['username'=>$_POST['username'],'email'=>$_POST['email'], 'password'=>$pass, 'admin'=>0];

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

    <form class="form-center" method="POST">
        <label>Naam:
        <input class="font-black" type="text" name='name' required>
        </label>
        <br/>

        <label>Gebruikersnaam:
        <input class="font-black" type="text" name='username' required>
        </label>
        <br/>

        <label>E-mail adres:
        <input class="font-black" type="text" name='email' required>
        </label>
        <br/>

        <label>Wachtwoord:
        <input class="font-black" type="password" name='pass'>
        </label>
        <br/>
        
        <label>Wachtwoord ter controle:
        <input class="font-black" type="password" name='verify'>
        </label>
        <br/>
        <input type="submit" name='submit' class="submit-button" value="Registreer">
    </form>
</body>
</html>