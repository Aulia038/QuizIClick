<?php
// edit_quiz_guru.php
session_start();
include_once 'dbConnection.php';

// Prevent caching
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

// Validasi session guru
if (!isset($_SESSION['id_guru'])) {
    header("location:index.php");
    exit();
}

$id_guru = $_SESSION['id_guru'];
$nama_guru = $_SESSION['nama_guru'];
$mapel = $_SESSION['mapel'];

// Ambil eid dari URL
$eid = isset($_GET['eid']) ? mysqli_real_escape_string($con, $_GET['eid']) : '';

if (empty($eid)) {
    header("location:dash_guru.php?q=4&error=ID kuis tidak valid");
    exit();
}

// Ambil data kuis dan pastikan milik guru ini
$quiz_query = mysqli_query($con, "SELECT * FROM quiz WHERE eid='$eid' AND id_guru='$id_guru'");
if (mysqli_num_rows($quiz_query) == 0) {
    header("location:dash_guru.php?q=4&error=Kuis tidak ditemukan atau bukan milik Anda");
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
                    WHERE eid = '$eid' AND id_guru = '$id_guru'";
    
    if (mysqli_query($con, $update_query)) {
        $success_msg = "Kuis berhasil diperbarui!";
        // Refresh data kuis
        $quiz_query = mysqli_query($con, "SELECT * FROM quiz WHERE eid='$eid'");
        $quiz = mysqli_fetch_array($quiz_query);
    } else {
        $error_msg = "Error: " . mysqli_error($con);
    }
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
    <title>Edit Kuis - iClick Guru</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/bootstrap.min.css"/>
    <link rel="stylesheet" href="css/bootstrap-theme.min.css"/>    
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/font1.css">
    <script src="js/jquery.js" type="text/javascript"></script>
    <script src="js/bootstrap.min.js" type="text/javascript"></script>
    
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
        background: #151518;
        color: white;
        padding: 20px 30px;
        border-radius: 10px;
        margin-bottom: 30px;
    } */
        
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
        
        /* .question-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 12px 20px;
            margin: -25px -25px 20px -25px;
            border-radius: 10px 10px 0 0;
        } */
        
        .option-group {
            margin: 15px 0;
        }
        
        .option-label {
            font-weight: 600;
            margin-bottom: 5px;
        }
        
        /* .correct-answer {
            border-left: 4px solid #27ae60;
            background: #d5f4e6;
        } */
    </style>
