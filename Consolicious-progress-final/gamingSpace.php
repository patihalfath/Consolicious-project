<?php
include 'connection.php'; // Menyertakan file koneksi database

// Query dasar untuk mengambil data gaming spaces
$sql = "SELECT * FROM gaming_space";
$params = [];

// Pencarian jika parameter 'search' ada
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search = '%' . $conn->real_escape_string($_GET['search']) . '%';
    $sql .= " WHERE nama_space LIKE ?";
    $params[] = $search;
}

// Siapkan query menggunakan prepared statement
$stmt = $conn->prepare($sql);

// Bind parameter jika ada
if (!empty($params)) {
    $stmt->bind_param("s", $params[0]);
}

$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Available Gaming Spaces | Consolicious</title>
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
                <li><a href="game.php">GAME</a></li>
                <li><a href="artikel.php">ARTIKEL</a></li>
                <li><a href="profile.php">PROFILE</a></li>
            </ul>
        </nav>
        <!-- Search Form -->
        <form action="gaming_space.php" method="GET" class="search-form">
            <input type="text" name="search" placeholder="Search gaming spaces..." 
                   value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
            <button type="submit">Search</button>
        </form>
    </header>

    <!-- Main Content Section -->
    <main>
        <section class="gaming-spaces">
            <h2>Find and Book Your Gaming Space Now</h2>
            <div class="space-grid">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    // Validasi gambar
                    $image_path = file_exists($row['image_path']) ? $row['image_path'] : 'default.jpg';
                    echo '<div class="space-item">
                        <img src="' . htmlspecialchars($image_path) . '" alt="' . htmlspecialchars($row['nama_space']) . '" />
                        <h3>' . htmlspecialchars($row['nama_space']) . '</h3>
                        <p>Lokasi: ' . htmlspecialchars($row['lokasi']) . '<br>Harga per jam: Rp' . number_format($row['harga_space_perjam'], 0, ',', '.') . '</p>
                        <p>' . htmlspecialchars($row['keterangan']) . '</p>
                        <form action="bookGamingSpace.php" method="POST">
                            <input type="hidden" name="space_id" value="' . htmlspecialchars($row['space_id']) . '">
                            <button type="submit">Book Sekarang</button>
                        </form>
                    </div>';
                }
            } else {
                echo "<p>No gaming spaces available at the moment.</p>";
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

