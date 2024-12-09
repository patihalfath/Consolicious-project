<?php
include 'connection.php'; // Menyertakan file koneksi database

// Menangani proses pembayaran jika form disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $psType = $_POST['psType'];
    $quantity = $_POST['quantity'];
    $duration = $_POST['duration'];
    $method = $_POST['method'];

    // Menangani upload bukti pembayaran
    if (isset($_FILES['paymentProof']) && $_FILES['paymentProof']['error'] == 0) {
        $fileTmpPath = $_FILES['paymentProof']['tmp_name'];
        $fileName = $_FILES['paymentProof']['name'];
        $fileType = $_FILES['paymentProof']['type'];
        
        // Tentukan folder tujuan dan nama file yang akan disimpan
        $uploadDir = 'buktibayar/';
        $uploadFile = $uploadDir . basename($fileName);
        
        // Pindahkan file ke folder tujuan
        if (move_uploaded_file($fileTmpPath, $uploadFile)) {
            // Daftar harga per jenis PlayStation
            $prices = [
                'Playstation 5' => 10000,  // Harga per jam untuk PS5
                'Playstation 4' => 5000,   // Harga per jam untuk PS4
                'Playstation 3' => 3000    // Harga per jam untuk PS3
            ];

            // Hitung total harga
            $total_price = $prices[$psType] * $duration * $quantity;

            // Menyusun query untuk menyimpan data transaksi
            $sql = "INSERT INTO sewa_ps (product_name, quantity, rental_date, total_price, user_name, user_phone, user_address, payment_method, bukti_pembayaran)
                    VALUES (?, ?, NOW(), ?, ?, ?, ?, ?, ?)";
            
            // Menyiapkan statement
            $stmt = $conn->prepare($sql);
            // Pastikan data sesuai dengan tipe yang diterima oleh tabel (parameter binding)
            $stmt->bind_param("siisssss", $psType, $quantity, $total_price, $name, $phone, $address, $method, $uploadFile);

            // Eksekusi query dan cek apakah berhasil
            if ($stmt->execute()) {
                // Jika berhasil, tampilkan pesan sukses
                echo "<script>alert('Pembayaran berhasil, terima kasih!'); window.location.href = 'dashboard.php';</script>";
            } else {
                // Jika gagal, tampilkan pesan error
                echo "Error: " . $stmt->error;
            }
        } else {
            echo "Error uploading the payment proof file.";
        }
    }
}

// Query untuk mengambil data PlayStation
$sql = "SELECT * FROM playstation";
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search = $conn->real_escape_string($_GET['search']);
    $sql .= " WHERE playstation_jenis LIKE '%$search%'";
}
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Available Games | Consolicious</title>
    <link rel="stylesheet" href="ps.css"> <!-- Link ke stylesheet eksternal -->
