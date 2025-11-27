<?php 
session_start();
if(isset($_SESSION['email_guru'])){
    session_destroy();
}
$ref = @$_GET['q'];
header("location:" . ($ref ? $ref : "index.php"));
?>