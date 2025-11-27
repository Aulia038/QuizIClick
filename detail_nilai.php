<?php
// detail_nilai.php
session_start();
include_once 'dbConnection.php';

// Validasi session guru
if (!isset($_SESSION['email_guru'])) {
    header("location:index.php");
    exit();
}

$id_guru = $_SESSION['id_guru'];
$nama_guru = $_SESSION['nama_guru'];
$mapel = $_SESSION['mapel'];

// Ambil eid dari URL
$eid = isset($_GET['eid']) ? mysqli_real_escape_string($con, $_GET['eid']) : '';

if (empty($eid)) {
    header("location:dash_guru.php?q=2&error=ID kuis tidak valid");
    exit();
}

// Verifikasi kuis milik guru ini
$quiz_check = mysqli_query($con, "SELECT * FROM quiz WHERE eid='$eid' AND id_guru='$id_guru'");
if (mysqli_num_rows($quiz_check) == 0) {
    header("location:dash_guru.php?q=2&error=Kuis tidak ditemukan atau bukan milik Anda");
    exit();
}

$quiz = mysqli_fetch_array($quiz_check);
$quiz_title = $quiz['title'];

// Ambil data nilai siswa untuk kuis ini
$nilai_query = mysqli_query($con, 
    "SELECT h.*, u.name, u.gender, u.college 
     FROM history h 
     JOIN user u ON h.email = u.email 
     WHERE h.eid = '$eid' 
     ORDER BY h.score DESC, h.date DESC"
) or die('Error');

