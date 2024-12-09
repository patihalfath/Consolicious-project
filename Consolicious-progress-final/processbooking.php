<?php
session_start();
include 'connection.php';

// Cek apakah pengguna login
if (!isset($_SESSION['user_id'])) {
    die("Anda harus login untuk melakukan pemesanan.");
}

$user_id = $_SESSION['user_id'];
$space_id = $_POST['space_id'] ?? null;
$name = $_POST['name'] ?? '';
$date = $_POST['date'] ?? '';
$start_time = $_POST['start_time'] ?? '';
$end_time = $_POST['end_time'] ?? '';

// Cek apakah semua data sudah terisi
if (empty($name) || empty($date) || empty($start_time) || empty($end_time) || !$space_id) {
    $status = "Gagal! Semua data harus diisi.";
} else {
    // Insert data pemesanan ke tabel bookings
    $stmt = $conn->prepare("INSERT INTO bookings (user_id, space_id, name, booking_date, start_time, end_time) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iissss", $user_id, $space_id, $name, $date, $start_time, $end_time);

    if ($stmt->execute()) {
        $status = "Pemesanan berhasil!";
        // Generate QR code link
        $qr_content = "Booking ID: " . $stmt->insert_id;  // Or other details related to the booking
        $qr_code_url = "https://api.qrserver.com/v1/create-qr-code/?data=" . urlencode($qr_content) . "&size=200x200";
    } else {
        $status = "Pemesanan gagal. Silakan coba lagi.";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Pemesanan | Consolicious</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* CSS untuk modal pop-up */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            padding-top: 60px;
        }

        .modal-content {
            background-color: #fff;
            margin: auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 400px;
            text-align: center;
        }

        .modal-content h2 {
            margin-bottom: 20px;
        }

        .modal-content img {
            margin-bottom: 20px;
        }

        .modal-content button {
            padding: 10px 20px;
            background-color: #1a1a2e;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 1rem;
        }

        .modal-content button:hover {
            background-color: #333;
        }
    </style>
</head>
<body>
    <!-- Modal Pop-up -->
    <div id="statusModal" class="modal">
        <div class="modal-content">
            <h2><?php echo $status; ?></h2>
            <?php if ($status === "Pemesanan berhasil!") : ?>
                <!-- Menampilkan QR code -->
                <img src="<?= $qr_code_url; ?>" alt="QR Code">
                <p>Harap SS QR ini, dan tunjukkan ke kasir</p>
            <?php endif; ?>
            <button onclick="closeModal()">Tutup</button>
        </div>
    </div>

    <script>
        // Menampilkan modal pop-up
        window.onload = function() {
            document.getElementById('statusModal').style.display = 'block';
        };

        // Menutup modal
        function closeModal() {
            document.getElementById('statusModal').style.display = 'none';
            // Jika pemesanan berhasil, arahkan ke halaman lain
            <?php if ($status === "Pemesanan berhasil!") { ?>
                window.location.href = 'dashboard.php';
            <?php } ?>
        }
    </script>
</body>
</html>
