-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th10 01, 2024 lúc 07:49 AM
-- Phiên bản máy phục vụ: 10.4.27-MariaDB
-- Phiên bản PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `ql_nongsan`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chitietgiohang`
--

CREATE TABLE `chitietgiohang` (
  `MaChiTietGioHang` int(11) NOT NULL,
  `MaGioHang` int(11) DEFAULT NULL,
  `MaSanPham` int(11) DEFAULT NULL,
  `SoLuong` int(11) DEFAULT NULL,
  `GiaBan` decimal(18,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chitietphieudathang`
--

CREATE TABLE `chitietphieudathang` (
  `MaChiTietPhieuDatHang` int(11) NOT NULL,
  `MaPhieuDatHang` int(11) DEFAULT NULL,
  `MaSanPham` int(11) DEFAULT NULL,
  `DonGiaNhap` decimal(18,2) DEFAULT NULL,
  `SoLuong` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chitietphieugiaohang`
--

CREATE TABLE `chitietphieugiaohang` (
  `MaChiTietPhieuGiaoHang` int(11) NOT NULL,
  `MaPhieuGiaoHang` int(11) DEFAULT NULL,
  `SoLuongGiao` int(11) DEFAULT NULL,
  `SoTienTuongUng` decimal(18,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `danhmucsanpham`
--

CREATE TABLE `danhmucsanpham` (
  `MaDanhMuc` int(11) NOT NULL,
  `TenDanhMuc` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `giohang`
--

CREATE TABLE `giohang` (
  `MaGioHang` int(11) NOT NULL,
  `MaKhachHang` int(11) DEFAULT NULL,
  `TongTien` decimal(18,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `khachhang`
--

CREATE TABLE `khachhang` (
  `MaKhachHang` int(11) NOT NULL,
  `TenKhachHang` varchar(100) DEFAULT NULL,
  `SoDienThoai` varchar(15) DEFAULT NULL,
  `DiaChi` varchar(255) DEFAULT NULL,
  `MaNguoiDung` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nguoidung`
--

CREATE TABLE `nguoidung` (
  `MaNguoiDung` int(11) NOT NULL,
  `TenDangNhap` varchar(50) DEFAULT NULL,
  `MatKhau` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `HoTen` varchar(100) DEFAULT NULL,
  `MaVaiTro` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `nguoidung`
--

INSERT INTO `nguoidung` (`MaNguoiDung`, `TenDangNhap`, `MatKhau`, `remember_token`, `Email`, `HoTen`, `MaVaiTro`) VALUES
(2, 'hmk2k3', '$2y$12$E6KiM83x69ylRg9IVTUM4Oj.EBpGEfZDwZN0VN8EF5ZqI523ADVQ6', 'nsfdV0vUcv7KX7eT5cV0ItjgAXVQTVO19vXXQ7ojGhHGGm8oADRyktPM2L5d', 'kh431248@gmail.com', 'kim', 1),
(5, 'hmk123456', '$2y$12$KberM.wDR1FiCbFPHjrCqe1D5O5Bc8vn/T49km0/VjlZskY1yPwCm', '1i2qepSKNyosKZ2GhtTsSprPnavITP2FlYAzboY0bffL2XzZvZ9EHE2iulww', 'mavnhuy1@gmail.com', 'hmk', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nhacungcap`
--

CREATE TABLE `nhacungcap` (
  `MaNhaCungCap` int(11) NOT NULL,
  `TenNhaCungCap` varchar(100) DEFAULT NULL,
  `DiaChi` varchar(255) DEFAULT NULL,
  `SoDienThoai` varchar(15) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `phieudathang`
--

CREATE TABLE `phieudathang` (
  `MaPhieuDatHang` int(11) NOT NULL,
  `MaNhaCungCap` int(11) DEFAULT NULL,
  `NgayDat` date DEFAULT NULL,
  `SoLuongDaGiao` int(11) DEFAULT NULL,
  `SoLuong` int(11) DEFAULT NULL,
  `TongTien` decimal(18,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `phieugiaohang`
--

CREATE TABLE `phieugiaohang` (
  `MaPhieuGiaoHang` int(11) NOT NULL,
  `MaPhieuDatHang` int(11) DEFAULT NULL,
  `NgayLap` date DEFAULT NULL,
  `TongTienPhaiTra` decimal(18,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `quyen`
--

CREATE TABLE `quyen` (
  `MaQuyen` int(11) NOT NULL,
  `TenQuyen` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `quyen`
--

INSERT INTO `quyen` (`MaQuyen`, `TenQuyen`) VALUES
(1, 'Xem sản phẩm'),
(2, 'Mua hàng'),
(3, 'Quản lý đơn hàng'),
(4, 'Quản lý sản phẩm'),
(5, 'Quản lý người dùng');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sanpham`
--

CREATE TABLE `sanpham` (
  `MaSanPham` int(11) NOT NULL,
  `TenSanPham` varchar(100) DEFAULT NULL,
  `LoaiSanPham` varchar(50) DEFAULT NULL,
  `DonViTinh` varchar(20) DEFAULT NULL,
  `MoTa` varchar(255) DEFAULT NULL,
  `HinhAnh` varchar(255) DEFAULT NULL,
  `GiaBan` decimal(18,2) DEFAULT NULL,
  `NgayTao` date DEFAULT NULL,
  `MaDanhMuc` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `vaitro`
--

CREATE TABLE `vaitro` (
  `MaVaiTro` int(11) NOT NULL,
  `TenVaiTro` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `vaitro`
--

INSERT INTO `vaitro` (`MaVaiTro`, `TenVaiTro`) VALUES
(1, 'Khách hàng'),
(2, 'Nhân viên'),
(3, 'Quản trị viên');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `vaitro_quyen`
--

CREATE TABLE `vaitro_quyen` (
  `MaVaiTro` int(11) NOT NULL,
  `MaQuyen` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `vaitro_quyen`
--

INSERT INTO `vaitro_quyen` (`MaVaiTro`, `MaQuyen`) VALUES
(1, 1),
(1, 2),
(2, 1),
(2, 3),
(3, 1),
(3, 3),
(3, 4),
(3, 5);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Chỉ mục cho bảng `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Chỉ mục cho bảng `chitietgiohang`
--
ALTER TABLE `chitietgiohang`
  ADD PRIMARY KEY (`MaChiTietGioHang`),
  ADD KEY `MaGioHang` (`MaGioHang`),
  ADD KEY `MaSanPham` (`MaSanPham`);

--
-- Chỉ mục cho bảng `chitietphieudathang`
--
ALTER TABLE `chitietphieudathang`
  ADD PRIMARY KEY (`MaChiTietPhieuDatHang`),
  ADD KEY `MaPhieuDatHang` (`MaPhieuDatHang`),
  ADD KEY `MaSanPham` (`MaSanPham`);

--
-- Chỉ mục cho bảng `chitietphieugiaohang`
--
ALTER TABLE `chitietphieugiaohang`
  ADD PRIMARY KEY (`MaChiTietPhieuGiaoHang`),
  ADD KEY `MaPhieuGiaoHang` (`MaPhieuGiaoHang`);

--
-- Chỉ mục cho bảng `danhmucsanpham`
--
ALTER TABLE `danhmucsanpham`
  ADD PRIMARY KEY (`MaDanhMuc`);

--
-- Chỉ mục cho bảng `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Chỉ mục cho bảng `giohang`
--
ALTER TABLE `giohang`
  ADD PRIMARY KEY (`MaGioHang`),
  ADD KEY `MaKhachHang` (`MaKhachHang`);

--
-- Chỉ mục cho bảng `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Chỉ mục cho bảng `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `khachhang`
--
ALTER TABLE `khachhang`
  ADD PRIMARY KEY (`MaKhachHang`),
  ADD KEY `MaNguoiDung` (`MaNguoiDung`);

--
-- Chỉ mục cho bảng `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `nguoidung`
--
ALTER TABLE `nguoidung`
  ADD PRIMARY KEY (`MaNguoiDung`),
  ADD KEY `MaVaiTro` (`MaVaiTro`);

--
-- Chỉ mục cho bảng `nhacungcap`
--
ALTER TABLE `nhacungcap`
  ADD PRIMARY KEY (`MaNhaCungCap`);

--
-- Chỉ mục cho bảng `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Chỉ mục cho bảng `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Chỉ mục cho bảng `phieudathang`
--
ALTER TABLE `phieudathang`
  ADD PRIMARY KEY (`MaPhieuDatHang`),
  ADD KEY `MaNhaCungCap` (`MaNhaCungCap`);

--
-- Chỉ mục cho bảng `phieugiaohang`
--
ALTER TABLE `phieugiaohang`
  ADD PRIMARY KEY (`MaPhieuGiaoHang`),
  ADD KEY `MaPhieuDatHang` (`MaPhieuDatHang`);

--
-- Chỉ mục cho bảng `quyen`
--
ALTER TABLE `quyen`
  ADD PRIMARY KEY (`MaQuyen`);

--
-- Chỉ mục cho bảng `sanpham`
--
ALTER TABLE `sanpham`
  ADD PRIMARY KEY (`MaSanPham`),
  ADD KEY `MaDanhMuc` (`MaDanhMuc`);

--
-- Chỉ mục cho bảng `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Chỉ mục cho bảng `vaitro`
--
ALTER TABLE `vaitro`
  ADD PRIMARY KEY (`MaVaiTro`);

--
-- Chỉ mục cho bảng `vaitro_quyen`
--
ALTER TABLE `vaitro_quyen`
  ADD PRIMARY KEY (`MaVaiTro`,`MaQuyen`),
  ADD KEY `MaQuyen` (`MaQuyen`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `chitietgiohang`
--
ALTER TABLE `chitietgiohang`
  MODIFY `MaChiTietGioHang` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `chitietphieudathang`
--
ALTER TABLE `chitietphieudathang`
  MODIFY `MaChiTietPhieuDatHang` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `chitietphieugiaohang`
--
ALTER TABLE `chitietphieugiaohang`
  MODIFY `MaChiTietPhieuGiaoHang` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `danhmucsanpham`
--
ALTER TABLE `danhmucsanpham`
  MODIFY `MaDanhMuc` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `giohang`
--
ALTER TABLE `giohang`
  MODIFY `MaGioHang` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `khachhang`
--
ALTER TABLE `khachhang`
  MODIFY `MaKhachHang` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `nguoidung`
--
ALTER TABLE `nguoidung`
  MODIFY `MaNguoiDung` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `nhacungcap`
--
ALTER TABLE `nhacungcap`
  MODIFY `MaNhaCungCap` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `phieudathang`
--
ALTER TABLE `phieudathang`
  MODIFY `MaPhieuDatHang` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `phieugiaohang`
--
ALTER TABLE `phieugiaohang`
  MODIFY `MaPhieuGiaoHang` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `quyen`
--
ALTER TABLE `quyen`
  MODIFY `MaQuyen` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `sanpham`
--
ALTER TABLE `sanpham`
  MODIFY `MaSanPham` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `vaitro`
--
ALTER TABLE `vaitro`
  MODIFY `MaVaiTro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `chitietgiohang`
--
ALTER TABLE `chitietgiohang`
  ADD CONSTRAINT `chitietgiohang_ibfk_1` FOREIGN KEY (`MaGioHang`) REFERENCES `giohang` (`MaGioHang`),
  ADD CONSTRAINT `chitietgiohang_ibfk_2` FOREIGN KEY (`MaSanPham`) REFERENCES `sanpham` (`MaSanPham`);

--
-- Các ràng buộc cho bảng `chitietphieudathang`
--
ALTER TABLE `chitietphieudathang`
  ADD CONSTRAINT `chitietphieudathang_ibfk_1` FOREIGN KEY (`MaPhieuDatHang`) REFERENCES `phieudathang` (`MaPhieuDatHang`),
  ADD CONSTRAINT `chitietphieudathang_ibfk_2` FOREIGN KEY (`MaSanPham`) REFERENCES `sanpham` (`MaSanPham`);

--
-- Các ràng buộc cho bảng `chitietphieugiaohang`
--
ALTER TABLE `chitietphieugiaohang`
  ADD CONSTRAINT `chitietphieugiaohang_ibfk_1` FOREIGN KEY (`MaPhieuGiaoHang`) REFERENCES `phieugiaohang` (`MaPhieuGiaoHang`);

--
-- Các ràng buộc cho bảng `giohang`
--
ALTER TABLE `giohang`
  ADD CONSTRAINT `giohang_ibfk_1` FOREIGN KEY (`MaKhachHang`) REFERENCES `khachhang` (`MaKhachHang`);

--
-- Các ràng buộc cho bảng `khachhang`
--
ALTER TABLE `khachhang`
  ADD CONSTRAINT `khachhang_ibfk_1` FOREIGN KEY (`MaNguoiDung`) REFERENCES `nguoidung` (`MaNguoiDung`);

--
-- Các ràng buộc cho bảng `nguoidung`
--
ALTER TABLE `nguoidung`
  ADD CONSTRAINT `nguoidung_ibfk_1` FOREIGN KEY (`MaVaiTro`) REFERENCES `vaitro` (`MaVaiTro`);

--
-- Các ràng buộc cho bảng `phieudathang`
--
ALTER TABLE `phieudathang`
  ADD CONSTRAINT `phieudathang_ibfk_1` FOREIGN KEY (`MaNhaCungCap`) REFERENCES `nhacungcap` (`MaNhaCungCap`);

--
-- Các ràng buộc cho bảng `phieugiaohang`
--
ALTER TABLE `phieugiaohang`
  ADD CONSTRAINT `phieugiaohang_ibfk_1` FOREIGN KEY (`MaPhieuDatHang`) REFERENCES `phieudathang` (`MaPhieuDatHang`);

--
-- Các ràng buộc cho bảng `sanpham`
--
ALTER TABLE `sanpham`
  ADD CONSTRAINT `sanpham_ibfk_1` FOREIGN KEY (`MaDanhMuc`) REFERENCES `danhmucsanpham` (`MaDanhMuc`);

--
-- Các ràng buộc cho bảng `vaitro_quyen`
--
ALTER TABLE `vaitro_quyen`
  ADD CONSTRAINT `vaitro_quyen_ibfk_1` FOREIGN KEY (`MaVaiTro`) REFERENCES `vaitro` (`MaVaiTro`),
  ADD CONSTRAINT `vaitro_quyen_ibfk_2` FOREIGN KEY (`MaQuyen`) REFERENCES `quyen` (`MaQuyen`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