$total_peserta = mysqli_num_rows($nilai_query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Detail Nilai - iClick Guru</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
<link rel="stylesheet" href="css/bootstrap.min.css"/>
<link rel="stylesheet" href="css/bootstrap-theme.min.css"/>    
<link rel="stylesheet" href="css/main.css">
<link rel="stylesheet" href="css/font1.css">
<script src="js/jquery.js" type="text/javascript"></script>
<script src="js/bootstrap.min.js" type="text/javascript"></script>

<style>
    body {
    background: #fff; 
    position: relative;
    overflow-x: hidden;
}
body::before {
    content: "";
    position: absolute;
    top: -100px;
    right: 600px;
    width: 500px;
    height: 500px;
    background: url("./image/ellipse 1.png") no-repeat;
    background-size: contain;
    z-index: -1;
    opacity: 0.9;
}
body::after {
    content: "";
    position: absolute;
    top: 10px;
    left: 800px;
    width: 100%;
    height: 100%;
    background: url("./image/ellipse 3.png") no-repeat;
    background-size: contain;
    z-index: -1;
    opacity: 0.9;
}
    .main-content {
        margin-left: 250px;
        margin-top: 20px;
        padding: 20px;
        min-height: calc(100vh - 60px);
    }

    /* .quiz-header {
        background: linear-gradient(135deg, #222, #444);
        color: white;
        padding: 20px 30px;
        border-radius: 10px;
        margin-bottom: 30px;
    } */

    .stats-card {
        background: white;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        margin-bottom: 20px;
        text-align:center;
    }

    .table-responsive {
        background: white;
        border-radius: 10px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        overflow: hidden;
    }

    table.table-striped > thead > tr {
        background:#222;
        color:white;
    }

    .badge-lulus {
        background:#27ae60;
        color:white;
    }

    .badge-tidak {
        background:#e74c3c;
        color:white;
    }
    
</style>
</head>
<body>

<!-- Header Bar -->
<header style="
    position: fixed;
    top: 0;
    right: 40px;
    width: calc(100% - 220px);
    height: 60px;
    color: black;
    display: flex;
    align-items: center;
    justify-content: flex-end;
    padding: 0 25px;
    z-index: 999;
">
    <div style="display: flex; align-items: center; gap: 10px;">
        <span style="color:#000; font-weight:400; font-size:16px;" class="bi bi-person-fill"></span>
        <span style="color:#000; font-weight:400; font-size:16px;"><?= htmlspecialchars($nama_guru) ?></span>
    </div>
</header>

<!-- Sidebar Navigation -->
<nav style="
font-size:16px;
  position: fixed;
  top: 0;
  left: 0;
  height: 100%;
  width: 220px;
  background-color: #101010;
  padding-top: 20px;
  color: white;
  overflow-y: auto;
  z-index: 1000;">
  
  <!-- Logo -->
  <div style="text-align:center; margin-bottom:20px;">
    <img src="image/logoheader.png" alt="Logo" style="width:100px; height:100px; margin-top:-30px">
    <h4 style="margin-top:0px; color:#fff; font-size:24px; font-weight:700; text-align:center;">Panel Guru</h4>
    <p style="color:#fff; background:#7C3AED; border-radius:4px; padding:10px 0px; font-size:16px; font-weight:400; margin-bottom:10px;text-align:center;"><?= htmlspecialchars($mapel) ?></p>
  </div>
  <!-- Menu -->
    <li <?php if(!isset($_GET['q']) || @$_GET['q']==0) echo 'style="background:#444; border-radius:4px;"'; ?>>
      <a href="dash_guru.php?q=0" style="display:block; padding:12px 20px; color:white; text-decoration:none;">
        <span class="bi bi-house-door-fill"></span>&nbsp; Beranda
      </a>
    </li>
       <li <?php if(@$_GET['q']==2) echo 'style="background:#444; border-radius:4px;"'; ?>>
      <a href="dash_guru.php?q=2" style="display:block; padding:12px 20px; color:white; text-decoration:none;">
        <span class="bi bi-arrow-left"></span>&nbsp; Kembali
      </a>
    </li>
    <li style="border-top:1px solid #444; margin-top:10px;">
      <a href="logout.php?q=account.php" style="display:block; padding:12px 20px; color:#7C3AED; text-decoration:none;">
        <span class="bi bi-box-arrow-right"></span>&nbsp; Keluar
      </a>
    </li>
  </ul>

</nav>

<!-- Main Content -->
<div class="main-content">
    <div class="container-fluid">
        <!-- Header Kuis -->
        <div class="quiz-header">
            <div class="row">
                <div class="col-md-8">
                   <h1 style="color:#000; font-weight:700; font-size:36px; margin-top:20px;">Detail Nilai Kuis</h1>
                  <p style="font-size:18px; color:#667085; margin-top:18px;">Halaman ini menampilkan rangkuman lengkap nilai siswa pada kuis yang telah dikerjakan.</p>
                
                  <!-- GRID -->
            <div style="display:flex; gap:25px; flex-wrap:wrap;">
               <!-- WRAPPER UNTUK 3 CARD -->
                <div style="display:flex; gap:20px; flex-wrap:wrap; margin-top:10px;">

            <!-- MATERI KUIS -->
            <div style="
                flex:1; min-width:190px; background:#151518; padding:20px; position:relative; border:1px solid #27272A; border-radius:8px;">
                <i class="bi bi-book" style="position:absolute; top:30px; right:30px; font-size:24px; color:#8B5CF6;"></i>
                <h3 style="margin-top:5px; font-size:16px; font-weight:300; color:#71717A;">Materi Kuis</h3>
                <p style="margin-top:5px; font-size:24px; font-weight:700; color:#fff;">
                    <?= htmlspecialchars($quiz_title) ?></p>
            </div>
            <!-- ID KUIS -->
            <div style="
                flex:1; min-width:190px;background:#151518; padding:20px; position:relative;border:1px solid #27272A; border-radius:8px;">
                <i class="bi bi-hash" style="position:absolute; top:25px; right:30px; font-size:24px; color:#10B981;"></i>
                <h3 style="margin-top:5px; font-size:16px; font-weight:300; color:#71717A;">Id Kuis</h3>
                <p style="font-size:18px; font-weight:700;  color:#fff;"><?= $eid ?></p>
            </div>
            <!-- TOTAL PESERTA -->
            <div style="
                flex:1; min-width:190px;background:#151518; padding:20px; position:relative; border:1px solid #27272A; border-radius:8px;">
                <i class="bi bi-people" style="position:absolute; top:30px; right:30px; font-size:24px; color:#3B82F6;"></i>
                <h3 style="margin-top:5px; font-size:16px; font-weight:300; color:#71717A;">Total Peserta</h3>
                <p style="font-size:24px; font-weight:700;  color:#fff;">
                    <?= $total_peserta ?> Siswa </p>
            </div>
        </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- GRID -->
            <div style="display:flex; gap:25px; flex-wrap:wrap;">
               <!-- WRAPPER UNTUK 3 CARD -->
                <div style="display:flex; gap:20px; flex-wrap:wrap; margin-top:10px;">

            <!-- NILAI TERTINGGI -->
            <div style="
                flex:1; min-width:190px; background:#151518; padding:20px; position:relative; border:1px solid #27272A; border-radius:8px;">
                <i class="bi bi-trophy" style="position:absolute; top:30px; right:30px; font-size:24px; color:#8B5CF6;"></i>
                <h3 style="margin-top:5px; font-size:16px; font-weight:300; color:#71717A;">Nilai Tertinggi</h3>
                <p style="margin-top:5px; font-size:24px; font-weight:700; color:#fff;">
                    <?= $max_score = mysqli_fetch_assoc(mysqli_query($con, "SELECT MAX(score) as max FROM history WHERE eid='$eid'"))['max'] ?: '0'; ?></p>
            </div>
            <!-- RATA RATA NILAI -->
            <div style="
                flex:1; min-width:190px;background:#151518; padding:20px; position:relative;border:1px solid #27272A; border-radius:8px;">
                <i class="bi bi-calculator" style="position:absolute; top:25px; right:30px; font-size:24px; color:#10B981;"></i>
                <h3 style="margin-top:5px; font-size:16px; font-weight:300; color:#71717A;">Rata-Rata Nilai</h3>
                <p style="font-size:24px; font-weight:700;  color:#fff;"><?= $avg_score = mysqli_fetch_assoc(mysqli_query($con, "SELECT AVG(score) as avg FROM history WHERE eid='$eid'"))['avg']; 
                           echo $avg_score ? number_format($avg_score,1) : '0'; ?></p>
            </div>
            <!-- PESERTA LULUS -->
            <div style="
                flex:1; min-width:190px;background:#151518; padding:20px; position:relative; border:1px solid #27272A; border-radius:8px;">
                <i class="bi bi-person-check" style="position:absolute; top:30px; right:30px; font-size:24px; color:#3B82F6;"></i>
                <h3 style="margin-top:5px; font-size:16px; font-weight:300; color:#71717A;">Peserta Lulus</h3>
                <p style="font-size:24px; font-weight:700;  color:#fff;">
                    <?= $lulus = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(*) as total FROM history WHERE eid='$eid' AND score >= " . ($quiz['total'] * $quiz['sahi'] * 0.6)))['total']; ?></p>
            </div>
        </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- DETAIL NILAI -->
        <div style="
            background:#151518;
                max-width:100%; 
                margin-right:40px;
                margin-left:280px;
                margin-top:-110px;
                border-radius:10px;
                padding:30px;
                color:white;
        ">
            <!-- HEADER + SEARCH -->
            <div style="
                display:flex; 
                justify-content:space-between; 
                align-items:center;
                margin-bottom:15px;
                gap:10px;
                flex-wrap:wrap;
            ">
                <div style="color:#fff; font-size:24px; font-weight:700;">
                    Detail Nilai Peserta
                    <p style="color:#A1A1AA; font-size:16px; font-weight:300; margin-top:5px;">
                        Berikut adalah hasil pengerjaan kuis oleh seluruh peserta.
                    </p>
                </div>
                <!-- SEARCH -->
                <input id="searchNilai" placeholder="Cari peserta"
                    style="
                        background:#19191B;
                        border:1px solid #27272A;
                        padding:6px 12px;
                        border-radius:6px;
                        color:white;
                        font-size:16px;
                        width:180px;
                        flex:1;
                        max-width:200px;
                    ">
            </div>
            <!-- TABLE WRAPPER -->
            <div style="
                    max-height:350px; 
                    overflow-y:auto; 
                    overflow-x:auto;
                    border:1px solid #27272A; 
                    border-radius:8px;
                    width:100%;
            ">
                <table style="
                        width:100%; 
                        border-collapse:collapse; 
                        font-size:16px; 
                        min-width:700px;
                        color:white;
                ">
                    <thead style="position:sticky; top:0; background:#1c1c1e; z-index:10;">
                        <tr>
                            <th style="padding:12px; text-align:center; font-weight:700;">Peringkat</th>
                            <th style="padding:12px; text-align:left; font-weight:700;">Nama Siswa</th>
                            <th style="padding:12px; text-align:center; font-weight:700;">Jenis Kelamin</th>
                            <th style="padding:12px; text-align:left; font-weight:700;">Lembaga</th>
                            <th style="padding:12px; text-align:center; font-weight:700;">Jawaban Benar</th>
                            <th style="padding:12px; text-align:center; font-weight:700;">Jawaban Salah</th>
                            <th style="padding:12px; text-align:center; font-weight:700;">Total Soal</th>
                            <th style="padding:12px; text-align:center; font-weight:700;">Nilai</th>
                            <th style="padding:12px; text-align:center; font-weight:700;">Tanggal</th>
                            <th style="padding:12px; text-align:center; font-weight:700;">Status</th>
                        </tr>
                    </thead>

                    <tbody id="nilaiTableBody">
                        <?php
                        if($total_peserta > 0) {
                            $rank = 1;
                            mysqli_data_seek($nilai_query, 0);
                            while($nilai = mysqli_fetch_array($nilai_query)) {
                                $score = $nilai['score'];
                                $sahi = $nilai['sahi'];
                                $wrong = $nilai['wrong'];
                                $level = $nilai['level'];
                                $date = date('d/m/Y H:i', strtotime($nilai['date']));
                                $passing_grade = $quiz['total'] * $quiz['sahi'] * 0.6;

                                $status_class = $score >= $passing_grade ? 'color:#27ae60;' : 'color:#e74c3c;';

                                echo "<tr style='border-bottom:1px solid #27272A;'>
                                        <td style='padding:12px; text-align:center; font-weight:700;'>$rank</td>
                                        <td style='padding:12px; text-align:left;'><strong>".htmlspecialchars($nilai['name'])."</strong></td>
                                        <td style='padding:12px; text-align:center;'>{$nilai['gender']}</td>
                                        <td style='padding:12px; text-align:left;'>".htmlspecialchars($nilai['college'])."</td>
                                        <td style='padding:12px; text-align:center;'><span style='background:#2ecc71; padding:4px 8px; border-radius:4px; font-size:12px;'>$sahi</span></td>
                                        <td style='padding:12px; text-align:center;'><span style='background:#e74c3c; padding:4px 8px; border-radius:4px; font-size:12px;'>$wrong</span></td>
                                        <td style='padding:12px; text-align:center;'>$level/{$quiz['total']}</td>
                                        <td style='padding:12px; text-align:center; font-weight:700; $status_class'>$score</td>
                                        <td style='padding:12px; text-align:center;'><small>$date</small></td>
                                        <td style='padding:12px; text-align:center;'>
                                            <span style='
                                                padding:4px 10px;
                                                border-radius:4px;
                                                font-size:12px;
                                                background:" . ($score >= $passing_grade ? "#2ecc71" : "#e74c3c") . ";
                                                color:white;
                                            '>
                                                ".($score >= $passing_grade ? 'LULUS' : 'TIDAK')."
                                            </span>
                                        </td>
                                    </tr>";
                                $rank++;
                            }
                        } else {
                            echo "<tr>
                                    <td colspan='10' style='text-align:center; padding:30px; color:#666;'>
                                        <i class='bi bi-person-fill-slash fa-3x text-muted mb-3'></i><br>
                                        Belum ada peserta
                                    </td>
                                </tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

<!-- SEARCH SCRIPT -->
<script>
    document.getElementById("searchNilai").addEventListener("keyup", function () {
        let filter = this.value.toLowerCase();
        let rows = document.querySelectorAll("#nilaiTableBody tr");

        rows.forEach(row => {
            let text = row.innerText.toLowerCase();
            row.style.display = text.includes(filter) ? "" : "none";
        });
    });
</script>

        <!-- INFO TAMBAHAN -->
        <div style="margin-left:280px; margin-right:40px; margin-top:40px; color:white; max-width:100%;">
            <h1 style="color:#000; font-weight:700; font-size:24px; margin-top:-20px;">Informasi Tambahan</h1>
            <p style="font-size:16px; color:#667085; margin-top:10px;">
                Data berikut menunjukkan detail kuis dan statistik hasil pengerjaan peserta.
            </p>
        </div>
        <div style="
            background:#151518;
            max-width:100%; 
            margin-right:40px;
            margin-left:280px;
            border-radius:8px;
            padding:20px;
            color:white;
        ">
    <div class="row" style="margin-top:10px;">
        <!-- CARD INFORMASI KUIS -->
        <div class="col-md-6" style="margin-bottom:20px;">
            <div style="
                background:#19191B;
                border:1px solid #27272A;
                border-radius:8px;
                padding:20px;
            ">
                <h5 style="font-weight:700; font-size:24px; margin-bottom:10px;margin-top:-5px;">
                    <i class="bi bi-info-circle"></i> Informasi Kuis
                </h5>

                <table style="
                    width:100%;
                    font-size:16px;
                    color:white;
                    border-collapse:collapse;
                ">
                    <tr style="border-bottom:1px solid #27272A;">
                        <td style="padding:10px; width:40%; color:#A1A1AA; font-size:16px;"><strong>Judul Kuis</strong></td>
                        <td style="padding:10px; font-size:16px;"><?= htmlspecialchars($quiz_title) ?></td>
                    </tr>
                    <tr style="border-bottom:1px solid #27272A;">
                        <td style="padding:10px; color:#A1A1AA; font-size:16px;"><strong>Total Soal</strong></td>
                        <td style="padding:10px; font-size:16px;"><?= $quiz['total'] ?> soal</td>
                    </tr>
                    <tr style="border-bottom:1px solid #27272A;">
                        <td style="padding:10px; color:#A1A1AA; font-size:16px;"><strong>Nilai Maksimal</strong></td>
                        <td style="padding:10px; font-size:16px;"><?= $quiz['total']*$quiz['sahi'] ?> poin</td>
                    </tr>
                    <tr style="border-bottom:1px solid #27272A;">
                        <td style="padding:10px; color:#A1A1AA; font-size:16px;"><strong>Nilai per Soal</strong></td>
                        <td style="padding:10px; font-size:16px;"><?= $quiz['sahi'] ?> poin</td>
                    </tr>
                    <tr>
                        <td style="padding:10px; color:#A1A1AA; font-size:16px;"><strong>Pengurangan Nilai</strong></td>
                        <td style="padding:10px; font-size:16px;"><?= $quiz['wrong'] ?> poin</td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- CARD STATISTIK -->
        <div class="col-md-6">
            <div style="
                background:#19191B;
                border:1px solid #27272A;
                border-radius:8px;
                padding:20px;
            ">
                <h5 style="font-weight:700; font-size:24px; margin-bottom:10px;">
                    <i class="bi bi-pie-chart"></i> Statistik Kelulusan
                </h5>
               <?php
                    $tidak_lulus = $total_peserta - $lulus;
                    $persen_lulus = $total_peserta>0 ? round(($lulus/$total_peserta)*100,1) : 0;
                    $persen_tidak_lulus = $total_peserta>0 ? round(($tidak_lulus/$total_peserta)*100,1) : 0;
                    ?>
                <div class="progress" style=" font-size:16px; background:#19191B; border:1px solid #27272A; height:100%; padding:10px; margin-bottom:10px;">
                        <div class="progress-bar bg-success" style="font-size:16px; width:<?= $persen_lulus ?>%">Lulus: <?= $persen_lulus ?>%</div>
                    </div>
                    <div class="progress" style=" font-size:16px; background:#19191B; border:1px solid #27272A; height:100%; padding:10px;">
                        <div class="progress-bar bg-danger" style="font-size:16px; width:<?= $persen_tidak_lulus ?>%">TidakLulus: <?= $persen_tidak_lulus ?>%</div>
                    </div>
                <table style="
                    width:100%;
                    font-size:16px;
                    color:white;
                    border-collapse:collapse;
                    margin-top:15px;
                ">
                    <tr style="border-bottom:1px solid #27272A; font-size:16px;">
                        <td style="padding:10px; width:40%; color:#A1A1AA;"><strong>Lulus</strong></td>
                        <td style="padding:10px;"><?= $lulus ?> siswa (<?= $persen_lulus ?>%)</td>
                    </tr>
                    <tr style="border-bottom:1px solid #27272A; font-size:16px;">
                        <td style="padding:10px; color:#A1A1AA;"><strong>Tidak Lulus</strong></td>
                        <td style="padding:10px;"><?= $tidak_lulus ?> siswa (<?= $persen_tidak_lulus ?>%)</td>
                    </tr>

                    <tr>
                        <td style="padding:10px; color:#A1A1AA; font-size:16px;"><strong>Total</strong></td>
                        <td style="padding:10px;"><?= $total_peserta ?> siswa</td>
                    </tr>
                </table>

            </div>
        </div>

    </div>
</div>
</body>
</html>
