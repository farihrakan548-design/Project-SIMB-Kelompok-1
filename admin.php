<?php
include 'koneksi.php';

// Proteksi halaman: hanya admin yang boleh masuk
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

$query = "SELECT * FROM artikel ORDER BY id DESC";
$result = mysqli_query($koneksi, $query);

// Hitung statistik ringkas
$count_total = mysqli_num_rows($result);
$q_materi = mysqli_query($koneksi, "SELECT COUNT(*) as jml FROM artikel WHERE kategori = 'Materi'");
$count_materi = mysqli_fetch_assoc($q_materi)['jml'];
$q_kasus = mysqli_query($koneksi, "SELECT COUNT(*) as jml FROM artikel WHERE kategori = 'Kasus'");
$count_kasus = mysqli_fetch_assoc($q_kasus)['jml'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Pengelolaan Konten - Edukasi Banjir</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <?php include 'navbar.php'; ?>

    <div class="container">
        <!-- Header Panel Admin -->
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; flex-wrap: wrap; gap: 15px;">
            <div>
                <h1 style="color: var(--primary); font-size: 24px; font-weight: 800;">Panel Pengelolaan Data</h1>
                <p style="color: var(--muted); font-size: 14px; margin-top: 4px;">Kelola seluruh materi edukasi dan data dokumentasi kasus banjir.</p>
            </div>
            <a href="tambah.php" class="btn">+ Tambah Artikel Baru</a>
        </div>

        <!-- Kartu Metrik Ringkas -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; margin-bottom: 25px;">
            <div style="background: #fff; border: 1px solid var(--border); border-radius: var(--radius-md); padding: 18px; box-shadow: var(--shadow-sm);">
                <div style="font-size: 13px; color: var(--muted); font-weight: 600;">TOTAL ARTIKEL</div>
                <div style="font-size: 28px; font-weight: 800; color: var(--primary); margin-top: 4px;"><?= $count_total; ?></div>
            </div>
            <div style="background: #fff; border: 1px solid var(--border); border-radius: var(--radius-md); padding: 18px; box-shadow: var(--shadow-sm);">
                <div style="font-size: 13px; color: var(--muted); font-weight: 600;">MATERI EDUKASI</div>
                <div style="font-size: 28px; font-weight: 800; color: var(--accent); margin-top: 4px;"><?= $count_materi; ?></div>
            </div>
            <div style="background: #fff; border: 1px solid var(--border); border-radius: var(--radius-md); padding: 18px; box-shadow: var(--shadow-sm);">
                <div style="font-size: 13px; color: var(--muted); font-weight: 600;">KASUS INDONESIA</div>
                <div style="font-size: 28px; font-weight: 800; color: var(--warning); margin-top: 4px;"><?= $count_kasus; ?></div>
            </div>
        </div>

        <?php if (isset($_GET['pesan'])): ?>
            <?php if ($_GET['pesan'] === 'tambah_sukses'): ?>
                <div class="alert alert-success">Data baru berhasil ditambahkan!</div>
            <?php elseif ($_GET['pesan'] === 'edit_sukses'): ?>
                <div class="alert alert-success">Perubahan data berhasil disimpan!</div>
            <?php elseif ($_GET['pesan'] === 'hapus_sukses'): ?>
                <div class="alert alert-success">Data berhasil dihapus dari sistem!</div>
            <?php endif; ?>
        <?php endif; ?>

        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th style="width: 90px;">Gambar</th>
                        <th>Judul Artikel</th>
                        <th style="width: 120px;">Kategori</th>
                        <th>Isi Singkat</th>
                        <th style="width: 140px; text-align: center;">Aksi</th>
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
                                        <span style="color: var(--muted); font-size: 12px; background: #f1f5f9; padding: 4px 8px; border-radius: 4px; display: inline-block;">Tanpa Foto</span>
                                    <?php endif; ?>
                                </td>
                                <td><strong><?= htmlspecialchars($row['judul']); ?></strong></td>
                                <td>
                                    <?php if ($row['kategori'] === 'Materi'): ?>
                                        <span class="badge" style="margin: 0;">Materi</span>
                                    <?php else: ?>
                                        <span class="badge badge-kasus" style="margin: 0;">Kasus</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?= htmlspecialchars(substr($row['isi_teks'], 0, 95)); ?>...
                                </td>
                                <td style="text-align: center;">
                                    <div style="display: inline-flex; gap: 6px;">
                                        <a href="edit.php?id=<?= $row['id']; ?>" class="btn btn-warning" style="padding: 5px 10px; font-size: 12px;">Edit</a>
                                        <a href="hapus.php?id=<?= $row['id']; ?>" class="btn btn-danger" style="padding: 5px 10px; font-size: 12px;" onclick="return confirm('Apakah Anda yakin ingin menghapus artikel ini?');">Hapus</a>
                                    </div>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" style="text-align: center; color: var(--muted); padding: 30px;">Belum ada artikel yang diinputkan.</td>
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
