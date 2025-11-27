<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>IClick | Belajar, Kuis, dan Berkompetisi</title>

  <link rel="stylesheet" href="css/bootstrap.min.css"/>
  <link rel="stylesheet" href="css/bootstrap-theme.min.css"/>    
  <link rel="stylesheet" href="css/homepage.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
  <script src="js/jquery.js" type="text/javascript"></script>
  <script src="js/bootstrap.min.js" type="text/javascript"></script>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-inverse navbar-fixed-top">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbarIClick">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#beranda">
        <img src="./image/logohtm.png" alt="IClick Logo">
      </a>
    </div>
    <div class="collapse navbar-collapse" id="navbarIClick">
      <ul class="nav navbar-nav navbar-center">
        <li><a href="#beranda">Beranda</a></li>
        <li><a href="#kategori">Kategori</a></li>
        <li><a href="#fitur">Fitur</a></li>
        <li><a href="#" data-toggle="modal" data-target="#rankingModal">Ranking</a></li>
        <li><a href="#footer">Hubungi Kami</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="tampilan_login.php?mode=daftar" class="btn btn-daftar navbar-btn">Daftar</a></li>
        <li><a href="tampilan_login.php?mode=masuk" class="btn btn-masuk navbar-btn">Masuk</a></li>
      </ul>
    </div>
  </div>
</nav>

<!-- HERO SECTION -->
<div class="hero" id="beranda">
  <h1><i class="bi bi-stars icon-fitur"></i> Pengalaman Kuis Terbaik</h1> 
  <h2>Belajar, Kuis, <span>dan Berkompetisi</span></h2>
  <p>Bergabunglah dengan siswa dan guru di platform evaluasi belajar<br>
  Uji pengetahuan Anda dan berkompetisi dengan teman sebaya.</p>
  <a href="tampilan_login.php?mode=daftar" class="btn btn-mulai" style="position: relative; z-index: 999; cursor: pointer; font-size:18px;">Mulai</a>
</div>

<!-- KATEGORI KUIS -->
<section class="kategori" id="kategori">
  <div class="container">
    <div class="section-title">
      <h1><i class="bi bi-book icon-fitur"></i> Kategori</h1> 
      <h2>Berdasarkan Mata Pelajaran</h2>
      <p>Temukan kuis di berbagai subjek untuk menguji dan memperluas pengetahuan Anda</p>
    </div>

    <div class="row">
      <?php
      $kategori = [
        "Sejarah" => ["ikon" => "bi bi-clock-history", "warna" => "#3B82F6"],
        "Matematika" => ["ikon" => "bi bi-plus-slash-minus", "warna" => "#22C55E"],
        "Kimia" => ["ikon" => "bi bi-type-h2", "warna" => "#A855F7"],
        "Biologi" => ["ikon" => "bi bi-flower2", "warna" => "#EC4899"],
        "Bahasa Indonesia" => ["ikon" => "bi bi-translate", "warna" => "#3B82F6"],
        "Pemrograman" => ["ikon" => "bi bi-pc-display", "warna" => "#3BF3F6"]
      ];

      foreach ($kategori as $nama => $data) {
        echo '
        <div class="col-sm-4">
          <div class="panel panel-default">
            <div class="panel-body">
             <h4 class="judul-kategori">
        <i class="'.$data["ikon"].' ikon-kategori" style="color:'.$data["warna"].'"></i>
        '.$nama.'
      </h4>
      <p class="deskripsi-kategori">
        Uji pengetahuan Anda dalam pelajaran '.$nama.' dengan kuis menantang kami.
      </p>
            </div>
          </div>
        </div>';
      }
      ?>
    </div>
  </div>
</section>

<!-- FITUR ICLICK -->
<section class="fitur" id="fitur" style="padding:60px 0;">
  <div class="container">
    <div class="section-title-fitur text-center">
      <h1><i class="bi bi-list-stars icon-fitur"></i> Fitur</h1>
      <img src="./image/logopth.png" alt="IClick Logo" class="logo-fitur">
      <p>Temukan kuis di berbagai subjek untuk menguji dan memperluas pengetahuan Anda</p>
    </div>

    <div class="row">
      <?php
      $fitur = [
        ["Pembelajaran yang Dipersonalisasi", "Kuis adaptif yang menyesuaikan dengan tingkat pengetahuan dan kecepatan belajar.", "bi bi-person-video3", "#8b5cf6"],
        ["Ranking", "Menampilkan peringkat siswa berdasarkan hasil nilai tertinggi.", "bi bi-award", "#f87171"],
        ["Dasbor Guru", "Pendidik dapat membuat dan mengelola kuis.", "bi bi-people-fill", "#60a5fa"],
        ["Pelacakan Kemajuan", "Melacak perkembangan kemampuan siswa berdasarkan hasil kuis.", "bi bi-bar-chart-line", "#10b981"],
        ["Histori Nilai", "Menyediakan akses ke seluruh hasil pengerjaan kuis.", "bi bi-person-vcard", "#fbbf24"],
        ["Manajemen Admin", "Admin memiliki kendali penuh dalam mengelola akun guru dan siswa.", "bi bi-person-fill-lock", "#a855f7"]
      ];

      foreach ($fitur as $f) {
    echo '
    <div class="col-sm-4 fitur-col">
      <div class="fitur-card">
        <div class="fitur-icon" style="background-color: '.$f[3].'1A; color: '.$f[3].';">
          <i class="'.$f[2].'"></i>
        </div>
        <h4 class="fitur-judul"><b>'.$f[0].'</b></h4>
        <p class="fitur-deskripsi">'.$f[1].'</p>
      </div>
    </div>';
  }
  ?>
