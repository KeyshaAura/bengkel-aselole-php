<?php
session_start();
include 'koneksi.php';

$id_daftar = $_GET['id'];
$query = "SELECT pendaftaran.*, service.nama_service, service.harga 
          FROM pendaftaran 
          JOIN service ON pendaftaran.id_service = service.id_service 
          WHERE pendaftaran.id_daftar = '$id_daftar'";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);

// Cek keamanan: orang lain gak boleh liat invoice orang lain kecuali admin
if ($_SESSION['role'] != 'admin' && $_SESSION['id_user'] != $data['id_user']) {
    die("Akses dilarang!");
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Invoice #<?= $data['id_daftar']; ?> - Bengkel Aselole</title>
    <style>
        body {
            font-family: 'Courier New', Courier, monospace;
            padding: 20px;
            color: #333;
        }

        .invoice-box {
            max-width: 600px;
            margin: auto;
            border: 1px solid #eee;
            padding: 30px;
        }

        .header {
            text-align: center;
            border-bottom: 2px dashed #333;
            padding-bottom: 10px;
        }

        .info {
            margin: 20px 0;
            line-height: 1.6;
        }

        .total {
            font-size: 20px;
            font-weight: bold;
            border-top: 2px dashed #333;
            padding-top: 10px;
            margin-top: 20px;
        }

        .btn-print {
            background: #333;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
        }

        @media print {
            .btn-print {
                display: none;
            }
        }
    </style>
</head>

<body onload="window.print()">
    <div class="invoice-box">
        <div class="header">
            <h2>BENGKEL ASELOLE</h2>
            <p>SMKN 1 Depok - Teknik PPLG</p>
            <p>No. Invoice: #ASL-<?= $data['id_daftar']; ?></p>
        </div>

        <div class="info">
            <p>Tanggal: <?= $data['tgl_daftar']; ?></p>
            <p>Nama Pelanggan: <?= $data['nama_pelanggan']; ?></p>
            <p>No. HP: <?= $data['no_hp']; ?></p>
            <hr>
            <p><b>Layanan:</b> <?= $data['nama_service']; ?></p>
            <p><b>Alamat:</b> <?= $data['alamat']; ?></p>
        </div>

        <div class="total">
            Total Estimasi: Rp <?= number_format($data['harga']); ?>
        </div>

        <p style="text-align: center; margin-top: 30px; font-style: italic;">
            "Terima kasih sudah servis di Bengkel Aselole!"
        </p>
    </div>
</body>

</html>