<?php
session_start();
include 'koneksi.php';

// Proteksi halaman
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

$pesan_error = "";

if (isset($_POST['simpan'])) {
    $judul = mysqli_real_escape_string($koneksi, trim($_POST['judul']));
    $kategori = mysqli_real_escape_string($koneksi, $_POST['kategori']);
    $isi_teks = mysqli_real_escape_string($koneksi, trim($_POST['isi_teks']));
    $nama_gambar = "";

    if (empty($judul) || empty($kategori) || empty($isi_teks)) {
        $pesan_error = "Semua kolom teks wajib diisi!";
    } else {
        // Proses upload gambar jika ada
        if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === 0) {
            $nama_file = $_FILES['gambar']['name'];
            $ukuran_file = $_FILES['gambar']['size'];
            $tmp_file = $_FILES['gambar']['tmp_name'];
            
            $ekstensi_valid = ['jpg', 'jpeg', 'png', 'webp'];
            $ekstensi = strtolower(pathinfo($nama_file, PATHINFO_EXTENSION));

            if (!in_array($ekstensi, $ekstensi_valid)) {
                $pesan_error = "Format gambar harus JPG, JPEG, PNG, atau WEBP!";
            } elseif ($ukuran_file > 2 * 1024 * 1024) {
                $pesan_error = "Ukuran gambar maksimal 2 MB!";
            } else {
                $nama_gambar = time() . '_' . preg_replace("/[^a-zA-Z0-9._-]/", "", $nama_file);
                move_uploaded_file($tmp_file, 'uploads/' . $nama_gambar);
            }
        }

        // Simpan ke database jika tidak ada error
        if (empty($pesan_error)) {
            $query = "INSERT INTO artikel (judul, kategori, isi_teks, gambar) VALUES ('$judul', '$kategori', '$isi_teks', '$nama_gambar')";
            if (mysqli_query($koneksi, $query)) {
                header("Location: admin.php?pesan=tambah_sukses");
                exit;
            } else {
                $pesan_error = "Gagal menyimpan data: " . mysqli_error($koneksi);
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Artikel - Panel Admin</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <?php include 'navbar.php'; ?>

    <div class="container">
        <div class="form-box form-box-large">
            <h2>Tambah Data Materi / Kasus</h2>

            <?php if (!empty($pesan_error)): ?>
                <div class="alert alert-danger"><?= $pesan_error; ?></div>
            <?php endif; ?>

            <form action="" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="judul">Judul Artikel</label>
                    <input type="text" name="judul" id="judul" placeholder="Contoh: Penyebab Banjir Bandang" required>
                </div>

                <div class="form-group">
                    <label for="kategori">Kategori</label>
                    <select name="kategori" id="kategori" required>
                        <option value="">-- Pilih Kategori --</option>
                        <option value="Materi">Materi Edukasi</option>
                        <option value="Kasus">Contoh Kasus Indonesia</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="isi_teks">Isi Pembahasan</label>
                    <textarea name="isi_teks" id="isi_teks" placeholder="Tuliskan materi atau penjelasan kasus di sini..." required></textarea>
                </div>

                <div class="form-group">
                    <label for="gambar">Foto / Gambar Pendukung (Opsional)</label>
                    <input type="file" name="gambar" id="gambar" accept="image/*">
                </div>

                <div style="display: flex; gap: 10px; margin-top: 20px;">
                    <button type="submit" name="simpan" class="btn">Simpan Data</button>
                    <a href="admin.php" class="btn btn-danger">Batal</a>
                </div>
            </form>
        </div>
    </div>

    <footer>
        <p>&copy; <?= date('Y'); ?> Panel Admin Portal Edukasi Bencana Banjir.</p>
    </footer>

</body>
</html>
