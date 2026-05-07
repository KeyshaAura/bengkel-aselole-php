<?php
session_start();
include 'koneksi.php';
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bengkel Aselole | Servis Kendaraan Terpercaya</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
            scroll-behavior: smooth;
        }

        body {
            background-color: #fdfdfd;
            color: #333;
            line-height: 1.6;
        }

        /* Navbar */
        nav {
            background: #2c3e50;
            padding: 15px 8%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.2);
        }

        .logo {
            font-size: 22px;
            font-weight: 700;
            color: #fff;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .logo span {
            color: #e74c3c;
        }

        .menu {
            display: flex;
            align-items: center;
        }

        .menu a {
            color: #ecf0f1;
            text-decoration: none;
            margin-left: 25px;
            font-size: 14px;
            font-weight: 500;
            transition: 0.3s;
        }

        .menu a:hover {
            color: #e74c3c;
        }

        .user-hi {
            color: #2ecc71;
            font-weight: 600;
            margin-left: 20px;
            border-left: 1px solid #555;
            padding-left: 20px;
        }

        .btn-reg {
            background: #e74c3c;
            padding: 8px 20px;
            border-radius: 5px;
            color: white !important;
        }

        /* Hero */
        .hero {
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?q=80&w=1000');
            height: 85vh;
            background-size: cover;
            background-position: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: white;
            text-align: center;
            padding: 0 20px;
        }

        .hero h1 {
            font-size: 3.5rem;
            margin-bottom: 20px;
            font-weight: 700;
        }

        .hero p {
            font-size: 1.2rem;
            margin-bottom: 30px;
            max-width: 800px;
            color: #ccc;
        }

        /* Section Style */
        section {
            padding: 80px 10%;
        }

        .section-title {
            text-align: center;
            margin-bottom: 50px;
        }

        .section-title h2 {
            font-size: 2.5rem;
            color: #2c3e50;
            position: relative;
            padding-bottom: 15px;
        }

        .section-title h2::after {
            content: '';
            width: 60px;
            height: 3px;
            background: #e74c3c;
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
        }

        /* Services */
        .grid-services {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
            margin-bottom: 40px;
        }

        .s-card {
            background: #fff;
            padding: 40px 30px;
            border-radius: 12px;
            text-align: center;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
            transition: 0.3s;
            border-bottom: 4px solid transparent;
        }

        .s-card:hover {
            transform: translateY(-10px);
            border-color: #e74c3c;
        }

        .btn-more {
            text-align: center;
        }

        .btn-more-link {
            padding: 12px 30px;
            border: 2px solid #e74c3c;
            color: #e74c3c;
            text-decoration: none;
            border-radius: 5px;
            font-weight: 600;
            transition: 0.3s;
        }

        .btn-more-link:hover {
            background: #e74c3c;
            color: white;
        }

        /* Gallery */
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
        }

        .gallery-grid img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 8px;
            transition: 0.3s;
            cursor: pointer;
        }

        .gallery-grid img:hover {
            filter: brightness(70%);
            transform: scale(1.02);
        }

        /* Staff */
        .staff-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 30px;
        }

        .staff-card {
            text-align: center;
        }

        .staff-card img {
            width: 140px;
            height: 140px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 15px;
            border: 4px solid #eee;
        }

        .footer {
            background: #2c3e50;
            color: #bdc3c7;
            text-align: center;
            padding: 40px;
        }
    </style>
</head>

