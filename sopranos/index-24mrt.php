<?php 
  

  // woensdag
  // voeg prijzen toe aan de sizes
  // toon gekozen pizza in winkelwagen , gebruik size en pizzanaam 

  
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "sopranos-2021";

  try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Connected successfully";
  } catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
  }

  function sqlHandler($sql  ){
    global $conn;
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    return  $stmt->fetchAll();
  }
  


  $sql1 = "SELECT * FROM `pizza`";
  $pizzaArray = sqlHandler($sql1);

  $sql2 = "SELECT * FROM `sizes`";
  $sizesArray = sqlHandler($sql2);

  $sql = "select items.id , items.pizzaPrice, pizza.id as pizzaID, pizza.pizzaName, sizes.name as sizename 
      from items 
      inner join sizes 
      on items.sizeID = sizes.id 
      inner join pizza 
      on items.pizzaID = pizza.id";

    $itemsArray = sqlHandler($sql);


  session_start();

  
  if(!isset($_SESSION["cart"])){
    $_SESSION["cart"] = array();
  }

  if(isset($_POST["submit"])){

    $cartItem =  [ "itemID"=>$_POST["itemID"]
                  ] ;
    array_push($_SESSION["cart"], $cartItem);
  }

  if(isset($_POST["order"])){


  //   foreach($_SESSION["cart"] as $cartItem){
  //   $price = 450;
  //   $pizzaID = $cartItem['itemID'];


  //   //insent query to add to movie and bindValue to the query
  //   $sql = "INSERT INTO 'order_items' (id, itemID, date, price) 
  //           VALUES (NULL, :pizzeID, :NOW(), :price)";
  //   $stmt = $conn->prepare($sql);
  //   $stmt->execute(array(':pizzaID'=>$pizzaID,':price'=>$price ));
  //   }

    session_destroy();
    unset($_SESSION["cart"]);
  }

?>

<body>


  <?php foreach($pizzaArray as $value): ?>
    <form action="" method="post">
        <input name="pizzaID" type="text" hidden value="<?= $value['id'] ; ?>">
        
          
        <h3><?= $value['pizzaName'] ; ?></h3>
        <select name="itemID" id="">
            <?php 
            
                  foreach($itemsArray as $item){  
                    if($value['id'] == $item['pizzaID']){
                      echo "<option value='".$item['id']."'>". $item['id'] ." " .$item["sizename"] ." €" .$item["pizzaPrice"] ." </option>";
                    }
                  }
                
            ?>
            </select>
            <input name="submit" type="submit" class="submit" value="voeg toe">

    </form>
  <?php endforeach; ?>

  <div>
    <h3>Winkelwagen</h3>
    <form action="" method="post">
      <?php 
      //toon inhoud winkelwagen
      echo "<br>";
      // var_dump(json_encode($itemsArray));
      
      $cartArray = $_SESSION["cart"];

      foreach($cartArray as $cartItem){
        
        $key = array_search($cartItem["itemID"], array_column($itemsArray, 'id'));
        echo "<br>";
        
        echo $itemsArray[$key]["pizzaName"] . " [".$itemsArray[$key]["sizename"] ."]";
      }
      //var_dump($_SESSION["cart"]);
      

      ?>
      <br>
        <input name="order" type="submit" class="submit" value="Toevoegen">

    </form>
  </div>
</body>