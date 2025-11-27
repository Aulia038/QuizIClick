<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>ICLICK</title>
<link rel="stylesheet" href="css/bootstrap.min.css"/>
<link rel="stylesheet" href="css/bootstrap-theme.min.css"/>    
<link rel="stylesheet" href="css/main.css">
<link rel="stylesheet" href="css/font1.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

<!-- LOAD JAVASCRIPT -->
<script src="js/jquery.js" type="text/javascript"></script>
<script src="js/bootstrap.min.js" type="text/javascript"></script>
<script src="js/form-validation.js" type="text/javascript"></script>  <!-- FILE BARU -->

<?php if(@$_GET['w']): ?>
<script>alert("<?php echo @$_GET['w']; ?>");</script>
<?php endif; ?>

<script>
function validatePassword(password) {
    // Minimal 8 karakter, kombinasi huruf dan angka
    var regex = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/;
    return regex.test(password);
}

function validateFormSiswa() {
    var y = document.forms["formSiswa"]["name"].value;	
    var letters = /^[A-Za-z\s]+$/;
    if (y == null || y == "") {
        alert("Nama harus diisi.");
        return false;
    }
    var z = document.forms["formSiswa"]["college"].value;
    if (z == null || z == "") {
        alert("Nama lembaga harus diisi.");
        return false;
    }
    var x = document.forms["formSiswa"]["email"].value;
    var atpos = x.indexOf("@");
    var dotpos = x.lastIndexOf(".");
    if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length) {
        alert("Alamat email tidak valid.");
        return false;
    }
    var a = document.forms["formSiswa"]["password"].value;
    if(a == null || a == ""){
        alert("Password harus diisi");
        return false;
    }
    if(!validatePassword(a)){
        alert("Password harus minimal 8 karakter dan kombinasi huruf dan angka.");
        return false;
    }
    var b = document.forms["formSiswa"]["cpassword"].value;
    if (a!=b){
        alert("Password dan konfirmasi password tidak cocok.");
        return false;
    }
    return true;
}

function validateFormGuru() {
    var namaGuru = document.forms["formGuru"]["nama_guru"].value;	
    if (namaGuru == null || namaGuru == "") {
        alert("Nama guru harus diisi.");
        return false;
    }
    
    var pendidikan = document.forms["formGuru"]["pendidikan_terakhir"].value;
    if (pendidikan == null || pendidikan == "") {
        alert("Pendidikan terakhir harus diisi.");
        return false;
    }
    
    var mapel = document.forms["formGuru"]["mapel"].value;
    if (mapel == null || mapel == "") {
        alert("Mata pelajaran harus diisi.");
        return false;
    }
    
    var mob = document.forms["formGuru"]["mob_guru"].value;
    if (mob == null || mob == "") {
        alert("Nomor HP harus diisi.");
        return false;
    }
    
    var email = document.forms["formGuru"]["email_guru"].value;
    var atpos = email.indexOf("@");
    var dotpos = email.lastIndexOf(".");
    if (atpos<1 || dotpos<atpos+2 || dotpos+2>=email.length) {
        alert("Alamat email tidak valid.");
        return false;
    }
    
    var password = document.forms["formGuru"]["password_guru"].value;
    if(password == null || password == ""){
        alert("Password harus diisi");
        return false;
    }
    if(!validatePassword(password)){
        alert("Password harus minimal 8 karakter dan kombinasi huruf dan angka.");
        return false;
    }
    
    var confirmPassword = document.forms["formGuru"]["cpassword_guru"].value;
    if (password != confirmPassword){
        alert("Password dan konfirmasi password tidak cocok.");
        return false;
    }
    return true;
}

function showForm(type) {
    document.getElementById('formSiswa').style.display = (type === 'siswa') ? 'block' : 'none';
    document.getElementById('formGuru').style.display = (type === 'guru') ? 'block' : 'none';
    
    // tombol aktif
    document.getElementById('btnSiswa').classList.toggle('btn-dark', type === 'siswa');
    document.getElementById('btnSiswa').classList.toggle('btn-secondary', type !== 'siswa');
    document.getElementById('btnGuru').classList.toggle('btn-dark', type === 'guru');
    document.getElementById('btnGuru').classList.toggle('btn-secondary', type !== 'guru');
}

