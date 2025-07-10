<?php
include('includes/session.php');
include('includes/db.php');

if (!isset($_SESSION['user_id']) || !isset($_GET['event_id'])) {
  header("Location: login.php");
  exit();
}

$user_id = $_SESSION['user_id'];
$event_id = $_GET['event_id'];
$action = isset($_GET['action']) && $_GET['action'] === 'unregister' ? 'unregister' : 'register';

if ($action === 'register') {
  $check = mysqli_query($conn, "SELECT * FROM registrations WHERE user_id = $user_id AND event_id = $event_id");
  if (mysqli_num_rows($check) == 0) {
    mysqli_query($conn, "INSERT INTO registrations (user_id, event_id) VALUES ($user_id, $event_id)");
  }
} elseif ($action === 'unregister') {
  mysqli_query($conn, "DELETE FROM registrations WHERE user_id = $user_id AND event_id = $event_id");
}

header("Location: dashboard.php");
exit();
?>
