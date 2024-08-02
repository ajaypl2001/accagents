<?php 
ob_start();
session_start();
unset($_SESSION['sno']);
unset($_SESSION['email']);
unset($_SESSION['password']);
session_destroy();
header("Location: login");
exit;
?>