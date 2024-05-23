<?php
    include "../../../blocks/connection.php";
    $title = "Update check point";
    $profpic = "../../../back5.jpg";
    include "../../../blocks/header.php";

    if($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["id"])) {
        $pointid = $_GET["id"];
        
        $sql = "SELECT * FROM points WHERE id = :pointid";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(":pointid", $pointid);
        $stmt->execute();

        if($stmt->rowCount() > 0){
            foreach ($stmt as $row) {
                $location = $row["location"];
            }

            echo "<br><br><br>
            <div class=\"container\">
                <div class=\"content\">
            <h3>Update point</h3>
            <form method='post'>
                <input type='hidden' name='id' value='$pointid' />
                <p>Title:
                <input type='text' name='location' value='$location' class='form-control'/></p>";
                echo "<div class=\"col text-center\"><input type='submit' value='Save' class='btn btn-warning'> </div>
                    </form></div></div>";
        }
        else{
            echo "Point was not found";
        }
    }
    elseif (isset($_POST["location"])) {

        $sql = "UPDATE points SET location = :location WHERE id = :pointid";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(":pointid", $_POST["id"]);
        $stmt->bindValue(":location", $_POST["location"]);

        $stmt->execute();
        header("Location: points.php");
    }
    else{
        echo "Invalid data";
    }
    include "../../../blocks/footer.php";
    echo "<br><br><br>";
