<!DOCTYPE html>
<?php 
// header("Location: https://avaloncommunitycollege.com/portal/login/");
// exit;
 ob_start();
 if(!isset($_SESSION)){
	 session_start();
 }
include("db.php");
include("logout_session.php");

if(isset($_SESSION['sno']) && !empty($_SESSION['sno'])){
$sessionid1 = $_SESSION['sno'];
$results = mysqli_query($con,"SELECT * FROM allusers WHERE sno = '$sessionid1'");
	$rows = mysqli_fetch_assoc($results);	
	$headid = mysqli_real_escape_string($con, $rows['sno']);
	$email2323 = mysqli_real_escape_string($con, $rows['email']);
	$username = mysqli_real_escape_string($con, $rows['username']);
	$roles1 = mysqli_real_escape_string($con, $rows['role']);
	$activated = mysqli_real_escape_string($con, $rows['verifystatus']);
	$report_allow = mysqli_real_escape_string($con, $rows['report_allow']);
	$loa_allow = mysqli_real_escape_string($con, $rows['loa_allow']);
	$createLogin = mysqli_real_escape_string($con, $rows['create_login']);
	$status2 = mysqli_real_escape_string($con, $rows['status2']);
	$contact_person = mysqli_real_escape_string($con, $rows['contact_person']);
	$notify_per = mysqli_real_escape_string($con, $rows['notify_per']);
	$cmsn_login = mysqli_real_escape_string($con, $rows['cmsn_login']);

	$getreslt = mysqli_query($con,"SELECT application_form FROM st_application WHERE user_id = '$headid' AND app_by='Student'");
	if(mysqli_num_rows($getreslt)){
		$rowssd = mysqli_fetch_assoc($getreslt);
		$applicationForm = mysqli_real_escape_string($con, $rowssd['application_form']);
	}else{
		$applicationForm = '';
	}
}else{
	$headid = '';
	$applicationForm = '';
	$roles1 = '';
	$email2323 = '';
	$username = '';
	$activated = '';
	$report_allow = '';
	$loa_allow = '';
	$createLogin = '';
	$status2 = '';
}

if($email2323 == 'operation@aol'){
	$agent_id_not_show = "AND user_id NOT IN ('1136')";
	$agent_user_table = "AND sno NOT IN ('1136')";
}else{
	$agent_id_not_show = '';
	$agent_user_table = '';
}

$rsltSalesQuery = "SELECT admin_id FROM `admin_access` where admin_id='$sessionid1'";
$qurySales = mysqli_query($con, $rsltSalesQuery);
$salesNum = mysqli_num_rows($qurySales);

$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

$curPageName = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);  
$date_at = date('Y-m-d');
$time_at = date('H:i:s');

