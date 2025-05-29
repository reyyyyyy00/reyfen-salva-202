-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 28 Bulan Mei 2025 pada 14.30
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `educ_env_energy`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`) VALUES
(1, 'admin', '$2y$10$aX8mmQUWYu/jxIzjmWw1CuiUnd2GYYqn.85Ihvv6W2Z2w9k8xV7zG');

-- --------------------------------------------------------

--
-- Struktur dari tabel `articles`
--

CREATE TABLE `articles` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `author` varchar(100) NOT NULL,
  `content` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `articles`
--

INSERT INTO `articles` (`id`, `title`, `author`, `content`, `image`, `created_at`) VALUES
(1, 'Energi Surya: Solusi Bersih untuk Masa Depan', 'Dian Putri', 'Energi surya merupakan salah satu sumber energi terbarukan yang paling potensial. Dengan memasang panel surya di rumah, masyarakat dapat mengurangi ketergantungan pada listrik dari bahan bakar fosil sekaligus menurunkan emisi karbon.', 'solar.png', '2025-05-24 10:00:00'),
(2, 'Manfaat Energi Angin dalam Mengurangi Emisi Karbon', 'Ahmad Nugroho', 'Energi angin memanfaatkan kekuatan alam untuk menghasilkan listrik tanpa menghasilkan polusi udara. Pembangkit listrik tenaga angin kini banyak dikembangkan di daerah pantai dan pegunungan.', 'wind.jpeg', '2025-05-25 10:15:00'),
(3, 'Biogas: Energi Alternatif dari Limbah Organik', 'Siti Lestari', 'Biogas dihasilkan dari fermentasi limbah organik seperti kotoran ternak dan sisa makanan. Energi ini tidak hanya mengurangi limbah, tetapi juga bisa dimanfaatkan untuk memasak atau pembangkit listrik skala kecil.', 'biogas.jpg', '2025-05-22 10:30:00'),
(4, 'Kendaraan Listrik: Inovasi Ramah Lingkungan di Jalan Raya', 'Budi Santosa', 'Mobil dan motor listrik kini menjadi pilihan transportasi yang lebih ramah lingkungan karena tidak menghasilkan emisi gas buang. Dengan dukungan infrastruktur, kendaraan listrik dapat menjadi solusi transportasi berkelanjutan.', 'ev.jpg', '2025-05-21 10:45:00'),
(5, 'Pemanfaatan Energi Air Sebagai Sumber Listrik', 'Nina Kurnia', 'Pembangkit listrik tenaga air telah lama digunakan di Indonesia. Energi ini memanfaatkan aliran sungai atau bendungan untuk menggerakkan turbin, menghasilkan listrik yang bersih dan berkelanjutan.', 'hydro.jpg', '2025-05-28 11:00:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(1, 'qwe', '$2y$10$lmgQ6Z730t.AwTw5M925kea8GxVOFYRfTWsCgYIRsRhRMk3Be2aAu');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indeks untuk tabel `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `articles`
--
ALTER TABLE `articles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
