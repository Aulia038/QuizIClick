<?php
include_once 'dbConnection.php';
session_start();

// Validasi session 
if (!isset($_SESSION['siswa_email']) || $_SESSION['role'] != 'siswa') {
    header("location:index.php");
    exit();
}

$email = $_SESSION['siswa_email'];

// Set session key
if (!isset($_SESSION['key'])) {
    $_SESSION['key'] = 'sunny7785068889';
}

// QUIZ ANSWER CHECKING
if(isset($_GET['q']) && $_GET['q'] == 'quiz' && isset($_GET['step']) && $_GET['step'] == 2) {
    $eid = $_GET['eid'];
    $sn = (int)$_GET['n'];
    $total = (int)$_GET['t'];
    $ans = $_POST['ans'];
    $qid = $_GET['qid'];
    
    $quiz_check = mysqli_query($con,"SELECT * FROM quiz WHERE eid='$eid'");
    $quiz_data = mysqli_fetch_array($quiz_check);
    $time_limit = $quiz_data['time'];
    
    $q = mysqli_query($con,"SELECT * FROM questions WHERE qid='$qid'");
    
    if($row = mysqli_fetch_array($q)) {
        $correct_answer = $row['answer'];
        $sn_value = $row['sn'];
        
        if($ans == $correct_answer) {
            // Jawaban benar
            $q = mysqli_query($con,"SELECT * FROM quiz WHERE eid='$eid'");
            while($row = mysqli_fetch_array($q)) {
                $sahi = $row['sahi'];  // Nilai per soal benar dari tabel quiz
            }
            
            if($sn == 1) {
                $q = mysqli_query($con,"INSERT INTO history VALUES('$email','$eid','0','0','0','0',NOW())") or die('Error');
            }
            
            $q = mysqli_query($con,"SELECT * FROM history WHERE eid='$eid' AND email='$email'") or die('Error');
            while($row = mysqli_fetch_array($q)) {
                $s = $row['score'];
                $r = $row['sahi'];
            }
            
            $r++;
            
            // === PERBAIKAN: GUNAKAN $sahi DARI QUIZ, BUKAN $sn_value ===
            $s = $s + $sahi;  // Tambah dengan nilai per soal benar
            
            $q = mysqli_query($con,"UPDATE `history` SET `score`=$s,`level`=$sn,`sahi`=$r, date=NOW() WHERE email='$email' AND eid='$eid'") or die('Error');
            
        } else {
            // Jawaban salah
            $q = mysqli_query($con,"SELECT * FROM quiz WHERE eid='$eid'") or die('Error');
            while($row = mysqli_fetch_array($q)) {
                $wrong = $row['wrong'];  // Pengurangan nilai per salah
            }
            
            if($sn == 1) {
                $q = mysqli_query($con,"INSERT INTO history VALUES('$email','$eid','0','0','0','0',NOW())") or die('Error');
            }
            
            $q = mysqli_query($con,"SELECT * FROM history WHERE eid='$eid' AND email='$email'") or die('Error');
            while($row = mysqli_fetch_array($q)) {
                $s = $row['score'];
                $w = $row['wrong'];
            }
            
            $w++;
            
            // === PERBAIKAN: KURANGI SKOR TAPI PASTIKAN TIDAK MINUS ===
            $s = $s - $wrong;
            if($s < 0) $s = 0;  // JANGAN BIARKAN SKOR MINUS
            
            $q = mysqli_query($con,"UPDATE `history` SET `score`=$s,`level`=$sn,`wrong`=$w, date=NOW() WHERE email='$email' AND eid='$eid'") or die('Error');
        }
        
        if($sn != $total) {
            $sn++;
            header("location:account.php?q=quiz&step=2&eid=$eid&n=$sn&t=$total");
            exit();
        } else {
            // Quiz selesai
            $q = mysqli_query($con,"SELECT score FROM history WHERE eid='$eid' AND email='$email'") or die('Error');
            while($row = mysqli_fetch_array($q)) {
                $s = $row['score'];
            }
            
            $q = mysqli_query($con,"SELECT * FROM `rank` WHERE email='$email'") or die('Error');
            $rowcount = mysqli_num_rows($q);
            
            if($rowcount == 0) {
                $q2 = mysqli_query($con,"INSERT INTO `rank` VALUES('$email','$s',NOW())") or die('Error');
            } else {
                while($row = mysqli_fetch_array($q)) {
                    $sun = $row['score'];
                }
                $sun = $s + $sun;
                $q = mysqli_query($con,"UPDATE `rank` SET `score`=$sun, time=NOW() WHERE email='$email'") or die('Error');
            }
            
            header("location:account.php?q=result&eid=$eid");
            exit();
        }
    } else {
        die("Soal tidak ditemukan!");
    }
}

// RESTART QUIZ
if(isset($_GET['q']) && $_GET['q'] == 'quizre' && isset($_GET['step']) && $_GET['step'] == 25) {
    $eid = $_GET['eid'];
    $n = $_GET['n'];
    $t = $_GET['t'];
    
    // 1. AMBIL SCORE SEBELUMNYA DULU
    $previous_score = 0;
    $q = mysqli_query($con,"SELECT score FROM history WHERE eid='$eid' AND email='$email' ORDER BY date DESC LIMIT 1");
    if(mysqli_num_rows($q) > 0) {
        while($row = mysqli_fetch_array($q)) {
            $previous_score = $row['score'];
        }
    }
    
    // 2. HAPUS HISTORY
    $q = mysqli_query($con,"DELETE FROM `history` WHERE eid='$eid' AND email='$email'") or die('Error');
    
    // 3. UPDATE RANK (KURANGI SCORE LAMA)
    if($previous_score > 0) {
        $q = mysqli_query($con,"SELECT score FROM `rank` WHERE email='$email'");
        if(mysqli_num_rows($q) > 0) {
            while($row = mysqli_fetch_array($q)) {
                $current_rank_score = $row['score'];
            }
            $new_rank_score = $current_rank_score - $previous_score;
            // Pastikan tidak minus
            if($new_rank_score < 0) $new_rank_score = 0;
            
            $q = mysqli_query($con,"UPDATE `rank` SET `score`=$new_rank_score, time=NOW() WHERE email='$email'") or die('Error');
        }
    }
    
    header("location:account.php?q=quiz&step=2&eid=$eid&n=1&t=$t");
    exit();
}
?>