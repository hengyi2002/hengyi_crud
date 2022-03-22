<?php
    include "header.php";

    $price = 0;
    $discount_total = 0;
    $subtotal = 0;
    $total_price = 0;

    function sqlHandler($sql){
        global $pdo;

        $statement = $pdo->prepare($sql);
        $statement->execute();
        return $statement->fetchAll();
    };

    // feching data from products
    $select_products = "SELECT * FROM products";
    $products = sqlHandler($select_products);

    $select_sizes = "SELECT * FROM sizes";
    $sizes = sqlHandler($select_sizes);


    // adding product to cart--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
    if(!isset($_SESSION["cart"])){
        $_SESSION["cart"] = [];
    };

    if(!isset($_SESSION["discount_total"])){
        $_SESSION["discount_total"] = 0;
    };

    if(isset($_POST["submit"])){
        $cartItem = [
            "productID"=>$_POST["product_id"],
            "sizeID"=>$_POST["size_id"]
        ];
        array_push($_SESSION["cart"], $cartItem);
    }
    
    // //laatste order form hier + sql injectie + mail aanmaken--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

    if(isset($_POST["order"])){
        //sql injectie
        // make sure if customer already exists
        global $pdo;

        $statement = $pdo->prepare("SELECT id FROM customers WHERE email = ?");
        $statement->execute([
            $_POST["email"]
        ]);
        $customer = $statement->fetchAll();
        $index2 = count($customer);
        
        if($index2 == 0) {
            $statement = $pdo->prepare("INSERT INTO `customers` (`name`, `address`, `city`, `phone_number`, `email`) VALUES (?, ?, ?, ?, ?)");
            $statement->execute([
                $_POST["name"],
                $_POST["address"],
                $_POST["city"],
                $_POST["phone_number"],
                $_POST["email"]
            ]);
        }else {
            // second select because now the customer is certain to exist
            $statement = $pdo->prepare("SELECT * FROM customers WHERE email = ?");
            $statement->execute([
                $_POST["email"]
            ]);
            $customer = $statement->fetchAll();
        }

        // insert a order --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
        $statement = $pdo->prepare("INSERT INTO `orders` (`location_id`, `customer_id`) VALUES (?, ?)");
        $statement->execute([
            $_POST["sopranos_location"],
            $customer[0]["id"]
        ]);

        // select an order based on the customer id
        $statement = $pdo->prepare("SELECT * FROM orders WHERE customer_id = ? ");
            $statement->execute([
                $customer[0]["id"]
            ]);
            $order = $statement->fetchAll();

        // for each loop to insert the products in to order items
        foreach ($_SESSION["cart"] as $product){
            $statement = $pdo->prepare("INSERT INTO `order_items` (`order_id`,`product_id`, `size_id`) VALUES (?,?,?)");
            $statement->execute([
            $order[0]["id"],
            $product["productID"],
            $product["sizeID"]
        ]);
        }
        //mail aanmaken--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
        session_destroy();
        unset($_SESSION["cart"]);
        unset($_SESSION["discount_total"]);
        header('Location: http://localhost/Jaar-2/Periode-3/ALA/index.php?order=complete');
        exit;
    };


?>

