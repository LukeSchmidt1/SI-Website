<?php
session_start();
require_once 'dbConnect.php';
require_once 'pageFormat.php';

$search = isset($_POST['search']) ? $_POST['search'] : '';

if ($search == '') {
    $query = "SELECT * FROM `Sessions`";
} else {
    $query = "SELECT * FROM `Sessions` WHERE `name` LIKE :search OR `Class_name` LIKE :search";
}

$pdo = connectDB();
$stmt = $pdo->prepare($query);

$stmt->execute(['search' => "%$search%"]);
$results = $stmt->fetchAll();

echo <<<EOT
<div class="container">
    <label for="toppings">Toppings:</label><br>
    <input type="text" id="toppings" onkeyup="searchByToppings(this)" name="toppings"><br><br>
    <p id="info"></p>
    <table class="table table-striped table-bordered mt-4">
        <thead class="table-dark">
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Class</th>
                <th>Time</th>
                <th>Location</th>
            </tr>
        </thead>
        <tbody>
EOT;

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

echo <<<EOT
        </tbody>
    </table>
</div>
EOT;
?>

<script type="text/javascript">

    document.getElementById('toppings').addEventListener('input', function () {
        const query = this.value;

        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'filterSessions.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        xhr.onload = function () {
            if (this.status === 200) {

                document.querySelector('table').innerHTML = this.responseText;
            } else {
                alert('Failed to fetch sessions.');
            }
        };
        xhr.send('search=' + encodeURIComponent(query));
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
