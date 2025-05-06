<?php
session_start();
require_once 'dbConnect.php';
require_once 'pageFormat.php';

$search = isset($_POST['search']) ? $_POST['search'] : '';

if ($search == '') {
    $query = "SELECT * FROM `Sessions`";
    $params = []; 
} else {
    $query = "SELECT * FROM `Sessions` WHERE `name` LIKE :search";
    $params = ['search' => "%$search%"];  
}

$pdo = connectDB();
$stmt = $pdo->prepare($query);

$stmt->execute($params);
$results = $stmt->fetchAll();

foreach ($results as $item) {
    echo <<<EOT
    <tr>
        <td>{$item['name']}</td>
        <td>{$item['email']}</td>
        <td>{$item['Class_name']}</td>
        <td>{$item['Session_time']}</td>
        <td>{$item['Session_location']}</td>
    </tr>
EOT;
}
?>
