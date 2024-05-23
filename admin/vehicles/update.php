<?php
    include "../../blocks/connection.php";
    $title = "Update vehicle";
    $profpic = "../../back5.jpg";
    include "../../blocks/header.php";

    if($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["id"])) {
        $vehicleid = $_GET["id"];

        $sql_for_brands = "SELECT id, title FROM brands ORDER BY title";
        $stmt_for_brands = $conn->query($sql_for_brands);
        $brandsList = $stmt_for_brands->fetchAll(PDO::FETCH_ASSOC);

        $sql_for_manufacturers = "SELECT id, title FROM manufacturers ORDER BY title";
        $stmt_for_manufacturers = $conn->query($sql_for_manufacturers);
        $manufacturerList = $stmt_for_manufacturers->fetchAll(PDO::FETCH_ASSOC);

        $sql_for_types = "SELECT id, title FROM types ORDER BY title";
        $stmt_for_types = $conn->query($sql_for_types);
        $typeList = $stmt_for_types->fetchAll(PDO::FETCH_ASSOC);

        $sql_for_points = "SELECT id, location FROM points ORDER BY location";
        $stmt_for_points = $conn->query($sql_for_points);
        $pointList = $stmt_for_points->fetchAll(PDO::FETCH_ASSOC);

        $sql = "SELECT * FROM vehicles WHERE id = :vehicleid";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(":vehicleid", $vehicleid);
        
         $stmt->execute();

        if($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $id_brand = $row["brand_id"];
            $id_type = $row["type_id"];
            $id_manufacturer = $row["manufacturer_id"];
            $year = $row["manufacturer_year"];
            $minute_price = $row["minute_price"];
            $id_point = $row["current_point"];

            echo "<br><br><br>
                <div class=\"container\">
                    <div class=\"content\">
                        <h3>Update vehicle</h3>
                        <form method='post'>
                            <input type='hidden' name='id_vehicle' value='$vehicleid' />
                            <p>Brand:
                            <select name='id_brand' class='form-control'>
                                <option value=''>Select brand...</option>";
            foreach ($brandsList as $brand) {
                $selected = ($brand['id'] == $id_brand) ? 'selected' : '';
                echo "<option value='" . $brand['id'] . "' $selected>" . $brand['title'] . "</option>";
            }
            echo "</select></p>
                <p>Type:
                <select name='id_type' class='form-control'>
                    <option value=''>Select type...</option>";
            foreach ($typeList as $type) {
                $selected = ($type['id'] == $id_type) ? 'selected' : '';
                echo "<option value='" . $type['id'] . "' $selected>" . $type['title'] . "</option>";
            }
            echo "</select></p>
                <p>Manufacturer:
                <select name='id_manufacturer' class='form-control'>
                    <option value=''>Select manufacturer...</option>";
            foreach ($manufacturerList as $manufacturer) {
                $selected = ($manufacturer['id'] == $id_manufacturer) ? 'selected' : '';
                echo "<option value='" . $manufacturer['id'] . "' $selected>" . $manufacturer['title'] . "</option>";
            }
            echo "</select></p>
                <p>Year:
                <input type='number' name='year' value='$year' class='form-control'/></p>
                <p>Minute Price:
                <input type='text' name='minute_price' value='$minute_price' class='form-control'/></p>
                <p>Point:
                <select name='id_point' class='form-control'>
                    <option value=''>Select point...</option>";
            foreach ($pointList as $point) {
                $selected = ($point['id'] == $id_point) ? 'selected' : '';
                echo "<option value='" . $point['id'] . "' $selected>" . $point['location'] . "</option>";
            }
            echo "</select></p>
                <div class=\"col text-center\"><input type='submit' value='Save' class='btn btn-warning'> </div>
                    </form></div></div>";
        } else {
            echo "Vehicle not found";
        }
    } elseif ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["id_vehicle"])) {

        $id_vehicle = $_POST["id_vehicle"];
        $id_brand = $_POST["id_brand"];
        $id_type = $_POST["id_type"];
        $id_manufacturer = $_POST["id_manufacturer"];
        $year = $_POST["year"];
        $minute_price = $_POST["minute_price"];
        $id_point = $_POST["id_point"];

        $sql = "UPDATE vehicles SET brand_id = :id_brand, type_id = :id_type, manufacturer_id = :id_manufacturer, manufacturer_year = :year, minute_price = :minute_price, current_point = :id_point WHERE id = :id_vehicle";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(":id_vehicle", $id_vehicle);
        $stmt->bindValue(":id_brand", $id_brand);
        $stmt->bindValue(":id_type", $id_type);
        $stmt->bindValue(":id_manufacturer", $id_manufacturer);
        $stmt->bindValue(":year", $year);
        $stmt->bindValue(":minute_price", $minute_price);
        $stmt->bindValue(":id_point", $id_point);

        if ($stmt->execute()) {
            echo "<br><h5 align='center'>" . "Vehicle successfully updated" . "</h5><br>";
            header("Location: vehicles.php");
        } else {
            echo "<br><h5 align='center'>" . "Error updating vehicle" . "</h5><br>";
        }
    } else {
        echo "Invalid request";
    }

    include "../../blocks/footer.php";
    echo "<br><br><br>";
?>

