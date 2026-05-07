<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['nama']) || $_SESSION['role'] != 'mekanik') {
    echo "<script>alert('Akses Khusus Mekanik!'); window.location='index.php';</script>";
    exit;
}

if (isset($_POST['update_status'])) {
    $id = $_POST['id_daftar'];
    $status_baru = $_POST['status'];
    mysqli_query($conn, "UPDATE pendaftaran SET status = '$status_baru' WHERE id_daftar = '$id'");
    echo "<script>alert('Status berhasil diperbarui!'); window.location='dashboard_mekanik.php';</script>";
}

$query = "SELECT pendaftaran.*, service.nama_service 
          FROM pendaftaran 
          JOIN service ON pendaftaran.id_service = service.id_service 
          WHERE status != 'Selesai' 
          ORDER BY tgl_daftar ASC";
$result = mysqli_query($conn, $query);

$total_kerjaan = mysqli_num_rows($result);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mekanik Panel | Bengkel Aselole</title>
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
        }

        .sidebar h2 {
            text-align: center;
            margin-bottom: 30px;
            font-size: 20px;
            letter-spacing: 2px;
            color: #2ecc71;
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
            border-left: 4px solid #2ecc71;
        }

        /* Main Content Style */
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

        .logout-btn {
            color: #e74c3c;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            border: 1px solid #e74c3c;
            padding: 5px 15px;
            border-radius: 5px;
        }

        .logout-btn:hover {
            background: #e74c3c;
            color: white;
        }

        /* Status Badge */
        .badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .badge-antri {
            background: #fff3e0;
            color: #ef6c00;
        }

        .badge-proses {
            background: #e3f2fd;
            color: #1976d2;
        }

        /* Table Container */
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
            font-size: 13px;
            text-transform: uppercase;
        }

        td {
            padding: 15px;
            border-bottom: 1px solid #f0f2f5;
            font-size: 14px;
        }

        /* Form Update */
        select {
            padding: 8px;
            border-radius: 6px;
            border: 1px solid #ddd;
            outline: none;
        }

        .btn-update {
            background: #2ecc71;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 500;
        }

        .btn-update:hover {
            background: #27ae60;
        }
    </style>
</head>

<body>

    <div class="sidebar">
        <h2>MEKANIK<span> PANEL</span></h2>
        <hr>
        <ul class="menu-item">
            <li><a href="dashboard_mekanik.php" class="active">List Pekerjaan</a></li>
            <li><a href="#">Jadwal Shift</a></li>
            <li style="margin-top: 50px;"><a href="index.php">← Lihat Website</a></li>
        </ul>
    </div>

    <div class="main-content">
        <div class="top-bar">
            <div>
                <strong>Mekanik: <?= $_SESSION['nama']; ?></strong>
            </div>
            <a href="logout.php" class="logout-btn">Keluar</a>
        </div>

        <div style="margin-bottom: 25px;">
            <h2 style="color: #2c3e50;">Daftar Tugas Servis</h2>
            <p style="color: #888;">Kamu punya <strong><?= $total_kerjaan; ?></strong> kendaraan yang harus ditangani.
            </p>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Pelanggan & Kontak</th>
                        <th>Layanan</th>
                        <th>Status Saat Ini</th>
                        <th style="text-align: center;">Aksi Update</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($result) > 0): ?>
                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td>
                                    <strong><?= strtoupper($row['nama_pelanggan']); ?></strong><br>
                                    <small style="color: #999;"><?= $row['no_hp']; ?></small>
                                </td>
                                <td><?= $row['nama_service']; ?></td>
                                <td>
                                    <?php if ($row['status'] == 'Antri'): ?>
                                        <span class="badge badge-antri">Antri</span>
                                    <?php else: ?>
                                        <span class="badge badge-proses">Sedang Dikerjakan</span>
                                    <?php endif; ?>
                                </td>
                                <td style="text-align: center;">
                                    <form method="POST" style="display: flex; gap: 10px; justify-content: center;">
                                        <input type="hidden" name="id_daftar" value="<?= $row['id_daftar']; ?>">
                                        <select name="status">
                                            <option value="Antri" <?= $row['status'] == 'Antri' ? 'selected' : ''; ?>>Antri</option>
                                            <option value="Dikerjakan" <?= $row['status'] == 'Dikerjakan' ? 'selected' : ''; ?>>
                                                Dikerjakan</option>
                                            <option value="Selesai" <?= $row['status'] == 'Selesai' ? 'selected' : ''; ?>>Selesai
                                            </option>
                                        </select>
                                        <button type="submit" name="update_status" class="btn-update">Simpan</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" style="text-align: center; padding: 40px; color: #999;">Santai aja dulu, nggak
                                ada kerjaan masuk.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</body>

</html>