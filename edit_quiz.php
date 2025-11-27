<?php
// edit_quiz.php
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

// Ambil data kuis berdasarkan eid
$eid = isset($_GET['eid']) ? mysqli_real_escape_string($con, $_GET['eid']) : '';

if (empty($eid)) {
    header("location:dash.php?q=5&error=ID kuis tidak valid");
    exit();
}

// Ambil data kuis
$quiz_query = mysqli_query($con, "SELECT * FROM quiz WHERE eid='$eid'");
if (mysqli_num_rows($quiz_query) == 0) {
    header("location:dash.php?q=5&error=Kuis tidak ditemukan");
    exit();
}

$quiz = mysqli_fetch_array($quiz_query);

// Handle form submission untuk tambah soal BARU
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_question'])) {
    $qns = mysqli_real_escape_string($con, $_POST['qns']);
    $optionA = mysqli_real_escape_string($con, $_POST['optionA']);
    $optionB = mysqli_real_escape_string($con, $_POST['optionB']);
    $optionC = mysqli_real_escape_string($con, $_POST['optionC']);
    $optionD = mysqli_real_escape_string($con, $_POST['optionD']);
    $answer = mysqli_real_escape_string($con, $_POST['answer']);
    $sn = (int)$_POST['sn'];
    
    $qid = uniqid();
    
    $insert_query = "INSERT INTO questions 
                    (qid, eid, qns, optionA, optionB, optionC, optionD, answer, sn) 
                    VALUES 
                    ('$qid', '$eid', '$qns', '$optionA', '$optionB', '$optionC', '$optionD', '$answer', '$sn')";
    
    if (mysqli_query($con, $insert_query)) {
        $success_msg = "Soal berhasil ditambahkan!";
        // Refresh data questions
        $questions_query = mysqli_query($con, "SELECT * FROM questions WHERE eid='$eid' ORDER BY qid");
        $total_questions = mysqli_num_rows($questions_query);
    } else {
        $error_msg = "Error menambah soal: " . mysqli_error($con);
    }
}

// Handle form submission untuk update kuis
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_quiz'])) {
    $title = mysqli_real_escape_string($con, $_POST['title']);
    $total = (int)$_POST['total'];
    $sahi = (int)$_POST['sahi'];
    $wrong = (int)$_POST['wrong'];
    $time = (int)$_POST['time'];
    $tag = mysqli_real_escape_string($con, $_POST['tag']);
    $desc = mysqli_real_escape_string($con, $_POST['desc']);
    
    // Update data kuis
    $update_query = "UPDATE quiz SET 
                    title = '$title',
                    total = '$total',
                    sahi = '$sahi',
                    wrong = '$wrong',
                    time = '$time',
                    tag = '$tag',
                    intro = '$desc',
                    date = NOW()
                    WHERE eid = '$eid'";
    
    if (mysqli_query($con, $update_query)) {
        $success_msg = "Kuis berhasil diperbarui!";
    } else {
        $error_msg = "Error: " . mysqli_error($con);
    }
    
    // Refresh data kuis
    $quiz_query = mysqli_query($con, "SELECT * FROM quiz WHERE eid='$eid'");
    $quiz = mysqli_fetch_array($quiz_query);
}

