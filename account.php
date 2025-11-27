<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>ICLICK</title>
<link  rel="stylesheet" href="css/bootstrap.min.css"/>
 <link  rel="stylesheet" href="css/bootstrap-theme.min.css"/>    
 <link rel="stylesheet" href="css/main.css">
 <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
 <link  rel="stylesheet" href="css/font1.css">
 <script src="js/jquery.js" type="text/javascript"></script>
 <link rel="stylesheet" href="css/timer.css">
 
 <script src="js/bootstrap.min.js"  type="text/javascript"></script>

 <!--alert message-->
<?php if(@$_GET['w'])
{echo'<script>alert("'.@$_GET['w'].'");</script>';}
?>
<!--alert message end-->

</head>
<?php
include_once 'dbConnection.php';
session_start();

// === PERBAIKAN KRITIS: CEK ROLE SISWA ===
if (!isset($_SESSION['siswa_email']) || $_SESSION['role'] != 'siswa') {
    // Jika bukan siswa, redirect ke login
    session_destroy();
    header("location:index.php?error=Silakan login sebagai siswa");
    exit();
}

// === PERBAIKAN: GUNAKAN SESSION SISWA YANG BARU ===
$email = $_SESSION['siswa_email'];
$name = $_SESSION['siswa_name'];
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
    top: 10px;
    left: 800px;
    width: 100%;
    height: 100%;
    background: url("./image/ellipse 3.png") no-repeat;
    background-size: contain;
    z-index: -1;
    opacity: 0.9;
}
</style>

<div class="header" style="display:flex; align-items:center; justify-content:space-between; background-color:#fff; padding:10px 20px;background: url('./image/ellipse 1.png') no-repeat; background-size: cover; opacity: 0.1;">
  <div style="display:flex; align-items:center;">
    <img src="image/logo.png" alt="Logo" style="width:85px; height:auto; margin-left:20px; margin-bottom:10px;">
  </div>

  <div style="color:#000; font-size:16px; display:flex; align-items:center;">
    <?php
    echo '
    <span style="display:flex; align-items:center; gap:6px; color:black !important; margin-right:20px; ">
      <span class="bi bi-person-fill" aria-hidden="true"></span>
      ,&nbsp;<a href="account.php?q=6" style="color:black !important; text-decoration:none; font-size:18px;">'.$name.'</a>
      &nbsp;&nbsp;
    </span>';
    ?>
  </div>
</div>

<div class="bg">

<!-- SIDEBAR NAVIGATION -->
<nav style="font-size:16px; position: fixed; top: 0; left: 0; height: 100%; width: 220px; background-color: #101010; padding-top: 20px; color: white; overflow-y: auto; z-index: 1000;">
  
  <div style="text-align:center; margin-bottom:20px;">
    <img src="image/logoheader.png" alt="Logo" style="width:100px; height:100px; margin-top:-30px">
  </div>

  <ul style="list-style:none; padding:0; margin:0; margin-top: -30px;">
  <li <?php if(@$_GET['q']==6) echo 'style="background:#7C3AED; border-radius:4px;"'; ?>>
  <a href="account.php?q=6" style="display:flex; align-items:center; gap:4px; padding:14px 50px; color:#fff; text-decoration:none; cursor:pointer;">
    <span class="bi bi-person-fill"></span>
    Halo, <b><?php echo $name; ?></b>
  </a>
</li>

    <li <?php if(!isset($_GET['q'])) echo 'style="background:#444;border-radius:4px;"'; ?>>
      <a href="account.php" style="display:block; padding:12px 20px; color:white; text-decoration:none;">
        <span class="bi bi-house-door-fill"></span>&nbsp; Beranda
      </a>
    </li>
    <li <?php if(@$_GET['q']==1) echo 'style="background:#444; border-radius:4px;"'; ?>>
      <a href="account.php?q=1" style="display:block; padding:12px 20px; color:white; text-decoration:none;">
        <span class="bi bi-mortarboard-fill"></span>&nbsp; Kuis
      </a>
    </li>
    <li <?php if(@$_GET['q']==2) echo 'style="background:#444; border-radius:4px;"'; ?>>
      <a href="account.php?q=2" style="display:block; padding:12px 20px; color:white; text-decoration:none;">
        <span class="bi bi-clipboard-data-fill"></span>&nbsp; Riwayat Pengerjaan
      </a>
    </li>
    <li <?php if(@$_GET['q']==3) echo 'style="background:#444; border-radius:4px;"'; ?>>
      <a href="account.php?q=3" style="display:block; padding:12px 20px; color:white; text-decoration:none;">
        <span class="bi bi-award-fill"></span>&nbsp; Peringkat
      </a>
    </li>
    <li <?php if(@$_GET['q']==5) echo 'style="background:#444; border-radius:4px;"'; ?>>
      <a href="feedback.php" target="_blank" style="display:block; padding:12px 20px; color:white; text-decoration:none;">
        <span class="bi bi-chat-left-fill"></span>&nbsp; Masukan & Saran
      </a>
    </li>
    <li style="border-top:1px solid #444; margin-top:10px;">
      <a href="logout.php?q=account.php" style="display:block; padding:12px 20px; color:#7C3AED; text-decoration:none;">
        <span class="bi bi-box-arrow-right"></span>&nbsp; Keluar
      </a>
    </li>
  </ul>
