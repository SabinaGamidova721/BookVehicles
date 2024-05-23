<?php
include "../../blocks/connection.php";
$title = "Main Admin Panel";
$profpic = "../../back5.jpg";
include "../../blocks/header.php";
?>

<div class="container">
    <div class="content">
        <div class="col text-center">
            <h1>All Orders</h1>
            <a href="user_orders.php" class="btn btn-primary mb-4">User orders</a>
            <a href="orders_by_filter.php" class="btn btn-primary mb-4">Orders by filters</a>

            <?php
            try {

                if(isset($_GET['page'])) {
                    $page = $_GET['page'];
                } else {
                    $page = 1;
                }
                $notes_on_page = 3;
                $from = ($page - 1) * $notes_on_page;

                $sql = "SELECT o.*, u.email, v.brand_id, v.manufacturer_id, v.type_id, 
                               s.title as status_title, 
                               sp.location as start_location, ep.location as end_location
                        FROM orders o
                        JOIN userprofiles u ON o.userprofile_id = u.id
                        JOIN vehicles v ON o.vehicle_id = v.id
                        JOIN statuses s ON o.status_id = s.id
                        JOIN points sp ON o.startpoint = sp.id
                        JOIN points ep ON o.endpoint = ep.id 
                        WHERE u.is_admin = false
                        ORDER BY o.startdate 
                        LIMIT $from, $notes_on_page";
                $stmt = $conn->prepare($sql);
                $stmt->execute();

                $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
                    
                    $id = $from + 1;
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
                    echo "No orders found.";
                }
            } catch (PDOException $e) {
                echo "Database error: " . $e->getMessage();
            }

            $sql = "SELECT COUNT(*) as count FROM orders o 
                    JOIN userprofiles u ON o.userprofile_id = u.id
                    WHERE u.is_admin = false";

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
            <br>
            <a href="../index.php" class="btn btn-warning mt-3">Return to main</a>

        </div>
    </div>
</div>

<?php
    include "../../blocks/footer.php";
?>

