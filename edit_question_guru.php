<?php
// edit_question_guru.php
session_start();
include_once 'dbConnection.php';

// Validasi session guru
if (!isset($_SESSION['id_guru'])) {
    header("location:index.php");
    exit();
}

$id_guru = $_SESSION['id_guru'];
$nama_guru = $_SESSION['nama_guru'];
$mapel = $_SESSION['mapel'];

// Ambil qid dari URL
$qid = isset($_GET['qid']) ? mysqli_real_escape_string($con, $_GET['qid']) : '';

if (empty($qid)) {
    header("location:dash_guru.php?q=4&error=ID soal tidak valid");
    exit();
}

// Ambil data soal dan pastikan milik guru ini
$question_query = mysqli_query($con, "SELECT q.*, qz.title, qz.eid, qz.id_guru 
                                     FROM questions q 
                                     JOIN quiz qz ON q.eid = qz.eid 
                                     WHERE q.qid = '$qid' AND qz.id_guru = '$id_guru'");

if (mysqli_num_rows($question_query) == 0) {
    header("location:dash_guru.php?q=4&error=Soal tidak ditemukan atau bukan milik Anda");
    exit();
}

$question = mysqli_fetch_array($question_query);
$eid = $question['eid'];

// Jika title tidak ada, ambil dari query terpisah
if (empty($question['title'])) {
    $quiz_query = mysqli_query($con, "SELECT title FROM quiz WHERE eid = '$eid'");
    if ($quiz_data = mysqli_fetch_array($quiz_query)) {
        $quiz_title = $quiz_data['title'];
    } else {
        $quiz_title = "Kuis Tidak Ditemukan";
    }
} else {
    $quiz_title = $question['title'];
}

// Handle form submission untuk update soal
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_question'])) {
    $qns = mysqli_real_escape_string($con, $_POST['qns']);
    $optionA = mysqli_real_escape_string($con, $_POST['optionA']);
    $optionB = mysqli_real_escape_string($con, $_POST['optionB']);
    $optionC = mysqli_real_escape_string($con, $_POST['optionC']);
    $optionD = mysqli_real_escape_string($con, $_POST['optionD']);
    $answer = mysqli_real_escape_string($con, $_POST['answer']);
    $sn = (int)$_POST['sn'];
    
    $update_query = "UPDATE questions SET 
                    qns = '$qns',
                    optionA = '$optionA',
                    optionB = '$optionB',
                    optionC = '$optionC',
                    optionD = '$optionD',
                    answer = '$answer',
                    sn = '$sn'
                    WHERE qid = '$qid'";
    
    if (mysqli_query($con, $update_query)) {
        $success_msg = "Soal berhasil diperbarui!";
        // Refresh data
        $question_query = mysqli_query($con, "SELECT * FROM questions WHERE qid = '$qid'");
        $question = mysqli_fetch_array($question_query);
    } else {
        $error_msg = "Error: " . mysqli_error($con);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Soal - iClick Guru</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/bootstrap.min.css"/>
    <link rel="stylesheet" href="css/bootstrap-theme.min.css"/>    
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/font1.css">
    <script src="js/jquery.js" type="text/javascript"></script>
    <script src="js/bootstrap.min.js" type="text/javascript"></script>
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet' type='text/css'>
    
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
    .main-content {
        margin-left: 250px;
        margin-top: 20px;
        padding: 20px;
        min-height: calc(100vh - 60px);
    }

    /* .quiz-header {
        background: linear-gradient(135deg, #222, #444);
        color: white;
        padding: 20px 30px;
        border-radius: 10px;
        margin-bottom: 30px;
    } */

    .stats-card {
        background: white;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        margin-bottom: 20px;
        text-align:center;
    }

    .table-responsive {
        background: white;
        border-radius: 10px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        overflow: hidden;
    }

    table.table-striped > thead > tr {
        background:#222;
        color:white;
    }

    .badge-lulus {
        background:#27ae60;
        color:white;
    }

    .badge-tidak {
        background:#e74c3c;
        color:white;
    }
    
</style>
</head>
<body>

<!-- Header Bar -->
<header style="
    position: fixed;
    top: 0;
    right: 40px;
    width: calc(100% - 220px);
    height: 60px;
    color: black;
    display: flex;
    align-items: center;
    justify-content: flex-end;
    padding: 0 25px;
    z-index: 999;
">
    <div style="display: flex; align-items: center; gap: 10px;">
        <span style="color:#000; font-weight:400; font-size:16px;" class="bi bi-person-fill"></span>
        <span style="color:#000; font-weight:400; font-size:16px;"><?= htmlspecialchars($nama_guru) ?></span>
    </div>
</header>

<!-- Sidebar Navigation -->
<nav style="
font-size:16px;
  position: fixed;
  top: 0;
  left: 0;
  height: 100%;
  width: 220px;
  background-color: #101010;
  padding-top: 20px;
  color: white;
  overflow-y: auto;
  z-index: 1000;">
  
  <!-- Logo -->
  <div style="text-align:center; margin-bottom:20px;">
    <img src="image/logoheader.png" alt="Logo" style="width:100px; height:100px; margin-top:-30px">
    <h4 style="margin-top:0px; color:#fff; font-size:24px; font-weight:700; text-align:center;">Panel Guru</h4>
    <p style="color:#fff; background:#7C3AED; border-radius:4px; padding:10px 0px; font-size:16px; font-weight:400; margin-bottom:10px;text-align:center;"><?= htmlspecialchars($mapel) ?></p>
  </div>
  <!-- Menu -->
    <li <?php if(!isset($_GET['q']) || @$_GET['q']==0) echo 'style="background:#444; border-radius:4px;"'; ?>>
      <a href="dash_guru.php?q=0" style="display:block; padding:12px 20px; color:white; text-decoration:none;">
        <span class="bi bi-house-door-fill"></span>&nbsp; Beranda
      </a>
    </li>
       <li <?php if(@$_GET['q']==2) echo 'style="background:#444; border-radius:4px;"'; ?>>
      <a href="dash_guru.php?q=2" style="display:block; padding:12px 20px; color:white; text-decoration:none;">
        <span class="bi bi-arrow-left"></span>&nbsp; Kembali
      </a>
    </li>
    <li style="border-top:1px solid #444; margin-top:10px;">
      <a href="logout.php?q=account.php" style="display:block; padding:12px 20px; color:#7C3AED; text-decoration:none;">
        <span class="bi bi-box-arrow-right"></span>&nbsp; Keluar
      </a>
    </li>
  </ul>

</nav>

<!-- Main Content -->
<div class="main-content">
    <div class="container-fluid">
        <!-- Notifikasi -->
        <?php if(isset($success_msg)): ?>
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Sukses!</strong> <?= $success_msg ?>
                <br><a href="edit_quiz_guru.php?eid=<?= $eid ?>" class="alert-link">Kembali ke Edit Kuis</a>
            </div>
        <?php endif; ?>
        
        <?php if(isset($error_msg)): ?>
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Error!</strong> <?= $error_msg ?>
            </div>
        <?php endif; ?>

        <!-- Header -->
         <div class="quiz-header">
            <div class="row">
                <div class="col-md-8">
                   <h1 style="color:#000; font-weight:700; font-size:36px; margin-top:20px;">Edit Soal</h1>
                  <p style="font-size:18px; color:#667085; margin-top:18px;">Halaman ini digunakan untuk mengubah, memperbarui, atau memperbaiki soal yang sudah dibuat.</p>

        <!-- GRID -->
            <div style="display:flex; gap:25px; flex-wrap:wrap;">
               <!-- WRAPPER UNTUK 3 CARD -->
                <div style="display:flex; gap:20px; flex-wrap:wrap; margin-top:10px;">
            <!-- MATERI KUIS -->
            <div style="
                flex:1; min-width:200px; background:#151518; padding:20px; position:relative; border:1px solid #27272A; border-radius:8px;">
                <i class="bi bi-book" style="position:absolute; top:30px; right:30px; font-size:24px; color:#8B5CF6;"></i>
                <h3 style="margin-top:5px; font-size:16px; font-weight:300; color:#71717A;">Materi Kuis</h3>
                <p style="margin-top:5px; font-size:24px; font-weight:700; color:#fff;">
                    <?= htmlspecialchars($quiz_title ?? 'Kuis Tidak Ditemukan') ?></p>
            </div>
            <!-- GURU -->
            <div style="
                flex:1; min-width:200px;background:#151518; padding:20px; position:relative;border:1px solid #27272A; border-radius:8px;">
                <i class="bi bi-person-fill" style="position:absolute; top:25px; right:30px; font-size:24px; color:#10B981;"></i>
                <h3 style="margin-top:5px; font-size:16px; font-weight:300; color:#71717A;">Guru</h3>
                <p style="font-size:18px; font-weight:700;  color:#fff;"><?= htmlspecialchars($nama_guru) ?> - <?= htmlspecialchars($mapel) ?></p>
            </div>
            <!-- ID SOAL -->
            <div style="
                flex:1; min-width:200px;background:#151518; padding:20px; position:relative; border:1px solid #27272A; border-radius:8px;">
                <i class="bi bi-hash" style="position:absolute; top:30px; right:30px; font-size:24px; color:#3B82F6;"></i>
                <h3 style="margin-top:5px; font-size:16px; font-weight:300; color:#71717A;">Id Soal</h3>
                <p style="font-size:24px; font-weight:700;  color:#fff;">
                    <?= $question['qid'] ?> </p>
            </div>
        </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Edit Soal -->
        <div class="panel" style="background:#151518; border-radius:10px; padding:30px; border:1px solid #27272A; margin-left:-3px; margin-top:20px;">
            <form method="POST" action="">
                <input type="hidden" name="update_question" value="1">
                
                <div class="question-card">
                    <div class="question-header" style="color:#000; margin-bottom:10px;">
                        <h4 style="margin:0; color:#fff; font-size:24px; font-weight:700;">Form Edit Soal</h4>
                        <p style="color:#A1A1AA; font-size:16px; font-weight:300; margin-top:5px;">
                        Halaman ini digunakan untuk memperbarui konten soal, termasuk pertanyaan, pilihan jawaban, dan kunci jawaban.
                    </p>
                    </div>
                    
                    <!-- Input Skor Nilai -->
                    <div class="form-group">
                        <label style="color:#fff; font-size:16px; font-weight:700; margin-top:5px;">Skor Nilai untuk Soal Ini</label>
                        <div class="input-group">
                            <span class="input-group-addon" style="background:#9b59b6; color:white; border:none;">
                                <i class="bi bi-star" ></i> Poin
                            </span>
                            <input type="number" name="sn" class="form-control" 
                                   value="<?= $question['sn'] ?>" min="1" max="100" required >
                        </div>
                    </div>

                    <!-- Pertanyaan -->
                    <div class="form-group">
                        <label style="color:#fff; font-size:16px; font-weight:700; margin-top:5px;"><b>Pertanyaan</b></label>
                        <textarea rows="4" name="qns" class="form-control" placeholder="Tulis pertanyaan di sini..." required><?= htmlspecialchars($question['qns']) ?></textarea>
                    </div>

                    <div class="row">
                        <!-- Opsi A -->
                        <div class="form-group col-md-6">
                            <label style="color:#fff; font-size:16px; font-weight:700;">Opsi A</label>
                            <div class="input-group">
                                <span class="input-group-addon" style="background:#7C3AED; color:white; border:none;">A</span>
                                <input name="optionA" value="<?= htmlspecialchars($question['optionA']) ?>" class="form-control" type="text" required>
                            </div>
                        </div>

                        <!-- Opsi B -->
                        <div class="form-group col-md-6">
                            <label style="color:#fff; font-size:16px; font-weight:700;">Opsi B</label>
                            <div class="input-group">
                                <span class="input-group-addon" style="background:#7C3AED; color:white; border:none;">B</span>
                                <input name="optionB" value="<?= htmlspecialchars($question['optionB']) ?>" class="form-control" type="text" required>
                            </div>
                        </div>

                        <!-- Opsi C -->
                        <div class="form-group col-md-6">
                            <label style="color:#fff; font-size:16px; font-weight:700;">Opsi C</label>
                            <div class="input-group">
                                <span class="input-group-addon" style="background:#7C3AED; color:white; border:none;">C</span>
                                <input name="optionC" value="<?= htmlspecialchars($question['optionC']) ?>" class="form-control" type="text" required>
                            </div>
                        </div>

                        <!-- Opsi D -->
                        <div class="form-group col-md-6">
                            <label style="color:#fff; font-size:16px; font-weight:700;">Opsi D</label>
                            <div class="input-group">
                                <span class="input-group-addon" style="background:#7C3AED; color:white; border:none;">D</span>
                                <input name="optionD" value="<?= htmlspecialchars($question['optionD']) ?>" class="form-control" type="text" required>
                            </div>
                        </div>
                    </div>

                    <!-- Jawaban Benar -->
                    <div class="form-group">
                        <label><b>Jawaban Benar</b></label>
                        <select name="answer" class="form-control" style="font-weight:600;" required>
                            <option value="">Pilih jawaban yang benar</option>
                            <option value="a" style="color:#000;" <?= $question['answer'] == 'a' ? 'selected' : '' ?>>✅ Opsi A</option>
                            <option value="b" style="color:#000;" <?= $question['answer'] == 'b' ? 'selected' : '' ?>>✅ Opsi B</option>
                            <option value="c" style="color:#000;" <?= $question['answer'] == 'c' ? 'selected' : '' ?>>✅ Opsi C</option>
                            <option value="d" style="color:#000;" <?= $question['answer'] == 'd' ? 'selected' : '' ?>>✅ Opsi D</option>
                        </select>
                    </div>
                </div>

                <div class="form-group text-center" style="margin-top:30px; padding-top:20px; border-top:2px dashed #fff;">
                    <div class="alert" style="background:none; color:#fff; border-radius:0 !important; box-shadow:none !important;">
                        <strong>Perhatian:</strong> Pastikan semua data sudah benar sebelum menyimpan.
                    </div>
                    <button type="submit" class="btn btn-success btn-lg" style="margin-right:10px; background:#7C3AED; color:white; padding:10px 22px; border:none;
                        border-radius:10px; font-size:16px; font-weight:300; cursor:pointer;">
                        <i class="bi bi-check-circle"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-sm" style=" background:#EF4444; color:white; padding:10px 22px; border:none;
                    border-radius:10px; font-size:16px; font-weight:300; cursor:pointer;"
                    onclick="confirmDeleteQuestion('<?= $question['qid'] ?>')">
                    <i class="bi bi-trash"></i> Hapus
                    </button>
                    <a href="edit_quiz_guru.php?eid=<?= $eid ?>" class="btn btn-lg" style="margin-left:10px; background:none; color:#fff; padding:10px 22px; border:1px solid #27272A;
                    border-radius:10px; font-size:16px; font-weight:300; cursor:pointer;
                    text-decoration:none; display:inline-block;">
                        <i class="bi bi-arrow-counterclockwise"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- JavaScript -->
<script>
function confirmDeleteQuestion(qid) {
    if(confirm('Apakah Anda yakin ingin menghapus soal ini?\nTindakan ini tidak dapat dibatalkan!')) {
        window.location.href = 'update_guru.php?q=delete_question&qid=' + qid + '&eid=<?= $eid ?>';
    }
}
</script>

</body>
</html>