</nav>

<!-- KONTEN UTAMA -->
<div style="margin-left:240px; padding:20px;">
  <div class="container">
    <div class="row">
      <div class="col-md-11">

<!-- PROFILE SISWA -->
<?php 
if(@$_GET['q']==6) {
    $email = $_SESSION['siswa_email'];
    
    $getUser = mysqli_query($con, "SELECT * FROM user WHERE email='$email'") or die(mysqli_error($con));
    if($userData = mysqli_fetch_assoc($getUser)) {
        $nama    = $userData['name'];
        $gender  = $userData['gender'];
        $college = $userData['college'];
        $mob     = $userData['mob'];
        $emailDB = $userData['email'];

        echo '
        <div style="margin-left:5px; margin-top:-20px; color:#fff; max-width:100%; margin-right:90px;">
            <h1 style="color:#000; font-weight:700; font-size:36px; margin-top:-40px;">Profil Siswa</h1>
            <p style="font-size:18px; color:#667085; margin-top:10px;">
                Selamat Datang, <b style="color:#667085;">'.$nama.'</b> 👋
                Berikut adalah informasi tentang akun Anda.
            </p>

            <div style="background:#151518; margin-top:15px; padding: 25px 15px; border-radius:8px; border:1px solid #27272A;">
              <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px;">
                  <div style="background:#151518; border-radius:8px; border:1px solid #27272A; padding:10px 12px;">
                      <h3 style="color:#71717A; margin:5px 0 4px 0; font-size:16px; font-weight:400;">Nama Lengkap</h3>
                      <p style="font-size:24px; color:#fff; margin:0; font-weight:600;">'.$nama.'</p>
                  </div>

                  <div style="background:#151518; border-radius:8px; border:1px solid #27272A; padding:10px 12px;">
                      <h3 style="color:#71717A; margin:5px 0 4px 0; font-size:16px;">Email</h3>
                      <p style="font-size:24px; color:#fff; margin:0; font-weight:600;">'.$emailDB.'</p>
                  </div>

                  <div style="background:#151518; border-radius:8px; border:1px solid #27272A; padding:10px 12px;">
                      <h3 style="color:#71717A; margin:5px 0 4px 0; font-size:16px;">Jenis Kelamin</h3>
                      <p style="font-size:24px; color:#fff; margin:0; font-weight:600;">'.$gender.'</p>
                  </div>

                  <div style="background:#151518; border-radius:8px; border:1px solid #27272A; padding:10px 12px;">
                      <h3 style="color:#71717A; margin:5px 0 4px 0; font-size:16px;">Lembaga/Sekolah</h3>
                      <p style="font-size:24px; color:#fff; margin:0; font-weight:600;">'.$college.'</p>
                  </div>

                  <div style="background:#151518; border-radius:8px; border:1px solid #27272A; padding:10px 12px;">
                      <h3 style="color:#71717A; margin:5px 0 4px 0; font-size:16px;">Nomor Telp.</h3>
                      <p style="font-size:24px; color:#fff; margin:0; font-weight:600;">'.$mob.'</p>
                  </div>
              </div>
            </div>
        </div>';
    } else {
        echo '<p style="color:red;">Data siswa tidak ditemukan.</p>';
    }
}
?>

