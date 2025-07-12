-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 12 Jul 2025 pada 06.17
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `seamless`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `buyerpay`
--

CREATE TABLE `buyerpay` (
  `id` int(11) NOT NULL,
  `user_id` varchar(50) NOT NULL,
  `produk` varchar(100) NOT NULL,
  `nominal` int(11) NOT NULL,
  `bukti` varchar(255) NOT NULL,
  `tanggal_upload` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `invoices`
--

CREATE TABLE `invoices` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `invoice_number` varchar(100) NOT NULL,
  `tanggal` datetime DEFAULT current_timestamp(),
  `total` decimal(10,2) NOT NULL,
  `status` varchar(50) DEFAULT 'Menunggu Pembayaran',
  `file_invoice` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `invoices`
--

INSERT INTO `invoices` (`id`, `user_id`, `invoice_number`, `tanggal`, `total`, `status`, `file_invoice`) VALUES
(1, 1, 'INV20250709-001', '2025-07-11 21:10:50', 25000000.00, 'Lunas', 'INV20250709-001.pdf');

-- --------------------------------------------------------

--
-- Struktur dari tabel `items`
--

CREATE TABLE `items` (
  `id_item` int(11) NOT NULL,
  `nama_item` varchar(100) NOT NULL,
  `stok_meter` int(11) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `items`
--

INSERT INTO `items` (`id_item`, `nama_item`, `stok_meter`, `created_at`, `updated_at`) VALUES
(1, 'Kain Katun', 200, '2025-07-01 18:38:09', '2025-07-12 10:37:15'),
(2, 'Kain Linen', 210, '2025-07-01 18:38:09', '2025-07-01 18:38:09'),
(3, 'Kain Denim', 480, '2025-07-01 18:38:09', '2025-07-01 18:38:09'),
(4, 'Kain Polyester', 100, '2025-07-01 18:58:01', '2025-07-01 18:58:01'),
(5, 'Kain Rayon', 200, '2025-07-12 10:37:05', '2025-07-12 10:37:05');

-- --------------------------------------------------------

--
-- Struktur dari tabel `item_requests`
--

CREATE TABLE `item_requests` (
  `id_request` int(11) NOT NULL,
  `nama_item` varchar(100) NOT NULL,
  `jumlah_dibutuhkan` int(11) NOT NULL,
  `tujuan_proyek` varchar(255) DEFAULT NULL,
  `tanggal_request` date DEFAULT curdate(),
  `status_ketersediaan` varchar(50) DEFAULT 'belum diperiksa'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `sender` varchar(50) DEFAULT NULL,
  `receiver` varchar(50) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `timestamp` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `messages`
--

INSERT INTO `messages` (`id`, `sender`, `receiver`, `message`, `timestamp`) VALUES
(51, 'warehouse', 'marketing', 'halo', '2025-07-02 15:08:16'),
(52, 'warehouse', 'garment', 'hai', '2025-07-02 15:08:30'),
(53, 'marketing', 'warehouse', 'Hai', '2025-07-02 15:19:36'),
(54, 'marketing', 'ekspedisi', 'Hari ini, kirim ke Uniqlo', '2025-07-02 15:21:29'),
(55, 'ekspedisi', 'marketing', 'Oke', '2025-07-02 15:21:57'),
(56, 'marketing', 'ekspedisi', 'Hari ini, kirim ke Uniqlo', '2025-07-02 15:22:04'),
(57, 'warehouse', 'marketing', 'Ada yang bisa dibantu?', '2025-07-02 15:22:23'),
(58, 'marketing', 'warehouse', 'Tolong, update stok kain ya', '2025-07-02 15:23:05'),
(59, 'warehouse', 'marketing', 'Buat Kain Katunnya masih 400 meter', '2025-07-02 15:23:38'),
(60, 'ekspedisi', 'marketing', 'Oke', '2025-07-02 15:39:23'),
(61, 'akuntansi', 'marketing', 'halo', '2025-07-09 12:10:38'),
(62, 'accounting', 'marketing', 'halo', '2025-07-09 12:19:43'),
(63, 'marketing', 'accounting', 'hai', '2025-07-09 12:20:58'),
(64, 'accounting', 'marketing', 'halo', '2025-07-09 12:21:04'),
(65, 'ekspedisi', 'marketing', 'halooo', '2025-07-09 12:21:16'),
(66, 'accounting', 'marketing', 'halo', '2025-07-09 12:27:29'),
(67, 'buyer', 'marketing', 'halo', '2025-07-11 20:43:04'),
(68, 'buyer', 'marketing', 'hai', '2025-07-12 10:25:53');

-- --------------------------------------------------------

--
-- Struktur dari tabel `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `tanggal` date DEFAULT NULL,
  `buyer` varchar(255) DEFAULT NULL,
  `amount` decimal(15,2) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `notes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `production_feedback`
--

CREATE TABLE `production_feedback` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `nama_produk` varchar(255) NOT NULL,
  `nomor_po` varchar(100) NOT NULL,
  `tanggal_penerimaan` date NOT NULL,
  `feedback` text NOT NULL,
  `tanggal_feedback` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `produksi_requests`
--

CREATE TABLE `produksi_requests` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `nama_produk` varchar(255) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `tanggal_mulai` date NOT NULL,
  `catatan` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `sample_feedback`
--

CREATE TABLE `sample_feedback` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `sample_id` int(11) NOT NULL,
  `komentar` text DEFAULT NULL,
  `file_revisi` varchar(255) DEFAULT NULL,
  `tanggal` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `sample_requests`
--

CREATE TABLE `sample_requests` (
  `id` int(11) NOT NULL,
  `user_id` varchar(50) NOT NULL,
  `nama_produk` varchar(100) DEFAULT NULL,
  `bahan` text DEFAULT NULL,
  `ukuran` varchar(10) DEFAULT NULL,
  `warna` varchar(50) DEFAULT NULL,
  `desain` varchar(255) DEFAULT NULL,
  `catatan` text DEFAULT NULL,
  `tanggal_pengajuan` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `sample_requests`
--

INSERT INTO `sample_requests` (`id`, `user_id`, `nama_produk`, `bahan`, `ukuran`, `warna`, `desain`, `catatan`, `tanggal_pengajuan`) VALUES
(10, 'BYR150992', 'Kemeja Kantor', 'Kain Katun', 'Semua Ukur', 'Putih', 'desain_6871304840bbf.png', '', '2025-07-11 22:39:52'),
(11, 'BYR1230001', 'Kaos Olahraga', 'Kain Katun', 'Semua Ukur', 'Orange', 'desain_6871d58d690cd.jpg', 'Ada kerah karretnya', '2025-07-12 10:25:01');

-- --------------------------------------------------------

--
-- Struktur dari tabel `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `deskripsi` varchar(255) NOT NULL,
  `tipe` enum('Income','Expense') NOT NULL,
  `amount` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `transactions`
--

INSERT INTO `transactions` (`id`, `tanggal`, `deskripsi`, `tipe`, `amount`) VALUES
(1, '2025-07-10', 'Pembelian kain', 'Expense', 2000000),
(2, '2025-07-12', 'Pembelian kancing', 'Expense', 100000),
(3, '2025-07-12', 'Keuntungan', 'Income', 5000000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `user_id` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  `company` varchar(100) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `user_id`, `name`, `company`, `email`, `password`, `role`) VALUES
(2, 'WAR070903', 'Brian Kang', 'PT SRITEX Tbk.', 'briankang@sritex.co.id', '$2y$10$AHeYvAyjqvpLpcP/1qBBp.Jn.0Wx5FB6VsgYgXWvzJsaRgjmcLy6m', 'Warehouse Staff'),
(4, 'EXP120905', 'Baskara', 'PT SRITEX Tbk.', 'baskara@sritex.co.id', '$2y$10$H7wEHqdycYZnY4i0LJtJk.yxCyWtCqfRd1DNqcddpNyvQQyjcRn5K', 'Expedition Staff'),
(5, 'EXP010125', 'Hindia', 'PT SRITEX Tbk.', 'hindia@sritex.co.id', '$2y$10$o4HRgv9c6r.JWBcxA0N.hewc1aydFb1t1fHOg3Zd1.iMYLPftkhpG', 'Expedition Staff'),
(7, 'AC1242301', 'Niki Zefanya', 'PT SRITEX Tbk.', 'nikizefanya@sritex.co.id', '$2y$10$2N1diVP6xjxrZfnAWPW97eTCX1UvSAA95qm5zO6uqUn15HhGQ0MPe', 'Accounting Staff'),
(8, 'AC1242302', 'Alea Putri', 'PT SRITEX Tbk.', 'aleaputri@sritex.co.id', '$2y$10$CiC8hA8.ZEKGsavzmI1AneJ63JGl18e8auto9ZqogwJSaM8e/vZTO', 'Accounting Staff'),
(9, 'GAR231004', 'Feby Putri', 'PT SRITEX Tbk.', 'febyputri@sritex.co.id', '$2y$10$mhiETT9tjjh.VVnqn16SreDN756AmzYEGMzEPhzj6DsJrjX7Riynm', 'Garment Staff'),
(10, 'BYR150992', 'Jae Park', 'PT Hindo', 'jaepark@hindo.co.id', '$2y$10$0jzuyW7AWmRJrLyFQEWRreq1SHEqTya5EKykZAVQEApJRrb7Bxn7q', 'Buyer'),
(11, 'MRK120193', 'Shiela Dara', 'PT SRITEX Tbk.', 'sheiladara@sritex.co.id', '$2y$10$YgqztUKKYclEzamPxFUn7.yRcsChHe6NFOT.fqxUZ1MymnCxHyx7.', 'Marketing Staff'),
(12, 'BYR1230001', 'Naruto Uzumaki', 'Konoha', 'uzumakinaruto@konoha.co.id', '$2y$10$6WSxTA8njfIA90SgUzls0OmoR8Yvbx25Dc0hSzxfXOX3ii.V8Mxr6', 'Buyer');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `buyerpay`
--
ALTER TABLE `buyerpay`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id_item`),
  ADD UNIQUE KEY `nama_item` (`nama_item`);

--
-- Indeks untuk tabel `item_requests`
--
ALTER TABLE `item_requests`
  ADD PRIMARY KEY (`id_request`),
  ADD KEY `nama_item` (`nama_item`);

--
-- Indeks untuk tabel `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `production_feedback`
--
ALTER TABLE `production_feedback`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeks untuk tabel `produksi_requests`
--
ALTER TABLE `produksi_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `sample_feedback`
--
ALTER TABLE `sample_feedback`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `sample_id` (`sample_id`);

--
-- Indeks untuk tabel `sample_requests`
--
ALTER TABLE `sample_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`);

--
-- Indeks untuk tabel `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `buyerpay`
--
ALTER TABLE `buyerpay`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `items`
--
ALTER TABLE `items`
  MODIFY `id_item` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `item_requests`
--
ALTER TABLE `item_requests`
  MODIFY `id_request` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT untuk tabel `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `production_feedback`
--
ALTER TABLE `production_feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `produksi_requests`
--
ALTER TABLE `produksi_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `sample_feedback`
--
ALTER TABLE `sample_feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `sample_requests`
--
ALTER TABLE `sample_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `item_requests`
--
ALTER TABLE `item_requests`
  ADD CONSTRAINT `item_requests_ibfk_1` FOREIGN KEY (`nama_item`) REFERENCES `items` (`nama_item`);

--
-- Ketidakleluasaan untuk tabel `production_feedback`
--
ALTER TABLE `production_feedback`
  ADD CONSTRAINT `production_feedback_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Ketidakleluasaan untuk tabel `sample_feedback`
--
ALTER TABLE `sample_feedback`
  ADD CONSTRAINT `sample_feedback_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `sample_feedback_ibfk_2` FOREIGN KEY (`sample_id`) REFERENCES `sample_requests` (`id`);

--
-- Ketidakleluasaan untuk tabel `sample_requests`
--
ALTER TABLE `sample_requests`
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
