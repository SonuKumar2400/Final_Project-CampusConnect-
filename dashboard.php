<?php
include('includes/session.php');
include('includes/db.php');
include('includes/header.php');
?>

<style>
.event-section {
  margin: 40px auto;
  max-width: 1100px;
}
.event-section h2 {
  border-bottom: 2px solid #007BFF;
  padding-bottom: 8px;
  color: #003366;
}
.events {
  display: flex;
  flex-wrap: wrap;
  gap: 20px;
  margin-top: 20px;
}
.event-card {
  background: white;
  border: 1px solid #ddd;
  border-radius: 8px;
  padding: 1em;
  width: calc(33% - 1em);
  box-shadow: 0 2px 5px #ccc;
}
.event-card img {
  width: 100%;
  height: 160px;
  object-fit: cover;
  border-radius: 6px;
}
.event-card h3 {
  margin-top: 10px;
  font-size: 1.2em;
  color: #003366;
}
.event-card p {
  font-size: 14px;
  color: #444;
}
@media(max-width: 768px) {
  .event-card {
    width: 100%;
  }
}
</style>

<?php
function displayCategory($conn, $categoryName, $emoji) {
  $categoryEvents = mysqli_query($conn, "SELECT * FROM events WHERE category='$categoryName' ORDER BY date DESC");

  echo "<div class='event-section'>";
  echo "<h2>$emoji " . ucfirst($categoryName) . " Events</h2>";
  echo "<div class='events'>";
  
  if (mysqli_num_rows($categoryEvents) > 0) {
    while ($row = mysqli_fetch_assoc($categoryEvents)) {
      echo "<div class='event-card'>";
      echo "<img src='uploads/{$row['image']}' alt='{$row['title']}'>";
      echo "<h3>{$row['title']}</h3>";
      echo "<p><strong>Date:</strong> " . date("d M, Y", strtotime($row['date'])) . "</p>";
      echo "<p>" . substr($row['description'], 0, 80) . "...</p>";
      echo "</div>";
    }
  } else {
    echo "<p>No $categoryName events found.</p>";
  }

  echo "</div></div>";
}

displayCategory($conn, "upcoming", "📅");
displayCategory($conn, "ongoing", "🟢");
displayCategory($conn, "completed", "✅");
include('includes/footer.php');
?>

?>
<script src="js/main.js"></script>

