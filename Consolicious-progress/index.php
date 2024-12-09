<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Website Penyewaan Console</title>
    <link rel="stylesheet" href="styles.css" />
</head>
<body>
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

    <main>
        <section class="hero">
            <h2>Sewa & Mainkan dengan Teman</h2>
            <p>Mainkan di rumah atau booking tempat rental di dekat Anda!</p>
        </section>

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

    <script>
    const rentButtons = document.querySelectorAll('.rent-button');

    rentButtons.forEach(button => {
        button.addEventListener('click', () => {
            alert('Login terlebih dahulu untuk menyewa konsol.');
        });
    });
    </script>


        <section class="book-space">
            <h2>Cari Tempat Rental Disekitar</h2>
            <p>Pilih lokasi, booking tempatnya, dan bermain dengan temanmu!</p>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 Consolicious. All rights reserved.</p>
    </footer>
</body>
</html>
