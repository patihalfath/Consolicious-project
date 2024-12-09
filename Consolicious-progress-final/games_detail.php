<?php
include 'connection.php'; // Menyertakan file koneksi database

// Mendapatkan game_id dari URL
if (isset($_GET['game_id'])) {
    $game_id = $_GET['game_id'];

    // Query untuk mengambil data game berdasarkan game_id
    $sql = "SELECT * FROM games WHERE game_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $game_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Memeriksa apakah game ditemukan
    if ($result->num_rows > 0) {
        $game = $result->fetch_assoc();
    } else {
        echo "<p>Game not found.</p>";
        exit();
    }

    // Query untuk mengambil rekomendasi game lain
    $recommendation_sql = "SELECT * FROM games WHERE game_id != ? LIMIT 4";
    $recommendation_stmt = $conn->prepare($recommendation_sql);
    $recommendation_stmt->bind_param("i", $game_id);
    $recommendation_stmt->execute();
    $recommendation_result = $recommendation_stmt->get_result();
} else {
    echo "<p>Game ID is missing.</p>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Game | Consolicious</title>
    <link rel="stylesheet" href="spacestyles.css"> <!-- Link ke stylesheet eksternal -->
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
                <li><a href="profile.php">PROFILE</a></li>
            </ul>
        </nav>
    </header>

    <!-- Main Content Section -->
    <main>
        <!-- Game Detail Section -->
        <section class="game-detail">
            <div class="game-detail-container">
                <div class="image-container">
                    <img src="<?php echo $game['image_path']; ?>" alt="<?php echo $game['game_name']; ?>">
                </div>
                <div class="game-info">
                    <h2 class="game-title"><?php echo $game['game_name']; ?></h2>
                    <p>Genre: <?php echo $game['genre']; ?></p>
                    <p class="game-price">Harga: Rp<?php echo $game['harga_perhari']; ?>/hari</p>
                    <p class="game-availability">Status: <?php echo $game['keterangan']; ?></p>
                    <p class="game-description"><?php echo $game['deskripsi']; ?></p>
                    <a href="bookgame.php?game_id=<?= $game['game_id']; ?>" class="rent-button">Sewa Sekarang</a>
                </div>
            </div>
        </section>

        <!-- Recommendation Section -->
        <section class="game-recommendation">
            <h2>Rekomendasi Game Lain</h2>
            <div class="recommendation-grid">
                <?php while ($recommendation = $recommendation_result->fetch_assoc()): ?>
                    <div class="recommendation-item">
                        <img src="<?php echo $recommendation['image_path']; ?>" alt="<?php echo $recommendation['game_name']; ?>">
                        <h3><?php echo $recommendation['game_name']; ?></h3>
                        <p>Rp<?php echo $recommendation['harga_perhari']; ?>/hari</p>
                        <a href="games_detail.php?game_id=<?= $recommendation['game_id']; ?>" class="view-button">Lihat Detail</a>
                    </div>
                <?php endwhile; ?>
            </div>
        </section>
    </main>

    <!-- Footer Section -->
    <footer>
        <p>&copy; 2024 Consolicious. All rights reserved.</p>
    </footer>
</body>
</html>
