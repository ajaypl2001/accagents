<?php
ob_start();
include("../../db.php");
include("../../header_navbar.php");
date_default_timezone_set("America/Toronto");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../../vendor/autoload.php';
$mail = new PHPMailer(true);

// if($roles1 == 'ClgCM'){

// } else {
// 	header("Location: ../../login");
//     exit();
// }

if (isset($_GET['getsearch']) && $_GET['getsearch']!="") {
	$searchTerm = $_GET['getsearch'];
	$searchInput = "AND (CONCAT(both_main_table.fname,  ' ', both_main_table.lname) LIKE '%".$searchTerm."%' OR both_main_table.refid LIKE '%".$searchTerm."%' OR both_main_table.passport_no LIKE '%".$searchTerm."%' OR both_main_table.student_id LIKE '%".$searchTerm."%')";
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

if(!empty($_GET['getVGDate'])){
	$getVGDate2 = $_GET['getVGDate'];
	$getVGDate3 = "AND v_g_r_status_datetime LIKE '%$getVGDate2%'";
}else{
	$getVGDate2 = '';
	$getVGDate3 = '';
}

if(!empty($_GET['getPName'])){
	$getPName2 = $_GET['getPName'];
	if($getPName2 == 'Human Resources Management Speciality'){
		$getPName3 = "AND (prg_name1='Human Resources Management Speciality(1)' OR prg_name1='Human Resources Management Speciality(2)' OR prg_name1='Human Resources Management Speciality(3)' OR prg_name1='Human Resources Management Speciality(4)' OR prg_name1='Human Resources Management Speciality')";
	}elseif($getPName2 == 'Healthcare Office Administration Diploma'){
		$getPName3 = "AND (prg_name1='Healthcare Office Administration Diploma(1)' OR prg_name1='Healthcare Office Administration Diploma(2)' OR prg_name1='Healthcare Office Administration Diploma(3)' OR prg_name1='Healthcare Office Administration Diploma(4)' OR prg_name1='Healthcare Office Administration Diploma')";
	}elseif($getPName2 == 'Diploma in Hospitality Management'){
		$getPName3 = "AND (prg_name1='Diploma in Hospitality Management(1)' OR prg_name1='Diploma in Hospitality Management(2)' OR prg_name1='Diploma in Hospitality Management(3)' OR prg_name1='Diploma in Hospitality Management(4)' OR prg_name1='Diploma in Hospitality Management')";
	}elseif($getPName2 == 'Business Administration Diploma'){
		$getPName3 = "AND (prg_name1='Business Administration Diploma(1)' OR prg_name1='Business Administration Diploma(2)' OR prg_name1='Business Administration Diploma(3)' OR prg_name1='Business Administration Diploma(4)' OR prg_name1='Business Administration Diploma')";
	}elseif($getPName2 == 'Global Supply Chain Management Diploma'){
		$getPName3 = "AND (prg_name1='Global Supply Chain Management Diploma(1)' OR prg_name1='Global Supply Chain Management Diploma(2)' OR prg_name1='Global Supply Chain Management Diploma(3)' OR prg_name1='Global Supply Chain Management Diploma(4)' OR prg_name1='Global Supply Chain Management Diploma')";
	}else{
		$getPName3 = "AND prg_name1='$getPName2'";
	}
}else{
	$getPName2 = '';
	$getPName3 = '';
}

if(isset($_POST['srchClickbtn'])){
	$search = $_POST['inputval'];
	$intakeInput = ''; //$_POST['intakeInput'];
	$pNameInput = ''; //$_POST['pNameInput'];
	$getVGInput = ''; //$_POST['getVGInput'];
	header("Location: ../campus/attendanceLists.php?getsearch=$search&getIntake=$intakeInput&getPName=$pNameInput&getVGDate=$getVGInput&page_no=1");
}

if (isset($_GET['page_no']) && $_GET['page_no']!="") {
	$page_no = $_GET['page_no'];
} else {
	$page_no = 1;
}

$total_records_per_page = 110;
$offset = ($page_no-1) * $total_records_per_page;
$previous_page = $page_no - 1;
$next_page = $page_no + 1;
$adjacents = "2";

$result_count = mysqli_query($con, "SELECT COUNT(m_student.app_id) As total_records
FROM m_student
INNER JOIN both_main_table ON m_student.app_id=both_main_table.sno
WHERE m_student.teacher_id!='' AND m_student.batch_status!='Completed' $searchInput");
$total_records = mysqli_fetch_array($result_count);
$total_records = $total_records['total_records'];
$total_no_of_pages = ceil($total_records / $total_records_per_page);
$second_last = $total_no_of_pages - 1;

$rsltQuery = "SELECT both_main_table.sno, both_main_table.fname, both_main_table.lname, both_main_table.email_address, both_main_table.student_id, both_main_table.prg_name1, both_main_table.prg_intake, m_student.app_id, m_student.teacher_id, m_student.betch_no
FROM m_student
INNER JOIN both_main_table ON m_student.app_id=both_main_table.sno
WHERE m_student.teacher_id!='' AND m_student.batch_status!='Completed' $searchInput order by m_student.updated_on DESC LIMIT $offset, $total_records_per_page";
?> 
<style>
.error_color{border:2px solid #de0e0e;}
.validError{border:2px solid #ccc;}
</style>

<section class="container-fluid">
<div class="main-div card"><div class="card-header">
<h3 class="my-0 py-0">Teacher Assign Lists</h3>
</div>

<div class="card-body">
<div class="row justify-content-between">	


<!-- <div class="col-sm-1 col-lg-1 mt-4 pt-2"> -->
<!--form method="POST" action="excelSheet.php" autocomplete="off">
	<input type="hidden" name="role" value="<?php //echo 'Student_Status'; ?>">
	<input type="hidden" name="keywordLists" value="<?php //echo $searchTerm; ?>">
	<input type="hidden" name="intakeInput" value="<?php //echo $getIntake2; ?>">
	<input type="hidden" name="pNameInput" value="<?php //echo $getPName2; ?>">
	<button type="submit" name="studentlist" class="btn btn-sm btn-success float-right" >Download Excel</button>
</form-->
<!-- </div> -->

<form action="" method="post" autocomplete="off" class="col-sm-6 col-lg-4 mb-3">

<label><b>Name & ID:</b></label>
	<div class="input-group">
		<input type="text" name="inputval" placeholder="Search By Stu. Name or ID" class="form-control form-control-sm" value="<?php echo $searchTerm; ?>">
		<div class="input-group-append">
			<input type="submit" name="srchClickbtn" class="btn btn-sm btn-success" value="Search">
	
</div>
</div>
</form>

<div class="col-12">			
	<div class="table-responsive">
	<table class="table table-sm table-bordered" width="100%">
    <thead>	  
      <tr class="bg-success">
        <th>Student Name</th>
        <th>vNumber</th>
        <th>Batch Name</th>
        <th>Program Name</th>
        <th>Timing</th>
        <th>Teacher Name</th>  		
        <th>Current Program</th>  		
        <th>Start Date(LOA)</th>
        <th>End Date(LOA)</th>
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
		$student_id = $row_nm['student_id'];
		$email_address = $row_nm['email_address'];
		$prg_name1 = $row_nm['prg_name1'];
		$prg_intake = $row_nm['prg_intake'];
		$teacher_id = $row_nm['teacher_id'];
		$betch_no = $row_nm['betch_no'];
		
		$queryGet4 = "SELECT commenc_date, expected_date FROM `contract_courses` WHERE program_name='$prg_name1' AND intake='$prg_intake'";
		$queryRslt4 = mysqli_query($con, $queryGet4);
		$rowSC4 = mysqli_fetch_assoc($queryRslt4);
		$start_date = $rowSC4['commenc_date'];
		$expected_date = $rowSC4['expected_date'];
		
		$queryGet34 = "SELECT * FROM `m_teacher` WHERE sno='$teacher_id'";
		$queryRslt4 = mysqli_query($con, $queryGet34);
		$rowSC4 = mysqli_fetch_assoc($queryRslt4);
		$tchrName = $rowSC4['name'];
		
		$queryGet33 = "SELECT * FROM `m_batch` WHERE sno='$betch_no'";
		$queryRslt33 = mysqli_query($con, $queryGet33);
		$rowSC33 = mysqli_fetch_assoc($queryRslt33);
		$batch_name = $rowSC33['batch_name'];		
		$program_name = $rowSC33['program_name'];	
		$shift_time = $rowSC33['shift_time'];		
	?>
	<tr>
		<td style="white-space: nowrap;"><?php echo $fname.' '.$lname; ?></td>
		<td style="white-space: nowrap;"><?php echo $student_id; ?></td>
		<td style="white-space: nowrap;">B<?php echo $batch_name; ?></td>
		<td style="white-space: nowrap;"><?php echo $program_name; ?></td>
		<td style="white-space: nowrap;"><?php echo $shift_time; ?></td>	
		<td style="white-space: nowrap;"><?php echo $tchrName; ?></td>	
		<td style="white-space: nowrap;"><?php echo $prg_name1; ?></td>		
		<td style="white-space: nowrap;"><?php echo $start_date; ?></td>
		<td style="white-space: nowrap;"><?php echo $expected_date; ?></td>	
	</tr>			
	<?php }
	}else{
		echo '<tr><td colspan="10"><center>Not Found!!!</center></td></tr>';
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
        <h4 class="modal-title">Assign To Teacher</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
		<form method="post" action="" autocomplete="off" name="assign_register" id="assign_register">
			<div class="form-group">
				<?php
				$counselor = "select sno, name from m_teacher where status='1' AND role='Teacher'"; 
				$counselorres=mysqli_query($con, $counselor);
				?>
				<label>Select Teacher<span style="color:red;">*</span></label>
				<select name="teacher_id" class="form-control teacher_id" required>
					<option>Select Option</option>
					<?php
					while ($datacouns=mysqli_fetch_array($counselorres)){
						echo '<option value='.$datacouns['sno'].'>'.ucfirst($datacouns['name']).'</option>';
					}
				?>
				</select>
			</div>
			<div class="form-group">
				<?php
				$counselor2 = "select sno, batch_name from m_batch where status='1'"; 
				$counselorres2=mysqli_query($con, $counselor2);
				?>
				<label>Select Batch<span style="color:red;">*</span></label>
				<select name="batch_name" class="form-control batch_name" required>
					<option>Select Option</option>
					<?php
					while ($datacouns2=mysqli_fetch_array($counselorres2)){
						echo '<option value='.$datacouns2['sno'].'>'.ucfirst($datacouns2['batch_name']).'</option>';
					}
				?>
				</select>
			</div>
			<input type="hidden" class="student_id" name="student_id" value="">
			<input type="hidden" class="v_no" name="v_no" value="">
			<button type="submit" name="assign_submit" class="btn btn-sm btn-success assign_submit">Assign</button>
		</form>
	  </div>
      <div class="modal-footer"></div>
    </div>
  </div>
</div>

<style type="text/css">
	.fixed-table-container th  { width:100px;}
	.fixed-table-container { overflow: scroll; }
	.fixed-table-container tr:first-child th {
    background: #333; 
}
</style>

<script>
$(document).ready(function(){
	$('.checked_all').on('change', function() {     
		$('.checkbox').prop('checked', $(this).prop("checked"));
		
		var ctyArray1 = [];
		var ctyArray12 = [];
		$(".cons_seen:checked").each(function() {
			ctyArray1.push($(this).val());
			ctyArray12.push($(this).attr('v-no'));
		});
		var countryid1 = ctyArray1.join(',') ;
		var countryid12 = ctyArray12.join(',') ;
		$('.student_id').attr('value', countryid1);		
		$('.v_no').attr('value', countryid12);		
	});
	
	$('.checkbox').change(function(){
		if($('.checkbox:checked').length == $('.checkbox').length){
			   $('.checked_all').prop('checked',true);
		}else{
			   $('.checked_all').prop('checked',false);
		}
	});
	
	$('.cons_seen').on('click', function(){
		var ctyArray1 = [];
		var ctyArray12 = [];
		$(".cons_seen:checked").each(function() { 
			ctyArray1.push($(this).val());
			ctyArray12.push($(this).attr('v-no'));
		});
		var countryid1 = ctyArray1.join(',') ;
		var countryid12 = ctyArray12.join(',') ;
		$('.student_id').attr('value', countryid1);	
		$('.v_no').attr('value', countryid12);
	});	
});
</script>
	
<script>
$(function(){
	$('.assign_submit').click(function(e) {  
		e.preventDefault();
		var student_id = $('.student_id').val();
		var counselor = $('.teacher_id').val();
		var batch_name = $('.batch_name').val();
		if(student_id == '' || counselor == '' || batch_name == '') {
			alert("Please Select Fields!!!");
			return false;
		}else{
			var $form = $(this).closest("#assign_register");
			var formData =  $form.serializeArray();
			var URL = "../responseStart.php?tag=assignTeacher";
			$.post(URL, formData).done(function(data) {
				if(data == 1){
					alert("Student Assigned to Instructor!!!");
					window.location.href = '../campus/';
					return true;					  
				 } else {				     
					alert("Something went wrong. Please contact to Administrator!!!");
                     return false;
				 }
			 });
		}
	});
});
</script>

<script>
  var fixedTable1 = fixTable(document.getElementById('fixed-table-container-1'));
</script> 
<?php 
include("../../footer.php");
?>