<?php 
ob_start();
session_start();
unset($_SESSION['sno']);
session_destroy();
header("Location: ../login");
exit;
?>