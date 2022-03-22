<?php
include("config.php");
session_start();

function checkUser($user, $pass){
    global $conn;

    $sql = "SELECT * FROM users WHERE email = ? AND `password` = ?";
    $query = $conn->prepare($sql);
    try{
        $query->execute(array($user, $pass));
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $result = $query->fetchAll();

        if($result != null){
           $_SESSION['user'] = $result[0]['username'];
           $_SESSION['role'] = $result[0]['role'];
           $_SESSION['loggedIn'] = true;

           header("Location: index.php");
        } else {
            echo "Error! Verkeerde email of wachtwoord";
        }
    }

    catch(PDOException $e) {
        echo "<script>console.log(\"No results found: " .$e->getMessage() . "\")</script>";
    }
}

if(isset($_POST['username']) && !empty($_POST['username']) && isset($_POST['password']) && !empty($_POST['password'])){
    checkUser($_POST['username'], $_POST['password']);
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Bigfoot bv</title>
    <link rel="stylesheet" type="text/css" href="./assets/styles.css">
</head>

<body>

    <form method="POST">
        <label>Email</label> <br/>
        <input type="text" name="username" required> <br/>
        <label>Wachtwoord</label> <br/>
        <input type="password" name="password" required> <br/> <br/>
        <input type="submit" name="submit">
    </form>

</body>

</html>