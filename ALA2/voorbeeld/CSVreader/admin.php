<?php
include("config.php");
session_start();

function getTable($table){
    global $conn;

    $sql = "SELECT id, `name` FROM $table";
    $query = $conn->prepare($sql);
    try{
        $query->execute();
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $result = $query->fetchAll();

       return $result;
    }

    catch(PDOException $e) {
        echo "<script>console.log(\"No results found: " .$e->getMessage() . "\")</script>";
    }
}

function create($table, $value, $brand = null){
    global $conn;

    $sqlInsert = "INSERT INTO $table (`name`) VALUES (:val)";
    $sql = $conn->prepare($sqlInsert);
    $sql->bindParam(':val', $value);
    try{
        $sql->execute();
    }

    catch(PDOException $e) {
        echo "<script>console.log(\"No results found: " .$e->getMessage() . "\")</script>";
    }
}

function update($table, $old, $new){
    global $conn;

    $sqlUpdate = "UPDATE $table SET `name` = :new WHERE id = :old";
    $sql = $conn->prepare($sqlUpdate);
    $sql->bindParam(':old', $old);
    $sql->bindParam(':new', $new);
    try{
        $sql->execute();
    }

    catch(PDOException $e) {
        echo "<script>console.log(\"No results found: " .$e->getMessage() . "\")</script>";
    }
}

function delete($table, $value){
    global $conn;

    $sqlDelete ="DELETE FROM $table WHERE id = ?";
    $sql = $conn->prepare($sqlDelete);
    try{
        $sql->execute(array($value));
    }

    catch(PDOException $e) {
        echo "<script>console.log(\"No results found: " .$e->getMessage() . "\")</script>";
    }
}

if(isset($_POST['addName']) && !empty($_POST['addName']) && !empty($_POST['addBrand'])){
    create($_SESSION['table'], $_POST['addName'], $_POST['addBrand']);
} else if(isset($_POST['addName']) && !empty($_POST['addName'])){
    create($_SESSION['table'], $_POST['addName']);
}

if(isset($_POST['edit']) && !empty($_POST['edit']) && isset($_POST['new']) && !empty($_POST['new'])){

    update($_SESSION['table'], $_POST['edit'], $_POST['new']);
}

if(isset($_POST['delete']) && !empty($_POST['delete'])){
    delete($_SESSION['table'], $_POST['delete']);
}

?>

<!DOCTYPE html>
<html>

<body>
<?php
echo "<h1>" . $_SESSION['type'] . "</h1>";

    if($_SESSION['type'] === 'Toevoegen'){?>
        <form method="POST">
            <label>Naam</label> <br/>
            <input type="text" name='addName'> <br/>
            <label>Merk (optioneel)</label> <br/>
            <input type="text" name='addBrand'> <br/>
            <br/>
            <input type='submit' name="submit">
        </form>
    <?php } else if($_SESSION['type'] === 'Aanpassen'){?>
        <form method="POST">
            <select name='edit'>
                <option>Selecteer item om aan te passen</option>
                <?php
                $tables = getTable($_SESSION['table']);
                foreach($tables as $table){
                    echo "<option value=".$table['id'].">".$table['name']."</option>";
                }
                ?>
            </select>
            <br/>
            <label>Pas het item aan</label>
            <br/>
            <input type='text' name="new">
            <br/>
            <input type='submit' name="submit">
        </form>
    <?php } else if($_SESSION['type'] === 'Verwijderen'){?>
        <form method="POST">
            <select name='delete'>
                <option>Selecteer item om te verwijderen</option>
                <?php
                $tables = getTable($_SESSION['table']);
                foreach($tables as $table){
                    echo "<option value=".$table['id'].">".$table['name']."</option>";
                }
                ?>
            </select>
            <input type='submit' name="submit">
        </form>
    <?php }
?>

<a href='index.php'>Terug</a>

</body>

</html>