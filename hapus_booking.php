<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['nama']) || $_SESSION['role'] == 'pelanggan') {
    header("Location: index.php");
    exit;
}

$id = $_GET['id'];
$delete = mysqli_query($conn, "DELETE FROM pendaftaran WHERE id_daftar = '$id'");

if ($delete) {
    echo "<script>alert('Data berhasil dihapus!'); window.location='dashboard_admin.php';</script>";
} else {
    echo "Gagal menghapus: " . mysqli_error($conn);
}
?>