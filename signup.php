<?php
// Include the database connection file
include 'dbconnect.php';

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize the form data
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $fullname = htmlspecialchars($_POST['fullname']);
    $no_phone = htmlspecialchars($_POST['no_phone']);
    $newUsername = htmlspecialchars($_POST['newUsername']);
    $newPassword = $_POST['newPassword']; // Password will be hashed below

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Invalid email format. Please enter a valid email.'); window.history.back();</script>";
        exit();
    }

    // Check that all fields are filled
    if (!empty($email) && !empty($fullname) && !empty($no_phone) && !empty($newUsername) && !empty($newPassword)) {
        try {
            // Check if email or username already exists
            $checkStmt = $conn->prepare("SELECT * FROM users WHERE email = :email OR username = :username");
            $checkStmt->bindParam(':email', $email);
            $checkStmt->bindParam(':username', $newUsername);
            $checkStmt->execute();

            if ($checkStmt->rowCount() > 0) {
                $existingUser = $checkStmt->fetch(PDO::FETCH_ASSOC);
                if ($existingUser['email'] === $email) {
                    echo "<script>alert('This email is already in use. Please use a different email.'); window.history.back();</script>";
                } elseif ($existingUser['username'] === $newUsername) {
                    echo "<script>alert('This username is already taken. Please choose a different username.'); window.history.back();</script>";
                }
                exit();
            }

            // Hash the password for security
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

            // Prepare the SQL statement to insert user data
            $stmt = $conn->prepare("INSERT INTO users (email, fullname, no_phone, username, password) 
                                    VALUES (:email, :fullname, :no_phone, :username, :password)");

            // Bind parameters to the statement
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':fullname', $fullname);
            $stmt->bindParam(':no_phone', $no_phone);
            $stmt->bindParam(':username', $newUsername);
            $stmt->bindParam(':password', $hashedPassword);

            // Execute the statement
            if ($stmt->execute()) {
                echo "<script>alert('Sign up completed!'); window.location.href='login.php';</script>";
                exit(); // Stop further execution after redirect
            } else {
                echo "<p>Error: Could not save the data.</p>";
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo "<p>Please fill out all fields.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up Page</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <style>
        body, html { height: 100%; margin: 0; display: flex; flex-direction: column; }
        .content { flex-grow: 1; }
        footer { background-color: #333; color: white; }
        .signup-form-container { max-width: 600px; margin: 0 auto; padding: 24px; }
        input[type="text"], input[type="email"], input[type="password"] { font-size: 18px; padding: 12px; }
        button { padding: 12px; font-size: 18px; }
    </style>
</head>
<body class="w3-light-grey">

<!-- Title Section -->
<div class="w3-container w3-margin-top w3-center">
    <h1 class="w3-text-grey">Moverilz Sdn Bhd</h1>
</div>

<!-- Sign-Up Form Section -->
<div class="content w3-container w3-card-4 w3-white w3-margin-top w3-padding-24 w3-round w3-center signup-form-container">
    <h2 class="w3-text-grey w3-center">Sign Up</h2>
    <form action="signup.php" method="POST">
        <label for="email" class="w3-text-grey w3-small">Email:</label>
        <input type="email" id="email" name="email" class="w3-input w3-border w3-margin-bottom" required placeholder="Enter your email">
        
        <label for="fullname" class="w3-text-grey w3-small">Full Name:</label>
        <input type="text" id="fullname" name="fullname" class="w3-input w3-border w3-margin-bottom" required placeholder="Enter your full name">
        
        <label for="no_phone" class="w3-text-grey w3-small">Phone Number:</label>
        <input type="text" id="no_phone" name="no_phone" class="w3-input w3-border w3-margin-bottom" required placeholder="Enter your phone number">
        
        <label for="newUsername" class="w3-text-grey w3-small">Username:</label>
        <input type="text" id="newUsername" name="newUsername" class="w3-input w3-border w3-margin-bottom" required placeholder="Enter your username">
        
        <label for="newPassword" class="w3-text-grey w3-small">Password:</label>
        <input type="password" id="newPassword" name="newPassword" class="w3-input w3-border w3-margin-bottom" required minlength="6" placeholder="Minimum 6 characters">
        
        <button type="submit" class="w3-button w3-green w3-block w3-margin-top w3-round">Sign Up</button>
    </form>

    <a href="login.php" class="w3-button w3-blue w3-block w3-margin-top w3-round">Login</a>
</div>

<!-- Footer Section -->
<footer class="w3-container w3-dark-grey w3-padding-12 w3-center">
    <p class="w3-text-white">
        Copyright &copy; 2024 Moverilz Sdn Bhd
    </p>
</footer>

</body>
</html>
