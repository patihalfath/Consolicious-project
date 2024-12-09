<?php
include 'connection.php'; 

// Ambil data `space_id` dari POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $space_id = $_POST['space_id'] ?? null;

    if (!$space_id) {
        die("Invalid request. Space ID is required.");
    }

    // Query untuk mengambil detail ruang gaming berdasarkan ID
    $stmt = $conn->prepare("SELECT * FROM gaming_space WHERE space_id = ?");
    $stmt->bind_param("i", $space_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        die("Gaming space tidak ditemukan.");
    }

    $space = $result->fetch_assoc();
} else {
    die("Invalid request method.");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Gaming Space | Consolicious</title>
    <link rel="stylesheet" href="spacestyles.css">
</head>
<body>
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
                <li><a href="profile.php">PROFILE</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <!-- Detail Gaming Space -->
        <section class="space-detail">
            <h2><?= htmlspecialchars($space['nama_space']); ?></h2>
            <img src="<?= htmlspecialchars($space['image_path']); ?>" alt="<?= htmlspecialchars($space['nama_space']); ?>">
            <p><strong>Lokasi:</strong> <?= htmlspecialchars($space['lokasi']); ?></p>
            <p><strong>Harga per jam:</strong> Rp <?= number_format($space['harga_space_perjam'], 0, ',', '.'); ?></p>
            <p><?= htmlspecialchars($space['keterangan']); ?></p>
        </section>
        
<!-- Form Pemesanan -->
<section class="booking-form">
    <h3>Masukkan Detail Pemesanan</h3>
    <form action="processBooking.php" method="POST">
        <input type="hidden" name="space_id" value="<?= htmlspecialchars($space_id); ?>">
        
        <label for="name">Nama Pemesan:</label>
        <input type="text" id="name" name="name" placeholder="Masukkan nama Anda" required>
        
        <label for="date">Tanggal Pemesanan:</label>
        <input type="date" id="date" name="date" required>
        
        <label for="time">Waktu:</label>
        <div style="display: flex; gap: 10px;">
            <input type="time" id="start_time" name="start_time" required>
            <span style="align-self: center;">sampai</span>
            <input type="time" id="end_time" name="end_time" required>
        </div>
        
        <button type="submit">Konfirmasi Booking</button>
    </form>
</section>

    </main>

    <footer>
        <p>&copy; 2024 Consolicious. All rights reserved.</p>
    </footer>
</body>
</html>
