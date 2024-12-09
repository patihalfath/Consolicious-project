<?php
include 'connection.php'; 

if (isset($_GET['artikel_id'])) {
    $artikel_id = $_GET['artikel_id']; 

    $sql = "SELECT * FROM artikel WHERE artikel_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $artikel_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $artikel = $result->fetch_assoc(); 

        // Ambil path file
        $file_path = $artikel['file_path'];

        // Cek apakah file ada
        if (file_exists($file_path)) {
            $isi_artikel = file_get_contents($file_path);
        } else {
            $isi_artikel = "<p>Isi artikel tidak ditemukan.</p>";
        }
    } else {
        echo "<p>Artikel tidak ditemukan.</p>";
        exit();
    }
} else {
    echo "<p>ID Artikel tidak diberikan.</p>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Artikel Games| Consolicious</title>
    <link rel="stylesheet" href="artikelstyle.css"> <!-- Link ke stylesheet eksternal -->
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
    <section class="game-detail">
    <div class="game-detail-container">
        <img src="<?php echo $artikel['image_path']; ?>" alt="<?php echo $artikel['artikel_title']; ?>">
        <h3><?php echo $artikel['artikel_title']; ?></h3>
        <p><strong>Deskripsi:</strong> <?php echo $artikel['deskripsi']; ?></p>
        <p><?php echo $isi_artikel; ?></p>
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
$conn->close(); // Menutup koneksi database
?>