<body>

    <nav>
        <div class="logo">BENGKEL <span>ASELOLE</span></div>
        <div class="menu">
            <a href="index.php">Home</a>
            <a href="#about">About</a>
            <a href="#services">Services</a>
            <a href="#gallery">Gallery</a>
            <a href="#staff">Staff</a>

            <?php if (isset($_SESSION['nama'])): ?>
                <span class="user-hi">Halo, <?= $_SESSION['nama']; ?>!</span>

                <?php if ($_SESSION['role'] == 'admin'): ?>
                    <a href="dashboard_admin.php">Dashboard Admin</a>
                <?php elseif ($_SESSION['role'] == 'mekanik'): ?>
                    <a href="dashboard_mekanik.php">Dashboard Mekanik</a>
                <?php else: ?>
                    <a href="daftar_service.php">Booking Service</a>
                    <a href="riwayat.php">Riwayat Service</a>
                <?php endif; ?>

                <a href="logout.php" style="color: #e74c3c; font-weight: bold;">Logout</a>

            <?php else: ?>
                <a href="login.php">Login</a>
                <a href="register.php" class="btn-reg">Daftar</a>
            <?php endif; ?>
        </div>
    </nav>

    <div class="hero">
        <h1>BENGKEL ASELOLE </h1>
        <p>Servis kendaraan lo dengan gaya dan kualitas tinggi. Terpercaya, transparan, dan pengerjaan cepat oleh
            ahlinya.</p>
        <a href="#services"
            style="padding: 15px 35px; background: #e74c3c; color: #fff; text-decoration: none; border-radius: 5px; font-weight: 600;">LIHAT
            LAYANAN</a>
    </div>

    <section id="about">
        <div class="about-container" style="display: flex; align-items: center; gap: 50px;">
            <div class="about-img" style="flex: 1; border-radius: 15px; overflow: hidden;">
                <img src="workshop.webp" alt="Workshop" style="width: 100%;">
            </div>
            <div class="about-text" style="flex: 1;">
                <div class="section-title" style="text-align: left;">
                    <h2>Tentang Kami</h2>
                </div>
                <p>Bengkel Aselole hadir memberikan solusi perawatan kendaraan paling asik di kota Depok. Kami
                    menggabungkan keahlian teknis otomotif SMKN 1 Depok dengan sistem manajemen digital modern untuk
                    kenyamanan lo.</p>
            </div>
        </div>
    </section>

    <section id="services" style="background: #f9f9f9;">
        <div class="section-title">
            <h2>Layanan Unggulan</h2>
        </div>
        <div class="grid-services">
            <div class="s-card">
                <h3>Ganti Oli</h3>
                <p>Pelumasan mesin optimal dengan produk original.</p>
            </div>
            <div class="s-card">
                <h3>Service Rutin</h3>
                <p>Pengecekan menyeluruh biar performa tetep joss.</p>
            </div>
            <div class="s-card">
                <h3>Tune Up</h3>
                <p>Kembalikan tenaga mesin kendaraan lo jadi maksimal.</p>
            </div>
            <div class="s-card">
                <h3>Cek Rem</h3>
                <p>Keselamatan nomor satu, pastikan rem lo pakem.</p>
            </div>
            <div class="s-card">
                <h3>Ganti Ban</h3>
                <p>Ban baru buat grip maksimal di segala medan jalan.</p>
            </div>
            <div class="s-card">
                <h3>Keluar Asap</h3>
                <p>Solusi mesin ngebul biar emisi tetep ramah lingkungan.</p>
            </div>
        </div>
        <div class="btn-more">
            <a href="daftar_service.php" class="btn-more-link">Lihat Layanan Lainnya</a>
        </div>
    </section>

    <section id="gallery">
        <div class="section-title">
            <h2>Galeri Kami</h2>
        </div>
        <div class="gallery-grid">
            <img src="bengkel.webp" alt="1">
            <img src="bengkel1.webp" alt="2">
            <img src="bengkel2.webp" alt="3">
            <img src="bengkel3.webp" alt="4">
        </div>
    </section>

    <section id="staff" style="background: #f9f9f9;">
        <div class="section-title">
            <h2>Mekanik Profesional</h2>
        </div>
        <div class="staff-grid">
            <div class="staff-card">
                <img src="bengkel7.jpg" alt="Staff">
                <h4>Nara</h4>
                <p>Master Mekanik</p>
            </div>
            <div class="staff-card">
                <img src="bengkel8.jpg" alt="Staff">
                <h4>Archen</h4>
                <p>Teknisi Injeksi</p>
            </div>
            <div class="staff-card">
                <img src="bengkel6.jpg" alt="Staff">
                <h4>Thana</h4>
                <p>Spesialis Listrik</p>
            </div>
        </div>
    </section>

    <div class="footer">
        <p>&copy; 2026 Bengkel Aselole - Keysha A. Putri. All Rights Reserved.</p>
    </div>

</body>

</html>