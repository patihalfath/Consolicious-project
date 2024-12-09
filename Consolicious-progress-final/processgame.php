<?php
include 'connection.php'; // Menyertakan koneksi database

// Pastikan pengguna sudah login dan memiliki user_id
session_start();
if (!isset($_SESSION['user_id'])) {
    die("Anda harus login untuk melakukan pemesanan.");
}

$user_id = $_SESSION['user_id'];

// Ambil data dari form
if (isset($_POST['game_id'], $_POST['user_id'], $_POST['name'], $_POST['date'], $_POST['duration'])) {
    $game_id = $_POST['game_id'];
    $name = $_POST['name'];
    $date = $_POST['date'];
    $duration = $_POST['duration'];

    // Ambil harga per hari game
    $stmt = $conn->prepare("SELECT game_name, harga_perhari FROM games WHERE game_id = ?");
    $stmt->bind_param("i", $game_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $game = $result->fetch_assoc();
    if ($game) {
        $game_name = $game['game_name'];
        $harga_perhari = $game['harga_perhari'];
        $harga_sewagame_total = $harga_perhari * $duration;

        // Hitung tanggal selesai sewa
        $tanggal_sewa_game = new DateTime($date);
        $tanggal_selesai_sewa_game = $tanggal_sewa_game->modify("+$duration days")->format('Y-m-d');

        // Masukkan data pemesanan ke dalam tabel sewa_game
        $stmt = $conn->prepare("INSERT INTO sewa_game (game_id, user_id, tanggal_sewa_game, tanggal_selesai_sewa_game, harga_sewagame_total) 
                                VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("iissd", $game_id, $user_id, $date, $tanggal_selesai_sewa_game, $harga_sewagame_total);
        
        if ($stmt->execute()) {
            $sewa_game_id = $stmt->insert_id; // ID pemesanan yang baru dibuat

            // Tampilkan informasi pemesanan
            ?>
            <!DOCTYPE html>
            <html lang="id">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Konfirmasi Pemesanan | Consolicious</title>
                <link rel="stylesheet" href="bookstyles.css"> <!-- Link ke CSS -->
            </head>
            <body>
                <header>
                    <div class="logo">
                        <h1>Consolicious</h1>
                    </div>
                </header>

                <main-pro>
                    <div class="booking-confirmation">
                        <h2>Konfirmasi Pemesanan</h2>
                        <p><strong>Nama Pemesan:</strong> <?= htmlspecialchars($name) ?></p>
                        <p><strong>Game yang Dipesan:</strong> <?= htmlspecialchars($game_name) ?></p>
                        <p><strong>Tanggal Pemesanan:</strong> <?= htmlspecialchars($date) ?></p>
                        <p><strong>Tanggal Selesai Sewa:</strong> <?= htmlspecialchars($tanggal_selesai_sewa_game) ?></p>
                        <p><strong>Durasi Sewa:</strong> <?= htmlspecialchars($duration) ?> hari</p>
                        <p><strong>Total Harga Sewa:</strong> Rp <?= number_format($harga_sewagame_total, 0, ',', '.') ?></p>
                        
                        <div class="button-container">
                            <!-- Tombol Kembali -->
                            <a href="javascript:void(0);" id="back-button" class="button back-button" onclick="cancelBooking(<?= $sewa_game_id ?>)">Kembali</a>
                            <!-- Tombol Bayar -->
                            <a href="javascript:void(0);" class="button pay-button" onclick="showQR()">Bayar</a>
                        </div>

                        <!-- QR Code dan tombol konfirmasi pembayaran -->
                        <div id="qr-container" style="display: none;">
                            <h3>QR Code Pembayaran</h3>
                            <!-- Menampilkan QR Code dari file asset -->
                            <img id="qr-code" src="asset/qr_code.png" alt="QR Code Pembayaran" class="qr-image" />
                            <button class="confirm-button" onclick="confirmPayment()">Konfirmasi Pembayaran</button>
                        </div>

                        <div id="upload-form-container" style="display: none; margin-top: 20px;">
                            <h3>Upload Bukti Pembayaran</h3>
                            <form action="payment.php" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="sewa_game_id" value="<?= $sewa_game_id ?>">
                                <label for="bukti-bayar">Unggah Bukti Pembayaran:</label>
                                <input type="file" name="bukti_bayar" id="bukti-bayar" accept="image/*" required>
                                <button type="submit" class="button upload-button">Upload</button>
                            </form>
                        </div>
                        <script src="script.js"></script>
                    </div>
                </main-pro>

                <footer>
                    <p>&copy; 2024 Consolicious. All rights reserved.</p>
                </footer>

            </body>
            </html>
            <?php
        } else {
            echo "Terjadi kesalahan, pemesanan gagal.";
        }
    } else {
        echo "Game tidak ditemukan.";
    }
} else {
    echo "Data pemesanan tidak lengkap.";
}
?>