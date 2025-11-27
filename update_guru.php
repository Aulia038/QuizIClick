<?php
// update_guru.php 
session_start();
include_once 'dbConnection.php';

// AKTIFKAN ERROR REPORTING
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['id_guru'])) {
    die("Akses ditolak! Session guru tidak ditemukan.");
}

$id_guru = $_SESSION['id_guru'];

// FUNGSI UNTUK MENAMBAH KUIZ - GURU
if(@$_GET['q'] == 'addquiz') {
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $total = (int)$_POST['total'];
    $right = (int)$_POST['right'];
    $wrong = (int)$_POST['wrong'];
    $time = (int)$_POST['time'];
    $tag = mysqli_real_escape_string($con, $_POST['tag']);
    $desc = mysqli_real_escape_string($con, $_POST['desc']);
    
    $eid = uniqid();
    
    // Guru membuat kuis untuk diri sendiri 
    $q = mysqli_query($con, "INSERT INTO quiz 
        (eid, title, sahi, wrong, total, time, intro, tag, pembuat_role, id_guru, date) 
        VALUES 
        ('$eid', '$name', '$right', '$wrong', '$total', '$time', '$desc', '$tag', 'guru', '$id_guru', NOW())");
    
    if ($q) {
        header("location: dash_guru.php?q=5&step=2&eid=$eid&n=$total");
        exit();
    } else {
        die("Error membuat kuis: " . mysqli_error($con));
    }
}

// PERBAIKAN: Gunakan q=addqns bukan q=5
if(@$_GET['q'] == 'addqns') {
    $n = @$_GET['n'];
    $eid = @$_GET['eid'];
    
    echo "Debug: Starting addqns - n=$n, eid=$eid<br>";
    
    // Verifikasi kepemilikan kuis
    $check = mysqli_query($con, "SELECT * FROM quiz WHERE eid='$eid' AND id_guru='$id_guru'");
    if(mysqli_num_rows($check) == 0) {
        die("Akses ditolak! Kuis tidak ditemukan atau bukan milik Anda.");
    }
    
    // Process the questions
    for($i=1; $i<=$n; $i++) {
        $qid = uniqid();
        $qns = mysqli_real_escape_string($con, $_POST['qns'.$i]);
        $optionA = mysqli_real_escape_string($con, $_POST[$i.'1']);
        $optionB = mysqli_real_escape_string($con, $_POST[$i.'2']);
        $optionC = mysqli_real_escape_string($con, $_POST[$i.'3']);
        $optionD = mysqli_real_escape_string($con, $_POST[$i.'4']);
        $answer = mysqli_real_escape_string($con, $_POST['ans'.$i]);
        $sn = (int)$_POST['sn'.$i];
        
        echo "Processing question $i: $qns<br>";
        
        $sql = "INSERT INTO questions 
                (qid, eid, qns, optionA, optionB, optionC, optionD, answer, sn) 
                VALUES 
                ('$qid', '$eid', '$qns', '$optionA', '$optionB', '$optionC', '$optionD', '$answer', '$sn')";
        
        $q = mysqli_query($con, $sql);
        if(!$q) {
            die("Error inserting question $i: " . mysqli_error($con));
        }
    }
    
    echo "All questions saved! Redirecting...";
    header("location: dash_guru.php?q=1&msg=Kuis dan soal berhasil dibuat!");
    exit();
}

// Fungsi untuk hapus quiz
if(@$_GET['q'] == 'rmquiz') {
    $eid = mysqli_real_escape_string($con, $_GET['eid']);
    
    // Verifikasi kepemilikan kuis
    $check = mysqli_query($con, "SELECT * FROM quiz WHERE eid='$eid' AND id_guru='$id_guru'");
    
    if(mysqli_num_rows($check) == 1) {
        mysqli_query($con, "DELETE FROM questions WHERE eid='$eid'");
        mysqli_query($con, "DELETE FROM history WHERE eid='$eid'");
        mysqli_query($con, "DELETE FROM quiz WHERE eid='$eid' AND id_guru='$id_guru'");
        header("location: dash_guru.php?q=4&msg=Quiz berhasil dihapus");
    } else {
        header("location: dash_guru.php?q=4&error=Akses ditolak! Quiz tidak ditemukan.");
    }
    exit();
}

// DELETE QUESTION - untuk guru
if(isset($_GET['q']) && $_GET['q'] == 'delete_question') {
    $qid = mysqli_real_escape_string($con, $_GET['qid']);
    $eid = mysqli_real_escape_string($con, $_GET['eid']);
    
    $result = mysqli_query($con,"DELETE FROM questions WHERE qid='$qid'") or die('Error');
    header("location:edit_quiz_guru.php?eid=$eid&msg=Soal berhasil dihapus");
    exit();
}

// Jika tidak ada action yang match
header("location: dash_guru.php?q=0");
exit();
?>