</div>
  </div>
</section>

<!-- ATAS FOOTER -->
<section class="cta">
  <div class="container">
    <div class="row align-items-center">
      <!-- Bagian kiri: teks dan tombol -->
      <div class="col-md-6 text-cta">
        <h2>Siap Memulai Perjalanan Kuis Anda?</h2>
        <p>Bergabunglah dengan ratusan siswa dan guru. Daftar hari ini dan dapatkan akses ke semua fitur.</p>
        <a href="tampilan_login.php?mode=daftar" class="btn btn-akun2 btn-lg">Buat Akun</a>
      </div>

      <!-- Bagian kanan: gambar -->
      <div class="col-md-6 text-center">
        <img src="./image/home3.jpg" alt="Ilustrasi Kuis" class="cta-image">
      </div>
    </div>
  </div>
</section>

<!-- FOOTER dengan id untuk navigasi -->
<footer id="footer" style="
  background-color:#000;
  color:#ccc;
  padding:50px 80px;
  border-top:1px solid #222;
">
  <div style="display:flex; flex-wrap:wrap; justify-content:space-between; gap:50px;">
    <!-- Logo + Deskripsi -->
    <div style="flex:1; min-width:250px; margin-bottom:30px;">
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
    </div>
    <!-- Quick Links -->
    <div style="flex:1; min-width:220px; margin-bottom:30px;">
      <h4 style="color:#fff; font-weight:600;">Link Footer</h4>
      <ul style="list-style:none; padding:0; margin-top:15px;">
        <li><a href="#beranda" style="color:#aaa; text-decoration:none; display:block; margin-bottom:10px;">Beranda</a></li>
        <li><a href="#kategori" style="color:#aaa; text-decoration:none; display:block; margin-bottom:10px;">Kategori</a></li>
        <li><a href="#fitur" style="color:#aaa; text-decoration:none; display:block; margin-bottom:10px;">Fitur</a></li>
        <li><a href="#" data-toggle="modal" data-target="#rankingModal" style="color:#aaa; text-decoration:none; display:block; margin-bottom:10px;">Ranking</a></li>
        <li><a href="#Footer" style="color:#aaa; text-decoration:none; display:block; margin-bottom:10px;">Hubungi Kami</a></li>
      </ul>
    </div>
    <!-- Contact Info -->
    <div style="flex:1; min-width:220px; margin-bottom:30px;">
      <h4 style="color:#fff; font-weight:600;">Hubungi Kami</h4>
      <ul style="list-style:none; padding:0; margin-top:15px; color:#aaa; font-size:14px;">
        <li><i class="glyphicon glyphicon-envelope" style="color:#9b59b6;"></i> iclick.quiz@gmail.com</li>
        <li style="margin-top:8px;"><i class="glyphicon glyphicon-earphone" style="color:#9b59b6;"></i> 081 335 245 678</li>
        <li style="margin-top:8px;"><i class="glyphicon glyphicon-map-marker" style="color:#9b59b6;"></i> Ketintang, Surabaya, Jawa Timur</li>
      </ul>
    </div>
  </div>
  <div style="border-top:1px solid #222; margin-top:30px; padding-top:15px; display:flex; justify-content:space-between; flex-wrap:wrap;">
    <p style="font-size:13px; color:#777;">Copyright © 2025 IClick</p>
    <p style="font-size:13px; color:#777;">
      Hak Cipta Dilindungi UU | 
      <a href="#" style="color:#9b59b6; text-decoration:none;">Syarat dan Ketentuan</a> | 
      <a href="#" style="color:#9b59b6; text-decoration:none;">Kebijakan Privasi</a>
    </p>
  </div>
</footer>

<!-- Modal untuk Ranking -->
<div class="modal fade" id="rankingModal" tabindex="-1" role="dialog" aria-labelledby="rankingModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="rankingModalLabel">Peringkat</h4>
      </div>
      <div class="modal-body">
        <p>Untuk melihat peringkat, silakan masuk terlebih dahulu ke akun Anda.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
        <a href="tampilan_login.php?mode=masuk" class="btn btn-primary">Masuk</a>
      </div>
    </div>
  </div>
</div>

<script>
// Tutup navbar mobile setelah klik link
$(document).ready(function(){
  $('.navbar-nav li a').on('click', function() {
    $('.navbar-collapse').collapse('hide');
  });
});
</script>

</body>
</html>