<?php
ob_start();
include("../../db.php");
include("../../header_navbar.php");

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
	$getIntake3 = "AND prg_intake='$getIntake2'";
}else{
	$getIntake2 = '';
	$getIntake3 = '';
}

if(isset($_POST['srchClickbtn'])){
	$search = $_POST['inputval'];
	$intakeInput = $_POST['intakeInput'];
	header("Location: ../collegeStart/strtdEnrld.php?getsearch=$search&getIntake=$intakeInput&page_no=1");
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

$result_count = mysqli_query($con, "SELECT COUNT(start_college.app_id) As total_records FROM `start_college` INNER JOIN st_application ON st_application.sno=start_college.app_id WHERE start_college.with_dism!='' AND (start_college.with_dism='Started' OR start_college.with_dism='Contract Signed') $searchInput $getIntake3");
$total_records = mysqli_fetch_array($result_count);
$total_records = $total_records['total_records'];
$total_no_of_pages = ceil($total_records / $total_records_per_page);
$second_last = $total_no_of_pages - 1;

$rsltQuery = "SELECT st_application.sno, st_application.fname, st_application.lname, st_application.refid, st_application.student_id, st_application.passport_no, st_application.email_address, st_application.mobile, st_application.address1, st_application.prg_name1, st_application.prg_intake, start_college.with_dism, start_college.refund_rp, start_college.datetime_at, start_college.in_w_d, start_college.with_file, start_college.started_program, start_college.started_start_date, start_college.started_end_date FROM `start_college` INNER JOIN st_application ON st_application.sno=start_college.app_id WHERE start_college.with_dism!='' AND (start_college.with_dism='Started' OR start_college.with_dism='Contract Signed') $searchInput $getIntake3 order by start_college.sno DESC LIMIT $offset, $total_records_per_page";
?> 
<link rel="stylesheet" href="../../css/sweetalert.min.css">
<script src="../../js/sweetalert.min.js"></script>
<style>
.error_color{border:2px solid #de0e0e;}
.validError{border:2px solid #ccc;}
</style>
<section class="container-fluid">
<div class="main-div">
<div class="admin-dashboard">
<div class="row">	

<div class="col-sm-3 col-lg-3 mb-3">
<h3 class="m-0">Student Status</h3>
</div>

<div class="col-sm-3 col-lg-3 mb-3">
<form method="POST" action="excelSheet.php" autocomplete="off">
	<input type="hidden" name="role" value="<?php echo 'Start_Enrolled_Status'; ?>">
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
        <th>Profile Details</th>	
        <th>Passport</th>	
        <th>Start/End Date</th>
        <th>In/W/D</th>		
        <th>Updated On</th>	
        <th>Updated By</th>	
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
		$mobile = $row_nm['mobile'];
		$address1 = $row_nm['address1'];
		$prg_name1 = $row_nm['prg_name1'];
		$prg_intake = $row_nm['prg_intake'];
		$prg_intake = $row_nm['prg_intake'];		
			
		$with_dism = $row_nm['with_dism'];		
		$datetime_at = $row_nm['datetime_at'];		
		$in_w_d = $row_nm['in_w_d'];

		$started_program2 = $row_nm['started_program'];
		if(!empty($started_program2)){
			$started_program = '<b>Program: </b>'.$started_program2.'<br>';
			$started_start_date = '<b>Start Date: </b>'.$row_nm['started_start_date'].'<br>';
			$started_end_date = '<b>End Date: </b>'.$row_nm['started_end_date'];
		}else{
			$started_program = '';
			$started_start_date = '';
			$started_end_date = '';
		}
	?>
	<tr>
		<td><?php echo $fname.' '.$lname; ?></td>
		<td><?php echo $refid.'/<br>'.$student_id; ?></td>		
		<td>
		<?php echo '<b>Email: </b>'.$email_address; ?><br>
		<?php echo '<b>Mobile: </b>'.$mobile; ?><br>
		<?php echo '<b>Address: </b>'.$address1; ?>
		</td>			
		<td><?php echo $passport_no; ?></td>			
		<td><?php echo $started_program.''.$started_start_date.''.$started_end_date; ?></td>
		<td style="white-space: nowrap;"><?php echo $with_dism; ?></td>		
		<td><?php echo $datetime_at; ?></td>			
		<td><?php echo $in_w_d; ?></td>
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
      <div class="modal-body getStartLists"></div>
      <div class="modal-footer"></div>
    </div>
  </div>
</div>

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
	<th>In/W/D</th>	
	<th>Inprogress Status</th>
	<th>Refund Type</th>
	<th>Refund Processed</th>
	<th>Refund Amount</th>
	<th>Followup Status</th>
	<th>Followup Date</th>
	<th>Remarks</th>
	<th>Updated On</th>
	<th>Added By</th>
	</tr>
	</thead>
	<tbody class="getAllLogsDiv">
	</tbody>
	</table>
      </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="editNameModel">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Update Details - <span class="stNameLogs"></span></h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
       <div class="modal-body">
		<div class="editNameChange"></div>
       </div>
      <div class="modal-footer">
      </div>
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
	$.post("../responseStart.php?tag=getStartLists",{"idno":getVal, "name":getVal2, "passp":getVal3, "stid":getVal4, "refid":getVal5},function(d){
		$('.getStartLists').html("");
		$('' + d[0].getStartLists +'').appendTo(".getStartLists");
		
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
</script>

<script type="text/javascript">
$(document).on('click', '.allClass', function(){
	var idmodel = $(this).attr('data-id');
	var getHeadVal = $(this).attr('data-name');
	$('.stNameLogs').html(getHeadVal);
	$('.loading_icon').show();	
	$.post("../responseStart.php?tag=getAllLogs",{"idno":idmodel},function(il){
		$('.getAllLogsDiv').html("");
		if(il==''){
			$('.getAllLogsDiv').html("<tr><td colspan='10'><center>Not Found</center></td></tr>");
		}else{
		 for (i in il){
			$('<tr>' + 
			'<td>'+il[i].idLogs+'</td>'+
			'<td>'+il[i].with_dismLogs+'</td>'+
			'<td style="white-space: nowrap;">'+il[i].inpStLogs+'</td>'+
			'<td>'+il[i].refund_rpLogs+'</td>'+
			'<td>'+il[i].rproccessLogs+'</td>'+
			'<td>'+il[i].yesp_amountLogs+'</td>'+			
			'<td>'+il[i].followup_statusLogs+'</td>'+
			'<td>'+il[i].follow_dateLogs+'</td>'+
			'<td>'+il[i].remarksLogs+'</td>'+
			'<td>'+il[i].updateLogs+'</td>'+
			'<td>'+il[i].in_w_dLogs+'</td>'+
			'</tr>').appendTo(".getAllLogsDiv");
		}
		}		
		$('.loading_icon').hide();	
	});	
});	
</script>

<script type="text/javascript">
$(document).on('change', '.ipDiv', function () {
	var getVal = $(this).val();
	if(getVal == 'Inprogress'){
		$('.InprgsDiv').show();
	}else{
		$('.InprgsDiv').hide();		
	}
});
$(document).on('change', '.wDisDiv', function () {
	var getVal = $(this).val();
	if(getVal == 'Withdrawal' || getVal == 'Dismissed'){
		$('.contractSgndDiv').hide();
		$('.startedDiv').hide();
		$('.rfndRPDiv').show();
		$('.inpsDiv').hide();		
		$('.flupDiv').hide();
		$('.flwpDateDiv').hide();
		$('.rfndPrDiv').hide();		
		$('.yespDiv').hide();
		$('.withFileDiv').hide();
	}else if(getVal == 'Graduate'){
		$('.contractSgndDiv').hide();
		$('.startedDiv').hide();
		$('.inpsDiv').show();
		$('.rfndRPDiv').hide();		
		$('.flupDiv').hide();
		$('.flwpDateDiv').hide();
		$('.rfndPrDiv').hide();		
		$('.yespDiv').hide();
		$('.withFileDiv').hide();
	}else if(getVal == 'Contract Signed'){
		$('.contractSgndDiv').show();
		$('.startedDiv').hide();
		$('.inpsDiv').hide();
		$('.rfndRPDiv').hide();		
		$('.flupDiv').hide();
		$('.flwpDateDiv').hide();
		$('.rfndPrDiv').hide();		
		$('.yespDiv').hide();
		$('.withFileDiv').hide();
	}else if(getVal == 'Started'){
		$('.contractSgndDiv').hide();
		$('.startedDiv').hide();
		$('.inpsDiv').hide();
		$('.rfndRPDiv').hide();		
		$('.flupDiv').hide();
		$('.flwpDateDiv').hide();
		$('.rfndPrDiv').hide();		
		$('.yespDiv').hide();
		$('.withFileDiv').hide();
	}else{
		$('.contractSgndDiv').hide();
		$('.startedDiv').hide();
		$('.rfndRPDiv').hide();		
		$('.inpsDiv').hide();		
		$('.flupDiv').hide();
		$('.flwpDateDiv').hide();
		$('.rfndPrDiv').hide();		
		$('.yespDiv').hide();
		$('.withFileDiv').hide();
	}
});
$(document).on('change', '.rfndRPList', function () {
	var getVal = $(this).val();
	if(getVal == 'Refund Request'){
		$('.flupDiv').show();
		$('.rfndPrDiv').hide();
		$('.yespDiv').hide();		
		$('.withFileDiv').show();
	}else if(getVal == 'Refund Processed'){	
		$('.flupDiv').hide();
		$('.flwpDateDiv').hide();
		$('.rfndPrDiv').show();			
		$('.withFileDiv').show();		
	}else{
		$('.flupDiv').hide();
		$('.flwpDateDiv').hide();
		$('.rfndPrDiv').hide();		
		$('.yespDiv').hide();			
		$('.withFileDiv').hide();	
	}
});
$(document).on('change', '.fdDiv', function () {
	var getVal = $(this).val();
	if(getVal == 'Followup'){
		$('.flwpDateDiv').show();
	}else{
		$('.flwpDateDiv').hide();
	}
});
$(document).on('change', '.contractSgndDiv', function () {
	var getVal = $(this).val();
	if(getVal == 'Followup'){
		$('.flwpDateDiv').show();
	}else{
		$('.flwpDateDiv').hide();		
	}
});

$(document).on('change', '.rproccessDiv', function () {
	var getVal = $(this).val();
	if(getVal == 'Yes'){
		$('.yespDiv').show();
	}else if(getVal == 'No'){
		$('.yespDiv').hide();		
	}else{
		$('.yespDiv').hide();		
	}
});

$(document).on('change', '.pcDiv', function () {
	var getVal = $(this).val();
	if(getVal == 'Yes'){
		$('.startedDiv').show();
	}else if(getVal == 'No'){
		$('.startedDiv').hide();		
	}else{
		$('.startedDiv').hide();		
	}
});
</script>

<script type="text/javascript">
$(document).on('click', '.editNameClass', function () {
	var getVal = $(this).attr('data-id');
	var getHeadVal = $(this).attr('st-no');
	$('.stNameLogs').html(getHeadVal);
	$.post("../responseStart.php?tag=changeNameSt",{"idno":getVal},function(obj12){
		$('.editNameChange').html("");
		$('' + obj12[0].editNameChange +'').appendTo(".editNameChange");
	});
});
</script>

<?php 
include("../../footer.php");
?>