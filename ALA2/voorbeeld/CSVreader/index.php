<?php
include('config.php');
session_start();

if(isset($_SESSION['reset']) && $_SESSION['reset'] === true){
    $_POST = array();
    session_unset();
}

if(isset($_POST['table']) && !empty($_POST['table'])){
    $_SESSION['table'] = $_POST['table'];
    if(isset($_POST['create'])){
        $_SESSION['type'] = $_POST['create'];
    } else if(isset($_POST['edit'])){
        $_SESSION['type'] = $_POST['edit'];
    } else if(isset($_POST['delete'])){
        $_SESSION['type'] = $_POST['delete'];
    }
    header("Location: admin.php");
}

$brands = [];
$tables = [];
$roles = [];

$getBrandsQuery = "SELECT * FROM brand";
$stmt = $conn->prepare($getBrandsQuery);
try{
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $result = $stmt->fetchAll();

    $brands = $result;
}

catch(PDOException $e) {
    echo "<script>console.log(\"No results found: " .$e->getMessage() . "\")</script>";
}

$getTables = "SHOW TABLES";
$sql = $conn->prepare($getTables);
try{
    $sql->execute();
    $sql->setFetchMode(PDO::FETCH_ASSOC);
    $result = $sql->fetchAll();
    
    foreach($result as $name){
        array_push($tables, $name['Tables_in_big_foot_bv']);
    }
}

catch(PDOException $e) {
    echo "<script>console.log(\"No results found: " .$e->getMessage() . "\")</script>";
}

$getRolesQuery = "SELECT * FROM roles";
$stmt = $conn->prepare($getRolesQuery);
try{
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $result = $stmt->fetchAll();

    $roles = $result;
}

catch(PDOException $e) {
    echo "<script>console.log(\"No results found: " .$e->getMessage() . "\")</script>";
}

 $page = $_SERVER['PHP_SELF'];
 $currentpage = 'Merk';
 $currentdir = ucwords(basename(dirname($page)));
 $topdir = basename(dirname(dirname($page)));

?>
<!DOCTYPE html>
<html>

<head>
    <title>Bigfoot bv</title>
    <link rel="stylesheet" type="text/css" href="./assets/styles.css">
</head>

<body>

<div id="nav">
	<ul>
		<li>
			<strong>Bigfoot BV</strong>
			<ul>
				<li>
					<a href="#"><?php echo $currentpage; ?></a>
			</li>
		</ul>

    <a id='loginLink' href='./login.php'>Login</a>
</div>

    <form method='POST'>
        <select id='brand' name='brand'>
            <option>Kies je merk</option>
            <?php
            foreach($brands as $brand){
                echo "<option value=".$brand['id'].">".$brand['name']."</option>";
            }
            ?>
    </select>
    <input type='submit' name='submit'>
    </form>
    <?php
        if(isset($_POST['brand']) && !empty($_POST['brand'])){
            $_SESSION['brand'] = $_POST['brand'];
        }

        if(!empty($_POST['submit'])){
            unset($_POST['submit']);
        }
        ?>
        <a href='./model/'>Volgende</a>

        <?php
        if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] === true){ ?>
           <div class='crud-block'>
            <form method='POST'>
                <select id='type' name='table'>
                    <option value=''>Kies data om te veranderen</option>
                    <?php 
                        switch($_SESSION['role']){
                            case 1:
                                echo "<option value=".$tables[0].">".$tables[0]."</option>";
                                break;
                            case 2:
                                echo "<option value=".$tables[1].">".$tables[1]."</option>";
                                break;
                            case 3:
                                echo "<option value=".$tables[2].">".$tables[2]."</option>";
                                break;
                            case 4:
                                foreach($tables as $table){
                                if($table != 'products' && $table != 'users' && $table != 'roles'){
                                echo "<option value=".$table.">".$table."</option>";
                                }
                            }
                        }
                        
                    ?>
                </select> <pre>
                <input type='submit' name='create' value='Toevoegen'><pre>
                <input type='submit' name='edit' value='Aanpassen'><pre>
                <input type='submit' name='delete' value='Verwijderen'>
            </form>
        </div> 
        <?php } ?>
        
</body>

</html>