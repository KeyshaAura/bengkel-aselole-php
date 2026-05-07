<?php
session_start();
include 'koneksi.php';

if (isset($_POST['register'])) {
    $nama     = mysqli_real_escape_string($conn, $_POST['nama']);
    $email    = mysqli_real_escape_string($conn, $_POST['email']);
    $password_raw = $_POST['password'];
    $password_hash = password_hash($password_raw, PASSWORD_DEFAULT);
    $role     = 'pelanggan';

    $query = "INSERT INTO users (nama, email, password, role) VALUES ('$nama', '$email', '$password_hash', '$role')";
    
    if (mysqli_query($conn, $query)) {
        $id_baru = mysqli_insert_id($conn);

        $_SESSION['id_user'] = $id_baru;
        $_SESSION['nama']    = $nama;
        $_SESSION['email']   = $email;
        $_SESSION['role']    = $role;

        echo "<script>
                alert('Pendaftaran Berhasil! Halo $nama, selamat datang di Bengkel Aselole.');
                window.location='index.php';
              </script>";
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Daftar Akun | Bengkel Aselole</title>
    <style>
        body { font-family: 'Poppins', sans-serif; background: #2c3e50; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .register-box { background: white; padding: 40px; border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.3); width: 380px; text-align: center; }
        h2 { color: #333; margin-bottom: 20px; }
        input { width: 100%; padding: 12px; margin: 10px 0; border: 1px solid #ddd; border-radius: 6px; box-sizing: border-box; }
        button { width: 100%; padding: 12px; background: #e74c3c; color: white; border: none; border-radius: 6px; cursor: pointer; font-size: 16px; font-weight: bold; margin-top: 10px; }
        button:hover { background: #c0392b; }
        a { color: #3498db; text-decoration: none; font-size: 14px; }
    </style>
</head>
<body>
    <div class="register-box">
        <h2>Join Bengkel Aselole</h2>
        <form method="POST">
            <input type="text" name="nama" placeholder="Nama Lengkap" required>
            <input type="email" name="email" placeholder="Email Aktif" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="register">Daftar & Masuk</button>
        </form>
        <p style="margin-top: 20px; font-size: 14px;">Sudah punya akun? <a href="login.php">Login di sini</a></p>
    </div>
</body>
</html>