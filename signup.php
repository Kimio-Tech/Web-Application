<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up Page</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <style>
        /* Ensure the page takes the full height of the screen */
        body, html {
            height: 100%;
            margin: 0;
            display: flex;
            flex-direction: column;
        }

        /* This will push the footer to the bottom */
        .content {
            flex-grow: 1; /* Makes the content take up the available space */
        }

        /* Optional: styling for the footer */
        footer {
            background-color: #333;
            color: white;
        }

        /* Set the form container width to a bit wider, but still reasonable */
        .signup-form-container {
            max-width: 600px; /* Set a moderate width for the form */
            margin: 0 auto;
            padding: 24px; /* Adjust padding to give space around the form */
        }

        /* Optional: Increase input field size */
        input[type="text"], input[type="email"], input[type="password"] {
            font-size: 18px;
            padding: 12px;
        }

        button {
            padding: 12px;
            font-size: 18px;
        }
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
    <form action="signup.php" method="POST" onsubmit="return validateForm()">
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
