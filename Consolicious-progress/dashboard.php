<?php
session_start();
$is_logged_in = isset($_SESSION['user_id']);

if ($is_logged_in) {
    $name = $_SESSION['name'];
    $email = $_SESSION['email'];
} else {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Website Penyewaan Console</title>
    <link rel="stylesheet" href="styles.css" />
</head>
<body>
    <header>
        <div class="logo">
            <h1>Consolicious</h1>
        </div>
        <nav>
            <ul>
                <li><a href="keranjang.php">ORDER</a></li>
                <li><a href="dashboard.php">HOME</a></li>
                <li><a href="gamingSpace.php">GAMING SPACE</a></li>
                <li><a href="artikel.php">ARTIKEL</a></li>
                <li><a href="game.php">GAME</a></li>
                <li><a href="profile.php">PROFILE</a></li>
                
            </ul>
        </nav>
    </header>

    <main>
        <section class="hero">
            <h2>Sewa & Mainkan dengan Teman</h2>
            <p>Mainkan di rumah atau booking tempat rental di dekat Anda!</p><br>
            <h2>Selamat Datang, <?php echo htmlspecialchars($name); ?>!</h2>
            <p>Mulailah menikmati layanan kami:</p>
        </section>

        <section class="rent-consoles">
            <h2>Konsol yang Tersedia</h2>
            <div class="console-grid">
                <div class="console-item">
                    <img src="https://asset.kompas.com/crops/OShkHBI40cCFj6mMFFcYmhbhBaw=/187x12:1126x638/750x500/data/photo/2020/06/12/5ee2bae6901d6.jpg" alt="Playstation"/>
                    <h3>Playstation</h3>
                    <button>
                    <a href="ps.php" style="color: white; text-decoration: none;">Sewa Sekarang</a>
                    </button>
                </div>
                <div class="console-item">
                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT7rPVNiuN-A9wSlOMudX6brvCOU5kHvE0xHQ&s" alt="X-Box"/>
                    <h3>X-Box</h3>
                    <button>
                    <a href="xbox.php" style="color: white; text-decoration: none;">Sewa Sekarang</a>
                    </button>
                </div>
                <div class="console-item">
                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSabCQvbxkReohNa2DRSZEjHFqUZiSrFFsIoA&s" alt="Switch"/>
                    <h3>Switch</h3>
                    <button>
                    <a href="switch.php" style="color: white; text-decoration: none;">Sewa Sekarang</a>
                    </button>
                </div>
            </div>
        </section>

        <section class="book-space">
            <h2>Cari Tempat Rental Disekitar</h2>
            <p>Pilih lokasi, booking tempatnya, dan bermain dengan temanmu!</p>
            <button class="cta-btn">Booking Sekarang</button>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 Consolicious. All rights reserved.</p>
    </footer>
</body>
</html>
