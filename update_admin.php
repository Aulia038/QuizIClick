<?php
include_once 'dbConnection.php';
session_start();

// Validasi session admin
if (!isset($_SESSION['email'])) {
    header("location:index.php");
    exit();
}

$email = $_SESSION['email'];

// Set session key
if (!isset($_SESSION['key'])) {
    $_SESSION['key'] = 'sunny7785068889';
}


// DELETE USER
if(isset($_GET['demail'])) {
    $demail = mysqli_real_escape_string($con, $_GET['demail']);
    
    // Cek apakah user ada
    $check_user = mysqli_query($con, "SELECT * FROM user WHERE email='$demail'");
    if(mysqli_num_rows($check_user) == 0) {
        header("location:dash.php?q=1&error=User tidak ditemukan");
        exit();
    }
    
    // Hapus dari semua tabel terkait
    mysqli_query($con,"DELETE FROM `rank` WHERE email='$demail'") or die('Error');
    mysqli_query($con,"DELETE FROM history WHERE email='$demail'") or die('Error');
    mysqli_query($con,"DELETE FROM user WHERE email='$demail'") or die('Error');
    
    header("location:dash.php?q=1&msg=User berhasil dihapus");
    exit();
}
// REMOVE QUIZ
if(isset($_GET['q']) && $_GET['q'] == 'rmquiz') {
    $eid = mysqli_real_escape_string($con, $_GET['eid']);
    
    mysqli_query($con,"DELETE FROM questions WHERE eid='$eid'") or die('Error');
    mysqli_query($con,"DELETE FROM history WHERE eid='$eid'") or die('Error');
    mysqli_query($con,"DELETE FROM quiz WHERE eid='$eid'") or die('Error');

    header("location:dash.php?q=5");
    exit();
}

// DELETE QUESTION - Hapus soal individual
if(isset($_GET['q']) && $_GET['q'] == 'delete_question') {
    $qid = mysqli_real_escape_string($con, $_GET['qid']);
    $eid = mysqli_real_escape_string($con, $_GET['eid']);
    
    $result = mysqli_query($con,"DELETE FROM questions WHERE qid='$qid'") or die('Error');
    header("location:edit_quiz.php?eid=$eid&msg=Soal berhasil dihapus");
    exit();
}

