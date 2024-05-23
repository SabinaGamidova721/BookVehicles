<?php
    include "../../blocks/connection.php";
    $title = "Delete confirmation";
    $profpic = "../../back5.jpg";
    include "../../blocks/header.php";

    if(isset($_POST['id'])) {
        $id = $_POST['id'];
    } else {
        echo "<div class='container'><div class='content'><div class='col text-center'><h3>Error: ID of the admin not provided</h3></div></div></div>";
        include "../../blocks/footer.php";
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
                <a href="admins.php" class="btn btn-secondary mt-3">Return to admins</a>
            </form>

<?php        
        if(isset($_POST["but_del"])) {
         if(isset($_POST["confirmation_field"]) && $_POST["confirmation_field"] == "Hello World!") {
 				try {
                    //$sql = "DELETE FROM userprofiles WHERE id = :userid AND is_admin = false";
                    
                    // $sql = "UPDATE userprofiles SET is_deleted = 1 WHERE id = :userid AND is_admin = false;";
                    // $stmt = $conn->prepare($sql);
                    // $stmt->bindValue(":userid", $_POST["id"]);
                    // $stmt->execute();
                    // header("Location: users.php");
                    // exit();
                    $sql = "SELECT is_deleted FROM userprofiles WHERE id = :userid AND is_admin = false";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindValue(":userid", $_POST["id"]);
                    $stmt->execute();
                    $result = $stmt->fetch(PDO::FETCH_ASSOC);

                    if ($result) {
                        if ($result['is_deleted'] == 0) {
                            $sqlUpdate = "UPDATE userprofiles SET is_deleted = 1 WHERE id = :userid AND is_admin = false";
                            $stmtUpdate = $conn->prepare($sqlUpdate);
                            $stmtUpdate->bindValue(":userid", $_POST["id"]);
                            $stmtUpdate->execute();
                        } else {
                            $sql = "DELETE FROM userprofiles WHERE id = :userid AND is_admin = false";
                            $stmt = $conn->prepare($sql);
                            $stmt->bindValue(":userid", $_POST["id"]);
                            $stmt->execute();
                        }
                        header("Location: users.php");
                        exit();
                    } else {
                        echo "<br><h5 style='color: red;'>User not found or is an admin.</h5>";
                    }
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
    include "../../blocks/footer.php";
?>