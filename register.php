<?php
session_start();
include 'koneksi.php';

// Jika sudah login, langsung alihkan
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$pesan_error = "";
$pesan_sukses = "";

if (isset($_POST['register'])) {
    $username = mysqli_real_escape_string($koneksi, trim($_POST['username']));
    $password = $_POST['password'];
    $konfirmasi = $_POST['konfirmasi_password'];

    if (empty($username) || empty($password)) {
        $pesan_error = "Semua kolom wajib diisi!";
    } elseif ($password !== $konfirmasi) {
        $pesan_error = "Konfirmasi password tidak cocok!";
    } else {
        // Cek apakah username sudah terdaftar
        $cek_user = mysqli_query($koneksi, "SELECT id FROM users WHERE username = '$username'");
        if (mysqli_num_rows($cek_user) > 0) {
            $pesan_error = "Username sudah digunakan, silakan pilih yang lain!";
        } else {
            // Hash password dan simpan sebagai user biasa
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            $query_simpan = "INSERT INTO users (username, password, role) VALUES ('$username', '$password_hash', 'user')";

            if (mysqli_query($koneksi, $query_simpan)) {
                $pesan_sukses = "Pendaftaran berhasil! Silakan masuk.";
            } else {
                $pesan_error = "Gagal mendaftar: " . mysqli_error($koneksi);
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
    <title>Daftar Akun - Edukasi Banjir</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <?php include 'navbar.php'; ?>

    <div class="container">
        <div class="form-box">
            <h2>Pendaftaran Akun</h2>

            <?php if (!empty($pesan_error)): ?>
                <div class="alert alert-danger"><?= $pesan_error; ?></div>
            <?php endif; ?>

            <?php if (!empty($pesan_sukses)): ?>
                <div class="alert alert-success">
                    <?= $pesan_sukses; ?>
                    <div style="margin-top: 10px;">
                        <a href="login.php" class="btn">Klik di sini untuk Masuk</a>
                    </div>
                </div>
            <?php endif; ?>

            <form action="" method="POST">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" placeholder="Buat username" required>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" placeholder="Buat password" required>
                </div>

                <div class="form-group">
                    <label for="konfirmasi_password">Konfirmasi Password</label>
                    <input type="password" name="konfirmasi_password" id="konfirmasi_password" placeholder="Ulangi password" required>
                </div>

                <button type="submit" name="register" class="btn btn-block">Daftar Akun</button>
            </form>

            <p style="text-align: center; margin-top: 15px; font-size: 14px;">
                Sudah punya akun? <a href="login.php">Masuk di sini</a>
            </p>
        </div>
    </div>

    <footer>
        <p>&copy; <?= date('Y'); ?> Portal Edukasi Bencana Banjir.</p>
    </footer>

</body>
</html>
