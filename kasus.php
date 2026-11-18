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
    <title>Studi Kasus Banjir di Indonesia</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <?php include 'navbar.php'; ?>

    <div class="container">
        <div style="margin-bottom: 24px;">
            <h1 style="color: var(--primary); font-size: 26px; font-weight: 800;">Studi Kasus Banjir di Indonesia</h1>
            <p style="color: var(--muted); font-size: 15px; margin-top: 4px;">Kilas balik berbagai peristiwa banjir besar yang pernah terjadi di Indonesia sebagai bahan evaluasi, pelajaran berharga, dan mitigasi di masa depan.</p>
        </div>

        <div class="toolbar-filter">
            <div class="search-input-wrap">
                <input type="text" id="kasusSearch" placeholder="Cari kejadian banjir (misal: Jakarta, Sentani, 2020)..." onkeyup="filterKasus()">
            </div>
            <div class="filter-chips">
                <button class="chip-btn active" onclick="filterKasusChip('semua', this)">Semua Kasus</button>
                <button class="chip-btn" onclick="filterKasusChip('jakarta', this)">Jabodetabek</button>
                <button class="chip-btn" onclick="filterKasusChip('sentani', this)">Papua / Luar Jawa</button>
                <button class="chip-btn" onclick="filterKasusChip('bandang', this)">Banjir Bandang</button>
            </div>
        </div>

        <div class="card-grid" id="kasusGrid">
            <?php if (mysqli_num_rows($result) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <div class="card kasus-item" data-judul="<?= strtolower(htmlspecialchars($row['judul'])); ?>" data-isi="<?= strtolower(htmlspecialchars($row['isi_teks'])); ?>">
                        <?php if (!empty($row['gambar']) && file_exists('uploads/' . $row['gambar'])): ?>
                            <img src="uploads/<?= htmlspecialchars($row['gambar']); ?>" alt="<?= htmlspecialchars($row['judul']); ?>">
                        <?php endif; ?>
                        
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                            <span class="badge badge-kasus">Kasus Indonesia</span>
                            <span style="font-size: 12px; color: var(--muted);">Dokumentasi #<?= $row['id']; ?></span>
                        </div>

                        <h3><?= htmlspecialchars($row['judul']); ?></h3>
                        <p><?= nl2br(htmlspecialchars($row['isi_teks'])); ?></p>

                        <div style="margin-top: 15px; background: #f8fafc; border-left: 3px solid #f59e0b; padding: 10px 12px; border-radius: 0 var(--radius-sm) var(--radius-sm) 0; font-size: 13px;">
                            <strong>Catatan Mitigasi:</strong>
                            <span style="color: var(--muted);">Pentingnya menjaga daerah resapan hulu sungai dan sistem peringatan dini (Early Warning System) bagi warga sekitar.</span>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p style="color: var(--muted); grid-column: 1/-1;">Belum ada data contoh kasus yang tersimpan.</p>
            <?php endif; ?>
        </div>

        <div id="noKasusMatch" style="display: none; text-align: center; padding: 40px; background: #fff; border-radius: var(--radius-md); border: 1px dashed var(--border); margin-top: 20px;">
            <p style="font-size: 16px; color: var(--muted);">Tidak ditemukan catatan kasus banjir dengan kata kunci tersebut.</p>
        </div>
    </div>

    <footer>
        <p>&copy; <?= date('Y'); ?> Portal Edukasi Bencana Banjir.</p>
    </footer>

    <script>
    function filterKasus() {
        const query = document.getElementById('kasusSearch').value.toLowerCase().trim();
        const cards = document.querySelectorAll('.kasus-item');
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

        const noMatch = document.getElementById('noKasusMatch');
        noMatch.style.display = (visibleCount === 0) ? 'block' : 'none';
    }

    function filterKasusChip(keyword, btn) {
        document.querySelectorAll('.chip-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');

        const searchInput = document.getElementById('kasusSearch');
        if (keyword === 'semua') {
            searchInput.value = '';
        } else {
            searchInput.value = keyword;
        }
        filterKasus();
    }
    </script>

</body>
</html>
