<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>CampusConnect</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <header>
    <h1>CampusConnect</h1>
    <nav>
      <a href="index.php">Home</a>
<?php if (isset($_SESSION['user_id'])): ?>
  <a href="dashboard.php">Dashboard</a>
  <?php if ($_SESSION['role'] === 'admin'): ?>
    <a href="admin.php">Admin Panel</a>
  <?php endif; ?>
  <a href="logout.php">Logout</a>
<?php else: ?>
  <a href="login.php">Login</a>
  <a href="signup.php">Sign Up</a>
  <a href="admin_login.php">Admin Login</a>
<?php endif; ?>
    </nav>
  </header>
