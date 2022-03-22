<?php

$servername = "localhost";
$username = "root";
$password = "";

try {
  $pdo = new PDO("mysql:host=$servername;dbname=netfish_db", $username, $password);
  // set the PDO error mode to exception
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  echo "<script>console.log('Connected successfully');</script>";
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}
//check if session has already started

if(session_id() == '' || !isset($_SESSION) || session_status() === PHP_SESSION_NONE) {
  session_start();
}

//if there is no session loggedIn, set automatically to false   
if(!isset($_SESSION['loggedIn'])){
  $_SESSION['loggedIn'] = false;
}

//funtion voor het prepare executen van de sql query
function sqlHandler($sql){
  global $pdo;

  $statement = $pdo->prepare($sql);
  $statement->setFetchMode(PDO::FETCH_ASSOC);
  $statement->execute();
  return $statement->fetchAll();
};

?>