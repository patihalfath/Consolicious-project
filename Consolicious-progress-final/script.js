// Script.js

// Tambahkan interaksi untuk tombol "Get Started" atau "Book Now"
document.querySelectorAll(".cta-btn").forEach(button => {
  button.addEventListener("click", () => {
      if (isLoggedIn) {
          alert("Ayo mulai bermain!");
      } else {
          alert("Silakan login terlebih dahulu untuk melanjutkan.");
          window.location.href = "login.php";
      }
  });
});

// Form Login Handler
const loginForm = document.querySelector(".login-form");
if (loginForm) {
  loginForm.addEventListener("submit", function (event) {
      event.preventDefault(); // Mencegah reload halaman
      const username = document.querySelector("#username").value;
      const password = document.querySelector("#password").value;

      // Kirim data ke server menggunakan Fetch API
      fetch("login.php", {
          method: "POST",
          headers: {
              "Content-Type": "application/x-www-form-urlencoded",
          },
          body: `username=${encodeURIComponent(username)}&password=${encodeURIComponent(password)}`,
      })
          .then(response => response.json())
          .then(data => {
              if (data.success) {
                  alert("Login berhasil!");
                  window.location.href = "dashboard.php"; // Redirect ke dashboard
              } else {
                  alert("Username atau password salah.");
              }
          })
          .catch(error => {
              console.error("Error:", error);
              alert("Terjadi kesalahan, silakan coba lagi.");
          });
  });
}

// Navbar Update (Jika isLoggedIn diinisialisasi dari server)
if (typeof isLoggedIn !== "undefined") {
  const navMenu = document.getElementById("nav-menu");
  const authLink = document.getElementById("auth-link");

  if (isLoggedIn) {
      authLink.innerHTML = `<a href="logout.php">Logout</a>`;
      const welcomeMessage = document.createElement("li");
      welcomeMessage.textContent = `Hi, ${userName}`;
      navMenu.appendChild(welcomeMessage);
  } else {
      authLink.innerHTML = `<a href="login.php">Login</a>`;
  }
}

function showQR() {
    document.getElementById('qr-container').style.display = 'flex'; // Menampilkan QR
}

function confirmPayment() {
    // Sembunyikan QR Container
    const qrContainer = document.getElementById('qr-container');
    if (qrContainer) {
        qrContainer.style.display = 'none';
    }

    // Tampilkan Form Upload
    const uploadFormContainer = document.getElementById('upload-form-container');
    if (uploadFormContainer) {
        uploadFormContainer.style.display = 'block';
    }
}

// Fungsi untuk membatalkan proses pemesanan (opsional, jika ada tombol "Kembali")
function cancelBooking(sewa_game_id) {
    if (confirm("Apakah Anda yakin ingin membatalkan pemesanan?")) {
        // Redirect ke file PHP untuk menghapus data berdasarkan sewa_gaQme_id
        window.location.href = "cancel_booking.php?sewa_game_id=" + sewa_game_id;
    }
}

document.addEventListener("DOMContentLoaded", function () {
    const rekomendasi = [
        { img: "asset/1.jpg", title: "Super Mario Odyssey", url: "games_detail.php?game_id=1" },
        { img: "asset/2.jpg", title: "The Last of Us Part II", url: "games_detail.php?game_id=2" },
        { img: "asset/tekken7.jpg", title: "Tekken 7", url: "games_detail.php?game_id=3" },
        { img: "asset/4.jpg", title: "Hollow Knight", url: "games_detail.php?game_id=4" },
        { img: "asset/5.jpeg", title: "Nioh Series", url: "games_detail.php?game_id=5" },
        { img: "asset/6.jpg", title: "The Legend of Zelda: Breath of the Wild", url: "games_detail.php?game_id=6" },
        { img: "asset/7.jpg", title: "Ninja Gaiden: Master Collection", url: "games_detail.php?game_id=7" },
        { img: "asset/8.jpg", title: "Crash Bandicoot 4: It's About Time", url: "games_detail.php?game_id=8" },
        { img: "asset/9.jpeg", title: "Devil May Cry 5", url: "games_detail.php?game_id=9" },
    ];

    const rekomendasiContainer = document.querySelector(".rekomendasi-dash");

    rekomendasi.forEach(item => {
        // Buat elemen tautan sebagai pembungkus
        const link = document.createElement("a");
        link.href = item.url;
        link.classList.add("rekomendasi-item");

        // Buat elemen gambar
        const img = document.createElement("img");
        img.src = item.img;
        img.alt = item.title;

        // Buat elemen teks
        const title = document.createElement("p");
        title.textContent = item.title;

        // Masukkan gambar dan teks ke dalam tautan
        link.appendChild(img);
        link.appendChild(title);

        // Masukkan tautan ke dalam container
        rekomendasiContainer.appendChild(link);
    });
});

