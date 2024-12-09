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

const loginForm = document.querySelector(".login-form");
if (loginForm) {
  loginForm.addEventListener("submit", function (event) {
      event.preventDefault(); // Mencegah reload halaman
      const username = document.querySelector("#username").value;
      const password = document.querySelector("#password").value;

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
                  window.location.href = "dashboard.php";
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


