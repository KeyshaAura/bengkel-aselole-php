<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['nama']) || $_SESSION['role'] != 'admin') {
    echo "<script>alert('Akses Khusus Admin!'); window.location='index.php';</script>";
    exit;
}

$query = "SELECT pendaftaran.*, service.nama_service, service.harga 
          FROM pendaftaran 
          JOIN service ON pendaftaran.id_service = service.id_service 
          ORDER BY pendaftaran.tgl_daftar DESC";
$result = mysqli_query($conn, $query);

$total_antrian = mysqli_num_rows($result);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel | Bengkel Aselole</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-color: #f0f2f5;
            display: flex;
        }

        .sidebar {
            width: 260px;
            height: 100vh;
            background: #2c3e50;
            color: white;
            position: fixed;
            padding: 20px;
            transition: 0.3s;
        }

        .sidebar h2 {
            text-align: center;
            margin-bottom: 30px;
            font-size: 20px;
            letter-spacing: 2px;
            color: #e74c3c;
        }

        .sidebar hr {
            border: 0.5px solid #3e4f5f;
            margin-bottom: 20px;
        }

        .menu-item {
            list-style: none;
        }

        .menu-item a {
            display: block;
            padding: 12px 15px;
            color: #bdc3c7;
            text-decoration: none;
            border-radius: 8px;
            margin-bottom: 10px;
            transition: 0.3s;
        }

        .menu-item a:hover,
        .menu-item a.active {
            background: #34495e;
            color: white;
            border-left: 4px solid #e74c3c;
        }

        .main-content {
            margin-left: 260px;
            width: calc(100% - 260px);
            padding: 30px;
            min-height: 100vh;
        }

        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            background: white;
            padding: 15px 25px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .logout-btn {
            color: #e74c3c;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            border: 1px solid #e74c3c;
            padding: 5px 15px;
            border-radius: 5px;
            transition: 0.3s;
        }

        .logout-btn:hover {
            background: #e74c3c;
            color: white;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            border-left: 5px solid #3498db;
        }

        .stat-card h3 {
            font-size: 14px;
            color: #888;
        }

        .stat-card p {
            font-size: 24px;
            font-weight: 700;
            color: #2c3e50;
        }

        .table-container {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            text-align: left;
            padding: 15px;
            border-bottom: 2px solid #f0f2f5;
            color: #888;
            font-weight: 500;
            font-size: 13px;
            text-transform: uppercase;
        }

        td {
            padding: 15px;
            border-bottom: 1px solid #f0f2f5;
            font-size: 14px;
            vertical-align: middle;
        }

        .btn-action {
            padding: 6px 12px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 12px;
            transition: 0.3s;
            display: inline-block;
        }

        .btn-print {
            background: #e3f2fd;
            color: #1976d2;
            margin-right: 5px;
        }

        .btn-print:hover {
            background: #1976d2;
            color: white;
        }

        .btn-delete {
            background: #ffebee;
            color: #c62828;
        }

        .btn-delete:hover {
            background: #c62828;
            color: white;
        }
    </style>
</head>

<body>

    <div class="sidebar">
        <h2>ASELOLE<span> PANEL</span></h2>
        <hr>
        <ul class="menu-item">
            <li><a href="dashboard_admin.php" class="active">Dashboard</a></li>
            <li style="margin-top: 50px;"><a href="index.php">← Lihat Website</a></li>
        </ul>
    </div>

    <div class="main-content">
        <div class="top-bar">
            <div class="user-info">
                <strong>Admin: <?= $_SESSION['nama']; ?></strong>
            </div>
            <a href="logout.php" class="logout-btn">Keluar</a>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <h3>Total Antrian</h3>
                <p><?= $total_antrian; ?></p>
            </div>
            <div class="stat-card" style="border-left-color: #2ecc71;">
                <h3>Status Bengkel</h3>
                <p>Buka</p>
            </div>
        </div>

        <div class="table-container">
            <h3 style="margin-bottom: 20px;">Antrian Service Masuk</h3>
            <table>
                <thead>
                    <tr>
                        <th>Pelanggan</th>
                        <th>Layanan</th>
                        <th>Tanggal</th>
                        <th>Biaya</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($result) > 0): ?>
                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td>
                                    <strong><?= $row['nama_pelanggan']; ?></strong><br>
                                    <small style="color: #999;"><?= $row['no_hp']; ?></small>
                                </td>
                                <td><?= $row['nama_service']; ?></td>
                                <td><?= date('d M Y', strtotime($row['tgl_daftar'])); ?></td>
                                <td>Rp <?= number_format($row['harga']); ?></td>
                                <td>
                                    <a href="invoice.php?id=<?= $row['id_daftar']; ?>" target="_blank"
                                        class="btn-action btn-print">Cetak</a>
                                    <a href="hapus_booking.php?id=<?= $row['id_daftar']; ?>" class="btn-action btn-delete"
                                        onclick="return confirm('Hapus antrian ini?')">Hapus</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" style="text-align:center; padding: 30px; color: #999;">Belum ada data masuk.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</body>

</html>