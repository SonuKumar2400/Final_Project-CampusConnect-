<?php
session_start();
include('includes/db.php');
include('includes/header.php');
?>

<!-- Hero Section -->
<section class="hero">
  <div class="hero-text">
    <h1>Welcome to CampusConnect 🎓</h1>
    <p>Your one-stop portal to explore and participate in exciting college events!</p>
    <?php if (!isset($_SESSION['user_id'])): ?>
      <a href="login.php" class="btn">Login</a>
      <a href="signup.php" class="btn">Sign Up</a>
    <?php else: ?>
      <a href="dashboard.php" class="btn">Go to Dashboard</a>
    <?php endif; ?>
  </div>
</section>

<!-- About Section -->
<section class="about">
  <div class="container">
    <h2>Why CampusConnect?</h2>
    <p>CampusConnect helps you discover and participate in the latest workshops, seminars, cultural fests, and more hosted by your college. Whether you're a student or an organizer, this platform brings all events to one central place!</p>
    <ul>
      <li>📅 View and register for upcoming events</li>
      <li>📢 Stay informed on college activities</li>
      <li>📝 Manage registrations from your dashboard</li>
      <li>🎉 Participate and win certificates</li>
    </ul>
  </div>
</section>
<script src="js/main.js"></script>


<?php include('includes/footer.php'); ?>