// Real-time password validation
function checkPasswordStrength(passwordField, strengthFieldId) {
    var password = passwordField.value;
    var strengthField = document.getElementById(strengthFieldId);
    
    if (password.length === 0) {
        strengthField.innerHTML = '';
        return;
    }
    
    var strength = 0;
    var feedback = '';
    
    if (password.length >= 8) strength++;
    if (/[A-Za-z]/.test(password)) strength++;
    if (/[0-9]/.test(password)) strength++;
    
    switch(strength) {
        case 3:
            feedback = '<span style="color:#27ae60"><i class="glyphicon glyphicon-ok"></i> Password kuat</span>';
            break;
        case 2:
            feedback = '<span style="color:#f39c12"><i class="glyphicon glyphicon-info-sign"></i> Password cukup</span>';
            break;
        case 1:
            feedback = '<span style="color:#e74c3c"><i class="glyphicon glyphicon-warning-sign"></i> Password lemah</span>';
            break;
        default:
            feedback = '<span style="color:#e74c3c"><i class="glyphicon glyphicon-remove"></i> Password terlalu pendek</span>';
    }
    
    strengthField.innerHTML = feedback;
}

// Set default form saat page load
// window.onload = function() {
//     showForm('siswa'); // Default tampilkan form siswa
// };
</script>
</head>

<?php
$mode = isset($_GET['mode']) ? $_GET['mode'] : 'masuk';
?>

<body style="background:url('./image/bg.png') no-repeat center center fixed; background-size:cover;">
  
