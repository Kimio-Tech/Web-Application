<?php
// Include the database connection file
include 'dbconnect.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    try {
        // Prepare and execute the query to check the username
        $sql = "SELECT * FROM users WHERE username = :username";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        // Check if a user with this username exists
        if ($stmt->rowCount() > 0) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // Verify the entered password with the hashed password in the database
            if (password_verify($password, $user['password'])) {
                $_SESSION['username'] = $username; // Store username in session
                
                // Redirect to the main page
                header("Location: index.php");
                exit();
            } else {
                // Incorrect password
                $error_message = "Invalid username or password.";
            }
        } else {
            // Username not found
            $error_message = "Invalid username or password.";
        }
    } catch (PDOException $e) {
        $error_message = "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <style>
        /* Ensure body takes full height for flex layout */
        body, html {
            height: 100%;
            margin: 0;
            display: flex;
            flex-direction: column;
        }

        /* This will push the footer to the bottom */
        .content {
            flex-grow: 1; /* Makes the content take up available space */
        }
    </style>
</head>
<body class="w3-light-grey">

<!-- Title Section -->
<div class="w3-container w3-center w3-margin-top">
    <h1 class="w3-text-grey">Moverilz Sdn Bhd</h1>
</div>

<!-- Login Form Section -->
<div class="content w3-container w3-card-4 w3-white w3-margin-top w3-padding-16 w3-round w3-center" style="max-width: 400px; margin: auto;">
    <h2 class="w3-text-grey">Login</h2>
    
    <!-- Display error message if set -->
    <?php if (isset($error_message)): ?>
        <div class="w3-panel w3-red">
            <p><?php echo $error_message; ?></p>
        </div>
    <?php endif; ?>
    
    <form action="login.php" method="POST">
        <label for="username" class="w3-text-grey">Username:</label>
        <input type="text" id="username" name="username" class="w3-input w3-border w3-margin-bottom" required placeholder="Enter your username">

        <label for="password" class="w3-text-grey">Password:</label>
        <input type="password" id="password" name="password" class="w3-input w3-border w3-margin-bottom" required placeholder="Enter your password">

        <div class="w3-margin-bottom">
            <input type="checkbox" id="remember" name="remember" class="w3-check">
            <label for="remember" class="w3-small">Remember Me</label>
        </div>

        <button type="submit" class="w3-button w3-green w3-block w3-round">Login</button>
    </form>

    <div class="w3-margin-top">
        <p>Don't have an account? <a href="signup.php" class="w3-text-blue">Create one here</a></p>
    </div>
</div>

<!-- Footer Section -->
<footer class="w3-container w3-grey w3-margin-top footer w3-center w3-padding">
    <p>Copyright &copy; 2024 Moverilz Sdn Bhd

    </p>
</footer>

</body>
</html>

