<?php
session_start();

include("config.php");

//Als de gebruiker is ingelogd en de gebruiker is een admin, wordt automatisch de view page ge include
if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == true && $_SESSION['admin'] == 1){
    if(isset($_GET["page"])){
        $page = $_GET["page"];
    }else{
        $page = "view";
    }

    if($page){
        include("./" . $page . ".php");
    }
} else {
    echo "U heeft geen toegang tot deze pagina";
}

    
?>