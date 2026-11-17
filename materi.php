<?php
include 'koneksi.php';

$query = "SELECT * FROM artikel WHERE kategori = 'Materi' ORDER BY id ASC";
$result = mysqli_query($koneksi, $query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Materi Edukasi Bencana Banjir</title>

    <title>Materi Edukasi Banjir</title>

    <link rel="stylesheet" href="style.css">
</head>
<body>

    <?php include 'navbar.php'; ?>

    <div class="container">

        <!-- Header Halaman -->
        <div style="margin-bottom: 24px;">
            <h1 style="color: var(--primary); font-size: 26px; font-weight: 800;">Materi Edukasi Bencana Banjir</h1>
            <p style="color: var(--muted); font-size: 15px; margin-top: 4px;">Panduan komprehensif mulai dari pemahaman konsep dasar, faktor pemicu, dampak lingkungan, hingga strategi mitigasi mandiri.</p>
        </div>

        <!-- Filter & Pencarian Cepat Interaktif -->
        <div class="toolbar-filter">
            <div class="search-input-wrap">
                <input type="text" id="materiSearch" placeholder="Cari topik materi (misal: penyebab, mitigasi, dampak)..." onkeyup="filterMateri()">
            </div>
            <div class="filter-chips">
                <button class="chip-btn active" onclick="filterByChip('semua', this)">Semua Topik</button>
                <button class="chip-btn" onclick="filterByChip('definisi', this)">Pengertian</button>
                <button class="chip-btn" onclick="filterByChip('penyebab', this)">Penyebab</button>
                <button class="chip-btn" onclick="filterByChip('dampak', this)">Dampak</button>
                <button class="chip-btn" onclick="filterByChip('mitigasi', this)">Mitigasi</button>
            </div>
        </div>

        <!-- Grid Kartu Materi -->
        <div class="card-grid" id="materiGrid">
            <?php if (mysqli_num_rows($result) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <div class="card materi-item" data-judul="<?= strtolower(htmlspecialchars($row['judul'])); ?>" data-isi="<?= strtolower(htmlspecialchars($row['isi_teks'])); ?>">
                        <?php if (!empty($row['gambar']) && file_exists('uploads/' . $row['gambar'])): ?>
                            <img src="uploads/<?= htmlspecialchars($row['gambar']); ?>" alt="<?= htmlspecialchars($row['judul']); ?>">
                        <?php endif; ?>
                        
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                            <span class="badge">Edukasi Banjir</span>
                            <span style="font-size: 12px; color: var(--muted);">ID #<?= $row['id']; ?></span>
                        </div>

=======
        <h2 style="margin-bottom: 10px; color: #1e3a8a;">Materi Edukasi Bencana Banjir</h2>
        <p style="margin-bottom: 25px; color: #666;">Pelajari informasi penting mengenai pengertian, penyebab, dampak, serta langkah penanggulangan banjir.</p>

        <div class="card-grid">
            <?php if (mysqli_num_rows($result) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <div class="card">
                        <?php if (!empty($row['gambar']) && file_exists('uploads/' . $row['gambar'])): ?>
                            <img src="uploads/<?= htmlspecialchars($row['gambar']); ?>" alt="<?= htmlspecialchars($row['judul']); ?>">
                        <?php endif; ?>
                        <span class="badge">Materi</span>
>>>>>>> f6950a2e4703be154e019933e94878730adeef34
                        <h3><?= htmlspecialchars($row['judul']); ?></h3>
                        <p><?= nl2br(htmlspecialchars($row['isi_teks'])); ?></p>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>

                <p style="color: var(--muted); grid-column: 1/-1;">Belum ada materi yang ditambahkan.</p>
            <?php endif; ?>
        </div>

        <div id="noMatchMessage" style="display: none; text-align: center; padding: 40px; background: #fff; border-radius: var(--radius-md); border: 1px dashed var(--border); margin-top: 20px;">
            <p style="font-size: 16px; color: var(--muted);">Topik materi yang Anda cari tidak ditemukan. Coba kata kunci lainnya.</p>
        </div>
                <p>Belum ada data materi yang tersedia saat ini.</p>
            <?php endif; ?>
        </div>
    </div>

    <footer>
        <p>&copy; <?= date('Y'); ?> Portal Edukasi Bencana Banjir.</p>
    </footer>

    <!-- JavaScript Interaktif -->
    <script>
    // 1. Pencarian Real-time
    function filterMateri() {
        const query = document.getElementById('materiSearch').value.toLowerCase().trim();
        const cards = document.querySelectorAll('.materi-item');
        let visibleCount = 0;

        cards.forEach(card => {
            const judul = card.getAttribute('data-judul') || '';
            const isi = card.getAttribute('data-isi') || '';

            if (judul.includes(query) || isi.includes(query)) {
                card.style.display = 'flex';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        const noMatch = document.getElementById('noMatchMessage');
        noMatch.style.display = (visibleCount === 0) ? 'block' : 'none';
    }

    // 2. Filter Chip Tombol Cepat
    function filterByChip(keyword, btn) {
        document.querySelectorAll('.chip-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');

        const searchInput = document.getElementById('materiSearch');
        if (keyword === 'semua') {
            searchInput.value = '';
        } else {
            searchInput.value = keyword;
        }
        filterMateri();
    }
    </script>

</body>
</html>
