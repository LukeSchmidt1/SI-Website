<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
  </head>
  <body>
  <div class="container">
        <?php
            require_once('pageFormat.php');
            require_once('dbConnect.php');

            $pdo = connectDB();
            $query = "SELECT * FROM `Sessions`";
            $results = $pdo->query($query);
            $arr = $results->fetchAll();

            pageHeader("Home", "./images/logo.png", "login");
            
            echo <<<EOT
            <div class="my-3">
                <label for="searchInput" class="form-label">Search by Leader Name or Class Name:</label>
                <input type="text" id="searchInput" class="form-control d-inline-block w-50" placeholder="e.g., John or BIO 1107">
            </div>
            <div id="tableContainer">
EOT;
            showLeaders($arr);

            
            function showLeaders($arr)
            {
                echo <<<EOT
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

            foreach ($arr as $item) {
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
        EOT;
        }

        ?>
    </div>

    <!-- Now outside the PHP block, safe to load JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
  </body>
</html>
