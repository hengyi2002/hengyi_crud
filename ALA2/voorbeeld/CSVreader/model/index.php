<?php
include('../config.php');
session_start();

$models = [];

if(isset($_SESSION['brand']) && !empty($_SESSION['brand'])){
   $getModelsQuery = "SELECT `id`, `name` FROM model WHERE `brand` = ?";
    $stmt = $conn->prepare($getModelsQuery);
    try{
        $stmt->execute(array($_SESSION['brand']));
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $result = $stmt->fetchAll();

        $models = $result;
    }

    catch(PDOException $e) {
        echo "<script>console.log(\"No results found: " .$e->getMessage() . "\")</script>";
    } 
}


 $page = $_SERVER['PHP_SELF'];
 $currentpage = 'Model';
 $currentdir = 'Merk';

?>
<!DOCTYPE html>
<html>

<head>
    <title>Bigfoot bv</title>
    <link rel="stylesheet" type="text/css" href="../assets/styles.css">
</head>

<body>

<div id="nav">
	<ul>
		<li>
			<strong>Bigfoot BV</strong>
			<ul>
				<li>
					<a href="../"><?php echo $currentdir; ?></a>
						<ul>
						    <li>
									<a href="#"><?php echo $currentpage; ?></a>
								</li>
							</ul>
					</li>
				</ul>
			</li>
		</ul>
</div>


<form method='POST'>
        <select id='model' name='model'>
            <option value=''>Kies je model</option>
            <?php
            foreach($models as $model){
                echo "<option value=".$model['id'].">".$model['name']."</option>";
            }
            ?>
    </select>
    <input type='submit' name='submit'>
    </form>
    <?php
        if(isset($_POST['model']) && !empty($_POST['model'])){
            $_SESSION['model'] = $_POST['model'];
        }

        if(!empty($_POST['submit'])){
            unset($_POST['submit']);
        }
        ?>
        <a href='./size/'>Volgende</a>

</body>

</html>