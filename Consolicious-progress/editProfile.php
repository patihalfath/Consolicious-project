<?php
session_start();
include 'connection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];


$success_message = $error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);

    if (!empty($name) && !empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $update_sql = "UPDATE users SET name = ?, email = ?, phone = ?, address = ? WHERE user_id = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("ssssi", $name, $email, $phone, $address, $user_id);

        if ($update_stmt->execute()) {
            session_destroy();
            $success_message = "Profile Anda Berhasil Diperbarui, silahkan login ulang.";
        } else {
            $error_message = "Gagal memperbarui profil: " . $conn->error;
        }
    } else {
        $error_message = "Nama dan email wajib diisi dengan benar!";
    }
} else {
    $query = "SELECT name, email, phone, address FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    $name = $user['name'] ?? "";
    $email = $user['email'] ?? "";
    $phone = $user['phone'] ?? "";
    $address = $user['address'] ?? "";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile - Consolicious</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <section class="edit-profile-section">
        <h2>Edit Profile</h2>

        <?php if (!empty($success_message)) { ?>
            <p style="color: green; text-align: center;"><?php echo $success_message; ?></p>
            <a href="login.php" class="btn">Login Ulang</a>
            <?php exit(); ?>
        <?php } ?>

        <?php if (!empty($error_message)) { ?>
            <p style="color: red; text-align: center;"><?php echo $error_message; ?></p>
        <?php } ?>

        <form action="editProfile.php" method="POST" class="edit-profile-form">
            <label for="name">Nama:</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>

            <label for="phone">No. Telepon:</label>
            <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($phone); ?>">

            <label for="address">Alamat:</label>
            <textarea id="address" name="address"><?php echo htmlspecialchars($address); ?></textarea>

            <button type="submit" class="btn">Simpan Perubahan</button>
        </form>
    </section>
</body>
</html>
