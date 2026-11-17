<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>
<div class="topbar-emergency">
    <div class="topbar-inner">
        <div>
            <span class="pulse-dot"></span>
            <strong>Info Siaga Banjir:</strong> Layanan Darurat Bebas Pulsa BNPB: <a href="tel:117">117</a> | Tanggap Bencana: <a href="tel:112">112</a>
        </div>
        <div>
            <span>Pusat Edukasi & Kesiapsiagaan Masyarakat</span>
        </div>
    </div>
</div>

<header class="navbar-wrap">
    <nav class="navbar">
        <a href="index.php" class="logo">
            <span class="logo-badge">SIAGA</span>
            <span class="logo-text">Edukasi Banjir</span>
        </a>

        <button class="nav-toggle" id="navToggle" aria-label="Menu">&#9776;</button>

        <ul class="navbar-nav" id="navMenu">
            <li><a href="index.php" class="<?= ($current_page == 'index.php') ? 'active' : ''; ?>">Beranda</a></li>
            <li><a href="materi.php" class="<?= ($current_page == 'materi.php') ? 'active' : ''; ?>">Materi Edukasi</a></li>
            <li><a href="kasus.php" class="<?= ($current_page == 'kasus.php') ? 'active' : ''; ?>">Kasus di Indonesia</a></li>

            <?php if (isset($_SESSION['user_id'])): ?>
                <?php if ($_SESSION['role'] === 'admin'): ?>
                    <li><a href="admin.php" class="<?= (in_array($current_page, ['admin.php', 'tambah.php', 'edit.php'])) ? 'active' : ''; ?>"><strong>Panel Admin</strong></a></li>
                <?php endif; ?>
                <li>
                    <span class="user-badge">
                        <span>User: <?= htmlspecialchars($_SESSION['username']); ?></span>
                        <span class="role-tag <?= $_SESSION['role']; ?>"><?= $_SESSION['role']; ?></span>
                    </span>
                </li>
                <li><a href="logout.php" class="btn-nav-logout">Keluar</a></li>
            <?php else: ?>
                <li><a href="login.php" class="btn-nav-login <?= ($current_page == 'login.php') ? 'active' : ''; ?>">Masuk</a></li>
                <li><a href="register.php" class="btn-nav-register">Daftar Akun</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>

<script>
const navToggle = document.getElementById('navToggle');
const navMenu = document.getElementById('navMenu');
if (navToggle && navMenu) {
    navToggle.addEventListener('click', function() {
        navMenu.classList.toggle('show');
    });
}
</script>
