<?php session_start();
include 'config.php';

include 'menuItem.php';

//Setting $_SESSION['orderList'] as an array, using an if statement with empty to prevent it being null.
if(empty($_SESSION['orderList'])){
    $_SESSION['orderList'] = [];
}

$products;
$specs;
$stores;
$latestOrderId;

//Setting $products as an array, using an if statement with empty to prevent it being null.
if(empty($products)){
    $products = [];
} 

//Setting $spec as an array, using an if statement with empty to prevent it being null.
if(empty($spec)){
    $spec = [];
}

//Setting $stores as an array, using an if statement with empty to prevent it being null.
if(empty($stores)){
    $stores = [];
}

//Preparing and executing query to retrieve all specialisations from the Database.
$query = "SELECT * FROM sopranos_db.specialisations";

    $result = $conn->prepare($query);
    try{
        $result->execute();
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $results= $result->fetchAll();

        //If there are results, foreach loop through the results and put all data in $spec.
        if($results){
            foreach($results as $item){
                if(!$spec){
                    $spec = [$item];
                } else {
                    array_push($spec, $item);
                }
           }
        }
        
    }

    catch(PDOException $e) {
        echo "<script>console.log(\"No results found: " .$e->getMessage() . "\")</script>";
    }

    //Preparing and executing query to retrieve all products from the Database.
    $queryProducts = "SELECT * FROM sopranos_db.products";

    $result = $conn->prepare($queryProducts);
    try{
        $result->execute();
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $results= $result->fetchAll();

        //If there are results, using a for loop to match the product key name with results key name.
        if($results){
            for($i = 0; $i < count($results); $i++){
                    $products[$i] = $results[$i];
            }           
        }
    }

    catch(PDOException $e) {
        echo "<script>console.log(\"No results found: " .$e->getMessage() . "\")</script>";
    }

    //Using foreach loop through $products to dynamicly create objects from the class MenuItem.
    foreach($products as $product){
       ${'pizza'.$product['id']} = new MenuItem ($product['id'], $product['name'], $product['description'], $product['price'], $spec);
    }

    //Preparing and executing query to retrieve all stores from the Database.
    $queryStores = "SELECT id, locationName FROM sopranos_db.stores";

    $result = $conn->prepare($queryStores);
    try{
        $result->execute();
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $results= $result->fetchAll();

        //Same strategy used as line 67
        if($results){
            for($i = 0; $i < count($results); $i++){
                $stores[$i] = $results[$i];
            }
        }
    }

    catch(PDOException $e) {
        echo "<script>console.log(\"No results found: " .$e->getMessage() . "\")</script>";
    }

    //Preparing and executing query to get the latest order added to the Database.
    $queryLatestOrder = "SELECT id FROM sopranos_db.orders ORDER BY id DESC LIMIT 0, 1";

    $result = $conn->prepare($queryLatestOrder);
    try{
        $result->execute();
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $results= $result->fetchAll();

        //Results being assigned to a global scoped variable
        $latestOrderId = $results['0']['id'];

        //Due to the script being too fast for the data to reach the database, staticly adding +1 to the latest order so the ordered_products are given the right order id.
        $latestOrderId += 1;
    }

    catch(PDOException $e) {
        echo "<script>console.log(\"No results found: " .$e->getMessage() . "\")</script>";
    }

    //If a product has been ordered via post, add it to $_SESSION['orderList'] array.
    if(isset($_POST['productName'])){
        array_push($_SESSION['orderList'], $_POST);
    }

    //Calculate the total price of all ordered products.
    function calcPrice(){
        $total = 0;

        if(isset($_SESSION['orderList']) && !empty($_SESSION['orderList'])){
            for($i = 0; $i < count($_SESSION['orderList']); $i++){
                $total += $_SESSION['orderList'][$i]['price'];
            }
            //Print_r to print it on the page and sprintf being used to get 2 decimal numbers.
            print_r(sprintf("%.2f",$total, 2));
        }
    }

    //Function to dynamicly execute queries to send ordered product data to the database.
    function insertOrderedProducts(int $specId, int $prodId, int $orderId, float $price){
        global $conn;

        $queryInsertOrderedProduct = "INSERT INTO sopranos_db.ordered_products (specialisation_id, product_id, order_id, product_price)
        VALUES ('" . $specId . "', '" . $prodId . "', '" . $orderId . "', '" . $price . "')";

        $result = $conn->prepare($queryInsertOrderedProduct);
        try{
            $result->execute();
        }

        catch(PDOException $e) {
            echo "<script>console.log(\"No results found: " .$e->getMessage() . "\")</script>";
        }
    }

    //Function to controlled execute the former function and not create any lag or create any errors.
    function prepareInsert(){
        global $latestOrderId;
        if(isset($_SESSION['orderList']) && !empty($_SESSION['orderList'])){
            foreach($_SESSION['orderList'] as $product){
                insertOrderedProducts($product['spec'], $product['id'], $latestOrderId, $product['price']);
            }
        }
    }

    //Function to insert the order data into the Database to the order table.
    function insertOrder(string $email, float $price, int $storeId){
        global $conn;
        if($email && $price && $storeId){
           $queryInsertOrder = "INSERT INTO sopranos_db.orders (customer_email, price, store_id)
            VALUES ('". $email . "', '" . $price . "', '" . $storeId . "')";
        
            $result = $conn->prepare($queryInsertOrder);
            try{
                $result->execute();
                //Once the order has been added to the database, execute the prepareInsert.
                prepareInsert();
                //Once the products have been added to the database, wipe all session data.
                session_destroy();
            }

            catch(PDOException $e) {
                echo "<script>console.log(\"No results found: " .$e->getMessage() . "\")</script>";
            } 
        }  
    }

    //If statement to check if the customer has pressed 'Bestel'.
    if(isset($_POST['submit'])){
        insertOrder($_POST['email'], $_POST['totalPrice'], $_POST['store']);
    }
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sopranos Pizza</title>
    <link rel="stylesheet" type="text/css" href="../pages/assets/css/style.css">
