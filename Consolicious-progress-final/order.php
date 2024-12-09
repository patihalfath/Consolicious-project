<?php
include 'connection.php'; // Menyertakan file koneksi database

// Memulai sesi untuk mengambil informasi pengguna yang login
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fungsi untuk menghapus data berdasarkan tabel dan ID
function deleteRecord($conn, $table, $id_column, $id_value) {
    $sql = "DELETE FROM $table WHERE $id_column = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_value);
    return $stmt->execute();
}

// Hapus riwayat berdasarkan parameter URL
if (isset($_GET['delete_type'], $_GET['delete_id'])) {
    $delete_type = $_GET['delete_type'];
    $delete_id = (int) $_GET['delete_id']; // Pastikan parameter ID adalah angka

    $tables = [
        'Game' => ['table' => 'sewa_game', 'id_column' => 'sewa_game_id'],
        'PlayStation' => ['table' => 'sewa_ps', 'id_column' => 'id'],
        'Xbox' => ['table' => 'sewa_xbox', 'id_column' => 'id'],
        'Switch' => ['table' => 'sewa_switch', 'id_column' => 'id'],
    ];

    if (array_key_exists($delete_type, $tables)) {
        $table_info = $tables[$delete_type];
        if (deleteRecord($conn, $table_info['table'], $table_info['id_column'], $delete_id)) {
            echo "<script>alert('Data {$delete_type} berhasil dihapus!'); window.location.href='order.php';</script>";
        } else {
            echo "<script>alert('Gagal menghapus data {$delete_type}.');</script>";
        }
    } else {
        echo "<script>alert('Jenis penyewaan tidak valid.'); window.location.href='order.php';</script>";
    }
}

// Query untuk mengambil riwayat pemesanan
$sql = "
    SELECT 
        'PlayStation' AS console_type,
        product_name, 
        quantity, 
        rental_date, 
        total_price, 
        user_name, 
        user_phone, 
        user_address, 
        payment_method, 
        id AS sewa_id
    FROM sewa_ps
    UNION
    SELECT 
        'Xbox' AS console_type,
        product_name, 
        quantity, 
        rental_date, 
        total_price, 
        user_name, 
        user_phone, 
        user_address, 
        payment_method, 
        id AS sewa_id
    FROM sewa_xbox
    UNION
    SELECT 
        'Switch' AS console_type,
        product_name, 
        quantity, 
        rental_date, 
        total_price, 
        user_name, 
        user_phone, 
        user_address, 
        payment_method, 
        id AS sewa_id
    FROM sewa_switch
    UNION
    SELECT 
        'Game' AS console_type,
        g.game_name AS product_name, 
        sg.quantity, 
        sg.tanggal_sewa_game AS rental_date, 
        sg.harga_sewagame_total AS total_price, 
        u.name AS user_name, 
        u.phone AS user_phone, 
        u.address AS user_address, 
        sg.payment_method, 
        sg.sewa_game_id AS sewa_id
    FROM sewa_game sg
    JOIN games g ON sg.game_id = g.game_id
    JOIN users u ON sg.user_id = u.user_id
    WHERE sg.user_id = ?
    ORDER BY rental_date DESC
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $_SESSION['user_id']); // Bind user_id dari session untuk mengambil riwayat
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order History | Consolicious</title>
    <link rel="stylesheet" href="orderr.css"> <!-- Link ke stylesheet eksternal -->
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
    </header>

    <!-- Main Content Section -->
    <main>
        <section class="order-history">
            <h2>Riwayat Pemesanan Anda</h2>

            <?php if ($result->num_rows > 0): ?>
                <table class="order-table">
                    <thead>
                        <tr>
                            <th>Jenis Penyewaan</th>
                            <th>Nama Produk</th>
                            <th>Jumlah</th>
                            <th>Total Harga</th>
                            <th>Alamat Tujuan</th>
                            <th>Metode Pembayaran</th>
                            <th>Waktu Pemesanan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['console_type']) ?></td>
                                <td><?= htmlspecialchars($row['product_name']) ?></td>
                                <td><?= htmlspecialchars($row['quantity']) ?></td>
                                <td>Rp <?= number_format($row['total_price'], 0, ',', '.') ?></td>
                                <td><?= htmlspecialchars($row['user_address']) ?></td>
                                <td><?= htmlspecialchars($row['payment_method']) ?></td>
                                <td><?= date("d-m-Y H:i:s", strtotime($row['rental_date'])) ?></td>
                                <td>
                                    <a href="?delete_type=<?= $row['console_type'] ?>&delete_id=<?= $row['sewa_id'] ?>" 
                                       onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                       🗑️
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>Belum ada transaksi yang dilakukan.</p>
            <?php endif; ?>
        </section>
    </main>

    <!-- Footer Section -->
    <footer>
        <p>&copy; 2024 Consolicious. All rights reserved.</p>
    </footer>
</body>
</html>

<?php $conn->close(); ?>
