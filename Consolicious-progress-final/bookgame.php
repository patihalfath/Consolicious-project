<?php
include 'connection.php'; 

// Ambil data `game_id` dari GET
if (isset($_GET['game_id'])) {
    $game_id = $_GET['game_id'];

    // Query untuk mengambil detail game berdasarkan ID
    $stmt = $conn->prepare("SELECT * FROM games WHERE game_id = ?");
    $stmt->bind_param("i", $game_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        die("Game tidak ditemukan.");
    }

    $game = $result->fetch_assoc();
} else {
    die("Invalid request. Game ID is missing.");
}

session_start();
if (!isset($_SESSION['user_id'])) {
    die("Anda harus login untuk melakukan pemesanan.");
}
$user_id = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Game | Consolicious</title>
    <link rel="stylesheet" href="bookstyles.css">
</head>
<body>
    <header>
        <div class="logo">
            <h1>Consolicious</h1>
        </div>
        <nav>
            <ul>
                <li><a href="dashboard.php">HOME</a></li>
                <li><a href="game.php">GAME</a></li>
                <li><a href="artikel.php">ARTIKEL</a></li>
                <li><a href="profile.php">PROFILE</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <!-- Detail Game -->
        <section class="game-detail">
            <h2><?= htmlspecialchars($game['game_name']); ?></h2>
            <img src="<?= htmlspecialchars($game['image_path']); ?>" alt="<?= htmlspecialchars($game['game_name']); ?>">
            <p><strong>Genre:</strong> <?= htmlspecialchars($game['genre']); ?></p>
            <p><strong>Deskripsi:</strong> <?= htmlspecialchars($game['deskripsi']); ?></p>
            <p><strong>Harga per hari:</strong> Rp <?= number_format($game['harga_perhari'], 0, ',', '.'); ?></p>
        </section>

        <!-- Form Pemesanan -->
        <section class="booking-form">
            <h3>Masukkan Detail Pemesanan</h3>
            <form action="processgame.php" method="POST">
                <input type="hidden" name="game_id" value="<?= htmlspecialchars($game_id); ?>">
                <input type="hidden" name="user_id" value="<?= htmlspecialchars($user_id); ?>">
                
                <label for="name">Nama Pemesan:</label>
                <input type="text" id="name" name="name" placeholder="Masukkan nama Anda" required>
                
                <label for="date">Tanggal Pemesanan:</label>
                <input type="date" id="date" name="date" required>
                
                <label for="duration">Durasi (hari):</label>
                <input type="number" id="duration" name="duration" min="1" placeholder="Durasi dalam hari" required>
                
                <button type="submit">Konfirmasi Booking</button>
            </form>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 Consolicious. All rights reserved.</p>
    </footer>
</body>
</html>
