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
    die('ID is required.');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Delete event
        $stmt = $pdo->prepare("DELETE FROM tbl_events_request WHERE id = ?");
        $stmt->execute([$id]);

        header('Location: view_event.php');
        exit;
    } catch (PDOException $e) {
        die("Database error: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Event</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <script>
        function confirmDeletion(event) {
            if (!confirm("Are you sure you want to delete this event? This action cannot be undone.")) {
                event.preventDefault();
            }
        }
    </script>
</head>
<body class="w3-light-grey">
    <div class="w3-container w3-card-4 w3-white w3-round w3-padding-32" style="max-width: 500px; margin: auto; margin-top: 50px;">
        <h2 class="w3-center">Delete Event</h2>
        <p class="w3-center">Are you sure you want to delete this event?</p>
        <form method="POST" onsubmit="confirmDeletion(event)">
            <button class="w3-button w3-red w3-margin-top" type="submit">Yes, Delete</button>
            <a href="view_event.php" class="w3-button w3-dark-grey w3-margin-top">Cancel</a>
        </form>
    </div>
</body>
</html>