<!-- Dashboard start -->
<?php
if(!@$_GET['q']) {
    $totalQuiz = mysqli_num_rows(mysqli_query($con,"SELECT * FROM quiz"));
    $historyCount = mysqli_num_rows(mysqli_query($con,"SELECT * FROM history WHERE email='$email'"));
    $rankData = mysqli_query($con,"SELECT score FROM `rank` WHERE email='$email'");
    $rankRow = mysqli_fetch_array($rankData);
    $overallScore = $rankRow ? $rankRow['score'] : 0;

    echo '
    <div style="margin-left:5px; margin-right:40px; margin-top:-20px; color:white; max-width;">
    <h1 style="color:#000; font-weight:700; font-size:36px; margin-top:-40px;">Beranda</h1>
            <p style="font-size:18px; color:#667085; margin-top:10px;">
                Selamat Datang, <b style="color:#667085;">'.$name.'</b> 👋
                Berikut adalah ringkasan aktivitas Anda.
            </p>

            <div style="display:flex; gap:25px; flex-wrap:wrap;">
               <div style="display:flex; gap:20px; flex-wrap:wrap; margin-top:10px;">

    <div style="flex:1; min-width:200px; background:#151518; padding:20px; border:1px solid #27272A; border-radius:8px;">
        <h3 style="margin-top:5px; font-size:16px; font-weight:300; color:#71717A;">Total Kuis</h3>
        <p style="margin-top:5px; font-size:24px; font-weight:700; margin-top:8px; color:#fff;">'.$totalQuiz.'</p>
    </div>

    <div style="flex:1; min-width:200px; background:#151518; padding:20px; border:1px solid #27272A; border-radius:8px;">
        <h3 style="margin-top:5px; font-size:16px; font-weight:300; color:#71717A;">Kuis Terselesaikan</h3>
        <p style="font-size:24px; font-weight:700; margin-top:8px; color:#fff;">'.$historyCount.'</p>
    </div>

    <div style="flex:1; min-width:200px; background:#151518; padding:20px; border:1px solid #27272A; border-radius:8px;">
        <h3 style="margin-top:5px; font-size:16px; font-weight:300; color:#71717A;">Skor Keseluruhan</h3>
        <p style="font-size:24px; font-weight:700; margin-top:8px; color:#fff;">'.$overallScore.'</p>
    </div>
</div>

<div style="background:#111; color:white; padding:20px; border-radius:14px; margin-top:-4px; margin-right:50px; border:1px solid #222; width:100%;">
    <div style="background:#181818; padding:15px 20px; border-radius:10px; border:1px solid #333; display:flex; justify-content:space-between; align-items:center; margin-bottom:5px;">
        <div style="display:flex; align-items:flex-start; gap:12px;">
            <span class="bi bi-mortarboard-fill" style="font-size:22px; color:#7C3AED; margin-top:3px;"></span>
            <div>
                <p style="margin:0; font-size:24px; font-weight:700;">Kuis</p>
                <p style="font-size:16px; opacity:0.7; margin-top:10px; font-weight:400; color:#CCCCCC;">
                    Kumpulan kuis yang dapat kamu kerjakan untuk menguji pemahamanmu
                </p>
            </div>
        </div>
        <a href="account.php?q=1" style="background:#7C3AED; color:white; text-decoration:none; border-radius:8px; font-size:16px; padding:10px 22px; display:inline-block; min-width:120px; text-align:center; line-height:1.2;">Kuis</a>
    </div>

    <div style="margin-top:10px;">
        <div style="background:#181818; padding:15px 20px; border-radius:10px; border:1px solid #333; display:flex; justify-content:space-between; align-items:center; margin-bottom:5px;">
            <div style="display:flex; align-items:flex-start; gap:12px;">
                <span class="bi bi-clipboard-data-fill" style="font-size:22px; color:#7C3AED; margin-top:3px;"></span>
                <div>
                    <p style="margin:0; font-weight:700; font-size:24px;">Riwayat Pengerjaan</p>
                    <p style="font-size:16px; opacity:0.7; margin-top:10px; font-weight:400; color:#CCCCCC;">
                        Tampilkan riwayat pengerjaan lengkap
                    </p>
                </div>
            </div>
            <a href="account.php?q=2" style="background:#7C3AED; color:white; text-decoration:none; border-radius:8px; font-size:16px; padding:10px 22px; display:inline-block; min-width:120px; text-align:center; line-height:1.2;">Riwayat</a>
        </div>

        <div style="margin-top:10px;">
            <div style="background:#181818; padding:15px 20px; border-radius:10px; border:1px solid #333; display:flex; justify-content:space-between; align-items:center; margin-bottom:5px;">
                <div style="display:flex; align-items:flex-start; gap:12px;">
                    <span class="bi bi-award-fill" style="font-size:22px; color:#7C3AED; margin-top:3px;"></span>
                    <div>
                        <p style="margin:0; font-size:24px; font-weight:700;">Peringkat</p>
                        <p style="font-size:16px; opacity:0.7; margin-top:10px; font-weight:400; color:#CCCCCC;">
                            Lihat urutan peringkat berdasarkan skor
                        </p>
                    </div>
                </div>
                <a href="account.php?q=3" style="background:#7C3AED; color:white; text-decoration:none; border-radius:8px; font-size:16px; padding:10px 22px; display:inline-block; min-width:120px; text-align:center; line-height:1.2;">Peringkat</a>
            </div>
        </div>
    </div>';
}
?>
<!-- Dashboard end -->

