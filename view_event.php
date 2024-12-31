<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

// Database configuration
$host = 'localhost';
$db = 'assignment_web'; // Corrected database name
$user = 'root';
$pass = '';

try {
    // Connect to the database using PDO
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Initialize query variables
    $query = "SELECT id, event_title, date_from, date_to, location, type, description FROM tbl_events_request WHERE 1";
    $params = [];

    // Handle filters
    if (!empty($_GET['type'])) {
        $query .= " AND type = :type";
        $params[':type'] = $_GET['type'];
    }

    if (!empty($_GET['location'])) {
        $query .= " AND location = :location";
        $params[':location'] = $_GET['location'];
    }

    // Order by date_from
    $query .= " ORDER BY date_from ASC";

    // Fetch events from the database
    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    $events = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Fetch unique event types and locations for filters
    $typesStmt = $pdo->query("SELECT DISTINCT type FROM tbl_events_request");
    $types = $typesStmt->fetchAll(PDO::FETCH_COLUMN);

    $locationsStmt = $pdo->query("SELECT DISTINCT location FROM tbl_events_request");
    $locations = $locationsStmt->fetchAll(PDO::FETCH_COLUMN);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Event</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
</head>
<body class="w3-light-grey">
    <!-- Header with Clock -->
    <header class="w3-container w3-dark-grey w3-center w3-padding-16">
        <h1 class="w3-text-white">Moverilz Sdn Bhd</h1>
        <div id="clock" class="w3-text-white w3-large w3-margin-top"></div>
    </header>

    <div class="w3-container w3-card-4 w3-white w3-round w3-padding-32" style="max-width: 900px; margin: auto; margin-top: 50px;">
        <h2 class="w3-center">Upcoming Events</h2>

        <!-- Filter Form -->
        <form method="GET" class="w3-row-padding w3-margin-bottom">
            <div class="w3-col s12 m6">
                <label for="type">Event Type:</label>
                <select name="type" id="type" class="w3-select w3-border">
                    <option value="">Choose Type</option>
                    <?php foreach ($types as $type): ?>
                        <option value="<?php echo htmlspecialchars($type); ?>" <?php echo isset($_GET['type']) && $_GET['type'] === $type ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($type); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="w3-col s12 m6">
                <label for="location">Location:</label>
                <select name="location" id="location" class="w3-select w3-border">
                    <option value="">Choose Location</option>
                    <?php foreach ($locations as $loc): ?>
                        <option value="<?php echo htmlspecialchars($loc); ?>" <?php echo isset($_GET['location']) && $_GET['location'] === $loc ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($loc); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="w3-col s12 m12 w3-margin-top">
                <button type="submit" class="w3-button w3-blue w3-round">Filter</button>
                <a href="view_event.php" class="w3-button w3-gray w3-round">Reset</a>
            </div>
        </form>

        <!-- Events List -->
        <?php if (count($events) > 0): ?>
            <ul class="w3-ul">
                <?php foreach ($events as $event): 
                    // Calculate the number of days
                    $dateFrom = new DateTime($event['date_from']);
                    $dateTo = new DateTime($event['date_to']);
                    $numOfDays = $dateFrom->diff($dateTo)->days + 1; // Include both start and end dates

                    // Format dates
                    $formattedDateFrom = $dateFrom->format('d/m/Y');
                    $formattedDateTo = $dateTo->format('d/m/Y');
                ?>
                    <li class="w3-padding-16 w3-border-bottom">
                        <h4 class="w3-text-teal"><?php echo htmlspecialchars($event['event_title']); ?></h4>
                        <p><strong>Type:</strong> <?php echo htmlspecialchars($event['type']); ?></p>
                        <p><strong>Date:</strong> <?php echo htmlspecialchars($formattedDateFrom); ?> to <?php echo htmlspecialchars($formattedDateTo); ?></p>
                        <p><strong>Number of Days:</strong> <?php echo $numOfDays; ?> day(s)</p>
                        <p><strong>Location:</strong> <?php echo htmlspecialchars($event['location']); ?></p>
                        <p><strong>Description:</strong> <?php echo htmlspecialchars($event['description']); ?></p>

                        <!-- Edit and Delete Buttons -->
                        <a href="edit_event.php?id=<?php echo $event['id']; ?>" class="w3-button w3-teal w3-small w3-margin-right">Edit Event</a>
                        <a href="delete_event.php?id=<?php echo $event['id']; ?>" class="w3-button w3-red w3-small">Delete Event</a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p class="w3-center w3-text-gray">No events available with the selected criteria.</p>
        <?php endif; ?>

        <a href="index.php" class="w3-button w3-dark-grey w3-margin-top w3-round">Back to Home</a>
    </div>

    <!-- Footer -->
    <footer class="w3-container w3-dark-grey w3-padding-16 w3-center w3-margin-top">
        <p class="w3-text-white">&copy; 2024 Moverilz Sdn Bhd</p>
    </footer>

    <script>
        // Real-Time Clock
        function updateClock() {
            const now = new Date();
            const hours = now.getHours().toString().padStart(2, '0');
            const minutes = now.getMinutes().toString().padStart(2, '0');
            const seconds = now.getSeconds().toString().padStart(2, '0');
            document.getElementById('clock').innerText = `${hours}:${minutes}:${seconds}`;
        }
        setInterval(updateClock, 1000);
    </script>
</body>
</html>