<?php if ($mode == 'daftar'): ?>
<!-- ===== TAMPILAN FORM PENDAFTARAN ===== -->
<div class="bg1" style="height:100vh;">
    <div style="display:flex; height:100%; flex-wrap:wrap;">

        <!-- KIRI: gambar iClick -->
        <div style="flex:1; min-width:300px; width:100%; background:url('./image/bg.png') no-repeat center center; background-size:cover;"></div>

        <!-- KANAN -->
        <div style="flex:1; min-width:300px; width:100%; background:white; display:flex; justify-content:center; align-items:flex-start; padding-top:60px; padding:20px;">
            <div style="width:100%; max-width:600px; text-align:center;">
                <h3 style="font-size:20px; font-weight:700; margin-bottom:15px; margin-left:-3px; text-align:left;">Daftar Akun</h3>
                <p style="font-size:12px; font-weight:300; margin-bottom:15px; margin-left:-3px; text-align:left; color:#667085;"> Pilih Jenis Akun Kemudian Masukkan Detail Pribadi Anda dan Mulailah Perjalanan Bersama Kami </p>


                <!-- Tombol Pilihan -->
                <!-- Siswa -->
                 <div style="display:flex; justify-content:center; gap:20px; width:100%; ">
                    <button data-card onclick="selectCard(this); showForm('siswa')"
                    style="width:180px; max-width:100%; padding:18px 15px; border:1px solid #CCCCD9; border-radius:4px; background:#fff; cursor:pointer; margin-bottom:20px;"
                    onmouseover="this.style.background='#ab63e673'"
                    onmouseout="if(!this.dataset.active) this.style.background='#FFF'">
                        <span class="bi bi-person-vcard" style="font-size:22px; display:block;"></span>
                        <b style="font-size:16px; color:#667085; margin-top:5px; margin-bottom:5px; display:block;">Siswa</b>
                          <div style="font-size:12px; color:#000;">Ikuti kuis dan lihat progresmu</div>
                    </button>

                    <!-- Guru -->
                    <button data-card onclick="selectCard(this); showForm('guru')"
                     style="width:180px; max-width:100%; padding:18px 15px; border:1px solid #CCCCD9; border-radius:4px; background:#fff; cursor:pointer; margin-bottom:20px;"
                    onmouseover="this.style.background='#ab63e673'"
                    onmouseout="if(!this.dataset.active) this.style.background='#FFF'">
                        <span class="bi bi-person-workspace" style="font-size:22px; display:block;"></span>
                        <b style="font-size:16px; color:#667085; margin-top:5px; margin-bottom:5px; display:block;">Guru</b>
                        <div style="font-size:12px; color:#000;">Kelola kuis dan soal</div>
                    </button>
                </div>

                <!-- FORM SISWA -->
                <form id="formSiswa" name="formSiswa" action="sign.php?q=account.php" method="POST" onsubmit="return validateFormSiswa()" style="display:block;">
                    <input type="hidden" name="role" value="siswa">
                    <form id="formSiswa" name="formSiswa" action="sign.php?q=account.php" method="POST" onsubmit="return validateFormSiswa()" style="display:block;">
                        <input type="hidden" name="role" value="siswa">
                    <form id="formSiswa" name="formSiswa" action="sign.php?q=account.php" method="POST" onsubmit="return validateFormSiswa()" style="display:block;">
                        <input type="hidden" name="role" value="siswa">
                    <form id="formSiswa" name="formSiswa" action="sign.php?q=account.php" method="POST" onsubmit="return validateFormSiswa()" style="display:block;">
                        <input type="hidden" name="role" value="siswa">
                    <!-- Nama & Email -->
                    <div style="display:flex; gap:15px; flex-wrap:wrap;">
                        <div class="form-group" style="flex:1; min-width:150px;">
                            <label for="name" style="font-size:14px; font-weight:700; display:block; margin-bottom:5px; text-align:left;">Nama</label>
                            <div class="input-group mb-3" style="color:#667085; ">
                        <span class="input-group-addon" style="background:white; ">
                    <i class="bi bi-envelope"></i>
                    </span>
                            <input name="name" placeholder="Johan Bahlil" class="form-control input-md" style="color:#667085;" type="text" required>
                        </div>
                    </div>
                        <div class="form-group" style="flex:1; min-width:150px;">
                            <label for="email" style="font-size:14px; font-weight:700; display:block; margin-bottom:5px; text-align:left;">Email</label>
                            <div class="input-group mb-3" style=" color:#667085; ">
                        <span class="input-group-addon" style="background:white; ">
                    <i class="bi bi-envelope"></i>
                    </span>
                            <input name="email" placeholder="nama123@gmail.com" class="form-control input-md" style="color:#667085;" type="email" required>
                        </div>
                    </div> 
                </div>
                    <!-- Lembaga/Sekolah & Nomor HP -->
                    <div style="display:flex; gap:15px; flex-wrap:wrap;">
                        <div class="form-group" style="flex:1; min-width:150px;">
                            <label for="college" style=" font-size:14px; font-weight:700; display:block; text-align:left;  margin-bottom:5px;">Lembaga/Sekolah</label>
                            <div class="input-group mb-3" style="color:#667085; ">
                        <span class="input-group-addon" style="background:white; ">
                    <i class="bi bi-envelope"></i>
                    </span>
                        <input name="college" placeholder="SMKN Surabaya" class="form-control input-md" style="color:#667085;" type="text" required>
                        </div>
                    </div>
                        <div class="form-group" style="flex:1; min-width:150px;">
                            <label for="mob" style=" font-size:14px; font-weight:700; display:block; text-align:left;  margin-bottom:5px;">Nomor HP</label>
                            <div class="input-group mb-3" style="color:#667085; ">
                        <span class="input-group-addon" style="background:white; ">
                    <i class="bi bi-envelope"></i>
                    </span>
                            <input name="mob" placeholder="081234567890" class="form-control input-md" style="color:#667085;" type="tel" required>
                        </div>
                    </div> </div>
                    <!-- Password & Konfirmasi Password -->
                    <div style="display:flex; gap:15px; flex-wrap:wrap; ">
                        <div class="form-group" style="flex:1; min-width:150px;">
                            <label for="password" style=" font-size:14px; font-weight:700; display:block; text-align:left;  margin-bottom:5px;">Password</label>
                            <div class="input-group mb-3" style="color:#667085; ">
                        <span class="input-group-addon" style="background:white; ">
                    <i class="bi bi-envelope"></i>
                    </span>
                            <input name="password" placeholder="********" class="form-control input-md" style="color:#667085;" type="password" required
                                onkeyup="checkPasswordStrength(this, 'passwordStrengthSiswa')">
                            <small id="passwordStrengthSiswa" style="font-size:12px; margin-top:5px; display:block;"></small>
                        </div>
                        </div>
                        <div class="form-group" style="flex:1; min-width:150px;">
                            <label for="cpassword" style=" font-size:14px; font-weight:700; display:block; text-align:left;  margin-bottom:5px;">Konfirmasi Password</label>
                            <div class="input-group mb-3" style="color:#667085; ">
                        <span class="input-group-addon" style="background:white; ">
                    <i class="bi bi-envelope"></i>
                    </span>
                            <input name="cpassword" placeholder="********" class="form-control input-md" style="color:#667085;" type="password" required>
                        </div>
                    </div>
                </div>
                    <!-- Jenis Kelamin -->
                    <div class="form-group">
                        <label for="gender" style=" font-size:14px; font-weight:700;  display:block; text-align:left; margin-bottom:5px;">Jenis Kelamin</label>
                        <select name="gender" class="form-control input-md" style="color:#667085;" required>
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="Laki-Laki">Laki-Laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>
                    <!-- Submit -->
                    <div class="form-group" style="margin-top:40px;">
                        <input type="submit" class="btn" value="Daftar" style="background:#9823F5; color:#fff; width:100%;">
                    </div>
                    <!-- Info Password -->
                    <div style="font-size:12px; margin-top:10px; background:none; color:#FF1E00;">
                    <i class="bi bi-exclamation-circle"></i>
                    <strong>Ketentuan Password:</strong> Minimal 8 karakter, kombinasi huruf dan angka
                </div>
                    </form>
                    <script>
                function selectCard(el) {
                    document.querySelectorAll("[data-card]").forEach(c => {
                        c.style.background = "#FFF";
                        c.style.border = "1px solid #CCCCD9";
                        c.dataset.active = "";
                    });

                    el.style.background = "#ab63e673";
                    el.style.border = "2px solid #AC63E6";
                    el.dataset.active = "true";
                }
                </script>
                <p style="margin-top:30px; font-size:12px;">
                    Sudah punya akun?
                    <a href="?mode=masuk" style="color:#AC63E6; font-size:12px;">Masuk</a>
                </p>

                <!-- FORM GURU (DIPERBAIKI) -->
                <form id="formGuru" name="formGuru" action="sign.php?q=account.php" method="POST" onsubmit="return validateFormGuru()" style="display:none;">
                    <input type="hidden" name="role" value="guru">
                    <!-- Nama & Email -->
                    <div style="display:flex; gap:15px; flex-wrap:wrap;">
                        <div class="form-group" style="flex:1; min-width:150px;">
                            <label for="nama_guru" style="font-size:14px; font-weight:700; display:block; margin-bottom:5px; text-align:left;">Nama</label>
                            <div class="input-group mb-3" style="color:#667085; ">
                        <span class="input-group-addon" style="background:white; ">
                    <i class="bi bi-envelope"></i>
                    </span>
                            <input name="nama_guru" placeholder="Johan Bahlil" class="form-control input-md" style="color:#667085;" type="text" required>
                        </div>
                    </div>
                        <div class="form-group" style="flex:1; min-width:150px;">
                            <label for="email_guru" style="font-size:14px; font-weight:700; display:block; margin-bottom:5px; text-align:left;">Email</label>
                            <div class="input-group mb-3" style=" color:#667085; ">
                        <span class="input-group-addon" style="background:white; ">
                    <i class="bi bi-envelope"></i>
                    </span>
                            <input name="email_guru" placeholder="nama123@gmail.com" class="form-control input-md" style="color:#667085;" type="email" required>
                        </div>
                    </div> 
                </div>
                <!-- jurusan & Mengampu Mapel -->
                    <div style="display:flex; gap:15px; flex-wrap:wrap;">
                        <div class="form-group" style="flex:1; min-width:150px;">
                            <label for="pendidikan_terakhir" style=" font-size:14px; font-weight:700; display:block; text-align:left;  margin-bottom:5px;">Pendidikan</label>
                            <div class="input-group mb-3" style="color:#667085; ">
                        <span class="input-group-addon" style="background:white; ">
                    <i class="bi bi-envelope"></i>
                    </span>
                        <input name="pendidikan_terakhir" placeholder="S1 Pendidikan Fisika" class="form-control input-md" style="color:#667085;" type="text" required>
                        </div>
                    </div>
                        <div class="form-group" style="flex:1; min-width:150px;">
                            <label for="mapel" style=" font-size:14px; font-weight:700; display:block; text-align:left;  margin-bottom:5px;">Mata Pelajaran yang Diampu</label>
                            <div class="input-group mb-3" style="color:#667085; ">
                        <span class="input-group-addon" style="background:white; ">
                    <i class="bi bi-envelope"></i>
                    </span>
                            <input name="mapel" placeholder="Matematika" class="form-control input-md" style="color:#667085;" type="tel" required>
                        </div>
                    </div> </div>
                    <!--  Nomor HP -->
                    <div style="display:flex; gap:15px; flex-wrap:wrap; ">
                        <div class="form-group" style="flex:1; min-width:150px;">
                            <label for="mob_guru" style=" font-size:14px; font-weight:700; display:block; text-align:left;  margin-bottom:5px;">Nomor Telp.</label>
                            <div class="input-group mb-3" style="color:#667085; ">
                        <span class="input-group-addon" style="background:white; ">
                    <i class="bi bi-envelope"></i>
                    </span>
                         <input name="mob_guru" placeholder="081234567890" class="form-control input-md" style="color:#667085;" type="tel" required>
                        </div>
                    <!-- Password & Konfirmasi Password -->
                    <div style="display:flex; gap:15px; flex-wrap:wrap; margin-top:15px;">
                        <div class="form-group" style="flex:1; min-width:150px;">
                            <label for="password_guru" style=" font-size:14px; font-weight:700; display:block; text-align:left;  margin-bottom:5px;">Password</label>
                            <div class="input-group mb-3" style="color:#667085; ">
                        <span class="input-group-addon" style="background:white; ">
                    <i class="bi bi-envelope"></i>
                    </span>
                            <input name="password_guru" placeholder="********" class="form-control input-md" style="color:#667085;" type="password" required
                                onkeyup="checkPasswordStrength(this, 'passwordStrengthSiswa')">
                            <small id="passwordStrengthSiswa" style="font-size:12px; margin-top:5px; display:block;"></small>
                        </div>
                        </div>
                        <div class="form-group" style="flex:1; min-width:150px;">
                            <label for="cpassword_guru" style=" font-size:14px; font-weight:700; display:block; text-align:left;  margin-bottom:5px;">Konfirmasi Password</label>
                            <div class="input-group mb-3" style="color:#667085; ">
                        <span class="input-group-addon" style="background:white; ">
                    <i class="bi bi-envelope"></i>
                    </span>
                            <input name="cpassword_guru" placeholder="********" class="form-control input-md" style="color:#667085;" type="password" required>
                        </div>
                    </div>
                </div>
                <div>
                    <!-- Submit -->
                    <div class="form-group" style="margin-top:40px;">
                        <input type="submit" class="btn" value="Daftar" style="background:#9823F5; color:#fff; width:100%;">
                    </div>
                    <!-- Info Password -->
                    <div style="font-size:12px; margin-top:10px; background:none; color:#FF1E00;">
                    <i class="bi bi-exclamation-circle"></i>
                    <strong>Ketentuan Password:</strong> Minimal 8 karakter, kombinasi huruf dan angka <br>
                    <strong>Verifikasi:</strong> Akun guru akan diverifikasi oleh admin terlebih dahulu sebelum dapat digunakan.
                </div>
                    </form>
                <script>
                function selectCard(el) {
                    document.querySelectorAll("[data-card]").forEach(c => {
                        c.style.background = "#FFF";
                        c.style.border = "1px solid #CCCCD9";
                        c.dataset.active = "";
                    });

                    el.style.background = "#ab63e673";
                    el.style.border = "2px solid #AC63E6";
                    el.dataset.active = "true";
                }
                </script>
                <p style="margin-top:30px; font-size:12px;">
                    Sudah punya akun?
                    <a href="?mode=masuk" style="color:#AC63E6; font-size:12px;">Masuk</a>
                </p>
                </div>
            </div>
        </div>
    </div>