</head>
<body>
    <!-- Header Section -->
    <header>
        <div class="logo">
            <h1>Consolicious</h1>
        </div>
        <nav>
            <ul>
                <li><a href="dashboard.php">HOME</a></li>
                <li><a href="gamingSpace.php">GAMING SPACE</a></li>
                <li><a href="game.php">GAME</a></li>
                <li><a href="profile.php">PROFILE</a></li>
            </ul>
        </nav>
        <form action="ps.php" method="GET" class="search-form">
            <input type="text" name="search" placeholder="Search PlayStation..." 
                   value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
            <button type="submit">Search</button>
        </form>
    </header>

    <!-- Main Content Section -->
    <main>
        <section class="games">
            <h2>Pilih Playstation yang Kamu Inginkan!</h2>
            <div class="game-grid">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="game-item">
                        <img src="' . $row['image_path'] . '" alt="' . $row['playstation_jenis'] . '" />
                        <h3>' . $row['playstation_jenis'] . '</h3>
                        <p>' . $row['deskripsi'] . '</p>
                        <p>Stok Tersedia: ' . $row['stok'] . ' unit</p>
                        <a href="javascript:void(0);" 
                           onclick="openPaymentForm(\'' . $row['playstation_jenis'] . '\')">
                           <button>Sewa Sekarang</button>
                        </a>
                    </div>';
                }
            } else {
                echo "<p>No games available at the moment.</p>";
            }
            ?>
            </div>
        </section>
    </main>

    <!-- Payment Form Modal -->
    <div id="paymentFormModal" class="payment-form-modal">
        <div class="payment-form-container">
            <span class="close-btn" onclick="closePaymentForm()">×</span>
            <h2>Form Pembayaran</h2>
            <form id="paymentForm" method="POST" action="ps.php" enctype="multipart/form-data">
                <label for="name">Nama</label>
                <input type="text" id="name" name="name" placeholder="Masukkan nama Anda" required>

                <label for="phone">No Telp Aktif</label>
                <input type="tel" id="phone" name="phone" placeholder="Masukkan nomor telp Anda" required>

                <label for="address">Alamat</label>
                <textarea id="address" name="address" placeholder="Masukkan alamat Anda" required></textarea>

                <label for="psType">Jenis PS</label>
                <input type="text" id="psType" name="psType" readonly required>

                <label for="quantity">Jumlah</label>
                <input type="number" id="quantity" name="quantity" placeholder="Jumlah unit" required>

                <label for="duration">Lama Waktu (Jam)</label>
                <input type="number" id="duration" name="duration" placeholder="Durasi waktu penyewaan" required>

                <label for="method">Jenis Pembayaran</label>
                <select id="method" name="method" required onchange="displayPaymentMethodInfo()">
                    <option value="" disabled selected>Pilih Jenis Pembayaran</option>
                    <option value="Gopay">Gopay</option>
                    <option value="Debit">Debit</option>
                    <option value="Dana">Dana</option>
                    <option value="Qris">Qris</option>
                </select>

                <p id="pricePerHour"></p> <!-- Menampilkan harga per jam -->

                <div id="qrCodeContainer" style="display:none;">
                    <p>Scan QR Code untuk pembayaran:</p>
                    <img id="qrCodeImage" src="asset/qr_code.png" alt="QR Code" />
                    <p id="totalPriceDisplay" style="margin-bottom: 10px; font-weight: bold;"></p>
                </div>

                <div id="bankDetails" style="display:none;">
                    <p id="bankInfo"></p>
                </div>

                <div id="gopayDetails" style="display:none;">
                    <p>Nomor Tujuan Gopay: <span id="gopayPhoneNumber"></span></p>
                </div>

                <div id="uploadSection" style="display:none;">
                    <label for="paymentProof">Unggah Bukti Pembayaran</label>
                    <input type="file" id="paymentProof" name="paymentProof" accept="image/*" required>
                </div>

                <button type="button" id="submitButton" onclick="showQrCode()">Lanjut</button><br>
                <button type="submit" id="continueButton" style="display:none;">Upload Bukti Pembayaran</button>
                <p id="errorMessage" style="color:red; display:none;">Isi Form dengan Lengkap</p>
            </form>
        </div>
    </div>

    <!-- Footer Section -->
    <footer>
        <p>&copy; 2024 Consolicious. All rights reserved.</p>
    </footer>

    <script>
        // Daftar harga per jenis PlayStation
        const prices = {
            'Playstation 5': 10000,  // Harga per jam untuk PS5
            'Playstation 4': 5000,   // Harga per jam untuk PS4
            'Playstation 3': 3000    // Harga per jam untuk PS3
        };

        // Open the payment form modal
        function openPaymentForm(psType) {
            // Isi field Jenis PS secara otomatis
            document.getElementById("psType").value = psType;

            // Menampilkan harga per jam sesuai dengan jenis PS yang dipilih
            const price = prices[psType] || 0;
            document.getElementById("pricePerHour").textContent = `Harga per jam: ${price}`;

            // Tampilkan modal
            document.getElementById("paymentFormModal").style.display = "block";
        }

        // Display information based on payment method
        function displayPaymentMethodInfo() {
            const method = document.getElementById("method").value;
            const bankInfo = document.getElementById("bankDetails");
            const qrCodeContainer = document.getElementById("qrCodeContainer");
            const gopayDetails = document.getElementById("gopayDetails");

            bankInfo.style.display = "none";
            qrCodeContainer.style.display = "none";
            gopayDetails.style.display = "none";

            if (method === "Gopay") {
                gopayDetails.style.display = "block";
                document.getElementById("gopayPhoneNumber").textContent = "08123456789, Atas Nama: ABC"; 
            } else if (method === "Debit") {
                document.getElementById("bankInfo").textContent = "Bank: XYZ, Atas Nama: ABC";
                bankInfo.style.display = "block";
            } else if (method === "Dana") {
                document.getElementById("bankInfo").textContent = "Nomor Tujuan Dana: 123456789, Atas Nama: ABC";
                bankInfo.style.display = "block";
            } else if (method === "Qris") {
                qrCodeContainer.style.display = "block";
            }
        }

        // Generate and display the QR code
        function showQrCode() {
    const name = document.getElementById("name").value;
    const phone = document.getElementById("phone").value;
    const address = document.getElementById("address").value;
    const psType = document.getElementById("psType").value;
    const quantity = document.getElementById("quantity").value;
    const duration = document.getElementById("duration").value;
    const method = document.getElementById("method").value;

    // Check if all fields are filled
    if (name && phone && address && psType && quantity && duration && method) {
        document.getElementById("errorMessage").style.display = "none";

        const totalPrice = prices[psType] * duration * quantity;

        // Hanya tampilkan QR code jika metode adalah Qris
        if (method === "Qris") {
            const paymentLink = "https://example.com/payment?amount=" + totalPrice;

            // Generate the QR code URL
            const qrCodeUrl = "https://api.qrserver.com/v1/create-qr-code/?data=" + encodeURIComponent(paymentLink) + "&size=200x200";

            // Show the QR code
            document.getElementById("qrCodeImage").src = qrCodeUrl;
            document.getElementById("qrCodeContainer").style.display = "block";
        } else {
            document.getElementById("qrCodeContainer").style.display = "none";
        }

        // Show the "Lanjut" button and the upload section
        document.getElementById("continueButton").style.display = "inline";
        document.getElementById("submitButton").style.display = "none";
    } else {
        // Show error message if not all fields are filled
        document.getElementById("errorMessage").style.display = "block";
    }
}


        // Show the upload section after clicking the "Lanjut" button
        document.getElementById("continueButton").onclick = function() {
            document.getElementById("uploadSection").style.display = "block";
        };

        // Close the payment form modal
        function closePaymentForm() {
            document.getElementById("paymentFormModal").style.display = "none";
        }

        // Close the modal if the user clicks outside the form
        window.onclick = function(event) {
            const modal = document.getElementById("paymentFormModal");
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>
</body>
</html>

<?php
// Tutup koneksi setelah selesai
$conn->close();
?>
