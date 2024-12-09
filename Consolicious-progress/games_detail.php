<?php
include 'connection.php';

if (isset($_GET['game_id'])) {
    $game_id = $_GET['game_id'];

    $sql = "SELECT * FROM games WHERE game_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $game_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $game = $result->fetch_assoc();
    } else {
        echo "<p>Game not found.</p>";
        exit();
    }
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
        <section class="game-detail">
            <div class="game-detail-container">
                <div class="image-container">
                    <img src="<?php echo $game['image_path']; ?>" alt="<?php echo $game['game_name']; ?>">
                </div>
                <div class="game-info">
                    <div class="game-title"><?php echo $game['game_name']; ?>
                    <p>Genre:<?php echo $game['genre']; ?></p>
                    <div class="game-price">Harga: Rp<?php echo $game['harga_perhari']; ?>/hari
                    <div class="game-availability"><?php echo $game['keterangan']; ?>
                    <p><?php echo $game['deskripsi']; ?></p>
                </p>
                <button class="rent-button">Sewa Sekarang</button>
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 Consolicious. All rights reserved.</p>
    </footer>
</body>
</html>

<?php
$conn->close();
?>
