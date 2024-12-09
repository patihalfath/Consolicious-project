<?php
session_start();
include 'connection.php';

// Pastikan pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Ambil user_id dari session
$user_id = $_SESSION['user_id'];

// Inisialisasi pesan
$success_message = $error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $current_password = trim($_POST['current_password']);
    $new_password = trim($_POST['new_password']);
    $confirm_password = trim($_POST['confirm_password']);

    if (!empty($current_password) && !empty($new_password) && !empty($confirm_password)) {
        if ($new_password === $confirm_password) {
            // Ambil password saat ini dari database
            $query = "SELECT password FROM users WHERE user_id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();

            if ($user && $current_password === $user['password']) { // Perbandingan langsung
                // Update password baru di database
                $update_query = "UPDATE users SET password = ? WHERE user_id = ?";
                $update_stmt = $conn->prepare($update_query);
                $update_stmt->bind_param("si", $new_password, $user_id);

                if ($update_stmt->execute()) {
                    $success_message = "Password berhasil diubah. Silakan login ulang.";
                    session_destroy(); // Hancurkan sesi setelah berhasil
                    header("refresh:3; url=login.php");
                } else {
                    $error_message = "Gagal mengubah password. Silakan coba lagi.";
                }
            } else {
                $error_message = "Password saat ini salah!";
            }
        } else {
            $error_message = "Konfirmasi password tidak cocok.";
        }
    } else {
        $error_message = "Semua bidang harus diisi.";
    }
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <link rel="stylesheet" href="profile.css">
</head>
<body>
    <header>
        <div class="logo">
            <h1>Consolicious</h1>
        </div>
        <nav>
            <ul>
                <li><a href="profile.php">Back to Profile</a></li>
            </ul>
        </nav>
    </header>
    <main class="profile-section">
        <div class="profile-card">
            <h2>Ubah Password</h2>

            <!-- Tampilkan pesan sukses -->
            <?php if (!empty($success_message)): ?>
                <p style="color: green; font-weight: bold; text-align: center;"><?php echo $success_message; ?></p>
            <?php endif; ?>

            <!-- Tampilkan pesan error -->
            <?php if (!empty($error_message)): ?>
                <p style="color: red; font-weight: bold; text-align: center;"><?php echo $error_message; ?></p>
            <?php endif; ?>

            <!-- Form Ubah Password -->
            <form method="POST" action="change_password.php">
    <div class="form-row">
        <label for="current_password">Password Saat Ini:</label>
        <input type="password" id="current_password" name="current_password" required placeholder="Masukkan password saat ini" class="input-field">
    </div>
    <div class="form-row">
        <label for="new_password">Password Baru:</label>
        <input type="password" id="new_password" name="new_password" required placeholder="Masukkan password baru" class="input-field">
    </div>
    <div class="form-row">
        <label for="confirm_password">Konfirmasi Password Baru:</label>
        <input type="password" id="confirm_password" name="confirm_password" required placeholder="Konfirmasi password baru" class="input-field">
    </div>
    <div class="profile-actions">
        <button type="submit" class="btn">Change Password</button>
        <a href="profile.php" class="btn" style="background-color: #e74c3c;">Cancel</a>
    </div>
</form>
        </div>
    </main>
    <footer>
        <p>&copy; 2024 Consolicious. All rights reserved.</p>
    </footer>
</body>
</html>
