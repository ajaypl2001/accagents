<!DOCTYPE html>
<?php 
 ob_start();
 if(!isset($_SESSION)){
	   session_start();
 }
include("db.php");
date_default_timezone_set("America/Vancouver");
$date_at_hdr = date('Y-m-d');
$date_at22_hdr = strtotime($date_at_hdr);
$getMonthYear_hdr = date('Y-m');

include("logout_session.php");
if(isset($_SESSION['sno']) && !empty($_SESSION['sno'])){
	$loggedId = $_SESSION['sno'];
	$qryGet = "SELECT * FROM m_teacher WHERE sno='$loggedId' AND status='1'";
	$results = mysqli_query($conInt, $qryGet);
	$rows = mysqli_fetch_assoc($results);
	$snoid = $rows['sno'];
	$name = $rows['name'];
	$roles1 = $rows['role'];
	$username = $rows['username'];
	$emp_code = $rows['emp_code'];
	$payroll_type_lgd = $rows['payroll_type'];
	$vacation_leave_lgd = '';
	$personal_leave_lgd = $rows['personal_leave'];
	$sick_day_hrs_lgd = $rows['sick_day_hrs'];
	
	$showMonthStart_HDR = '';
	$dssad_hdr = "SELECT start_date FROM `m_bi_weekly_start_date` where (start_date LIKE '%$getMonthYear_hdr%')";
	$login_hdr = mysqli_query($conInt, $dssad_hdr);
	while($row_hdr = mysqli_fetch_array($login_hdr)){
		$row2_hdr[] = $row_hdr['start_date'];
	}
	if(!empty($row2_hdr[0])){
		$getStartDate1_HDR = strtotime($row2_hdr[0]);
		$endDate_HDR = strtotime($row2_hdr[0].'+13 days');
	}else{
		$getStartDate1_HDR = '';
		$endDate_HDR = '';
	}
	
	if(!empty($row2_hdr[1])){
		$getStartDate2_HDR = strtotime($row2_hdr[1]);
		$endDate2_HDR = strtotime($row2_hdr[1].'+13 days');
	}else{
		$getStartDate2_HDR = '';
		$endDate2_HDR = '';
	}

	if(!empty($row2_hdr[2])){
		$getStartDate3_HDR = strtotime($row2_hdr[2]);
		$endDate3_HDR = strtotime($row2_hdr[2].'+13 days');
	}else{	
		$getStartDate3_HDR = '';
		$endDate3_HDR ='';
	}

	if($getStartDate1_HDR >= $date_at22_hdr || $date_at22_hdr <= $endDate_HDR){
		$showMonthStart_HDR = $row2_hdr[0];
		// $showMonthStart_HDR = date('d M, Y', $getStartDate1_HDR);
		// $showMonthEnd_HDR = date('d M, Y', $endDate_HDR);
		// $getBiWeekly_HDR = $showMonthStart_HDR.' to '.$showMonthEnd_HDR;
	}elseif($getStartDate2_HDR >= $date_at22_hdr || $date_at22_hdr <= $endDate2_HDR){
		$showMonthStart_HDR = $row2_hdr[1];
		// $showMonthStart_HDR = date('d M, Y', $getStartDate2_HDR);
		// $showMonthEnd_HDR = date('d M, Y', $endDate2_HDR);
		// $getBiWeekly_HDR = $showMonthStart_HDR.' to '.$showMonthEnd_HDR;
	}elseif($getStartDate3_HDR >= $date_at22_hdr || $date_at22_hdr <= $endDate3_HDR){
		$showMonthStart_HDR = $row2_hdr[2];
		// $showMonthStart_HDR = date('d M, Y', $getStartDate3_HDR);
		// $showMonthEnd_HDR = date('d M, Y', $endDate3_HDR);
		// $getBiWeekly_HDR = $showMonthStart_HDR.' to '.$showMonthEnd_HDR;
	}
	
}else{
	// header("Location: localhost/accagents/login/index.php");
    exit();
}
$encriptDiv = base64_encode('OverAllEAttendance');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Granville College Attendence - Lists</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="stylesheet" href="../css/all.min.css">
	<link href="../css/bootstrap.min.css" rel="stylesheet">
	<script src="../js/bootstrap.bundle.min.js"></script>
	<link rel="stylesheet" href="../css/style.css">
	<script src="../js/jquery.min.js"></script>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

	<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&display=swap" rel="stylesheet">
	</head>
