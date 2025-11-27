<?php
session_start();
include_once 'dbConnection.php';

// Cek jika sudah login, redirect ke dashboard
if(isset($_SESSION['email_guru'])) {
    header("location:dash_guru.php");
    exit();
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = md5(mysqli_real_escape_string($con, $_POST['password']));
    
    // DEBUG: Tampilkan input
    error_log("LOGIN ATTEMPT - Email: $email, Password: [HASHED]");
    
    $result = mysqli_query($con, "SELECT * FROM guru WHERE email_guru='$email' AND password_guru='$password'");
    
    if($result && mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_array($result);
        
        // DEBUG: Tampilkan data yang ditemukan
        error_log("LOGIN SUCCESS - Data: " . print_r($row, true));
        
        // Cek status akun
        if($row['status'] == 'accept') {
            // PERBAIKAN KRITIS: Cek nama kolom yang sebenarnya
            $id_guru = isset($row['id_guru']) ? $row['id_guru'] : 
                      (isset($row['idguru']) ? $row['idguru'] : null);
            
            // Set session
            $_SESSION['email_guru'] = $email;
            $_SESSION['nama_guru'] = $row['nama_guru'];
            $_SESSION['id_guru'] = $id_guru; // PASTIKAN INI TERISI!
            $_SESSION['mapel'] = $row['mapel'];
            
            // DEBUG: Tampilkan session yang diset
            error_log("SESSION SET - id_guru: " . $id_guru . ", nama_guru: " . $row['nama_guru']);
            
            header("location:dash_guru.php");
            exit();
        } else {
            header("location:index.php?w=" . urlencode("Akun guru belum disetujui admin."));
            exit();
        }
    } else {
        error_log("LOGIN FAILED - Email: $email");
        header("location:index.php?w=" . urlencode("Email atau password salah."));
        exit();
    }
} else {
    header("location:index.php");
    exit();
}
?>