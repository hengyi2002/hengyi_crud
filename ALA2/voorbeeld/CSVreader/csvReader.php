<?php

include("config.php");

if(($file = fopen("bigfoot-2021.csv", "r")) !== false){
    while(($data = fgetcsv($file, 1000, "%")) !== false){
        if(array(null) !== $data){
        $array[] = $data;
        }
    }

    fclose($file);
}

array_filter($array);

function dystectArray(){
    global $array;
    global $conn;
    $brandsArray = [];
    $modelsArray = [];
    $modelSizesArray = [];
    $sizesArray = [];

    $tableNames = $array[0];

    $length = count($array);

    for($i = 1; $i < $length; $i++){
        array_push($brandsArray, $array[$i][0]);
    }

    for($i = 1; $i < $length; $i++){
        array_push($modelsArray, [$array[$i][0], $array[$i][1]]);
    }

    for($i = 1; $i < $length; $i++){
        array_push($sizesArray, $array[$i][2]);
    }

    for($i = 1; $i < $length; $i++){
        array_push($modelSizesArray, [$array[$i][1], $array[$i][2]]);
    }

    $uniqueBrand = array_intersect_key($brandsArray, array_unique(array_map('strtolower', $brandsArray)));

    foreach($uniqueBrand as $brand){
        insert($tableNames[0], $brand);
    }

    $uniqueSize = array_intersect_key($sizesArray, array_unique(array_map('strtolower', $sizesArray)));

    foreach($uniqueSize as $size){
        insert($tableNames[2], $size);
    }
    
    //source: https://vijayasankarn.wordpress.com/2017/02/20/array_unique-for-multidimensional-array/
    $temp = array_unique(array_column($modelsArray, 1));
    $uniqueModel = array_intersect_key($modelsArray, $temp);

    foreach($uniqueModel as $model){
        insert($tableNames[1], $model[1], $model[0]);
    }

    foreach($modelSizesArray as $mosi){
        insertProduct($mosi[0], $mosi[1]);
    }
}

function getBrandId($brand){
    global $conn;

    $sqlGetBrand = "SELECT id FROM brand WHERE `name` LIKE ?";
        $stmt3 = $conn->prepare($sqlGetBrand);
        try{
          $stmt3->execute(array('%' . $brand));
          $stmt3->setFetchMode(PDO::FETCH_ASSOC);
          $result = $stmt3->fetchAll();

          return $result[0]['id'];
        }

        catch(PDOException $e) {
            echo "<script>console.log(\"No results found: " .$e->getMessage() . "\")</script>";
        }
}

function getModelId($model){
    global $conn;

    $sqlGetModel = "SELECT id FROM model WHERE `name` LIKE ?";
        $stmt = $conn->prepare($sqlGetModel);
        try{
          $stmt->execute(array('%' . $model));
          $stmt->setFetchMode(PDO::FETCH_ASSOC);
          $result = $stmt->fetchAll();

          return $result[0]['id'];
        }

        catch(PDOException $e) {
            echo "<script>console.log(\"No results found: " .$e->getMessage() . "\")</script>";
        }
}

function getSizeId($size){
    global $conn;

    $sqlGetSize = "SELECT id FROM size WHERE `name` LIKE ?";
        $stmt = $conn->prepare($sqlGetSize);
        try{
          $stmt->execute(array('%' . $size));
          $stmt->setFetchMode(PDO::FETCH_ASSOC);
          $result = $stmt->fetchAll();

          return $result[0]['id'];
        }

        catch(PDOException $e) {
            echo "<script>console.log(\"No results found: " .$e->getMessage() . "\")</script>";
        }
}

function insert($tableName, $val, $brand = null){
    global $conn;

    $brandId = '';

    if($brand !== null){
        $brandId = getBrandId($brand);
    }

    if($tableName === "brand"){
        $sql = "INSERT INTO brand (`name`) VALUES (:val)";
        $stmt1 = $conn->prepare($sql);
        $stmt1->bindParam(':val', $val);
        try{
            $stmt1->execute();
        }

        catch(PDOException $e) {
                echo "<script>console.log(\"Error: " .$e->getMessage() . "\")</script>";
        }

    } else if($tableName === "size"){
        $sql = "INSERT INTO size (`name`) VALUES (:val)";
        $stmt1 = $conn->prepare($sql);
        $stmt1->bindParam(':val', $val);
        try{
            $stmt1->execute();
        }

        catch(PDOException $e) {
                echo "<script>console.log(\"Error: " .$e->getMessage() . "\")</script>";
        }

    } else if($tableName === 'model'){
        $sql = "INSERT INTO model (`name`, `brand`) VALUES (:val, :brandId)";
        $stmt2 = $conn->prepare($sql);
        $stmt2->bindParam(':val', $val);
        $stmt2->bindParam(':brandId', $brandId);
        try{
            $stmt2->execute();
        }

        catch(PDOException $e) {
            echo "<script>console.log(\"Error: " .$e->getMessage() . "\")</script>";
        }
    }

}

function insertProduct($model, $size){
    global $conn;

    $modelId = getModelId($model);

    $sizeId = getSizeId($size);

    $sqlProducts = "INSERT INTO products (`model_id`, `size_id`) VALUES (:model, :size)";
    $stmt = $conn->prepare($sqlProducts);
    $stmt->bindParam(':model', $modelId);
    $stmt->bindParam(':size', $sizeId);
    try{
        $stmt->execute();
    }

    catch(PDOException $e) {
        echo "<script>console.log(\"Error: " .$e->getMessage() . "\")</script>";
    }
}


// dystectArray();
