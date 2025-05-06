<?php
session_start();
require_once('pageFormat.php');
require_once('dbConnect.php');
$pdo = connectDB();
$query = "SELECT * FROM `Sessions`";
$results = $pdo->query($query);
$arr = $results->fetchAll();
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Home</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <div class="container">
    <?php pageHeader("Home", "./images/logo.png", "login"); ?>

    <?php
    if (isset($_SESSION['delete_success']) && $_SESSION['delete_success']) {
        echo "<div class='alert alert-success'>Session deleted successfully.</div>";
        unset($_SESSION['delete_success']);
    }
    ?>

<div class="filter-container text-center">
  <label for="searchInput" class="form-label">🔍 Search by Leader Name</label>
  <input type="text" id="searchInput" class="form-control mt-2" placeholder="e.g., John Doe">
</div>


    <div id="tableContainer">
      <table class="table table-striped table-bordered mt-4">
        <thead class="table-dark">
          <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Class</th>
            <th>Time</th>
            <th>Location</th>
            <?php if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn']): ?>
              <th>Action</th>
            <?php endif; ?>
          </tr>
        </thead>
        <tbody id="results">
          <?php foreach ($arr as $row): ?>
            <tr>
              <td><?= htmlspecialchars($row['name']) ?></td>
              <td><?= htmlspecialchars($row['email']) ?></td>
              <td><?= htmlspecialchars($row['Class_name']) ?></td>
              <td><?= htmlspecialchars($row['Session_time']) ?></td>
              <td><?= htmlspecialchars($row['Session_location']) ?></td>
              <?php if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn']): ?>
                <td>
                  <form method="POST" action="deleteLeader.php">
                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                  </form>
                </td>
              <?php endif; ?>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Custom Confirmation Modal -->
  <div id="customConfirmModal" class="custom-modal-overlay">
    <div class="custom-modal">
      <p>Are you sure you want to delete this leader?</p>
      <div class="text-end">
        <button id="cancelDeleteBtn" class="btn btn-secondary me-2">Cancel</button>
        <button id="confirmDeleteBtn" class="btn btn-danger">Yes, Delete</button>
      </div>
    </div>
  </div>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
  <script src="js/fadeDelete.js"></script>
  <script>
    function refreshDeleteListeners() {
      if (typeof initDeleteListeners === "function") {
        initDeleteListeners();
      }
    }

    document.getElementById('searchInput').addEventListener('input', function () {
      const query = this.value;
      const xhr = new XMLHttpRequest();
      xhr.open('POST', 'filterSessions.php', true);
      xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
      xhr.onload = function () {
        if (this.status === 200) {
          document.getElementById('results').innerHTML = this.responseText;
          refreshDeleteListeners(); // reattach modal listeners
        }
      };
      xhr.send('search=' + encodeURIComponent(query));
    });

    window.onload = function () {
      const xhr = new XMLHttpRequest();
      xhr.open('POST', 'filterSessions.php', true);
      xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
      xhr.onload = function () {
        if (this.status === 200) {
          document.getElementById('results').innerHTML = this.responseText;
          refreshDeleteListeners(); // reattach modal listeners
        }
      };
      xhr.send('search=');
    };
  </script>
</body>
</html>
