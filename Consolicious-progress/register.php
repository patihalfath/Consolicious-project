<?php
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password =$_POST['password']; 
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    $sql_check = "SELECT * FROM users WHERE email = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("s", $email);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        $error_message = "Email sudah terdaftar!";
    } else {
        $sql = "INSERT INTO users (name, email, password, phone, address) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $name, $email, $password, $phone, $address);

        if ($stmt->execute()) {
            $success_message = "Pendaftaran berhasil! Silakan login.";
        } else {
            $error_message = "Terjadi kesalahan. Silakan coba lagi.";
        }

        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Consolicious</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <section class="register-section">
        <h2>Register</h2>
        <?php
        if (isset($error_message)) {
            echo "<p style='color: red; text-align: center;'>$error_message</p>";
        }
        if (isset($success_message)) {
            echo "<p style='color: green; text-align: center;'>$success_message</p>";
        }
        ?>
        <form action="register.php" method="POST" class="register-form">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" placeholder="Enter your name" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" placeholder="Enter your email" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" placeholder="Create a password" required>

            <label for="phone">Phone:</label>
            <input type="text" id="phone" name="phone" placeholder="Enter your phone number" required>

            <label for="address">Address:</label>
            <textarea id="address" name="address" placeholder="Enter your address" required></textarea>

            <button type="submit" class="register-btn">Register</button>
        </form>
        <p>Sudah punya akun? <a href="login.php">Login di sini</a>.</p>
    </section>
</body>
</html>
