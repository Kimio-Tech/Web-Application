<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            margin: 0;
        }

        footer {
            margin-top: auto;
        }

        @media (max-width: 768px) {
            .desktop-buttons {
                display: none;
            }
            .hamburger-menu {
                display: block;
            }
            .w3-dropdown-content {
                display: none;
            }
            .w3-dropdown-content.w3-show {
                display: block;
            }
        }

        @media (min-width: 769px) {
            .hamburger-menu {
                display: none;
            }
        }
    </style>
</head>
<body class="w3-light-grey w3-margin-0">

    <!-- Header with Clock and Welcome Message -->
    <header class="w3-container w3-dark-grey w3-center w3-padding-16 w3-relative">
        <h1 class="w3-text-white">Moverilz Sdn Bhd</h1>

        <!-- PHP to show welcome message only if user is logged in -->
        <?php if (isset($_SESSION['username'])): ?>
            <p id="welcome-message" class="w3-text-white">Welcome back, <span id="username-display"><?php echo htmlspecialchars($_SESSION['username']); ?></span>!</p>
        <?php endif; ?>

        <div id="clock" class="w3-text-white w3-large w3-margin-top"></div>

        <div class="w3-position-topright desktop-buttons">
            <?php if (!isset($_SESSION['username'])): ?>
                <!-- Show login and sign up buttons if user is not logged in -->
                <a href="login.php"><button class="w3-button w3-dark-grey w3-margin-left">Login</button></a>
                <a href="signup.php"><button class="w3-button w3-dark-grey w3-margin-left">Sign Up</button></a>
                <button class="w3-button w3-blue w3-margin-left" onclick="redirectToLogin()">Add Event</button>
            <?php else: ?>
                <!-- Show logout, event, and view buttons if user is logged in -->
                <a href="logout.php"><button class="w3-button w3-dark-grey w3-margin-left">Logout</button></a>
                <a href="add_event.php"><button class="w3-button w3-blue w3-margin-left">Add Event</button></a>
                <a href="view_event.php"><button class="w3-button w3-green w3-margin-left">View Event</button></a>
            <?php endif; ?>
        </div>

        <!-- Hamburger Menu Icon (Mobile View) -->
        <div class="w3-button w3-dark-grey w3-hover-opacity w3-xlarge w3-position-top w3-right w3-margin-top hamburger-menu" onclick="toggleMenu()">
            <i class="fa fa-bars"></i>
        </div>

        <!-- Menu Items for Mobile View -->
        <div class="w3-dropdown-content w3-dark-grey w3-bar-block w3-card-4 w3-large w3-mobile">
            <?php if (!isset($_SESSION['username'])): ?>
                <a href="login.php" class="w3-bar-item w3-button">Login</a>
                <a href="signup.php" class="w3-bar-item w3-button">Sign Up</a>
                <button class="w3-bar-item w3-button" onclick="redirectToLogin()">Add Event</button>
            <?php else: ?>
                <a href="logout.php" class="w3-bar-item w3-button">Logout</a>
                <a href="add_event.php" class="w3-bar-item w3-button">Add Event</a>
                <a href="view_event.php" class="w3-bar-item w3-button">View Event</a>
            <?php endif; ?>
        </div>
    </header>

    <!-- Content (Photo Slider and Word Slider) -->
    <div class="w3-container w3-center w3-padding-16">
        <div class="w3-display-container">
            <img src="Gambar1.jpg" class="w3-image w3-round-large" id="slide" alt="Photo Slider">
        </div>
    </div>

    <div class="w3-container w3-center w3-padding-16">
        <div class="w3-display-container">
            <h6 class="w3-text-black">Creating Memorable Experiences, One Event at a Time

At Moverilz Sdn Bhd, we are passionate about turning ideas into extraordinary events. Our mission is to deliver seamless, unforgettable experiences that connect people, celebrate milestones, and create lasting impressions.</h6>
        </div>
    </div>

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

        // Image Slider
        const images = ["Gambar1.jpg", "Gambar2.jpg", "Gambar3.jpg"];
        let currentIndex = 0;

        function changeSlide() {
            currentIndex = (currentIndex + 1) % images.length;
            document.getElementById("slide").src = images[currentIndex];
        }
        setInterval(changeSlide, 3000); // Change slide every 3 seconds

        // Toggle Hamburger Menu
        function toggleMenu() {
            const menuItems = document.querySelector('.w3-dropdown-content');
            menuItems.classList.toggle('w3-show');
        }

        // Redirect to Login
        function redirectToLogin() {
            alert("You need to log in first to access this feature.");
            window.location.href = "login.php";
        }
    </script>

    <!-- Footer -->
    <footer class="w3-container w3-dark-grey w3-padding-16 w3-center">
        <p class="w3-text-white">Copyright &copy; 2024 Moverilz Sdn Bhd</p>
    </footer>

</body>
</html>
