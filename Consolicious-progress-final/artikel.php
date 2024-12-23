<?php
include 'connection.php'; // Menyertakan file koneksi database

// Query untuk mengambil data game dari tabel 'games'
$sql = "SELECT * FROM artikel";
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search = $conn->real_escape_string($_GET['search']);
    $sql .= " WHERE artikel_title LIKE '%$search%'";
}
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Available Games | Consolicious</title>
    <link rel="stylesheet" href="artikelstyle.css"> <!-- Link ke stylesheet eksternal -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

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
                <li><a href="game.php">GAME</a></li>
                <li><a href="profile.php">PROFILE</a></li>
            </ul>
        </nav>
        <!-- Search Form -->
        <form action="artikel.php" method="GET" class="search-form">
            <input type="text" name="search" placeholder="Search artikel..." 
                   value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
            <button type="submit">Search</button>
        </form>
    </header>

    <!-- Main Content Section -->
    <main>
        <section class="games">
            <h2>Simak Artikel Terbaru Seputar Dunia Games!</h2>
            <div class="game-grid">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="game-item">
                        <img src="' . $row['image_path'] . '" alt="' . $row['artikel_title'] . '" />
                        <h3>' . $row['artikel_title'] . '</h3>
                        <p>' . $row['deskripsi'] . '</p>
                        <a href="artikel_detail.php?artikel_id=' . $row['artikel_id'] . '">Read More</a>
                    </div>';
                }
            } else {
                echo "<p>No articles available at the moment.</p>";
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