<?php
session_start();
include 'koneksi.php';

if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    $result = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email'");

    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);

        // 2. Cek password
        if (password_verify($password, $row['password'])) {
            $_SESSION['id_user'] = $row['id'];
            $_SESSION['nama'] = $row['nama'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['role'] = $row['role']; 

            if ($row['role'] == 'admin') {
                header("Location: dashboard_admin.php");
            } elseif ($row['role'] == 'mekanik') {
                header("Location: dashboard_mekanik.php");
            } else {
                header("Location: index.php");
            }
            exit;
        }
    }
    $error = true;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Login | Bengkel Aselole</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #2c3e50;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .login-box {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 350px;
            text-align: center;
        }

        input {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            padding: 12px;
            background: #3498db;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            font-weight: bold;
        }

        .error {
            color: #e74c3c;
            font-size: 14px;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <div class="login-box">
        <h2>Login Aselole</h2>
        <?php if (isset($error)): ?>
            <p class="error">Email atau Password salah!</p><?php endif; ?>
        <form method="POST">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="login">Masuk Sekarang</button>
        </form>
        <p style="margin-top:15px; font-size:14px;">Belum punya akun? <a href="register.php">Daftar</a></p>
    </div>
</body>

</html>