</div>
<?php else: ?>

<!-- ===== TAMPILAN LOGIN ===== -->
<div class="bg1" style="height:100vh;">
    <div style="display:flex; height:100%; flex-wrap:wrap;">

        <!-- KIRI: gambar iClick -->
        <div style="flex:1; min-width:300px; width:100%; background:url('./image/bg.png') no-repeat center center; background-size:cover;"></div>

        <!-- KANAN -->
        <div style="flex:1; min-width:300px; width:100%; background:white; display:flex; justify-content:center; align-items:flex-start; padding-top:60px; padding:20px;">
            <div style="width:100%; max-width:600px; text-align:center;">
                <h3 style="font-size:20px; font-weight:700; margin-bottom:15px; margin-left:-3px; text-align:left;">Masuk Akun</h3>
                <p style="font-size:12px; font-weight:300; margin-bottom:15px; margin-left:-3px; text-align:left; color:#667085;"> Pilih jenis akun Anda dan mulailah perjalanan bersama Kami  </p>
                
                <div style="display:flex; justify-content:center; gap:20px; flex-wrap:wrap; margin-bottom:25px; width:100%;">

                    <!-- Siswa -->
                    <button data-card onclick="selectCard(this); showForm('siswa')"
                     style="width:180px; max-width:100%; padding:18px 15px; border:1px solid #CCCCD9; border-radius:4px; background:#fff; cursor:pointer; margin-bottom:20px;"
                    onmouseover="this.style.background='#ab63e673'"
                    onmouseout="if(!this.dataset.active) this.style.background='#FFF'">
                        <span class="bi bi-person-vcard" style="font-size:22px; display:block;"></span>
                        <b style="font-size:16px; color:#667085; margin-top:5px; margin-bottom:5px; display:block;">Siswa</b>
                        <div style="font-size:12px; color:#000;">Ikuti kuis dan lihat progresmu</div>
                    </button>

                    <!-- Guru -->
                    <button data-card onclick="selectCard(this); showForm('guru')"
                     style="width:180px; max-width:100%; padding:18px 15px; border:1px solid #CCCCD9; border-radius:4px; background:#fff; cursor:pointer; margin-bottom:20px;"
                    onmouseover="this.style.background='#ab63e673'"
                    onmouseout="if(!this.dataset.active) this.style.background='#FFF'">
                        <span class="bi bi-person-workspace" style="font-size:22px; display:block;"></span>
                        <b style="font-size:16px; color:#667085; margin-top:5px; margin-bottom:5px; display:block;">Guru</b>
                        <div style="font-size:12px; color:#000;">Kelola kuis dan soal</div>
                    </button>

                    <!-- Admin -->
                    <button data-card onclick="selectCard(this); showForm('admin')"
                     style="width:180px; max-width:100%; padding:18px 15px; border:1px solid #CCCCD9; border-radius:4px; background:#fff; cursor:pointer; margin-bottom:20px;"
                    onmouseover="this.style.background='#ab63e673'"
                    onmouseout="if(!this.dataset.active) this.style.background='#FFF'">
                        <span class="bi bi-person-lock" style="font-size:22px; display:block;"></span>
                        <b style="font-size:16px; color:#667085; margin-top:5px; margin-bottom:5px; display:block;">Admin</b>
                        <div style="font-size:12px; color:#000;">Kelola sistem</div>
                    </button>

                </div>

                <script>
                function selectCard(el) {
                    document.querySelectorAll("[data-card]").forEach(c => {
                        c.style.background = "#FFF";
                        c.style.border = "1px solid #CCCCD9";
                        c.dataset.active = "";
                    });

                    el.style.background = "#ab63e673";
                    el.style.border = "2px solid #AC63E6";
                    el.dataset.active = "true";
                }
                </script>

                <!-- FORM LOGIN DITAMPILKAN DI BAWAH -->
                <div id="formArea"></div>

                <p style="margin-top:40px; font-size:12px;">
                    Belum punya akun?
                    <a href="?mode=daftar" style="color:#AC63E6; font-size:12px;">Daftar</a>
                </p>

            </div>
        </div>
    </div>