</head>

<body>

    <div class='main'>
         <div class='menuBox'>
        <?php 
            $pizza1->render();
            $pizza2->render();
            $pizza3->render();
            $pizza4->render();
        ?>
        </div>

        <form method="POST" class="formOrder">
            <div class='contactBox'>
                <label class ='contactInput'>Email</label>
                <input class ='contactInput contactInputM' name='email' required>

                <label class ='contactInput'>Voor- en achternaam</label>
                <input class ='contactInput contactInputM' name='name' required>

                <label class ='contactInput'>Woonplaats</label>
                <input class ='contactInput contactInputM' name='city' required>

                <label class ='contactInput'>Pizzaria</label>
                <select class ='contactInput contactInputM' name='store' required>
                <option value=''>Kies een pizarria</option>
                <?php
                //Dynamicly create options for the stores in the database.
                foreach($stores as $option){
                    echo "<option value=".$option['id'].">" . $option['locationName'] . "</option>";
                }
                ?>
            </select>
            </div>

            <div class="orderBox">
                <div class='orderDisplay'>
                    <?php 
                    //Dynamicly echo all the ordered products from $_SESSION['orderList'].
                    if(isset($_SESSION['orderList']) && count($_SESSION['orderList']) > 0){
                        foreach($_SESSION['orderList'] as $item){
                            echo $item['productName'] . '  €' . $item['price'] . '<br/>';
                        }
                    }
                    ?>
                    <label>Totaal prijs: </label> <input class='orderTotalPrice' name='totalPrice' value="<?php calcPrice(); ?>" readonly>
                </div>
            </div>
            
            <input class='formSubmit' name='submit' type="submit" value="Bestel">
        </form>
    </div>

</body>
</html>