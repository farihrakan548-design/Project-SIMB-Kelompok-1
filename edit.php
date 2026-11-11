<?php
session_start();
include 'koneksi.php';

// Proteksi halaman
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

// Ambil ID artikel dari parameter URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: admin.php");
    exit;
}

$id = (int) $_GET['id'];
$query = "SELECT * FROM artikel WHERE id = $id LIMIT 1";
$result = mysqli_query($koneksi, $query);

if (!$result || mysqli_num_rows($result) === 0) {
    header("Location: admin.php");
    exit;
}

$data = mysqli_fetch_assoc($result);
$pesan_error = "";

if (isset($_POST['update'])) {
    $judul = mysqli_real_escape_string($koneksi, trim($_POST['judul']));
    $kategori = mysqli_real_escape_string($koneksi, $_POST['kategori']);
    $isi_teks = mysqli_real_escape_string($koneksi, trim($_POST['isi_teks']));
    $nama_gambar = $data['gambar']; // Default pakai gambar lama

    if (empty($judul) || empty($kategori) || empty($isi_teks)) {
        $pesan_error = "Semua kolom teks wajib diisi!";
    } else {
        // Cek jika ada unggahan gambar baru
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
                // Hapus gambar lama jika ada di server
                if (!empty($data['gambar']) && file_exists('uploads/' . $data['gambar'])) {
                    unlink('uploads/' . $data['gambar']);
                }

                $nama_gambar = time() . '_' . preg_replace("/[^a-zA-Z0-9._-]/", "", $nama_file);
                move_uploaded_file($tmp_file, 'uploads/' . $nama_gambar);
            }
        }

        // Update database jika tidak ada pesan error
        if (empty($pesan_error)) {
            $query_update = "UPDATE artikel SET 
                             judul = '$judul', 
                             kategori = '$kategori', 
                             isi_teks = '$isi_teks', 
                             gambar = '$nama_gambar' 
                             WHERE id = $id";

            if (mysqli_query($koneksi, $query_update)) {
                header("Location: admin.php?pesan=edit_sukses");
                exit;
            } else {
                $pesan_error = "Gagal memperbarui data: " . mysqli_error($koneksi);
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
    <title>Edit Data - Panel Admin</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <?php include 'navbar.php'; ?>

    <div class="container">
        <div class="form-box form-box-large">
            <h2>Edit Data Materi / Kasus</h2>

            <?php if (!empty($pesan_error)): ?>
                <div class="alert alert-danger"><?= $pesan_error; ?></div>
            <?php endif; ?>

            <form action="" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="judul">Judul Artikel</label>
                    <input type="text" name="judul" id="judul" value="<?= htmlspecialchars($data['judul']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="kategori">Kategori</label>
                    <select name="kategori" id="kategori" required>
                        <option value="Materi" <?= ($data['kategori'] === 'Materi') ? 'selected' : ''; ?>>Materi Edukasi</option>
                        <option value="Kasus" <?= ($data['kategori'] === 'Kasus') ? 'selected' : ''; ?>>Contoh Kasus Indonesia</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="isi_teks">Isi Pembahasan</label>
                    <textarea name="isi_teks" id="isi_teks" required><?= htmlspecialchars($data['isi_teks']); ?></textarea>
                </div>

                <div class="form-group">
                    <label>Gambar Saat Ini</label>
                    <div>
                        <?php if (!empty($data['gambar']) && file_exists('uploads/' . $data['gambar'])): ?>
                            <img src="uploads/<?= htmlspecialchars($data['gambar']); ?>" alt="Foto" style="max-width: 150px; border-radius: 4px; display: block; margin-bottom: 10px;">
                        <?php else: ?>
                            <p style="color: #888; font-size: 13px; margin-bottom: 8px;">Tidak ada gambar yang terpasang.</p>
                        <?php endif; ?>
                    </div>
                    <label for="gambar">Ganti Gambar (Biarkan kosong jika tidak ingin mengganti)</label>
                    <input type="file" name="gambar" id="gambar" accept="image/*">
                </div>

                <div style="display: flex; gap: 10px; margin-top: 20px;">
                    <button type="submit" name="update" class="btn">Simpan Perubahan</button>
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
