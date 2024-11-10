<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        body {
            min-height: 100vh; /* Ensure the body takes at least the full viewport height */
            display: flex;
            flex-direction: column;
            margin: 0;
        }

        footer {
            margin-top: auto; /* Pushes the footer to the bottom */
        }

        /* Media Query for Mobile View */
        @media (max-width: 768px) {
            /* Hide the login and sign-up buttons on smaller screens */
            .desktop-buttons {
                display: none;
            }
            /* Show the hamburger menu icon in mobile view */
            .hamburger-menu {
                display: block;
            }
            /* Hide the menu items until toggled */
            .w3-dropdown-content {
                display: none;
            }
            .w3-dropdown-content.w3-show {
                display: block;
            }
        }

        /* Ensure the buttons are visible on larger screens */
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
                <!-- Show login and signup buttons if user is not logged in -->
                <a href="login.php"><button class="w3-button w3-dark-grey w3-margin-left">Login</button></a>
                <a href="signup.php"><button class="w3-button w3-dark-grey w3-margin-left">Sign Up</button></a>
            <?php else: ?>
                <!-- Show logout button if user is logged in -->
                <a href="logout.php"><button class="w3-button w3-dark-grey w3-margin-left">Logout</button></a>
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
            <?php else: ?>
                <a href="logout.php" class="w3-bar-item w3-button">Logout</a>
            <?php endif; ?>
        </div>
    </header>

    <!-- Photo Slider -->
    <div class="w3-container w3-center w3-padding-16">
        <div class="w3-display-container">
            <img src="gambar1.jpg" class="w3-image w3-round-large" id="slide" alt="Photo Slider">
        </div>
    </div>

    <!-- Word Slider -->
    <div class="w3-container w3-center w3-padding-16">
        <div class="w3-display-container">
            <h6 class="w3-text-black">Our company stands at the forefront of the automotive industry, renowned for offering a premium selection of modern, professional, and high-quality vehicles that cater to the evolving demands of today’s drivers. As one of the best-selling car dealerships in the country, we have built a solid reputation for providing vehicles that combine state-of-the-art technology, exceptional performance, and eye-catching designs. Our extensive inventory includes a diverse range of cars, from compact city vehicles to powerful SUVs and luxurious sedans, all meticulously crafted to ensure durability, comfort, and driving pleasure. We pride ourselves on our commitment to excellence, offering not only the best vehicles but also exceptional customer service, making the car-buying experience smooth, transparent, and satisfying. Our professional team of experts is dedicated to guiding each customer in finding the perfect car that suits their lifestyle and preferences. Whether you’re a first-time buyer or a seasoned enthusiast, we strive to exceed expectations at every turn, delivering outstanding after-sales support and maintenance services. With our focus on innovation, reliability, and customer satisfaction, we are proud to be the trusted choice for those who value quality and performance in their vehicles.</h6>
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
        const images = ["gambar1.jpg", "gambar2.jpg", "gambar3.jpg"];
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
    </script>

    <!-- Footer -->
    <footer class="w3-container w3-dark-grey w3-padding-16 w3-center">
        <p class="w3-text-white">
            Copyright &copy; 2024 Moverilz Sdn Bhd
        </p>
    </footer>

</body>
</html>

