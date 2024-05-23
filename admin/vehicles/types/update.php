<?php
    include "../../../blocks/connection.php";
    $title = "Update type";
    $profpic = "../../../back5.jpg";
    include "../../../blocks/header.php";

    if($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["id"])) {
        $typeid = $_GET["id"];
        
        $sql = "SELECT * FROM types WHERE id = :typeid";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(":typeid", $typeid);
        
        $stmt->execute();

        if($stmt->rowCount() > 0){
            foreach ($stmt as $row) {
                $title = $row["title"];
            }

            echo "<br><br><br>
            <div class=\"container\">
                <div class=\"content\">
            <h3>Update type</h3>
            <form method='post'>
                <input type='hidden' name='id' value='$typeid' />
                <p>Title:
                <input type='text' name='title' value='$title' class='form-control'/></p>";
                echo "<div class=\"col text-center\"><input type='submit' value='Save' class='btn btn-warning'> </div>
                    </form></div></div>";
        }
        else{
            echo "Type was not found";
        }
    }
    elseif (isset($_POST["title"])) {

        $sql = "UPDATE types SET title = :title WHERE id = :typeid";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(":typeid", $_POST["id"]);
        $stmt->bindValue(":title", $_POST["title"]);

        $stmt->execute();
        header("Location: types.php");
    }
    else{
        echo "Invalid data";
    }
    include "../../../blocks/footer.php";
    echo "<br><br><br>";