// Ambil data soal untuk kuis ini
$questions_query = mysqli_query($con, "SELECT * FROM questions WHERE eid='$eid' ORDER BY qid");
$total_questions = mysqli_num_rows($questions_query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kuis - iClick</title>
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
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
            transition: all 0.3s ease;
        }
        
        .question-card:hover {
            border-color: #3498db;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        
        .question-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 12px 20px;
            margin: -25px -25px 20px -25px;
            border-radius: 10px 10px 0 0;
        }
        
        .option-group {
            margin: 15px 0;
        }
        
        .option-label {
            font-weight: 600;
            margin-bottom: 5px;
        }
        
        .correct-answer {
            border-left: 4px solid #27ae60;
            background: #d5f4e6;
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
        <span style="color:#ffb300">Edit Kuis</span>
    </div>
    <div style="display: flex; align-items: center; gap: 10px;">
        <!-- <span style="color:#ffb300" class="glyphicon glyphicon-user"></span>
        <span style="color:#ffb300">Halo,</span>
        <a href="dash.php" style="color:#ffb300; text-decoration:none; font-weight:600;">
            <?= htmlspecialchars($name) ?> -->
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
            <a href="dash.php?q=0" style="display:block; padding:12px 20px; color:white; text-decoration:none;">
                <span class="glyphicon glyphicon-home"></span>&nbsp; Dashboard
            </a>
        </li>
        <li>
            <a href="dash.php?q=5" style="display:block; padding:12px 20px; color:white; text-decoration:none;">
                <span class="glyphicon glyphicon-arrow-left"></span>&nbsp; Kembali
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
            </div>
        <?php endif; ?>
        
        <?php if(isset($error_msg)): ?>
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Error!</strong> <?= $error_msg ?>
            </div>
        <?php endif; ?>

        <!-- Header Kuis -->
        <div class="quiz-header" style= "background:linear-gradient(135deg, #222, #444)">
            <div class="row">
                <div class="col-md-8">
                    <h1><i class="fas fa-edit"></i> Edit Kuis</h1>
                    <h3><?= htmlspecialchars($quiz['title']) ?></h3>
                    <p>ID Kuis: <?= $quiz['eid'] ?></p>
                </div>
                <div class="col-md-4 text-right">
                    <div class="btn-group">
                        <a href="dash.php?q=5" class="btn btn-default" style="background:white; color:#333;">
                            <i class="glyphicon glyphicon-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Edit Informasi Kuis -->
        <div class="panel" style="background:white; border-radius:10px; padding:30px; box-shadow:0 2px 6px rgba(0,0,0,0.2); margin-bottom:30px;">
            <h3 style="color:#333; border-bottom:2px solid black; padding-bottom:15px; margin-bottom:25px;">
                <i class="fas fa-info-circle"></i> Informasi Kuis
            </h3>
            
            <form method="POST" action="">
                <input type="hidden" name="update_quiz" value="1">
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="title"><b>Judul Kuis</b></label>
                            <input type="text" id="title" name="title" class="form-control" 
                                   value="<?= htmlspecialchars($quiz['title']) ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="total"><b>Jumlah Soal</b></label>
                            <input type="number" id="total" name="total" class="form-control" 
                                   value="<?= $quiz['total'] ?>" min="1" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="sahi"><b>Nilai per Soal Benar</b></label>
                            <input type="number" id="sahi" name="sahi" class="form-control" 
                                   value="<?= $quiz['sahi'] ?>" min="1" required>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="wrong"><b>Pengurangan Nilai Salah</b></label>
                            <input type="number" id="wrong" name="wrong" class="form-control" 
                                   value="<?= $quiz['wrong'] ?>" min="0" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="time"><b>Batas Waktu (menit)</b></label>
                            <input type="number" id="time" name="time" class="form-control" 
                                   value="<?= $quiz['time'] ?>" min="1" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="tag"><b>Tag</b></label>
                            <input type="text" id="tag" name="tag" class="form-control" 
                                   value="<?= htmlspecialchars($quiz['tag']) ?>" placeholder="#matematika #ujian">
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="desc"><b>Deskripsi Kuis</b></label>
                    <textarea id="desc" name="desc" class="form-control" rows="4" 
                              placeholder="Deskripsi kuis..."><?= htmlspecialchars($quiz['intro']) ?></textarea>
                </div>
                
                <div class="form-group text-center" style="margin-top:30px;">
                    <button type="submit" class="btn btn-success btn-lg" style="padding:10px 30px; font-size:15px; margin-right:5px;  border:1px solid #000;">
                        <i class="fas fa-save"></i> Simpan Perubahan
                    </button>
                    <a href="dash.php?q=5" class="btn btn-default btn-lg" style="padding:10px 30px; font-size:15px; margin-left:5px;  border:1px solid #000;">
                        <i class="fas fa-times"></i> Batal
                    </a>
                </div>
            </form>
        </div>

        <!-- Form Tambah Soal Baru -->
        <div class="panel" style="background:white; border-radius:10px; padding:30px; box-shadow:0 2px 6px rgba(0,0,0,0.2); margin-bottom:30px;">
            <div class="row">
                <div class="col-md-8">
                    <h3 style="color:#333; border-bottom:2px solid black; padding-bottom:15px; margin-bottom:25px;">
                        <i class="fas fa-plus-circle"></i> Tambah Soal Baru
                    </h3>
                </div>
                <div class="col-md-4 text-right">
                    <button type="button" class="btn btn-info" style="background:black; color:#ffb300;" onclick="toggleAddQuestionForm()">
                        <i class="fas fa-plus"></i> Tampilkan/Sembunyikan Form
                    </button>
                </div>
            </div>

            <div id="addQuestionForm" style="display:none;">
                <form method="POST" action="">
                    <input type="hidden" name="add_question" value="1">
                    
                    <div class="question-card">
                        <!-- Input Skor Nilai -->
                        <div class="form-group">
                            <label><b>Skor Nilai untuk Soal Ini</b></label>
                            <div class="input-group">
                                <span class="input-group-addon" style="background:#9b59b6; color:white; border:none;">
                                    <i class="fas fa-star"></i> Poin
                                </span>
                                <input type="number" name="sn" class="form-control" 
                                       value="<?= $quiz['sahi'] ?>" min="1" max="100" required>
                            </div>
                        </div>

                        <!-- Pertanyaan -->
                        <div class="form-group">
                            <label><b>Pertanyaan</b></label>
                            <textarea rows="4" name="qns" class="form-control" placeholder="Tulis pertanyaan di sini..." required></textarea>
                        </div>

                        <div class="row">
                            <!-- Opsi A -->
                            <div class="form-group col-md-6">
                                <label style="color:#e74c3c;"><b>Opsi A</b></label>
                                <div class="input-group">
                                    <span class="input-group-addon" style="background:#e74c3c; color:white; border:none;">A</span>
                                    <input name="optionA" placeholder="Masukkan opsi A" class="form-control" type="text" required>
                                </div>
                            </div>

                            <!-- Opsi B -->
                            <div class="form-group col-md-6">
                                <label style="color:#3498db;"><b>Opsi B</b></label>
                                <div class="input-group">
                                    <span class="input-group-addon" style="background:#3498db; color:white; border:none;">B</span>
                                    <input name="optionB" placeholder="Masukkan opsi B" class="form-control" type="text" required>
                                </div>
                            </div>

                            <!-- Opsi C -->
                            <div class="form-group col-md-6">
                                <label style="color:#2ecc71;"><b>Opsi C</b></label>
                                <div class="input-group">
                                    <span class="input-group-addon" style="background:#2ecc71; color:white; border:none;">C</span>
                                    <input name="optionC" placeholder="Masukkan opsi C" class="form-control" type="text" required>
                                </div>
                            </div>

                            <!-- Opsi D -->
                            <div class="form-group col-md-6">
                                <label style="color:#f39c12;"><b>Opsi D</b></label>
                                <div class="input-group">
                                    <span class="input-group-addon" style="background:#f39c12; color:white; border:none;">D</span>
                                    <input name="optionD" placeholder="Masukkan opsi D" class="form-control" type="text" required>
                                </div>
                            </div>
                        </div>

                        <!-- Jawaban Benar -->
                        <div class="form-group">
                            <label><b>Jawaban Benar</b></label>
                            <select name="answer" class="form-control" style="font-weight:600;" required>
                                <option value="">Pilih jawaban yang benar</option>
                                <option value="a" style="color:#e74c3c;">✅ Opsi A</option>
                                <option value="b" style="color:#3498db;">✅ Opsi B</option>
                                <option value="c" style="color:#2ecc71;">✅ Opsi C</option>
                                <option value="d" style="color:#f39c12;">✅ Opsi D</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group text-center" style="margin-top:20px;">
                        <button type="submit" class="btn btn-success btn-lg"  style="padding:10px 30px; font-size:15px; margin-right:5px;  border:1px solid #000;">
                            <i class="fas fa-save"></i> Simpan Soal Baru
                        </button>
                        <button type="button" class="btn btn-default btn-lg"  style="padding:10px 30px; font-size:15px; margin-left:5px;  border:1px solid #000;" onclick="toggleAddQuestionForm()">
                            <i class="fas fa-times"></i> Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Daftar Soal -->
        <div class="panel" style="background:white; border-radius:10px; padding:30px; box-shadow:0 2px 6px rgba(0,0,0,0.2);">
            <div class="row">
                <div class="col-md-8">
                    <h3 style="color:#333; border-bottom:2px solid black; padding-bottom:15px; margin-bottom:25px;">
                        <i class="fas fa-question-circle"></i> Daftar Soal
                        <span class="badge" style="background:#3498db; margin-left:10px;"><?= $total_questions ?> Soal</span>
                    </h3>
                </div>
                <!-- <div class="col-md-4 text-right">
                    <a href="add_questions.php?eid=<?= $eid ?>" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tambah Soal
                    </a>
                </div> -->
            </div>

            <?php if($total_questions > 0): ?>
                <?php 
                $question_num = 1;
                while($question = mysqli_fetch_array($questions_query)): 
                ?>
                    <div class="question-card">
                        <div class="question-header" style="background: linear-gradient(135deg, #222, #444);">
                            <h4 style="margin:0; font-weight:600;">
                                <i class="fas fa-question"></i> Soal <?= $question_num ?>
                                <span class="pull-right">
                                    <small>Nilai: <?= $question['sn'] ?> poin</small>
                                </span>
                            </h4>
                        </div>
                        
                        <div class="form-group">
                            <label><b>Pertanyaan:</b></label>
                            <div style="background:#f8f9fa; padding:15px; border-radius:5px; border-left:4px solid #3498db;">
                                <?= nl2br(htmlspecialchars($question['qns'])) ?>
                            </div>
                        </div>

                        <div class="row">
                            <?php
                            $options = [
                                'a' => ['text' => $question['optionA'], 'color' => '#e74c3c'],
                                'b' => ['text' => $question['optionB'], 'color' => '#3498db'],
                                'c' => ['text' => $question['optionC'], 'color' => '#2ecc71'],
                                'd' => ['text' => $question['optionD'], 'color' => '#f39c12']
                            ];
                            
                            foreach($options as $key => $option):
                                $is_correct = ($question['answer'] == $key);
                            ?>
                                <div class="col-md-6">
                                    <div class="option-group <?= $is_correct ? 'correct-answer' : '' ?>">
                                        <div class="option-label" style="color:<?= $option['color'] ?>;">
                                            <i class="fas fa-circle"></i> Opsi <?= strtoupper($key) ?>
                                            <?php if($is_correct): ?>
                                                <span class="badge" style="background:#27ae60; margin-left:10px;">
                                                    <i class="fas fa-check"></i> Benar
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                        <div style="padding:10px; background:white; border-radius:5px; border:1px solid #ddd;">
                                            <?= htmlspecialchars($option['text']) ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <div class="text-right" style="margin-top:15px;">
                            <a href="edit_question.php?qid=<?= $question['qid'] ?>" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i> Edit Soal
                            </a>
                            <button type="button" class="btn btn-danger btn-sm" 
                                    onclick="confirmDeleteQuestion('<?= $question['qid'] ?>', 'Soal <?= $question_num ?>')">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </div>
                    </div>
                <?php 
                $question_num++;
                endwhile; 
                ?>
            <?php else: ?>
                <div class="alert alert-info text-center" style="margin:20px;">
                    <i class="fas fa-info-circle fa-3x mb-3"></i>
                    <h4>Belum ada soal</h4>
                    <p>Tambahkan soal pertama untuk kuis ini</p>
                    <a href="add_questions.php?eid=<?= $eid ?>" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tambah Soal Pertama
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- JavaScript -->
<script>
function showQuizStats() {
    alert('Fitur statistik kuis akan segera tersedia!');
}

function confirmDeleteQuestion(qid, questionText) {
    if(confirm('Apakah Anda yakin ingin menghapus ' + questionText + '?\nTindakan ini tidak dapat dibatalkan!')) {
        window.location.href = 'update.php?q=delete_question&qid=' + qid + '&eid=<?= $eid ?>';
    }
}

// Hitung total nilai
function calculateTotalScore() {
    const totalQuestions = document.getElementById('total').value;
    const scorePerQuestion = document.getElementById('sahi').value;
    const totalScore = totalQuestions * scorePerQuestion;
    
    document.getElementById('totalScoreDisplay').innerText = totalScore;
}

// Event listeners
document.getElementById('total').addEventListener('input', calculateTotalScore);
document.getElementById('sahi').addEventListener('input', calculateTotalScore);

// Hitung saat load
calculateTotalScore();
</script>

<!-- JavaScript -->
<script>
// ===== TAMBAHKAN FUNGSI INI =====
function toggleAddQuestionForm() {
    const form = document.getElementById('addQuestionForm');
    if (form.style.display === 'none') {
        form.style.display = 'block';
    } else {
        form.style.display = 'none';
    }
}
// ===== END OF TAMBAHAN =====

function showQuizStats() {
    alert('Fitur statistik kuis akan segera tersedia!');
}

function confirmDeleteQuestion(qid, questionText) {
    if(confirm('Apakah Anda yakin ingin menghapus ' + questionText + '?\nTindakan ini tidak dapat dibatalkan!')) {
        window.location.href = 'update.php?q=delete_question&qid=' + qid + '&eid=<?= $eid ?>';
    }
}

// ... kode JavaScript existing lainnya ...
</script>

</body>
</html>