<body>
<section class="section bg-white shadow align-items-center themeBgImage d-flex active" id="home">
<div class="container-fluid"> 
<div class="bg-overlay">

<nav class="navbar navbar-expand-lg">
 
    <a class="navbar-brand" href="javascript:void(0)">
		<img src="../images/Granville-logo.webp" width="100" alt="Granville-logo">
	</a>
    <button class="navbar-toggler border" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
      <span class="navbar-toggler-icon mb-0 pb-0 text-dark"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="mynavbar">
      <ul class="navbar-nav">
	<?php if($roles1 == 'Teacher'){ ?>		
		<li class="nav-item">
		  <a class="nav-link" href="localhost/accagents/attendence/lists/module_start_end_add.php?<?php echo $encriptDiv;?>">Module Dates</a>
		</li>
		<li class="nav-item">
		  <a class="nav-link" href="localhost/accagents/attendence/lists/module_wise_attendence_new.php?<?php echo $encriptDiv;?>">Mark Attendence</a>
		</li>
		
		<li class=" dropdown dropdown-menu-end">
		  <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#">Reports</a>
		  <ul class="dropdown-menu">
			<li><a class="dropdown-item" href="localhost/accagents/attendence/lists/report.php?<?php echo $encriptDiv;?>">Attendence Reports</a></li>
			<li><a class="dropdown-item" href="localhost/accagents/attendence/lists/module_wise_report_new.php?<?php echo $encriptDiv;?>">Module Wise Reports</a></li>
		  </ul>
		</li>		
		
		<li class="nav-item">
		  <a class="nav-link" href="localhost/accagents/attendence/lists/students.php?<?php echo $encriptDiv;?>">Student Lists</a>
		</li>
		<li class="nav-item">
		  <a class="nav-link text-success" href="localhost/accagents/attendence/empDiv/OTLists.php?<?php echo $encriptDiv;?>"><b>My Attendence</b></a>
		</li>
	<?php }else{ ?>
		<li class="nav-item">
		  <a class="nav-link text-success" href="localhost/accagents/attendence/empDiv/OTLists.php?<?php echo $encriptDiv;?>"><b>My Attendence</b></a>
		</li>
		
		<!--li class="nav-item">
		  <a class="nav-link" href="https://granville-college.com/attendence/empDiv/leaveList.php?<?php //echo $encriptDiv;?>">Emp Leave Demo</a>
		</li-->
		
		<!--li class="nav-item">
		  <a class="nav-link" href="https://granville-college.com/attendence/empDiv/leave_requests.php?<?php //echo $encriptDiv;?>">Emp Leave</a>
		</li-->
	<?php } ?>
        <li class="nav-item">
		  <a class="nav-link" href="localhost/accagents/attendence/logout.php" title="Logout">Logout(<?php echo $name;?>)</a>
	    </li> 
      </ul>
 
  </div>
</nav>

</div>
</section>

<style>
.dropdown-menu { box-shadow:0px 0px 15px #333;
}
.dropdown-menu li a { border-bottom:1px solid #ccc;transition:2s;} 
/* stroke */
.navbar-nav li a{
  position: relative;
}
.navbar-nav li a:before {
  position: absolute;
  bottom: 0;
  left: 0;
  right: 0;
  margin: auto;
  width: 0%;
  content: '.'; opacity: 0;
  color: transparent;
  background: #4a8035;
  height: 2px;
}
.navbar-nav li a.active:hover:before,
.navbar-nav li a:hover:before {
  width: 100%;opacity: 1;
}.navbar-nav li a:before{
  transition: all .5s;
}

.dropdown-item.active, .dropdown-item:active { background-color: #39803d;
}
</style>