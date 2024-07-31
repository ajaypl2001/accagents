<?php 
ob_start();
session_start();
// unset($_SESSION['id']);
unset($_SESSION['sno']);
unset($_SESSION['email']);
unset($_SESSION['password']);
unset($_SESSION['agentPostiveResponseAOL']);
session_destroy();
header("Location: login"); 
exit;
?>