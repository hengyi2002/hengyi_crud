<?php
include('../../config.php');
session_start();

$sizes = [];

if(isset($_SESSION['model']) && !empty($_SESSION['model'])){
    $getProductsQuery = "SELECT s.id, s.name FROM size s JOIN products p ON s.id = p.size_id WHERE p.model_id = ?";
    $stmt = $conn->prepare($getProductsQuery);
    try{
        $stmt->execute(array($_SESSION['model']));
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $result = $stmt->fetchAll();

        $sizes = $result;
    }

    catch(PDOException $e) {
        echo "<script>console.log(\"No results found: " .$e->getMessage() . "\")</script>";
    }
}

 $page = $_SERVER['PHP_SELF'];
 $currentpage = 'Maat';
 $currentdir = 'Model';
 $topdir = 'Merk';

?>
<!DOCTYPE html>
<html>

<head>
    <title>Bigfoot bv</title>
    <link rel="stylesheet" type="text/css" href="../../assets/styles.css">
</head>

<body>

<div id="nav">
	<ul>
		<li>
			<strong>Bigfoot BV</strong>
			<ul>
				<li>
					<a href="http://localhost/ALA/Bigfoot/test/">
					<?php echo ucwords($topdir); ?></a>
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
			</li>
		</ul>
</div>

<form method='POST'>
        <select id='size' name='size'>
            <option value=''>Kies je maat</option>
            <?php
            foreach($sizes as $size){
                echo "<option value=".$size['id'].">".$size['name']."</option>";
            }
            ?>
    </select>
    <input type='submit' name='submit'>
    </form>
    <?php
        if(isset($_POST['size']) && !empty($_POST['size'])){
            $_SESSION['size'] = $_POST['size'];
        }

        if(!empty($_POST['submit'])){
            unset($_POST['submit']);
            $_SESSION['reset'] = true;
        }
        ?>
        <a href='http://localhost/ALA/Bigfoot/test/'>Voeg toe aan winkelmandje</a>

</body>

</html>