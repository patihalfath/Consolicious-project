<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Website Penyewaan Console</title>
    <link rel="stylesheet" href="styles.css" />
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <!-- Swiper JS -->
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

</head>
<body>
    <!-- Header Section -->
    <header>
        <div class="logo">
            <h1>Consolicious</h1>
        </div>
        <nav>
            <ul>
                <li><a href="#">Home</a></li>
                <li><a href="login.php">Login</a></li>
            </ul>
        </nav>
    </header>

    <!-- Main Content Section -->
    <main>
        <!-- Hero Section -->
        <section class="hero swiper">
    <div class="swiper-wrapper">
        <div class="swiper-slide" style="background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('asset/game2.png');">
            <h2>Sewa & Mainkan dengan Teman</h2>
            <p>Mainkan di rumah atau booking tempat rental di dekat Anda!</p>
        </div>
        <div class="swiper-slide" style="background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('asset/gameindex.webp');">
            <h2>Mainkan Game Favorit Anda</h2>
            <p>Sewa konsol dan Game terbaru dengan harga terjangkau!</p>
        </div>
    </div>
    <!-- Tombol navigasi -->
    <div class="swiper-button-next"></div>
    <div class="swiper-button-prev"></div>
    <!-- Pagination -->
    <div class="swiper-pagination"></div>
</section>


        <!-- Console Rental Section -->
        <section class="rent-consoles">
    <h2>Available Consoles for Rent</h2>
    <div class="console-grid">
        <div class="console-item">
            <img
                src="https://asset.kompas.com/crops/OShkHBI40cCFj6mMFFcYmhbhBaw=/187x12:1126x638/750x500/data/photo/2020/06/12/5ee2bae6901d6.jpg"
                alt="Playstation"
            />
            <h3>Playstation</h3>
            <button class="rent-button">Sewa Sekarang</button>
        </div>
        <div class="console-item">
            <img
                src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT7rPVNiuN-A9wSlOMudX6brvCOU5kHvE0xHQ&s"
                alt="X-Box"
            />
            <h3>X-Box</h3>
            <button class="rent-button">Sewa Sekarang</button>
        </div>
        <div class="console-item">
            <img
                src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSabCQvbxkReohNa2DRSZEjHFqUZiSrFFsIoA&s"
                alt="Switch"
            />
            <h3>Switch</h3>
            <button class="rent-button">Sewa Sekarang</button>
        </div>
    </div>
</section>

    <!-- JS -->
    <script>
    // Ambil semua tombol dengan class "rent-button"
    const rentButtons = document.querySelectorAll('.rent-button');

    // Tambahkan event listener ke setiap tombol
    rentButtons.forEach(button => {
        button.addEventListener('click', () => {
            alert('Login terlebih dahulu untuk menyewa konsol.');
        });
    });
    </script>


        <!-- Book Gaming Spot Section -->
        <section class="book-space">
            <h2>Cari Gaming Space Disekitar</h2>
            <p>Pilih lokasi, booking tempatnya, dan bermain dengan temanmu!</p>
        </section>
    </main>

    <!-- Footer Section -->
    <footer>
        <p>&copy; 2024 Consolicious. All rights reserved.</p>
    </footer>

    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const swiper = new Swiper('.swiper', {
            loop: true, // Mengulang slide
            autoplay: {
                delay: 5000, // Durasi antar slide
                disableOnInteraction: false, // Tetap autoplay setelah interaksi
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
        });
    });
</script>

</body>
</html>
