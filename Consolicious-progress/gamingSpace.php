<?php
include 'connection.php';

$sql = "SELECT * FROM gaming_space";
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search = $conn->real_escape_string($_GET['search']);
    $sql .= " WHERE nama_space LIKE '%$search%'";
}
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Available Gaming Spaces | Consolicious</title>
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
                <li><a href="game.php">GAME</a></li>
                <li><a href="artikel.php">ARTIKEL</a></li>
                <li><a href="profile.php">PROFILE</a></li>
            </ul>
        </nav>
    <form action="gaming_space.php" method="GET" class="search-form">
        <input type="text" name="search" placeholder="Search gaming spaces..." 
               value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
        <button type="submit">Search</button>
    </form>
    </header>

    <main>
        <section class="gaming-spaces">
            <h2>Find and Book Your Gaming Space Now</h2>
            <div class="space-grid">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="space-item">
                        <img src="' . $row['image_path'] . '" alt="' . $row['nama_space'] . '" />
                        <h3>' . $row['nama_space'] . '</h3>
                        <p>Lokasi: ' . $row['lokasi'] . '<br>Harga per jam: Rp' . $row['harga_space_perjam'] . '</p>
                        <p>' . $row['keterangan'] . '</p>
                        <a href="space_detail.php?space_id=' . $row['space_id'] . '">
                            <button>Book Sekarang</button>
                        </a>
                    </div>';
                }
            } else {
                echo "<p>No gaming spaces available at the moment.</p>";
            }
            ?>
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
