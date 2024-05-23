<?php
    include "../../../blocks/connection.php";
    $title = "Delete confirmation";
    $profpic = "../../../back5.jpg";
    include "../../../blocks/header.php";

    if(isset($_POST['id'])) {
        $id = $_POST['id'];
    } else {
        echo "<div class='container'><div class='content'><div class='col text-center'><h3>Error: ID of the point not provided</h3></div></div></div>";
        include "../../../blocks/footer.php";
        exit();
    }
?>

<div class="container">
    <div class="content">
        <div class="col text-center">
            <form method="post">
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <h3>Enter phrase for delete confirmation: Hello World!</h3>
                <input type="text" name="confirmation_field" placeholder="Enter the phrase..." class='form-control'>
                <input type="submit" value="Done" class="btn btn-danger mt-3" name="but_del">
                <a href="points.php" class="btn btn-secondary mt-3">Return to points</a>
            </form>

<?php        
        if(isset($_POST["but_del"])) {
         if(isset($_POST["confirmation_field"]) && $_POST["confirmation_field"] == "Hello World!") {
 				try {
                    $sql = "DELETE FROM points WHERE id = :pointid";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindValue(":pointid", $_POST["id"]);
                    $stmt->execute();
                    header("Location: points.php");
                    exit();
                }
			    catch (PDOException $e) {
			        echo "Database error: " . $e->getMessage();
			    }

            } else {
                echo "<br><h5 style='color: red;'>Invalid phrase</h5>";
            }
        }
?>
        </div>
    </div>
</div>

<?php
    include "../../../blocks/footer.php";
?>