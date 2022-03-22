<?php

//Als er nog geen log in in de Session is opgeslagen, wordt het automatisch op false gezet
if(!isset($_SESSION['loggedIn'])){
    $_SESSION['loggedIn'] = false;
}

?>
<!DOCTYPE html>
<html lang="en">

<header>
    <!-- adds navbar and bootstap link -->
    <?php include_once('./view/navbar.php') ?>
</header>

<body>
    <div class="container">
    <h1> Geen toegang</h1>
    <button class="btn btn-outline-secondary" onclick="window.location.href='./index.php'">terug naar index</button>
    </div>
</body>

</html>