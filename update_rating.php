<?php
    include "blocks/connection.php"; 
    session_start();

    if(isset($_POST['rating']) && isset($_POST['commentId'])) {
        $rating = $_POST['rating'];
        $commentId = $_POST['commentId'];
        
        try {
            $conn->beginTransaction();
            $stmt = $conn->prepare("UPDATE comments SET rating = :rating WHERE id = :commentId");
            $stmt->bindParam(':rating', $rating, PDO::PARAM_INT);
            $stmt->bindParam(':commentId', $commentId, PDO::PARAM_INT);
            $stmt->execute();
            $conn->commit();
            echo 'Rating updated successfully';
        } catch (Exception $e) {
            $conn->rollback();
            echo 'Error updating rating: ' . $e->getMessage();
        }
    }
?>