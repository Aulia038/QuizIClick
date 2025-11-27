<?php
session_start();

// Jika user sudah login, arahkan ke dashboard
if (isset($_SESSION['user_id'])) {
    header("Location: dash.php");
    exit();
}

// Tampilkan alert jika login gagal
if (isset($_GET['w'])) {
    echo "<script>alert('" . $_GET['w'] . "');</script>";
}

// Jika belum login, tampilkan homepage
include("homepage.php");
?>
