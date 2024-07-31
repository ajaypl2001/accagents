<?php
ob_start();
include("../../db.php");
include("../../header_navbar.php");

if($email2323 == 'admin@granville.com' || $email2323 == 'manica@granville.com' || $email2323 == 'operation@granville' || $email2323 == 'operation2@granville' || $email2323 == 'operation3@granville' || $email2323 == 'operation4@granville' || $email2323 == 'operation5@granville' || $email2323 == 'viewdocs@oeg.com'){
	
}else{
	header("Location: ../../login");
    exit();
}

if(!empty($_GET['stid'])){
	$stid = $_GET['stid'];
}else{
	header("Location: ../../clg_docs");
    exit();
}
?> 
<script src="../../document.js"></script>
<?php
if($roles1 == 'college' || $roles1 == 'Admin'){
	
$resultQuery4 = "SELECT sno, fname, lname, student_id, refid, passport_no, idproof, vg_copy_file, fh_re_lodgement FROM both_main_table where sno='$stid'";
$result4 = mysqli_query($con, $resultQuery4);
$row4 = mysqli_fetch_assoc($result4);
$fname = mysqli_real_escape_string($con, $row4['fname']);
$lname = mysqli_real_escape_string($con, $row4['lname']);
$student_id = mysqli_real_escape_string($con, $row4['student_id']);
$refid = mysqli_real_escape_string($con, $row4['refid']);
$passport_no = mysqli_real_escape_string($con, $row4['passport_no']);
$idproof = mysqli_real_escape_string($con, $row4['idproof']);
$fh_re_lodgement = mysqli_real_escape_string($con, $row4['fh_re_lodgement']);
$vg_copy_file2 = mysqli_real_escape_string($con, $row4['vg_copy_file']);
if(!empty($vg_copy_file2)){
	$vg_copy_file = '<a href="../../VG_Copy/'.$vg_copy_file2.'" download>Download</a>';
}else{
	$vg_copy_file = 'Not Uploaded';
}

if(!empty($fh_re_lodgement) && $fh_re_lodgement == 'With_Study_Permit'){
	$showWSP = '';
}else{
	$showWSP = "AND sno!='13'";
}
?> 
<section class="container-fluid">
<div class="main-div">
<h2 class="mb-3 mt-3">VG Documents</h2>
<div class="col-lg-12 admin-dashboard content-wrap">
<div class="row">
<div class="col-12">
<p>
<b>Name:</b> <?php echo $fname.' '.$lname; ?> &nbsp; &nbsp; | &nbsp; &nbsp;
<b>RefID:</b> <?php echo $refid; ?> &nbsp; &nbsp; | &nbsp; &nbsp;
<b>Student Id:</b> <?php echo $student_id; ?> &nbsp; &nbsp; | &nbsp; &nbsp;
<b>Passport No.:</b> <?php echo $passport_no; ?>
</p>
</div>
<div class="col-12 col-lg-4 col-xl-3 col-md-6 mb-2">
<form method="POST"  action="../../application/educational_services_contract.php">
	<input type="hidden" name="snoid" value="<?php echo $stid; ?>">
	<button type="submit" title="Generate" class="btn btn-sm btn-success">Download Educational Services Contract</button>
</form>
</div>
<!--form class="float-left ml-3" method="post" action="../../application/appendix_a_1.php">
	<input type="hidden" name="snoid" value="<?php //echo $stid; ?>">
	<button class="btn btn-sm btn-success">Download Appendix - A-1  Form
</form-->
<div class="col-12  col-lg-5 col-md-6 mb-2">
<?php if($email2323 == 'admin@granville.com' || $email2323 == 'operation@granville' || $email2323 == 'operation2@granville' || $email2323 == 'operation3@granville' || $email2323 == 'operation4@granville' || $email2323 == 'operation5@granville' || $email2323 == 'viewdocs@oeg.com'){ ?>
<select name="Travel_Support_Letter" class="Travel_Support_Letter<?php echo $stid; ?>">
	<option value="">Select TSL</option>
	<option value="Yes">Yes</option>
	<option value="No">No</option>
</select>
<input type="email" class="studentEmail<?php echo $stid; ?> ml-2 custom-input">
<span class="text-right btn btn-success btn-sm ml-sm-2  mt-sm-0 reSendbtnClick" data-id="<?php echo $stid; ?>">Send Welcome Email to Student</span>
<a href="javascript:void(0)" class="btn btn-sm btn-info WelLogsClass" data-toggle="modal" data-target="#WelLogsModel" data-id="<?php echo $stid; ?>">Check Logs</a>
<?php } ?>
</div>
<div class="col-12  col-lg-3 col-xl-4 col-md-12 mb-2 text-lg-right">
<a href="signedContractSend.php?stid=<?php echo $stid; ?>">Send Student to Enrollment Contract   <i class="fas fa-arrow-right"></i></a>
</div>
</div>

<div class=" application-tabs row pt-4">
	<div class="col-lg-12 content-wrap">	
	
    <div class="table-responsive">
	<table class="table table-bordered" width="100%">
    <thead>	  
      <tr style="color:#fff;background:#596164;">		
        <th>Documents Name</th>
        <th>Documents File</th>
        <th>Uploaded On</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
	<?php
	 $resultQuery = "SELECT * FROM vg_docs_name where docs_fields!='' $showWSP order by sno asc";	
	$result2 = mysqli_query($con, $resultQuery);
	while ($row = mysqli_fetch_assoc($result2)){
		 $sno = mysqli_real_escape_string($con, $row['sno']);
		 $docs_name = mysqli_real_escape_string($con, $row['docs_name']);
		 $docs_fields = mysqli_real_escape_string($con, $row['docs_fields']);
		 
		 $resultQuery2 = "SELECT * FROM vg_docs_uploaded where doc_name='$docs_name' AND application_id='$stid'";	
		 $result22 = mysqli_query($con, $resultQuery2);
		 if(mysqli_num_rows($result22)){
			 $row22 = mysqli_fetch_assoc($result22);
			 $sno2 = mysqli_real_escape_string($con, $row22['sno']);
			 $doc_file2 = $row22['doc_file'];
			 if(!empty($doc_file2)){
				 $doc_file = '<a href="../../VGDoc/'.$doc_file2.'" download>Download</a>';
			 }else{
				 $doc_file = '<span style="color:red;">Not Uploaded</span>';
			 }
			 $doc_datetime = mysqli_real_escape_string($con, $row22['doc_datetime']);
			 $status = mysqli_real_escape_string($con, $row22['status']);
			 if(empty($status)){
				$statusDiv = '<span class="btn btn-outline-warning btn-sm vgStatusClass" data-toggle="modal" data-target="#vgStatusModel" data-id='.$sno2.'><i class="fas fa-check" data-toggle="tooltip" data-placement="top" title="Status Pending"></i></span>'; 
			 }
			 if(!empty($status) && $status == 'Approved'){
				$statusDiv = '<span class="btn btn-outline-success btn-sm vgStatusClass" data-toggle="modal" data-target="#vgStatusModel" data-id='.$sno2.'><i class="fas fa-check" data-toggle="tooltip" data-placement="top" title="Approved"></i></span>'; 
			 }
			 if(!empty($status) && $status == 'Not-Approved'){
				$statusDiv = '<span class="btn btn-outline-danger btn-sm vgStatusClass" data-toggle="modal" data-target="#vgStatusModel" data-id='.$sno2.'><i class="fas fa-check" data-toggle="tooltip" data-placement="top" title="Not-Approved"></i></span>'; 
			 }			 
			 
		 }else{
			 
			
			 $doc_file = '<span style="color:red;">Not Uploaded</span>'; 
			 $doc_datetime = '<span style="color:red;">N/A</span>';
			 $statusDiv = 'N/A';
		 }
	?>
      <tr>
        <th><?php echo $docs_name; ?></th>
		<?php
		if($docs_name == 'Download Travel Support' || $docs_name == 'Download Student Confirmation Letter' || $docs_name == 'Fee Receipt' || $docs_name == 'INVOICE'){
		if($docs_name == 'Download Travel Support'){
			$travel_enrollment_path = 'travel_support_letter.php';
			$travel_enrollment_name = 'Travel Support';
			$feeR_docs_fields = '';
			$inv_Date_flds = '';
			$inv_Date_flds2 = '';
			$std_con_Date_flds = '';
		}
		if($docs_name == 'Download Student Confirmation Letter'){
			$travel_enrollment_path = 'enrollment_letter.php';
			$travel_enrollment_name = 'Student Confirmation Letter';
			$feeR_docs_fields = '';
			$inv_Date_flds = '';
			$inv_Date_flds2 = '';
			$std_con_Date_flds = '<input type="text" name="std_conf_letterdate" placeholder="Std Con L Date" class="datepicker123 custom-input" required>';
		}
		if($docs_name == 'Fee Receipt'){
			$travel_enrollment_path = '../application/FEE_RECEIPT.php';
			$travel_enrollment_name = 'Fee Receipt';
			$feeR_docs_fields = '<input type="text" name="vg_receipt" class="custom-input" placeholder="Enter Amount">';
			$inv_Date_flds = '<input type="text" name="fee_receipt_date" placeholder="Enter Fee Receipt Date" class="datepicker123 custom-input">';
			$inv_Date_flds2 = '<input type="text" name="fee_receipt_date2" placeholder="Enter Fee Due Date" class="datepicker123 custom-input">';
			$std_con_Date_flds = '';
		}
		if($docs_name == 'INVOICE'){
			$travel_enrollment_path = '../application/invoice_new.php';
			$travel_enrollment_name = 'INVOICE';
			$feeR_docs_fields = '<input type="text" name="vg_invoice" class="custom-input" placeholder="Enter BALANCE DUE">';
			$inv_Date_flds = '<input type="text" name="inv_date" placeholder="Enter INVOICE Date" class="datepicker123 custom-input">';
			$inv_Date_flds2 = '<input type="text" name="due_date" placeholder="Enter Due Date" class="datepicker123 custom-input">';
			$std_con_Date_flds = '';
		}
		?>
			<td>
			<?php if($email2323 == 'admin@granville.com' || $email2323 == 'operation@granville'){ ?>
				<form action="<?php echo $travel_enrollment_path;?>" method="post" autocomplete="off">
					<input type="hidden" name="stuid" value="<?php echo $stid; ?>">
					<input type="hidden" name="vgsno" value="<?php echo $sno; ?>">
					<input type="hidden" name="docs_name" value="<?php echo $docs_name; ?>">
					<?php echo  $feeR_docs_fields; ?>
					<?php echo  $inv_Date_flds; ?>
					<?php echo  $inv_Date_flds2; ?>
					<?php echo  $std_con_Date_flds; ?>
					<button type="submit" title="Generate" class="btn btn-sm btn-success">Generate <?php echo $travel_enrollment_name; ?></button>
				</form>
			<?php } ?>
				<?php echo $doc_file; ?>
			</td>
			<td><?php echo $doc_datetime; ?></td>
			<td></td>
		<?php }else{ ?>	  
			<td><?php
			if($docs_name == 'Air Ticket' || $docs_name == 'Vaccination Certificate' || $docs_name == 'LOA' || $docs_name == 'TT (Payment Proof)' || $docs_name == 'Approval letter' || $docs_name == 'PPR' || $docs_name == 'Insurance'){ ?>
			<form action="../uploadVg.php" enctype="multipart/form-data" class="form-horizontal-docu<?php echo $sno; ?>" method="post">
		<input type="file" name="<?php echo $docs_fields; ?>" class="form-control upload-image" id="upload-image<?php echo $sno; ?>" data-id="<?php echo $sno; ?>" />
		<input type="hidden" name="stuid" value="<?php echo $stid;?>">
		<input type="hidden" name="docs_name" value="<?php echo $docs_name;?>">
		<input type="hidden" name="ddsno" value="<?php echo $sno;?>">
		<div class="preview<?php echo $sno; ?>">	
		<?php echo $doc_file; ?>
		</div>
		<div class="progress progressDiv<?php echo $sno; ?>" style="display:none">
		<div class="progress-bar progress-bar-success progress-bar-striped pbClass<?php echo $sno; ?>" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0%">0%</div>
		</div>
		</form>		
			<?php }else{?>
			<?php echo $doc_file; }?>
			
			
			</td>
			<td><?php echo $doc_datetime; ?></td>
			<td><?php echo $statusDiv; ?></td>
		<?php } ?>
        				
      </tr>
	<?php } ?>
	<tr>
		<th>Passport</th>
		<td><?php echo '<a href="../../uploads/'.$idproof.'" download>Download</a>'; ?></td>
		<td>N/A</td>
		<td>N/A</td>
	</tr>
	<tr>
		<th>V-G Copy</th>
		<td><?php echo $vg_copy_file; ?></td>
		<td>N/A</td>
		<td>N/A</td>
	</tr>
    </tbody>	
 </table>  
 </div>
	</div>
  </div>
</div>
</div>

</section>

<div class="modal fade" id="vgStatusModel" role="dialog">
	<div class="modal-dialog modal-md">
	<div class="modal-content">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
	<div class="modal-body">
	<div class="row">
	<div class="col-sm-12">
		<h4 class="modal-title mb-4">Status</h4>
		<div class="loading_icon"></div>
		<div class="vgListDiv"></div>
	</div>
	</div>
	</div>
	</div>
	</div>
</div>

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
<style type="text/css">
	.custom-input {width: 200px; padding:3px 10px; border:1px solid #ccc; border-radius:4px; margin: 4px 2px;}
</style>

<script>
$(document).ready(function() {
$(".upload-image").on('change',function(){
	var idsno = $(this).attr('data-id');
	var idproof_image = this.files[0].size;	
	var progressbar = $('.pbClass'+idsno);
	
	// if(idproof_image <= '4194304'){
		$(".form-horizontal-docu"+idsno).ajaxForm({
			target: '.preview'+idsno,
			beforeSend: function() {
				$('.preview'+idsno).show();
				$(".progressDiv"+idsno).css("display","block");
				progressbar.width('0%');
				progressbar.text('0%');	
			},
		uploadProgress: function (event, position, total, percentComplete) {
		progressbar.width(percentComplete + '%');
		progressbar.text(percentComplete + '%');
		if(percentComplete == '100'){
			$('.progressDiv'+idsno).hide();
			$('#upload-image'+idsno).val('');
		}else{
			$('.progressDiv'+idsno).show();
		}
		},
	}).submit();
	// }else{
		// alert('File too large. File must be less than 4 MB.');
		// return false;
	// }
	});
});
</script>


<script>
$(document).on('click', '.vgStatusClass', function(){	
	var docid = $(this).attr('data-id');
	var stid = '<?php echo $stid; ?>';
	$('.loading_icon').show();
	
	$.post("../response.php?tag=vgFinalStatus",{"docid":docid, "stid":stid},function(d){
		$('.vgListDiv').html("");
		$('<div>' +	
		'' + d[0].vgdiv + '' +
		'</div>').appendTo(".vgListDiv");
		$('.loading_icon').hide();
	});
});
</script>

<script type="text/javascript">
$(document).on('click', '.reSendbtnClick', function(){
	var stusno = '<?php echo $stid; ?>';
	var emailId = $('.studentEmail<?php echo $stid; ?>').val();
	var TSL = $('.Travel_Support_Letter<?php echo $stid; ?>').val();
	$.post("sendWelCEmail.php",{"stusno":stusno, "emailId":emailId, "TSL":TSL},function(d){
		if(d=='1'){
			alert('Sent Email to Student!!!');
			return false;
		}
		if(d=='2'){
			alert('Please Generate Travel Support Letter!!!');
			return false;
		}
		if(d=='3'){
			alert('Something went wrong. Please contact to S/W Team!!!');
			return false;
		}
	});
});
</script>

<script type="text/javascript">
$(document).on('click', '.WelLogsClass', function(){
	var idmodel = $(this).attr('data-id');
	var getType = 'Welcome';
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

<?php 
include("../../footer.php");	
}else{
	header("Location: ../../login");
    exit();
}
?>  
