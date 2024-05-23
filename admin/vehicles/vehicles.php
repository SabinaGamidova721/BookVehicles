<?php
include "../../blocks/connection.php";
$title = "Main Admin Panel";
$profpic = "../../back5.jpg";
include "../../blocks/header.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id"])) {
    $vehicleId = $_POST["id"];
    $is_available = isset($_POST["is_available"]) ? 1 : 0;
    $is_damaged = isset($_POST["is_damaged"]) ? 1 : 0;

    if ($is_available && $is_damaged) {
        $is_damaged = 0; 
    }

    $sql = "UPDATE vehicles SET is_available = :is_available, is_damaged = :is_damaged WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':is_available', $is_available, PDO::PARAM_BOOL);
    $stmt->bindParam(':is_damaged', $is_damaged, PDO::PARAM_BOOL);
    $stmt->bindParam(':id', $vehicleId, PDO::PARAM_INT);
    $stmt->execute();
}

$page = isset($_GET['page']) ? $_GET['page'] : 1;
$notes_on_page = 4;
$from = ($page - 1) * $notes_on_page;

$sql = "SELECT vehicles.*, 
               brands.title AS brand_title, 
               manufacturers.title AS manufacturer_title, 
               types.title AS type_title, 
               points.location AS point_location 
        FROM vehicles 
        JOIN brands ON vehicles.brand_id = brands.id 
        JOIN manufacturers ON vehicles.manufacturer_id = manufacturers.id 
        JOIN types ON vehicles.type_id = types.id 
        JOIN points ON vehicles.current_point = points.id 
        LIMIT $from, $notes_on_page";
$result = $conn->query($sql);
?>

<div class="container">
    <div class="content">
        <div class="col text-center">
            <h1>Vehicles panel</h1>
            <a href="brands/brands.php" class="btn btn-primary mb-4">Brands</a>
            <a href="manufacturers/manufacturers.php" class="btn btn-primary mb-4">Manufacturers</a>
            <a href="types/types.php" class="btn btn-primary mb-4">Types</a>
            <a href="points/points.php" class="btn btn-primary mb-4">Check Points</a>

            <table class="table table-hover table-sm">
                <tr>
                    <th>Id</th>
                    <th>Brand</th>
                    <th>Manufacturer</th>
                    <th>Type</th>
                    <th>Manufacturer year</th>
                    <th>Minute price</th>
                    <th>Current point</th>
                    <th>Is available</th>
                    <th>Is damaged</th>
                    <th></th>
                    <th></th>
                </tr>
                <?php
                $id = $from + 1;
                while($row = $result->fetch()){
                    echo "<tr>";
                    echo "<td>" . $id++ . "</td>";
                    echo "<td>" . htmlspecialchars($row["brand_title"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["manufacturer_title"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["type_title"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["manufacturer_year"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["minute_price"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["point_location"]) . "</td>";
                    echo "<td>
                            <form method='post' action=''>
                                <input type='hidden' name='id' value='" . htmlspecialchars($row["id"]) . "' />
                                <input type='checkbox' name='is_available' value='1' " . ($row["is_available"] ? "checked" : "") . " onchange='this.form.submit()' />
                            </form>
                          </td>";
                    echo "<td>
                            <form method='post' action=''>
                                <input type='hidden' name='id' value='" . htmlspecialchars($row["id"]) . "' />
                                <input type='checkbox' name='is_damaged' value='1' " . ($row["is_damaged"] ? "checked" : "") . " onchange='this.form.submit()' />
                            </form>
                          </td>";
                    echo "<td><a href='update.php?id=" . htmlspecialchars($row["id"]) . "' class='btn btn-outline-success'>Update</a></td>";
                    echo "<td>
                            <form action='delete.php' method='post'>
                                <input type='hidden' name='id' value='" . htmlspecialchars($row["id"]) . "' />
                                <input type='submit' value='Delete' class='btn btn-outline-danger'>
                            </form>
                          </td>";
                    echo "</tr>";
                }
                ?>
            </table>
            <?php
            $sql = "SELECT COUNT(*) as count FROM vehicles";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $count = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
            if($count == 0) {
                echo "<br><b>No records found</b><br>";
            } else {
                $pages_count = ceil($count / $notes_on_page);

                if($page != 1) {
                    $prev = $page - 1;
                    echo "<a href=\"?page=$prev\" class=\"pages arrow\"><<</a>";
                }

                for($i = 1; $i <= $pages_count; $i++) {
                    if($page == $i) {
                        echo "<a href=\"?page=$i\" class=\"pages active\">$i</a> ";
                    } else {
                        echo "<a href=\"?page=$i\" class=\"pages\">$i</a> ";
                    }
                }

                if($page != $pages_count) {
                    $next = $page + 1;
                    echo "<a href=\"?page=$next\" class=\"pages arrow\">>></a> ";
                }
            }
            ?>
            <br><br>

            <a href="new.php" class="btn btn-primary">New vehicle</a>
            <a href="../index.php" class="btn btn-warning">Return to main</a>
        </div>
    </div>
</div>

<?php
include "../../blocks/footer.php";
?>
