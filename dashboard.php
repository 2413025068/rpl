<?php
session_start();

include 'koneksi.php';

if(!isset($_SESSION['nis'])){
    header("Location: index.php");
    exit;
}

$nis = $_SESSION['nis'];

/* TOTAL HADIR */

$totalHadir = mysqli_num_rows(
    mysqli_query(
        $conn,
        "SELECT * FROM presensi
        WHERE nis='$nis'
        AND status='Hadir'"
    )
);

/* TOTAL TELAT */

$totalTelat = mysqli_num_rows(
    mysqli_query(
        $conn,
        "SELECT * FROM presensi
        WHERE nis='$nis'
        AND status='Telat'"
    )
);

/* TOTAL IZIN */

$totalIzin = mysqli_num_rows(
    mysqli_query(
        $conn,
        "SELECT * FROM presensi
        WHERE nis='$nis'
        AND status='Izin'"
    )
);

/* TOTAL SAKIT */

$totalSakit = mysqli_num_rows(
    mysqli_query(
        $conn,
        "SELECT * FROM presensi
        WHERE nis='$nis'
        AND status='Sakit'"
    )
);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard Presensi</title>

    <link rel="stylesheet" href="style.css">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>

<body>

<div class="page active">

    <!-- NAVBAR -->
    <div class="navbar">

        <div class="nav-left">
            <h2>
                <i class="fas fa-tachometer-alt"></i>
                Dashboard
            </h2>
        </div>

        <div class="nav-right">

            <span class="user-info">
                <?php echo $_SESSION['nama']; ?>
            </span>

            <a href="logout.php" class="logout-btn">
                <i class="fas fa-sign-out-alt"></i>
                Logout
            </a>

        </div>

    </div>

    <!-- CONTENT -->
    <div class="main-content">

        <!-- STATISTIK -->
        <div class="stats-grid">

            <div class="stat-card">

                <div class="stat-icon present">
                    <i class="fas fa-check-circle"></i>
                </div>

                <div class="stat-info">
                    <h3><?php echo $totalHadir; ?></h3>
                    <p>Hadir</p>
                </div>

            </div>

            <div class="stat-card">

                <div class="stat-icon absent">
                    <i class="fas fa-times-circle"></i>
                </div>

                <div class="stat-info">
                    <h3><?php echo $totalIzin; ?></h3>
                    <p>Tidak Hadir</p>
                </div>

            </div>

            <div class="stat-card">

                <div class="stat-icon late">
                    <i class="fas fa-clock"></i>
                </div>

                <div class="stat-info">
                    <h3><?php echo $totalTelat; ?></h3>
                    <p>Telat</p>
                </div>

            </div>

            <div class="stat-card">

                <div class="stat-icon late">
                    <i class="fas fa-clock"></i>
                </div>

                <div class="stat-info">
                    <h3><?php echo $totalSakit; ?></h3>
                    <p>Sakit</p>
                </div>

            </div>

        </div>

        <!-- PRESENSI -->
        <div class="presensi-header">

            <h3>Presensi Hari Ini</h3>

            <div class="date-info">
                <span id="currentDtae">
                    <?php echo date('d M Y'); ?>
                </span>

                <span id="currentTime">
                    <?php echo date("H:i"); ?>
                </span>

            </div>

        </div>

        <?php
        include 'koneksi.php';

        $nis = $_SESSION['nis'];
        /* TOTAL HADIR */

        $totalHadir = mysqli_num_rows(
            mysqli_query(
              $conn,
              "SELECT * FROM presensi
               WHERE nis='$nis'
               AND status='Hadir'"
            )
        );

        /* TOTAL TELAT */

        $totalTelat = mysqli_num_rows(
            mysqli_query(
               $conn,
               "SELECT * FROM presensi
               WHERE nis='$nis'
               AND status='Telat'"
            )
        );

        /* TOTAL IZIN */

        $totalIzin = mysqli_num_rows(
            mysqli_query(
               $conn,
               "SELECT * FROM presensi
               WHERE nis='$nis'
               AND status='Izin'"
            )
        );

        /* TOTAL SAKIT */

        $totalSakit = mysqli_num_rows(
            mysqli_query(
                $conn,
                "SELECT * FROM presensi
                WHERE nis='$nis'
                AND status='Sakit'"
            )
        );

        $tanggal = date('Y-m-d');

        $cek = mysqli_query(
            $conn,
            "SELECT * FROM presensi
            WHERE nis='$nis'
            AND tanggal='$tanggal'"
        );

        $sudah = mysqli_num_rows($cek);
        ?>

        <div class="presensi-status">

        <?php if($sudah > 0){ ?>

    <!-- SUDAH PRESENSI -->

    <div class="status-card present">

        <i class="fas fa-check-circle"></i>

        <h4>Presensi Berhasil</h4>

        <p>
            Kamu sudah melakukan presensi hari ini
        </p>

        <button class="presensi-btn success">

            <i class="fas fa-check"></i>

            Sudah Presensi

        </button>

    </div>

        <?php } else { ?>

             <!-- BELUM PRESENSI -->

            <div class="status-card waiting">

                <i class="fas fa-calendar-check"></i>

                <h4>Belum Presensi</h4>

                <p>
                    Klik tombol di bawah untuk melakukan presensi hari ini
                </p>

                <form action="presensi.php" method="POST">
                    <select
                        name="status"
                        required
                        style="
                        width:100%;
                        padding:15px;
                        border-radius:10px;
                        margin-bottom:20px;
                        border:2px solid #ddd;
                        ">

                        <option value="">
                           -- pilih status --
                        </option>

                        <option value="Hadir">
                            Hadir
                        </option>

                        <option value="Izin">
                            Izin
                        </option>

                        <option value="Sakit">
                            Sakit
                        </option>

                    </select>

                   <button type="submit" 
                           class="presensi-btn primary">

                        <i class="fas fa-check"></i>

                            Simpan Presensi Sekarang

                    </button>

                </form>

            </div>

        <?php } ?>

        </div> 

    </div>

</div>

</body>
</html>