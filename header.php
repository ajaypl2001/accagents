<!DOCTYPE html>
<?php 
 ob_start();
 if(!isset($_SESSION)){
	 session_start();
 }
include("db.php");
?>
<?php
$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
?>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <script src="../js/jquery.min.js"></script>
  <script src="../js/bootstrap.min.js"></script>
  <link rel="stylesheet" type="text/css" href="../css/stylesheet.css">
  <link rel="stylesheet" type="text/css" href="../css/fontawesome-all.css">
    <script src="../js/popper.min.js"></script>
	<script src="../js/bootstrap-4-hover-navbar.js"></script>
	<!-- <link href="../css/style-sheet.css" rel="stylesheet" type="text/css" /> -->
<link rel="stylesheet" href="../css/responsive.css" type="text/css" media="screen"/>
 <link rel="icon" href="https://avaloncommunitycollege.ca/img/favicon.png">
  <!--link rel="stylesheet" href="../css/all.css" -->
 <?php 
	$get_title_url = $_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
	if($get_title_url == "<?php echo $protocol;?>aoltorontoagents.ca/application/index.php"){
		echo "<title>";
		echo "Applications | Avalon Community College";
		echo "</title>";
	}
	elseif($get_title_url == "<?php echo $protocol;?>aoltorontoagents.ca/login/index.php"){
		echo "<title>";
		echo "Login | Avalon Community College ";
		echo "</title>";
	}else{
		echo "<title>";
		echo "Avalon Community College";
		echo "</title>";
	}
?>		
</head>
<body>