<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

$host = 'localhost';
$db = 'assignment_web';
$user = 'root';
$pass = '';
$id = $_GET['id'] ?? null;

if (!$id) {
    die('Event ID is required.');
}

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch event details or handle form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $title = $_POST['event_title'];
        $date_from = $_POST['date_from'];
        $date_to = $_POST['date_to'];
        $location = $_POST['location'];
        $type = $_POST['type'];
        $description = $_POST['description'];

        // Update event
        $stmt = $pdo->prepare(
            "UPDATE tbl_events_request 
            SET event_title = ?, date_from = ?, date_to = ?, location = ?, type = ?, description = ? 
            WHERE id = ?"
        );
        $stmt->execute([$title, $date_from, $date_to, $location, $type, $description, $id]);
        header('Location: view_event.php');
        exit;
    } else {
        $stmt = $pdo->prepare(
            "SELECT event_title, date_from, date_to, location, type, description 
            FROM tbl_events_request 
            WHERE id = ?"
        );
        $stmt->execute([$id]);
        $event = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$event) {
            die('Event not found.');
        }
    }
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Event</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <script>
        // Function to update the time every second
        function updateClock() {
            var now = new Date();
            var hours = now.getHours().toString().padStart(2, '0');
            var minutes = now.getMinutes().toString().padStart(2, '0');
            var seconds = now.getSeconds().toString().padStart(2, '0');
            var timeString = hours + ':' + minutes + ':' + seconds;
            document.getElementById('clock').textContent = timeString;
        }

        // Update the clock immediately and then every second
        setInterval(updateClock, 1000);
        window.onload = updateClock;
    </script>
</head>
<body class="w3-light-grey">

    <!-- Header -->
    <header class="w3-container w3-teal w3-center w3-padding-16">
        <h1>Edit Event</h1>
        <div id="clock" class="w3-large"></div> <!-- Clock display -->
    </header>

    <div class="w3-container w3-card-4 w3-white w3-round w3-padding-32" style="max-width: 700px; margin: auto; margin-top: 50px;">
        <h2 class="w3-center">Edit Event</h2>
        <form method="POST">
            <label>Event Title</label>
            <input class="w3-input w3-border" type="text" name="event_title" value="<?php echo htmlspecialchars($event['event_title']); ?>" required>

            <label>Start Date</label>
            <input class="w3-input w3-border" type="date" name="date_from" value="<?php echo htmlspecialchars($event['date_from']); ?>" required>

            <label>End Date</label>
            <input class="w3-input w3-border" type="date" name="date_to" value="<?php echo htmlspecialchars($event['date_to']); ?>" required>

            <label>Location</label>
            <input class="w3-input w3-border" type="text" name="location" value="<?php echo htmlspecialchars($event['location']); ?>" required>

            <label>Type</label>
            <input class="w3-input w3-border" type="text" name="type" value="<?php echo htmlspecialchars($event['type']); ?>" required>

            <label>Description</label>
            <textarea class="w3-input w3-border" name="description" rows="4" required><?php echo htmlspecialchars($event['description']); ?></textarea>

            <button class="w3-button w3-teal w3-margin-top" type="submit">Save Changes</button>
            <a href="view_event.php" class="w3-button w3-dark-grey w3-margin-top">Cancel</a>
        </form>
    </div>

    <!-- Footer -->
    <footer class="w3-container w3-teal w3-center w3-padding-16" style="margin-top: 50px;">
        <p>&copy; 2024 Moverilz Sdn Bhd</p>
    </footer>

</body>
</html>
