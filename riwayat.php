<?php
session_start();
include 'koneksi.php';

// Pastiin yang akses udah login
if (!isset($_SESSION['nama'])) {
    echo "<script>alert('Login dulu bos!'); window.location='login.php';</script>";
    exit;
}

$id_user = $_SESSION['id_user'];

// Tarik data bookingan milik user ini aja
$query = "SELECT pendaftaran.*, service.nama_service, service.harga 
          FROM pendaftaran 
          JOIN service ON pendaftaran.id_service = service.id_service 
          WHERE pendaftaran.id_user = '$id_user' 
          ORDER BY pendaftaran.tgl_daftar DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Riwayat Service | Bengkel Aselole</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f4f4f4;
            padding: 40px;
        }

        .container {
            max-width: 900px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #2c3e50;
            border-bottom: 2px solid #e74c3c;
            display: inline-block;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th {
            text-align: left;
            padding: 15px;
            background: #f8f9fa;
            color: #777;
            font-size: 13px;
            text-transform: uppercase;
        }

        td {
            padding: 15px;
            border-bottom: 1px solid #eee;
            font-size: 14px;
        }

        /* Warna Status */
        .status {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
        }

        .antri {
            background: #fff3e0;
            color: #ef6c00;
        }

        .proses {
            background: #e3f2fd;
            color: #1976d2;
        }

        .selesai {
            background: #e8f5e9;
            color: #2e7d32;
        }

        .btn-invoice {
            text-decoration: none;
            color: #3498db;
            font-weight: 600;
            font-size: 13px;
        }

        .btn-back {
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            color: #888;
            font-size: 14px;
        }
    </style>
</head>

<body>

    <div class="container">
        <h2>Riwayat Booking Lo</h2>
        <p style="margin-bottom: 20px;">Halo <b><?= $_SESSION['nama']; ?></b>, ini status servis kendaraan lo:</p>

        <table>
            <thead>
                <tr>
                    <th>Layanan</th>
                    <th>Tanggal</th>
                    <th>Biaya</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($result) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><strong><?= $row['nama_service']; ?></strong></td>
                            <td><?= date('d M Y', strtotime($row['tgl_daftar'])); ?></td>
                            <td>Rp <?= number_format($row['harga']); ?></td>
                            <td>
                                <?php
                                $s = $row['status'];
                                if ($s == 'Antri')
                                    echo "<span class='status antri'>Antri</span>";
                                elseif ($s == 'Dikerjakan')
                                    echo "<span class='status proses'>Dikerjakan</span>";
                                else
                                    echo "<span class='status selesai'>Selesai</span>";
                                ?>
                            </td>
                            <td>
                                <a href="invoice.php?id=<?= $row['id_daftar']; ?>" target="_blank" class="btn-invoice">Lihat
                                    Nota</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 30px; color: #999;">Belum ada riwayat booking.
                            Yuk service sekarang!</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <a href="index.php" class="btn-back">← Kembali ke Beranda</a>
    </div>

</body>

</html>