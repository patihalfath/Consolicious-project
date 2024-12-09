<?php
session_start();
$is_logged_in = isset($_SESSION['user_id']);

// Jika pengguna belum login, arahkan ke halaman login
if (!$is_logged_in) {
    header("Location: login.php");
    exit();
}

// Ambil data user dari session
$name = $_SESSION['name'];
$email = $_SESSION['email'];
$address = $_SESSION['address'];
$phone = $_SESSION['phone'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - Consolicious</title>
    <link rel="stylesheet" href="profile.css">
</head>
<body>
    <!-- Header Section -->
    <header>
        <div class="logo">
            <h1>Consolicious</h1>
        </div>
        <nav>
            <ul>
                <li><a href="dashboard.php">HOME</a></li>
                <li><a href="gamingSpace.php">GAMING SPACE</a></li>
                <li><a href="artikel.php">ARTIKEL</a></li>
                <li><a href="game.php">GAME</a></li>
            </ul>
        </nav>
    </header>

    <!-- Profile Content -->
    <main>
        <section class="profile-section">
            <div class="profile-card">
                <h2>Hallo, <?php echo htmlspecialchars($name); ?>!</h2>
                <p class="profile-info"><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
                <p class="profile-info"><strong>Nomor Telepon:</strong> <?php echo htmlspecialchars($phone); ?></p>
                <p class="profile-info"><strong>Alamat:</strong> <?php echo htmlspecialchars($address); ?></p>
                <div class="profile-actions">
                    <a href="editProfile.php" class="btn">Edit Profile</a>
                    <a href="change_password.php" class="btn">Change Password</a>
                    <a href="order.php" class="btn">Order History</a>
                    <a href="logout.php" class="btn logout-btn">Logout</a>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer>
        <p>&copy; 2024 Consolicious. All rights reserved.</p>
    </footer>
</body>
</html>
