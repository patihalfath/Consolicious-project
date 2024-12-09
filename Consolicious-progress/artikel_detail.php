<?php
include 'connection.php';


if (isset($_GET['artikel_id'])) {
    $game_id = $_GET['artikel_id'];

    $sql = "SELECT * FROM artikel WHERE artikel_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $game_id);
    $stmt->execute();
    $result = $stmt->get_result();
    

    if ($result->num_rows > 0) {
        $game = $result->fetch_assoc();
    } else {
        echo "<p>Artikel not found.</p>";
        exit();
    }
} else {
    echo "<p>Artikel is missing.</p>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Artikel Games| Consolicious</title>
    <link rel="stylesheet" href="artikelstyle.css">
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
                <li><a href="artikel.html">ARTIKEL</a></li>
                <li><a href="game.php">GAME</a></li>
                <li><a href="profile.php">PROFILE</a></li>
            </ul>
        </nav>
    </header>

    <main>
    <section class="game-detail">
    <div class="game-detail-container">
        <img src="<?php echo $game['image_path']; ?>" alt="<?php echo $game['artikel_title']; ?>">
        <h3><?php echo $game['artikel_title']; ?></h3>
        <p><strong>Deskripsi:</strong> <?php echo $game['deskripsi']; ?></p>
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
