<?php
include 'connection.php';
session_start();

// Cek apakah ada parameter sewa_game_id di URL
if (isset($_GET['sewa_game_id'])) {
    $sewa_game_id = $_GET['sewa_game_id'];

    // Pastikan ID yang diterima valid
    if (is_numeric($sewa_game_id)) {
        // Query untuk menghapus data berdasarkan sewa_game_id
        $stmt = $conn->prepare("DELETE FROM sewa_game WHERE sewa_game_id = ?");
        $stmt->bind_param("i", $sewa_game_id);

        if ($stmt->execute()) {
            // Jika berhasil, redirect ke halaman game.php
            header("Location: game.php");
            exit(); // Pastikan script berhenti setelah redirect
        } else {    
            echo "Gagal menghapus pemesanan.";
        }
    } else {
        echo "ID pemesanan tidak valid.";
    }
} else {
    echo "Data tidak ditemukan.";
}
?>
