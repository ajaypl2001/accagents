<?php
ob_start();
include("../../db.php");
include("../../header_navbar.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../../vendor/autoload.php';
$mail = new PHPMailer(true);

date_default_timezone_set("America/Toronto");

if (isset($_GET['getsearch']) && $_GET['getsearch']!="") {
	$searchTerm = $_GET['getsearch'];
	$searchInput = "AND (CONCAT(fname,  ' ', lname) LIKE '%".$searchTerm."%' OR refid LIKE '%".$searchTerm."%' OR passport_no LIKE '%".$searchTerm."%' OR student_id LIKE '%".$searchTerm."%')";
	$search_url = "&getsearch=".$searchTerm."";
} else {
	$searchInput = '';
	$search_url = '';
	$searchTerm = '';
}

if(!empty($_GET['getIntake'])){
	$getIntake2 = $_GET['getIntake'];
	$getIntake3 = "AND prg_intake='$getIntake2'";
}else{
	$getIntake2 = '';
	$getIntake3 = '';
}

if(isset($_POST['submitbtnStuPmt'])){
	$userid = $_POST['app_id'];
	$study_permit_yes = $_POST['study_permit'];
	$passp = $_POST['passp'];
	$stid = $_POST['stid'];
	$refid = $_POST['refid'];
	$spr = $_POST['spr'];
	$created_date2 = date('Y-m-d H:i:s');
	
	$qry = mysqli_query($con, "SELECT * FROM `international_airport_student` where `app_id`='$userid'");
	if(mysqli_num_rows($qry)){
		$uid1 = mysqli_fetch_assoc($qry);
		$study_permit22 = $uid1['study_permit'];
		$insurance22 = $uid1['insurance'];
	}else{
		$study_permit22 = '';
		$insurance22 = '';
	}
		
	$name1 = $_FILES['study_permit_file']['name'];
	$tmp1 = $_FILES['study_permit_file']['tmp_name'];

	$name2 = $_FILES['insurance']['name'];
	$tmp2 = $_FILES['insurance']['tmp_name'];

	if($name1 == ''){	
		$img_name1 = $study_permit22;	
	}else{
		$extension = pathinfo($name1, PATHINFO_EXTENSION);
		if(!empty($study_permit22)){
			unlink("../../../international/uploads/$study_permit22");
		}
		$img_name1 = 'StudyPermit_'.$userid.'_'.date('dhis').'.'.$extension;
		move_uploaded_file($tmp1, '../../../international/uploads/'.$img_name1);
	}
	
	if($name2 == ''){	
		$img_name2 = $insurance22;	
	}else{
		$extension2 = pathinfo($name2, PATHINFO_EXTENSION);
		if(!empty($insurance22)){
			unlink("../../../international/uploads/$insurance22");
		}
		$img_name2 = 'Insurance_'.$userid.'_'.date('dhis').'.'.$extension2;
		move_uploaded_file($tmp2, '../../../international/uploads/'.$img_name2);
	}
	
	$remarks = mysqli_real_escape_string($con, $_POST['remarks']);
	$datetime_at = date('Y-m-d H:i:s');
	
	if($study_permit_yes == 'Yes'){
		if(mysqli_num_rows($qry)){
			$mainTableUpdate = "UPDATE `international_airport_student` SET `study_permit`='$img_name1', `insurance`='$img_name2', `datetime_at`='$created_date2' WHERE `app_id`='$userid'";
			mysqli_query($con, $mainTableUpdate);
		}else{
			mysqli_query($con, "INSERT INTO `international_airport_student` (`app_id`, `student_id`, `study_permit`, `insurance`,  `datetime_at`) VALUES ('$userid', '$stid', '$img_name1', '$img_name2', '$created_date2')");
		}
	}
	$mainTableQry = "UPDATE `both_main_table` SET `study_permit`='$study_permit_yes', `sif_send_by`='$contact_person' WHERE `sno`='$userid'";
	mysqli_query($con, $mainTableQry);
	
	header("Location: ../collegeStart/vgStudyPermit.php?getIntake=$getIntake2&SuccessFully_Submit$search_url");	
}

if(isset($_POST['srchClickbtn'])){
	$search = $_POST['inputval'];
	$intakeInput = $_POST['intakeInput'];
	header("Location: ../collegeStart/vgStudyPermit.php?getsearch=$search&getIntake=$intakeInput&page_no=1");
}

if (isset($_GET['page_no']) && $_GET['page_no']!="") {
	$page_no = $_GET['page_no'];
} else {
	$page_no = 1;
}

$total_records_per_page = 90;
$offset = ($page_no-1) * $total_records_per_page;
$previous_page = $page_no - 1;
$next_page = $page_no + 1;
$adjacents = "2";

$result_count = mysqli_query($con, "SELECT COUNT(*) As total_records FROM `both_main_table` where v_g_r_status='V-G'  $searchInput $getIntake3");
$total_records = mysqli_fetch_array($result_count);
$total_records = $total_records['total_records'];
$total_no_of_pages = ceil($total_records / $total_records_per_page);
$second_last = $total_no_of_pages - 1;

$rsltQuery = "SELECT * FROM both_main_table where v_g_r_status='V-G' $searchInput $getIntake3 order by sno DESC LIMIT $offset, $total_records_per_page";
?> 
<link rel="stylesheet" href="../../css/sweetalert.min.css">
<script src="../../js/sweetalert.min.js"></script>
<style>
.error_color{border:2px solid #de0e0e;}
.validError{border:2px solid #ccc;}
.blink-bg{
	color: #fff;
	padding: 1px;
	display: inline-block;
	border-radius: 1px;
	animation: blinkingBackground 2s infinite;
}
@keyframes blinkingBackground{
	0%		{ background-color: #10c018;}
	25%		{ background-color: #1056c0;}
	50%		{ background-color: #ef0a1a;}
	75%		{ background-color: #254878;}
	100%	{ background-color: #04a1d5;}
}
</style>


<link rel="stylesheet" type="text/css" href="../../css/fixed-table.css">
<script src="../../js/fixed-table.js"></script>
<section class="container-fluid">
<div class="main-div">
<div class="admin-dashboard">
<div class="row">	

<div class="col-sm-4 col-lg-4 mb-3">
<h3 class="m-0"><span class="blink-bg">VG</span><span style="font-size:19px;">Student Lists - Study Permit & Insurance Form</span></h3>
</div>

<div class="col-sm-2 col-lg-2 mb-3">
<form method="POST" action="excelSheet.php" autocomplete="off">
	<input type="hidden" name="role" value="<?php echo 'Student_Status'; ?>">
	<input type="hidden" name="keywordLists" value="<?php echo $searchTerm; ?>">
	<input type="hidden" name="intakeInput" value="<?php echo $getIntake2; ?>">
	<button type="submit" name="studentlist" class="btn btn-sm btn-success float-right" >Download Excel</button>
</form>
</div>

<form action="" method="post" autocomplete="off" class="col-sm-6 col-lg-6">
<div class="row">
<div class="col-sm-6 mb-3">
<div class="input-group input-group-sm">
	<select name="intakeInput" class="form-control">
		<option value="">Select Intake</option>
		<?php
		$rsltQuery5 = "SELECT intake FROM contract_courses Group BY intake ORDER BY intake DESC";
		$qurySql5 = mysqli_query($con, $rsltQuery5);
		while($row_nm5 = mysqli_fetch_assoc($qurySql5)){
			$intake34 = $row_nm5['intake'];
		?>
		<option value="<?php echo $intake34; ?>"<?php if ($intake34 == $getIntake2) { echo 'selected="selected"'; } ?>><?php echo $intake34; ?></option>
		<?php } ?>
	</select>
</div>
</div>

<div class="col-sm-6 mb-3">
	<div class="input-group">
		<input type="text" name="inputval" placeholder="Search By Stu. Name or Ref Id" class="form-control form-control-sm" value="<?php echo $searchTerm; ?>">
		<div class="input-group-append">
			<input type="submit" name="srchClickbtn" class="btn btn-sm btn-success" value="Search">
		</div>
	</div>
</div>
</div>
</form>

<div class="col-12">			
   <div id="fixed-table-container-1" class="fixed-table-container">
	<table class="table table-sm table-bordered" width="100%">
    <thead>	  
      <tr>
        <th>Student Name</th>
        <th>Ref/Std Id</th>	
        <th>Std Location</th>	
        <th>Agent Name</th>	
        <th>DOB</th>	
        <th>Program Name</th>	
        <th>Start Date(LOA)</th>	
        <th>VG Date</th>	
        <th>Email Address</th>	
        <th>Passport</th>        
        <th>Status</th>
        <th>Updated By Name</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>	
	<?php
	$qurySql = mysqli_query($con, $rsltQuery);
	if(mysqli_num_rows($qurySql)){
		while ($row_nm = mysqli_fetch_assoc($qurySql)){
		$snoid = $row_nm['sno'];
		$clg_serial_no = $row_nm['clg_serial_no'];
		$user_id = $row_nm['user_id'];
		$fname = $row_nm['fname'];				
		$lname = $row_nm['lname'];
		$fullname = ucfirst($fname).' '.ucfirst($lname);
		$refid = $row_nm['refid'];
		$dob = $row_nm['dob'];
		$student_id = $row_nm['student_id'];
		$passport_no = $row_nm['passport_no'];
		$email_address = $row_nm['email_address'];
		$prg_name1 = $row_nm['prg_name1'];
		$prg_intake = $row_nm['prg_intake'];		
		$on_off_shore = $row_nm['on_off_shore'];
		$study_insurance_form_mail_sent = $row_nm['study_insurance_form_mail_sent'];
		$study_permit = $row_nm['study_permit'];
		$v_g_r_status_datetime = $row_nm['v_g_r_status_datetime'];
		$vgDate = date('Y-m-d', strtotime("$v_g_r_status_datetime"));
		
		$sif_send_by = $row_nm['sif_send_by'];
		if(!empty($sif_send_by)){
			$study_fileName = $sif_send_by;
		}else{
			$study_fileName = 'Student';
		}
		
		$queryGet2 = "SELECT * FROM `start_college` WHERE with_dism!='' AND app_id='$snoid' ORDER BY sno DESC";
		$queryRslt2 = mysqli_query($con, $queryGet2);
		if(mysqli_num_rows($queryRslt2)){
			$rowSC = mysqli_fetch_assoc($queryRslt2);	
			$with_dism = $rowSC['with_dism'];			
			$refund_rp = $rowSC['refund_rp'];		
			$datetime_at = $rowSC['datetime_at'];		
			$in_w_d = $rowSC['in_w_d'];
			$with_file3 = $rowSC['with_file'];
			if(!empty($with_file3)){
				$with_file_download = "<br><a href='../../Student_File/$with_file3' download>Download File</a>";
			}else{
				$with_file_download = '';
			}
			$started_program2 = $rowSC['started_program'];
			if(!empty($started_program2)){
				$started_program = '<b>Program: </b>'.$started_program2.'<br>';
				$started_start_date = '<b>Start Date: </b>'.$rowSC['started_start_date'].'<br>';
				$started_end_date = '<b>End Date: </b>'.$rowSC['started_end_date'];
			}else{
				$started_program = '';
				$started_start_date = '';
				$started_end_date = '';
			}
		}else{
			$with_dism = '<span style="color:red;">No Action</span>';			
			$refund_rp = '';			
			$datetime_at = '';			
			$in_w_d = '';
			
			$started_program = '';
			$started_start_date = '';
			$started_end_date = '';
			$with_file_download = '';			
		}
		$getquery22 = "SELECT username FROM `allusers` WHERE sno='$user_id'";		
		$RefundsWeeklyRslt22 = mysqli_query($con, $getquery22);
		$row_nm22 = mysqli_fetch_assoc($RefundsWeeklyRslt22);
		$username = mysqli_real_escape_string($con, $row_nm22['username']);
		
		$queryGet4 = "SELECT commenc_date FROM `contract_courses` WHERE program_name='$prg_name1' AND intake='$prg_intake'";
		$queryRslt4 = mysqli_query($con, $queryGet4);
		$rowSC4 = mysqli_fetch_assoc($queryRslt4);
		$start_date = $rowSC4['commenc_date'];
		
		$queryGetSnoid = "SELECT sno, study_permit, insurance FROM `international_airport_student` where app_id='$snoid'";
		$queryRsltSnoid = mysqli_query($con, $queryGetSnoid);
	?>
	<tr>
		<td style="white-space: nowrap;"><?php echo $fname.' '.$lname; ?></td>
		<td style="white-space: nowrap;"><?php echo $refid.'/'.$student_id; ?></td>		
		<td><?php echo $on_off_shore; ?></td>		
		<td style="white-space: nowrap;"><?php echo $username; ?></td>		
		<td style="white-space: nowrap;"><?php echo $dob; ?></td>		
		<td style="white-space: nowrap;"><?php echo $prg_name1; ?></td>		
		<td style="white-space: nowrap;"><?php echo $start_date; ?></td>		
		<td style="white-space: nowrap;"><?php echo $vgDate; ?></td>		
		<td style="white-space: nowrap;"><?php echo $email_address; ?></td>			
		<td style="white-space: nowrap;"><?php echo $passport_no; ?></td>			
		<td><?php echo $study_permit; ?></td>
		<td><?php echo $study_fileName; ?></td>
		<td style="white-space: nowrap;">
		<?php
		if(mysqli_num_rows($queryRsltSnoid) && ($study_permit == 'Yes')){
			$row_nmSnoid = mysqli_fetch_assoc($queryRsltSnoid);
			$study_file = $row_nmSnoid['study_permit'];
			$insurance = $row_nmSnoid['insurance'];
			if(!empty($study_file)){
				echo '<a href="https://granville-college.com/international/uploads/'.$study_file.'" download>Download Study Permit</a>';
			}
			if(!empty($insurance)){
				echo '<br><a href="https://granville-college.com/international/uploads/'.$insurance.'" download>Download Insurance Form</a>';
			}
			echo '<br><span style="color:red;">Already Added</span>';
		}else{
		?>
		<span class="btn btn-sm btn-success statusClass my-1" data-toggle="modal" data-target="#statusModal" data-id="<?php echo $snoid; ?>" data-name="<?php echo $fullname; ?>" data-refid="<?php echo $refid; ?>" data-stid="<?php echo $student_id; ?>" data-passp="<?php echo $passport_no; ?>">Add Status</span>
		<?php } ?>
		</td>
	</tr>			
	<?php }
	}else{
		echo '<tr><td colspan="9"><center>Not Found!!!</center></td></tr>';
	}
	?>
    </tbody>	
	</table>  
	</div>
</div>

<div class="col-md-8 mt-2 pl-3">
	<strong>Total Records <?php echo $total_records; ?>, </strong>
	<strong>Page <?php echo $page_no." of ".$total_no_of_pages; ?></strong>
</div>

<div class="col-md-4 mt-2">
<nav aria-label="Page navigation example">
<ul class="pagination justify-content-end">  
	<?php // if($page_no > 1){ echo "<li><a href='?page_no=1'>First Page</a></li>"; } ?>
    
	<li <?php if($page_no <= 1){ echo "class='page-item disabled'"; } ?>>
	<a <?php if($page_no > 1){ echo "href='?page_no=$previous_page&getsearch=$search_url&getIntake=$getIntake2'"; } ?> class='page-link'>Previous</a>
	</li>
       
    <?php 
	if ($total_no_of_pages <= 10){  	 
		for ($counter = 1; $counter <= $total_no_of_pages; $counter++){
			if ($counter == $page_no) {
		   echo "<li class='page-item active'><a class='page-link'>$counter</a></li>";	
				}else{
           echo "<li class='page-item'><a href='?page_no=$counter&getsearch=$search_url&getIntake=$getIntake2' class='page-link'>$counter</a></li>";
				}
        }
	}
	elseif($total_no_of_pages > 10){
		
	if($page_no <= 4) {			
	 for ($counter = 1; $counter < 8; $counter++){		 
			if ($counter == $page_no) {
		   echo "<li class='page-item active'><a class='page-link'>$counter</a></li>";	
				}else{
           echo "<li class='page-item'><a href='?page_no=$counter&getsearch=$search_url&getIntake=$getIntake2' class='page-link'>$counter</a></li>";
				}
        }
		echo "<li><a>...</a></li>";
		echo "<li><a href='?page_no=$second_last&getsearch=$search_url&getIntake=$getIntake2' class='page-link'>$second_last</a></li>";
		echo "<li><a href='?page_no=$total_no_of_pages&getsearch=$search_url&getIntake=$getIntake2' class='page-link'>$total_no_of_pages</a></li>";
		}

	 elseif($page_no > 4 && $page_no < $total_no_of_pages - 4) {		 
		echo "<li class='page-item'><a href='?page_no=1&getsearch=$search_url&getIntake=$getIntake2' class='page-link'>1</a></li>";
		echo "<li class='page-item'><a href='?page_no=2&getsearch=$search_url&getIntake=$getIntake2' class='page-link'>2</a></li>";
        echo "<li class='page-item'><a class='page-link'>...</a></li>";
        for ($counter = $page_no - $adjacents; $counter <= $page_no + $adjacents; $counter++) {			
           if ($counter == $page_no) {
		   echo "<li class='page-item active'><a class='page-link'>$counter</a></li>";	
				}else{
           echo "<li class='page-item'><a href='?page_no=$counter&getsearch=$search_url&getIntake=$getIntake2' class='page-link'>$counter</a></li>";
				}                  
       }
       echo "<li class='page-item'><a class='page-link'>...</a></li>";
	   echo "<li class='page-item'><a href='?page_no=$second_last&getsearch=$search_url&getIntake=$getIntake2' class='page-link'>$second_last</a></li>";
	   echo "<li class='page-item'><a href='?page_no=$total_no_of_pages&getsearch=$search_url&getIntake=$getIntake2' class='page-link'>$total_no_of_pages</a></li>";      
            }
		
		else {
        echo "<li class='page-item'><a href='?page_no=1&getsearch=$search_url&getIntake=$getIntake2' class='page-link'>1</a></li>";
		echo "<li class='page-item'><a href='?page_no=2&getsearch=$search_url&getIntake=$getIntake2' class='page-link'>2</a></li>";
        echo "<li class='page-item'><a class='page-link'>...</a></li>";

        for ($counter = $total_no_of_pages - 6; $counter <= $total_no_of_pages; $counter++) {
          if ($counter == $page_no) {
		   echo "<li class='page-item active'><a class='page-link'>$counter</a></li>";	
				}else{
           echo "<li class='page-item'><a href='?page_no=$counter&getsearch=$search_url&getIntake=$getIntake2' class='page-link'>$counter</a></li>";
				}                   
                }
            }
	}
?>
    
	<li <?php if($page_no >= $total_no_of_pages){ echo "class='page-item disabled'"; } ?>>
	<a <?php if($page_no < $total_no_of_pages) { echo "href='?page_no=$next_page&getsearch=$search_url&getIntake=$getIntake2'"; } ?> class='page-link'>Next</a>
	</li>
    <?php if($page_no < $total_no_of_pages){
		echo "<li class='page-item'><a href='?page_no=$total_no_of_pages&getsearch=$search_url&getIntake=$getIntake2' class='page-link'>Last &rsaquo;&rsaquo;</a></li>";
		} ?>
</ul>
</nav>
</div>
</div>
</div>
</div>
</div>
</div>
</section>

<div class="modal" id="statusModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><span class="getNameId"></span></h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body getStudyPermitLists"></div>
      <div class="modal-footer"></div>
    </div>
  </div>
</div>

<script type="text/javascript">
$(document).on('click', '.statusClass', function () {
	var getVal = $(this).attr('data-id');
	var getVal2 = $(this).attr('data-name');
	var getVal3 = $(this).attr('data-passp');
	var getVal4 = $(this).attr('data-stid');
	var getVal5 = $(this).attr('data-refid');
	$('.getNameId').html(getVal2);
	$.post("../responseStart.php?tag=getStudyPermitLists",{"idno":getVal, "name":getVal2, "passp":getVal3, "stid":getVal4, "refid":getVal5},function(d){
		$('.getStudyPermitLists').html("");
		$('' + d[0].getStudyPermitLists +'').appendTo(".getStudyPermitLists");
		
		$("#firsttab_requried").submit(function () {
			var submit = true;
			$(".is_require:visible").each(function(){
				if($(this).val() == '') {
						$(this).addClass('error_color');
						submit = false;
				} else {
						$(this).addClass('validError');
				}
			});
			if(submit == true) {
				return true;        
			} else {
				$('.is_require').keyup(function(){
					$(this).removeClass('error_color');
				});
				return false;        
			}
		});		
		
	});
});
</script>

<script type="text/javascript">
$(document).on('change', '.study_permit', function () {
	var getVal = $(this).val();
	if(getVal == 'Yes'){
		$('.studyPermitDiv').show();
	}else{
		$('.studyPermitDiv').hide();		
	}
});
</script>


<style type="text/css">
	.fixed-table-container th  { width:100px;}
	.fixed-table-container { overflow: scroll; }
	.fixed-table-container tr:first-child th {
    background: #333; 
}
</style>	
<script>
  var fixedTable1 = fixTable(document.getElementById('fixed-table-container-1'));
</script> 
<?php 
include("../../footer.php");
?>
