<?php

include("config.php");

// if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == true && $_SESSION['admin'] == 1){
//     header("Location: crud/movie_overview.php");
//     if(isset($_SESSION['user'])){
//         header("Location: ./movie_just_overview.php.php");
//     }
// } else {
    //Als er gesubmit is, controlleer of de ingevoerde username en password overeenkomen
if(isset($_POST['submit']) && !empty($_POST['submit'])){
    $user = $_POST['user'];
    $pass = htmlspecialchars($_POST['pass']);

    $sql = "SELECT * FROM user WHERE username = ?";
    $query = $pdo->prepare($sql);
    try{
        $query->execute(array($user));
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $result = $query->fetchAll();

        //Bij succes set Session user en admin naar username en naar is_admin. Zet Session login naar true
        if(count($result) == 1 && password_verify($pass, $result[0]['password'])){
            $_SESSION['user'] = $result[0]['username'];
            $_SESSION['admin'] = $result[0]['is_admin'];
            $_SESSION['loggedIn'] = true;

            header("Location: crud/movie_overview.php");
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
    <title>Log in </title>

    <link link rel="stylesheet" type="text/css" href='./assets/styles.css'>
</head>

<body>

    <?php include_once("./view/navbar.php") ?>
    <div class="modal modal-signin position-static d-block bg-secondary py-5" tabindex="-1" role="dialog"
        id="modalSignin">
        <div class="modal-dialog" role="document">
            <div class="modal-content rounded-5 shadow">
                <div class="modal-body p-5 pt-0">
                    <form class="form-center" method="POST">
                        <label>Gebruikersnaam:</label>
                        <input class="form-control rounded-4" name='user' type="text" required>
                        <label>Wachtwoord:</label>
                        <input class="form-control rounded-4" name='pass' type="password">

                        <br />
                        <input class="submit-button w-100 py-2 mb-2 btn btn-outline-secondary rounded-4" type="submit"
                            name="submit" class="submit-button" value="Login">
                        <a class="right no-deco" href="./register.php">Wachtwoord vergeten?</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>