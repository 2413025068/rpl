<?php
session_start();

include 'koneksi.php';

if(!isset($_SESSION['nis'])){
    header("Location: index.php");
    exit;
}

$nis = $_SESSION['nis'];

$tanggal = date('Y-m-d');

$jam = date('H:i:s');

$status = $_POST['status'];

/* CEK SUDAH ABSEN ATAU BELUM */

$cek = mysqli_query(
    $conn,
    "SELECT * FROM presensi
    WHERE nis='$nis'
    AND tanggal='$tanggal'"
);

if(mysqli_num_rows($cek) == 0){

    mysqli_query(
        $conn,
        "INSERT INTO presensi
        (nis, tanggal, jam_masuk, status)

        VALUES
        ('$nis','$tanggal','$jam','$status')"
    );

}

header("Location: dashboard.php");
?>