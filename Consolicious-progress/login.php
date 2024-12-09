<?php
session_start();
include 'connection.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $sql = "SELECT * FROM users WHERE email = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $_SESSION['user_id'] = $user['user_id']; 
        $_SESSION['name'] = $user['name'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['address'] = $user['address'];
        $_SESSION['phone'] = $user['phone'];
        header("Location: dashboard.php");
        exit();
    } else {
        $error_message = "Email atau password salah!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Consolicious</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <section class="login-section">
        <div class="login-container">
            <h2>Login</h2>
            <?php if (isset($error_message)) { ?>
                <p class="error-message"><?php echo $error_message; ?></p>
            <?php } ?>
            <form action="login.php" method="POST" class="login-form">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" required>

                <button type="submit" class="login-btn">Login</button>
            </form>
            <p>Belum punya akun? <a href="register.php">Daftar di sini</a>.</p>
        </div>
    </section>
</body>
</html>
