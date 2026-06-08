<?php
session_start();
include 'koneksi.php';

/* TAMBAH SISWA */

if(isset($_POST['tambah'])){

    $nis = $_POST['nis'];
    $nama = $_POST['nama'];
    $kelas = $_POST['kelas'];
    $password = $_POST['password'];

    mysqli_query(
        $conn,
        "INSERT INTO siswa
        (nis, nama, kelas, password)

        VALUES

        ('$nis','$nama','$kelas','$password')"
    );

    echo "
    <script>
        alert('Data siswa berhasil ditambahkan');
        window.location='admin.php';
    </script>
    ";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Admin Presensi</title>

    <link rel="stylesheet" href="style.css">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
          rel="stylesheet">

</head>

<body>

<div class="page active">

    <!-- NAVBAR -->

    <div class="navbar">

        <div class="nav-left">

            <h2>
                <i class="fas fa-user-shield"></i>
                Admin Panel
            </h2>

        </div>

        <div class="nav-right">

            <a href="dashboard.php" class="logout-btn">

                <i class="fas fa-home"></i>

                Dashboard

            </a>

        </div>

    </div>

    <!-- CONTENT -->

    <div class="main-content">

        <!-- FORM -->

        <div class="login-card"
             style="max-width:700px; margin:auto;">

            <div class="login-header">

                <i class="fas fa-user-plus"></i>

                <h1>Tambah Siswa</h1>

                <p>
                    Tambahkan data siswa baru
                </p>

            </div>

            <form method="POST">

                <div class="input-group">

                    <i class="fas fa-id-card"></i>

                    <input
                        type="text"
                        name="nis"
                        placeholder="NIS"
                        required
                    >

                </div>

                <div class="input-group">

                    <i class="fas fa-user"></i>

                    <input
                        type="text"
                        name="nama"
                        placeholder="Nama Siswa"
                        required
                    >

                </div>

                <div class="input-group">

                    <i class="fas fa-school"></i>

                    <input
                        type="text"
                        name="kelas"
                        placeholder="Kelas"
                        required
                    >

                </div>

                <div class="input-group">

                    <i class="fas fa-lock"></i>

                    <input
                        type="text"
                        name="password"
                        placeholder="Password"
                        required
                    >

                </div>

                <button
                    type="submit"
                    name="tambah"
                    class="login-btn">

                    <i class="fas fa-save"></i>

                    Simpan Data

                </button>

            </form>

        </div>

        <!-- DATA SISWA -->

        <div class="activity-list"
             style="margin-top:40px;">

            <h3
            style="margin-bottom:20px; color:#333;">

                Data Siswa

            </h3>

            <?php

            $siswa = mysqli_query(
                $conn,
                "SELECT * FROM siswa
                ORDER BY id DESC"
            );

            while($data = mysqli_fetch_assoc($siswa)){

            ?>

            <div class="activity-item">

                <div class="activity-left">

                    <div class="status-icon icon-hadir">

                        <i class="fas fa-user"></i>

                    </div>

                    <div>

                        <strong>
                            <?php echo $data['nama']; ?>
                        </strong>

                        <br>

                        <?php echo $data['kelas']; ?>

                    </div>

                </div>

                <div>

                    <?php echo $data['nis']; ?>

                </div>

            </div>

            <?php } ?>

        </div>

    </div>

</div>

</body>
</html>
