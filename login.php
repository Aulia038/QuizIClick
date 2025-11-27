<?php
session_start();
if(isset($_SESSION["email"])){
    session_destroy();
}
include_once 'dbConnection.php';
$ref=@$_GET['q'];
$email = $_POST['email'];
$password = $_POST['password'];

$email = stripslashes($email);
$email = addslashes($email);
$password = stripslashes($password); 
$password = addslashes($password);
$password=md5($password); 

$result = mysqli_query($con,"SELECT name FROM user WHERE email = '$email' and password = '$password'") or die('Error');
$count=mysqli_num_rows($result);

if($count==1){
    while($row = mysqli_fetch_array($result)) {
        $name = $row['name'];
    }
    
    // === PERBAIKAN: SET SESSION SISWA YANG BARU ===
    $_SESSION["siswa_email"] = $email;
    $_SESSION["siswa_name"] = $name;
    $_SESSION["role"] = 'siswa';
    
    // Backup compatibility (sementara)
    $_SESSION["email"] = $email;
    $_SESSION["name"] = $name;
    
    header("location:account.php");
    exit();
}
else
header("location:$ref?w=Login gagal! Silakan cek kembali email dan password Anda.");
?>