<main>
    <div class="album py-5 bg-light">
        <div class="container">
            <div class="row no-gutters">
                <div class="col-md-8">
                    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-2 g-3">
                        <?php foreach ($products as $product) { ?>
                        <div class="col">
                            <div class="card shadow-sm">
                                <svg class="bd-placeholder-img card-img-top" width="100%" height="225"
                                    xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Thumbnail"
                                    preserveAspectRatio="xMidYMid slice" focusable="false">
                                    <title><?php echo $product['name']; ?></title>
                                    <rect width="100%" height="100%" fill="#55595c" /><text x="50%" y="50%"
                                        fill="#eceeef" dy=".3em"><?php echo $product['name']; ?></text>
                                </svg>
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $product['name']; ?></h5>
                                    <p class="card-text"><?php echo $product['description']; ?></p>
                                    <!-- ------------->
                                    <form action="" method="post">
                                        <div class="input-group mb-5">
                                            <div class="input-group-prepend">
                                                <label class="input-group-text" for="inputGroupSelect01">Size</label>
                                            </div>
                                            <select class="custom-select" id="inputGroupSelect01" name="size_id">
                                                <?php foreach ($sizes as $size) {
                                                ?>
                                                <option value=<?php echo $size['id']; ?>>
                                                    <?php echo $size['name']; ?> </option>
                                                <?php
                                                } ?>
                                            </select>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="btn-group">
                                                <input type="hidden" name='product_id'
                                                    value="<?php echo $product['id']; ?>" />
                                                <input name="submit" type="submit" value="+">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <?php
                        } ?>
                    </div>
                </div>


                <!-- ----------------------------------------     cart items and discount       ------------------------------------------- -->
                <div class="col-md-4">
                    <div class="payment-info">
                        <div class="d-flex justify-content-between align-items-center">
                            <span>cart details</span><img class="rounded" src="..." width="30">
                        </div>
                        <?php
                        foreach ($_SESSION["cart"] as $product){

                                    // for each loop query var's 
                                    $products_query = "SELECT * from products WHERE id =".$product["productID"];
                                    $returned_product = sqlHandler($products_query);

                                    
                                    $size_query = "SELECT * from sizes WHERE id =".$product["sizeID"];
                                    $returned_size = sqlHandler($size_query);
                                    
                                    // price calculations
                                    if (isset($returned_product[0]["price"]) && isset($returned_size[0]["multiplier"])){
                                        $price_calc = sprintf("%.2f", round($returned_product[0]["price"] * $returned_size[0]["multiplier"], 2));
                                        $price = $price_calc;
                                        $subtotal += $price;
                                        
                                    };

                                ?>
                            <div class="d-flex justify-content-between align-items-center mt-3 p-2 items rounded">
                                <div class="d-flex flex-row">
                                    <div class="ml-2">
                                        <span class="font-weight-bold d-block">
                                            <?php 
                                                    echo $returned_product[0]["name"];
                                                ?>
                                        </span>
                                        <span class="spec">
                                            <?php 
                                                    echo $returned_size[0]["name"];
                                                ?>
                                        </span>
                                    </div>
                                </div>
                                <div class="d-flex flex-row align-items-center">
                                    <span class="d-block"></span>
                                    <span class="d-block ml-5 font-weight-bold">
                                        <?php
                                                echo "€".$price;
                                            ?>
                                    </span>
                                </div>
                            </div>
                            <?php
                        };?>
                    </div>
                    <?php
                        $index = count($_SESSION["cart"]) - 1;
                        If($index >= 1){
                            $_SESSION["discount_total"] +=  $price * 0.5;
                        };

                        if (isset($subtotal) && isset($_SESSION["discount_total"])){
                            $total_price = $subtotal - $_SESSION["discount_total"];
                        };
                    ?>
                    <hr class="line">
                    <div class="d-flex justify-content-between information">
                        <span>Subtotal</span><span>$<?php echo $subtotal; ?></span></div>
                    <div class="d-flex justify-content-between information">
                        <span>Discount</span><span>$<?php echo $_SESSION["discount_total"]; ?></span>
                    </div>
                    <div class="d-flex justify-content-between information">
                        <span>Total</span><span>$<?php echo $total_price; ?></span>
                    </div>
                    <button type="button" class="btn btn-primary" data-toggle="modal"
                        data-target=".bd-example-modal-lg">
                        <span>$<?php echo $total_price; ?></span><span>Checkout<i
                                class="fa fa-long-arrow-right ml-1"></i></span></button>



                    <!--  ----------------------------------------          form for customers     ----------------------------------- -->
                    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog"
                        aria-labelledby="myLargeModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Personal information form</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="" method="post">
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label label for="inputPassword4">Naam</label>
                                                <input type="name" class="form-control" id="inputPassword4"
                                                    placeholder="naam" name='name' required>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="inputEmail4">Email</label>
                                                <input type="email" class="form-control" id="inputEmail4"
                                                    placeholder="Email" name='email' required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputAddress">Adres</label>
                                            <input type="text" class="form-control" id="inputAddress"
                                                placeholder="1234 Kerkstraat" name='address' required>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="inputCity">stad</label>
                                                <input type="text" class="form-control" id="inputCity"
                                                    placeholder="stad" name='city' required>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="inputState">Locatie Sopranos </label>
                                                <select id="inputState" class="form-control" name='sopranos_location'>
                                                    <option selected value="1">Rotterdam</option>
                                                    <option value="2">Amsterdam</option>
                                                    <option value="3">Utrecht</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="inputZip">Telefoon nummer</label>
                                                <input type="text" class="form-control" id="inputZip"
                                                    placeholder="+31 6 12345678" name='phone_number' required>
                                            </div>
                                        </div>
                                        <input type="hidden" name='order_price' value="<?php echo $total_price; ?>" />
                                        <button type="submit" name="order" class="btn btn-primary">Confirm
                                            order</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>