</head>
<body style="background:#eee;">

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
            </div>
        <?php endif; ?>
        
        <?php if(isset($error_msg)): ?>
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Error!</strong> <?= $error_msg ?>
            </div>
        <?php endif; ?>

        <!-- Header Kuis -->
        <div class="quiz-header">
            <div class="row">
                <div class="col-md-8">
                   <h1 style="color:#000; font-weight:700; font-size:36px; margin-top:20px;">Edit Kuis</h1>
                  <p style="font-size:18px; color:#667085; margin-top:18px;">Halaman ini menampilkan rangkuman lengkap nilai siswa pada kuis yang telah dikerjakan.</p>
                
                  <!-- GRID -->
            <div style="display:flex; gap:25px; flex-wrap:wrap;">
               <!-- WRAPPER UNTUK 3 CARD -->
                <div style="display:flex; gap:20px; flex-wrap:wrap; margin-top:10px;">

            <!-- JUDUL KUIS -->
            <div style="
                flex:1; min-width:190px; background:#151518; padding:20px; position:relative; border:1px solid #27272A; border-radius:8px;">
                <h3 style="margin-top:5px; font-size:16px; font-weight:300; color:#71717A;">Materi Kuis</h3>
                <p style="margin-top:5px; font-size:24px; font-weight:700; color:#fff;">
                    <?= htmlspecialchars($quiz['title']) ?></p>
            </div>
            <!-- ID KUIS -->
            <div style="
                flex:1; min-width:190px;background:#151518; padding:20px; position:relative;border:1px solid #27272A; border-radius:8px;">
                <h3 style="margin-top:5px; font-size:16px; font-weight:300; color:#71717A;">Id Kuis</h3>
                <p style="font-size:18px; font-weight:700;  color:#fff;"><?= $quiz['eid'] ?> </p>
            </div>
            <!-- MAPEL -->
            <div style="
                flex:1; min-width:190px;background:#151518; padding:20px; position:relative; border:1px solid #27272A; border-radius:8px;">
                <h3 style="margin-top:5px; font-size:16px; font-weight:300; color:#71717A;">Mata Pelajaran</h3>
                <p style="font-size:24px; font-weight:700;  color:#fff;">
                    <?= htmlspecialchars($mapel) ?> </p>
            </div>
        </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Edit Informasi Kuis -->
        <div class="panel" style="background:#151518; color:#fff; border-radius:8px; padding:30px; margin-top:20px; margin-left:-5px;">
            <h3 style="color:#fff; margin-top:1px; margin-bottom:25px; font-size:24px; font-weight:700;">
                <i class="bi bi-info-circle" ></i> Informasi Kuis
            </h3>
            
            <form method="POST" action="">
                <input type="hidden" name="update_quiz" value="1">
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="title" style="font-size:16px; font-weight:300;">Judul Kuis</label>
                            <input type="text" id="title" name="title" class="form-control" 
                                   value="<?= htmlspecialchars($quiz['title']) ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="total" style="font-size:16px; font-weight:300;">Jumlah Soal</label>
                            <input type="number" id="total" name="total" class="form-control" 
                                   value="<?= $quiz['total'] ?>" min="1" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="sahi" style="font-size:16px; font-weight:300;">Nilai per Soal Benar</label>
                            <input type="number" id="sahi" name="sahi" class="form-control" 
                                   value="<?= $quiz['sahi'] ?>" min="1" required>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="wrong" style="font-size:16px; font-weight:300;">Pengurangan Nilai Salah</label>
                            <input type="number" id="wrong" name="wrong" class="form-control" 
                                   value="<?= $quiz['wrong'] ?>" min="0" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="time" style="font-size:16px; font-weight:300;">Batas Waktu (menit)</label>
                            <input type="number" id="time" name="time" class="form-control" 
                                   value="<?= $quiz['time'] ?>" min="1" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="tag" style="font-size:16px; font-weight:300;">Tag</label>
                            <input type="text" id="tag" name="tag" class="form-control" 
                                   value="<?= htmlspecialchars($quiz['tag']) ?>" placeholder="#matematika #ujian">
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="desc" style="font-size:16px; font-weight:300;">Deskripsi Kuis</label>
                    <textarea id="desc" name="desc" class="form-control" rows="4" 
                              placeholder="Deskripsi kuis..."><?= htmlspecialchars($quiz['intro']) ?></textarea>
                </div>
                
                <div class="form-group " style="margin-top:30px; justify-content:flex-end; ">
                    <button type="submit" class="btn btn-success btn-lg" style="margin-right:10px; background:#7C3AED; color:white; padding:10px 22px; border:none;
                border-radius:10px; font-size:16px; font-weight:300; cursor:pointer;">
                        <i class="bi bi-check-circle"></i> Simpan Perubahan
                    </button>
                    <a href="dash_guru.php?q=4" class="btn btn-lg" style="background:none; color:#fff; padding:10px 22px; border:1px solid #27272A;
                border-radius:10px; font-size:16px; font-weight:300; cursor:pointer;
                text-decoration:none; display:inline-block;">
                        <i class="bi bi-arrow-counterclockwise"></i> Batal
                    </a>
                </div>
            </form>
        </div>

        <!-- Form Tambah Soal Baru -->
        <div class="panel" style="background:#151518; color:#fff; border-radius:8px; padding:30px; margin-top:20px; margin-left:-5px;">
            <div class="row" >
                <div class="col-md-8">
                    <h3 style="color:#fff; margin-top:1px; margin-bottom:25px; font-size:24px; font-weight:700;">
                        <i class="bi bi-plus-circle-dotted"></i> Tambah Soal Baru
                    </h3>
                </div>
                <div class="col-md-4 text-right">
                    <button type="button" class="btn btn-info" style="background:none; color:#fff; padding:10px 22px; border:1px solid #27272A;
                border-radius:10px; font-size:16px; font-weight:300; cursor:pointer;
                text-decoration:none; display:inline-block; margin-bottom:5px;" onclick="toggleAddQuestionForm()">
                        <i class="fas fa-plus"></i> Tampilkan/Sembunyikan Form
                    </button>
                </div>
            </div>

            <div id="addQuestionForm" style="display:none; padding:20px; border-radius:8px;">
                <form method="POST" action="">
                    <input type="hidden" name="add_question" value="1">
                    
                    <div class="question-card" style="background:19191B;" >
                        <!-- Input Skor Nilai -->
                        <div class="form-group" style="margin-bottom:15px;">
                            <label style="color:#000; font-weight:600;"><b>Skor Nilai untuk Soal Ini</b></label>
                            <div class="input-group" style="display:flex;">
                                <span style="background:#7C3AED; color:white; border:none; padding:8px 12px; border-radius:5px 0 0 5px; display:flex; align-items:center;">
                                    <i class="bi bi-star"></i> Poin </span>
                                <input type="number" name="sn" class="form-control" 
                                       value="<?= $quiz['sahi'] ?>" min="1" max="100" required 
                                       style="flex:1; padding:8px 12px; border-radius:0 5px 5px 0; border:none;">
                            </div>
                        </div>

                        <!-- Pertanyaan -->
                        <div class="form-group" style="margin-bottom:15px;">
                            <label style="color:#000; font-weight:600;">Pertanyaan</label>
                            <textarea rows="4" name="qns" class="form-control" placeholder="Tulis pertanyaan di sini..." required 
                            style="width:100%; padding:10px; border-radius:5px; border:none; background:#fff; color:white;"></textarea>
                        </div>

                        <div class="row">
                            <!-- Opsi A -->
                            <div class="form-group col-md-6">
                                <label style="color:#000;"><b>Opsi A</b></label>
                                <div class="input-group">
                                    <span class="input-group-addon" style="background:#7C3AED; color:white; border:none;">A</span>
                                    <input name="optionA" placeholder="Masukkan opsi A" class="form-control" type="text" required>
                                </div>
                            </div>

                            <!-- Opsi B -->
                            <div class="form-group col-md-6">
                                <label style="color:#000;"><b>Opsi B</b></label>
                                <div class="input-group">
                                    <span class="input-group-addon" style="background:#7C3AED; color:white; border:none;">B</span>
                                    <input name="optionB" placeholder="Masukkan opsi B" class="form-control" type="text" required>
                                </div>
                            </div>

                            <!-- Opsi C -->
                            <div class="form-group col-md-6">
                                <label style="color:#000;"><b>Opsi C</b></label>
                                <div class="input-group">
                                    <span class="input-group-addon" style="background:#7C3AED; color:white; border:none;">C</span>
                                    <input name="optionC" placeholder="Masukkan opsi C" class="form-control" type="text" required>
                                </div>
                            </div>

                            <!-- Opsi D -->
                            <div class="form-group col-md-6">
                                <label style="color:#000;"><b>Opsi D</b></label>
                                <div class="input-group">
                                    <span class="input-group-addon" style="background:#7C3AED; color:white; border:none;">D</span>
                                    <input name="optionD" placeholder="Masukkan opsi D" class="form-control" type="text" required>
                                </div>
                            </div>
                        </div>

                        <!-- Jawaban Benar -->
                        <div class="form-group">
                            <label style="font-size:16px; font-weight:600; color:#000;">Jawaban Benar</label>
                            <select name="answer" class="form-control" style="font-weight:600;" required>
                                <option value="">Pilih jawaban yang benar</option>
                                <option value="a" style="color:#000;">✅ Opsi A</option>
                                <option value="b" style="color:#000;">✅ Opsi B</option>
                                <option value="c" style="color:#000;">✅ Opsi C</option>
                                <option value="d" style="color:#000;">✅ Opsi D</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group" style="margin-top:30px; justify-content:flex-end;">
                        <button type="submit" class="btn btn-success btn-lg" style="pmargin-right:10px; background:#7C3AED; color:white; padding:10px 22px; border:none;
                        border-radius:10px; font-size:16px; font-weight:300; cursor:pointer;">
                             <i class="bi bi-check-circle"></i> Simpan Soal Baru
                        </button>
                        <button type="button" class="btn btn-lg" style="background:none; color:#fff; padding:10px 22px; border:1px solid #27272A;
                    border-radius:10px; font-size:16px; font-weight:300; cursor:pointer;
                    text-decoration:none; display:inline-block;" onclick="toggleAddQuestionForm()">
                            <i class="bi bi-arrow-counterclockwise"></i> Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Daftar Soal -->
        <div class="panel" style="background:#151518; color:#fff; border-radius:8px; padding:30px; margin-top:20px; margin-left:-5px;">
            <div class="row">
                <div class="col-md-8">
                    <h3 style="color:#fff; margin-top:1px; margin-bottom:25px; font-size:24px; font-weight:700;">
                        <i class="bi bi-card-list"></i> Daftar Soal
                        <span class="badge" style="background: black; margin-left:10px;"><?= $total_questions ?> Soal</span>
                    </h3>
                </div>
            </div>

            <?php if($total_questions > 0): ?>
                <?php 
                $question_num = 1;
                while($question = mysqli_fetch_array($questions_query)): 
                ?>
                    <div class="question-card" style="background:19191B;">
                        <div class="question-header" style="background:19191B;">
                            <h4 style="margin:0; font-weight:600; color:#000;">
                                <i class="fas fa-question" style="color:#000;"></i> Soal <?= $question_num ?>
                                <span class="pull-right" style="color:#000;">
                                    <small>Nilai: <?= $question['sn'] ?> poin</small>
                                </span>
                            </h4>
                        </div>
                        
                        <div class="form-group" style="color:#000;">
                            <label style="color:#000;"><b>Pertanyaan:</b></label>
                            <div style="background:#f8f9fa; padding:15px; border-radius:5px; border-left:4px solid #3498db;">
                                <?= nl2br(htmlspecialchars($question['qns'])) ?>
                            </div>
                        </div>

                        <div class="row">
                            <?php
                            $options = [
                                'a' => ['text' => $question['optionA'], 'color' => '#000'],
                                'b' => ['text' => $question['optionB'], 'color' => '#000'],
                                'c' => ['text' => $question['optionC'], 'color' => '#000'],
                                'd' => ['text' => $question['optionD'], 'color' => '#000']
                            ];
                            
                            foreach($options as $key => $option):
                                $is_correct = ($question['answer'] == $key);
                            ?>
                                <div class="col-md-6">
                                    <div class="option-group <?= $is_correct ? 'correct-answer' : '' ?>">
                                        <div class="option-label" style="color:<?= $option['color'] ?>;">
                                            <i class="bi bi-circle"></i> Opsi <?= strtoupper($key) ?>
                                            <?php if($is_correct): ?>
                                                <span class="badge" style="background:#7C3AED; margin-left:10px;">
                                                    <i class="bi bi-check-lg"></i> Benar
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                        <div style="padding:10px; background:white; color:#000; border-radius:5px; border:1px solid #ddd;">
                                            <?= htmlspecialchars($option['text']) ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <div class="text-right" style="margin-top:30px; justify-content:flex-end;">
                            <a href="edit_question_guru.php?qid=<?= $question['qid'] ?>" class="btn btn-sm" style="margin-right:10px; background:#7C3AED; color:white; padding:10px 22px; border:none;
                border-radius:10px; font-size:16px; font-weight:300; cursor:pointer;">
                                <i class="bi bi-pencil-square"></i> Edit Soal
                            </a>
                            <button type="button" class="btn btn-sm" style="margin-right:10px; background:#7C3AED; color:white; padding:10px 22px; border:none;
                border-radius:10px; font-size:16px; font-weight:300; cursor:pointer;"
                                    onclick="confirmDeleteQuestion('<?= $question['qid'] ?>', 'Soal <?= $question_num ?>')">
                                <i class="bi bi-trash"></i> Hapus
                            </button>
                        </div>
                    </div>
                <?php 
                $question_num++;
                endwhile; 
                ?>
            <?php else: ?>
                <div class="alert alert-info text-center" style="margin:20px; background:linear-gradient(135deg, #222, #444)">
                    <i class="fas fa-info-circle fa-3x mb-3" style="color:white"></i>
                    <h4 style="color:white">Belum ada soal</h4>
                    <p style="color:white; margin-bottom:10px">Tambahkan soal pertama untuk kuis ini</p>
                    <a href="add_questions_guru.php?eid=<?= $eid ?>" class="btn btn-primary" style="background:white; color:black">
                        <i class="fas fa-plus"></i> Tambah Soal Pertama
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- JavaScript -->
<script>
function toggleAddQuestionForm() {
    const form = document.getElementById('addQuestionForm');
    if (form.style.display === 'none') {
        form.style.display = 'block';
    } else {
        form.style.display = 'none';
    }
}

function confirmDeleteQuestion(qid, questionText) {
    if(confirm('Apakah Anda yakin ingin menghapus ' + questionText + '?\nTindakan ini tidak dapat dibatalkan!')) {
        window.location.href = 'update_guru.php?q=delete_question&qid=' + qid + '&eid=<?= $eid ?>';
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

</body>
</html>