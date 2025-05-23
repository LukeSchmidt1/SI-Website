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
EOT;
    if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn']) {
        echo <<<EOT
        <td>
            <form method='POST' action='deleteLeader.php'>
                <input type='hidden' name='id' value='{$item['Id']}' />
                <button type='submit' class='btn btn-danger btn-sm'>Delete</button>
            </form>
        </td>
EOT;
    }
    echo <<<EOT
    </tr>
EOT;
}
?>
