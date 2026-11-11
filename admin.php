<?php
session_start();
include 'koneksi.php';

// Proteksi halaman: hanya admin yang boleh masuk
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

$query = "SELECT * FROM artikel ORDER BY id DESC";
$result = mysqli_query($koneksi, $query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Admin - Kelola Materi & Kasus</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <?php include 'navbar.php'; ?>

    <div class="container">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <div>
                <h2>Panel Pengelolaan Data</h2>
                <p style="color: #666;">Kelola konten materi edukasi dan contoh kasus banjir.</p>
            </div>
            <a href="tambah.php" class="btn">+ Tambah Data Baru</a>
        </div>

        <?php if (isset($_GET['pesan'])): ?>
            <?php if ($_GET['pesan'] === 'tambah_sukses'): ?>
                <div class="alert alert-success">Data baru berhasil ditambahkan!</div>
            <?php elseif ($_GET['pesan'] === 'edit_sukses'): ?>
                <div class="alert alert-success">Perubahan data berhasil disimpan!</div>
            <?php elseif ($_GET['pesan'] === 'hapus_sukses'): ?>
                <div class="alert alert-success">Data berhasil dihapus!</div>
            <?php endif; ?>
        <?php endif; ?>

        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th style="width: 90px;">Gambar</th>
                        <th>Judul</th>
                        <th style="width: 100px;">Kategori</th>
                        <th>Isi Singkat</th>
                        <th style="width: 150px; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($result) > 0): ?>
                        <?php $no = 1; while ($row = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td>
                                    <?php if (!empty($row['gambar']) && file_exists('uploads/' . $row['gambar'])): ?>
                                        <img src="uploads/<?= htmlspecialchars($row['gambar']); ?>" alt="Foto">
                                    <?php else: ?>
                                        <span style="color: #999; font-size: 12px;">Tanpa Foto</span>
                                    <?php endif; ?>
                                </td>
                                <td><strong><?= htmlspecialchars($row['judul']); ?></strong></td>
                                <td>
                                    <?php if ($row['kategori'] === 'Materi'): ?>
                                        <span class="badge">Materi</span>
                                    <?php else: ?>
                                        <span class="badge" style="background-color: #fef3c7; color: #b45309;">Kasus</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?= htmlspecialchars(substr($row['isi_teks'], 0, 100)); ?>...
                                </td>
                                <td style="text-align: center;">
                                    <a href="edit.php?id=<?= $row['id']; ?>" class="btn btn-warning" style="padding: 5px 10px; font-size: 12px;">Edit</a>
                                    <a href="hapus.php?id=<?= $row['id']; ?>" class="btn btn-danger" style="padding: 5px 10px; font-size: 12px;" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');">Hapus</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" style="text-align: center; color: #888;">Belum ada data artikel.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <footer>
        <p>&copy; <?= date('Y'); ?> Panel Admin Portal Edukasi Bencana Banjir.</p>
    </footer>

</body>
</html>
