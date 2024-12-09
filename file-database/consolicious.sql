-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 09, 2024 at 07:02 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `consolicious`
--

-- --------------------------------------------------------

--
-- Table structure for table `artikel`
--

CREATE TABLE `artikel` (
  `artikel_id` int(10) NOT NULL,
  `artikel_title` varchar(100) NOT NULL,
  `deskripsi` varchar(65) NOT NULL,
  `file_path` varchar(100) DEFAULT NULL,
  `image_path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `artikel`
--

INSERT INTO `artikel` (`artikel_id`, `artikel_title`, `deskripsi`, `file_path`, `image_path`) VALUES
(1, 'Wukong The Next Game of The Year?', 'lorem ipsum', 'artikel/artikel1.html', 'https://w0.peakpx.com/wallpaper/226/779/HD-wallpaper-2024-black-myth-wukong-ps5-game.jpg'),
(2, '10 Game Terbaik Tahun Ini yang Wajib Kamu Coba: Dari RPG hingga FPS!', 'Tahun ini dipenuhi dengan rilis game yang epik dari berbagai genr', 'artikel/artikel2.html', 'https://asset-2.tstatic.net/sumsel/foto/bank/images/10-game-online-android-terbaik-dan-terpopuler-2020-memiliki-player-terbanyak-di-dunia.jpg'),
(3, 'Tips dan Trik Menjadi Pro di Game Battle Royale: Panduan Lengkap untuk Pemula', 'Battle Royale telah menjadi salah satu genre game paling populer ', 'artikel/artikel3.html', 'asset/art3.png');

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `booking_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `space_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `booking_date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `games`
--

CREATE TABLE `games` (
  `game_id` int(11) NOT NULL,
  `game_name` varchar(100) NOT NULL,
  `genre` varchar(50) DEFAULT NULL,
  `konsol_model_kom` varchar(100) DEFAULT NULL,
  `harga_perhari` decimal(10,2) NOT NULL,
  `keterangan` enum('tersedia','tidak tersedia') DEFAULT 'tersedia',
  `deskripsi` text DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `games`
--

INSERT INTO `games` (`game_id`, `game_name`, `genre`, `konsol_model_kom`, `harga_perhari`, `keterangan`, `deskripsi`, `image_path`) VALUES
(1, 'Super Mario Odyssey', 'Adventure', 'Nintendo Switch', 50000.00, 'tersedia', 'Super Mario Odyssey menghadirkan berbagai dunia yang disebut \"Kingdoms,\" masing-masing dengan tema, tantangan, dan rahasia unik. Dunia-dunia tersebut dirancang dengan visual memukau, mulai dari kota modern New Donk City hingga wilayah es, hutan, dan gurun yang penuh warna. Pemain ditantang untuk menemukan Power Moons, yang diperlukan untuk menggerakkan kapal udara Odyssey milik Mario.', 'asset\\1.jpg'),
(2, 'The Last of Us Part II', 'Action', 'PlayStation 5', 70000.00, 'tersedia', NULL, 'asset\\2.jpg'),
(3, 'Tekken 7', 'Action', 'PlayStation 4', 30000.00, 'tersedia', NULL, 'asset\\tekken7.jpg'),
(4, 'Hollow Knight', 'Adventure', 'PlayStation 4, Switch', 30000.00, 'tersedia', NULL, 'asset/4.jpg'),
(5, 'Nioh Series', 'Action', 'PlayStation 4, PlayStation 5', 40000.00, 'tersedia', NULL, 'asset/5.jpeg'),
(6, 'The Legend of Zelda: Breath of the Wild', 'Adventure', 'Switch', 50000.00, 'tersedia', NULL, 'asset/6.jpg'),
(7, 'Ninja Gaiden: Master Collection', 'Action', 'PlayStation 4, Xbox One', 45000.00, 'tersedia', NULL, 'asset/7.jpg'),
(8, 'Crash Bandicoot 4: It\'s About Time', 'Race', 'Xbox One, Switch', 35000.00, 'tersedia', NULL, 'asset/8.jpg'),
(9, 'Devil May Cry 5', 'Action', 'PlayStation 4, Xbox', 40000.00, 'tersedia', NULL, 'asset/9.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `gaming_space`
--

CREATE TABLE `gaming_space` (
  `space_id` int(11) NOT NULL,
  `nama_space` varchar(100) NOT NULL,
  `tipe_space` varchar(20) NOT NULL,
  `tipe_konsol` varchar(20) NOT NULL,
  `lokasi` varchar(255) NOT NULL,
  `harga_space_perjam` decimal(10,2) NOT NULL,
  `keterangan` enum('tersedia','tidak tersedia') DEFAULT 'tersedia',
  `image_path` varchar(255) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gaming_space`
--

INSERT INTO `gaming_space` (`space_id`, `nama_space`, `tipe_space`, `tipe_konsol`, `lokasi`, `harga_space_perjam`, `keterangan`, `image_path`, `deskripsi`) VALUES
(1, 'Space 1', 'Private', 'Nintendo Switch', 'Jakarta', 50000.00, 'tersedia', 'asset/gs1.jpg', 'Ruang gaming pribadi untuk 2 orang'),
(2, 'Space 2', 'Public', 'PlayStation 5', 'Bandung', 75000.00, 'tersedia', 'asset/gs2.jpg', 'Ruang gaming untuk 4 orang'),
(3, 'Space 3', 'Private', 'Xbox', 'Jakarta', 50000.00, 'tersedia', 'asset/gs3.webp', 'Gaming space mewah bertema cyberpunk dengan layar super besar'),
(4, 'Space 4', 'Public', 'Xbox', 'Jakarta', 10000.00, 'tersedia', 'asset/gs4.webp', 'Gaming space dengan monitor 4k dan aksesoris gaming lengkap');

-- --------------------------------------------------------

--
-- Table structure for table `konsol`
--

CREATE TABLE `konsol` (
  `konsol_id` int(11) NOT NULL,
  `konsol_tipe` varchar(100) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `harga_perhari` decimal(10,2) NOT NULL,
  `keterangan` enum('tersedia','tidak tersedia') DEFAULT 'tersedia'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `konsol`
--

INSERT INTO `konsol` (`konsol_id`, `konsol_tipe`, `deskripsi`, `harga_perhari`, `keterangan`) VALUES
(1, 'PlayStation 5', 'Console Sony PlayStation 5 terbaru', 150000.00, 'tersedia'),
(2, 'Nintendo Switch', 'Console Nintendo Switch dengan Joy-Con', 120000.00, 'tersedia');

-- --------------------------------------------------------

--
-- Table structure for table `order_history`
--

CREATE TABLE `order_history` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `rental_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `playstation`
--

CREATE TABLE `playstation` (
  `playstation_id` int(11) NOT NULL,
  `playstation_jenis` varchar(100) NOT NULL,
  `deskripsi` varchar(65) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `sewa_link` varchar(100) NOT NULL,
  `stok` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `playstation`
--

INSERT INTO `playstation` (`playstation_id`, `playstation_jenis`, `deskripsi`, `image_path`, `sewa_link`, `stok`) VALUES
(1, 'Playstation 3', 'Sewa Playstation 3 Sekarang dan Rasakan Vibes Nostalgianya!', '	https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQIaROnEzZ0byFRtxstafRP97kjQpb0WatQKg&s', 'ps3.php', 42),
(2, 'Playstation 4', 'Sewa Playstation 4, Mainkan dengan Temanmu!', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTgADzKoqojC1u6oxuH3liJWno0NrhKxg3Lzw&s', 'ps4.php', 49),
(3, 'Playstation 5', 'Tunggu Apa Lagi? Ayo Mainkan Sekarang Juga!', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS9orrMl_TWmk3bmDfYtoGuRtsqxvqhCpqegw&s', 'ps5.php', 50);

-- --------------------------------------------------------

--
-- Table structure for table `sewa_game`
--

CREATE TABLE `sewa_game` (
  `sewa_game_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `game_id` int(11) DEFAULT NULL,
  `tanggal_sewa_game` timestamp NOT NULL DEFAULT current_timestamp(),
  `tanggal_selesai_sewa_game` timestamp NULL DEFAULT NULL,
  `quantity` int(11) DEFAULT 1,
  `payment_method` varchar(50) DEFAULT 'qris',
  `harga_sewagame_total` decimal(10,2) NOT NULL,
  `buktibayar` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sewa_game`
--

INSERT INTO `sewa_game` (`sewa_game_id`, `user_id`, `game_id`, `tanggal_sewa_game`, `tanggal_selesai_sewa_game`, `quantity`, `payment_method`, `harga_sewagame_total`, `buktibayar`) VALUES
(27, 1, 1, '2022-11-10 17:00:00', '2022-11-13 17:00:00', 1, 'qris', 150000.00, 'C:/xampp/htdocs/Web_uasProgres_agt2/buktibayar/bukti_675642827609a0.69742401.png');

-- --------------------------------------------------------

--
-- Table structure for table `sewa_konsol`
--

CREATE TABLE `sewa_konsol` (
  `Sewa_konsol_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `konsol_id` int(11) NOT NULL,
  `tanggal_sewa_konsol` timestamp NOT NULL DEFAULT current_timestamp(),
  `tanggal_selesai_sewa_game` timestamp NULL DEFAULT NULL,
  `jumlah` int(11) NOT NULL,
  `harga_sewakons_total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sewa_konsol`
--

INSERT INTO `sewa_konsol` (`Sewa_konsol_id`, `user_id`, `konsol_id`, `tanggal_sewa_konsol`, `tanggal_selesai_sewa_game`, `jumlah`, `harga_sewakons_total`) VALUES
(2, 1, 1, '2024-11-10 08:51:02', '2024-11-14 17:00:00', 1, 120000.00);

-- --------------------------------------------------------

--
-- Table structure for table `sewa_ps`
--

CREATE TABLE `sewa_ps` (
  `id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `rental_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `total_price` decimal(10,2) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `user_phone` varchar(20) NOT NULL,
  `user_address` text NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `bukti_pembayaran` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sewa_switch`
--

CREATE TABLE `sewa_switch` (
  `id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `rental_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `total_price` decimal(10,2) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `user_phone` varchar(20) NOT NULL,
  `user_address` text NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `bukti_pembayaran` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sewa_xbox`
--

CREATE TABLE `sewa_xbox` (
  `id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `rental_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `total_price` decimal(10,2) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `user_phone` varchar(20) NOT NULL,
  `user_address` text NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `bukti_pembayaran` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `switch`
--

CREATE TABLE `switch` (
  `switch_id` int(11) NOT NULL,
  `switch_jenis` varchar(100) NOT NULL,
  `deskripsi` varchar(65) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `sewa_link` varchar(100) NOT NULL,
  `stok` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `switch`
--

INSERT INTO `switch` (`switch_id`, `switch_jenis`, `deskripsi`, `image_path`, `sewa_link`, `stok`) VALUES
(1, 'Switch OLED', 'lorem ipseumm', 'https://media.dinomarket.com/docs/imgTD/2021-09/NInOLED_5_220921220927_ll.jpg.jpg', '#', 80),
(2, 'Switch 2', 'lorem ipseumm', 'https://static.promediateknologi.id/crop/22x476:712x902/0x0/webp/photo/p3/75/2024/08/14/Screenshot_20240814_200202_Edge-1023299565.png', '#', 80),
(3, 'Switch LITE', 'lorem ipseumm', 'https://cultura.id/wp-content/uploads/2019/07/Nintendo-Switch-Lite-1024x648.jpg', '#', 75);

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `transaksi_id` int(11) NOT NULL,
  `pemesanan_id` int(11) NOT NULL,
  `kategori_transaksi` enum('game','konsol','gaming_space') NOT NULL,
  `jumlah_pembayaran` decimal(10,2) NOT NULL,
  `metode_pembayaran` enum('credit_card','debit_card','cash','bank_transfer') NOT NULL,
  `status_pembayaran` enum('paid','unpaid') DEFAULT 'unpaid',
  `pembayaran_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`transaksi_id`, `pemesanan_id`, `kategori_transaksi`, `jumlah_pembayaran`, `metode_pembayaran`, `status_pembayaran`, `pembayaran_date`) VALUES
(1, 1, 'game', 50000.00, 'credit_card', 'paid', '2024-11-10 08:52:00'),
(2, 1, 'konsol', 120000.00, 'debit_card', 'unpaid', '2024-11-10 08:56:28');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(25) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `address` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `email`, `password`, `phone`, `address`) VALUES
(1, 'agata', 'agata@gmail.com', 'agata123', '8888', 'jsajasoj'),
(2, 'agatamulia', 'muliaramadhan3@gmail.com', 'agata123', '081282529371', 'tafatfsttsafssss'),
(3, 'agata g', 'agata1@gmail.com', 'agata1234', '9090', 'jiajsmxxkabclh dhdjx'),
(5, 'AGATA MULIA RAMADHAN', 'buldep@gmail.com', 'agata', '9090', 'aaaaaa'),
(10, 'IlhamBasudara', 'kurir@gmail.com', 'franco123', '051212121', 'JL Menteng Wadas TImur'),
(11, 'RahmatTahalu', 'asik@gmail.com', '1234', '12344321', 'jl manaajaakusuka');

-- --------------------------------------------------------

--
-- Table structure for table `xbox`
--

CREATE TABLE `xbox` (
  `Xbox_id` int(11) NOT NULL,
  `Xbox_jenis` varchar(100) NOT NULL,
  `deskripsi` varchar(65) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `sewa_link` varchar(100) NOT NULL,
  `stok` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `xbox`
--

INSERT INTO `xbox` (`Xbox_id`, `Xbox_jenis`, `deskripsi`, `image_path`, `sewa_link`, `stok`) VALUES
(1, 'Xbox Series X', 'Lorem Ipsum Lolok', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQh95VkISJU1JTIfhgao9kiynATpGZqpgMDag&s', 'xboxX.php', 60),
(2, 'Xbox Series S', 'Lorem Ipsum Lolok', 'https://assets.xboxservices.com/assets/97/d3/97d3bf27-1a7d-4db6-85bc-929f2badf14e.png?n=389964_Buy-Box-0_857x676_01.png', 'xboxS.php', 58),
(3, 'Xbox One', 'Lorem Ipsum Lolok', 'https://images5.alphacoders.com/404/thumb-1920-404729.jpg', 'xboxOne.php', 60);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `artikel`
--
ALTER TABLE `artikel`
  ADD PRIMARY KEY (`artikel_id`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `space_id` (`space_id`);

--
-- Indexes for table `games`
--
ALTER TABLE `games`
  ADD PRIMARY KEY (`game_id`);

--
-- Indexes for table `gaming_space`
--
ALTER TABLE `gaming_space`
  ADD PRIMARY KEY (`space_id`);

--
-- Indexes for table `konsol`
--
ALTER TABLE `konsol`
  ADD PRIMARY KEY (`konsol_id`);

--
-- Indexes for table `order_history`
--
ALTER TABLE `order_history`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `playstation`
--
ALTER TABLE `playstation`
  ADD PRIMARY KEY (`playstation_id`);

--
-- Indexes for table `sewa_game`
--
ALTER TABLE `sewa_game`
  ADD PRIMARY KEY (`sewa_game_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `game_id` (`game_id`);

--
-- Indexes for table `sewa_konsol`
--
ALTER TABLE `sewa_konsol`
  ADD PRIMARY KEY (`Sewa_konsol_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `konsol_id` (`konsol_id`);

--
-- Indexes for table `sewa_ps`
--
ALTER TABLE `sewa_ps`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sewa_switch`
--
ALTER TABLE `sewa_switch`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sewa_xbox`
--
ALTER TABLE `sewa_xbox`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `switch`
--
ALTER TABLE `switch`
  ADD PRIMARY KEY (`switch_id`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`transaksi_id`),
  ADD KEY `pemesanan_id` (`pemesanan_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `xbox`
--
ALTER TABLE `xbox`
  ADD PRIMARY KEY (`Xbox_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `artikel`
--
ALTER TABLE `artikel`
  MODIFY `artikel_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `games`
--
ALTER TABLE `games`
  MODIFY `game_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `gaming_space`
--
ALTER TABLE `gaming_space`
  MODIFY `space_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `konsol`
--
ALTER TABLE `konsol`
  MODIFY `konsol_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `order_history`
--
ALTER TABLE `order_history`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `playstation`
--
ALTER TABLE `playstation`
  MODIFY `playstation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `sewa_game`
--
ALTER TABLE `sewa_game`
  MODIFY `sewa_game_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `sewa_konsol`
--
ALTER TABLE `sewa_konsol`
  MODIFY `Sewa_konsol_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sewa_ps`
--
ALTER TABLE `sewa_ps`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `sewa_switch`
--
ALTER TABLE `sewa_switch`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `sewa_xbox`
--
ALTER TABLE `sewa_xbox`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `switch`
--
ALTER TABLE `switch`
  MODIFY `switch_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `transaksi_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `xbox`
--
ALTER TABLE `xbox`
  MODIFY `Xbox_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`space_id`) REFERENCES `gaming_space` (`space_id`);

--
-- Constraints for table `order_history`
--
ALTER TABLE `order_history`
  ADD CONSTRAINT `order_history_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `sewa_game`
--
ALTER TABLE `sewa_game`
  ADD CONSTRAINT `sewa_game_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `sewa_game_ibfk_2` FOREIGN KEY (`game_id`) REFERENCES `games` (`game_id`);

--
-- Constraints for table `sewa_konsol`
--
ALTER TABLE `sewa_konsol`
  ADD CONSTRAINT `sewa_konsol_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `sewa_konsol_ibfk_2` FOREIGN KEY (`konsol_id`) REFERENCES `konsol` (`konsol_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
