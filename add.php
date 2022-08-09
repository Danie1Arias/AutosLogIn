<?php
require_once "pdo.php";

session_start();

if ( ! isset($_SESSION['name']) ) {
    die('Not logged in');
  }

if ( isset($_POST['logout']) ) {

    header('Location: logout.php');
    return;
}

$failure = false;
$access = false;  

if ( isset($_POST['make']) && isset($_POST['year']) && isset($_POST['mileage']) ) {

    if ( strlen($_POST['make']) < 1 || strlen($_POST['year']) < 1 || strlen($_POST['mileage']) < 1 ) {

        $failure = "Make is required";

    } else if ( !is_numeric($_POST['mileage']) || !is_numeric($_POST['year']) ) {

                $failure = "Mileage and year must be numeric";

            } else {

                $sql = "INSERT INTO autos (make, year, mileage) VALUES (:make, :year, :mileage)";

                $stmt = $pdo->prepare('INSERT INTO autos
                        (make, year, mileage) VALUES ( :mk, :yr, :mi)');
                $stmt->execute(array(
                    ':mk' => $_POST['make'],
                    ':yr' => $_POST['year'],
                    ':mi' => $_POST['mileage'])
                    );

                $_SESSION["success"] = "Record inserted";
                header("Location: view.php");
                return;
                    
            }

}

?>

<!DOCTYPE html>
<html>
    <head>
    <title>Daniel Arias Cámara Autos Page 8364f022</title>
    <?php require_once "bootstrap.php"; ?>
</head>

<body>
<div class="container">
    <?php
        if ( isset($_SESSION['name'])) {

            echo "<h1>Tracking autos for  ";
            echo htmlentities($_SESSION['name']);
            echo "</h1>\n";
        }

        if ( $failure !== false ) {

        echo('<p style="color: red;">'.htmlentities($failure)."</p>\n");

        } 

        if ( $access !== false ) {

        echo('<p style="color: green;">'.htmlentities($access)."</p>\n");
    
        } 
            
    ?>

    <form method="post">
    <p>Make:
    <input type="text" name="make" size="60"></p>
    <p>Year:
    <input type="text" name="year"></p>
    <p>Mileage:
    <input type="text" name="mileage"></p>
    <input type="submit" value="Add"/>
    <input type="submit" name = "logout" value="Logout"/>
        
    </form>

</div>
</body>
