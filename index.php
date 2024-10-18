<?php
  require_once('config/config.php');

  if (isset($_POST['log'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $qry = mysqli_query($conn, "SELECT * FROM login WHERE status ='1' AND  username='$username' and password='$password'") or die(mysqli_error($conn));

    $count = mysqli_num_rows($qry);

    if ($count == 1) {
      $result = mysqli_fetch_object($qry);
      session_start();

      $_SESSION['security_id'] = $result->id;
      $_SESSION['name'] = $result->username; 

      $mainId = $_SESSION['security_id']; 
      $mainName = $_SESSION['name'];

      $message = "Login Successfull";
      $color = "color:green";
      header("Location:dashboard.php");
      
    } else {
      $message = "Incorrect Username or Password!";
      $color = "color:red";
    }
  }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login Page</title>
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <!-- Css CDN -->
    <link rel="stylesheet" href="css/style.css">
  </head>
  <body>
    <div class="login-container">
      <div class="card">
        <p style="<?= $color; ?>;position: relative; top: -25px; left: 50px;"><?= $message; ?></p>
        <form id="loginForm" method="POST">
          <label for="username">Username</label>
          <div class="input-container">
            <i class="fas fa-user"></i>
            <input type="text" id="username" name="username" placeholder="Username" required/>
          </div>

          <label for="password">Password</label>
          <div class="input-container">
            <i class="fas fa-lock"></i> 
            <input type="password" id="password" name="password" placeholder="Password" required/>
            <i id="togglePassword" class="fas fa-eye toggle-password"></i>
          </div>

          <!-- <a href="#" class="forgot-password">Forgot Password?</a> -->
          <button class="btn" type="submit" name="log">Login</button>
        </form>
      </div>
    </div>

    <!-- Script CDN -->
    <script src="js/script.js"></script>

  </body>
</html>
