<?php
session_start();
include 'connection.php';

$is_logged_in = isset($_SESSION['user_id']);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['rent_now'])) {
    if (!$is_logged_in) {
        echo "<script>alert('Anda harus login untuk menyewa barang!'); window.location.href = 'login.php';</script>";
        exit();
    }

    $user_id = $_SESSION['user_id'];
    $product_name = $_POST['product_name'];
    $quantity = (int)$_POST['quantity'];
    $price = (int)$_POST['price'];
    $total_price = $quantity * $price;
    $rental_date = date('Y-m-d');

    $sql = "INSERT INTO sewa_xbox (user_id, product_name, quantity, rental_date, total_price)
            VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isisi", $user_id, $product_name, $quantity, $rental_date, $total_price);

    if ($stmt->execute()) {
        echo "<script>alert('Penyewaan berhasil!'); window.location.href = 'dashboard.php';</script>";
    } else {
        echo "<script>alert('Terjadi kesalahan saat menyimpan data sewa.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sewa Produk - Consolicious</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }
        .container {
            max-width: 800px;
            margin: 30px auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .product {
            display: flex;
            gap: 20px;
        }
        .product img {
            max-width: 300px;
            border-radius: 8px;
        }
        .product-details {
            flex: 1;
        }
        .product-details h1 {
            margin: 0;
            font-size: 24px;
        }
        .price {
            color: #e60023;
            font-size: 20px;
            margin: 10px 0;
        }
        .cta button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .cta button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <header>
        <h1>Consolicious</h1>
    </header>
    <div class="container">
        <div class="product">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT7rPVNiuN-A9wSlOMudX6brvCOU5kHvE0xHQ&s" alt="Xbox">
            <div class="product-details">
                <h1>Xbox</h1>
                <p class="price">Rp 7.800.000</p>
                <p>Pengalaman bermain generasi baru dengan Xbox.</p>

                <form method="POST" action="">
                    <div class="quantity-selector">
                        <label for="quantity">Jumlah:</label>
                        <input type="number" id="quantity" name="quantity" value="1" min="1" max="10">
                    </div>
                    <input type="hidden" name="product_name" value="Xbox">
                    <input type="hidden" name="price" value="7800000"><br>
                    <button type="submit" name="rent_now">Sewa Sekarang</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
