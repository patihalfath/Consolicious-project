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

// Inisialisasi variabel pesan
$success_message = $error_message = "";

// Jika form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);

    // Validasi input
    if (!empty($name) && !empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        
        // Cek apakah email sudah digunakan oleh pengguna lain
        $check_email_sql = "SELECT * FROM users WHERE email = ? AND user_id != ?";
        $check_email_stmt = $conn->prepare($check_email_sql);
        $check_email_stmt->bind_param("si", $email, $user_id);
        $check_email_stmt->execute();
        $check_result = $check_email_stmt->get_result();

        // Jika email sudah ada di database (untuk pengguna lain)
        if ($check_result->num_rows > 0) {
            $error_message = "Email sudah digunakan oleh pengguna lain. Silakan pilih email lain.";
        } else {
            // Update data pengguna di database
            $update_sql = "UPDATE users SET name = ?, email = ?, phone = ?, address = ? WHERE user_id = ?";
            $update_stmt = $conn->prepare($update_sql);

            if ($update_stmt) {
                $update_stmt->bind_param("ssssi", $name, $email, $phone, $address, $user_id);
                if ($update_stmt->execute()) {
                    // Update session dengan data yang baru
                    $_SESSION['name'] = $name;        // Menyimpan nama yang baru di session
                    $_SESSION['email'] = $email;      // Menyimpan email yang baru di session
                    $_SESSION['phone'] = $phone;      // Menyimpan nomor telepon yang baru di session
                    $_SESSION['address'] = $address;  // Menyimpan alamat yang baru di session

                    // Pesan sukses
                    $success_message = "Profil Anda berhasil diperbarui! Anda akan diarahkan ke halaman profil.";

                    // Tidak langsung redirect, beri waktu untuk melihat pesan
                    echo "<script>
                            setTimeout(function() {
                                window.location.href = 'profile.php';
                            }, 3000);  // Arahkan ke profile.php setelah 3 detik
                          </script>";
                } else {
                    $error_message = "Gagal memperbarui profil. Silakan coba lagi.";
                }
            } else {
                $error_message = "Gagal mempersiapkan query. Silakan coba lagi.";
            }
        }
    } else {
        $error_message = "Nama dan email wajib diisi dengan benar!";
    }
} else {
    // Ambil data pengguna dari database untuk ditampilkan di form
    $query = "SELECT name, email, phone, address FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($query);

    if ($stmt) {
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        // Mengambil data pengguna dari hasil query
        $name = $user['name'] ?? "";
        $email = $user['email'] ?? "";
        $phone = $user['phone'] ?? "";
        $address = $user['address'] ?? "";
    } else {
        $error_message = "Gagal mengambil data pengguna.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="profile.css">
</head>
<body>
    <header>
        <div class="logo">
            <h1>Edit Profile</h1>
        </div>
        <nav>
            <ul>
                <li><a href="profile.php">Back to Profile</a></li>
            </ul>
        </nav>
    </header>
    <main class="profile-section">
        <div class="profile-card">
            <h2>Edit Your Profile</h2>

            <!-- Tampilkan pesan sukses -->
            <?php if (!empty($success_message)): ?>
                <p style="color: green; font-weight: bold; text-align: center;"><?php echo $success_message; ?></p>
            <?php endif; ?>

            <!-- Tampilkan pesan error -->
            <?php if (!empty($error_message)): ?>
                <p style="color: red; font-weight: bold; text-align: center;"><?php echo $error_message; ?></p>
            <?php endif; ?>

            <!-- Form Edit Profile -->
            <form method="POST" action="editProfile.php" class="edit-profile-form">
    <div class="form-group">
        <label for="name">Nama:</label>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" required class="input-field">
    </div>
    <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required class="input-field">
    </div>
    <div class="form-group">
        <label for="phone">No. Telepon:</label>
        <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($phone); ?>" class="input-field">
    </div>
    <div class="form-group">
        <label for="address">Alamat:</label>
        <textarea id="address" name="address" class="input-field"><?php echo htmlspecialchars($address); ?></textarea>
    </div>
    <div class="profile-actions">
        <button type="submit" class="btn">Save Changes</button>
        <a href="profile.php" class="btn" style="background-color: #e74c3c;">Cancel</a>
    </div>
</form>
        </div>
    </main>
    <br>
    <br>
    <br>
    <footer>
        <p>&copy; 2024 Consolicious. All rights reserved.</p>
    </footer>
</body>
</html>