<!-- Kuis start-->
<?php 
if(@$_GET['q']==1) {
    $result = mysqli_query($con,"SELECT * FROM quiz ORDER BY date DESC") or die('Error');
    echo '<div style="margin-left:5px; margin-right:40px; margin-top:-20px; color:white; max-width;">
    <h1 style="color:#000; font-weight:700; font-size:36px; margin-top:-40px;">Kuis</h1>
            <p style="font-size:18px; color:#667085; margin-top:10px;">
                Kerjakan Kuis Anda, '.$name.'!
            </p>
          </div>

<div style="background:#151518; max-width:100%; margin-right:90px; border-radius:10px; padding:30px; color:white;">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:15px; gap:10px; flex-wrap:wrap;">
        <div style="color:#fff; font-size:24px; font-weight:700;">Daftar Kuis
        <p style="color:#A1A1AA; font-size:16px; font-weight:300; margin-top:5px;"> Pilih kuis yang ingin kamu kerjakan dan uji pemahamanmu pada materi yang tersedia</p>
        </div>

        <input id="searchQuiz" placeholder="Cari kuis" style="background:#19191B; border:1px solid #27272A; padding:6px 12px; border-radius:6px; color:white; font-size:16px; width:180px; flex:1; max-width:200px;">
    </div>

    <div style="max-height:350px; overflow-y:auto; overflow-x:auto; border:1px solid #27272A; border-radius:8px; width:100%;">
        <table style="width:100%; border-collapse:collapse; font-size:16px; color:white; min-width:600px;">
            <thead style="position:sticky; top:0; background:#1c1c1e; z-index:10;">
                <tr>
                    <th style="padding:12px; text-align:left; font-weight:700;">No</th>
                    <th style="padding:12px; text-align:left; font-weight:700;">Materi</th>
                    <th style="padding:12px; text-align:left; font-weight:700;">Total Soal</th>
                    <th style="padding:12px; text-align:left; font-weight:700;">Nilai</th>
                    <th style="padding:12px; text-align:left; font-weight:700;">Batas Waktu</th>
                    <th style="padding:12px; text-align:center; font-weight:700;">Aksi</th>
                </tr>
            </thead>

            <tbody id="quizTableBody">';

    $c = 1;
    while($row = mysqli_fetch_array($result)) {
        $title = $row['title'];
        $total = $row['total'];
        $sahi = $row['sahi'];
        $time = $row['time'];
        $eid = $row['eid'];

        $q12 = mysqli_query($con,"SELECT score FROM history WHERE eid='$eid' AND email='$email' ORDER BY date DESC LIMIT 1");
        $rowcount = mysqli_num_rows($q12);
        $latest_score = 0;
        if($rowcount > 0) {
            $history_data = mysqli_fetch_array($q12);
            $latest_score = $history_data['score'];
        }	

        echo '<tr style="border-bottom:1px solid #27272A;">
                <td style="padding:12px; font-weight:400;">'.$c++.'</td>
                <td style="padding:12px; font-weight:400;"><strong>'.$title.'</strong></td>
                <td style="padding:12px; font-weight:400;">'.$total.'</td>
                <td style="padding:12px; font-weight:400;">'.$sahi*$total.'</td>
                <td style="padding:12px; font-weight:400;">'.$time.' min</td>';

        if($rowcount == 0){
            echo '
                <td style="padding:12px; text-align:center;">
                    <a href="account.php?q=quiz&step=2&eid='.$eid.'&n=1&t='.$total.'" style="background:#7C3AED; color:#fff; padding:6px 20px; font-size:16px; border-radius:6px; display:inline-block; text-decoration:none;">
                        Mulai
                    </a>
                </td>';
        } else {
            echo '
                <td style="padding:12px; text-align:center;">
                    <a href="update.php?q=quizre&step=25&eid='.$eid.'&n=1&t='.$total.'" style="background:#dc3545; color:#fff; padding:6px 12px; font-size:16px; border-radius:6px; display:inline-block; text-decoration:none;">
                        Restart
                    </a>
                </td>';
        }

        echo '</tr>';
    }

    echo '</tbody>
        </table>
    </div>
</div>

<script>
    document.getElementById("searchQuiz").addEventListener("keyup", function () {
        let filter = this.value.toLowerCase();
        let rows = document.querySelectorAll("#quizTableBody tr");

        rows.forEach(row => {
            let text = row.innerText.toLowerCase();
            row.style.display = text.includes(filter) ? "" : "none";
        });
    });
</script>';
}
?>

