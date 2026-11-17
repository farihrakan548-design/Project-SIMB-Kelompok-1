<?php
include 'koneksi.php';

// Ambil beberapa artikel pilihan dari database
$query_materi = mysqli_query($koneksi, "SELECT * FROM artikel WHERE kategori = 'Materi' ORDER BY id ASC LIMIT 3");
$query_kasus = mysqli_query($koneksi, "SELECT * FROM artikel WHERE kategori = 'Kasus' ORDER BY id DESC LIMIT 2");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Edukasi & Kesiapsiagaan Bencana Banjir</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <?php include 'navbar.php'; ?>

    <div class="container">
        <!-- Hero Banner Utama -->
        <div class="hero-box">
            <span class="hero-tag">KESIAPSIAGAAN MASYARAKAT</span>
            <h1>Kenali Potensi Banjir di Sekitarmu, Selamatkan Keluarga & Lingkungan</h1>
            <p>Bencana banjir dapat terjadi sewaktu-waktu akibat cuaca ekstrem maupun kondisi lingkungan. Lewat portal edukasi ini, mari pahami penyebabnya, pelajari langkah mitigasi praktis, dan ketahui apa yang wajib dilakukan sebelum, saat, dan sesudah banjir melanda.</p>
            <div class="hero-actions">
                <a href="materi.php" class="btn btn-secondary">Pelajari Materi Edukasi</a>
                <a href="kasus.php" class="btn btn-outline">Lihat Kasus di Indonesia</a>
            </div>
        </div>

        <!-- Panduan Tindakan 3 Fase Bencana (Tabs) -->
        <div class="tabs-section">
            <h2 style="font-size: 20px; color: var(--primary); margin-bottom: 6px;">Panduan Tindakan 3 Fase Banjir</h2>
            <p style="font-size: 14px; color: var(--muted); margin-bottom: 18px;">Pilih tab di bawah untuk melihat rincian langkah keselamatan penting berdasarkan fase bencana.</p>

            <div class="tabs-nav">
                <button class="tab-btn active" onclick="switchTab('tab-pra')">1. Sebelum Banjir (Siaga)</button>
                <button class="tab-btn" onclick="switchTab('tab-saat')">2. Saat Air Naik (Tanggap Darurat)</button>
                <button class="tab-btn" onclick="switchTab('tab-pasca')">3. Setelah Air Surut (Pemulihan)</button>
            </div>

            <!-- Panel 1: Pra-Bencana -->
            <div id="tab-pra" class="tab-panel active">
                <div class="step-list">
                    <div class="step-card">
                        <h4>Amankan Dokumen Penting</h4>
                        <p>Simpan ijazah, sertifikat, akta, dan kartu identitas di dalam plastik kedap air (ziplock) dan taruh di rak paling tinggi.</p>
                    </div>
                    <div class="step-card">
                        <h4>Kenali Jalur & Titik Evakuasi</h4>
                        <p>Ketahui rute evakuasi terdekat di lingkungan RT/RW Anda menuju balai warga, masjid, atau gedung yang lebih tinggi.</p>
                    </div>
                    <div class="step-card">
                        <h4>Bersihkan Drainase & Biopori</h4>
                        <p>Gotong royong membersihkan sampah dan endapan lumpur di saluran air depan rumah sebelum puncak musim hujan tiba.</p>
                    </div>
                </div>
            </div>

            <!-- Panel 2: Saat Banjir -->
            <div id="tab-saat" class="tab-panel">
                <div class="step-list">
                    <div class="step-card" style="border-left-color: var(--danger);">
                        <h4>Putus Arus Listrik Segera</h4>
                        <p>Segera matikan sakelar MCB listrik utama dari meteran PLN untuk mencegah bahaya sengatan listrik (korsleting air).</p>
                    </div>
                    <div class="step-card" style="border-left-color: var(--danger);">
                        <h4>Tutup Saluran & Cabut Selang Gas</h4>
                        <p>Cabut regulator tabung gas dan letakkan tabung di posisi tinggi. Tutup saluran kloset toilet agar air kotor tidak berbalik.</p>
                    </div>
                    <div class="step-card" style="border-left-color: var(--danger);">
                        <h4>Prioritaskan Evakuasi Jiwa</h4>
                        <p>Segera bawa anak-anak, lansia, atau ibu hamil ke tempat aman. Jangan berjalan atau menerobos arus air yang deras.</p>
                    </div>
                </div>
            </div>

            <!-- Panel 3: Pasca Banjir -->
            <div id="tab-pasca" class="tab-panel">
                <div class="step-list">
                    <div class="step-card" style="border-left-color: var(--warning);">
                        <h4>Waspada Bahaya Sengatan & Hewan Liar</h4>
                        <p>Jangan nyalakan listrik sebelum instalasi diperiksa ahli. Waspadai ular, kelabang, atau tikus yang bersembunyi di sela perabot.</p>
                    </div>
                    <div class="step-card" style="border-left-color: var(--warning);">
                        <h4>Bersihkan Lumpur Saat Masih Basah</h4>
                        <p>Keluarkan lumpur dari lantai sebelum mengering dan mengeras. Gunakan sepatu bot dan sarung tangan karet saat membersihkan.</p>
                    </div>
                    <div class="step-card" style="border-left-color: var(--warning);">
                        <h4>Desinfeksi & Rebus Air Minum</h4>
                        <p>Semprot lantai dengan cairan pembersih/karbol dan pastikan air untuk konsumsi dimasak hingga mendidih sempurna.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cuplikan Materi Terkini dari Database -->
        <div style="margin-bottom: 35px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                <div>
                    <h2 style="font-size: 20px; color: var(--primary);">Materi Edukasi Pilihan</h2>
                    <p style="font-size: 14px; color: var(--muted);">Data edukasi resmi yang tersimpan di sistem.</p>
                </div>
                <a href="materi.php" style="color: var(--primary); text-decoration: none; font-weight: 600; font-size: 14px;">Lihat Semua Materi &rarr;</a>
            </div>

            <div class="card-grid">
                <?php while ($materi = mysqli_fetch_assoc($query_materi)): ?>
                    <div class="card">
                        <?php if (!empty($materi['gambar']) && file_exists('uploads/' . $materi['gambar'])): ?>
                            <img src="uploads/<?= htmlspecialchars($materi['gambar']); ?>" alt="<?= htmlspecialchars($materi['judul']); ?>">
                        <?php endif; ?>
                        <span class="badge">Materi</span>
                        <h3><?= htmlspecialchars($materi['judul']); ?></h3>
                        <p><?= htmlspecialchars(substr($materi['isi_teks'], 0, 140)); ?>...</p>
                        <div style="margin-top: 15px;">
                            <a href="materi.php" class="btn" style="padding: 6px 12px; font-size: 13px;">Baca Detail</a>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>

        <!-- Pusat Nomor Darurat Indonesia -->
        <div style="background: #fff; border: 1px solid var(--border); border-radius: var(--radius-md); padding: 24px; box-shadow: var(--shadow-sm);">
            <h2 style="font-size: 20px; color: var(--danger); margin-bottom: 4px;">Pusat Nomor Darurat Indonesia (Bebas Pulsa)</h2>
            <p style="font-size: 14px; color: var(--muted); margin-bottom: 15px;">Simpan nomor ini di ponsel Anda untuk keadaan darurat saat musim penghujan.</p>

            <div class="emergency-grid">
                <div class="emergency-card">
                    <div class="agency-name">BNPB (Posko Bencana)</div>
                    <div class="phone-num">117</div>
                    <div class="agency-desc">Layanan siaga bencana nasional</div>
                    <button class="btn-copy" onclick="copyNumber('117', this)">Salin Nomor</button>
                </div>

                <div class="emergency-card">
                    <div class="agency-name">BASARNAS (Evakuasi SAR)</div>
                    <div class="phone-num">115</div>
                    <div class="agency-desc">Penyelamatan darurat air & arus</div>
                    <button class="btn-copy" onclick="copyNumber('115', this)">Salin Nomor</button>
                </div>

                <div class="emergency-card">
                    <div class="agency-name">Damkar & Penyelamatan</div>
                    <div class="phone-num">113</div>
                    <div class="agency-desc">Pompa darurat & perahu karet</div>
                    <button class="btn-copy" onclick="copyNumber('113', this)">Salin Nomor</button>
                </div>

                <div class="emergency-card">
                    <div class="agency-name">Ambulans Medis (Kemenkes)</div>
                    <div class="phone-num">119</div>
                    <div class="agency-desc">Pertolongan darurat kesehatan</div>
                    <button class="btn-copy" onclick="copyNumber('119', this)">Salin Nomor</button>
                </div>

                <div class="emergency-card">
                    <div class="agency-name">PLN Gangguan Listrik</div>
                    <div class="phone-num">123</div>
                    <div class="agency-desc">Pemutusan gardu listrik terendam</div>
                    <button class="btn-copy" onclick="copyNumber('123', this)">Salin Nomor</button>
                </div>
            </div>
        </div>
    </div>

    <footer>
        <p>&copy; <?= date('Y'); ?> <strong>Portal Edukasi & Kesiapsiagaan Bencana Banjir</strong>. Dikembangkan untuk edukasi dan keselamatan publik.</p>
    </footer>

    <!-- Script Interaktif Sederhana -->
    <script>
    // 1. Logika Tab Fase Bencana
    function switchTab(tabId) {
        document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
        document.querySelectorAll('.tab-panel').forEach(p => p.classList.remove('active'));

        const targetPanel = document.getElementById(tabId);
        if (targetPanel) {
            targetPanel.classList.add('active');
        }

        event.currentTarget.classList.add('active');
    }

    // 2. Salin Nomor Darurat
    function copyNumber(num, btn) {
        navigator.clipboard.writeText(num).then(() => {
            const originalText = btn.innerHTML;
            btn.innerHTML = 'Tersalin!';
            btn.style.backgroundColor = '#dcfce7';
            setTimeout(() => {
                btn.innerHTML = originalText;
                btn.style.backgroundColor = '';
            }, 1800);
        });
    }
    </script>
    
</body>
</html>
