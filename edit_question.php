<?php
// edit_question.php
session_start();
include_once 'dbConnection.php';

// Prevent caching
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

// Validasi session admin
if (!isset($_SESSION['email'])) {
    header("location:index.php");
    exit();
}

$email = $_SESSION['email'];
$name = $_SESSION['name'];

// Ambil qid dari URL
$qid = isset($_GET['qid']) ? mysqli_real_escape_string($con, $_GET['qid']) : '';

if (empty($qid)) {
    header("location:dash.php?q=5&error=ID soal tidak valid");
    exit();
}

// Ambil data soal
$question_query = mysqli_query($con, "SELECT q.*, qz.title, qz.eid FROM questions q 
                                     JOIN quiz qz ON q.eid = qz.eid 
                                     WHERE q.qid = '$qid'");

if (mysqli_num_rows($question_query) == 0) {
    header("location:dash.php?q=5&error=Soal tidak ditemukan");
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
    <title>Edit Soal - iClick</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css"/>
    <link rel="stylesheet" href="css/bootstrap-theme.min.css"/>    
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/font.css">
    <script src="js/jquery.js" type="text/javascript"></script>
    <script src="js/bootstrap.min.js" type="text/javascript"></script>
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet' type='text/css'>
    
    <style>
        .main-content {
            margin-left: 220px;
            margin-top: 60px;
            padding: 20px;
            min-height: calc(100vh - 60px);
        }
        
        .quiz-header {
            background: linear-gradient(135deg, #222, #444);
            color: white;
            padding: 30px;
            border-radius: 10px;
            margin-bottom: 30px;
        }
        
        .question-card {
            border: 2px solid #e3e3e3;
            border-radius: 12px;
            padding: 25px;
            background: #fafafa;
            margin-bottom: 30px;
        }
        
        .question-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 12px 20px;
            margin: -25px -25px 20px -25px;
            border-radius: 10px 10px 0 0;
        }
    </style>
</head>
<body style="background:#eee;">

<!-- Header Bar -->
<header style="
    position: fixed;
    top: 0;
    left: 220px;
    width: calc(100% - 220px);
    height: 60px;
    background-color: black;
    color: white;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 25px;
    box-shadow: 0 2px 5px rgba(0,0,0,0.3);
    z-index: 999;
">
    <div style="display: flex; align-items: center; gap: 10px;">
        <span style="color:#ffb300" class="glyphicon glyphicon-edit"></span>
        <span style="color:#ffb300">Edit Soal</span>
    </div>
    <div style="display: flex; align-items: center; gap: 10px;">
        <span style="color:#ffb300" class="glyphicon glyphicon-user"></span>
        <span style="color:#ffb300">Halo,</span>
        <a href="dash.php" style="color:#ffb300; text-decoration:none; font-weight:600;">
            <?= htmlspecialchars($name) ?>
        </a>
    </div>
</header>

<!-- Sidebar Navigation -->
<nav style="
    position: fixed;
    top: 0;
    left: 0;
    height: 100%;
    width: 220px;
    background-color: black;
    padding-top: 20px;
    color: white;
    overflow-y: auto;
    z-index: 1000;
">
    <!-- Logo -->
    <div style="text-align:center; margin-bottom:30px;">
        <img src="image/logo.png" alt="Logo" style="width:100px; height:100px; margin-top:-30px;">
        <h4 style="margin-top:10px; color:#fff;">Panel Admin</h4>
    </div>

    <!-- Menu -->
    <ul style="list-style:none; padding:0; margin:0; margin-top:30px;">
        <li>
            <a href="edit_quiz.php?eid=<?= $eid ?>" style="display:block; padding:12px 20px; color:white; text-decoration:none;">
                <span class="glyphicon glyphicon-arrow-left"></span>&nbsp; Kembali ke Edit Kuis
            </a>
        </li>
        <li>
            <a href="dash.php?q=5" style="display:block; padding:12px 20px; color:white; text-decoration:none;">
                <span class="glyphicon glyphicon-list"></span>&nbsp; Kelola Kuis
            </a>
        </li>
        <li style="border-top:1px solid #444; margin-top:10px;">
            <a href="logout.php?q=dash.php" style="display:block; padding:12px 20px; color:#f66; text-decoration:none;">
                <span class="glyphicon glyphicon-log-out"></span>&nbsp; Keluar
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
                <br><a href="edit_quiz.php?eid=<?= $eid ?>" class="alert-link">Kembali ke Edit Kuis</a>
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
                    <h1><i class="fas fa-edit"></i> Edit Soal</h1>
                    <h3><?= htmlspecialchars($quiz_title ?? 'Kuis Tidak Ditemukan') ?></h3>
                    <p>ID Soal: <?= $question['qid'] ?></p>
                </div>
                <div class="col-md-4 text-right">
                    <div class="btn-group">
                        <a href="edit_quiz.php?eid=<?= $eid ?>" class="btn btn-default" style="background:white; color:#333;">
                            <i class="glyphicon glyphicon-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Edit Soal -->
        <div class="panel" style="background:white; border-radius:10px; padding:30px; box-shadow:0 2px 6px rgba(0,0,0,0.2);">
            <form method="POST" action="">
                <input type="hidden" name="update_question" value="1">
                
                <div class="question-card">
                    <!-- Input Skor Nilai -->
                    <div class="form-group">
                        <label><b>Skor Nilai untuk Soal Ini</b></label>
                        <div class="input-group">
                            <span class="input-group-addon" style="background:#9b59b6; color:white; border:none;">
                                <i class="fas fa-star"></i> Poin
                            </span>
                            <input type="number" name="sn" class="form-control" 
                                   value="<?= $question['sn'] ?>" min="1" max="100" required>
                        </div>
                    </div>

                    <!-- Pertanyaan -->
                    <div class="form-group">
                        <label><b>Pertanyaan</b></label>
                        <textarea rows="4" name="qns" class="form-control" required><?= htmlspecialchars($question['qns']) ?></textarea>
                    </div>

                    <div class="row">
                        <!-- Opsi A -->
                        <div class="form-group col-md-6">
                            <label style="color:#e74c3c;"><b>Opsi A</b></label>
                            <div class="input-group">
                                <span class="input-group-addon" style="background:#e74c3c; color:white; border:none;">A</span>
                                <input name="optionA" value="<?= htmlspecialchars($question['optionA']) ?>" class="form-control" type="text" required>
                            </div>
                        </div>

                        <!-- Opsi B -->
                        <div class="form-group col-md-6">
                            <label style="color:#3498db;"><b>Opsi B</b></label>
                            <div class="input-group">
                                <span class="input-group-addon" style="background:#3498db; color:white; border:none;">B</span>
                                <input name="optionB" value="<?= htmlspecialchars($question['optionB']) ?>" class="form-control" type="text" required>
                            </div>
                        </div>

                        <!-- Opsi C -->
                        <div class="form-group col-md-6">
                            <label style="color:#2ecc71;"><b>Opsi C</b></label>
                            <div class="input-group">
                                <span class="input-group-addon" style="background:#2ecc71; color:white; border:none;">C</span>
                                <input name="optionC" value="<?= htmlspecialchars($question['optionC']) ?>" class="form-control" type="text" required>
                            </div>
                        </div>

                        <!-- Opsi D -->
                        <div class="form-group col-md-6">
                            <label style="color:#f39c12;"><b>Opsi D</b></label>
                            <div class="input-group">
                                <span class="input-group-addon" style="background:#f39c12; color:white; border:none;">D</span>
                                <input name="optionD" value="<?= htmlspecialchars($question['optionD']) ?>" class="form-control" type="text" required>
                            </div>
                        </div>
                    </div>

                    <!-- Jawaban Benar -->
                    <div class="form-group">
                        <label><b>Jawaban Benar</b></label>
                        <select name="answer" class="form-control" style="font-weight:600;" required>
                            <option value="">Pilih jawaban yang benar</option>
                            <option value="a" style="color:#e74c3c;" <?= $question['answer'] == 'a' ? 'selected' : '' ?>>✅ Opsi A</option>
                            <option value="b" style="color:#3498db;" <?= $question['answer'] == 'b' ? 'selected' : '' ?>>✅ Opsi B</option>
                            <option value="c" style="color:#2ecc71;" <?= $question['answer'] == 'c' ? 'selected' : '' ?>>✅ Opsi C</option>
                            <option value="d" style="color:#f39c12;" <?= $question['answer'] == 'd' ? 'selected' : '' ?>>✅ Opsi D</option>
                        </select>
                    </div>
                </div>

                <div class="form-group text-center" style="margin-top:30px; padding-top:20px; border-top:2px dashed #ddd;">
                    <div class="alert alert-warning">
                        <strong>Perhatian:</strong> Pastikan semua data sudah benar sebelum menyimpan.
                    </div>
                    <button type="submit" class="btn btn-success btn-lg" style="padding:10px 30px; font-size:15px; margin-right:5px;  border:1px solid #000;">
                        <i class="fas fa-save"></i> Simpan Perubahan
                    </button>
                    <a href="edit_quiz.php?eid=<?= $eid ?>" class="btn btn-default btn-lg" style="padding:10px 30px; font-size:15px; margin-right:5px;  border:1px solid #000;">
                        <i class="fas fa-times"></i> Batal
                    </a>
                    <button type="button" class="btn btn-danger btn-lg" style="padding:10px 30px; font-size:15px; margin-right:5px;  border:1px solid #000;" 
                            onclick="confirmDeleteQuestion('<?= $question['qid'] ?>')">
                        <i class="fas fa-trash"></i> Hapus Soal
                    </button>
                </div>
            </form>
        </div>
    </div>
            </form>
        </div>
    </div>
</div>

<!-- JavaScript -->
<script>
function confirmDeleteQuestion(qid) {
    if(confirm('Apakah Anda yakin ingin menghapus soal ini?\nTindakan ini tidak dapat dibatalkan!')) {
        window.location.href = 'update.php?q=delete_question&qid=' + qid + '&eid=<?= $eid ?>';
    }
}
</script>

</body>
</html>