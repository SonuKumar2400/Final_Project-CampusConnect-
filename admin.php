<?php
include('includes/session.php');
include('includes/db.php');

if ($_SESSION['role'] != 'admin') {
  header("Location: dashboard.php");
  exit();
}

// Handle Add Event
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_event'])) {
$title = mysqli_real_escape_string($conn, $_POST['title']);
$desc = mysqli_real_escape_string($conn, $_POST['desc']);
$date = $_POST['date'];
$category = $_POST['category'];
$img = $_FILES['image']['name'];

move_uploaded_file($_FILES['image']['tmp_name'], "uploads/$img");

$query = "INSERT INTO events (title, description, date, category, image, created_by) 
VALUES ('$title', '$desc', '$date', '$category', '$img', {$_SESSION['user_id']})";

mysqli_query($conn, $query) or die("Error: " . mysqli_error($conn));
}
// Handle Delete Event
if (isset($_GET['delete'])) {
  $event_id = $_GET['delete'];

  // Delete image file
  $result = mysqli_query($conn, "SELECT image FROM events WHERE id = $event_id");
  $event = mysqli_fetch_assoc($result);
  if ($event && file_exists("uploads/" . $event['image'])) {
    unlink("uploads/" . $event['image']);
  }

  // Delete event
  mysqli_query($conn, "DELETE FROM events WHERE id = $event_id");
  header("Location: admin.php");
  exit();
}

include('includes/header.php');
?>

<style>
.form-container {
  background: white;
  max-width: 600px;
  margin: 2em auto;
  padding: 2em;
  box-shadow: 0 0 10px #ccc;
  border-radius: 8px;
}
.container {
  padding: 2em;
}
table {
  width: 100%;
  background: white;
  border-collapse: collapse;
  margin-top: 20px;
}
th, td {
  padding: 10px;
  text-align: center;
  border: 1px solid #ccc;
}
th {
  background: #003366;
  color: white;
}
.btn-delete {
  background: #dc3545;
  padding: 5px 12px;
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}
.btn-delete:hover {
  background: #c82333;
}
select {
  width: 100%;
  padding: 10px;
  margin: 10px 0;
  border-radius: 4px;
  border: 1px solid #ccc;
}
</style>

<div class="form-container">
  <h2>Admin - Create Event</h2>
  <form method="POST" enctype="multipart/form-data">
    <input type="hidden" name="add_event" value="1">
    <input type="text" name="title" placeholder="Event Title" required>
    <textarea name="desc" placeholder="Event Description" required></textarea>
    <input type="date" name="date" required>
    
    <!-- Category Select -->
    <select name="category" required>
      <option value="">Select Category</option>
      <option value="upcoming">Upcoming</option>
      <option value="ongoing">Ongoing</option>
      <option value="completed">Completed</option>
    </select>
    
    <input type="file" name="image" required>
    <button class="btn" type="submit">Add Event</button>
  </form>
</div>

<div class="container">
  <h2>📋 Existing Events</h2>
  <table>
    <tr>
      <th>Title</th>
      <th>Date</th>
      <th>Category</th>
      <th>Image</th>
      <th>Action</th>
    </tr>
    <?php
    $events = mysqli_query($conn, "SELECT * FROM events ORDER BY date DESC");
    while ($row = mysqli_fetch_assoc($events)) {
      echo "<tr>";
      echo "<td>{$row['title']}</td>";
      echo "<td>" . date('d M Y', strtotime($row['date'])) . "</td>";
      echo "<td>" . ucfirst($row['category']) . "</td>";
      echo "<td><img src='uploads/{$row['image']}' width='80'></td>";
      echo "<td><a href='admin.php?delete={$row['id']}' onclick=\"return confirm('Delete this event?')\" class='btn-delete'>Delete</a></td>";
      echo "</tr>";
    }
    ?>
  </table>
</div>

<?php include('includes/footer.php'); ?>
<script src="js/main.js"></script>
