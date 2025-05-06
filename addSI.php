<?php
session_start();

if (!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] !== true) {
    header("Location: login.php");
    exit();
}

require_once 'pageFormat.php';
require_once 'dbConnect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $class_name = htmlspecialchars(trim($_POST['class_name']));
    $session_time = htmlspecialchars(trim($_POST['session_time']));
    $session_location = htmlspecialchars(trim($_POST['session_location']));

    $pdo = connectDB();
    $stmt = $pdo->prepare("INSERT INTO `Sessions` (name, email, Class_name, Session_time, Session_location) 
                           VALUES (:name, :email, :class_name, :session_time, :session_location)");

    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':class_name', $class_name);
    $stmt->bindParam(':session_time', $session_time);
    $stmt->bindParam(':session_location', $session_location);

    if ($stmt->execute()) {
        header("Location: index.php");
        exit();
    } else {
        echo "<div class='alert alert-danger mt-3'>Error: Unable to add SI Leader.</div>";
    }
}
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Add SI Leader</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
  <link rel="stylesheet" href="./css/style.css">
</head>
<body>

  <div class="container">
    <?php pageHeader("Add SI Leader", "images/logo.png", "login"); ?>
  </div>

  <div class="form-wrapper">
    <h1 class="text-center mb-4">Add SI Leader Session</h1>

    <form id="addSIForm" action="addSI.php" method="POST">
      <div class="form-group mb-3">
        <label for="name">Leader's Name</label>
        <input type="text" class="form-control" id="name" name="name" placeholder="First Last" required>
        <div class="invalid-feedback" id="name-error"></div>
      </div>

      <div class="form-group mb-3">
        <label for="email">Leader's Email</label>
        <input type="email" class="form-control" id="email" name="email" placeholder="example@mail.com" required>
        <div class="invalid-feedback" id="email-error"></div>
      </div>

      <div class="form-group mb-3">
        <label for="class_name">Class Name</label>
        <input type="text" class="form-control" id="class_name" name="class_name" placeholder="Ex: CSCI 1000" required>
        <div class="invalid-feedback" id="class-name-error"></div>
      </div>

      <div class="form-group mb-3">
        <label for="session_time">Session Time</label>
        <select class="form-control" id="session_time" name="session_time" required>
          <option value="">Select a time</option>
          <option value="8:00-9:30">8:00-9:30</option>
          <option value="10:00-11:30">10:00-11:30</option>
          <option value="1:00-2:30">1:00-2:30</option>
          <option value="3:00-4:30">3:00-4:30</option>
          <option value="5:00-6:30">5:00-6:30</option>
          <option value="7:00-8:30">7:00-8:30</option>
        </select>
        <div class="invalid-feedback" id="session-time-error"></div>
      </div>

      <div class="form-group mb-4">
        <label for="session_location">Session Location</label>
        <input type="text" class="form-control" id="session_location" name="session_location" placeholder="Ex: ATK 309" required>
        <div class="invalid-feedback" id="session-location-error"></div>
      </div>

      <button type="submit" class="btn btn-primary w-100">Add SI Leader</button>
    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
  <script src="./js/validateSession.js"></script>
</body>
</html>
