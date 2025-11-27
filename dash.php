<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Project Worlds || DASHBOARD </title>
<link  rel="stylesheet" href="css/bootstrap.min.css"/>
 <link  rel="stylesheet" href="css/bootstrap-theme.min.css"/>    
 <link rel="stylesheet" href="css/main.css">
 <link  rel="stylesheet" href="css/font.css">
 <script src="js/jquery.js" type="text/javascript"></script>

  <script src="js/bootstrap.min.js"  type="text/javascript"></script>
 	<link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet' type='text/css'>

<script>
$(function () {
    $(document).on( 'scroll', function(){
        console.log('scroll top : ' + $(window).scrollTop());
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

<body  style="background:#eee;">
<div class="header">
<div class="row">
<?php
include_once 'dbConnection.php';
session_start();
//Prevent caching
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

if (!isset($_SESSION['email'])) {
  header("location:index.php");
  exit();
}

$name  = $_SESSION['name'];
$email = $_SESSION['email'];
?>

<!-- Header Bar -->
<header style="
  position: fixed;
  top: 0;
  left: 220px;
  width: calc(100% - 220px);
  height: 60px;
  background-color: black;
  color: white;
  display: flex;
  align-items: center;
  justify-content: flex-end;
  padding: 0 25px;
  box-shadow: 0 2px 5px rgba(0,0,0,0.3);
  z-index: 999;
">
  <div style="display: flex; align-items: center; gap: 10px; margin-right: 20px">
    <span style="color:#ffb300" class="glyphicon glyphicon-user"></span>
    <a href="dash.php?q=9" style="color:#ffb300; text-decoration:none; font-weight:600;">
      Profil
    </a>
  </div>
</header>

</div></div>
<!-- admin start-->

<!--navigation menu-->
<!-- Sidebar Navigation -->
<nav style="
  position: fixed;
  top: 0;
  left: 0;
  height: 100%;
  width: 220px;
  background-color: black;
  padding-top: 20px;
  color: white;
  overflow-y: auto;
  z-index: 1000;
">
  <!-- Logo -->
  <div style="text-align:center; margin-bottom:30px;">
    <img src="image/logo.png" alt="Logo" style="width:100px; height:100px; margin-top:-30px;">
    <h4 style="margin-top:10px; color:#fff;">Panel Admin</h4>
  </div>

  <!-- Menu -->
  <ul style="list-style:none; padding:0; margin:0; margin-top:30px;">
    <li style="padding:12px 20px; color:#ffb300; font-weight:600; display:flex; align-items:center; gap:10px;">
        <span class="glyphicon glyphicon-user"></span>
        <a href="dash.php?q=9" style="color:#ffb300; text-decoration:none;">
            Profil
        </a>
    </li>
    <li <?php if(!isset($_GET['q']) || @$_GET['q']==0) echo 'style="background:#444;"'; ?>>
      <a href="dash.php?q=0" style="display:block; padding:12px 20px; color:white; text-decoration:none;">
        <span class="glyphicon glyphicon-home"></span>&nbsp; Kuis
      </a>
    </li>
    <li <?php if(@$_GET['q']==1) echo 'style="background:#444;"'; ?>>
      <a href="dash.php?q=1" style="display:block; padding:12px 20px; color:white; text-decoration:none;">
        <span class="glyphicon glyphicon-user"></span>&nbsp; Pengguna
      </a>
    </li>
    <li <?php if(@$_GET['q']==2) echo 'style="background:#444;"'; ?>>
      <a href="dash.php?q=2" style="display:block; padding:12px 20px; color:white; text-decoration:none;">
        <span class="glyphicon glyphicon-stats"></span>&nbsp; Peringkat
      </a>
    </li>
    <li <?php if(@$_GET['q']==3) echo 'style="background:#444;"'; ?>>
      <a href="dash.php?q=3" style="display:block; padding:12px 20px; color:white; text-decoration:none;">
        <span class="glyphicon glyphicon-comment"></span>&nbsp; Masukan&Saran
      </a>
    </li>

    <!-- Dropdown manual untuk Quiz -->
    <li <?php if(@$_GET['q']==4 || @$_GET['q']==5) echo 'style="background:#333;"'; ?>>
      <details style="padding:0;">
        <summary style="cursor:pointer; padding:12px 20px; color:white; list-style:none;">
          <span class="glyphicon glyphicon-education"></span>&nbsp; Kuis
        </summary>
        <ul style="list-style:none; padding:0; margin:0;">
          <li><a href="dash.php?q=4" style="display:block; padding:10px 40px; color:#ccc; text-decoration:none;">Tambah Kuis</a></li>
          <li><a href="dash.php?q=5" style="display:block; padding:10px 40px; color:#ccc; text-decoration:none;">Edit Kuis</a></li>
        </ul>
      </details>
    </li>

    <!-- Menu Kelola Guru -->
    <li <?php if(@$_GET['q']==6) echo 'style="background:#444;"'; ?>>
      <a href="dash.php?q=6" style="display:block; padding:12px 20px; color:white; text-decoration:none;">
        <span class="glyphicon glyphicon-education"></span>&nbsp; Kelola Guru
      </a>
    </li>

    <li style="border-top:1px solid #444; margin-top:10px;">
      <a href="logout.php?q=account.php" style="display:block; padding:12px 20px; color:#f66; text-decoration:none;">
        <span class="glyphicon glyphicon-log-out"></span>&nbsp; Keluar
      </a>
    </li>
  </ul>
</nav>

<!--navigation menu closed-->
<div class="container"><!--container start-->
<div class="row">
<div class="col-md-12">

<!--PROFIL ADMIN-->
<?php
if(@$_GET['q']==9) {
    echo '
    <div style="
        width:85%;
        margin:40px auto;
        margin-left:200px;
    ">
        <h1 style="color:#ffb300; font-weight:700;">Profil Admin</h1>
        <p style="font-size:17px; color:black; margin-top:-10px;">
            Selamat datang, <b style="color:black;">'.htmlspecialchars($name).'</b> 👋
        </p>

        <div style="
            background:#1a1a1a;
            padding:30px;
            margin-top:25px;
            border:1px solid #ffb300;
        ">
            <h2 style="margin-top:0; margin-bottom:25px; color:#ffb300; font-weight:600;">
                Informasi Akun
            </h2>

            <div style="display:flex; flex-direction:column; gap:20px;">

                <div style="
                    background:#222;
                    padding:20px;
                    border:1px solid #ffb300;
                    display:flex;
                    align-items:center;
                    gap:15px;
                ">
                    <span class="glyphicon glyphicon-user" style="color:#ffb300; font-size:18px;"></span>
                    <span style="color:#ffb300; font-weight:600; width:120px;">Nama</span>
                    <span style="color:#eee;">'.htmlspecialchars($name).'</span>
                </div>

                <div style="
                    background:#222;
                    padding:20px;
                    border:1px solid #ffb300;
                    display:flex;
                    align-items:center;
                    gap:15px;
                ">
                    <span class="glyphicon glyphicon-envelope" style="color:#ffb300; font-size:18px;"></span>
                    <span style="color:#ffb300; font-weight:600; width:120px;">Email</span>
                    <span style="color:#eee;">'.htmlspecialchars($email).'</span>
                </div>

                <div style="
                    background:#222;
                    padding:20px;
                    border:1px solid #ffb300;
                    display:flex;
                    align-items:center;
                    gap:15px;
                ">
                    <span class="glyphicon glyphicon-lock" style="color:#ffb300; font-size:18px;"></span>
                    <span style="color:#ffb300; font-weight:600; width:120px;">Password</span>
                    <span style="color:#eee;">********</span>
                </div>

            </div>

        </div>
    </div>';
}
?>

<!--home start-->
<!-- Daftar Kuis - ADMIN (Tampil Semua) -->
<?php 
if(@$_GET['q']==0) {
    // Gunakan variabel berbeda untuk email admin
    $current_admin_email = $_SESSION['email'];
    
    $result = mysqli_query($con,"SELECT 
        q.*, 
        g.nama_guru, 
        g.mapel,
        CASE 
            WHEN q.id_guru IS NULL THEN 'Admin'
            ELSE CONCAT(g.nama_guru, ' (Guru)')
        END as pembuat_info
    FROM quiz q 
    LEFT JOIN guru g ON q.id_guru = g.id_guru 
    ORDER BY q.date DESC") or die('Error');

    echo  '<div class="panel" style="margin-left:220px; margin-top:40px;">
    <div class="table-responsive">
    <table class="table table-striped title1" style="text-align:center;">
    <tr style="background:#222; color:#fff;">
    <td><b>No</b></td>
    <td><b>Materi</b></td>
    <td><b>Pembuat</b></td>
    <td><b>Total Soal</b></td>
    <td><b>Nilai</b></td>
    <td><b>Batas Waktu</b></td>
    <td><b>Tanggal</b></td>
    </tr>';

    $c=1;
    while($row = mysqli_fetch_array($result)) {
        $title = $row['title'];
        $total = $row['total'];
        $sahi = $row['sahi'];
        $time = $row['time'];
        $date = $row['date'];
        $eid = $row['eid'];
        
        if($row['id_guru']) {
            $pembuat = $row['nama_guru'] . ' (Guru)';
            $mapel = $row['mapel'] ?: '-';
        } else {
            $pembuat = 'Admin';
            $mapel = '-';
        }

        // Gunakan variabel yang berbeda
        $q12=mysqli_query($con,"SELECT score FROM history WHERE eid='$eid' AND email='$current_admin_email'" )or die('Error98');
        $rowcount=mysqli_num_rows($q12);	

        if($rowcount == 0){
            echo '<tr>
            <td>'.$c++.'</td>
            <td>'.$title.'</td>
            <td>'.$pembuat.'<br><small>'.$mapel.'</small></td>
            <td>'.$total.'</td>
            <td>'.$sahi*$total.'</td>
            <td>'.$time.'&nbsp;min</td>
            <td>'.date("d-m-Y", strtotime($date)).'</td>
            </tr>';
        } else {
            echo '<tr style="color:#99cc32">
            <td>'.$c++.'</td>
            <td>'.$title.'&nbsp;<span title="This quiz is already solved by you" class="glyphicon glyphicon-ok" aria-hidden="true"></span></td>
            <td>'.$pembuat.'<br><small>'.$mapel.'</small></td>
            <td>'.$total.'</td>
            <td>'.$sahi*$total.'</td>
            <td>'.$time.'&nbsp;min</td>
            <td>'.date("d-m-Y", strtotime($date)).'</td>
            </tr>';
        }
    }
    $c=0;
    echo '</table></div></div>';
}
?>

<!--home closed-->

<!--users start-->
<?php 
if(@$_GET['q']==1) {
    $result = mysqli_query($con,"SELECT * FROM user") or die('Error');
    echo  '<div class="panel" style="margin-top:40px; margin-left:220px;">
    <div class="table-responsive">
    <table class="table table-striped title1" style="text-align:center;">
    <tr style="background:#222; color:#fff;">
    <td><b>No</b></td><td><b>Nama</b></td><td><b>Jenis Kelamin</b></td><td><b>Lembaga</b></td>
    <td><b>Email</b></td><td><b>Nomor Handphone</b></td><td></td>
    </tr>';
    
    $c=1;
    while($row = mysqli_fetch_array($result)) {
        $user_name = $row['name'];
        $mob = $row['mob'];
        $gender = $row['gender'];
        $user_email = $row['email'];  // Email user
        $college = $row['college'];
        
        echo '<tr>
        <td>'.$c++.'</td>
        <td>'.$user_name.'</td>
        <td>'.$gender.'</td>
        <td>'.$college.'</td>
        <td>'.$user_email.'</td>
        <td>'.$mob.'</td>
        <td>
            <!-- PERBAIKAN: Gunakan $user_email, dan hilangkan tag PHP di dalam echo -->
            <a title="Delete User" href="update_admin.php?demail='.$user_email.'" 
               onclick="return confirm(\'Apakah Anda yakin ingin menghapus user '.$user_name.'?\')">
                <b><span class="glyphicon glyphicon-trash" aria-hidden="true" style="color:red;"></span></b>
            </a>
        </td></tr>';
    }
    
    if($c == 1) {
        echo '<tr><td colspan="7" style="text-align:center; padding:20px;">Tidak ada data pengguna</td></tr>';
    }
    
    echo '</table></div></div>';
}
?>
<!--user end-->

<!--ranking start-->
<?php 
if(@$_GET['q']== 2) {
    $q=mysqli_query($con,"SELECT * FROM `rank` ORDER BY score DESC") or die('Error223');
    echo  '<div class="panel title" style="margin-top:40px; margin-left:220px;">
    <div class="table-responsive">
    <table class="table table-striped title1" style="text-align:center;">
    <tr style="background:#222; color:#fff;">
    <td><b>Peringkat</b></td>
    <td><b>Nama</b></td>
    <td><b>Jenis Kelamin</b></td>
    <td><b>Lembaga</b></td>
    <td><b>Nilai</b></td>
    </tr>';
    
    $c=0;
    while($row=mysqli_fetch_array($q)) {
        $e=$row['email'];
        $s=$row['score'];
        $q12=mysqli_query($con,"SELECT * FROM user WHERE email='$e'") or die('Error231');
        
        // Inisialisasi variabel
        $name = "Unknown";
        $gender = "-";
        $college = "-";
        
        while($row_user=mysqli_fetch_array($q12)) {
            $name=$row_user['name'];
            $gender=$row_user['gender'];
            $college=$row_user['college'];
        }
        $c++;
        
        echo '<tr>
            <td style="color:black"><b>'.$c.'</b></td>
            <td>'.htmlspecialchars($name).'</td>
            <td>'.htmlspecialchars($gender).'</td>
            <td>'.htmlspecialchars($college).'</td>
            <td>'.$s.'</td>
        </tr>';
    }
    
    if($c == 0) {
        echo '<tr><td colspan="5" style="text-align:center; padding:20px;">Belum ada data peringkat.</td></tr>';
    }
    
    echo '</table></div></div>';
}
?>

<!--feedback start-->
<?php 
if(@$_GET['q']==3) {
$result = mysqli_query($con,"SELECT * FROM `feedback` ORDER BY `feedback`.`date` DESC") or die('Error');
echo  '<div class="panel" style="margin-top:40px; margin-left:220px;">
<div class="table-responsive">
<table class="table table-striped title1" style="text-align:center;">
<tr style="background:#222; color:#fff;">
<td><b>No</b></td><td><b>Subjek</b></td><td><b>Email</b></td>
<td><b>Tanggal</b></td><td><b>Waktu</b></td><td><b>Oleh</b></td><td></td><td></td>
</tr>';
$c=1;
while($row = mysqli_fetch_array($result)) {
    $date = $row['date'];
    $date= date("d-m-Y",strtotime($date));
    $time = $row['time'];
    $subject = $row['subject'];
    $name = $row['name'];
    $email = $row['email'];
    $id = $row['id'];
    echo '<tr><td>'.$c++.'</td>';
    echo '<td><a title="Click to open feedback" href="dash.php?q=3&fid='.$id.'">'.$subject.'</a></td>
    <td>'.$email.'</td><td>'.$date.'</td><td>'.$time.'</td><td>'.$name.'</td>
    <td><a title="Open Feedback" href="dash.php?q=3&fid='.$id.'"><b><span class="glyphicon glyphicon-folder-open" aria-hidden="true"></span></b></a></td>
    </tr>';
}
echo '</table></div></div>';
}
?>
<!--feedback closed-->

<!--feedback reading portion start-->
<?php 
if(@$_GET['fid']) {
    echo '<br />';
    $id = @$_GET['fid'];
    $result = mysqli_query($con,"SELECT * FROM feedback WHERE id='$id'") or die('Error');

    while($row = mysqli_fetch_array($result)) {
        $name = $row['name'];
        $subject = $row['subject'];
        $date = $row['date'];
        $date = date("d-m-Y", strtotime($date));
        $time = $row['time'];
        $feedback = $row['feedback'];

        echo '
        <div class="panel" style="margin-top:0px; margin-left:220px; padding:20px; background:#fff; border-radius:8px; box-shadow:0 2px 5px rgba(0,0,0,0.2);">
            <a title="Back to Archive" href="dash.php?q=3" style="color:black; text-decoration:none;">
                <b><span class="glyphicon glyphicon-level-up" aria-hidden="true"></span></b>
            </a>
            <h2 style="text-align:center; margin-top:10px; font-weight:bold;">
                '.$subject.'
            </h2>
            <div class="mCustomScrollbar" data-mcs-theme="dark" 
                style="margin:20px 10px; max-height:450px; line-height:35px; padding:15px; border:1px solid #ddd; border-radius:5px; background:#f9f9f9;">
                <p><b>Tanggal:</b> '.$date.' &nbsp;&nbsp; <b>Waktu:</b> '.$time.' &nbsp;&nbsp; <b>Oleh:</b> '.$name.'</p>
                <hr>
                <p style="white-space:pre-wrap;">'.$feedback.'</p>
            </div>
        </div>';
    }
}
?>
<!--Feedback reading portion closed-->

<!--add quiz start-->
<?php
if(@$_GET['q']==4 && !(@$_GET['step'])) {
    // Ambil daftar guru yang sudah diterima untuk dropdown
    $guru_options = '';
    $guru_query = mysqli_query($con, "SELECT id_guru, nama_guru, mapel FROM guru WHERE status='accept' ORDER BY nama_guru");
    
    while($guru = mysqli_fetch_array($guru_query)) {
        $guru_options .= '<option value="'.$guru['id_guru'].'">'.$guru['nama_guru'].' - '.$guru['mapel'].'</option>';
    }
    
echo ' 
<div class="panel" style="margin-top:40px; margin-left:220px; padding:30px; background:#fff; border-radius:10px; box-shadow:0 2px 6px rgba(0,0,0,0.2); width:80%;">
  <h2 class="title1 text-center" style="font-size:28px; font-weight:bold; margin-bottom:30px;">Buat Kuis</h2>
  
  <form class="form-horizontal title1" name="form" action="update_admin.php?q=addquiz" method="POST" autocomplete="off">
    <fieldset>

      <!-- Pilihan Pembuat Kuis -->
      <div class="form-group">
        <label class="col-md-12 control-label" for="pembuat"><b>Pembuat Kuis</b></label>  
        <div class="col-md-12">
          <select id="pembuat" name="pembuat" class="form-control" required>
            <option value="admin">Saya (Admin)</option>
            <option value="guru">Guru</option>
          </select>
        </div>
      </div>

      <!-- Dropdown Pilih Guru -->
      <div class="form-group" id="guruSelection" style="display:none;">
        <label class="col-md-12 control-label" for="id_guru"><b>Pilih Guru</b></label>  
        <div class="col-md-12">
          <select id="id_guru" name="id_guru" class="form-control">
            <option value="">-- Pilih Guru --</option>
            '.$guru_options.'
          </select>
        </div>
      </div>

      <!-- Quiz Title -->
      <div class="form-group">
        <label class="col-md-12 control-label" for="name"><b>Judul Kuis</b></label>  
        <div class="col-md-12">
          <input id="name" name="name" placeholder="Masukkan Judul Kuis" class="form-control input-md" type="text" required>
        </div>
      </div>

      <!-- Jumlah Soal -->
      <div class="form-group">
        <label class="col-md-12 control-label" for="total"><b>Jumlah Soal</b></label>  
        <div class="col-md-12">
          <input id="total" name="total" placeholder="Masukkan jumlah total soal" class="form-control input-md" type="number" min="1" required>
        </div>
      </div>

      <!-- Nilai Jawaban Benar -->
      <div class="form-group">
        <label class="col-md-12 control-label" for="right"><b>Nilai Jawaban Benar</b></label>  
        <div class="col-md-12">
          <input id="right" name="right" placeholder="Masukkan nilai untuk jawaban benar" class="form-control input-md" type="number" min="0" required>
        </div>
      </div>

      <!-- Pengurangan Nilai -->
      <div class="form-group">
        <label class="col-md-12 control-label" for="wrong"><b>Pengurangan Nilai</b></label>  
        <div class="col-md-12">
          <input id="wrong" name="wrong" placeholder="Masukkan pengurangan nilai untuk jawaban salah" class="form-control input-md" type="number" min="0" required>
        </div>
      </div>

      <!-- Batas Waktu -->
      <div class="form-group">
        <label class="col-md-12 control-label" for="time"><b>Batas Waktu (menit)</b></label>  
        <div class="col-md-12">
          <input id="time" name="time" placeholder="Masukkan batas waktu ujian dalam menit" class="form-control input-md" type="number" min="1" required>
        </div>
      </div>

      <!-- Tag -->
      <div class="form-group">
        <label class="col-md-12 control-label" for="tag"><b>Tag</b></label>  
        <div class="col-md-12">
          <input id="tag" name="tag" placeholder="Masukkan #tag (untuk memudahkan pencarian)" class="form-control input-md" type="text">
        </div>
      </div>

      <!-- Deskripsi -->
      <div class="form-group">
        <label class="col-md-12 control-label" for="desc"><b>Deskripsi Kuis</b></label>  
        <div class="col-md-12">
          <textarea rows="6" name="desc" class="form-control" placeholder="Tulis deskripsi kuis di sini..."></textarea>
        </div>
      </div>

      <!-- Submit Button -->
      <div class="form-group text-center" style="margin-top:20px;">
        <input type="submit" class="btn btn-primary" value="Buat Kuis" style="width:150px;">
      </div>

    </fieldset>
  </form>
</div>

<script>
document.getElementById("pembuat").addEventListener("change", function() {
    var guruSelection = document.getElementById("guruSelection");
    if (this.value === "guru") {
        guruSelection.style.display = "block";
        document.getElementById("id_guru").required = true;
    } else {
        guruSelection.style.display = "none";
        document.getElementById("id_guru").required = false;
    }
});
</script>';
}
?>

<!--add quiz step2 start-->
<?php
if(@$_GET['q']==4 && (@$_GET['step'])==2 ) {
    $eid = @$_GET['eid'];
    $n = @$_GET['n'];
    
    // Cek apakah kuis ada dan ambil info nilai
    $quiz_info = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM quiz WHERE eid='$eid'"));
    $nilai_per_soal = $quiz_info['sahi'];
    
    echo '
    <div style="margin-left: 220px; margin-top:80px; color:max-width; margin-right:-190px;">
        <h1 style="color:#000; font-weight:700; font-size:36px; margin-top:-40px;">Membuat Kuis Baru</h1>
        <p style="font-size:18px; color:#667085; margin-top:10px;">
            Tambahkan pertanyaan, atur jawaban, dan atur kuis.
        </p>
    </div>
    
    <div style="background: #151518; border-radius: 8px; padding: 20px; border:1px solid #27272A; width: 86%; margin-left:220px; margin-top:10px;">
        <h3 style="font-size:24px; font-weight:700; margin-top:-1px; color:#fff">Pertanyaan</h3>
        <div style="display:flex; justify-content:space-between; align-items:flex-start; gap:20px;">    
            <p style="color:#9CA3AF; margin-bottom:25px; font-size:16px; font-weight:300; color:#A1A1AA;">
                Buat dan kelola pertanyaan kuis Anda <br> Jumlah Pertanyaan: <strong>'.$n.' soal</strong> <br> Untuk kuis: <strong>'.$quiz_info['title'].'</strong>
            </p>
            <div style="background: #151518; border:none; color:#A1A1AA; font-size:16px; font-weight:300; margin-top:-5px; width:40%; text-align:right;">
                <strong>Informasi Nilai:</strong> 
                Total nilai maksimal kuis: <strong>'.($n * $quiz_info['sahi']).'</strong> poin<br>
                Nilai default per soal: <strong>'.$quiz_info['sahi'].'</strong> poin (bisa diubah per soal)
            </div>
        </div>

        <form name="form" action="update_admin.php?q=addqns&n='.$n.'&eid='.$eid.'&ch=4" method="POST">';

    for($i=1; $i<=$n; $i++) {
        echo '
        <div class="question-box">
            <div class="question-header">
                <div class="question-title" style="font-size:24px;font-weight:600;">Pertanyaan '.$i.'</div>
                <div class="question-point">'.$quiz_info['sahi'].' Poin</div>
            </div>

            <label style="font-weight:400; color:#fff; font-size:16px;">Teks Pertanyaan</label>
            <textarea name="qns'.$i.'" rows="3" placeholder="Tulis pertanyaan di sini..." required style="width: 100%; background: #1F1F1F; color: #fff; border: 1px solid #27272A; border-radius: 10px; padding: 12px; font-size: 16px; margin-bottom: 18px;"></textarea>

            <div style="margin-bottom:10px; font-size:16px; font-weight:300; color:#fff;">Pilihan Jawaban</div>

            <!-- Opsi A -->
            <div style="display:flex; align-items:center; gap:10px; margin-bottom:8px;">
                <input type="radio" name="ans'.$i.'" value="a" required style="accent-color:#7C3AED; transform:scale(1.3);">
                <input type="text" name="'.$i.'1" placeholder="Opsi A..." 
                    style="background:#1F1F20; color:#fff; border:1px solid #27272A; 
                    padding:12px; font-size:16px; border-radius:8px; width:100%;" required>
            </div>

            <!-- Opsi B -->
            <div style="display:flex; align-items:center; gap:10px; margin-bottom:8px;">
                <input type="radio" name="ans'.$i.'" value="b" required style="accent-color:#7C3AED; transform:scale(1.3);">
                <input type="text" name="'.$i.'2" placeholder="Opsi B..." 
                    style="background:#1F1F20; color:#fff; border:1px solid #27272A; 
                    padding:12px; font-size:16px; border-radius:8px; width:100%;" required>
            </div>

            <!-- Opsi C -->
            <div style="display:flex; align-items:center; gap:10px; margin-bottom:8px;">
                <input type="radio" name="ans'.$i.'" value="c" required style="accent-color:#7C3AED; transform:scale(1.3);">
                <input type="text" name="'.$i.'3" placeholder="Opsi C..." 
                    style="background:#1F1F20; color:#fff; border:1px solid #27272A; 
                    padding:12px; font-size:16px; border-radius:8px; width:100%;" required>
            </div>

            <!-- Opsi D -->
            <div style="display:flex; align-items:center; gap:10px; margin-bottom:15px;">
                <input type="radio" name="ans'.$i.'" value="d" required style="accent-color:#7C3AED; transform:scale(1.3);">
                <input type="text" name="'.$i.'4" placeholder="Opsi D..." 
                    style="background:#1F1F20; color:#fff; border:1px solid #27272A; 
                    padding:12px; font-size:16px; border-radius:8px; width:100%;" required>
            </div>

            <!-- hidden nomor urut -->
            <input type="hidden" name="sn'.$i.'" value="'.$i.'">
        </div>';
    }

    // Hitung total nilai
    $total_nilai = $n * $quiz_info['sahi'];

    echo '
        <div style="margin-top:25px; display:flex; justify-content:flex-end; gap:10px;">

            <!-- Tombol Sebelumnya -->
            <a href="dash.php?q=4"
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

        <div style="margin-top:20px; border-radius:10px; padding:20px; background:#1a1a1a;">

            <div style="text-align:center; margin-bottom:20px; color:#E5E7EB;">
                <strong style="font-size:16px;">Total Nilai Maksimal Kuis:</strong>
                <div style="font-size:18px; font-weight:700; margin-top:5px; color:#7C3AED;">'.$total_nilai.' Poin</div>
                <small style="font-size:14px; color:#A1A1AA; margin-top:5px;">
                    Berdasarkan jumlah soal ('.$n.') × nilai per soal ('.$quiz_info['sahi'].' poin)
                </small>
            </div>

            <div style="display:flex; justify-content:center; gap:12px; margin-top:10px;">
                <!-- Reset -->
                <button type="reset"
                    style="background:#374151; color:#fff; border:1px solid #4B5563; padding:10px 20px;
                    border-radius:10px; font-size:16px; cursor:pointer;">
                    Reset Form
                </button>
            </div>

        </div>
        </form>
    </div>

    <style>
    /* CARD PERTANYAAN */
    .question-box {
        background: #1F1F1F;
        border-radius: 14px;
        padding: 25px;
        margin-bottom: 30px;
        border: 1px solid #27272A;
    }

    /* HEADER BOX */
    .question-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 18px;
    }

    .question-title {
        font-size: 20px;
        font-weight: 700;
        color: #fff;
    }

    .question-point {
        background: #7C3AED;
        color: #fff;
        padding: 6px 12px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 14px;
    }

    /* TEXTAREA DARK */
    .question-box textarea {
        width: 100%;
        background: #1F1F1F;
        color: #fff;
        border: 1px solid #27272A;
        border-radius: 10px;
        padding: 12px;
        font-size: 16px;
        margin-bottom: 18px;
        resize: vertical;
        min-height: 80px;
    }

    .question-box textarea:focus {
        outline: none;
        border-color: #7C3AED;
    }

    /* INPUT STYLING */
    .question-box input[type="text"] {
        background: #1F1F20;
        color: #fff;
        border: 1px solid #27272A;
        padding: 12px;
        font-size: 16px;
        border-radius: 8px;
        width: 100%;
    }

    .question-box input[type="text"]:focus {
        outline: none;
        border-color: #7C3AED;
    }

    /* RADIO BUTTON STYLING */
    .question-box input[type="radio"] {
        accent-color: #7C3AED;
        transform: scale(1.3);
    }

    /* LABEL STYLING */
    .question-box label {
        color: #fff;
        font-size: 16px;
        font-weight: 400;
        margin-bottom: 8px;
        display: block;
    }
    </style>
    ';

    // FOOTER FORM
echo '
<div class="text-center" style="margin-top:30px; padding-top:25px; border-top:2px dashed #ccc;">
    <div class="alert alert-info" style="font-size:16px;">
        <b>Total Nilai Maksimal Kuis:</b> '.($n * $nilai_per_soal).' poin
    </div>

    <button type="reset" class="btn btn-warning btn-lg" style="margin-right:15px;">
        <i class="fas fa-redo"></i> Reset
    </button>

    <button type="submit" class="btn btn-success btn-lg" style="width:220px;">
        <i class="fas fa-save"></i> Simpan Semua Soal
    </button>
</div>
';
}
?>

<!--remove quiz-->
<?php 
if(@$_GET['q']==5) {
    // Query untuk melihat SEMUA kuis (admin + guru)
    $result = mysqli_query($con,"SELECT 
        q.*, 
        g.nama_guru, 
        g.mapel,
        CASE 
            WHEN q.id_guru IS NULL THEN 'Admin'
            ELSE CONCAT(g.nama_guru, ' (Guru)')
        END as pembuat_info
    FROM quiz q 
    LEFT JOIN guru g ON q.id_guru = g.id_guru 
    ORDER BY q.date DESC") or die('Error');

    echo '
    <div class="panel" style="margin-top:40px; margin-left:220px; padding:30px; background:#fff; border-radius:10px; box-shadow:0 2px 6px rgba(0,0,0,0.2); width:80%;">
      <h2 class="title1 text-center" style="font-size:28px; font-weight:bold; margin-bottom:30px;">
        <i class="fas fa-cogs"></i> Kelola Semua Kuis
      </h2>

      <div class="alert alert-info" style="margin-bottom:20px;">
        <i class="fas fa-info-circle"></i> Kelola semua kuis yang tersedia di sistem (baik buatan Admin maupun Guru)
      </div>

      <div class="table-responsive">
        <table class="table table-striped title1" style="text-align:center;">
        <tr style="background:#222; color:#fff;">
          <th style="text-align:center;">No</th>
          <th style="text-align:center;">Judul Kuis</th>
          <th style="text-align:center;">Pembuat</th>
          <th style="text-align:center;">Total Soal</th>
          <th style="text-align:center;">Nilai Maks</th>
          <th style="text-align:center;">Waktu</th>
          <th style="text-align:center;">Aksi</th>
        </tr>';

    $c=1;
    while($row = mysqli_fetch_array($result)) {
      $title = $row['title'];
      $total = $row['total'];
      $sahi = $row['sahi'];
      $time = $row['time'];
      $eid = $row['eid'];
      $pembuat = $row['id_guru'] ? $row['nama_guru'] . ' (Guru)' : 'Admin';
      $mapel = $row['mapel'] ?: '-';
      $tag = $row['tag'];
      $intro = $row['intro'];
      $date = $row['date'];

      // Hitung jumlah peserta
      $peserta = mysqli_fetch_assoc(mysqli_query($con,"SELECT COUNT(*) as total FROM history WHERE eid='$eid'"))['total'];

      echo '
          <tr>
            <td style="vertical-align:middle;">'.$c++.'</td>
            <td style="vertical-align:middle;">
              <strong>'.$title.'</strong>';
              
      if(!empty($tag)) {
        echo '<br><small class="text-muted">#'.$tag.'</small>';
      }
              
      echo '</td>
            <td style="vertical-align:middle;">
              '.$pembuat.'<br>
              <small class="text-muted">'.$mapel.'</small>
            </td>
            <td style="vertical-align:middle;">'.$total.' soal</td>
            <td style="vertical-align:middle;"><span class="badge" style="background:#27ae60;">'.($sahi * $total).'</span></td>
            <td style="vertical-align:middle;">'.$time.' menit</td>
            <td style="vertical-align:middle;">
              <div class="btn-group-vertical" style="display:flex; flex-direction:column; gap:5px;">
                <!-- Tombol READ -->
                <button type="button" class="btn btn-info btn-sm" 
                        style="border-radius:6px; padding:6px 12px; font-size:12px; background:blue;"
                        onclick="showQuizDetails(\''.$eid.'\', \''.htmlspecialchars($title).'\', \''.$total.'\', \''.($sahi * $total).'\', \''.$time.'\', \''.date("d/m/Y", strtotime($date)).'\', \''.htmlspecialchars($tag).'\', \''.htmlspecialchars($intro).'\', \''.$peserta.'\', \''.htmlspecialchars($pembuat).'\', \''.htmlspecialchars($mapel).'\')">
                  <i class="fas fa-eye"></i> Lihat
                </button>
                
                <!-- Tombol EDIT -->
                <button type="button" class="btn btn-warning btn-sm" 
                        style="border-radius:6px; padding:6px 12px; font-size:12px; background:#f39c12; border:none;"
                        onclick="editQuiz(\''.$eid.'\', \''.htmlspecialchars($title).'\')">
                  <i class="fas fa-edit"></i> Edit
                </button>
                
                <!-- Tombol DELETE -->
                <button type="button" class="btn btn-danger btn-sm" 
                        style="border-radius:6px; padding:6px 12px; font-size:12px;"
                        onclick="confirmDelete(\''.$eid.'\', \''.htmlspecialchars($title).'\')">
                  <i class="fas fa-trash"></i> Hapus
                </button>
              </div>
            </td>
          </tr>
      ';
    }

    if($c == 1) {
        echo '<tr>
                <td colspan="7" style="text-align:center; padding:30px;">
                  <i class="fas fa-inbox fa-3x text-muted mb-3"></i><br>
                  <h4 style="color:#666;">Belum ada kuis yang tersedia</h4>
                  <p class="text-muted">Mulai dengan membuat kuis pertama</p>
                  <a href="dash.php?q=4" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Buat Kuis Baru
                  </a>
                </td>
              </tr>';
    }

    echo '
        </table>
      </div>
    </div>

<!-- Modal untuk Detail Kuis -->
<div class="modal fade" id="quizDetailModal" tabindex="-1" role="dialog" aria-labelledby="quizDetailModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content" style="border-radius:10px; overflow:hidden;">
      
      <div class="modal-header" style="background:linear-gradient(135deg, black 0%, black 100%); color:white;">
        <h4 class="modal-title" id="quizDetailModalLabel">
          <i class="fas fa-info-circle"></i> Detail Kuis
        </h4>
        </button>
      </div>

      <div class="modal-body" style="background:#f8f9fa; padding:20px;" id="quizDetailContent">
        <!-- Isi dari script -->
      </div>

      <div class="modal-footer" style="border-top:none;">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
      </div>

    </div>
  </div>
</div>

    <!-- JavaScript untuk fungsi tombol -->
    <script>
    // Fungsi untuk menampilkan detail kuis
    function showQuizDetails(eid, title, totalSoal, nilaiMaks, waktu, tanggal, tag, deskripsi, peserta, pembuat, mapel) {
        let content = `
            <div class="row">
                <div class="col-md-6">
                    <h5 style="color:#333; border-bottom:2px solid black; padding-bottom:10px;">
                        <i class="fas fa-clipboard-list"></i> Informasi Kuis
                    </h5>
                    <table class="table table-bordered">
                        <tr>
                            <td><strong>Judul Kuis:</strong></td>
                            <td>${title}</td>
                        </tr>
                        <tr>
                            <td><strong>Pembuat:</strong></td>
                            <td>${pembuat}<br><small>${mapel}</small></td>
                        </tr>
                        <tr>
                            <td><strong>Total Soal:</strong></td>
                            <td>${totalSoal} soal</td>
                        </tr>
                        <tr>
                            <td><strong>Nilai Maksimal:</strong></td>
                            <td><span class="badge" style="background:black; color:#ffb300;">${nilaiMaks}</span> poin</td>
                        </tr>
                        <tr>
                            <td><strong>Waktu Pengerjaan:</strong></td>
                            <td>${waktu} menit</td>
                        </tr>
                        <tr>
                            <td><strong>Tanggal Dibuat:</strong></td>
                            <td>${tanggal}</td>
                        </tr>
                        <tr>
                            <td><strong>Jumlah Peserta:</strong></td>
                            <td><span class="badge" style="background:black; color:#ffb300;">${peserta}</span> siswa</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <h5 style="color:#333; border-bottom:2px solid black; padding-bottom:10px;">
                        <i class="fas fa-tags"></i> Informasi Tambahan
                    </h5>
                    <p><strong>Tag:</strong> ${tag ? "#" + tag : "<em>Tidak ada tag</em>"}</p>
                    <p><strong>Deskripsi:</strong></p>
                    <div style="background:#f8f9fa; padding:15px; border-radius:5px; border-left:4px solid black;">
                        ${deskripsi ? deskripsi : "<em>Tidak ada deskripsi</em>"}
                    </div>
                </div>
            </div>
            <div class="row" style="margin-top:20px;">
                <div class="col-md-12 text-center">
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle"></i>
                        <strong>Perhatian:</strong> Hanya kuis yang dibuat oleh Admin yang dapat diedit dari sini.
                    </div>
                </div>
            </div>
        `;
        
        document.getElementById("quizDetailContent").innerHTML = content;
        $("#quizDetailModal").modal("show");
    }

    // Fungsi untuk konfirmasi hapus
    function confirmDelete(eid, title) {
        if(confirm("Apakah Anda yakin ingin menghapus kuis \\"" + title + "\\"?\\n\\nTindakan ini tidak dapat dibatalkan dan akan menghapus semua data terkait kuis ini!")) {
            window.location.href = "update_admin.php?q=rmquiz&eid=" + eid;
        }
    }

    // Fungsi untuk edit kuis
    function editQuiz(eid, title) {
        if(confirm("Edit kuis: " + title + "\\n\\nFitur ini akan membawa Anda ke halaman edit kuis.")) {
            // Redirect ke halaman edit kuis - bisa dikembangkan lebih lanjut
            window.location.href = "edit_quiz.php?eid=" + eid;
        }
    }
    </script>

    <style>
    .btn-group-vertical .btn {
        margin: 2px 0;
        transition: all 0.3s ease;
        min-width: 80px;
    }
    
    .btn-group-vertical .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 2px 5px rgba(0,0,0,0.2);
    }
    
    .table tbody tr:hover {
        background-color: #f8f9fa;
        transition: background-color 0.3s ease;
    }
    
    .badge {
        font-size: 12px;
        padding: 5px 10px;
        border-radius: 12px;
    }
    </style>
    ';
}
?>

<!-- Kelola Guru -->
<?php 
if(@$_GET['q']==6) {
    // Inisialisasi variabel message untuk menghindari warning
    $message = '';
    
    // Handle actions dengan prepared statement untuk menghindari error
    if(isset($_GET['action']) && isset($_GET['id'])) {
        $id_guru = (int)$_GET['id'];
        $action = trim($_GET['action']);
        
        // Tentukan nilai status yang sesuai dengan ENUM
        if($action == 'accept') {
            $status_value = 'accept';
        } 
        elseif($action == 'reject') {
            $status_value = 'reject';
        } else {
            $status_value = null;
        }
        
        if($status_value) {
            // Gunakan prepared statement untuk menghindari error
            $stmt = $con->prepare("UPDATE guru SET status = ? WHERE id_guru = ?");
            if ($stmt) {
                $stmt->bind_param("si", $status_value, $id_guru);
                
                if($stmt->execute()) {
                    $message = '<div class="alert alert-success alert-dismissible" style="margin:20px;">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong>Sukses!</strong> Guru telah ' . ($action == 'accept' ? 'diterima' : 'ditolak') . '.
                    </div>';
                    
                    // Refresh halaman untuk memperbarui data
                    echo "<script>setTimeout(function(){ window.location.href = 'dash.php?q=6'; }, 1000);</script>";
                    exit();
                } else {
                    $message = '<div class="alert alert-danger alert-dismissible" style="margin:20px;">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong>Error!</strong> Gagal memperbarui status guru: ' . $stmt->error . '
                    </div>';
                }
                $stmt->close();
            } else {
                $message = '<div class="alert alert-danger alert-dismissible" style="margin:20px;">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>Error!</strong> Gagal mempersiapkan query: ' . $con->error . '
                </div>';
            }
        }
    }

    // Parameter pagination dan search
    $limit = 10;
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $search = isset($_GET['search']) ? mysqli_real_escape_string($con, $_GET['search']) : '';
    $offset = ($page - 1) * $limit;

    // Query untuk mendapatkan data guru dengan search dan pagination
    $search_condition = $search ? "AND (nama_guru LIKE '%$search%' OR email_guru LIKE '%$search%' OR mapel LIKE '%$search%')" : "";
    
    // Query untuk mendapatkan data guru
    $guru_pending = mysqli_query($con, "SELECT * FROM guru WHERE status='pending' $search_condition ORDER BY tanggal_daftar DESC LIMIT $offset, $limit");
    $guru_accepted = mysqli_query($con, "SELECT * FROM guru WHERE status='accept' $search_condition ORDER BY tanggal_daftar DESC LIMIT $offset, $limit");
    $guru_rejected = mysqli_query($con, "SELECT * FROM guru WHERE status='reject' $search_condition ORDER BY tanggal_daftar DESC LIMIT $offset, $limit");

    // Query untuk total data (untuk pagination)
    $total_pending = mysqli_query($con, "SELECT COUNT(*) as total FROM guru WHERE status='pending' $search_condition");
    $total_accepted = mysqli_query($con, "SELECT COUNT(*) as total FROM guru WHERE status='accept' $search_condition");
    $total_rejected = mysqli_query($con, "SELECT COUNT(*) as total FROM guru WHERE status='reject' $search_condition");
    
    $total_pending = mysqli_fetch_assoc($total_pending)['total'];
    $total_accepted = mysqli_fetch_assoc($total_accepted)['total'];
    $total_rejected = mysqli_fetch_assoc($total_rejected)['total'];
    
    $total_pages_pending = ceil($total_pending / $limit);
    $total_pages_accepted = ceil($total_accepted / $limit);
    $total_pages_rejected = ceil($total_rejected / $limit);
    
    echo '
    <div class="panel" style="margin-top:40px; margin-left:220px; padding:30px; background:#fff; border-radius:10px; box-shadow:0 2px 6px rgba(0,0,0,0.2); width:80%;">
        <h2 class="title1 text-center" style="font-size:28px; font-weight:bold; margin-bottom:30px; color:#333;">
            <i class="fas fa-chalkboard-teacher" style="color:black;"></i> Manajemen Pendaftaran Guru
        </h2>
        
        '.$message.'
        
        <!-- Search Box -->
        <div class="row" style="margin-bottom:20px;">
            <div class="col-md-6">
                <form method="GET" action="dash.php">
                    <input type="hidden" name="q" value="6">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Cari nama guru, email, atau mata pelajaran..." value="'.htmlspecialchars($search).'" style="border-radius:20px 0 0 20px;">
                        <div class="input-group-btn">
                            <button class="btn btn-primary" type="submit" style="border-radius:0 20px 20px 0; background:black; color:#ffb300;">
                                <i class="fas fa-search"></i> Cari
                            </button>
                            '.($search ? '<a href="dash.php?q=6" class="btn btn-danger" style="border-radius:0 20px 20px 0; margin-left:2px;">
                                <i class="fas fa-times"></i>
                            </a>' : '').'
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-6 text-right">
                <span class="label label-info" style="background:black; color:#ffb300; padding:8px 15px; border-radius:15px;">
                    <i class="fas fa-info-circle"></i> Menampilkan 10 data per halaman
                </span>
            </div>
        </div>
        
        <!-- Tab Navigation -->
        <ul class="nav nav-tabs" style="border-bottom:2px solid #9b59b6;">
            <li class="active">
                <a data-toggle="tab" href="#pending" style="color:#333; font-weight:600;">
                    <i class="fas fa-clock" style="color:#f39c12;"></i> Pending 
                    <span class="badge" style="background:#f39c12;">'.$total_pending.'</span>
                </a>
            </li>
            <li>
                <a data-toggle="tab" href="#accepted" style="color:#333; font-weight:600;">
                    <i class="fas fa-check-circle" style="color:#27ae60;"></i> Diterima 
                    <span class="badge" style="background:#27ae60;">'.$total_accepted.'</span>
                </a>
            </li>
            <li>
                <a data-toggle="tab" href="#rejected" style="color:#333; font-weight:600;">
                    <i class="fas fa-times-circle" style="color:#e74c3c;"></i> Ditolak 
                    <span class="badge" style="background:#e74c3c;">'.$total_rejected.'</span>
                </a>
            </li>
        </ul>
        
        <div class="tab-content" style="padding:20px 0;">
            <!-- Tab Pending -->
            <div id="pending" class="tab-pane fade in active">
                <h3 style="color:#f39c12; margin-bottom:20px;">
                    <i class="fas fa-clock"></i> Guru Menunggu Persetujuan
                </h3>';
                
                if(mysqli_num_rows($guru_pending) == 0) {
                    echo '<div class="alert alert-info text-center" style="margin:20px;">
                        <i class="fas fa-info-circle"></i> '.($search ? 'Tidak ditemukan guru yang sesuai dengan pencarian "' . htmlspecialchars($search) . '"' : 'Tidak ada guru yang menunggu persetujuan.').'
                    </div>';
                } else {
                    echo '<div class="table-responsive">
                        <table class="table table-striped table-hover" style="border:1px solid #ddd;">
                            <thead style="background:linear-gradient(135deg, #667eea 0%, #764ba2 100%); color:white;">
                                <tr>
                                    <th style="padding:12px; text-align:center;">No</th>
                                    <th style="padding:12px;">Nama Guru</th>
                                    <th style="padding:12px;">Pendidikan</th>
                                    <th style="padding:12px;">Mata Pelajaran</th>
                                    <th style="padding:12px;">Email</th>
                                    <th style="padding:12px;">Tanggal Daftar</th>
                                    <th style="padding:12px; text-align:center;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>';
                            $no = $offset + 1;
                            while($row = mysqli_fetch_array($guru_pending)) {
                                echo '<tr style="transition: all 0.3s;">
                                    <td style="text-align:center; vertical-align:middle;">'.$no++.'</td>
                                    <td style="vertical-align:middle;"><strong>'.$row['nama_guru'].'</strong></td>
                                    <td style="vertical-align:middle;">'.$row['pendidikan_terakhir'].'</td>
                                    <td style="vertical-align:middle;">
                                        <span class="label label-primary" style="background:#3498db;">'.$row['mapel'].'</span>
                                    </td>
                                    <td style="vertical-align:middle;">
                                        <i class="fas fa-envelope" style="color:#9b59b6;"></i> '.$row['email_guru'].'
                                    </td>
                                    <td style="vertical-align:middle;">
                                        <i class="fas fa-calendar-alt" style="color:#e74c3c;"></i> '.date('d/m/Y H:i', strtotime($row['tanggal_daftar'])).'
                                    </td>
                                    <td style="text-align:center; vertical-align:middle;">
                                        <div class="btn-group">
                                            <a href="dash.php?q=6&action=accept&id='.$row['id_guru'].'&page='.$page.($search ? '&search='.urlencode($search) : '').'" 
                                               class="btn btn-success btn-sm" 
                                               style="border-radius:20px; padding:6px 15px;"
                                               title="Terima Guru"
                                               onclick="return confirm(\'Apakah Anda yakin ingin menerima guru '.$row['nama_guru'].'?\')">
                                                <i class="fas fa-check"></i> Terima
                                            </a>
                                            <a href="dash.php?q=6&action=reject&id='.$row['id_guru'].'&page='.$page.($search ? '&search='.urlencode($search) : '').'" 
                                               class="btn btn-danger btn-sm" 
                                               style="border-radius:20px; padding:6px 15px; margin-left:5px;"
                                               title="Tolak Guru"
                                               onclick="return confirm(\'Apakah Anda yakin ingin menolak guru '.$row['nama_guru'].'?\')">
                                                <i class="fas fa-times"></i> Tolak
                                            </a>
                                        </div>
                                    </td>
                                </tr>';
                            }
                            echo '</tbody>
                        </table>
                    </div>';
                    
                    // Pagination untuk pending
                    if($total_pages_pending > 1) {
                        echo '<div class="text-center" style="margin-top:20px;">
                            <ul class="pagination">';
                            
                            // Tombol Previous
                            if($page > 1) {
                                echo '<li><a href="dash.php?q=6&page='.($page-1).($search ? '&search='.urlencode($search) : '').'">&laquo; Previous</a></li>';
                            }
                            
                            // Numbered pages
                            $start_page = max(1, $page - 2);
                            $end_page = min($total_pages_pending, $page + 2);
                            
                            for($i = $start_page; $i <= $end_page; $i++) {
                                echo '<li '.($i == $page ? 'class="active"' : '').'>
                                    <a href="dash.php?q=6&page='.$i.($search ? '&search='.urlencode($search) : '').'">'.$i.'</a>
                                </li>';
                            }
                            
                            // Tombol Next
                            if($page < $total_pages_pending) {
                                echo '<li><a href="dash.php?q=6&page='.($page+1).($search ? '&search='.urlencode($search) : '').'">Next &raquo;</a></li>';
                            }
                            
                            echo '</ul>
                            <p class="text-muted">Halaman '.$page.' dari '.$total_pages_pending.'</p>
                        </div>';
                    }
                }
                echo '
            </div>
            
            <!-- Tab Accepted -->
            <div id="accepted" class="tab-pane fade">
                <h3 style="color:#27ae60; margin-bottom:20px;">
                    <i class="fas fa-check-circle"></i> Guru yang Diterima
                </h3>';
                
                if(mysqli_num_rows($guru_accepted) == 0) {
                    echo '<div class="alert alert-info text-center" style="margin:20px;">
                        <i class="fas fa-info-circle"></i> '.($search ? 'Tidak ditemukan guru yang sesuai dengan pencarian "' . htmlspecialchars($search) . '"' : 'Tidak ada guru yang diterima.').'
                    </div>';
                } else {
                    echo '<div class="table-responsive">
                        <table class="table table-striped table-hover" style="border:1px solid #ddd;">
                            <thead style="background:linear-gradient(135deg, #27ae60 0%, #2ecc71 100%); color:white;">
                                <tr>
                                    <th style="padding:12px; text-align:center;">No</th>
                                    <th style="padding:12px;">Nama Guru</th>
                                    <th style="padding:12px;">Pendidikan</th>
                                    <th style="padding:12px;">Mata Pelajaran</th>
                                    <th style="padding:12px;">Email</th>
                                    <th style="padding:12px;">Tanggal Daftar</th>
                                </tr>
                            </thead>
                            <tbody>';
                            $no = $offset + 1;
                            while($row = mysqli_fetch_array($guru_accepted)) {
                                echo '<tr style="transition: all 0.3s;">
                                    <td style="text-align:center; vertical-align:middle;">'.$no++.'</td>
                                    <td style="vertical-align:middle;">
                                        <strong>'.$row['nama_guru'].'</strong>
                                        <span class="label label-success" style="background:#27ae60; margin-left:5px;">
                                            <i class="fas fa-check"></i> Diterima
                                        </span>
                                    </td>
                                    <td style="vertical-align:middle;">'.$row['pendidikan_terakhir'].'</td>
                                    <td style="vertical-align:middle;">
                                        <span class="label label-primary" style="background:#3498db;">'.$row['mapel'].'</span>
                                    </td>
                                    <td style="vertical-align:middle;">
                                        <i class="fas fa-envelope" style="color:#9b59b6;"></i> '.$row['email_guru'].'
                                    </td>
                                    <td style="vertical-align:middle;">
                                        <i class="fas fa-calendar-alt" style="color:#e74c3c;"></i> '.date('d/m/Y H:i', strtotime($row['tanggal_daftar'])).'
                                    </td>
                                </tr>';
                            }
                            echo '</tbody>
                        </table>
                    </div>';
                    
                    // Pagination untuk accepted
                    if($total_pages_accepted > 1) {
                        echo '<div class="text-center" style="margin-top:20px;">
                            <ul class="pagination">';
                            
                            if($page > 1) {
                                echo '<li><a href="dash.php?q=6&page='.($page-1).($search ? '&search='.urlencode($search) : '').'#accepted">&laquo; Previous</a></li>';
                            }
                            
                            $start_page = max(1, $page - 2);
                            $end_page = min($total_pages_accepted, $page + 2);
                            
                            for($i = $start_page; $i <= $end_page; $i++) {
                                echo '<li '.($i == $page ? 'class="active"' : '').'>
                                    <a href="dash.php?q=6&page='.$i.($search ? '&search='.urlencode($search) : '').'#accepted">'.$i.'</a>
                                </li>';
                            }
                            
                            if($page < $total_pages_accepted) {
                                echo '<li><a href="dash.php?q=6&page='.($page+1).($search ? '&search='.urlencode($search) : '').'#accepted">Next &raquo;</a></li>';
                            }
                            
                            echo '</ul>
                            <p class="text-muted">Halaman '.$page.' dari '.$total_pages_accepted.'</p>
                        </div>';
                    }
                }
                echo '
            </div>
            
            <!-- Tab Rejected -->
            <div id="rejected" class="tab-pane fade">
                <h3 style="color:#e74c3c; margin-bottom:20px;">
                    <i class="fas fa-times-circle"></i> Guru yang Ditolak
                </h3>';
                
                if(mysqli_num_rows($guru_rejected) == 0) {
                    echo '<div class="alert alert-info text-center" style="margin:20px;">
                        <i class="fas fa-info-circle"></i> '.($search ? 'Tidak ditemukan guru yang sesuai dengan pencarian "' . htmlspecialchars($search) . '"' : 'Tidak ada guru yang ditolak.').'
                    </div>';
                } else {
                    echo '<div class="table-responsive">
                        <table class="table table-striped table-hover" style="border:1px solid #ddd;">
                            <thead style="background:linear-gradient(135deg, #e74c3c 0%, #c0392b 100%); color:white;">
                                <tr>
                                    <th style="padding:12px; text-align:center;">No</th>
                                    <th style="padding:12px;">Nama Guru</th>
                                    <th style="padding:12px;">Pendidikan</th>
                                    <th style="padding:12px;">Mata Pelajaran</th>
                                    <th style="padding:12px;">Email</th>
                                    <th style="padding:12px;">Tanggal Daftar</th>
                                </tr>
                            </thead>
                            <tbody>';
                            $no = $offset + 1;
                            while($row = mysqli_fetch_array($guru_rejected)) {
                                echo '<tr style="transition: all 0.3s;">
                                    <td style="text-align:center; vertical-align:middle;">'.$no++.'</td>
                                    <td style="vertical-align:middle;">
                                        <strong>'.$row['nama_guru'].'</strong>
                                        <span class="label label-danger" style="background:#e74c3c; margin-left:5px;">
                                            <i class="fas fa-times"></i> Ditolak
                                        </span>
                                    </td>
                                    <td style="vertical-align:middle;">'.$row['pendidikan_terakhir'].'</td>
                                    <td style="vertical-align:middle;">
                                        <span class="label label-primary" style="background:#3498db;">'.$row['mapel'].'</span>
                                    </td>
                                    <td style="vertical-align:middle;">
                                        <i class="fas fa-envelope" style="color:#9b59b6;"></i> '.$row['email_guru'].'
                                    </td>
                                    <td style="vertical-align:middle;">
                                        <i class="fas fa-calendar-alt" style="color:#e74c3c;"></i> '.date('d/m/Y H:i', strtotime($row['tanggal_daftar'])).'
                                    </td>
                                </tr>';
                            }
                            echo '</tbody>
                        </table>
                    </div>';
                    
                    // Pagination untuk rejected
                    if($total_pages_rejected > 1) {
                        echo '<div class="text-center" style="margin-top:20px;">
                            <ul class="pagination">';
                            
                            if($page > 1) {
                                echo '<li><a href="dash.php?q=6&page='.($page-1).($search ? '&search='.urlencode($search) : '').'#rejected">&laquo; Previous</a></li>';
                            }
                            
                            $start_page = max(1, $page - 2);
                            $end_page = min($total_pages_rejected, $page + 2);
                            
                            for($i = $start_page; $i <= $end_page; $i++) {
                                echo '<li '.($i == $page ? 'class="active"' : '').'>
                                    <a href="dash.php?q=6&page='.$i.($search ? '&search='.urlencode($search) : '').'#rejected">'.$i.'</a>
                                </li>';
                            }
                            
                            if($page < $total_pages_rejected) {
                                echo '<li><a href="dash.php?q=6&page='.($page+1).($search ? '&search='.urlencode($search) : '').'#rejected">Next &raquo;</a></li>';
                            }
                            
                            echo '</ul>
                            <p class="text-muted">Halaman '.$page.' dari '.$total_pages_rejected.'</p>
                        </div>';
                    }
                }
                echo '
            </div>
        </div>
    </div>';
}
?>

</div>

<!--container closed-->
</div></div>
?>

</body>
</html>