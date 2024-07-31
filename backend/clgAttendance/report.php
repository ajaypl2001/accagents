<?php
ob_start();
include("../../db.php");
include("../../header_navbar.php");

if($roles1 == 'ClgAttd' || $warning_tab == 'Yes'){

} else {
	header("Location: ../../login");
    exit();
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../../vendor/autoload.php';
$mail = new PHPMailer(true);

if (isset($_GET['getsearch']) && $_GET['getsearch']!="") {
	$searchTerm = $_GET['getsearch'];
	$searchInput = "AND (CONCAT(st_application.fname,  ' ', st_application.lname) LIKE '%".$searchTerm."%' OR st_application.refid LIKE '%".$searchTerm."%' OR st_application.passport_no LIKE '%".$searchTerm."%' OR st_application.student_id LIKE '%".$searchTerm."%')";
	$search_url = "&getsearch=".$searchTerm."";
} else {
	$searchInput = '';
	$search_url = '';
	$searchTerm = '';
}

if(!empty($_GET['getIntake'])){
	$getIntake2 = $_GET['getIntake'];
	$getIntake3 = "AND start_college_attendance.warning_letter='$getIntake2'";
}else{
	$getIntake2 = '';
	$getIntake3 = '';
}

if(isset($_POST['srchClickbtn'])){
	$search = $_POST['inputval'];
	$intakeInput = $_POST['intakeInput'];
	header("Location: ../clgAttendance/report.php?getsearch=$search&getIntake=$intakeInput&page_no=1");
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

$result_count = mysqli_query($con, "SELECT COUNT(DISTINCT start_college_attendance.app_id) As total_records
FROM st_application
INNER JOIN start_college_attendance ON st_application.sno=start_college_attendance.app_id
WHERE start_college_attendance.app_id!='' $searchInput $getIntake3");
$total_records = mysqli_fetch_array($result_count);
$total_records = $total_records['total_records'];
$total_no_of_pages = ceil($total_records / $total_records_per_page);
$second_last = $total_no_of_pages - 1;

$rsltQuery = "SELECT st_application.sno, st_application.fname, st_application.lname, st_application.refid, st_application.student_id, st_application.prg_name1, st_application.prg_intake, st_application.email_address, st_application.on_off_shore, start_college_attendance.app_id
FROM st_application
INNER JOIN start_college_attendance ON st_application.sno=start_college_attendance.app_id
WHERE start_college_attendance.app_id!='' $searchInput $getIntake3 GROUP BY start_college_attendance.app_id
ORDER BY start_college_attendance.sno ASC LIMIT $offset, $total_records_per_page";
$qurySql = mysqli_query($con, $rsltQuery);
?> 

<style>
.error_color{border:2px solid #de0e0e;}
.validError{border:2px solid #ccc;}
</style>
<section class="container-fluid">
<div class="main-div">
<div class="admin-dashboard">
<div class="row">	

<div class="col-sm-4 col-lg-4 mb-3">
<h3 class="m-0">Report Lists - Warning Letter</h3>
</div>

<div class="col-sm-2 col-lg-2 mb-3">
<form method="POST" action="excelSheet.php" autocomplete="off">
	<input type="hidden" name="role" value="<?php echo 'Attendance_Reports'; ?>">
	<input type="hidden" name="keywordLists" value="<?php echo $searchTerm; ?>">
	<input type="hidden" name="intakeInput" value="">
	<input type="hidden" name="warningInput" value="<?php echo $getIntake2; ?>">
	<button type="submit" name="studentlist" class="btn btn-sm btn-success float-right" >Download Excel</button>
</form>
</div>

<form action="" method="post" autocomplete="off" class="col-sm-6 col-lg-6">
<div class="row">
<div class="col-sm-6 mb-3">
<div class="input-group input-group-sm">
	<select name="intakeInput" class="form-control">
		<option value="">Select Warning Type</option>
		<option value="1st_warning_letter"<?php if ($getIntake2 == '1st_warning_letter') { echo 'selected="selected"'; } ?>>1st_warning_letter</option>
		<option value="2nd_warning_letter"<?php if ($getIntake2 == '2nd_warning_letter') { echo 'selected="selected"'; } ?>>2nd_warning_letter</option>
		<option value="Confirmation_of_Dismissal"<?php if ($getIntake2 == 'Confirmation_of_Dismissal') { echo 'selected="selected"'; } ?>>Confirmation_of_Dismissal</option>
		<option value="Confirmation_of_Enrollment"<?php if ($getIntake2 == 'Confirmation_of_Enrollment') { echo 'selected="selected"'; } ?>>Confirmation_of_Enrollment</option>
		<option value="Confirmation_of_Withdrawal"<?php if ($getIntake2 == 'Confirmation_of_Withdrawal') { echo 'selected="selected"'; } ?>>Confirmation_of_Withdrawal</option>
		<option value="Letter_of_Completion"<?php if ($getIntake2 == 'Letter_of_Completion') { echo 'selected="selected"'; } ?>>Letter_of_Completion</option>
		<option value="Student_Dismissal_Letter"<?php if ($getIntake2 == 'Student_Dismissal_Letter') { echo 'selected="selected"'; } ?>>Student_Dismissal_Letter</option>
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
    <div class="table-responsive">
	<table class="table table-sm table-bordered" width="100%">
    <thead>	  
      <tr>
        <th>Student Name</th>
        <th>Std Id</th>	
        <th>Email Address</th>	
        <th>Program</th>
        <th>Start Date</th>
        <th>End Date</th>
        <th>Status</th>
        <th>Warning Letter<br>Type Sent</th>
        <th>Logs</th>
      </tr>
    </thead>
    <tbody>	
	<?php
	if(mysqli_num_rows($qurySql)){
		while ($row_nm = mysqli_fetch_assoc($qurySql)){
		$snoid = $row_nm['sno'];
		$fname = $row_nm['fname'];				
		$lname = $row_nm['lname'];
		$fullname = ucfirst($fname).' '.ucfirst($lname);
		$refid = $row_nm['refid'];
		$student_id = $row_nm['student_id'];
		$email_address = $row_nm['email_address'];
		$prg_name1 = $row_nm['prg_name1'];
		$prg_intake = $row_nm['prg_intake'];
		
		$queryGet4 = "SELECT warning_letter FROM `start_college_attendance` WHERE app_id='$snoid'";
		$getWL = '';
		$queryRslt4 = mysqli_query($con, $queryGet4);
		if(mysqli_num_rows($queryRslt4)){
			while ($row_nm4 = mysqli_fetch_assoc($queryRslt4)){
				$getWL .= $row_nm4['warning_letter'].'<br>';
			}
		}else{
			$getWL .= 'N/A';
		}
		
		$queryGet5 = "SELECT commenc_date, expected_date FROM contract_courses where program_name='$prg_name1' AND intake='$prg_intake'";
		$queryRslt5 = mysqli_query($con, $queryGet5);
		$row_nm5 = mysqli_fetch_assoc($queryRslt5);
		$commenc_date = $row_nm5['commenc_date'];
		$expected_date = $row_nm5['expected_date'];
		
		$slctQry_23 = "SELECT email_address FROM international_airport_student where app_id='$snoid'";
		$checkQuery_23 = mysqli_query($con, $slctQry_23);
		if(mysqli_num_rows($checkQuery_23)){
			$rowStartValue_33 = mysqli_fetch_assoc($checkQuery_23);
			$email_address_33 = $rowStartValue_33['email_address'];
		}else{
			$email_address_33 = '';			
		}
		
		$slctQry_25 = "SELECT with_dism FROM start_college where app_id='$snoid'";
		$checkQuery_25 = mysqli_query($con, $slctQry_25);		
		if(mysqli_num_rows($checkQuery_25)){
			$rowStartValue_35 = mysqli_fetch_assoc($checkQuery_25);
			$with_dism = $rowStartValue_35['with_dism'];
		}else{
			$with_dism = '';			
		}
	?>
	<tr>
		<td><?php echo $fname.' '.$lname; ?></td>
		<td  style="white-space: nowrap;"><?php echo $student_id; ?></td>
		<td><?php echo $email_address.'<br>'.$email_address_33; ?></td>				
		<td><?php echo $prg_name1; ?></td>				
		<td><?php echo $commenc_date; ?></td>				
		<td><?php echo $expected_date; ?></td>	
		<td><?php echo $with_dism; ?></td>
		<td><?php echo $getWL; ?></td>
		<td>		
		<span class="btn btn-sm btn-info allClass" data-toggle="modal" data-target="#allModel" data-id="<?php echo $snoid; ?>" data-name="<?php echo $fullname; ?>">Logs</span>
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
	<?php if($page_no > 1){ echo "<li class='page-item'><a href='?page_no=1' class='page-link'>First Page</a></li>"; } ?>
    
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

<div class="modal fade" id="allModel">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">	  
	  <div class="modal-header">
        <h4 class="modal-title"><span class="stNameLogs"></span></h4>
		<button type="button" class="close" data-dismiss="modal">×</button>
      </div>	  
	  <div class="loading_icon"></div>
      <div class="modal-body">
	  <div class="table-responsive">
		<table class="table table-bordered table-sm table-striped table-hover">
	<thead>
	<tr>
	<th>Sno.</th>
	<th>Letter Type</th>
	<th>Download</th>
	<th>Remarks</th>
	<th>Added Datetime</th>
	<th>Added By</th>
	</tr>
	</thead>
	<tbody class="getSIFLogsDiv">
	</tbody>
	</table>
      </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
$(document).on('click', '.allClass', function(){
	var idmodel = $(this).attr('data-id');
	var getHeadVal = $(this).attr('data-name');
	$('.stNameLogs').html(getHeadVal);
	$('.loading_icon').show();	
	$.post("../responseStart.php?tag=getWLLogs",{"idno":idmodel},function(il){
		$('.getSIFLogsDiv').html("");
		if(il==''){
			$('.getSIFLogsDiv').html("<tr><td colspan='6'><center>Not Found</center></td></tr>");
		}else{
		 for (i in il){
			$('<tr>' + 
			'<td>'+il[i].idLogs+'</td>'+
			'<td>'+il[i].warning_letter+'</td>'+
			'<td style="white-space: nowrap;">'+il[i].warning_letterFile+'</td>'+
			'<td>'+il[i].remarks+'</td>'+
			'<td>'+il[i].update_datetime+'</td>'+
			'<td>'+il[i].updated_by_name+'</td>'+
			'</tr>').appendTo(".getSIFLogsDiv");
		}
		}		
		$('.loading_icon').hide();	
	});	
});	
</script>

<?php 
include("../../footer.php");
?>