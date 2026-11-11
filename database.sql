CREATE DATABASE IF NOT EXISTS db_banjir;
USE db_banjir;

-- Tabel Users
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'user') NOT NULL DEFAULT 'user'
);

-- Tabel Artikel (Materi & Kasus)
CREATE TABLE IF NOT EXISTS artikel (
    id INT AUTO_INCREMENT PRIMARY KEY,
    judul VARCHAR(255) NOT NULL,
    kategori ENUM('Materi', 'Kasus') NOT NULL,
    isi_teks TEXT NOT NULL,
    gambar VARCHAR(255) DEFAULT NULL
);

-- Data Awal Pengguna
-- Akun admin: username 'admin', password 'admin123'
-- Akun user: username 'user', password 'user123'
INSERT INTO users (username, password, role) VALUES
('admin', '$2y$12$PDK.5gEEztPnJAJtwv3klOe3nzenI6nDaU/qloQOb7UL0.Cb/LrYa', 'admin'),
('user', '$2y$12$v0PpS13aSocDU45FvB1NzuCX3MHup./zCoWavVKv1Bq5zIZ1UUHwS', 'user');

-- Data Awal Artikel
INSERT INTO artikel (judul, kategori, isi_teks, gambar) VALUES
('Pengertian dan Definisi Banjir', 'Materi', 'Banjir adalah peristiwa terbenamnya daratan yang biasanya kering karena volume air yang meningkat. Hal ini bisa terjadi karena luapan air sungai, danau, atau laut, serta curah hujan yang sangat tinggi dalam jangka waktu lama.', ''),
('Penyebab Terjadinya Banjir', 'Materi', 'Faktor utama banjir meliputi curah hujan tinggi, penyumbatan saluran air akibat sampah, penggundulan hutan di daerah hulu, berkurangnya daerah resapan air di perkotaan, dan pendangkalan sungai.', ''),
('Dampak Buruk Bencana Banjir', 'Materi', 'Banjir menimbulkan berbagai kerugian seperti kerusakan rumah dan fasilitas umum, gangguan perekonomian, lumpuhnya jalur transportasi, serta penyebaran penyakit menular seperti diare dan penyakit kulit.', ''),
('Upaya Penanggulangan dan Mitigasi Banjir', 'Materi', 'Mitigasi banjir dapat dilakukan dengan menjaga kebersihan sungai, membuat sumur resapan atau biopori, menanam pohon (reboisasi), membersihkan got secara berkala, dan membuat peta jalur evakuasi warga.', ''),
('Banjir Besar Jabodetabek 2020', 'Kasus', 'Pada awal Januari 2020, wilayah Jabodetabek mengalami banjir parah akibat curah hujan ekstrem di malam pergantian tahun. Banjir merendam puluhan ribu rumah dan melumpuhkan aktivitas warga di berbagai titik.', ''),
('Banjir Bandang Sentani Papua 2019', 'Kasus', 'Pada Maret 2019, banjir bandang menerjang wilayah Sentani, Jayapura, akibat kerusakan kawasan hutan di Pegunungan Cycloop ditambah curah hujan yang lebat. Bencana ini menelan puluhan korban jiwa dan merusak pemukiman.', '');
