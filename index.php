<?php
session_start();

if(isset($_SESSION['nis'])){
    header("Location: dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Presensi Siswa</title>

    <link rel="stylesheet" href="style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>

    <!-- Login Page -->
    <div id="loginPage" class="page active">
        <div class="login-container">
            <div class="login-card">

                <div class="login-header">
                    <i class="fas fa-graduation-cap"></i>
                    <h1>Sistem Presensi Siswa</h1>
                    <p>Masukkan NIS dan Password</p>
                </div>

                <form action="login.php" method="POST" class="login-form">

                    <div class="input-group">
                        <i class="fas fa-id-card"></i>
                        <input 
                            type="text" 
                            name="nis"
                            id="nis" 
                            placeholder="NIS"
                            required
                        >
                    </div>

                    <div class="input-group">
                        <i class="fas fa-lock"></i>
                        <input 
                            type="password" 
                            name="password"
                            placeholder="Masukkan Password"
                            required
                        >
                    </div>

                    <button type="submit" class="login-btn">
                        <span>Masuk</span>
                        <i class="fas fa-arrow-right"></i>
                    </button>
                </form>
</html>