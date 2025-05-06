<?php
session_start();
require_once 'dbConnect.php';
require_once 'pageFormat.php';

$message = ""; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($name) || empty($email) || empty($password)) {
        $message = "<div class=\"alert alert-info mt-3\">All fields are required.</div>";
    } else {
        $shaPassword = sha1($password);

        try {
            $pdo = connectDB();
            $stmt = $pdo->prepare("INSERT INTO Leader (name, email, password) VALUES (?, ?, ?)");
            $stmt->execute([$name, $email, $shaPassword]);

            $message = "<div class=\"alert alert-info mt-3\">Account created successfully. You may now log in.</div>";
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) { 
                $message = "<div class=\"alert alert-info mt-3\">An account with this email already exists.</div>";
            } else {
                $message = "<div class=\"alert alert-info mt-3\">Error: " . $e->getMessage() . "</div>";
            }
        }
    }
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign Up</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/style.css">

  </head>
  <body>
    <div class="container">
        <?php
            pageHeader("Signup", "images/logo.png", "login");
        ?>

        <div class="row justify-content-center mt-4">
            <div class="col-md-6">
                <h1 class="text-center">Sign Up</h1>
                <?php if (!empty($message)): ?>
                    <?php echo $message; ?>
                <?php endif; ?>
                <div id="js-alert-placeholder"></div>
                <form action="signup.php" method="POST" class="p-4 border rounded bg-light mt-4" onsubmit="return validateSignupForm()">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="Enter your name" required>
                    </div>
                    <div class="form-group mt-3">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" class="form-control" placeholder="Enter your email" required>
                    </div>
                    <div class="form-group mt-3">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" class="form-control" placeholder="Enter your password" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block mt-4">Sign Up</button>
                </form>
            </div>
        </div>

        
    </div>

    <script src="./js/validateSignup.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>
