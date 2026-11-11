<?php
include 'koneksi.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edukasi Bencana Banjir</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <?php include 'navbar.php'; ?>

    <div class="container">
        <div class="hero">
            <h1>Selamat Datang di Portal Edukasi Bencana Banjir</h1>
            <p>Banjir merupakan salah satu bencana hidrometeorologi yang paling sering terjadi di Indonesia. Melalui portal ini, Anda dapat mempelajari penyebab, dampak, serta langkah mitigasi dan penanggulangannya untuk meningkatkan kesiapsiagaan kita bersama.</p>
            <div style="margin-top: 20px;">
                <a href="materi.php" class="btn">Pelajari Materi</a>
                <a href="kasus.php" class="btn btn-warning" style="margin-left: 10px;">Lihat Kasus Banjir</a>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px;">
            <div class="card">
                <span class="badge">Edukasi</span>
                <h3>Pahami Bahayanya</h3>
                <p>Ketahui faktor-faktor pemicu banjir mulai dari curah hujan tinggi hingga alih fungsi lahan dan kebiasaan membuang sampah sembarangan.</p>
            </div>
            <div class="card">
                <span class="badge">Aksi Nyata</span>
                <h3>Langkah Mitigasi</h3>
                <p>Pelajari apa yang harus disiapkan sebelum banjir datang, saat air mulai naik, dan tindakan setelah banjir surut.</p>
            </div>
            <div class="card">
                <span class="badge">Studi Kasus</span>
                <h3>Belajar dari Kejadian</h3>
                <p>Kilas balik berbagai peristiwa banjir besar di tanah air sebagai bahan evaluasi dan peningkatan kewaspadaan lingkungan.</p>
            </div>
        </div>
    </div>

    <footer>
        <p>&copy; <?= date('Y'); ?> Portal Edukasi Bencana Banjir. Dibuat untuk tujuan edukasi masyarakat.</p>
    </footer>

</body>
</html>
