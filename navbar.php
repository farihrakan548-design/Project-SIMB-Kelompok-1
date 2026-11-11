<nav class="navbar">
    <div class="logo">Edukasi Banjir</div>
    <ul>
        <li><a href="index.php">Beranda</a></li>
        <li><a href="materi.php">Materi Banjir</a></li>
        <li><a href="kasus.php">Kasus di Indonesia</a></li>

        <?php if (isset($_SESSION['user_id'])): ?>
            <?php if ($_SESSION['role'] === 'admin'): ?>
                <li><a href="admin.php"><strong>Panel Admin</strong></a></li>
            <?php endif; ?>
            <li><span>Halo, <?= htmlspecialchars($_SESSION['username']); ?> (<?= $_SESSION['role']; ?>)</span></li>
            <li><a href="logout.php" class="btn-logout">Keluar</a></li>
        <?php else: ?>
            <li><a href="login.php">Masuk</a></li>
            <li><a href="register.php">Daftar</a></li>
        <?php endif; ?>
    </ul>
</nav>
