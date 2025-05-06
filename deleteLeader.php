<?php
require_once 'dbConnect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];
    
    $pdo = connectDB();
    $stmt = $pdo->prepare("DELETE FROM `Sessions` WHERE `id` = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    
    if ($stmt->execute()) {
        // Redirect back to index or return success
        header("Location: index.php");
        exit();
    } else {
        echo "Failed to delete leader.";
    }
} else {
    echo "Invalid request.";
}
