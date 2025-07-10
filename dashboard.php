<?php
include('includes/session.php');
include('includes/db.php');
include('includes/header.php');
?>

<style>
body {
  margin: 0;
  font-family: 'Segoe UI', sans-serif;
  background: #f4f6f9;
}

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
  position: relative;
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
.register-btn {
  margin-top: 10px;
  display: inline-block;
  background: #007BFF;
  color: white;
  padding: 6px 12px;
  border-radius: 4px;
  text-decoration: none;
  transition: background 0.3s ease;
}
.register-btn:hover {
  background: #0056b3;
}
.register-btn.unregister {
  background: #dc3545;
}
.register-btn.unregister:hover {
  background: #b02a37;
}
@media(max-width: 768px) {
  .event-card {
    width: 100%;
  }
}
</style>

<?php
function displayCategory($conn, $categoryName, $emoji, $user_id = null, $onlyRegistered = false) {
  if ($onlyRegistered) {
    $query = "SELECT events.* FROM events
              JOIN registrations ON events.id = registrations.event_id
              WHERE registrations.user_id = $user_id
              ORDER BY events.date DESC";
  } else {
    $query = "SELECT * FROM events WHERE category='$categoryName' ORDER BY date DESC";
  }

  $categoryEvents = mysqli_query($conn, $query);

  echo "<div class='event-section'>";
  echo "<h2>$emoji " . ($onlyRegistered ? "My Registered Events" : ucfirst($categoryName) . " Events") . "</h2>";
  echo "<div class='events'>";
  
  if (mysqli_num_rows($categoryEvents) > 0) {
    while ($row = mysqli_fetch_assoc($categoryEvents)) {
      echo "<div class='event-card'>";
      echo "<img src='uploads/{$row['image']}' alt='{$row['title']}'>";
      echo "<h3>{$row['title']}</h3>";
      echo "<p><strong>Date:</strong> " . date("d M, Y", strtotime($row['date'])) . "</p>";
      echo "<p>" . substr($row['description'], 0, 80) . "...</p>";

      // Show "Register" button only in category sections
      if (!$onlyRegistered && isset($_SESSION['user_id'])) {
        $eid = $row['id'];
        $uid = $_SESSION['user_id'];
        $check = mysqli_query($conn, "SELECT * FROM registrations WHERE event_id = $eid AND user_id = $uid");

        if (mysqli_num_rows($check) == 0) {
          echo "<a href='register.php?event_id={$row['id']}' class='register-btn'>Register</a>";
        } else {
          echo "<span style='color: green; font-weight: bold;'>✅ Registered</span>";
        }
      }

      // Show "Unregister" button only in My Registered Events
      if ($onlyRegistered && isset($_SESSION['user_id'])) {
        echo "<a href='register.php?event_id={$row['id']}&action=unregister' class='register-btn unregister' onclick=\"return confirm('Unregister from this event?')\">Unregister</a>";
      }

      echo "</div>";
    }
  } else {
    echo "<p>No " . ($onlyRegistered ? "registered" : $categoryName) . " events found.</p>";
  }

  echo "</div></div>";
}

// Display Upcoming, Ongoing, Completed
displayCategory($conn, "upcoming", "📅");
displayCategory($conn, "ongoing", "🟢");
displayCategory($conn, "completed", "✅");

// My Registered Events (with Unregister option)
if (isset($_SESSION['user_id'])) {
  displayCategory($conn, "", "📌", $_SESSION['user_id'], true);
}
?>

<?php include('includes/footer.php'); ?>
