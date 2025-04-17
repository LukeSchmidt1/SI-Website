<?php
    session_start();
    if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn']) {
        echo "You are already logged in as " . $_SESSION['name'];
        die();
    }
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>Login</title>
  </head>
  <body>
    <div class="container">
    <?php
        require_once 'pageFormat.php';
        require_once 'dbConnect.php';
        pageHeader("Login", "images/logo.png", "login");
    ?>
    
    <div class="row justify-content-center"> 
    <h1 class="text-center">Login</h1>
        <div class="col-md-6">
            <form action="login.php" method="POST" class="p-4 border rounded bg-light">
                <div class="form-group">
                    <label for="email">Email address</label>
                    <input type="email" name="email" class="form-control" id="email" placeholder="Enter email">
                </div>
                <div class="form-group">
                    <label for="pwd">Password</label>
                    <input type="password" name="pwd" class="form-control" id="pwd" placeholder="Password">
                </div>
                <button type="submit" class="btn btn-primary btn-block">Submit</button>
            </form>
        </div>
    </div>

    <?php
        if (isset($_POST["email"])) {
            $email = $_POST["email"];
            $pwd = $_POST["pwd"];
            
            $pdo = connectDB();
            $query = "SELECT * FROM Leader WHERE email=:email AND password=SHA1(:pwd)";
            $stmt = $pdo->prepare($query);
            $stmt->execute(['email' => $email, 'pwd' => $pwd]);
            $arr = $stmt->fetchAll();

            if (count($arr) == 1) {
                $_SESSION['loggedIn'] = true;
                $_SESSION['name'] = $arr[0]['name']; 
                header('Location: index.php');
            } else {
                echo "<div class=\"alert alert-danger\" role=\"alert\">Incorrect Email or Password</div>";
            }
        }
    ?>
    </div>  
    
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>