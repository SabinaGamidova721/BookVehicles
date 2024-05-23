<?php
    $email = "";
    include "../../blocks/connection.php";
    $title = "Search orders";
    $profpic = "../../back5.jpg";
    include "../../blocks/header.php";
?>

<br><br><br><br>
<div class="col text-center">
    <div class="container mt-5">
        <div class="content">
            <h1>Search orders by user</h1>

            <div class="col text-center">
                <form method="post">
                    <input type="email" name="email" value="<?php echo $email; ?>" placeholder="Enter email..." class="form-control"> <br>
                    <input type="submit" value="Find" class="btn btn-warning" name="but_search">
                </form>
            </div><br>

            <?php
            if ((isset($_POST["but_search"]) && isset($_POST["email"])) || isset($_GET['page'])) {
                if(isset($_POST["email"])) {
                    $email = $_POST["email"];
                } else {
                    $email = $_GET["email"];
                }
                
                if(isset($_GET['page'])) {
                    $page = $_GET['page'];
                } else {
                    $page = 1;
                }

                $notes_on_page = 4;
                $from = ($page - 1) * $notes_on_page;

                try {
                    $sql = "SELECT id FROM userprofiles WHERE email = :email AND is_admin = false";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                    $stmt->execute();

                    $user = $stmt->fetch(PDO::FETCH_ASSOC);

                    if ($user) {
                        $userid = $user['id'];

                        $sql = "SELECT o.*, u.email, v.brand_id, v.manufacturer_id, v.type_id, 
                                       s.title as status_title, 
                                       sp.location as start_location, ep.location as end_location
                                FROM orders o
                                JOIN userprofiles u ON o.userprofile_id = u.id
                                JOIN vehicles v ON o.vehicle_id = v.id
                                JOIN statuses s ON o.status_id = s.id
                                JOIN points sp ON o.startpoint = sp.id
                                JOIN points ep ON o.endpoint = ep.id
                                WHERE o.userprofile_id = :userid 
                                LIMIT $from, $notes_on_page";
                        $stmt = $conn->prepare($sql);
                        $stmt->bindParam(':userid', $userid, PDO::PARAM_INT);
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
                            echo "No orders found for this user";
                        }
                    }
                } catch (PDOException $e) {
                    echo "Database error: " . $e->getMessage();
                }

            $sql = "SELECT COUNT(*) as count FROM orders WHERE userprofile_id = :userid";

            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':userid', $userid, PDO::PARAM_INT);
            $stmt->execute();
            $count = $stmt->fetch(PDO::FETCH_ASSOC)['count'];

            if($count == 0) {
                echo "<br><b>No records found</b><br>";
            } else {
                $pages_count = ceil($count / $notes_on_page);
                
                if($page != 1) {
                    $prev = $page - 1;
                    echo "<a href=\"?page=$prev&email=$email\" class=\"pages arrow\"><<</a>";
                }

                for($i = 1; $i <= $pages_count; $i++) {
                    if($page == $i) {
                        echo "<a href=\"?page=$i&email=$email\" class=\"pages active\">$i</a> ";
                    } else {
                        echo "<a href=\"?page=$i&email=$email\" class=\"pages\">$i</a> ";
                    }
                }

                if($page != $pages_count) {
                    $next = $page + 1;
                    echo "<a href=\"?page=$next&email=$email\" class=\"pages arrow\">>></a> ";
                }
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
        <a href="orders.php" class="btn btn-primary mt-2">Return to orders</a>

        </div>
    </div>
</div>

<?php
    include "../../blocks/footer.php";
?>