<!-- Quiz Questions -->
<?php
if(@$_GET['q']== 'quiz' && @$_GET['step']== 2) {

    $eid   = @$_GET['eid'];
    $sn    = @$_GET['n'];
    $total = @$_GET['t'];
    
    $quiz_data = mysqli_query($con,"SELECT * FROM quiz WHERE eid='$eid'");
    $quiz = mysqli_fetch_array($quiz_data);
    $time_limit = $quiz['time'];
    $quiz_title = $quiz['title']; 
    
    $q = mysqli_query($con,"SELECT * FROM questions WHERE eid='$eid' LIMIT 1 OFFSET ".($sn-1));

    echo '
    <div style="max-width; margin-right:90px; background:#151518; padding:40px; color:#fff; border-radius:8px;">
        <div style="margin-bottom:10px;">
            <a href="account.php?q=1" style="color:#fff; font-size:24px; text-decoration:none;">←</a>
            <span style="margin-left:5px; margin-top:-5px; font-size:16px; font-weight:700;">'.$quiz_title.'</span>
        </div>
        <div style="width:100%; padding:25px 30px; border-radius:8px; margin-bottom:5px; display:flex; flex-direction:column; gap:10px;">
            <div style="display:flex; justify-content:space-between; align-items:center;">
                <span style="background:#a259ff; color:#fff; padding:6px 14px; border-radius:50px; font-size:16px; font-weight:400;">
                    '.$sn.' / '.$total.' Soal
                </span>
                <div style="display:flex; align-items:center; gap:8px;">
                    <span style="color:red; font-size:18px;">⏱</span>
                    <span id="timer" style="font-weight:400; font-size:16px; color:#EF4444;">
                        '.$time_limit.':00
                    </span>
                </div>
            </div>';

    if($row = mysqli_fetch_array($q)) {
        $qns     = $row['qns'];
        $qid     = $row['qid'];
        $optionA = $row['optionA'];
        $optionB = $row['optionB'];
        $optionC = $row['optionC'];
        $optionD = $row['optionD'];
        
        echo '<b style="background:rgba(255,255,255,0.4); padding:30px 20px; border-radius:10px; font-size:16px; font-weight:400; margin-bottom:-60px; margin-top:5px;">'.$qns.'</b><br /><br />';
        echo '
        <form action="update.php?q=quiz&step=2&eid='.$eid.'&n='.$sn.'&t='.$total.'&qid='.$qid.'" method="POST" class="form-horizontal" id="quizForm">
        <br />

        <div style="display:flex; gap:10px; margin-bottom:5px;">
            <label style="flex:1; background:rgba(255,255,255,0.4); padding:18px; border-radius:10px; cursor:pointer; display:flex; align-items:center; gap:12px; font-size:16px; font-weight:400; box-shadow:0 0 8px rgba(0,0,0,0.3);">
                <input type="radio" name="ans" value="a" required style="transform:scale(1.4);">
                A. '.$optionA.'
            </label>

            <label style="flex:1; background:rgba(255,255,255,0.4); padding:18px; border-radius:10px; cursor:pointer; display:flex; align-items:center; gap:12px; font-size:16px; font-weight:400; box-shadow:0 0 8px rgba(0,0,0,0.3);">
                <input type="radio" name="ans" value="b" required style="transform:scale(1.4);">
                B. '.$optionB.'
            </label>
        </div>

        <div style="display:flex; gap:10px; margin-bottom:10px;">
            <label style="flex:1; background:rgba(255,255,255,0.4); padding:18px; border-radius:10px; cursor:pointer; display:flex; align-items:center; gap:12px; font-size:16px; font-weight:400; box-shadow:0 0 8px rgba(0,0,0,0.3);">
                <input type="radio" name="ans" value="c" required style="transform:scale(1.4);">
                C. '.$optionC.'
            </label>

            <label style="flex:1; background:rgba(255,255,255,0.4); padding:18px; border-radius:10px; cursor:pointer; display:flex; align-items:center; gap:12px; font-size:16px; font-weight:400; box-shadow:0 0 8px rgba(0,0,0,0.3);">
                <input type="radio" name="ans" value="d" required style="transform:scale(1.4);">
                D. '.$optionD.'
            </label>
        </div>

        <div style="display:flex; justify-content:right; align-items:center;">
            <button type="submit" style="padding:10px 20px; background:#9823F5; border:none; border-radius:10px; font-size:16px; color:#fff; cursor:pointer;">
                Selanjutnya >
            </button>
        </div>
        </form>';
    
    } else {
        echo '<div class="alert alert-danger">Soal tidak ditemukan!</div>';
    }

    echo '</div></div>';
    
    echo '
    <script>
    function startTimer(duration, display) {
        var timer = duration, minutes, seconds;
        var interval = setInterval(function () {
            minutes = parseInt(timer / 60, 10);
            seconds = parseInt(timer % 60, 10);

            minutes = minutes < 10 ? "0" + minutes : minutes;
            seconds = seconds < 10 ? "0" + seconds : seconds;

            display.textContent = minutes + ":" + seconds;

            if (timer <= 300) {
                display.style.color = "#e74c3c";
                display.style.fontWeight = "400";
            }
            
            if (timer <= 60) {
                display.style.color = "#c0392b";
                display.style.fontSize = "16px";
            }

            if (--timer < 0) {
                clearInterval(interval);
                alert("Waktu telah habis! Jawaban akan dikirim otomatis.");
                document.getElementById("quizForm").submit();
            }
        }, 1000);
    }

    window.onload = function () {
        var timeLimit = '.$time_limit.';
        var display = document.querySelector("#timer");
        var totalSeconds = timeLimit * 60;
        startTimer(totalSeconds, display);
    };

    document.getElementById("quizForm").addEventListener("submit", function(e) {
    });
    </script>';
}
?>

