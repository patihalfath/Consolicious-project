<?php
session_start();
include 'connection.php';

if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Anda harus login untuk melihat riwayat pemesanan!'); window.location.href = 'login.php';</script>";
    exit();
}

$user_id = $_SESSION['user_id'];

$sql = "
    SELECT 'PlayStation' AS console, product_name, rental_date, quantity, total_price
    FROM sewa_ps WHERE user_id = ?
    UNION ALL
    SELECT 'Xbox' AS console, product_name, rental_date, quantity, total_price
    FROM sewa_xbox WHERE user_id = ?
    UNION ALL
    SELECT 'Switch' AS console, product_name, rental_date, quantity, total_price
    FROM sewa_switch WHERE user_id = ?
    ORDER BY rental_date DESC
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("iii", $user_id, $user_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order History</title>
    <link rel="stylesheet" href="keranjang.css">
</head>
<body>
    <div class="order-history-container">
        <header class="order-header">
            <h1>Order History</h1>
            <nav>
                <a href="#" class="active">All Orders (<?php echo $result->num_rows; ?>)</a>
            </nav>
        </header>

        <div class="filters">
            <input type="text" class="search-bar" placeholder="Search...">
            <div class="date-filters">
                <input type="date">
                <span>To</span>
                <input type="date">
            </div>
            <button class="sort-button">Urutkan</button>
        </div>

        <table class="order-table">
            <thead>
                <tr>
                    <th>Jenis Konsol</th>
                    <th>Nama Produk</th>
                    <th>Tanggal Sewa</th>
                    <th>Jumlah</th>
                    <th>Total Harga</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['console']); ?></td>
                            <td><?php echo htmlspecialchars($row['product_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['rental_date']); ?></td>
                            <td><?php echo htmlspecialchars($row['quantity']); ?></td>
                            <td>Rp <?php echo number_format($row['total_price'], 0, ',', '.'); ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5">Belum ada riwayat pemesanan.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
