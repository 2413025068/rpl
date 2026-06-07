<?php
session_start();

include 'koneksi.php';

$nis = $_POST['nis'];
$password = $_POST['password'];

$query = mysqli_query(
    $conn,
    "SELECT * FROM siswa
    WHERE nis='$nis'
    AND password='$password'"
);

$data = mysqli_fetch_assoc($query);

if($data){

    $_SESSION['nis'] = $data['nis'];
    $_SESSION['nama'] = $data['nama'];
    $_SESSION['kelas'] = $data['kelas'];

    header("Location: dashboard.php");
    exit;

}else{

    echo "
    <script>
        alert('NIS atau Password salah!');
        window.location='index.php';
    </script>
    ";

}
?>