<!-- Result Display -->
<?php
if(@$_GET['q']== 'result' && @$_GET['eid']) {
    $eid = @$_GET['eid'];
    
    $q = mysqli_query($con,"SELECT * FROM history WHERE eid='$eid' AND email='$email'") or die('Error157');
    
    if(mysqli_num_rows($q) == 0) {
        echo '<div class="alert alert-danger">Data hasil kuis tidak ditemukan!</div>';
    } else {
        echo ' 
        <div style="margin-left:5px; margin-right:40px; margin-top:-20px; color:white; max-width;">
            <h1 style="color:#000; font-weight:700; font-size:36px; margin-top:-40px;">Hasil Kuis</h1>
            <p style="font-size:18px; color:#667085; margin-top:10px;">
                Selamat! Anda telah menyelesaikan kuis.
            </p>
        </div>
        
        <div class="panel" style="background:#19191B; border:1px solid #27272A; margin-right:90px; margin-left:5px; margin-top:10px; padding:20px; border-radius:8px;">
            <table class="table" style="font-size:16px;font-weight:400; color:#fff; width:100%;">';

        while($row = mysqli_fetch_array($q)) {
            $s = $row['score'];
            $w = $row['wrong'];
            $r = $row['sahi'];
            $qa = $row['level'];
            
            $quiz_query = mysqli_query($con, "SELECT title FROM quiz WHERE eid='$eid'");
            $quiz_data = mysqli_fetch_array($quiz_query);
            $quiz_title = $quiz_data['title'];
            
            echo '
            <tr><td colspan="2" style="padding:15px; text-align:center; background:#7C3AED; border-radius:5px;">
                <strong>'.$quiz_title.'</strong>
            </td></tr>
            <tr style="border-bottom:1px solid #333;"><td style="padding:12px;">Total Pertanyaan</td><td style="padding:12px;">'.$qa.'</td></tr>
            <tr style="border-bottom:1px solid #333;"><td style="padding:12px;">Jawaban Benar <span class="bi bi-check-circle" style="color:#28a745;"></span></td><td style="padding:12px;">'.$r.'</td></tr> 
            <tr style="border-bottom:1px solid #333;"><td style="padding:12px;">Jawaban Salah <span class="bi bi-x-circle" style="color:#dc3545;"></span></td><td style="padding:12px;">'.$w.'</td></tr>
            <tr style="border-bottom:1px solid #333;"><td style="padding:12px;">Nilai <span class="bi bi-star" style="color:#ffc107;"></span></td><td style="padding:12px;"><strong>'.$s.'</strong></td></tr>';
        }
        
        $rank_query = mysqli_query($con,"SELECT * FROM `rank` WHERE email='$email'");
        if($rank_row = mysqli_fetch_array($rank_query)) {
            $overall_score = $rank_row['score'];
            echo '<tr><td style="padding:12px;">Nilai Keseluruhan <span class="bi bi-bar-chart" style="color:#17a2b8;"></span></td><td style="padding:12px;"><strong>'.$overall_score.'</strong></td></tr>';
        }
        
        echo '</table>
        
        <div style="margin-top:20px; text-align:center;">
            <a href="account.php?q=1" style="background:#7C3AED; color:white; padding:10px 20px; border-radius:6px; text-decoration:none; margin-right:10px;">
                Kuis Lainnya
            </a>
            <a href="account.php?q=2" style="background:#28a745; color:white; padding:10px 20px; border-radius:6px; text-decoration:none;">
                Lihat Riwayat
            </a>
        </div>
        
        </div>';
    }
}
?>

