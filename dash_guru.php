<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>iClick || DASHBOARD GURU</title>
<link  rel="stylesheet" href="css/bootstrap.min.css"/>
 <link  rel="stylesheet" href="css/bootstrap-theme.min.css"/>    
 <link rel="stylesheet" href="css/main.css">
 <link  rel="stylesheet" href="css/font1.css">
 <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
 <script src="js/jquery.js" type="text/javascript"></script>
<script src="js/bootstrap.min.js"  type="text/javascript"></script>
 	

<script>
$(function () {
    $(document).on( 'scroll', function(){
        if($(window).scrollTop()>=$(".logo").height())
        {
             $(".navbar").addClass("navbar-fixed-top");
        }

        if($(window).scrollTop()<$(".logo").height())
        {
             $(".navbar").removeClass("navbar-fixed-top");
        }
    });
});</script>
</head> 
<?php
include_once 'dbConnection.php';
session_start();

if (!isset($_SESSION['email_guru'])) {
  header("location:index.php");
  exit();
}

// PERBAIKAN: Jika id_guru NULL, ambil dari database
$nama_guru = $_SESSION['nama_guru'];
$email_guru = $_SESSION['email_guru'];
$mapel = $_SESSION['mapel'];

// FIX: Ambil id_guru dengan fallback ke database
if (!isset($_SESSION['id_guru']) || empty($_SESSION['id_guru']) || $_SESSION['id_guru'] === null) {
    // Ambil dari database berdasarkan email
    $guru_query = mysqli_query($con, "SELECT id_guru FROM guru WHERE email_guru = '$email_guru'");
    if ($guru_data = mysqli_fetch_array($guru_query)) {
        $_SESSION['id_guru'] = $guru_data['id_guru'];
        $id_guru = $guru_data['id_guru'];
        error_log("FIXED: id_guru retrieved from database: " . $id_guru);
    } else {
        // Jika masih tidak ditemukan, logout
        error_log("ERROR: Cannot find guru data for email: " . $email_guru);
        session_destroy();
        header("location:index.php?w=Data guru tidak ditemukan");
        exit();
    }
} else {
    $id_guru = $_SESSION['id_guru'];
}
?>
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
    top: 40px;
    left: 900px;
     width: 100%;
    height: 100%;
    background: url("./image/ellipse 3.png") no-repeat;
    background-size: contain;
    z-index: -1;
    opacity: 0.9;
}
  </style>>
  
<!-- Header Bar
<header style="
  position: fixed;
  top: 0;
  left: 220px; /* karena sidebar lebarnya 220px */
  width: calc(100% - 220px);
  height: 60px;
  background-color: #fff;
  color: white;
  display: flex;
  align-items: center;
  justify-content: flex-end;
  padding: 0 25px;
  box-shadow: 0 2px 5px rgba(0,0,0,0.3);
  z-index: 999;
">
</header> -->
<!-- </div></div> -->

<!--navigation menu-->
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
 <li <?php if(@$_GET['q']==10) echo 'style="background:#444; border-radius:4px;"'; ?>>
  <a href="dash_guru.php?q=10" 
     style="display:flex; align-items:center; gap:4px; padding:12px 20px; 
            color:#fff; text-decoration:none; cursor:pointer;">
    <span class="bi bi-person-fill"></span>
    Halo, <b><?= htmlspecialchars($nama_guru) ?></b>
  </a>
</li>
    <li <?php if(!isset($_GET['q']) || @$_GET['q']==0) echo 'style="background:#444; border-radius:4px;"'; ?>>
      <a href="dash_guru.php?q=0" style="display:block; padding:12px 20px; color:white; text-decoration:none;">
        <span class="bi bi-house-door-fill"></span>&nbsp; Beranda
      </a>
    </li>
    <li <?php if(@$_GET['q']==1) echo 'style="background:#444; border-radius:4px;"'; ?>>
      <a href="dash_guru.php?q=1" style="display:block; padding:12px 20px; color:white; text-decoration:none;">
        <span class="bi bi-mortarboard-fill"></span>&nbsp; Kuis Saya
      </a>
    </li>
    <li <?php if(@$_GET['q']==2) echo 'style="background:#444; border-radius:4px;"'; ?>>
      <a href="dash_guru.php?q=2" style="display:block; padding:12px 20px; color:white; text-decoration:none;">
        <span class="bi bi-file-bar-graph-fill"></span>&nbsp; Lihat Nilai
      </a>
    </li>

    <!-- Dropdown manual untuk Quiz -->
    <li <?php if(@$_GET['q']==3 || @$_GET['q']==4) echo 'style="background:#333; border-radius:4px;"'; ?>>
      <details style="padding:0;">
        <summary style="cursor:pointer; padding:12px 20px; color:white; list-style:none;">
          <span class="bi bi-mortarboard-fill"></span>&nbsp; Kelola Kuis
        </summary>
        <ul style="list-style:none; padding:0; margin:0;">
          <li><a href="dash_guru.php?q=3" style="display:block; padding:10px 40px; color:#ccc; text-decoration:none;">Buat Kuis Baru</a></li>
          <li><a href="dash_guru.php?q=4" style="display:block; padding:10px 40px; color:#ccc; text-decoration:none;">Edit Kuis</a></li>
        </ul>
      </details>
    </li>

    <li style="border-top:1px solid #444; margin-top:10px;">
      <a href="logout.php?q=account.php" style="display:block; padding:12px 20px; color:#7C3AED; text-decoration:none;">
        <span class="bi bi-box-arrow-right"></span>&nbsp; Keluar
      </a>
    </li>
  </ul>
</nav>

<!--navigation menu closed-->
<div class="container"><!--container start-->
<div class="row">
<div class="col-md-12">

