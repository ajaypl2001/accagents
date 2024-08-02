<!DOCTYPE html>
<?php 
 ob_start();
 if(!isset($_SESSION)){
	 session_start();
 }
include("../../root_element/db.php");
?>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../../css/bootstrap.min.css">
  <script src="../../js/jquery.min.js"></script>
  <script src="../../js/bootstrap.min.js"></script>
  <link rel="stylesheet" type="text/css" href="../../css/stylesheet.css">
  <!--link rel="stylesheet" href="../css/all.css" -->
 <?php 
	$get_title_url = $_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
	if($get_title_url == "localhost/aol/backend/dashboard/index.php"){
		echo "<title>";
		echo "Dashboard | Avalon Community College";
		echo "</title>";
	}
	elseif($get_title_url == "localhost/aol/backend/login/index.php"){
		echo "<title>";
		echo "Login | Avalon Community College";
		echo "</title>";
	}else{
		echo "<title>";
		echo "Avalon Community College";
		echo "</title>";
	}
?>		
</head>