$trackQuery = "INSERT INTO `tracking_report`(`login_username`, `name`, `url`, `page`,`date_at`,`time_at`) VALUES ('$email2323','$username','$url','$curPageName','$date_at','$time_at')";
mysqli_query($con, $trackQuery);
?>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php 
	$get_title_url = $_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
	if($get_title_url == "localhost/accagents/portal/application/index.php"){
		echo "<title>";
		echo "Applications | Avalon Community College";
		echo "</title>";
	}
	elseif($get_title_url == "localhost/accagents/portal/login/index.php"){
		echo "<title>";
		echo "Login | Avalon Community College ";
		echo "</title>";
	}else{
		echo "<title>";
		echo "Avalon Community College";
		echo "</title>";
	}
	if(($roles1 == "Admin") || ($roles1 == "Excu") || ($roles1 == "college") || ($roles1 == "Excu1")){
	?>  
	<link rel="stylesheet" href="../../css/bootstrap.min.css">
    <link href="../../css/multi_select.css" rel="stylesheet" type="text/css" />
	<script src="../../js/jquery.min.js"></script>
	<link rel="stylesheet" href="../../css/responsive.css" type="text/css" media="screen"/>
    <!-- <script src="../../js/bootstrap-4-hover-navbar.js"></script> -->
	<script src="../../js/popper.min.js"></script>
	<link rel="stylesheet" type="text/css" href="../../css/stylesheet.css">
	<link href="../../css/fontawesome-all.css" rel="stylesheet" type="text/css" />
	<script src="../../js/bootstrap.min.js"></script>
	<!--link rel="stylesheet" href="../../css/code-jquery-ui.css"-->
	<link rel="stylesheet" href="../../css/jquery-ui.css">
	<script src="../../js/code-jquery-ui.js"></script>
    <script src="../../js/multi_select.js" type="text/javascript"></script>
     <link rel="icon" href="https://avaloncommunitycollege.ca/img/favicon.png">
	<script>
	
  $( function() {
    $(".datepicker123").datepicker({	  
		dateFormat: 'yy-mm-dd', 
		changeMonth: true, 
		changeYear: true,
		yearRange: "-80:+0"
    });
  });
  </script>
	<style> 
.loading_icon{
	display:none;
	background: url("../../images/CircleBlue.gif") no-repeat scroll center center transparent;
	background-color: rgba(150,150,150,.5);
	width: 100%;
	height: 100%;
	vertical-align: middle;
	z-index: 100 !important;
	position: fixed;
	top: 0;
	left: 0;
}
</style>
	<?php }else{ ?>	
    <link rel="stylesheet" href="../css/bootstrap.min.css">
	<script src="../js/jquery.min.js"></script>
	<link rel="stylesheet" href="../css/responsive.css" type="text/css" media="screen"/>
	<script src="../js/bootstrap.min.js"></script>
	<script src="../js/popper.min.js"></script>
	<link rel="stylesheet" type="text/css" href="../css/stylesheet.css">
	<link rel="stylesheet" href="../css/code-jquery-ui.css">
	<script src="../js/code-jquery-ui.js"></script>
	<script src="../js/bootstrap-4-hover-navbar.js"></script>
	<link href="../css/fontawesome-all.css" rel="stylesheet" type="text/css" />
	<script>
  $( function() {
    $(".datepicker123").datepicker({	  
		dateFormat: 'yy-mm-dd', 
		changeMonth: true, 
		changeYear: true,
		yearRange: "-80:+0"
    });
  });
  </script> 
	<script src="../js/bootstrap.min.js"></script>
	<style> 
.loading_icon{
	display:none;
	background: url("../images/CircleBlue.gif") no-repeat scroll center center transparent;
	background-color: rgba(150,150,150,.5);
	width: 100%;
	height: 100%;
	vertical-align: middle;
	z-index: 100 !important;
	position: fixed;
	top: 0;
	left: 0;
}
</style>
	<?php } ?>
   
<script>
$(function () {
        $("[data-toggle='tooltip']").tooltip();
    });
</script>

