<?php
require_once "DatabaseFunctions.php";
require_once "LoginFunctions.php";
startSession();
$dbConn = getConnection();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="styles.css" rel="stylesheet" type="text/css" />
    <!-- <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bulma@1.0.2/css/bulma.min.css"
    > -->
    <title>Login Page</title>
  </head>
  <body>
    <div class="login-page">
      <div class="container">
        <!-- Left Section -->
        <div class="left-section">
          <div class="logo">Logo</div>
          <h1>The Food Waste Management App</h1>
        </div>

        <!-- Login Form Section -->
        <div class="form-container">
          <h2>Login</h2>
          <form id="loginForm" action="loginProcess.php" method="post">
            <div class="input-group">
              <label for="email">Email Address</label>
              <input
                type="email"
                id="email"
                name="email"
                placeholder="name@address.com"
                required
              />
              <button type="button" class="clear-btn">✕</button>
            </div>
            <div class="input-group">
              <label for="password">Password</label>
              <input
                type="password"
                id="password"
                name="password"
                placeholder="********"
                required
              />
              <button type="button" class="clear-btn">✕</button>
            </div>
            <?php if (isset($input) && isset($errors)) {
                        dispayLoginError($input, $errors);
                    } ?>
            <button type="submit" class="login-btn">Login</button>
          </form>
          <button onclick="window.location.href='registerForm.php'" class="register-btn">Create Account</button>
        </div>
      </div>
    </div>
  </body>
</html>
