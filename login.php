<?php
session_start();
include('includes/db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $email = $_POST['email'];
  $password = $_POST['password'];

  $query = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
  $user = mysqli_fetch_assoc($query);

  if ($user && $password === $user['password']) {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['role'] = $user['role'];
    header("Location: dashboard.php");
    exit;
  } else {
    $error = "Invalid email or password!";
  }
}

include('includes/header.php');
?>
<style>
html, body {
  height: 100%;
  margin: 0;
  padding: 0;
}

.wrapper {
  min-height: 85vh;
  display: flex;
  flex-direction: column;
}

.main-content {
  flex: 1;
}
</style>
<div class="wrapper">
  <div class="main-content">
    <div class="form-container">
      <h2>Login</h2>
      <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
      <form method="POST">
        <input type="email" name="email" placeholder="Email Address" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" class="btn">Login</button>
      </form>
      <p>Don't have an account? <a href="signup.php">Sign up now</a></p>
    </div>
  </div>

  <?php include('includes/footer.php'); ?>
</div>
<script src="js/main.js"></script>