<style>
.notfi-btn { float:right !important;margin:1% 30px 0px 0px;  padding:2px;}
.notfi-btn .dropdown-menu { padding:0px 0px; margin-top:30px;right:0px; min-width:250px; }
.notfi-btn .dropdown-menu li {padding:10px 15px 10px 10px; font-size:12px; border-bottom:1px solid #fff; margin:0px; color:#333; line-height:20px;}
.notfi-btn .dropdown-menu li:last-child { border:0px;}
.notfi-btn .dropdown-menu li span { color:#2c97ea;margin:0px; font-size:12px;}
.notfi-btn .dropdown-menu li span:first-child { color:#666;}
.noti_list { background:none !important; color:#007bff; border-radius:50%; padding:2px; border:0px !important;}
.noti_list:hover { background:none !important; color:#007bff !important;}
.count_notify_me { background:#2c97ea; border-radius:10px; }
.fa-bell { font-size:20px !important;}
.btn-group:focus, .noti_list:focus { background:none; box-shadow:none !important;color:#007bff !important;  border:0px !important;}
.hd:hover { background:#4EA245 !important;}
.marque-text{position:relative; background:#4ea245; margin:0px; line-height:30px; color:#fff;}
@media only screen and (max-width:1024px) {.notfi-btn { margin-top:-34px;}}
</style>		
</head>

<body>   
<style type="text/css">
#autoModal .modal-dialog{ max-width: 1400px; }
</style>
  
<script>
$(document).ready(function(){
	var getloc = window.location.href;
	if(getloc =='localhost/accagents/portal/backend/application/'){
	setTimeout(function(){  
				$("#autoModal").modal('show');
	}, 2000);                
	}
});
</script>
<?php
if(isset($_SESSION['agentPostiveResponseAOL'])){
	$agentPostiveResponseAOL2 = $_SESSION['agentPostiveResponseAOL'];
}else{
	$agentPostiveResponseAOL2 = '';
}
if(empty($status2) || empty($agentPostiveResponseAOL2) && $status2 == 'No'){
?>
<script>
$(document).ready(function(){
  $('#prModelAlert').modal({backdrop: 'static', keyboard: false}, 'show');
});
</script>
<div class="modal fade" id="prModelAlert" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header border-0 py-1">
          
		  <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body text-left pt-0">
		<h5 style="color:red;">Latest Update: <?php echo date('Y-m-d'); ?></h5>
		<p>

<p>Dear <?php echo ucfirst($contact_person); ?>,</p>
Greeting from Avalon Community College<br><br>
We are excited to share that many of our agents have started receiving positive results for the upcoming intakes. We urge you to check your students GC key for the result updates.<br><br>
</p>
         <form action="../mysqldb.php" method="POST" autocomplete="off">
		 <input type="checkbox" name="notiAgain" id="dontShow3"> 
		 <label for="dontShow3">Don't show this message again.</label>
		 <input type="hidden" name="agentid" value="<?php echo $sessionid1; ?>">
		 <input type="submit" name="btnPostiveRes" class="btn btn-sm w-25 float-right mt-4 btn-success" value="Okay">
         </form>
		 <p class="mt-5"><b>Regards,<br>
Team Avalon Community College</b></p>
        </div>
      </div>
    </div>
</div>
<?php } ?>

<?php
if(!empty($_GET['msgLoad'])){
if($_GET['msgLoad'] == 'Success'){
?>
<script>
$(document).ready(function(){
  $("#scsModelAlert").modal("show");
});
</script>
<div class="modal fade" id="scsModelAlert" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
		<div class="modal-header py-1">
          <h5 style="color:red;">Alert</h5>
		  <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body pt-0">
		<p class="mt-3"><b style="font-size: 15px;">Application Successfully Submitted.</b></p>
        </div>
      </div>
    </div>
</div>
<?php } ?>
<?php } ?>

   <nav class="navbar navbar-expand-xl btco-hover-menu fixed-top" style="display: inline !important;">
	<!--marquee class="marque-text" behavior="alternate" width="100%" direction="left" height="10%" onMouseOver="this.stop()" onMouseOut="this.start()">
		&nbsp;&nbsp; <b>Latest Update: </b>Courses are available for JAN Intake 2023  &nbsp;&nbsp;
	</marquee-->	
	<div class="container-fluid">
	<div class="col-xl-1 col-12">   
	<a class="navbar-brand" href="#">
	<?php if(($roles1 == "Admin") || ($roles1 == "Excu") || ($roles1 == "college") || ($roles1 == "Excu1")){ ?>
		<img src="../../images/logo-img.png" width="70" alt="">
	<?php }else{ ?>
		<img src="../images/logo-img.png" width="70" alt="">
	<?php } ?>	
	</a>
	<button class="navbar-toggler float-right" type="button" data-toggle="collapse" data-target="#navbarNavDropdown"> 
		<i class="fas fa-bars"></i> 
	</button>
	</div>
    <div class="col-xl-11 col-12"> 
		<?php
		if($salesNum){
		
		}else{
		
		//if($report_allow == "1"){
		if($roles1 !== "college"){
		if(($roles1 == "Admin") || ($roles1 == "Excu") || ($roles1 == "Excu1")){ ?>
		
		<script type="text/javascript">
			// setInterval(function(){
			$.ajax({
			   url:"../../notification_count.php",
			   type:"GET", 
			   async:true, 
			   cache:false, 
			   success:function(result){
				 $("#count_notify_me").html(result);
			   }
			});
		// },500000);
		</script>	

		<div class="notfi-btn dropdown mr-5 mr-xl-1">
		
			<button type="button" class="btn btn-default dropdown-toggle noti_list" data-toggle="dropdown">
				<span id="count_notify_me"></span> 
				<i class="fas fa-bell" aria-hidden="true"></i>
			</button>
				<ul class="dropdown-menu dropdown-menu-right" role="menu" style="background: #efe5e5 !important;">		
				<span id="notification_response"></span>
				  <?php 
					$list_notification = mysqli_query($con, "SELECT sno FROM notification_aol ORDER BY sno desc LIMIT 5");
					$count_five = mysqli_num_rows($list_notification);
					if($count_five >= '5'){
					?>
					<li style="padding:0px !important;"><a href="../notification" class='btn btn-info hd' style="color:#fff; width:100%; margin:0px;">Check All</a></li>
				   <style>a.btn.btn-info.hd{background:#4EA245 !important;}</style>
				   <?php } ?>
				</ul>             
			
		</div>
	
		<script>
		$(document).ready(function() {
			$(".noti_list").click(function() {
				$('.loading_icon').show();
				$.ajax({  
				type: "GET",
				url: "../../notification_count_status.php",             
				dataType: "html",             
				success: function(response){                    
				$("#notification_response").html(response); 
					//alert(response);
					$('.loading_icon').hide();
				}
			  });
			});
		  });
		</script>
		
		<?php } } } //} 
		if($roles1 == "Agent"){
		?>
		
		<script type="text/javascript">
			// setInterval(function(){
			$.ajax({
			   url:"../notification_count.php",
			   type:"GET", 
			   async:true, 
			   cache:false, 
			   success:function(result){
				 $("#count_notify_me").html(result);
			   }
			});
			// },500000);
		</script>
		
		<div class="notfi-btn dropdown float-right">
       
        <button type="button" class="btn btn-default dropdown-toggle noti_list" data-toggle="dropdown">
            <span id="count_notify_me"></span> 
            <i class="fas fa-bell" aria-hidden="true"></i>
        </button>
            <ul class="dropdown-menu  dropdown-menu-right" role="menu" style="background: #fff;">		
            <span id="notification_response"></span>
			  <?php 
				$list_notification = mysqli_query($con, "SELECT sno FROM notification_aol ORDER BY sno desc LIMIT 5");
				$count_five = mysqli_num_rows($list_notification);
				if($count_five >= '5'){
				?>
				<li style="padding:0px !important;"><a href="../notification" class='btn btn-info hd' style="color:#fff; width:100%; margin:0px;">Check All</a></li>
			   <style>a.btn.btn-info.hd{background:#4EA245 !important;}</style>
			   <?php }
			   ?>
			</ul>             
   
		</div>
		
		<script>
		$(document).ready(function() {
			$(".noti_list").click(function() {
				$('.loading_icon').show();
				$.ajax({  
				type: "GET",
				url: "../notification_count_status.php",             
				dataType: "html",             
				success: function(response){                    
				$("#notification_response").html(response); 
					//alert(response);
					$('.loading_icon').hide();
				}
			  });
			});
		  });
		</script>
		
		<?php } ?>
       <div class="collapse navbar-collapse justify-content-end" id="navbarNavDropdown">
		<ul class="navbar-nav">		
			<?php if(($roles1 == "Admin") || ($roles1 == "Excu") || ($roles1 == "Excu1")){
			if($report_allow == "1"){
			?>
			<li class="nav-item"><a href="../application">All Applications</a></li>
		<?php		
		if($email2323 == 'operation@acc' || $salesNum){
			
		}else{
		?>
			<li class="nav-item"><a href="../application/loaLogs.php">LOA Logs</a></li>
		<?php } ?>
		<?php if($email2323 != 'viewdocs@acc.com'){ ?>
			<li class="nav-item"><a href="../followup">Followup List</a></li>
		<?php } ?>
			<!-- <li><a href="../followup/stage_followup_reminder.php?<?php //echo base64_encode('1SecuRi4y9');?>">Auto Reminders</a></li> -->
			<?php if($loa_allow == '1'){ ?>
			<li class="nav-item"><a href="../application/btnEnabled.php?<?php echo base64_encode('1SecuRi4y9');?>">Btn Enabled</a></li>

<?php
$list_notification_all3 = "SELECT application_remarks.app_id FROM `application_remarks` INNER JOIN st_application ON st_application.sno=application_remarks.app_id where st_application.application_form ='1' AND (application_remarks.added_by_id!='3000' OR application_remarks.added_by_id!='300') AND application_remarks.comments_color='#f9d5d5'";
$list_notification_all23 = mysqli_query($con, $list_notification_all3);
$listcntnoti = mysqli_num_rows($list_notification_all23);
if($listcntnoti){
	$cmntNotDiv = '<span class="badge badge-pill badge-danger" style="top: -7px;
    margin-left: 0;position: relative;">'.$listcntnoti.'</span>';
}else{
	$cmntNotDiv = '';
}

$listNotiNotSubmit = "SELECT application_remarks.app_id FROM `application_remarks` INNER JOIN st_application ON st_application.sno=application_remarks.app_id where st_application.application_form !='1' AND (application_remarks.added_by_id!='3000' OR application_remarks.added_by_id!='300') AND application_remarks.comments_color='#f9d5d5'";
$listNotiNotSubmit_res = mysqli_query($con, $listNotiNotSubmit);
$listcntnoti_notSub = mysqli_num_rows($listNotiNotSubmit_res);
if($listcntnoti_notSub){
	$cmntNotSubDiv = '<span class="badge badge-pill badge-danger" style="top: -7px;
    margin-left: 0;position: relative;">'.$listcntnoti_notSub.'</span>';
}else{
	$cmntNotSubDiv = '';
}
?>			
			<li class="nav-item"><a href="../application/latestCmnt.php?<?php echo base64_encode('1SecuRi4y9');?>">Comments Notification<?php echo $cmntNotDiv; ?></a></li>

			<?php } ?>
		<?php if($email2323 != 'viewdocs@acc.com'){ ?>	
			<li class="nav-item"><a href="../followup/drop.php">Drop List</a></li>
		<?php } ?>

			<?php } if(($roles1 =="Admin") && ($report_allow == "")){ ?>
			
            <li class="nav-item"><a href="../report/vgrapplication.php?<?php echo base64_encode('1SecuRi4y9');?>">My Applications</a></li>
            <li class="nav-item"><a href="../report/loa_receipt.php?<?php echo base64_encode('1SecuRi4y9');?>">TT Receipt</a></li>
            <li class="nav-item"><a href="../report/agent_course.php?<?php echo base64_encode('1SecuRi4y9');?>">Summary</a></li>

			<?php }
			if(($roles1 =="Admin") && ($report_allow == "1")){
			if($salesNum){
				
			}else{
			?>
			<!--li><a href="../daily_reports">Report</a></li-->
			<?php } ?>
			
		<?php if($email2323 == 'admin@acc.com' || $email2323 == 'operation@acc' || $email2323 == 'acc_admin' || $salesNum){ ?>
		<?php if($email2323 != 'viewdocs@acc.com'){ ?>
			<li class="nav-item"><a href="../agenLlisting/">Agents List</a></li>
		<?php } ?>
		<?php if($email2323 == 'viewdocs@acc.com'){ ?>			
			<li><a href="../liveReportAcc/">All Time Reports</a></li>
		<?php } ?>
		<?php if($email2323 == 'admin@acc.com' || $email2323 == 'acc_admin'){ ?>
			
		<li class="dropdown">
		  <a  class="dropdown-toggle" data-toggle="dropdown">
			Other
		  </a>
		  <ul class="dropdown-menu">
			<li>
			<a href="../application/palLists.php?<?php echo base64_encode('1SecuRi4y9');?>" class="dropdown-item">PAL Lists</a>
			</li>
			<li>
			<a href="../application/gicLists.php?<?php echo base64_encode('1SecuRi4y9');?>" class="dropdown-item">GIC Lists</a>
			</li>
		  </ul>
		</li>			
			
			<li class="nav-item"><a href="../application/pending_application.php?<?php echo base64_encode('1SecuRi4y9');?>">Appls Cratd But Not Sbmtd<?php echo $cmntNotSubDiv; ?></a></li>
				
			<li class="nav-item dropdown show">
				<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">Reports</a>
				<ul class="dropdown-menu"><li><a href="../report/agent_course.php?<?php echo base64_encode('1SecuRi4y9');?>">Summary</a></li>
				<li><a href="../liveReportAcc/">All Time Reports</a></li>
				<li><a href="../courses/all_courses.php?<?php echo base64_encode('1SecuRi4y9');?>">Courses</a></li>	
				<li><a href="../application/agent_change.php?<?php echo base64_encode('1SecuRi4y9'); ?>">Change Agent</a></li>	
				</ul>
			</li>

			<li class="nav-item dropdown show">
				<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">Accounts</a>
				<ul class="dropdown-menu"><li><a href="../accounts/">Total Lists</a></li><li><a href="../accounts/recieved_account.php">Followup Lists</a></li>
				</ul>
			</li>
		<?php } }
		} }else{ ?>
		<?php if($activated == ''){ ?>
			
		<?php }else{
		if($roles1 == "Agent"){ ?>
			<li class="nav-item">
			<a class="nav-link" href="../dashboard/">Create New Application</a>
			</li>
			<li class="nav-item">
			<a class="nav-link" href="../application/">My Applications</a>
			</li>
			
			<li class="nav-item">
				<a class="nav-link" href="../application/palLists.php?<?php echo base64_encode('1SecuRi4y9');?>">PAL Lists</a>
			</li>
			<li class="nav-item">
				<a href="../application/latestCmnt.php?<?php echo base64_encode('1SecuRi4y9');?>">Comments Lists</a>
			</li>

		<?php if($email2323 !== 'apply_board@aol'){ ?>
			<li class="nav-item"> 
			<a class="nav-link" href="../application/certifyavl.php?<?php echo base64_encode('1SecuRi4y9');?>">Authorisation Certificate</a>
			</li>

		<?php } ?>
			<style>.btco-hover-menu a, .navbar > li > a {
font-size: 10px;
font-weight: bold;
}</style>
		<?php }else{ 
		if($roles1 !== "college"){
		if($applicationForm == ''){
		?>
			<li class="nav-item"> <a class="nav-link" href="../dashboard/">Create Application</a></li>
		<?php }
		if($applicationForm == '1'){ ?>
		<li class="nav-item"> <a class="nav-link" href="../application/">My Applications</a></li>
		<?php } } } ?>
			
		<li class="nav-item dropdown show"> 
		<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"><i class="fas fa-user"></i> <?php echo $username; ?></a>
		<ul class="dropdown-menu wow animated fadeInDown" data-wow-delay="0.2s" aria-labelledby="navbarDropdownMenuLink">
			
		<li class="nav-item"><a class="nav-link" href="../changepassword" > Change Password</a></li> 
		</ul>
		</li>
		
		<?php } } 
		if($roles1 == "college"){ ?>        
		<li class="nav-item"><a href="../clg_docs">Compliances</a></li>					
		<?php }	?>
		
		<?php
		if($salesNum){
			$clgName = '('.ucfirst($contact_person).')';
		}else{
			$clgName = '';
		}
		?>			
            <li class="nav-item"> <a class="nav-link" href="../logout.php"><?php echo $clgName; ?> Log Out</a></li>		
		</ul>
		
		</div>
		
	  </div>
	 </div>
	</nav>