<?php
include 'connection.php'; // Menyertakan file koneksi database

// Query untuk mengambil data game dari tabel 'games'
$sql = "SELECT * FROM games";
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search = $conn->real_escape_string($_GET['search']);
    $sql .= " WHERE game_name LIKE '%$search%'";
}
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Available Games | Consolicious</title>
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
                <li><a href="profile.php">PROFILE</a></li>
            </ul>
        </nav>
        <!-- Search Form -->
        <form action="game.php" method="GET" class="search-form">
            <input type="text" name="search" placeholder="Search games..." 
                   value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
            <button type="submit">Search</button>
        </form>
    </header>

    <!-- Main Content Section -->
    <main>
        <section class="games">
            <h2>Take it and play your game now</h2>
            <div class="game-grid">
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<div class="game-item">
                            <img src="' . htmlspecialchars($row['image_path']) . '" alt="' . htmlspecialchars($row['game_name']) . '" />
                            <h3>' . htmlspecialchars($row['game_name']) . '</h3>
                            <p>Genre: ' . htmlspecialchars($row['genre']) . '</p>
                            <p>Harga per hari: <strong>Rp' . number_format($row['harga_perhari'], 0, ',', '.') . '</strong></p>
                            <p>' . htmlspecialchars($row['keterangan']) . '</p>
                            <a href="games_detail.php?game_id=' . intval($row['game_id']) . '">
                                <button>Mainkan Sekarang</button>
                            </a>
                        </div>';
                    }
                } else {
                    echo '<p class="no-games">Tidak ada game yang ditemukan. Silakan cari dengan kata kunci lain.</p>';
                }
                ?>
            </div>
        </section>
    </main>

    <!-- Footer Section -->
    <footer>
        <p>&copy; 2024 Consolicious. All rights reserved.</p>
    </footer>
</body>
</html>

<?php
// Menutup koneksi database
$conn->close();
?>
