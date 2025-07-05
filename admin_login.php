<?php
session_start();
include('includes/db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $email = $_POST['email'];
  $password = $_POST['password'];

  $query = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
  $user = mysqli_fetch_assoc($query);

  if ($user && $password === $user['password']) {
    if ($user['role'] === 'admin') {
      $_SESSION['user_id'] = $user['id'];
      $_SESSION['role'] = 'admin';
      header("Location: admin.php");
      exit();
    } else {
      $error = "❌ Not valid admin credentials!";
      header("refresh:2;url=login.php");
    }
  } else {
    $error = "❌ Invalid email or password!";
  }
}

include('includes/header.php');
?>
<style>
body, html {
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
      <h2>Admin Login</h2>
      <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
      <form method="POST">
        <input type="email" name="email" placeholder="Admin Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" class="btn">Login as Admin</button>
      </form>
    </div>
  </div>

  <?php include('includes/footer.php'); ?>

</div>
<script src="js/main.js"></script>
