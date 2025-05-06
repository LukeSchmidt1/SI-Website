<?php
session_start();
require_once 'dbConnect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];

    $pdo = connectDB();
    $stmt = $pdo->prepare("DELETE FROM `Sessions` WHERE `id` = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        $_SESSION['delete_success'] = true;
        header("Location: index.php");
        exit();
    } else {
        echo "Failed to delete session.";
    }
} else {
    echo "Invalid request.";
}
