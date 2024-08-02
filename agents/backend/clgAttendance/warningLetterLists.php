<?php
ob_start();
include("../../db.php");
include("../../header_navbar.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../../vendor/autoload.php';
$mail = new PHPMailer(true);

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

$result_count = mysqli_query($con, "SELECT COUNT(start_college_attendance.app_id) As total_records FROM start_college_attendance INNER JOIN st_application ON st_application.sno=start_college_attendance.app_id where start_college_attendance.app_id!='' GROUP BY start_college_attendance.app_id");
$total_records = mysqli_fetch_array($result_count);
$total_records = $total_records['total_records'];
$total_no_of_pages = ceil($total_records / $total_records_per_page);
$second_last = $total_no_of_pages - 1;

$rsltQuery = "SELECT start_college_attendance.sno, start_college_attendance.app_id, start_college_attendance.followup_status, start_college_attendance.follow_date, start_college_attendance.remarks, start_college_attendance.update_datetime, start_college_attendance.updated_by_name  FROM start_college_attendance INNER JOIN st_application ON st_application.sno=start_college_attendance.app_id where start_college_attendance.app_id!='' GROUP BY start_college_attendance.app_id order by start_college_attendance.sno DESC LIMIT $offset, $total_records_per_page";
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
<h3 class="m-0">Student Warning Letter - Followup</h3>
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
    <div class="table-responsive">
	<table class="table table-sm table-bordered" width="100%">
    <thead>	  
      <tr>
        <th>Student Name</th>
        <th>Ref/Std Id</th>	
        <th>Email Address</th>	
        <th>Program</th>
        <th>Start Date</th>
        <th>End Date</th>
        <th>Warning Letter<br>Type Sent</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>	
	<?php
	$qurySql = mysqli_query($con, $rsltQuery);
	if(mysqli_num_rows($qurySql)){
		while ($row_nm = mysqli_fetch_assoc($qurySql)){
		$snoid = $row_nm['sno'];
		$fname = $row_nm['fname'];				
		$lname = $row_nm['lname'];
		$fullname = ucfirst($fname).' '.ucfirst($lname);
		$refid = $row_nm['refid'];
		$student_id = $row_nm['student_id'];
		$passport_no = $row_nm['passport_no'];
		$email_address = $row_nm['email_address'];
		$prg_name1 = $row_nm['prg_name1'];
		$prg_intake = $row_nm['prg_intake'];
		
		$queryGet4 = "SELECT warning_letter FROM `start_college_attendance` WHERE app_id='$snoid'";
		$getWL = 'N/A';
		$queryRslt4 = mysqli_query($con, $queryGet4);
		if(mysqli_num_rows($queryRslt4)){
			while ($row_nm4 = mysqli_fetch_assoc($queryRslt4)){
				$getWL .= $row_nm4['warning_letter'].'<br>';
			}
		}else{
			$getWL .= '';
		}
		
		$queryGet5 = "SELECT commenc_date, expected_date FROM contract_courses where program_name='$prg_name1' AND intake='$prg_intake'";
		$getWL = 'N/A';
		$queryRslt5 = mysqli_query($con, $queryGet5);
		$row_nm5 = mysqli_fetch_assoc($queryRslt5);
		$commenc_date = $row_nm5['commenc_date'];
		$expected_date = $row_nm5['expected_date'];
	?>
	<tr>
		<td><?php echo $fname.' '.$lname; ?></td>
		<td  style="white-space: nowrap;"><?php echo $refid.' /<br>'.$student_id; ?></td>
		<td><?php echo $email_address; ?></td>				
		<td><?php echo $prg_name1; ?></td>				
		<td><?php echo $commenc_date; ?></td>				
		<td><?php echo $expected_date; ?></td>	
		<td><?php echo $getWL; ?></td>
		<td style="white-space: nowrap;">
		<span class="btn btn-sm btn-success statusClass" data-toggle="modal" data-target="#statusModal" data-id="<?php echo $snoid; ?>" data-name="<?php echo $fullname; ?>" data-refid="<?php echo $refid; ?>" data-stid="<?php echo $student_id; ?>">Add Status</span>
		
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

<div class="modal" id="statusModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><span class="getNameId"></span> warning letter</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body getAttendLists"></div>
      <div class="modal-footer"></div>
    </div>
  </div>
</div>

<script type="text/javascript">
$(document).on('click', '.statusClass', function () {
	var getVal = $(this).attr('data-id');
	var getVal2 = $(this).attr('data-name');
	$('.getNameId').html(getVal2);
	$.post("../responseStart.php?tag=getAttendLists",{"idno":getVal, "name":getVal2},function(d){
		$('.getAttendLists').html("");
		$('' + d[0].getAttendLists +'').appendTo(".getAttendLists");
		
		$(function(){
			$(".datepickerDiv").datepicker({	  
				dateFormat: 'yy-mm-dd', 
				changeMonth: false, 
				changeYear: false,
			});
		});
		
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

$(document).on('change', '.fdDiv', function () {
	var getVal = $(this).val();
	if(getVal == 'Followup'){
		$('.flwpDateDiv').show();
	}else{
		$('.flwpDateDiv').hide();
	}
});
</script>

<?php 
include("../../footer.php");
?>