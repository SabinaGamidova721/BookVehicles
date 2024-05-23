<?php
    include "blocks/connection.php";
    $orderId = $_GET['order_id'];

    try {
        $stmt = $conn->prepare("SELECT id FROM statuses WHERE title = 'closed'");
        $stmt->execute();
        $statusId = $stmt->fetch(PDO::FETCH_ASSOC)['id'];

        $endDate = date('Y-m-d H:i:s');
        $stmt = $conn->prepare("UPDATE orders SET status_id = :statusId, enddate = :endDate WHERE id = :orderId");
        $stmt->bindParam(':statusId', $statusId, PDO::PARAM_INT);
        $stmt->bindParam(':endDate', $endDate, PDO::PARAM_STR);
        $stmt->bindParam(':orderId', $orderId, PDO::PARAM_INT);
        $stmt->execute();

        $stmt = $conn->prepare("SELECT * FROM orders WHERE id = :orderId");
        $stmt->bindParam(':orderId', $orderId, PDO::PARAM_INT);
        $stmt->execute();
        $order = $stmt->fetch(PDO::FETCH_ASSOC);

        $vehicleId = $order['vehicle_id'];
        $startDate = $order['startdate'];

        $stmt = $conn->prepare("SELECT minute_price FROM vehicles WHERE id = :vehicleId");
        $stmt->bindParam(':vehicleId', $vehicleId, PDO::PARAM_INT);
        $stmt->execute();
        $minutePrice = $stmt->fetch(PDO::FETCH_ASSOC)['minute_price'];
        //$minutePrice = $vehicle['minute_price'];

        // $startDateObj = new DateTime($startDate);
        // $endDateObj = new DateTime($endDate);
        // $interval = $endDateObj->diff($startDateObj);
        // //$interval2 = $startDateObj->diff($endDateObj);
        // $totalMinutes = ($interval->days * 24 * 60) + ($interval->h * 60) + $interval->i;

        $from_time = strtotime($startDate); 
        $to_time = strtotime($endDate); 
        //$diff_minutes = round(abs($from_time - $to_time) / 60,2). " minutes";
        $totalMinutes = ceil(round(abs($from_time - $to_time) / 60,2));

        $totalPrice = $totalMinutes * $minutePrice;

        $stmt = $conn->prepare("UPDATE orders SET total_price = :totalPrice WHERE id = :orderId");
        $stmt->bindParam(':totalPrice', $totalPrice);
        $stmt->bindParam(':orderId', $orderId, PDO::PARAM_INT);
        $stmt->execute();

        $stmt = $conn->prepare("UPDATE vehicles SET is_available = 1, current_point = :curpoint WHERE id = :vehicleId");
        $stmt->bindParam(':vehicleId', $vehicleId, PDO::PARAM_INT);
        $stmt->bindParam(':curpoint', $order["endpoint"], PDO::PARAM_INT);
        $stmt->execute();

    header("Location: all-user-orders.php");

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