// ADD QUIZ - ADMIN
if(isset($_GET['q']) && $_GET['q'] == 'addquiz') {
    $name = $_POST['name'];
    $name = ucwords(strtolower($name));
    $total = (int)$_POST['total'];
    $sahi = (int)$_POST['right'];
    $wrong = (int)$_POST['wrong'];
    $time = (int)$_POST['time'];
    $tag = $_POST['tag'];
    $desc = $_POST['desc'];
    $pembuat = $_POST['pembuat'];
    $id_guru_selected = isset($_POST['id_guru']) ? (int)$_POST['id_guru'] : null;
    $id = uniqid();
    
    // Tentukan id_guru berdasarkan pilihan
    if($pembuat == 'guru' && !empty($id_guru_selected)) {
        $id_guru_value = $id_guru_selected;
        $q3 = mysqli_query($con, "INSERT INTO quiz 
            (eid, title, sahi, wrong, total, time, intro, tag, pembuat_role, id_guru, date) 
            VALUES 
            ('$id','$name','$sahi','$wrong','$total','$time','$desc','$tag','guru','$id_guru_value',NOW())");
    } else {
        // Insert untuk admin
        $q3 = mysqli_query($con, "INSERT INTO quiz 
            (eid, title, sahi, wrong, total, time, intro, tag, pembuat_role, id_guru, date) 
            VALUES 
            ('$id','$name','$sahi','$wrong','$total','$time','$desc','$tag','admin',NULL,NOW())");
    }

    if($q3) {
        header("location:dash.php?q=4&step=2&eid=$id&n=$total");
        exit();
    } else {
        $error_msg = mysqli_error($con);
        header("location:dash.php?q=4&error=" . urlencode("Gagal membuat kuis: $error_msg"));
        exit();
    }
}

// ADD QUESTIONS - ADMIN (HANDLER UNTUK STEP 2)
if(isset($_GET['q']) && $_GET['q'] == 'addqns') {
    $n = (int)$_GET['n'];
    $eid = mysqli_real_escape_string($con, $_GET['eid']);
    
    // Validasi: pastikan kuis ada dan milik admin
    $quiz_check = mysqli_query($con, "SELECT * FROM quiz WHERE eid='$eid'");
    if(mysqli_num_rows($quiz_check) == 0) {
        header("location:dash.php?q=4&error=Kuis tidak ditemukan");
        exit();
    }
    
    // Process each question
    for($i = 1; $i <= $n; $i++) {
        // Validasi input soal
        if(empty($_POST['qns'.$i]) || empty($_POST[$i.'1']) || empty($_POST[$i.'2']) || empty($_POST[$i.'3']) || empty($_POST[$i.'4']) || empty($_POST['ans'.$i])) {
            header("location:dash.php?q=4&step=2&eid=$eid&n=$n&error=Semua field soal harus diisi");
            exit();
        }
        
        $qid = uniqid();
        $qns = mysqli_real_escape_string($con, $_POST['qns'.$i]);
        $optionA = mysqli_real_escape_string($con, $_POST[$i.'1']);
        $optionB = mysqli_real_escape_string($con, $_POST[$i.'2']);
        $optionC = mysqli_real_escape_string($con, $_POST[$i.'3']);
        $optionD = mysqli_real_escape_string($con, $_POST[$i.'4']);
        $answer = mysqli_real_escape_string($con, $_POST['ans'.$i]);
        $sn = (int)$_POST['sn'.$i];
        
        // Insert question into database
        $sql = "INSERT INTO questions 
                (qid, eid, qns, optionA, optionB, optionC, optionD, answer, sn) 
                VALUES 
                ('$qid', '$eid', '$qns', '$optionA', '$optionB', '$optionC', '$optionD', '$answer', '$sn')";
        
        $result = mysqli_query($con, $sql);
        
        if(!$result) {
            $error_msg = mysqli_error($con);
            header("location:dash.php?q=4&step=2&eid=$eid&n=$n&error=" . urlencode("Gagal menyimpan soal $i: $error_msg"));
            exit();
        }
    }
    
    // Semua soal berhasil disimpan
    header("location:dash.php?q=0&msg=Kuis berhasil dibuat dengan $n soal!");
    exit();
}

// QUIZ ANSWER CHECKING
if(isset($_GET['q']) && $_GET['q'] == 'quiz' && isset($_GET['step']) && $_GET['step'] == 2) {
    $eid = $_GET['eid'];
    $sn = (int)$_GET['n'];
    $total = (int)$_GET['t'];
    $ans = $_POST['ans'];
    $qid = $_GET['qid'];
    
    // CEK APAKAH WAKTU MASIH TERSEDIA (optional - untuk security tambahan)
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
                $sahi = $row['sahi'];
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
            $s = $s + $sn_value;
            $q = mysqli_query($con,"UPDATE `history` SET `score`=$s,`level`=$sn,`sahi`=$r, date=NOW() WHERE email='$email' AND eid='$eid'") or die('Error');
            
        } else {
            // Jawaban salah
            $q = mysqli_query($con,"SELECT * FROM quiz WHERE eid='$eid'") or die('Error');
            while($row = mysqli_fetch_array($q)) {
                $wrong = $row['wrong'];
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
            $s = $s - $wrong;
            $q = mysqli_query($con,"UPDATE `history` SET `score`=$s,`level`=$sn,`wrong`=$w, date=NOW() WHERE email='$email' AND eid='$eid'") or die('Error');
        }
        
        if($sn != $total) {
            $sn++;
            header("location:account.php?q=quiz&step=2&eid=$eid&n=$sn&t=$total") or die('Error');
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
    
    $q = mysqli_query($con,"SELECT score FROM history WHERE eid='$eid' AND email='$email'") or die('Error');
    while($row = mysqli_fetch_array($q)) {
        $s = $row['score'];
    }

    $q = mysqli_query($con,"DELETE FROM `history` WHERE eid='$eid' AND email='$email'") or die('Error');
    
    $q = mysqli_query($con,"SELECT * FROM `rank` WHERE email='$email'") or die('Error');
    while($row = mysqli_fetch_array($q)) {
        $sun = $row['score'];
    }

    $sun = $sun - $s;
    $q = mysqli_query($con,"UPDATE `rank` SET `score`=$sun, time=NOW() WHERE email='$email'") or die('Error');
    
    header("location:account.php?q=quiz&step=2&eid=$eid&n=1&t=$t");
    exit();
}

// Jika tidak ada action yang match, redirect ke dashboard
header("location:dash.php?q=0");
exit();
?>