<!-- Riwayat Pengerjaan start -->
<?php
if (@$_GET['q'] == 2) {
    $q = mysqli_query($con, "SELECT h.*, q.title FROM history h JOIN quiz q ON h.eid = q.eid WHERE h.email='$email' ORDER BY h.date DESC") or die('Error197');
?>
    <div style="margin-left:5px; margin-top:-20px; max-width:100%; margin-right:40px;">
        <h1 style="color:#000; font-weight:700; font-size:36px; margin-top:-40px;">Riwayat Pengerjaan</h1>
        <p style="font-size:18px; color:#667085; margin-top:10px;">
            Pantau progres kuis yang sudah kamu selesaikan, <?php echo $name; ?>!
        </p>
    </div>

    <div style="background:#151518; max-width:100%; margin-right:90px; border-radius:10px; padding:30px; color:white;">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:15px; gap:10px; flex-wrap:wrap;">
            <div style="color:#fff; font-size:24px; font-weight:700;">
                Riwayat kuis yang telah Anda kerjakan
                <p style="color:#A1A1AA; font-size:16px; font-weight:300; margin-top:5px;">
                    Lihat progres Anda atau ulangi kuis jika diperlukan
                </p>
            </div>

            <input id="searchHistory" placeholder="Cari kuis" style="background:#19191B; border:1px solid #27272A; padding:6px 12px; border-radius:6px; color:white; font-size:16px; width:180px; flex:1; max-width:200px;">
        </div>

        <div style="max-height:350px; overflow-y:auto; overflow-x:auto; border:1px solid #27272A; border-radius:8px; width:100%;">
            <table style="width:100%; border-collapse:collapse; font-size:16px; min-width:600px; color:white;">
                <thead style="position:sticky; top:0; background:#1c1c1e; z-index:10;">
                    <tr>
                        <th style="padding:12px; text-align:left; font-weight:700;">No</th>
                        <th style="padding:12px; text-align:left; font-weight:700;">Kuis</th>
                        <th style="padding:12px; text-align:left; font-weight:700;">Pertanyaan Terjawab</th>
                        <th style="padding:12px; text-align:left; font-weight:700;">Benar</th>
                        <th style="padding:12px; text-align:left; font-weight:700;">Salah</th>
                        <th style="padding:12px; text-align:center; font-weight:700;">Nilai</th>
                    </tr>
                </thead>

                <tbody id="historyTableBody">
                <?php
                $c = 0;
                while ($row = mysqli_fetch_array($q)) {
                    $eid = $row['eid'];
                    $s = $row['score'];
                    $w = $row['wrong'];
                    $r = $row['sahi'];
                    $qa = $row['level'];

                    $q23 = mysqli_query($con, "SELECT title FROM quiz WHERE eid='$eid'") or die('Error208');
                    $title = mysqli_fetch_array($q23)['title'];

                    $c++;

                    echo '
                    <tr style="border-bottom:1px solid #27272A;">
                        <td style="padding:12px;">'.$c.'</td>
                        <td style="padding:12px;"><strong>'.$title.'</strong></td>
                        <td style="padding:12px;">'.$qa.'</td>
                        <td style="padding:12px;">'.$r.'</td>
                        <td style="padding:12px;">'.$w.'</td>
                        <td style="padding:12px; text-align:center;">'.$s.'</td>
                    </tr>';
                }

                if ($c == 0) {
                    echo '
                    <tr>
                        <td colspan="6" style="text-align:center; padding:20px; color:#888;">
                            <i class="fas fa-chart-line fa-3x mb-3 text-muted"></i><br>
                            Belum ada kuis yang dikerjakan!
                        </td>
                    </tr>';
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        document.getElementById("searchHistory").addEventListener("keyup", function () {
            let filter = this.value.toLowerCase();
            let rows = document.querySelectorAll("#historyTableBody tr");

            rows.forEach(row => {
                let text = row.innerText.toLowerCase();
                row.style.display = text.includes(filter) ? "" : "none";
            });
        });
    </script>

<?php
}
?>

<!-- Ranking start -->
<?php
if (@$_GET['q'] == 3) {
    $q = mysqli_query($con, "SELECT * FROM `rank` ORDER BY score DESC") or die('Error223');
?>
    <div style="margin-left:5px; margin-top:-20px; color:white; max-width:100%; margin-right:40px;">
        <h1 style="color:#000; font-weight:700; font-size:36px; margin-top:-40px;">Peringkat</h1>
        <p style="font-size:18px; color:#667085; margin-top:10px;">
            Lihat seberapa jauh progresmu dibanding peserta lain, <?php echo $name; ?>!
        </p>
    </div>

    <div style="background:#151518; max-width:100%; margin-right:90px; border-radius:10px; padding:30px; color:white;">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:15px; gap:10px; flex-wrap:wrap;">
            <div style="color:#fff; font-size:24px; font-weight:700;">
                Ranking Peserta
                <p style="color:#A1A1AA; font-size:16px; font-weight:300; margin-top:5px;">
                    Cari peringkat peserta berdasarkan nama.
                </p>
            </div>

            <input id="searchRank" placeholder="Cari Nama" style="background:#19191B; border:1px solid #27272A; padding:6px 12px; border-radius:6px; color:white; font-size:16px; width:180px; flex:1; max-width:200px;">
        </div>

        <div style="max-height:350px; overflow-y:auto; overflow-x:auto; border:1px solid #27272A; border-radius:8px; width:100%;">
            <table style="width:100%; border-collapse:collapse; font-size:16px; color:white; min-width:600px;">
                <thead style="position:sticky; top:0; background:#1c1c1e; z-index:10;">
                    <tr>
                        <th style="padding:12px; text-align:left; font-weight:700;">Peringkat</th>
                        <th style="padding:12px; text-align:left; font-weight:700;">Nama</th>
                        <th style="padding:12px; text-align:left; font-weight:700;">Jenis Kelamin</th>
                        <th style="padding:12px; text-align:left; font-weight:700;">Lembaga</th>
                        <th style="padding:12px; text-align:left; font-weight:700;">Nilai</th>
                    </tr>
                </thead>
                <tbody id="rankTableBody">
                <?php
                $c = 0;
                while ($row = mysqli_fetch_array($q)) {
                    $e = $row['email'];
                    $s = $row['score'];

                    $q12 = mysqli_query($con, "SELECT * FROM user WHERE email='$e'") or die('Error231');
                    $user = mysqli_fetch_array($q12);

                    $name = $user['name'];
                    $gender = $user['gender'];
                    $college = $user['college'];

                    $c++;
                    echo '
                    <tr style="border-bottom:1px solid #27272A;">
                        <td style="padding:12px; font-weight:400;">'.$c.'</td>
                        <td style="padding:12px; font-weight:400;"><strong>'.$name.'</strong></td>
                        <td style="padding:12px; font-weight:400;">'.$gender.'</td>
                        <td style="padding:12px; font-weight:400;">'.$college.'</td>
                        <td style="padding:12px; font-weight:400;">'.$s.'</td>
                    </tr>';
                }

                if ($c == 0) {
                    echo '
                    <tr>
                        <td colspan="6" style="text-align:center; padding:20px; color:#888;">
                            <i class="fas fa-chart-line fa-3x mb-3 text-muted"></i><br>
                            Belum ada data peringkat!
                        </td>
                    </tr>';
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        document.getElementById("searchRank").addEventListener("keyup", function () {
            let filter = this.value.toLowerCase();
            let rows = document.querySelectorAll("#rankTableBody tr");

            rows.forEach(row => {
                let text = row.innerText.toLowerCase();
                row.style.display = text.includes(filter) ? "" : "none";
            });
        });
    </script>

<?php
}
?>

</div>
</div>
</div>
</div>

<!-- Modal For Developers-->
<div class="modal fade title1" id="developers">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" style="font-family:'typo' "><span style="color:orange">Developers</span></h4>
      </div>
	  
      <div class="modal-body">
        <p>
		<div class="row">
		<div class="col-md-4">
		 <img src="image/CAM00121.jpg" width=100 height=100 alt="Sunny Prakash Tiwari" class="img-rounded">
		 </div>
		 <div class="col-md-5">
		<a href="http://yugeshverma.blogspot.in" style="color:#202020; font-family:'typo' ; font-size:18px" title="Find on Facebook">Yugesh Verma</a>
		<h4 style="color:#202020; font-family:'typo' ;font-size:16px" class="title1">+91 9165063741</h4>
		<h4 style="font-family:'typo' ">vermayugesh323@gmail.com</h4>
		<h4 style="font-family:'typo' ">Chhattishgarh insitute of management & Technology ,bhilai</h4></div></div>
		</p>
      </div>
    
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!--Modal for admin login-->
	 <div class="modal fade" id="login">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title"><span style="color:orange;font-family:'typo' ">LOGIN</span></h4>
      </div>
      <div class="modal-body title1">
<div class="row">
<div class="col-md-3"></div>
<div class="col-md-6">
<form role="form" method="post" action="admin.php?q=index.php">
<div class="form-group">
<input type="text" name="uname" maxlength="20"  placeholder="Admin user id" class="form-control"/> 
</div>
<div class="form-group">
<input type="password" name="password" maxlength="15" placeholder="Password" class="form-control"/>
</div>
<div class="form-group" align="center">
<input type="submit" name="login" value="Login" class="btn btn-primary" />
</div>
</form>
</div><div class="col-md-3"></div></div>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

</body>
</html>