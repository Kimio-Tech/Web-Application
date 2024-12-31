<?php
include 'dbconnect.php'; // Database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate input data
    function validateInput($data) {
        return htmlspecialchars(strip_tags(trim($data)));
    }

    $eventTitle = validateInput($_POST['event_title']);
    $description = validateInput($_POST['description']);
    $location = validateInput($_POST['location']);
    $type = validateInput($_POST['type']);
    $dateFrom = validateInput($_POST['date_from']);
    $dateTo = validateInput($_POST['date_to']);
    $numDays = validateInput($_POST['num_days']);

    // Server-side validation
    if (empty($eventTitle) || empty($description) || empty($location) || empty($type) || empty($dateFrom) || empty($dateTo)) {
        echo "<script>
                alert('All fields are required.');
                window.history.back();
              </script>";
        exit();
    }

    if (new DateTime($dateFrom) > new DateTime($dateTo)) {
        echo "<script>
                alert('Invalid date range: \"Date From\" cannot be later than \"Date To\".');
                window.history.back();
              </script>";
        exit();
    }

    try {
        // Insert into database
        $sql = "INSERT INTO tbl_events_request (event_title, description, location, type, date_from, date_to, num_days)
                VALUES (:event_title, :description, :location, :type, :date_from, :date_to, :num_days)";
        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':event_title', $eventTitle);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':location', $location);
        $stmt->bindParam(':type', $type);
        $stmt->bindParam(':date_from', $dateFrom);
        $stmt->bindParam(':date_to', $dateTo);
        $stmt->bindParam(':num_days', $numDays);

        $stmt->execute();
        
        // Redirect to the main page with success message
        echo "<script>
                alert('Event successfully added.');
                window.location.href = 'index.php';
              </script>";
        exit();
    } catch (PDOException $e) {
        echo "<script>
                alert('Error: " . addslashes($e->getMessage()) . "');
                window.history.back();
              </script>";
    }
}
?>
