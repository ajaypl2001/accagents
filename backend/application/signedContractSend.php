<?php
ob_start();
include("../../db.php");
include("../../header_navbar.php");

if($email2323 == 'admin@acc.com' || $email2323 == 'operation@acc' || $email2323 == 'acc_admin' || $email2323 == "viewdocs@acc.com"){
	
}else{
	header("Location: ../../login");
    exit();
}

if(isset($_POST['submitbtn'])){
	$status = $_POST['contract_status'];
	$snoid = $_POST['snoid'];
	$remarks = mysqli_real_escape_string($con, $_POST['contract_remarks']);
	$datetime_at = date('Y-m-d H:i:s');
	$date_at = date('Y-m-d');

	$getInQry2 = "UPDATE `st_app_more` SET `contract_status`='$status', `contract_datetime`='$date_at', `contract_remarks`='$remarks' WHERE `app_id`='$snoid'";
	mysqli_query($con, $getInQry2);
	
	if($status == 'Accept'){
		header("Location: ../../../docsignD2/HCOA-EC.php?tab=DirectorSign&stsno=$snoid");
	}else{	
		header("Location: ../backend/clg_docs/vgDocsAgent.php?msg=Successfully&stid=$snoid");
	}
}

if(!empty($_GET['stid'])){
	$stid = $_GET['stid'];
}else{
	header("Location: ../../login");
    exit();
}
?> 
<script src="../../document.js"></script>
<?php
if($roles1 == 'college' || $roles1 == 'Admin'){
	
$resultQuery4 = "SELECT sno, fname, lname, student_id, refid, email_address, dob, passport_no, idproof, prg_name1, prg_intake, fh_re_lodgement FROM st_application where sno='$stid'";
$result4 = mysqli_query($con, $resultQuery4);
$row4 = mysqli_fetch_assoc($result4);
$fname = mysqli_real_escape_string($con, $row4['fname']);
$lname = mysqli_real_escape_string($con, $row4['lname']);
$student_id = mysqli_real_escape_string($con, $row4['student_id']);
$refid = mysqli_real_escape_string($con, $row4['refid']);
$email_address = mysqli_real_escape_string($con, $row4['email_address']);
$dob = mysqli_real_escape_string($con, $row4['dob']);
$passport_no = mysqli_real_escape_string($con, $row4['passport_no']);
$prg_name1 = preg_replace('/\s+/', ' ',$row4['prg_name1']);
$prg_intake = preg_replace('/\s+/', ' ',$row4['prg_intake']);

$queryGet4 = "SELECT commenc_date, expected_date FROM `contract_courses` WHERE program_name='$prg_name1' AND intake='$prg_intake'";
$queryRslt4 = mysqli_query($con, $queryGet4);
$rowSC4 = mysqli_fetch_assoc($queryRslt4);
$start_date = $rowSC4['commenc_date'];
$end_date = $rowSC4['expected_date'];

$getQry = "SELECT * FROM `st_app_more` WHERE app_id='$stid'";
$getQryRslt = mysqli_query($con, $getQry);
$signed_contract = '';
if(mysqli_num_rows($getQryRslt)){
	$rowS = mysqli_fetch_assoc($getQryRslt);
	$stud_enrld = $rowS['stud_enrld'];
	$send_date = $rowS['send_date'];
	$signed_contract2 = $rowS['signed_contract'];
	$student_signature2 = $rowS['student_signature'];
	$signed_contract_datetime = $rowS['signed_contract_datetime'];
	$contract_status = $rowS['contract_status'];
	$contract_remarks = $rowS['contract_remarks'];
	$contract_datetime = $rowS['contract_datetime'];
	$selected_start_date = $rowS['selected_start_date'];
	$selected_end_date = $rowS['selected_end_date'];
	if(empty($send_date)){
		$sendDiv = 'Send';
		$sendBtn = 'warning';
	}else{
		$sendDiv = 'Re-Sent';
		$sendBtn = 'success';	
	}
	$GenerateDiv = 'Re-Generate';
	$GenerateBtn = 'success';
	$GenerateDownload = '<a href="../../docsignD2/'.$stud_enrld.'" download>Download Enrollment Contract</a>';	
	
	if(!empty($send_date)){
		$student_signature = '<a href="https://avaloncommunitycollege.com/docsignD2/Student_Sign/'.$student_signature2.'" download>Download<a/>';	
	}else{
		$student_signature = 'Pending';			
	}
	
	if(!empty($send_date)){
		$statusDocs = '1) Sent Email to Student- <span class="text-success"><b>Done</b></span><br>';
	}else{
		$statusDocs = '1) Send Email to Student- <span class="text-danger">Pending</span><br>';			
	}
	
	if(!empty($signed_contract2)){
		$statusDocs2 = '2) Signed By Student- <span class="text-success"><b>Done</b></span><br>';
		$signed_contract = '<a href="https://avaloncommunitycollege.com/docsignD2/uploadsWS/'.$signed_contract2.'" download>Download<a/>';
	}else{
		$signed_contract = '';
		$statusDocs2 = '2) Signed By Student- <span class="text-danger">Pending</span><br>';
	}
	
	if(!empty($contract_status)){
		$statusDocs3 = '3) Signed By College- <span class="text-success"><b>'.$contract_status.'</b></span><br>';
	}else{
		$statusDocs3 = '3) Signed By College- <span class="text-danger">Pending</span><br>';
	}
	
	$contract_remarks = $contract_remarks;
	$contract_datetime = $rowS['contract_datetime'];
	
	if(!empty($contract_status)){
		$contract_status3 = $contract_status;
	}else{
		$contract_status3 = 'Pending<br>';
	}
	
	if(!empty($contract_remarks)){
		$contract_remarks3 = $contract_remarks;
	}else{
		$contract_remarks3 = 'Pending<br>';
	}
	
	if(!empty($contract_datetime)){
		$contract_datetime3 = $contract_datetime;
	}else{
		$contract_datetime3 = 'Pending';
	}
	
}else{
	$signed_contract = 'Pending';
	$signed_contract_datetime = 'Pending';
	$student_signature = 'Pending';
	$send_date = 'Pending';
	$GenerateDiv = 'Generate';
	$GenerateBtn = 'warning';
	$GenerateDownload = '';
	$sendDiv = 'Sent';
	$sendBtn = 'warning';
	
	$statusDocs = '1) Send Email to Student- <span class="text-danger">Pending</span><br>';
	$statusDocs2 = '2) Signed By Student- <span class="text-danger">Pending</span><br>';
	$statusDocs3 = '3) Signed By College- <span class="text-danger">Pending</span>';
	$contract_status3 = 'Pending';
	$contract_remarks3 = 'Pending';
	$contract_datetime3 = 'Pending';	
	$selected_start_date = '';
	$selected_end_date = '';
}
?> 

<section class="container-fluid">
<div class="main-div">
<h2 class="mb-3 mt-3" style="text-decoration: underline;">Student Contract Signed Panel</h2>
<div class="col-lg-12 admin-dashboard content-wrap">
<div class="row">
<div class="col-12 col-lg-4 col-xl-3 col-md-6 mb-2">
<a href="travel_doc.php?st=<?php echo $stid; ?>"><i class="fas fa-arrow-left"></i> Back to Travel Support Lists(VG)</a>
</div>

<div class="col-12">
<p>
<b>Name:</b> <?php echo $fname.' '.$lname; ?> &nbsp; &nbsp; | &nbsp; &nbsp;
<b>RefID:</b> <?php echo $refid; ?> &nbsp; &nbsp; | &nbsp; &nbsp;
<b>Student Id:</b> <?php echo $student_id; ?> &nbsp; &nbsp; | &nbsp; &nbsp;
<b>Email Id:</b> <?php echo $email_address; ?> &nbsp; &nbsp; | &nbsp; &nbsp;
<b>Passport No.:</b> <?php echo $passport_no; ?>
</p>
<p>
<b>Program Name:</b> <?php echo $prg_name1; ?> &nbsp; &nbsp; | &nbsp; &nbsp;
<b>Start Date:</b> <?php echo $start_date; ?> &nbsp; &nbsp; | &nbsp; &nbsp;
<b>End Date:</b> <?php echo $end_date; ?>
</p>
</div>

</div>

<div class=" application-tabs row pt-4">
	<div class="col-lg-12 content-wrap">	
	
    <div class="table-responsive">
	<table class="table table-bordered table-hover table-striped table-sm text-left" width="100%">
	<tr>	
        <th>Docs Status</th>
		<td>
			<?php echo $statusDocs.' '.$statusDocs2.' '.$statusDocs3; ?>
		</td>
	</tr>
	<tr>	
        <th>Enrollment Contract Generate</th>
		<td>
		<form action="https://avaloncommunitycollege.com/docsignD2/HCOA-EC.php" method="post" autocomplete="off">
			<input type="text" name="selected_start_date" class="datepicker123" placeholder="New Start Date" value="<?php echo $selected_start_date; ?>">
			<input type="text" name="selected_end_date" placeholder="New End Date" class="datepicker1245" value="<?php echo $selected_end_date; ?>">
			<input type="hidden" name="snoid" value="<?php echo $stid; ?>">
			<button type="submit" title="Generate" class="btn btn-sm btn-<?php echo $GenerateBtn; ?>"><?php echo $GenerateDiv; ?></button>
			<p><b style="color:red;">Note: </b>Change Contract date if necessary, otherwise show Program date as per current intake.</p>
		</form>
		<!-- <?php //echo $GenerateDownload; ?> -->
		</td>
	</tr>
	<tr>	
        <th>OEG Send Enrollment Contract</th>
		<td>		
		<input type="email" class="studentEmail<?php echo $stid; ?> ml-2 custom-input" placeholder="Enter Email Id">
		<span class="btn btn-<?php echo $sendBtn; ?> btn-sm sendbtnClick"><?php echo $sendDiv; ?> Email to Student</span>
		<a href="javascript:void(0)" class="btn btn-sm btn-info WelLogsClass" data-toggle="modal" data-target="#WelLogsModel" data-id="<?php echo $stid; ?>">Check Logs</a><br>
		Sent Date: <?php echo $send_date; ?>
		</td>
	</tr>
	<tr>	
        <th>Student Signed Enrollment Contract Updated On</th>
		<td><?php echo $signed_contract_datetime; ?></td>
	</tr>
	<tr>	
        <th>College Sign (Institution Representative)</th>
		<td>
		<form method="post" action="">
			<select name="contract_status" class="form-control form-control-sm mb-2">
				<option value="">Select Status</option>
				<option value="Accept">Accept</option>
				<option value="Reject">Reject</option>
			</select>
			<textarea name="contract_remarks" class="form-control form-control-sm mb-2" cols="10"></textarea>
			<input type="hidden" name="snoid" value="<?php echo $stid; ?>">
			<button type="submit" name="submitbtn" class="btn btn-sm btn-success  ">Submit</button>
		</form>
		</td>
	</tr>	
	<tr>	
        <th>College Status</th>
		<td><?php echo $contract_status3; ?></td>
	</tr>
	<tr>	
        <th>College Remarks</th>
		<td><?php echo $contract_remarks3; ?></td>
	</tr>
	<tr>	
        <th>College Updated On</th>
		<td><?php echo $contract_datetime3; ?></td>
	</tr>
	<tr>	
        <th>Signed Enrollment Contract</th>
		<td><?php echo $signed_contract; ?></td>
	</tr>
 </table>  
 </div>
	</div>
  </div>
</div>
</div>

</section>

<div class="modal" id="WelLogsModel">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header border-0">
		<button type="button" class="close" data-dismiss="modal">×</button>
      </div>
	  <div class="loading_icon"></div>
      <div class="modal-body">
	  <div class="table-responsive">
		<table class="table table-bordered table-sm table-striped table-hover">
	<thead>
	<tr>
	<th>Program</th>
	<th>Start Date</th>
	<th>Email Id</th>
	<th>Send On</th>
	</tr>
	</thead>
	<tbody class="getWelLogsDiv">
	</tbody>
	</table>
      </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
$(document).on('click', '.sendbtnClick', function(){
	var stusno = '<?php echo $stid; ?>';
	var getEmail = $('.studentEmail'+stusno).val();
	var checkstr =  confirm('Are you sure you want to Sent Email to Student?');
	if(checkstr == true){
	$.post("sendStudentSign.php",{"stusno":stusno, "getEmail":getEmail},function(d){
		if(d=='1'){
			alert('Sent Email to Student!!!');				
			window.location.href = "https://avaloncommunitycollege.com/portal/backend/application/signedContractSend.php?stid="+stusno+"";
			return true; 
		}
		if(d=='4'){
			alert('Firstly, Please Generate Contract!!!');
			return false;
		}
		if(d=='2'){
			alert('Something went wrong. Please contact to S/W Team!!!');
			return false;
		}
		if(d=='3'){
			alert('Again Send Email to Student!!!');
			window.location.href = "https://avaloncommunitycollege.com/portal/backend/application/signedContractSend.php?stid="+stusno+"";
			return true;
		}
	});
	}else{
		return false;
	}
});
</script>

<script type="text/javascript">
$(document).on('click', '.WelLogsClass', function(){
	var idmodel = $(this).attr('data-id');
	var getType = 'Contract';
	$('.loading_icon').show();
	$.post("../response.php?tag=getWelLogs",{"idno":idmodel, "getType":getType},function(il){
		$('.getWelLogsDiv').html("");
		if(il == ""){
			$('<tr>' + 
				'<td colspan="5" style="text-align:center;">Not Found</td>'+
			'</tr>').appendTo(".getWelLogsDiv");
		}else{
			for (i in il){
				$('<tr>' + 
				'<td>'+il[i].pgnLogs+'</td>'+
				'<td>'+il[i].start_dateLogs+'</td>'+
				'<td>'+il[i].email_idLogs+'</td>'+
				'<td>'+il[i].send_onLogs+'</td>'+
				'</tr>').appendTo(".getWelLogsDiv");
			}
		}		
		$('.loading_icon').hide();	
	});	
});
</script>
<script>	
$( function() {
    $(".datepicker1245").datepicker({	  
		dateFormat: 'yy-mm-dd', 
		changeMonth: true, 
		changeYear: true,
		yearRange: "-10:+05"
    });
});
</script>

<style type="text/css">
	.application-tabs .table th { text-align:left !important; width:40%; }
	.application-tabs .table td { text-align:left !important;padding-left:10px; }
</style>
<?php 
include("../../footer.php");	
}else{
	header("Location: ../../login");
    exit();
}
?>  
