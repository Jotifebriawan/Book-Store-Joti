-- Database: Book_Store_Joti
CREATE DATABASE IF NOT EXISTS `Book_Store_Joti` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `Book_Store_Joti`;

-- Tabel Users
DROP TABLE IF EXISTS `tb_user`;
CREATE TABLE `tb_user` (
  `id_user` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nama_user` varchar(255) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `telpon` varchar(16) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `level` varchar(16) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `tb_user_username_unique` (`username`),
  UNIQUE KEY `tb_user_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `tb_user` (`id_user`, `nama_user`, `username`, `password`, `telpon`, `email`, `level`, `created_at`, `updated_at`) VALUES
(1, 'Administrator', 'admin', '$2y$10$duYcs5K/c/.Comqyn3Sx3.eD3jClKGSG1MEVn6ImLT/YLuCMiT/Ze', '0874537328', 'admin@gmail.com', 'admin', NOW(), NOW()),
(2, 'User', 'user', '$2y$10$iTT.fiVjtYTcI/h5f6MWeu/024ncjLTHyBUUTn../AZPnVx9g6vpK', '0875638594', 'user@gmail.com', 'user', NOW(), NOW());

-- Tabel Kategori
DROP TABLE IF EXISTS `tb_kategori`;
CREATE TABLE `tb_kategori` (
  `id_kategori` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nama_kategori` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_kategori`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `tb_kategori` (`id_kategori`, `nama_kategori`, `created_at`, `updated_at`) VALUES
(1, 'Fiksi', NOW(), NOW()),
(2, 'Sejarah', NOW(), NOW()),
(3, 'Fantasi', NOW(), NOW()),
(4, 'Dongeng', NOW(), NOW());

-- Tabel Produk
DROP TABLE IF EXISTS `tb_produk`;
CREATE TABLE `tb_produk` (
  `id_produk` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nama_produk` varchar(255) NOT NULL,
  `id_kategori` bigint(20) NOT NULL,
  `harga_beli` int(11) NOT NULL,
  `harga_jual` int(11) NOT NULL,
  `stok` int(11) NOT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_produk`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `tb_produk` (`id_produk`, `nama_produk`, `id_kategori`, `harga_beli`, `harga_jual`, `stok`, `gambar`, `created_at`, `updated_at`) VALUES
(1, 'The Alchemist', 1, 15000, 20000, 10, NULL, NOW(), NOW()),
(2, 'Sapiens: A Brief History of Humankind', 2, 10000, 12000, 15, NULL, NOW(), NOW()),
(3, 'Harry Potter and the Sorcerer\'s Stone', 3, 20000, 25000, 5, NULL, NOW(), NOW()),
(4, 'Si Kancil Pintar', 4, 20000, 25000, 5, NULL, NOW(), NOW());

-- Tabel Penjualan
DROP TABLE IF EXISTS `tb_penjualan`;
CREATE TABLE `tb_penjualan` (
  `id_penjualan` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tanggal` date NOT NULL,
  `id_produk` bigint(20) NOT NULL,
  `id_user` bigint(20) NOT NULL,
  `total` int(11) NOT NULL,
  `harga` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_penjualan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
