<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Event</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script>
        // Function to calculate the number of days between two dates
        function calculateDays() {
            const dateFrom = new Date(document.getElementById("date_from").value);
            const dateTo = new Date(document.getElementById("date_to").value);

            if (dateFrom && dateTo && dateTo >= dateFrom) {
                const timeDiff = dateTo - dateFrom;
                const days = Math.ceil(timeDiff / (1000 * 60 * 60 * 24)) + 1; // Including the starting day
                document.getElementById("num_days").value = days;
            } else {
                document.getElementById("num_days").value = "Invalid dates";
            }
        }

        // Function to validate the form before submission
        function validateForm() {
            const title = document.getElementById("event_title").value.trim();
            const description = document.getElementById("description").value.trim();
            const location = document.getElementById("location").value.trim();
            const type = document.getElementById("type").value;
            const dateFrom = document.getElementById("date_from").value;
            const dateTo = document.getElementById("date_to").value;

            if (!title || !description || !location || !type || !dateFrom || !dateTo) {
                alert("All fields are required.");
                return false;
            }

            if (new Date(dateFrom) > new Date(dateTo)) {
                alert("Date From cannot be later than Date To.");
                return false;
            }

            return true;
        }
    </script>
</head>
<body class="w3-light-grey">
    <!-- Header with Clock -->
    <header class="w3-container w3-dark-grey w3-center w3-padding-16">
        <h1 class="w3-text-white">Moverilz Sdn Bhd</h1>
        <div id="clock" class="w3-text-white w3-large w3-margin-top"></div>
    </header>

    <!-- Event Request Form -->
    <div class="w3-container w3-card-4 w3-white w3-round w3-padding-32" style="max-width: 700px; margin: auto; margin-top: 50px;">
        <h2 class="w3-center w3-text-grey w3-margin-bottom">Add Event Form</h2>
        <form action="process_event_request.php" method="POST" onsubmit="return validateForm();">
            <!-- Event Title -->
            <label for="event_title" class="w3-text-grey w3-large">Event Title:</label>
            <input type="text" id="event_title" name="event_title" class="w3-input w3-border w3-margin-bottom w3-padding-large" required>

            <!-- Description -->
            <label for="description" class="w3-text-grey w3-large">Description:</label>
            <textarea id="description" name="description" class="w3-input w3-border w3-margin-bottom w3-padding-large" required></textarea>

            <!-- Location -->
            <label for="location" class="w3-text-grey w3-large">Location:</label>
            <input type="text" id="location" name="location" class="w3-input w3-border w3-margin-bottom w3-padding-large" required>

            <!-- Event Type -->
            <label for="type" class="w3-text-grey w3-large">Event Type:</label>
            <select id="type" name="type" class="w3-select w3-border w3-margin-bottom w3-padding-large" required>
                <option value="" disabled selected>Choose Type</option>
                <option value="Conference">Conference</option>
                <option value="Workshop">Workshop</option>
                <option value="Seminar">Seminar</option>
                <option value="Others">Others</option>
            </select>

            <!-- Date From -->
            <label for="date_from" class="w3-text-grey w3-large">Date From:</label>
            <input type="date" id="date_from" name="date_from" class="w3-input w3-border w3-margin-bottom w3-padding-large" required onchange="calculateDays();">

            <!-- Date To -->
            <label for="date_to" class="w3-text-grey w3-large">Date To:</label>
            <input type="date" id="date_to" name="date_to" class="w3-input w3-border w3-margin-bottom w3-padding-large" required onchange="calculateDays();">

            <!-- Number of Days -->
            <label for="num_days" class="w3-text-grey w3-large">Number of Days:</label>
            <input type="text" id="num_days" name="num_days" class="w3-input w3-border w3-margin-bottom w3-padding-large" readonly>

            <!-- Submit Button -->
            <button type="submit" class="w3-button w3-green w3-block w3-round w3-padding-large">Submit</button>
        </form>

        <!-- Back to Home Button -->
        <div class="w3-center w3-margin-top">
            <a href="index.php" class="w3-button w3-blue w3-round w3-padding-large">Back to Home</a>
        </div>
    </div>

    <!-- Footer -->
    <footer class="w3-container w3-dark-grey w3-padding-16 w3-center w3-margin-top">
        <p class="w3-text-white">
            &copy; 2024 Moverilz Sdn Bhd
        </p>
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
