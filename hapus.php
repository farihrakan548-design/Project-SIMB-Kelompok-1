<?php
session_start();
include 'koneksi.php';

// Proteksi halaman: hanya admin yang berhak menghapus data
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = (int) $_GET['id'];

    // Ambil data untuk mengecek apakah ada file gambar yang perlu dihapus
    $query = "SELECT gambar FROM artikel WHERE id = $id LIMIT 1";
    $result = mysqli_query($koneksi, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        // Hapus file fisik gambar jika tersimpan di folder uploads
        if (!empty($row['gambar']) && file_exists('uploads/' . $row['gambar'])) {
            unlink('uploads/' . $row['gambar']);
        }

        // Hapus data dari tabel database
        mysqli_query($koneksi, "DELETE FROM artikel WHERE id = $id");
    }
}

header("Location: admin.php?pesan=hapus_sukses");
exit;
?>