</div>
<script>
function showForm(type) {
    let formHTML = "";

    if (type === "siswa") {
        formHTML = `
            <h4 style="margin-top:5px; font-weight:700; font-size:16px; text-align:center; display:block; ">Login Sebagai Siswa</h4>
            <form action="login.php?q=index.php" method="POST" style="margin-top:15px; ">
           <label for="email" style=" font-size:14px; font-weight:700; display:block; text-align:left;  margin-bottom:5px;">Email</label>
            <div class="input-group mb-3" style="margin-bottom:15px; color:#667085; ">
            <span class="input-group-addon" style="background:white; ">
               <i class="bi bi-envelope"></i>
            </span>
            <input id="email" name="email" type="email" class="form-control input-md" style="color:#667085;" placeholder="nama123@gmail.com" required>

        </div>

         <label for="password" style=" font-size:14px; font-weight:700; display:block; text-align:left;  margin-bottom:5px;">Password</label>
        <div class="input-group mb-3">
            <span class="input-group-addon" style="background:white;">
              <i class="bi bi-lock"></i>
            </span>
            <input id="password" name="password" type="password" class="form-control input-md" style="color:#667085;" placeholder="*******" required>
        </div>
               <button class="btn" style="background:#9823F5; margin-top:50px; color:#fff; width:100%;">Masuk</button>
            </form>
        `;
    }
    if (type === "guru") {
        formHTML = `
            <h4 style="margin-top:5px; font-weight:700; font-size:16px; text-align:center; display:block;">Login Sebagai Guru</h4>
            <form action="login_guru.php?q=index.php" method="POST" style="margin-top:15px;">
                <label for="email" style=" font-size:14px; font-weight:700; display:block; text-align:left;  margin-bottom:5px;">Email</label>
            <div class="input-group mb-3" style="margin-bottom:15px; color:#667085; ">
            <span class="input-group-addon" style="background:white; ">
               <i class="bi bi-envelope"></i>
            </span>
            <input id="email" name="email" type="email" class="form-control input-md" style="color:#667085;" placeholder="nama123@gmail.com" required>

        </div>

         <label for="password" style=" font-size:14px; font-weight:700; display:block; text-align:left;  margin-bottom:5px;">Password</label>
        <div class="input-group mb-3">
            <span class="input-group-addon" style="background:white;">
              <i class="bi bi-lock"></i>
            </span>
            <input id="password" name="password" type="password" class="form-control input-md" style="color:#667085;" placeholder="*******" required>
        </div>
               <button class="btn" style="background:#9823F5; margin-top:50px; color:#fff; width:100%;">Masuk</button>
            </form>
        `;
    }
    if (type === "admin") {
        formHTML = `
            <h4 style="margin-top:5px; font-weight:700; font-size:16px; text-align:center; display:block;">Login Sebagai Admin</h4>
            <form action="admin.php?q=index.php" method="POST" style="margin-top:15px;">
                <label for="email" style=" font-size:14px; font-weight:700; display:block; text-align:left;  margin-bottom:5px;">Email</label>
            <div class="input-group mb-3" style="margin-bottom:15px; color:#667085; ">
            <span class="input-group-addon" style="background:white; ">
               <i class="bi bi-envelope"></i>
            </span>
            <input id="email" name="uname" type="email" class="form-control input-md" style="color:#667085;" placeholder="nama123@gmail.com" required>

        </div>

         <label for="password" style=" font-size:14px; font-weight:700; display:block; text-align:left;  margin-bottom:5px;">Password</label>
        <div class="input-group mb-3">
            <span class="input-group-addon" style="background:white;">
              <i class="bi bi-lock"></i>
            </span>
            <input id="password" name="password" type="password" class="form-control input-md" style="color:#667085;" placeholder="*******" required>
        </div>
               <button class="btn" style="background:#9823F5; margin-top:50px; color:#fff; width:100%;">Masuk</button>
            </form>
        `;
    }

    document.getElementById("formArea").innerHTML = formHTML;
}

</script>
<?php endif; ?>

</body>
</html>