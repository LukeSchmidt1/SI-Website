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
          <!-- Table will be dynamically populated here -->
          <table class="table table-striped table-bordered mt-4">
              <thead class="table-dark">
                  <tr>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Class</th>
                      <th>Time</th>
                      <th>Location</th>
                      <th>Action</th>
                  </tr>
              </thead>
              <tbody id="results">
                  <!-- Data rows will be inserted here dynamically via Ajax -->
EOT;

                  // Loop through results and output each row with a Delete button
                  foreach ($arr as $row) {
                      echo "<tr>";
                      echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                      echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                      echo "<td>" . htmlspecialchars($row['Class_name']) . "</td>";
                      echo "<td>" . htmlspecialchars($row['Session_time']) . "</td>";
                      echo "<td>" . htmlspecialchars($row['Session_location']) . "</td>";
                      echo "<td>
                              <form method='POST' action='deleteLeader.php' onsubmit=\"return confirm('Are you sure you want to delete this leader?');\">
                                <input type='hidden' name='id' value='" . $row['id'] . "' />
                                <button type='submit' class='btn btn-danger btn-sm'>Delete</button>
                              </form>
                            </td>";
                      echo "</tr>";
                  }

      echo <<<EOT
              </tbody>
          </table>
      </div>
      EOT;
    ?>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
  <script>
    document.getElementById('searchInput').addEventListener('input', function () {
        const query = this.value;
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'filterSessions.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function () {
            if (this.status === 200) {
                if (query === "") {
                    document.getElementById('results').innerHTML = this.responseText;
                } else {
                    document.getElementById('results').innerHTML = this.responseText;
                }
            }
        };
        xhr.send('search=' + encodeURIComponent(query));
    });

    window.onload = function() {
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'filterSessions.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function () {
            if (this.status === 200) {
                document.getElementById('results').innerHTML = this.responseText;
            }
        };
        xhr.send('search=');
    }
  </script>
</body>
</html>
