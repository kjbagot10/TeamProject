<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="styles.css" rel="stylesheet" type="text/css" />
  <title>Create Account</title>
    
</head>
<body>
<div class="login-page"> 
  <div class="container">
    <!-- Left Section -->
    <div class="left-section">
      <div class="logo">Logo</div>
      <h1>Join the Food Waste Management App</h1>
    </div>

    <!-- Create Account Form Section -->
    <div class="form-container">
      <h2>Create Account</h2>
      <form id="registerForm" action="registerProcess.php" method="post">
        <div class="input-group">
          <label for="name">Full Name</label>
          <input type="text" id="name" name="name" placeholder="Enter your full name" required>
          <button type="button" class="clear-btn">✕</button>
        </div>
        <div class="input-group">
          <label for="email">Email Address</label>
          <input type="email" id="email" name="email" placeholder="name@address.com" required>
          <button type="button" class="clear-btn">✕</button>
        </div>
        <div class="input-group">
          <label for="password">Password</label>
          <input type="password" id="password" name="password" placeholder="********" required>
          <button type="button" class="clear-btn">✕</button>
        </div>
        <div class="input-group">
          <label for="confirm-password">Confirm Password</label>
          <input type="password" id="confirm-password" name="confirm-password" placeholder="********" required>
          <button type="button" class="clear-btn">✕</button>
        </div>
        <?php if (isset($input) && isset($errors)) {
                        dispayLoginError($input, $errors);
                    } ?>
        <button type="submit" class="login-btn">Create Account</button>
      </form>
    </div>
  </div>
</div>
</body>
</html>