<?php
include 'koneksi.php';

$query = "SELECT * FROM artikel WHERE kategori = 'Kasus' ORDER BY id ASC";
$result = mysqli_query($koneksi, $query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kasus Kejadian Banjir di Indonesia</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <?php include 'navbar.php'; ?>

    <div class="container">
        <h2 style="margin-bottom: 10px; color: #1e3a8a;">Contoh Kasus Banjir di Indonesia</h2>
        <p style="margin-bottom: 25px; color: #666;">Daftar peristiwa banjir bersejarah di berbagai wilayah Indonesia sebagai bahan pembelajaran dan refleksi bersama.</p>

        <div class="card-grid">
            <?php if (mysqli_num_rows($result) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <div class="card">
                        <?php if (!empty($row['gambar']) && file_exists('uploads/' . $row['gambar'])): ?>
                            <img src="uploads/<?= htmlspecialchars($row['gambar']); ?>" alt="<?= htmlspecialchars($row['judul']); ?>">
                        <?php endif; ?>
                        <span class="badge" style="background-color: #fef3c7; color: #b45309;">Kasus Indonesia</span>
                        <h3><?= htmlspecialchars($row['judul']); ?></h3>
                        <p><?= nl2br(htmlspecialchars($row['isi_teks'])); ?></p>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>Belum ada data kasus banjir yang tersedia saat ini.</p>
            <?php endif; ?>
        </div>
    </div>

    <footer>
        <p>&copy; <?= date('Y'); ?> Portal Edukasi Bencana Banjir.</p>
    </footer>

</body>
</html>
