<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['nama'])) {
    header("Location: login.php");
    exit;
}

if (isset($_POST['submit_booking'])) {
    $id_user    = $_SESSION['id_user'];
    $id_service = $_POST['id_service'];
    $alamat     = mysqli_real_escape_string($conn, $_POST['alamat']);
    $no_hp      = mysqli_real_escape_string($conn, $_POST['no_hp']);
    $nama_pelanggan = $_SESSION['nama']; // Ambil dari session yang tadi kita benerin

    $query = "INSERT INTO pendaftaran (id_user, id_service, nama_pelanggan, alamat, no_hp) 
              VALUES ('$id_user', '$id_service', '$nama_pelanggan', '$alamat', '$no_hp')";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Booking Berhasil! Tunggu konfirmasi mekanik.'); window.location='index.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Booking Service | Bengkel Aselole</title>
    <style>
        body { font-family: 'Poppins', sans-serif; background: #f4f4f4; padding: 50px; }
        .form-box { background: white; max-width: 500px; margin: auto; padding: 30px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
        input, select, textarea { width: 100%; padding: 12px; margin: 10px 0; border: 1px solid #ddd; border-radius: 5px; box-sizing: border-box; }
        button { width: 100%; padding: 12px; background: #e74c3c; color: white; border: none; border-radius: 5px; font-weight: bold; cursor: pointer; }
    </style>
</head>
<body>
    <div class="form-box">
        <h2>Form Booking Service</h2>
        <form method="POST">
            <label>Nama Anda:</label>
            <input type="text" value="<?= $_SESSION['nama']; ?>" readonly style="background: #eee;">
            
            <label>Pilih Layanan:</label>
            <select name="id_service" required>
                <option value="">-- Pilih Layanan --</option>
                <?php
                $services = mysqli_query($conn, "SELECT * FROM service");
                while($s = mysqli_fetch_assoc($services)) {
                    echo "<option value='".$s['id_service']."'>".$s['nama_service']." - Rp ".number_format($s['harga'])."</option>";
                }
                ?>
            </select>

            <input type="text" name="no_hp" placeholder="Nomor WhatsApp (Aktif)" required>
            <textarea name="alamat" placeholder="Alamat Lengkap / Lokasi Penjemputan" rows="4" required></textarea>
            
            <button type="submit" name="submit_booking">Kirim Data Booking</button>
            <p style="text-align:center; margin-top:15px;"><a href="index.php" style="color:#777; text-decoration:none;">Kembali ke Home</a></p>
        </form>
    </div>
</body>
</html>