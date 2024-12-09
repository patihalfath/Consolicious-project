<?php
include 'connection.php';
session_start();

// Cek apakah form sudah di-submit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['sewa_game_id']) && isset($_FILES['bukti_bayar'])) {
    $sewa_game_id = $_POST['sewa_game_id'];

    // Validasi file
    $file = $_FILES['bukti_bayar'];
    $fileName = $file['name'];
    $fileTmpName = $file['tmp_name'];
    $fileSize = $file['size'];
    $fileError = $file['error'];
    $fileType = $file['type'];

    // Batasi jenis file yang diizinkan
    $allowed = ['jpg', 'jpeg', 'png'];
    $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    if (in_array($fileExt, $allowed)) {
        if ($fileError === 0) {
            if ($fileSize < 3000000) { // Maksimal ukuran file 3MB
                // Buat nama file unik
                $newFileName = uniqid('bukti_', true) . '.' . $fileExt;
                $uploadDir = 'buktibayar/';
                $uploadPath = $uploadDir . $newFileName;

                // Pindahkan file ke direktori uploads
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true); // Buat folder jika belum ada
                }

                if (move_uploaded_file($fileTmpName, $uploadPath)) {
                    // Simpan path file ke database pada kolom `buktibayar`
                    $stmt = $conn->prepare("UPDATE sewa_game SET buktibayar = ? WHERE sewa_game_id = ?");
                    $stmt->bind_param("si", $uploadPath, $sewa_game_id);

                    if ($stmt->execute()) {
                        echo '<script>
                                alert("Pembayaran berhasil!"); 
                                window.location.href = "game.php"; 
                            </script>';
                    } else {
                        echo "Gagal menyimpan bukti pembayaran ke database.";
                    }
                } else {
                    echo "Gagal mengunggah file.";
                }
            } else {
                echo "File terlalu besar. Maksimal 2MB.";
            }
        } else {
            echo "Terjadi kesalahan saat mengunggah file.";
        }
    } else {
        echo "Format file tidak diizinkan. Hanya JPG, JPEG, dan PNG.";
    }
} else {
    echo "Data tidak valid.";
}
?>