<!-- PROFIL GURU -->
<?php 
if (@$_GET['q'] == 10) { 
?>
<div style="
    margin-left:220px;
    margin-top:80px;
    color:white;
    margin-right:-23px;
    max-width:100%; 
">
    <h1 style="color:#000; font-weight:700; font-size:36px; margin-top:-40px;">Profil Guru</h1>
    <p style="font-size:18px; color:#667085; margin-top:10px;">
        Selamat Datang, 
        <b style="color:#667085;"><?= htmlspecialchars($_SESSION['nama_guru']) ?></b>.
        Berikut adalah informasi tentang akun Anda sebagai Pengajar.
    </p>

    <!-- CARD WRAPPER -->
    <div style="
        background:#151518;
                margin-top:15px;
                padding: 25px 15px;
                border-radius:8px;
                border:1px solid #27272A;
    ">
        <!-- GRID -->
        <div style="
                  display: grid;
                  grid-template-columns: repeat(2, 1fr);
                  gap: 20px;
              ">
            <!-- ID GURU -->
            <div style="background:#151518; border-radius:8px; border:1px solid #27272A; padding:10px 12px;">
                <h3 style="color:#71717A; margin:5px 0 4px 0; font-size:16px; font-weight:400;">Nomor Id</h3>
                <p style="font-size:24px; color:#fff; margin:0; font-weight:600;">
                    <?= htmlspecialchars($_SESSION['id_guru']) ?>
                </p>
            </div>
            <!-- NAMA -->
            <div style="background:#151518; border-radius:8px; border:1px solid #27272A; padding:10px 12px;">
                <h3 style="color:#71717A; margin:5px 0 4px 0; font-size:16px; font-weight:400;">Nama Lengkap</h3>
                <p style="font-size:24px; color:#fff; margin:0; font-weight:600;">
                    <?= htmlspecialchars($_SESSION['nama_guru']) ?>
                </p>
            </div>

            <!-- EMAIL -->
            <div style="background:#151518; border-radius:8px; border:1px solid #27272A; padding:10px 12px;">
                <h3 style="color:#71717A; margin:5px 0 4px 0; font-size:16px; font-weight:400;">Email</h3>
                 <p style="font-size:24px; color:#fff; margin:0; font-weight:600;">
                    <?= htmlspecialchars($_SESSION['email_guru']) ?>
                </p>
            </div>
            <!-- MAPEL -->
            <div style="background:#151518; border-radius:8px; border:1px solid #27272A; padding:10px 12px;">
                 <h3 style="color:#71717A; margin:5px 0 4px 0; font-size:16px; font-weight:400;">Mata Pelajaran</h3>
                <p style="font-size:24px; color:#fff; margin:0; font-weight:600;">
                    <?= htmlspecialchars($_SESSION['mapel']) ?>
                </p>
            </div>
        
        </div>
</div>
<?php } ?>

