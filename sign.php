<?php
include_once 'dbConnection.php';

// Fungsi untuk cek apakah kolom ada di tabel
function columnExists($con, $table, $column) {
    $result = mysqli_query($con, "SHOW COLUMNS FROM $table LIKE '$column'");
    return mysqli_num_rows($result) > 0;
}

$role = $_POST['role'];

if ($role == 'siswa') {
    // --- Form Siswa (DIPERBAIKI VALIDASI PASSWORD) ---
    $nama = $_POST['name'];
    $gender = $_POST['gender'];
    $college = $_POST['college'];
    $email = $_POST['email'];
    $mob = $_POST['mob'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];

    // Validasi password match
    if ($password != $cpassword) {
        header("location:tampilan_login.php?w=Password dan konfirmasi password tidak cocok");
        exit();
    }

    // **VALIDASI PASSWORD SISWA: Minimal 8 karakter, kombinasi huruf dan angka**
    if (strlen($password) < 8) {
        header("location:tampilan_login.php?w=Password harus minimal 8 karakter");
        exit();
    }
    
    if (!preg_match('/[A-Za-z]/', $password) || !preg_match('/[0-9]/', $password)) {
        header("location:tampilan_login.php?w=Password harus kombinasi huruf dan angka");
        exit();
    }

    // amankan input
    $nama = ucwords(strtolower(mysqli_real_escape_string($con, $nama)));
    $gender = mysqli_real_escape_string($con, $gender);
    $college = mysqli_real_escape_string($con, $college);
    $email = mysqli_real_escape_string($con, $email);
    $mob = mysqli_real_escape_string($con, $mob);
    $password = mysqli_real_escape_string($con, $password);
    $password = md5($password);

    // cek email sudah digunakan?
    $cekEmail = mysqli_query($con, "SELECT email FROM user WHERE email='$email'");
    if (mysqli_num_rows($cekEmail) > 0) {
        header("location:tampilan_login.php?w=Email sudah digunakan, silakan gunakan email lain");
        exit();
    }

    // insert data siswa
    $q = mysqli_query($con, "INSERT INTO user (name, gender, college, email, mob, password) 
        VALUES ('$nama', '$gender', '$college', '$email', '$mob', '$password')");

    if ($q) {
        header("location:tampilan_login.php?w=Pendaftaran siswa berhasil! Silakan login.");
    } else {
        header("location:tampilan_login.php?w=Pendaftaran gagal: " . mysqli_error($con));
    }

} elseif ($role == 'guru') {
    // --- Form Guru ---
    $nama_guru = $_POST['nama_guru'];
    $pendidikan_terakhir = $_POST['pendidikan_terakhir'];
    $mapel = $_POST['mapel'];
    $mob_guru = $_POST['mob_guru'];
    $email_guru = $_POST['email_guru'];
    $password_guru = $_POST['password_guru'];
    $cpassword_guru = $_POST['cpassword_guru'];

    // Validasi password match
    if ($password_guru != $cpassword_guru) {
        header("location:tampilan_login.php?w=Password dan konfirmasi password tidak cocok");
        exit();
    }

    // **VALIDASI PASSWORD GURU: Minimal 8 karakter, kombinasi huruf dan angka**
    if (strlen($password_guru) < 8) {
        header("location:tampilan_login.php?w=Password harus minimal 8 karakter");
        exit();
    }
    
    if (!preg_match('/[A-Za-z]/', $password_guru) || !preg_match('/[0-9]/', $password_guru)) {
        header("location:tampilan_login.php?w=Password harus kombinasi huruf dan angka");
        exit();
    }

    // amankan input
    $nama_guru = ucwords(strtolower(mysqli_real_escape_string($con, $nama_guru)));
    $pendidikan_terakhir = mysqli_real_escape_string($con, $pendidikan_terakhir);
    $mapel = mysqli_real_escape_string($con, $mapel);
    $mob_guru = mysqli_real_escape_string($con, $mob_guru);
    $email_guru = mysqli_real_escape_string($con, $email_guru);
    $password_guru = mysqli_real_escape_string($con, $password_guru);
    $password_guru_hash = md5($password_guru);

    // cek email sudah digunakan?
    $cekEmail = mysqli_query($con, "SELECT email_guru FROM guru WHERE email_guru='$email_guru'");
    if (mysqli_num_rows($cekEmail) > 0) {
        header("location:tampilan_login.php?w=Email sudah digunakan, silakan gunakan email lain");
        exit();
    }

    // **CEK APAKAH KOLOM mob_guru ADA**
    if (columnExists($con, 'guru', 'mob_guru')) {
        // Jika kolom mob_guru ada, gunakan query dengan mob_guru
        $q = mysqli_query($con, "INSERT INTO guru (nama_guru, pendidikan_terakhir, mapel, mob_guru, email_guru, password_guru, status, tanggal_daftar) 
            VALUES ('$nama_guru', '$pendidikan_terakhir', '$mapel', '$mob_guru', '$email_guru', '$password_guru_hash', 'pending', NOW())");
    } else {
        // Jika kolom mob_guru tidak ada, buat kolomnya dulu
        mysqli_query($con, "ALTER TABLE guru ADD COLUMN mob_guru VARCHAR(50) NOT NULL AFTER mapel");
        
        // Kemudian insert data
        $q = mysqli_query($con, "INSERT INTO guru (nama_guru, pendidikan_terakhir, mapel, mob_guru, email_guru, password_guru, status, tanggal_daftar) 
            VALUES ('$nama_guru', '$pendidikan_terakhir', '$mapel', '$mob_guru', '$email_guru', '$password_guru_hash', 'pending', NOW())");
    }

    if ($q) {
        header("location:tampilan_login.php?w=Pendaftaran guru berhasil! Menunggu verifikasi admin.");
    } else {
        $error = mysqli_error($con);
        error_log("INSERT ERROR: " . $error);
        header("location:tampilan_login.php?w=Pendaftaran gagal: " . $error);
    }

} else {
    header("location:tampilan_login.php?w=Role tidak valid!");
}
?>