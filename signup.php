<?php
session_start();
include('includes/db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $name = htmlspecialchars($_POST['name']);
  $email = $_POST['email'];
  $password = $_POST['password'];

  $check = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
  if (mysqli_num_rows($check) > 0) {
    $error = "Email already registered!";
  } else {
    mysqli_query($conn, "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')");
    header("Location: login.php");
    exit;
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
      <h2>Sign Up</h2>
      <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
      <form method="POST">
        <input type="text" name="name" placeholder="Full Name" required>
        <input type="email" name="email" placeholder="Email Address" required>
        <input type="password" name="password" placeholder="Create Password" required>
        <button type="submit" class="btn">Register</button>
      </form>
      <p>Already have an account? <a href="login.php">Login here</a></p>
    </div>
  </div>

  <?php include('includes/footer.php'); ?>
</div>
<script src="js/main.js"></script>