<!-- Dashboard Guru -->
<?php 
if(@$_GET['q']==0) {

    $total_quiz = mysqli_fetch_assoc(mysqli_query($con, 
        "SELECT COUNT(*) as total FROM quiz WHERE id_guru='$id_guru'"))['total'];
    
    $total_siswa = mysqli_fetch_assoc(mysqli_query($con,
        "SELECT COUNT(DISTINCT email) as total FROM history WHERE eid IN 
        (SELECT eid FROM quiz WHERE id_guru='$id_guru')"))['total'];
    
    $avg_score = mysqli_fetch_assoc(mysqli_query($con,
        "SELECT AVG(score) as avg FROM history WHERE eid IN 
        (SELECT eid FROM quiz WHERE id_guru='$id_guru')"))['avg'];
    
    $avg_score = $avg_score ? number_format($avg_score, 1) : '-';
    
    echo '
    <div style="margin-left:219px; margin-top:80px; color:white; max-width; margin-right:-70px;  ">
    <h1 style="color:#000; font-weight:700; font-size:36px; margin-top:-40px;">Beranda</h1>
            <p style="font-size:18px; color:#667085; margin-top:10px;">
                Selamat Datang, <b style="color:#667085;">'.htmlspecialchars($nama_guru).'</b>
            </p>
            <p style="font-size:18px; color:#667085; margin-top:10px;">
                Anda login sebagai Guru <b style="color:#667085;">'.htmlspecialchars($mapel).'</b>
            </p>
          <!-- GRID -->
            <div style="display:flex; gap:25px; flex-wrap:wrap;">
               <!-- WRAPPER UNTUK 3 CARD -->
            <div style="display:flex; gap:20px; flex-wrap:wrap; margin-top:10px;">
        <!-- TOTAL KUIS -->
                <div style="
                    flex:1; min-width:200px;
                    background:#151518; padding:20px;
                    border:1px solid #27272A; border-radius:8px;">
                    <h3 style="margin-top:5px; font-size:16px; font-weight:300; color:#71717A;">
                        Total Kuis </h3>
                    <p style="margin-top:5px; font-size:24px; font-weight:700; margin-top:8px; color:#fff;">
                        '.$total_quiz.'
                    </p>
                </div>
        <!-- Total Siswa -->
                <div style="
                    flex:1; min-width:200px;
                    background:#151518; padding:20px;
                    border:1px solid #27272A; border-radius:10px;">
                    <h3 style="margin-top:5px; font-size:16px; font-weight:300; color:#71717A;">
                        Total Siswa
                    </h3>
                    <p style="font-size:24px; font-weight:700; margin-top:8px; color:#fff;">
                        '.$total_siswa.'
                    </p>
                </div>
        <!-- Rata-Rata -->
              <div style="
                  flex:1; min-width:200px;
                  background:#151518; padding:20px;
                  border:1px solid #27272A; border-radius:10px;">
                  
                  <h3 style="margin-top:5px; font-size:16px; font-weight:300; color:#71717A;">
                      Rata-Rata Nilai
                  </h3>
                  <p style="font-size:24px; font-weight:700; margin-top:8px; color:#fff;">
                      '.$avg_score.'
                  </p>
              </div>
          </div>
            <!-- BUAT KUIS -->
    <div style="
        background:#111; color:white; padding:20px; border-radius:14px; 
        margin-top:5px; margin-right:50px; border:1px solid #222; width:100%;">
        <div style="background:#181818; padding:15px 20px; border-radius:10px; 
             border:1px solid #333; display:flex; justify-content:space-between; align-items:center; margin-bottom:5px;">
             <div style="display:flex; align-items:flex-start; gap:12px;">
            <span class="bi bi-plus-circle-fill" 
                style="font-size:24px; color:#7C3AED; margin-top:3px;">
            </span>
            <div>
                <p style="margin:0; font-size:24px; font-weight:700;">Buat Kuis</p>
                <p style="font-size:16px; opacity:0.7; margin-top:10px; font-weight:400; color:#CCCCCC;">
                    Buat kuis baru untuk siswa. Tambahkan soal, pengaturan waktu, serta opsi nilai sesuai kebutuhan pembelajaran
                </p>
            </div>
             </div>
            <a href="dash_guru.php?q=1" style="background:#7C3AED; padding:8px 22px; color:white;
          text-decoration:none; border-radius:8px; font-size:16px;
          display:inline-block; min-width:90px; text-align:center;">Buat</a>
        </div>

  <!-- LIHAT KUIS SAYA -->
    <div style=" margin-top:10px;">
        <div style="background:#181818; padding:15px 20px; border-radius:10px; 
             border:1px solid #333; display:flex; justify-content:space-between; 
             align-items:center; margin-bottom:5px;">
             <div style="display:flex; align-items:flex-start; gap:12px;">
            <span class="bi bi-journal-text" 
                style="font-size:24px; color:#7C3AED; margin-top:3px;">
            </span>
            <div>
                <p style="margin:0; font-weight:700; font-size:24px;">Kuis Saya</p>
                <p style="font-size:16px; opacity:0.7; margin-top:10px; font-weight:400; color:#CCCCCC;">
                    Tampilkan semua kuis yang telah Anda buat. Kelola kuis, lihat status pengerjaan, dan lakukan pembaruan kapan saja
                </p>
            </div>
            </div>
            <a href="dash_guru.php?q=1" style="background:#7C3AED; padding:8px 22px; color:white;
          text-decoration:none; border-radius:8px; font-size:16px;
          display:inline-block; min-width:90px; text-align:center;">Kuis </a>
        </div>

        <!-- LIHAT NILAI -->
    <div style=" margin-top:10px;">
        <div style="background:#181818; padding:15px 20px; border-radius:10px; 
             border:1px solid #333; display:flex; justify-content:space-between; 
             align-items:center; margin-bottom:5px;">
             <div style="display:flex; align-items:flex-start; gap:12px;">
            <span class="bi bi-clipboard2-data-fill" 
                style="font-size:24px; color:#7C3AED; margin-top:3px;">
            </span>
            <div>
                <p style="margin:0; font-size:24px; font-weight:700;">Lihat Nilai</p>
                <p style="font-size:16px; opacity:0.7; margin-top:10px; font-weight:400; color:#CCCCCC;">
                   Lihat riwayat pengerjaan siswa secara lengkap, termasuk nilai, dan waktu pengerjaan
                </p>
            </div>
            </div>
            <a href="dash_guru.php?q=2" style="background:#7C3AED; padding:8px 22px; color:white;
          text-decoration:none; border-radius:8px; font-size:16px;
          display:inline-block; min-width:90px; text-align:center;"> Nilai </a>
        </div>
    ';        
}
?>

<!-- LIHAT NILAI (ROLE GURU) -->
<?php 
if(@$_GET['q']==2) {

    echo '
    <div style="margin-left:219px; margin-top:80px; color:white; max-width:100%; margin-right:-70px; ">
    <h1 style="color:#000; font-weight:700; font-size:36px; margin-top:-40px;">Nilai</h1>
        <p style="font-size:18px; color:#667085; margin-top:10px;">
            Pantau nilai siswa pada setiap kuis yang Anda buat.
        </p>
    </div>

    <div style="
        background:#151518;
        margin-right:-23px;
        max-width:100%;
        margin-left:220px;
        border-radius:10px;
        padding:30px;
        color:white;
    ">
        <!-- HEADER ACTION (BUTTON + SEARCH) -->
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px; flex-wrap:wrap; gap:10px;">
        <!-- BUTTON BUAT KUIS BARU -->
            <a href="dash_guru.php?q=4" 
                style="
                    background:#7C3AED; 
                    color:white; 
                    padding:7px 14px; 
                    border-radius:8px; 
                    font-size:16px; 
                    text-decoration:none;
                    font-weight:300;
                    display:inline-block;
                "
                onmouseover="this.style.background=\'#A855F7\'"
                onmouseout="this.style.background=\'#9333EA\'"
            >
                + Buat Kuis </a>

            <!-- SEARCH -->
            <input id="searchQuizTeacher" placeholder="Cari kuis" 
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
        <!-- END HEADER ACTION -->

        <!-- WRAPPER TABEL -->
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
                        <th style="padding:12px; text-align:left; font-weight:700;">No</th>
                        <th style="padding:12px; text-align:left; font-weight:700;">Nama Kuis</th>
                        <th style="padding:12px; text-align:left; font-weight:700;">Peserta</th>
                        <th style="padding:12px; text-align:left; font-weight:700;">Nilai Tertinggi</th>
                        <th style="padding:12px; text-align:left; font-weight:700;">Nilai Rata-rata</th>
                        <th style="padding:12px; text-align:center; font-weight:700;">Aksi</th>
                    </tr>
                </thead>

                <tbody id="teacherScoreTable">
    ';

    // Query kuis guru
    $quiz_result = mysqli_query($con,"SELECT * FROM quiz WHERE id_guru='$id_guru' ORDER BY date DESC") or die('Error');
    $c=1;
    
    while($quiz = mysqli_fetch_array($quiz_result)) {
        $eid = $quiz['eid'];
        $title = $quiz['title'];
        
        $peserta = mysqli_fetch_assoc(mysqli_query($con,"SELECT COUNT(*) as total FROM history WHERE eid='$eid'"))['total'];
        $max_score = mysqli_fetch_assoc(mysqli_query($con,"SELECT MAX(score) as max FROM history WHERE eid='$eid'"))['max'];
        $avg_score = mysqli_fetch_assoc(mysqli_query($con,"SELECT AVG(score) as avg FROM history WHERE eid='$eid'"))['avg'];

        $max_score = $max_score ? number_format($max_score, 1) : '-';
        $avg_score = $avg_score ? number_format($avg_score, 1) : '-';

        echo '
        <tr style="border-bottom:1px solid #27272A;">
            <td style="padding:12px;">'.$c++.'</td>
            <td style="padding:12px;"><strong>'.$title.'</strong></td>
            <td style="padding:12px;">'.$peserta.'</td>
            <td style="padding:12px;" class="text-success">'.$max_score.'</td>
            <td style="padding:12px;" class="text-primary">'.$avg_score.'</td>
            <td style="padding:12px; text-align:center;">
                <a href="detail_nilai.php?eid='.$eid.'" 
                    style="
                        background:#7C3AED; 
                        color:white; 
                        padding:6px 12px; 
                        border-radius:6px; 
                        font-size:16px; 
                        text-decoration:none;
                    ">
                    Detail
                </a>
            </td>
        </tr>';
    }

    if($c == 1) {
        echo '
        <tr>
            <td colspan="6" style="text-align:center; padding:20px; color:#888;">
                <i class="bi bi-clipboard-x-fill fa-2x text-muted"></i><br>
                Belum ada data nilai. Buat kuis terlebih dahulu!
            </td>
        </tr>';
    }
    echo '
                </tbody>
            </table>
        </div> 
    </div>
    ';
}
?>

<?php
if(@$_GET['q']==3 && !(@$_GET['step'])) {
echo '
<div>
    <div style="color:#000; font-weight:700; font-size:36px; margin-top:40px; margin-left:220px;">Membuat Kuis Baru</div>
    <div style="font-size:18px; color:#667085; font-weight:300; margin-top:10px; margin-left:220px">
      Tambahkan pertanyaan, atur jawaban, dan atur kuis
    </div>
</div>
    <div style="margin-top:10px; margin-left:220px; padding:30px; background:#101010; border-radius:8px; max-width; margin-right:-20px; color:white;">
      <form name="form" action="update_guru.php?q=addquiz" method="POST">

    <input type="hidden" name="pembuat" value="guru">
    <input type="hidden" name="id_guru" value="'.$id_guru.'">

    <div style="display:flex; gap:25px;">
      <!-- KIRI -->
      <div style="flex:1; background:#151518; padding:25px; border-radius:14px; border:1px solid #27272A;">
        <h3 style="margin-top:-10px; color:#fff; font-weight:700; font-size:24px;">Detail Kuis</h3>
        <p style="font-size:16px; color:#667085; font-weight:300; margin-top:-5px;">Informasi dasar tentang kuis Anda</p>

        <label style="margin-top:15px; display:block; font-size:18px; font-weight:400;">Judul Kuis</label>
        <input id="name" name="name" type="text" placeholder="Masukkan Judul Kuis" required
               style="font-size:16px; font-weight:300; width:100%; background:#fff; border:1px solid #27272A; padding:12px 14px; border-radius:8px; margin-top:6px; color:#000;">

        <label style="margin-top:15px; display:block; font-size:18px; font-weight:400;">Mata Pelajaran</label>
        <input id="tag" name="tag" type="text" placeholder="Masukkan #tag (untuk memudahkan pencarian)"
               style="font-size:16px; font-weight:300; width:100%; background:#fff; border:1px solid #27272A; padding:12px 14px; border-radius:8px; margin-top:6px; color:#000;">

        <label style="margin-top:15px; display:block; font-size:18px; font-weight:400;">Deskripsi</label>
        <textarea name="desc" placeholder="Tulis deskripsi kuis di sini..." 
                  style="font-size:16px; font-weight:300; width:100%; background:#fff; border:1px solid #27272A; padding:12px 14px; border-radius:8px; margin-top:6px; color:#000; height:120px;"></textarea>
      </div>

      <!-- KANAN -->
      <div style="flex:1; background:#151518; padding:25px; border-radius:14px; border:1px solid #27272A;">

        <h3 style="margin-top:-10px; color:#fff; font-weight:700; font-size:24px;">Pengaturan Kuis</h3>
        <p style="font-size:16px; color:#667085; font-weight:300; margin-top:-5px;">Atur cara kerja kuis Anda</p>

        <label style="margin-top:15px; display:block; font-size:18px; font-weight:400;">Waktu</label>
        <input id="time" name="time" type="number" min="1" placeholder="Masukkan batas waktu ujian dalam menit" required
               style="font-size:16px; font-weight:300; width:100%; background:#fff; border:1px solid #27272A; padding:12px 14px; border-radius:8px; margin-top:6px; color:#000;">

        <label style="margin-top:15px; display:block; font-size:18px; font-weight:400;">Nilai Jawaban Benar</label>
        <input id="right" name="right" type="number" placeholder="Masukkan nilai untuk jawaban benar" required
               style="font-size:16px; font-weight:300; width:100%; background:#fff; border:1px solid #27272A; padding:12px 14px; border-radius:8px; margin-top:6px; color:#000;">

        <label style="margin-top:16px; display:block; font-size:18px; font-weight:400;">Pengurangan Nilai</label>
        <input id="wrong" name="wrong" type="number" placeholder="Masukkan pengurangan nilai untuk jawaban salah" required
               style="font-size:16px; font-weight:300; width:100%; background:#fff; border:1px solid #27272A; padding:12px 14px; border-radius:8px; margin-top:6px; color:#000;">

        <label style="margin-top:15px; display:block; font-size:18px; font-weight:400;">Jumlah Soal</label>
        <input id="total" name="total" type="number" placeholder="Masukkan jumlah total soal" required
               style="font-size:16px; font-weight:300; width:100%; background:#fff; border:1px solid #27272A; padding:12px 14px; border-radius:8px; margin-top:6px; color:#000;">
      </div>
    </div>

    <div style="margin-top:25px; display:flex; justify-content:flex-end; gap:10px;">
      <button type="button" onclick="history.back()" 
              style="background:none; color:#ccc; padding:10px 22px; border:1px solid #27272A; ; border-radius:10px; font-size:16px; font-weight:300;">
        ‹ Sebelumnya
      </button>
      <button type="submit"
              style="background:#7C3AED; color:white; padding:10px 22px; border:none; ; border-radius:10px; font-size:16px; font-weight:300;">
        Lanjut ›
      </button>
    </div>

  </form>
</div>
';
}
?>

<!-- Quiz Saya - GURU (Hanya milik guru tersebut) -->
<?php 
if(@$_GET['q']==1) {

    $result = mysqli_query($con,"SELECT 
        q.*, 
        g.nama_guru, 
        g.mapel
    FROM quiz q 
    LEFT JOIN guru g ON q.id_guru = g.id_guru 
    WHERE q.id_guru = '$id_guru' 
    ORDER BY q.date DESC") or die('Error');

    // ==== HEADER ====
    echo '
    <div style="margin-left:219px; margin-top:80px; max-width:100%; margin-right:90px;">
        <h1 style="color:#000; font-weight:700; font-size:36px; margin-top:-40px;">Kuis Saya</h1>
        <p style="font-size:18px; color:#667085; margin-top:10px;">
            Daftar seluruh kuis yang telah Anda buat dan kelola.
        </p>
    </div>

    <!-- WRAPPER KONTEN -->
    <div style="
        background:#151518;
        margin-right:-23px;
        max-width:100%;
        margin-left:220px;
        border-radius:10px;
        padding:30px;
        color:white;
    ">
        
        <!-- ACTION HEADER -->
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px; flex-wrap:wrap; gap:10px;">
            
            <!-- BUTTON BUAT KUIS BARU -->
            <a href="dash_guru.php?q=3" 
                style="
                    background:#7C3AED; 
                    color:white; 
                    padding:7px 14px; 
                    border-radius:8px; 
                    font-size:16px; 
                    text-decoration:none;
                    font-weight:300;
                    display:inline-block;
                "
                onmouseover="this.style.background=\'#A855F7\'"
                onmouseout="this.style.background=\'#9333EA\'"
            >
                + Buat Kuis Baru
            </a>

            <!-- SEARCH -->
            <input id="searchMyQuiz" placeholder="Cari kuis" 
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

        <!-- TABEL WRAPPER -->
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
                        <th style="padding:12px; text-align:left; font-weight:700;">No</th>
                        <th style="padding:12px; text-align:left; font-weight:700;">Materi</th>
                        <th style="padding:12px; text-align:left; font-weight:700;">Total Soal</th>
                        <th style="padding:12px; text-align:left; font-weight:700;">Nilai Max</th>
                        <th style="padding:12px; text-align:left; font-weight:700;">Waktu</th>
                        <th style="padding:12px; text-align:left; font-weight:700;">Tanggal Dibuat</th>
                        <th style="padding:12px; text-align:center; font-weight:700;">Status</th>
                    </tr>
                </thead>

                <tbody id="myQuizTable">
    ';

    // ==== LOOP DATA QUIZ  ====
    $c=1;
    while($row = mysqli_fetch_array($result)) {
        $title = $row['title'];
        $total = $row['total'];
        $sahi = $row['sahi'];
        $time = $row['time'];
        $date = $row['date'];
        $eid = $row['eid'];

        $peserta = mysqli_fetch_assoc(mysqli_query($con,"SELECT COUNT(*) as total FROM history WHERE eid='$eid'"))['total'];
        
        echo '
        <tr style="border-bottom:1px solid #27272A;">
            <td style="padding:12px;">'.$c++.'</td>
            <td style="padding:12px;"><strong>'.$title.'</strong></td>
            <td style="padding:12px;">'.$total.'</td>
            <td style="padding:12px;">'.($sahi * $total).'</td>
            <td style="padding:12px;">'.$time.' &nbsp;min</td>
            <td style="padding:12px;">'.date("d-m-Y", strtotime($date)).'</td>
            <td style="padding:12px; text-align:center;">
                <span style="
                    background:#7C3AED; 
                    padding:4px 10px; 
                    border-radius:5px; 
                    font-size:16px;
                ">Aktif</span>
                <br><small style="color:#71717A; display:block; margin-top:5px;">'.$peserta.' peserta</small>
            </td>
        </tr>';
    }
    
    if($c == 1) {
        echo '
        <tr>
            <td colspan="7" style="text-align:center; padding:20px; color:#888;">
                <i class="bi bi-inbox fa-2x text-muted"></i><br>
                Belum ada Kuis yang dibuat.
                <a href="dash_guru.php?q=3" style="color:#A855F7;">Buat Kuis Pertama Anda!</a>
            </td>
        </tr>';
    }

    echo '
                </tbody>
            </table>
        </div>
    </div>

    <!-- FILTER SEARCH SCRIPT -->
    <script>
        document.getElementById("searchMyQuiz").addEventListener("keyup", function () {
            let filter = this.value.toLowerCase();
            let rows = document.querySelectorAll("#myQuizTable tr");

            rows.forEach(row => {
                let text = row.innerText.toLowerCase();
                row.style.display = text.includes(filter) ? "" : "none";
            });
        });
    </script>
    <script>
function showQuizDetails(eid, title) {
    window.location.href = "detail_nilai.php?q=detail&eid=" + eid;
}
</script>
    ';
}
?>
<!-- Hapus Quiz -->
<?php 
if(@$_GET['q']==4) {
     $result = mysqli_query($con,"SELECT * FROM quiz WHERE id_guru='$id_guru' ORDER BY date DESC") or die('Error');
     

    echo '
    <div style="margin-left:219px; margin-top:80px; color:white; max-width; margin-right:-70px;">
        <h1 style="color:#000; font-weight:700; font-size:36px; margin-top:-40px;">Kelola Kuis</h1>
        <p style="font-size:18px; color:#667085; margin-top:10px;">
            Kelola seluruh kuis yang telah Anda buat. Anda dapat melihat detail, mengedit, atau menghapus kuis.
        </p>
    </div>

    <div style="
        background:#151518;
        margin-right:-23px;
        max-width:100%;
        margin-left:220px;
        border-radius:10px;
        padding:30px;
        color:white;
    ">

        <!-- HEADER ACTION -->
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px; flex-wrap:wrap; gap:10px;">
            
            <!-- BUTTON TAMBAH KUIS -->
            <a href="dash_guru.php?q=3" 
                style="
                    background:#7C3AED; 
                    color:white; 
                    padding:7px 14px; 
                    border-radius:8px; 
                    font-size:16px; 
                    text-decoration:none;
                    font-weight:300;
                    display:inline-block;
                "
                onmouseover="this.style.background=\'#A855F7\'"
                onmouseout="this.style.background=\'#9333EA\'"
            >
                + Buat Kuis Baru
            </a>

            <!-- SEARCH -->
            <input id="searchManageQuiz" placeholder="Cari kuis" 
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
                min-width:750px;
                color:white;
            ">
                <thead style="position:sticky; top:0; background:#1c1c1e; z-index:10;">
                    <tr>
                        <th style="padding:12px; text-align:left; font-weight:700;">No</th>
                        <th style="padding:12px; text-align:left; font-weight:700;">Judul Kuis</th>
                        <th style="padding:12px; text-align:left; font-weight:700;">Total Soal</th>
                        <th style="padding:12px; text-align:left; font-weight:700;">Nilai Maks</th>
                        <th style="padding:12px; text-align:left; font-weight:700;">Waktu</th>
                        <th style="padding:12px; text-align:left; font-weight:700;">Tanggal</th>
                        <th style="padding:12px; text-align:center; font-weight:700;">Aksi</th>
                    </tr>
                </thead>

                <tbody id="manageQuizTable">';
    
    $c=1;
    while($row = mysqli_fetch_array($result)) {
      $title = $row['title'];
      $total = $row['total'];
      $sahi = $row['sahi'];
      $time = $row['time'];
      $date = $row['date'];
      $eid = $row['eid'];
      $tag = $row['tag'];
      $intro = $row['intro'];

      $peserta = mysqli_fetch_assoc(mysqli_query($con,"SELECT COUNT(*) as total FROM history WHERE eid='$eid'"))['total'];
        echo '
        <tr style="border-bottom:1px solid #27272A;">
        <td style="padding:12px;">'.$c++.'</td>
        <td style="padding:12px;">
            <strong>'.$title.'</strong>'.
        (!empty($tag) 
            ? '<br><small style="color:#9ca3af; font-size:12px;">#'.$tag.'</small>' 
            : '').'</td>

        <td style="padding:12px;">'.$total.'</td>
        <td style="padding:12px;">
        <span style="background:#7C3AED; padding:4px 10px; border-radius:5px; font-size:16px;">'.($sahi * $total).'</span></td>
        <td style="padding:12px;">'.$time.' menit</td>
        <td style="padding:12px;">'.date("d-m-Y", strtotime($date)).'</td>
        <td style="padding:12px; text-align:center;">

           <!-- LIHAT -->
            <button 
                onclick="showQuizDetails(\''.$eid.'\', \''.htmlspecialchars($title).'\', \''.$total.'\', \''.($sahi * $total).'\', \''.$time.'\', \''.date("d/m/Y", strtotime($date)).'\', \''.htmlspecialchars($tag).'\', \''.htmlspecialchars($intro).'\', \''.$peserta.'\')" 
                style="
                    background:#3B82F6; 
                    color:white; 
                    padding:6px 12px; 
                    border-radius:6px; 
                    font-size:16px; 
                    border:none;
                    margin-right:6px;
                ">
                Lihat
            </button>

            <!-- EDIT -->
            <a href="edit_quiz_guru.php?eid='.$eid.'" 
                style="
                    background:#F59E0B; 
                    color:white;
                    padding:6px 12px;
                    border-radius:6px;
                    font-size:16px;
                    text-decoration:none;
                    margin-right:6px;
                ">
                Edit
            </a>

            <!-- HAPUS -->
            <button 
                onclick="confirmDelete(\''.$eid.'\', \''.htmlspecialchars($title).'\')" 
                style="
                    background:#EF4444; 
                    color:white; 
                    padding:6px 12px; 
                    border-radius:6px; 
                    font-size:16px; 
                    border:none;
                ">
                Hapus
            </button>
            </td>
          </tr>
      ';
    }
    
    if($c == 1) {
        echo '<tr>
                <td colspan="7" style="text-align:center; padding:30px; color:#666;">
                  <i class="fas fa-inbox fa-3x text-muted mb-3"></i><br>
                  <h4>Belum ada kuis yang dibuat</h4>
                  <p class="text-muted">Mulai dengan membuat kuis pertama Anda</p>
                  <a href="dash_guru.php?q=3" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Buat Kuis Baru
                  </a>
                </td>
              </tr>';
    }

    echo '
        </table>
      </div>
    </div>

<!-- Modal Detail Kuis -->
<div class="modal fade" id="quizDetailModal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content modal-dark">
      <!-- HEADER -->
      <div class="modal-header modal-purple">
        <h4 class="modal-title; font-size:36px; font-weight:400; color:#fff;">
          <i class="bi bi-info-circle"></i> Detail Kuis</h4> 
          </div>
      
          <!-- BODY -->
      <div class="modal-body modal-body-dark">
        <div class="field-group">
          <strong class="label-purple">Judul:</strong>
          <div id="modalTitle" class="value-big"></div>
        </div>
        <!-- BADGE ROW -->
        <div class="badge-row">
          <div class="badge-box">
            <span class="label">Total Soal</span>
            <span id="modalTotalSoal" class="value"></span>
          </div>
          <div class="badge-box">
            <span class="label">Nilai Maks</span>
            <span id="modalNilaiMaks" class="value"></span>
          </div>

          <div class="badge-box">
            <span class="label">Waktu</span>
            <span id="modalWaktu" class="value"></span>
          </div>

          <div class="badge-box">
            <span class="label">Peserta</span>
            <span id="modalPeserta" class="value"></span>
          </div>
        </div>

        <div class="field-group">
          <strong class="label-purple">Tanggal:</strong>
          <div id="modalTanggal" class="value-normal"></div>
        </div>

        <div class="field-group">
          <strong class="label-purple">Tag:</strong>
          <div id="modalTag" class="value-normal"></div>
        </div>

        <div class="field-group">
          <strong class="label-purple">Deskripsi:</strong>
          <div id="modalDeskripsi" class="deskripsi-box"></div>
        </div>

      </div>

      <!-- FOOTER -->
      <div class="modal-footer modal-footer-dark">
        <button type="button" class="btn btn-dark-close" data-dismiss="modal">
          Tutup
        </button>
      </div>

    </div>
  </div>
</div>

<style>
  .modal-dark {
    background:#0f0f10;
    border-radius:14px;
    border:1px solid #27272A;
    box-shadow:0 0 25px rgba(0,0,0,0.35);
    overflow:hidden;
    color:#fff;
  }

  .modal-purple {
    background:#7C3AED;
    padding:18px 20px;
    color:#fff;
    font-weight:700;
    border-bottom:1px solid #5B2BC5;
  }

  .modal-body-dark {
    background:#151518;
    padding:25px;
  }

  .modal-footer-dark {
    background:#0f0f10;
    border-top:1px solid #27272A;
    padding:15px 20px;
  }

  .btn-dark-close {
    background:#27272A;
    color:white;
    padding:8px 20px;
    border-radius:8px;
    font-size:14px;
  }

  .label-purple {
    color:#A78BFA;
    font-weight:600;
  }

  .value-big {
    font-size:17px;
    font-weight:700;
    margin-top:3px;
  }

  .value-normal {
    margin-top:3px;
    color:#E5E7EB;
  }

  .badge-row {
    display:flex;
    flex-wrap:wrap;
    gap:12px;
    margin:15px 0;
  }

  .badge-box {
    background:#1c1c1e;
    padding:12px 16px;
    border-radius:8px;
    border:1px solid #27272A;
    min-width:140px;
  }

  .badge-box .label {
    font-size:11px;
    color:#9CA3AF;
  }

  .badge-box .value {
    margin-top:3px;
    font-size:15px;
    font-weight:700;
  }

  .deskripsi-box {
    background:#0f0f10;
    padding:15px;
    border-radius:10px;
    border:1px solid #27272A;
    color:#D1D5DB;
    margin-top:6px;
    min-height:50px;
  }

  .field-group {
    margin-bottom:18px;
  }
</style>


        </td>
      </tr>';
    }

    echo '    
                </tbody>
            </table>
        </div>
    </div>
    <script>
    function showQuizDetails(eid, title, totalSoal, nilaiMaks, waktu, tanggal, tag, deskripsi, peserta) {
        let content = `
            <div class="row">
                <div class="col-md-6">
                    <h5 style="color:#333; border-bottom:2px solid #3498db; padding-bottom:10px;">
                        <i class="fas fa-clipboard-list"></i> Informasi Kuis
                    </h5>
                    <table class="table table-bordered">
                        <tr><td><strong>Judul Kuis:</strong></td><td>${title}</td></tr>
                        <tr><td><strong>Total Soal:</strong></td><td>${totalSoal} soal</td></tr>
                        <tr><td><strong>Nilai Maksimal:</strong></td><td><span class="badge" style="background:#27ae60;">${nilaiMaks}</span> poin</td></tr>
                        <tr><td><strong>Waktu Pengerjaan:</strong></td><td>${waktu} menit</td></tr>
                        <tr><td><strong>Tanggal Dibuat:</strong></td><td>${tanggal}</td></tr>
                        <tr><td><strong>Jumlah Peserta:</strong></td><td><span class="badge" style="background:#3498db;">${peserta}</span> siswa</td></tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <h5 style="color:#333; border-bottom:2px solid #e74c3c; padding-bottom:10px;">
                        <i class="fas fa-tags"></i> Informasi Tambahan
                    </h5>
                    <p><strong>Tag:</strong> ${tag ? "#" + tag : "<em>Tidak ada tag</em>"}</p>
                    <p><strong>Deskripsi:</strong></p>
                    <div style="background:#f8f9fa; padding:15px; border-radius:5px; border-left:4px solid #3498db;">
                        ${deskripsi ? deskripsi : "<em>Tidak ada deskripsi</em>"}
                    </div>
                </div>
            </div>
        `;
        document.getElementById("quizDetailContent").innerHTML = content;
        $("#quizDetailModal").modal("show");
    }

    function confirmDelete(eid, title) {
        if(confirm("Apakah Anda yakin ingin menghapus kuis \\"" + title + "\\"?\\n\\nTindakan ini tidak dapat dibatalkan dan akan menghapus semua data terkait kuis ini!")) {
            window.location.href = "update_guru.php?q=rmquiz&eid=" + eid;
        }
    }
    </script>
    ';

?>

<!-- Form Buat Soal (Step 2) -->
 <style>
/* CARD PERTANYAAN */
.question-box {
    background: #FFFFFF;
    border-radius: 14px;
    padding: 25px;
    margin-bottom: 30px;
}

/* HEADER BOX */
.question-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 18px;
}

.question-title {
    font-size: 16px;
    font-weight: 700;
    color: #000;
}

.question-point {
    background: #1A1A1A;
    color: #fff;
    padding: 6px 12px;
    border-radius: 8px;
    font-weight: 600;
}

/* TEXTAREA DARK */
.question-box textarea {
    width: 100%;
    background: #1F1F1F;
    color: #fff;
    border: none;
    border-radius: 10px;
    padding: 10px;
    font-size: 12px;
    margin-bottom: 18px;
}

/* NAV BUTTONS */
.nav-btn {
    background: #1F1F1F;
    color: #E5E7EB;
    padding: 10px 20px;
    border-radius: 10px;
    border: 1px solid #333;
}

.next-btn {
    background: #7C3AED;
    color: #fff;
    border: none;
    padding: 10px 25px;
    border-radius: 10px;
    font-weight: 600;
}
</style>

<?php
if(@$_GET['q']==5 && (@$_GET['step'])==2 ) {
    $eid = @$_GET['eid'];
    $n = @$_GET['n'];
    $nilai_per_soal = @$_GET['nilai_per_soal'];
    
    // Verifikasi ini quiz milik guru yang login
    $check = mysqli_query($con, "SELECT * FROM quiz WHERE eid='$eid' AND id_guru='$id_guru'");
    if(mysqli_num_rows($check) == 0) {
        echo '<div class="alert alert-danger" style="margin-left:220px; margin-top:40px;">
                Akses ditolak! Kuis tidak ditemukan atau bukan milik Anda.
              </div>';
    } else {
        $quiz_data = mysqli_fetch_array($check);
        echo '
        <div style=" margin-left: 220px; margin-top:80px; color:max-width; margin-right:-190px;">
        <h1 style="color:#000; font-weight:700; font-size:36px; margin-top:-40px;">Membuat Kuis Baru</h1>
            <p style="font-size:18px; color:#667085; margin-top:10px;">
                 Tambahkan pertanyaan, atur jawaban, dan atur kuis.</p>
        <div style=" background: #151518; border-radius: 8px; padding: 20px; border:1px solid #27272A; width: 86%;">
        <h3 style="font-size:24px; font-weight:700; margin-top:-1px; color:#fff">Pertanyaan</h3>
        <div style="display:flex; justify-content:space-between; align-items:flex-start; gap:20px;">    
            <p style="color:#9CA3AF; margin-bottom:25px; font-size:16px; font-weight:300; color:#A1A1AA;">
                Buat dan kelola pertanyaan kuis Anda <br> Jumlah Pertanyaan: <strong>'.$n.' soal</strong> <br> Untuk kuis: <strong>'.$quiz_data['title'].'</strong></p>
        <div style=" background: #151518; border:none; color:#A1A1AA; font-size:16px; font-weight:300; margin-top:-5px; width:40%; text-align:right;">
         <strong>Informasi Nilai:</strong> 
            Total nilai maksimal kuis: <strong>'.($n * $quiz_data['sahi']).'</strong> poin<br>
                Nilai default per soal: <strong>'.$quiz_data['sahi'].'</strong> poin (bisa diubah per soal)
        </div>
</div>
            <form name="form" action="update_guru.php?q=addqns&n='.$n.'&eid='.$eid.'" method="POST">
        ';

                for($i=1; $i<=$n; $i++) {

           echo '
<div class="question-box">
    <div class="question-header">
        <div class="question-title" style="font-size:24px;font-weight:600;" >Pertanyaan '.$i.'</div>
        <div class="question-point">'.$quiz_data['sahi'].' Poin</div>
    </div>

    <label style="font-weight:400; color:#000; font-size:16px;">Teks Pertanyaan</label>
    <textarea name="qns'.$i.'" rows="3" required></textarea>

    <div style="margin-bottom:10px; font-size:16px; font-weight:300; color:#000;">Pilihan Jawaban</div>

    <!-- Opsi A -->
    <div style="display:flex; align-items:center; gap:10px; margin-bottom:5px;">
        <input type="radio" name="ans'.$i.'" value="a" required style="accent-color:#7C3AED; transform:scale(1.3);">
        <input type="text" name="'.$i.'1" placeholder="Opsi A..." 
          style="background:#1F1F20; color:#fff; border:1px solid #27272A; 
          padding:12px; font-size:16px; border-radius:8px; width:100%;" required>
    </div>

    <!-- Opsi B -->
    <div style="display:flex; align-items:center; gap:10px; margin-bottom:5px;">
        <input type="radio" name="ans'.$i.'" value="b" required style="accent-color:#7C3AED; transform:scale(1.3);">
        <input type="text" name="'.$i.'2" placeholder="Opsi B..." 
          style="background:#1F1F20; color:#fff; border:1px solid #27272A; 
          padding:12px; font-size:16px; border-radius:8px; width:100%;" required>
    </div>

    <!-- Opsi C -->
    <div style="display:flex; align-items:center; gap:10px; margin-bottom:5px;">
        <input type="radio" name="ans'.$i.'" value="c" required style="accent-color:#7C3AED; transform:scale(1.3);">
        <input type="text" name="'.$i.'3" placeholder="Opsi C..." 
          style="background:#1F1F20; color:#fff; border:1px solid #27272A; 
          padding:12px; font-size:16px; border-radius:8px; width:100%;" required>
    </div>

    <!-- Opsi D -->
    <div style="display:flex; align-items:center; gap:10px; margin-bottom:5px;">
        <input type="radio" name="ans'.$i.'" value="d" required style="accent-color:#7C3AED; transform:scale(1.3);">
        <input type="text" name="'.$i.'4" placeholder="Opsi D..." 
          style="background:#1F1F20; color:#fff; border:1px solid #27272A; 
          padding:12px; font-size:16px; border-radius:8px; width:100%;" required>
    </div>

    <!-- hidden nomor urut -->
    <input type="hidden" name="sn'.$i.'" value="'.$i.'">
</div>
';
                }

        // tombol navigasi SELALU di dalam echo
        echo '
        <div style="margin-top:25px; display:flex; justify-content:flex-end; gap:10px;">

            <!-- Tombol Sebelumnya -->
            <a href="?q=3"
                style="background:none; color:#fff; padding:10px 22px; border:1px solid #27272A;
                border-radius:10px; font-size:16px; font-weight:300; cursor:pointer;
                text-decoration:none; display:inline-block;">
                ‹ Sebelumnya
            </a>

            <!-- Tombol Simpan -->
            <button type="submit"
                style="background:#7C3AED; color:white; padding:10px 22px; border:none;
                border-radius:10px; font-size:16px; font-weight:300; cursor:pointer;">
               Simpan ›
            </button>

        </div>
        ';

        // Hitung total nilai (diluar echo tombol)
        $total_nilai = $n * $quiz_data['sahi'];

        echo '
        <div style="margin-top:10px; 
                    border-radius:10px; padding:20px;">

            <div style="text-align:center; margin-bottom:20px; color:#E5E7EB;">
                <strong style="font-size:16px;">Total Nilai Maksimal Kuis:</strong>
                <div style="font-size:16px; font-weight:700; margin-top:5px;">'.$total_nilai.' Poin</div>
                <small style="font-size:16px; color:#A1A1AA; margin-top:5px;">
                    Berdasarkan jumlah soal ('.$n.') × nilai per soal ('.$quiz_data['sahi'].' poin)
                </small>
            </div>

            <div style="display:flex; justify-content:center; gap:12px; margin-top:10px;">
                <!-- Reset -->
                <button type="reset"
                    style="background:#7C3AED; color:#fff; border:none; padding:10px 20px;
                    border-radius:10px; font-size:16px; cursor:pointer;">
                    Reset Form
                </button>

            </div>

        </div>
        </form>
        ';
    }
}
?>

<script>
function showQuizDetails(eid, title, totalSoal, nilaiMaks, waktu, tanggal, tag, deskripsi, peserta) {
    document.getElementById('modalTitle').innerText = title;
    document.getElementById('modalTotalSoal').innerText = totalSoal + ' soal';
    document.getElementById('modalNilaiMaks').innerText = nilaiMaks + ' poin';
    document.getElementById('modalWaktu').innerText = waktu + ' menit';
    document.getElementById('modalTanggal').innerText = tanggal;
    document.getElementById('modalPeserta').innerText = peserta;
    document.getElementById('modalTag').innerHTML = tag ? '#' + tag : '<em>Tidak ada tag</em>';
    document.getElementById('modalDeskripsi').innerHTML = deskripsi ? deskripsi : '<em>Tidak ada deskripsi</em>';
    $('#quizDetailModal').modal('show');
}
</script>

</div>
<!--container closed-->
</div></div>

<!-- ===== FOOTER START ===== -->
<!-- <footer style="
  background-color:#000;
  color:#ccc;
  padding:50px 100px;
  font-family:'Poppins', sans-serif;
  border-top:1px solid #222;
">

  <div style="display:flex; flex-wrap:wrap; justify-content:space-between; margin-left:150px;"> -->

    <!-- Logo + Deskripsi -->
    <!-- <div style="flex:1; min-width:250px; margin-bottom:30px; margin-top:-20px;">
      <img src="image/logo.png" alt="IClick" style="width:130px; margin-bottom:15px;">
      <p style="max-width:280px; font-size:14px; color:#aaa;">
        Platform kuis terbaik untuk siswa dan guru.<br>Belajar dan berkompetisi.
      </p>
<div style="margin-top:20px; display:flex; gap:15px;">
  <a href="https://www.facebook.com/wegoingdeath" style="color:#9b59b6; font-size:20px;"><i class="fab fa-facebook"></i></a>
  <a href="https://x.com/gibran_tweet" style="color:#9b59b6; font-size:20px;"><i class="fab fa-twitter"></i></a>
  <a href="https://www.instagram.com/bahlillahadalia" style="color:#9b59b6; font-size:20px;"><i class="fab fa-instagram"></i></a>
  <a href="https://www.linkedin.com/in/bahlil-bahlul-820b1a279" style="color:#9b59b6; font-size:20px;"><i class="fab fa-linkedin"></i></a>
  <a href="https://www.youtube.com/@corbuzier" style="color:#9b59b6; font-size:20px;"><i class="fab fa-youtube"></i></a>
</div>

    </div> -->

    <!-- Quick Links -->
    <!-- <div style="flex:1; min-width:220px; margin-bottom:30px; margin-left:80px;">
      <h4 style="color:#fff; font-weight:600;">Link Footer</h4>
<ul style="list-style:none; padding:0; margin-top:15px;">
  <li><a href="dash_guru.php?q=0" style="color:#aaa; text-decoration:none; display:block; margin-bottom:13px;">Dashboard</a></li>
  <li><a href="dash_guru.php?q=1" style="color:#aaa; text-decoration:none; display:block; margin-bottom:13px;">Quiz Saya</a></li>
  <li><a href="dash_guru.php?q=2" style="color:#aaa; text-decoration:none; display:block; margin-bottom:13px;">Lihat Nilai</a></li>
  <li><a href="dash_guru.php?q=3" style="color:#aaa; text-decoration:none; display:block; margin-bottom:13px;">Buat Quiz Baru</a></li>
  <li><a href="dash_guru.php?q=4" style="color:#aaa; text-decoration:none; display:block; margin-bottom:13px;">Hapus Quiz</a></li>
</ul>

    </div> -->

    <!-- Contact Info -->
    <!-- <div style="flex:1; min-width:220px; margin-bottom:30px;">
      <h4 style="color:#fff; font-weight:600;">Contacts us</h4>
      <ul style="list-style:none; padding:0; margin-top:15px; color:#aaa; font-size:14px;">
        <li><i class="glyphicon glyphicon-envelope" style="color:#9b59b6;"></i> iclick.quiz@gmail.com</li>
        <li style="margin-top:8px;"><i class="glyphicon glyphicon-earphone" style="color:#9b59b6;"></i> 081 335 245 678</li>
        <li style="margin-top:8px;"><i class="glyphicon glyphicon-map-marker" style="color:#9b59b6;"></i> Ketintang, Surabaya, Jawa Timur</li>
      </ul>
    </div>
  </div>

  <div style="border-top:1px solid #222; margin-left:150px; margin-top:30px; padding-top:15px; display:flex; justify-content:space-between; flex-wrap:wrap;">
    <p style="font-size:13px; color:#777;">Copyright © 2025 IClick</p>
    <p style="font-size:13px; color:#777;">
      Hak Cipta Dilindungi UU | 
      <a href="#" style="color:#9b59b6; text-decoration:none;">Syarat dan Ketentuan</a> | 
      <a href="#" style="color:#9b59b6; text-decoration:none;">Kebijakan Privasi</a>
    </p>
  </div>
</footer> -->
<!-- ===== FOOTER END ===== -->

<script>
document.addEventListener("DOMContentLoaded", function () {
    // === SEARCH FOR MANAGE QUIZ ===
    let searchManageQuiz = document.getElementById("searchManageQuiz");
    if (searchManageQuiz) {
        searchManageQuiz.addEventListener("keyup", function () {
            let filter = this.value.toLowerCase();
            let rows = document.querySelectorAll("#manageQuizTable tr");
            rows.forEach(row => {
                row.style.display = row.innerText.toLowerCase().includes(filter) ? "" : "none";
            });
        });
    }
    // === SEARCH FOR TEACHER QUIZ ===
    let searchQuizTeacher = document.getElementById("searchQuizTeacher");
    if (searchQuizTeacher) {
        searchQuizTeacher.addEventListener("keyup", function () {
            let filter = this.value.toLowerCase();
            let rows = document.querySelectorAll("#teacherScoreTable tr");
            rows.forEach(row => {
                row.style.display = row.innerText.toLowerCase().includes(filter) ? "" : "none";
            });
        });
    }

});
</script>

</body>
</html>