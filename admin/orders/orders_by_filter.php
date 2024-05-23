<?php
    include "../../blocks/connection.php";
    $title = "Orders by Filter";
    $profpic = "../../back5.jpg";
    include "../../blocks/header.php";

    function getValues($conn, $table) {
        $sql = "SELECT id, title FROM $table";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function getOrdersByFilter($conn, $filter, $filter_value) {
        $sql = "SELECT o.*, u.email, v.brand_id, v.manufacturer_id, v.type_id, 
                       s.title as status_title, 
                       sp.location as start_location, ep.location as end_location
                FROM orders o
                JOIN userprofiles u ON o.userprofile_id = u.id
                JOIN vehicles v ON o.vehicle_id = v.id
                JOIN statuses s ON o.status_id = s.id
                JOIN points sp ON o.startpoint = sp.id
                JOIN points ep ON o.endpoint = ep.id
                WHERE $filter = :filter_value AND u.is_admin = false
                ORDER BY o.startdate";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':filter_value', $filter_value, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    $types = getValues($conn, 'types');
    $manufacturers = getValues($conn, 'manufacturers');
    $brands = getValues($conn, 'brands');
    $statuses = getValues($conn, 'statuses');
?>

<div class="container">
    <div class="content">
        <div class="col text-center">
            <h1>Orders by Filter</h1>
            <form method="post" action="orders_by_filter.php">
                <div class="form-group">
                    <select name="filter" class="form-control" id="filter">
                        <option value="">Select Filter</option>
                        <option value="type_id">Type</option>
                        <option value="manufacturer_id">Manufacturer</option>
                        <option value="brand_id">Brand</option>
                        <option value="status_id">Status</option>
                    </select>
                </div>
                <div class="form-group mt-3">
                    <select name="filter_value" class="form-control" id="filter_value">
                        <option value="">Select Value</option>
                        <?php foreach ($types as $type): ?>
                            <option class="type_id" value="<?php echo htmlspecialchars($type['id']); ?>">
                                <?php echo htmlspecialchars($type['title']); ?>
                            </option>
                        <?php endforeach; ?>
                        <?php foreach ($manufacturers as $manufacturer): ?>
                            <option class="manufacturer_id" value="<?php echo htmlspecialchars($manufacturer['id']); ?>">
                                <?php echo htmlspecialchars($manufacturer['title']); ?>
                            </option>
                        <?php endforeach; ?>
                        <?php foreach ($brands as $brand): ?>
                            <option class="brand_id" value="<?php echo htmlspecialchars($brand['id']); ?>">
                                <?php echo htmlspecialchars($brand['title']); ?>
                            </option>
                        <?php endforeach; ?>
                        <?php foreach ($statuses as $status): ?>
                            <option class="status_id" value="<?php echo htmlspecialchars($status['id']); ?>">
                                <?php echo htmlspecialchars($status['title']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <br>
                <input type="submit" value="Find" class="btn btn-warning" name="but_search">
            </form>
            <br>

            <?php
            if (isset($_POST["but_search"]) && isset($_POST["filter"]) && isset($_POST["filter_value"]) && !empty($_POST["filter"]) && !empty($_POST["filter_value"])) {

                $filter = $_POST["filter"];
                $filter_value = $_POST["filter_value"];
                $orders = getOrdersByFilter($conn, $filter, $filter_value);

                if ($orders) {
                    echo "<table class='table table-hover table-sm'>";
                    echo "<tr>
                            <th>Order ID</th>
                            <th>User Email</th>
                            <th>Brand</th>
                            <th>Manufacturer</th>
                            <th>Type</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Status</th>
                            <th>Start Point</th>
                            <th>End Point</th>
                            <th>Total Price</th>
                          </tr>";
                    $id = 1;
                    foreach ($orders as $order) {
                        echo "<tr>";
                        echo "<td>" . $id++ . "</td>";
                        echo "<td>" . htmlspecialchars($order['email']) . "</td>";
                        echo "<td>" . htmlspecialchars(getBrandName($conn, $order['brand_id'])) . "</td>";
                        echo "<td>" . htmlspecialchars(getManufacturerName($conn, $order['manufacturer_id'])) . "</td>";
                        echo "<td>" . htmlspecialchars(getTypeName($conn, $order['type_id'])) . "</td>";
                        echo "<td>" . htmlspecialchars($order['startdate']) . "</td>";
                        echo "<td>" . htmlspecialchars($order['enddate']) . "</td>";
                        echo "<td>" . htmlspecialchars($order['status_title']) . "</td>";
                        echo "<td>" . htmlspecialchars($order['start_location']) . "</td>";
                        echo "<td>" . htmlspecialchars($order['end_location']) . "</td>";
                        echo "<td>" . htmlspecialchars($order['total_price']) . "</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                } else {
                    echo "<b>No orders found for this filter</b><br><br>";
                }
        }

            function getBrandName($conn, $brand_id) {
                $sql = "SELECT title FROM brands WHERE id = :id";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':id', $brand_id, PDO::PARAM_INT);
                $stmt->execute();
                return $stmt->fetchColumn();
            }

            function getManufacturerName($conn, $manufacturer_id) {
                $sql = "SELECT title FROM manufacturers WHERE id = :id";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':id', $manufacturer_id, PDO::PARAM_INT);
                $stmt->execute();
                return $stmt->fetchColumn();
            }

            function getTypeName($conn, $type_id) {
                $sql = "SELECT title FROM types WHERE id = :id";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':id', $type_id, PDO::PARAM_INT);
                $stmt->execute();
                return $stmt->fetchColumn();
            }
            ?>

            <a href="orders.php" class="btn btn-primary">Return to orders</a>

        </div>
    </div>
</div>

<?php
    include "../../blocks/footer.php";
?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var filterSelect = document.querySelector('select[name="filter"]');
    var filterValueSelect = document.querySelector('select[name="filter_value"]');

    filterSelect.addEventListener('change', function() {
        var filter = this.value;
        filterValueSelect.querySelectorAll('option').forEach(function(option) {
            option.style.display = 'none';
        });
        if (filter) {
            filterValueSelect.querySelectorAll('.' + filter).forEach(function(option) {
                option.style.display = 'block';
            });
        }
        filterValueSelect.value = ''; 
    });

    filterSelect.dispatchEvent(new Event('change')); 
});
</script>