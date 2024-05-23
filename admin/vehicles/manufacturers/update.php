<?php
    include "../../../blocks/connection.php";
    $title = "Update manufacturer";
    $profpic = "../../../back5.jpg";
    include "../../../blocks/header.php";

    if($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["id"])) {
        $manufacturerid = $_GET["id"];
        
        $sql = "SELECT * FROM manufacturers WHERE id = :manufacturerid";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(":manufacturerid", $manufacturerid);
        
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
                <input type='hidden' name='id' value='$manufacturerid' />
                <p>Title:
                <input type='text' name='title' value='$title' class='form-control'/></p>";
                echo "<div class=\"col text-center\"><input type='submit' value='Save' class='btn btn-warning'> </div>
                    </form></div></div>";
        }
        else{
            echo "Manufacturer was not found";
        }
    }
    elseif (isset($_POST["title"])) {

        $sql = "UPDATE manufacturers SET title = :title WHERE id = :manufacturerid";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(":manufacturerid", $_POST["id"]);
        $stmt->bindValue(":title", $_POST["title"]);

        $stmt->execute();
        header("Location: manufacturers.php");
    }
    else{
        echo "Invalid data";
    }
    include "../../../blocks/footer.php";
    echo "<br><br><br>";
