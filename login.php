<?php
session_start();
include 'koneksi.php';

// Jika sudah login, langsung alihkan
if (isset($_SESSION['user_id'])) {
    if ($_SESSION['role'] === 'admin') {
        header("Location: admin.php");
    } else {
        header("Location: index.php");
    }
    exit;
}

$pesan_error = "";

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($koneksi, trim($_POST['username']));
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        $pesan_error = "Username dan password wajib diisi!";
    } else {
        $query = "SELECT * FROM users WHERE username = '$username' LIMIT 1";
        $result = mysqli_query($koneksi, $query);

        if ($result && mysqli_num_rows($result) === 1) {
            $user = mysqli_fetch_assoc($result);

            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];

                if ($user['role'] === 'admin') {
                    header("Location: admin.php");
                } else {
                    header("Location: index.php");
                }
                exit;
            } else {
                $pesan_error = "Password yang Anda masukkan salah!";
            }
        } else {
            $pesan_error = "Username tidak terdaftar dalam sistem!";
                $pesan_error = "Password salah!";
            }
        } else {
            $pesan_error = "Username tidak ditemukan!";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - Edukasi Bencana Banjir</title>
    <title>Masuk - Edukasi Banjir</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <?php include 'navbar.php'; ?>

    <div class="container">
        <div class="form-box">
            <h2>Masuk ke Portal</h2>
            <p class="subtitle">Gunakan akun Anda untuk mengakses fitur sistem edukasi.</p>

            <h2>Masuk ke Akun</h2>

            <?php if (!empty($pesan_error)): ?>
                <div class="alert alert-danger"><?= $pesan_error; ?></div>
            <?php endif; ?>

            <form action="" method="POST">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" placeholder="Masukkan username Anda" required autofocus>

                    <input type="text" name="username" id="username" placeholder="Masukkan username" required>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" placeholder="Masukkan password" required>
                </div>

                <button type="submit" name="login" class="btn btn-block">Masuk Sekarang</button>
            </form>

            <div style="background: #f8fafc; border: 1px dashed var(--border); border-radius: var(--radius-sm); padding: 12px; margin-top: 20px; font-size: 13px; color: var(--muted);">
                <strong>Akun Pengujian Demo:</strong><br>
                • Admin: <code>admin</code> | pass: <code>admin123</code><br>
                • Warga: <code>user</code> | pass: <code>user123</code>
            </div>

            <p style="text-align: center; margin-top: 18px; font-size: 14px; color: var(--muted);">
                Belum memiliki akun? <a href="register.php" style="color: var(--primary); font-weight: 600;">Daftar Akun Baru</a>

                <button type="submit" name="login" class="btn btn-block">Masuk</button>
            </form>

            <p style="text-align: center; margin-top: 15px; font-size: 14px;">
                Belum punya akun? <a href="register.php">Daftar sekarang</a>
            </p>
        </div>
    </div>

    <footer>
        <p>&copy; <?= date('Y'); ?> Portal Edukasi Bencana Banjir.</p>
    </footer>

</body>
</html>
