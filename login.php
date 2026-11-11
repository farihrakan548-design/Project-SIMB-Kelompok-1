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
    <title>Masuk - Edukasi Banjir</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <?php include 'navbar.php'; ?>

    <div class="container">
        <div class="form-box">
            <h2>Masuk ke Akun</h2>

            <?php if (!empty($pesan_error)): ?>
                <div class="alert alert-danger"><?= $pesan_error; ?></div>
            <?php endif; ?>

            <form action="" method="POST">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" placeholder="Masukkan username" required>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" placeholder="Masukkan password" required>
                </div>

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
