<?php
	include "../../blocks/connection.php";
	$title = "New vehicle";
	$profpic = "../../back5.jpg";
	include "../../blocks/header.php";

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
?>


<style>
  .checkbox-group {
      display: flex;
      align-items: center;
      margin-left: 76px; 
      margin-bottom: 20px; 
  }

  .checkbox-item {
      margin-right: 20px; 
  }
</style>


<div class="container mb-5">
    <div class="container mt-5">
        <div class="container mt-5">
            <div class="container">
                <div class="content">
                    <h1>Create new vehicle</h1>

                    <div class="col text-center">
                        <form method="post">
                            <select name="id_brand" class="form-control">
                                <option value="">Select brand...</option>
                                <?php foreach ($brandsList as $brand): ?>
                                    <option value="<?php echo $brand['id']; ?>"><?php echo $brand['title']; ?></option>
                                <?php endforeach; ?>
                            </select><br>

                            <select name="id_type" class="form-control">
                                <option value="">Select type...</option>
                                <?php foreach ($typeList as $type): ?>
                                    <option value="<?php echo $type['id']; ?>"><?php echo $type['title']; ?></option>
                                <?php endforeach; ?>
                            </select><br>

                            <select name="id_manufacturer" class="form-control">
                                <option value="">Select manufacturer...</option>
                                <?php foreach ($manufacturerList as $manufacturer): ?>
                                    <option value="<?php echo $manufacturer['id']; ?>"><?php echo $manufacturer['title']; ?></option>
                                <?php endforeach; ?>
                            </select><br>

                            <input type="number" name="year" placeholder="Enter manufacturer year..." min="1900" max="2024" required class="form-control"> <br>

                            <input type="number" name="minute_price" placeholder="Enter price for minute..." class="form-control"> <br>

                            <select name="id_point" class="form-control">
                                <option value="">Select point...</option>
                                <?php foreach ($pointList as $point): ?>
                                    <option value="<?php echo $point['id']; ?>"><?php echo $point['location']; ?></option>
                                <?php endforeach; ?>
                            </select><br>

                            <input type="submit" value="Save" class="btn btn-warning" name="but_add">
                        </form>
                    </div>
                    <br>

                    <?php
                    if (isset($_POST["but_add"])) {
                        $required_fields = ['id_brand', 'id_type', 'id_manufacturer', 'year', 'minute_price', 'id_point'];
                        $all_fields_filled = true;
                        
                        foreach ($required_fields as $field) {
                            if (empty($_POST[$field])) {
                                $all_fields_filled = false;
                                echo "Field $field is missing.<br>";
                            }
                        }
                        
                        if ($all_fields_filled) {
                            $id_brand = $_POST["id_brand"];
                            $id_type = $_POST["id_type"];
                            $id_manufacturer = $_POST["id_manufacturer"];
                            $year = intval($_POST["year"]);
                            $minute_price = floatval($_POST["minute_price"]);
                            $id_point = $_POST["id_point"];

                            try {
                                $sql = "INSERT INTO vehicles (brand_id, type_id, manufacturer_id, manufacturer_year,minute_price, current_point) VALUES (:id_brand, :id_type, :id_manufacturer, :year, :minute_price, :id_point)";
                                
                                $stmt = $conn->prepare($sql);
                                $stmt->bindParam(':id_brand', $id_brand);
                                $stmt->bindParam(':id_type', $id_type);
                                $stmt->bindParam(':id_manufacturer', $id_manufacturer);
                                $stmt->bindParam(':year', $year, PDO::PARAM_INT);
                                $stmt->bindParam(':minute_price', $minute_price, PDO::PARAM_INT);
                                $stmt->bindParam(':id_point', $id_point);

                                $stmt->execute();

                                if ($stmt->rowCount() > 0) {
                                    echo "<br><h5 align='center'>" . "Data successfully added" . "</h5><br>";
                                }
                            } catch (PDOException $e) {
                                echo "Database error: " . $e->getMessage();
                            }
                        } else {
                            echo 'Some fields are missing.';
                        }
                    }
                    ?>
                    <div class="col text-center">
                    	   <a href="vehicles.php" class="btn btn-primary">Return to vehicles</a>
                        <a href="../index.php" class="btn btn-primary">Return to main</a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<?php
require "../../blocks/footer.php";
?>
<br><br>
