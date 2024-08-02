<?php
ob_start();
include("../../db.php");
include("../../header_navbar.php");

if(!isset($_SESSION['sno'])){
    header("Location: ../../login");
    exit(); 
}

if(isset($_SESSION['sno']) && !empty($_SESSION['sno'])){
$sessionSno = $_SESSION['sno'];
$result1 = mysqli_query($con,"SELECT sno,role,username,email,report_allow FROM allusers WHERE sno = '$sessionSno'");
 while ($row1 = mysqli_fetch_assoc($result1)) {
   $adminrole = mysqli_real_escape_string($con, $row1['role']);
   $counselor_email = mysqli_real_escape_string($con, $row1['email']);
   $counselor_uname = mysqli_real_escape_string($con, $row1['username']);   
   $report_allow = mysqli_real_escape_string($con, $row1['report_allow']);   
 }
}else{
	$adminrole = '';
	$counselor_email = '';
	$counselor_uname = '';
	$report_allow = '';
} 

if(($adminrole == 'Admin') || ($adminrole == 'Excu')){
	
if(!empty($_GET['noti']) && isset($_GET['noti'])){
	$notif =  $_GET['noti'];
	mysqli_query($con, "UPDATE `notification_aol` SET  `status`='0', `bgcolor`='#fff' WHERE `sno`='$notif'");
}	
?> 

<style>
body { background:#eeee;}
</style>

<link rel="stylesheet" href="../../css/sweetalert.min.css">
<script src="../../js/sweetalert.min.js"></script>

<section>
<div class="main-div container-fluid">
<div class="col-sm-12 application-tabs mt-2">
	<div class="admin-dashboard "> 
	<div class="col-sm-6 offset-sm-3 col-lg-4 offset-lg-4 mb-4">
	<select class="refundVRStatus form-control">
		<option value="">Select Option</option>  
		<option value="cdsbot"> Commission Details Send by Operation Team</option>
		<!--option value="crr"> Commission Request Raised</option-->
		<option value="cnp">Commission not Proccessed</option>
		<option value="cp">Commission Proccessed</option>	
		<option value="tt_rdabt">Refund Docs Approved By Team(Status Pending)</option> 
		<option value="tt_Yes_settled">Refund Approved(Settled)</option>	
		<option value="tt_Yes_notsettled">Refund Approved(Not Settled)</option>	
	</select>
	<p class="text-center mt-2 totalcnt" style="display:none;"><b>Total: </b> <span class="totalcnt11">89</span></p>
	</div>
		
		<div class="col-sm-12">
			<div class="table-responsive">          
			  <table class="table table-bordered table-hover">
				<thead>
				  <tr>
					<th>Full Name</th>
					<th>Reference Id</th>
					<th>Status</th>
					<th>Action</th>
				  </tr>
				</thead>
				<tbody class="vrList">
				<?php
				if(isset($_GET['aid']) && !empty($_GET['aid'])){
				$get_aid = $_GET['aid'];
				$expVal = explode("error_", $get_aid);
					$queryVgr = "(SELECT sno,fname,lname,refid,v_g_r_invoice,v_g_r_amount,comrefund_remarks,com_refund_datetime,inovice_status,v_g_r_status,file_upload_vgr_status,tt_upload_report_status,file_upload_vr_status FROM st_application where fh_status!='' AND v_g_r_status!='' AND sno='$expVal[1]') UNION (SELECT sno,fname,lname,refid,v_g_r_invoice,v_g_r_amount,comrefund_remarks,com_refund_datetime,inovice_status,v_g_r_status,file_upload_vgr_status,tt_upload_report_status,file_upload_vr_status FROM st_application where fh_status!='' AND v_g_r_status!='' AND sno !='$expVal[1]' order by sno ASC)";
				}else{
					$queryVgr = "SELECT sno,fname,lname,refid,v_g_r_invoice,v_g_r_amount,comrefund_remarks,com_refund_datetime,inovice_status,v_g_r_status,file_upload_vgr_status,tt_upload_report_status,file_upload_vr_status FROM st_application where fh_status!='' AND v_g_r_status!=''";
				}
				// die;
				$get_query = mysqli_query($con, $queryVgr);
				while ($row_nm = mysqli_fetch_assoc($get_query)){
					$ssno = mysqli_real_escape_string($con, $row_nm['sno']);
					$fname = mysqli_real_escape_string($con, $row_nm['fname']);
					$lname = mysqli_real_escape_string($con, $row_nm['lname']);
					$refid = mysqli_real_escape_string($con, $row_nm['refid']);
					
					$v_g_r_amount1 = mysqli_real_escape_string($con, $row_nm['v_g_r_amount']);
					$v_g_r_invoice = mysqli_real_escape_string($con, $row_nm['v_g_r_invoice']);
					
					$inovice_status = mysqli_real_escape_string($con, $row_nm['inovice_status']);
					$v_g_r_status = mysqli_real_escape_string($con, $row_nm['v_g_r_status']);
					$file_upload_vgr_status = mysqli_real_escape_string($con, $row_nm['file_upload_vgr_status']);
					$file_upload_vr_status = mysqli_real_escape_string($con, $row_nm['file_upload_vr_status']);
					$tt_upload_report_status = mysqli_real_escape_string($con, $row_nm['tt_upload_report_status']);
					
				?>
				 <tr class="error_<?php echo $ssno;?>">
					<td><?php echo $fname.' '.$lname; ?></td>
					<td><?php echo $refid; ?></td>			
                    <td><?php echo $v_g_r_status; ?></td>					
					<td>
					<?php 
	//V-G : Commission				
					if($v_g_r_status == 'V-G'){
					if(($v_g_r_invoice == '') && ($v_g_r_amount1 == '')){
					?>
					 <div class="btn checklistClassred btn-sm"><i class="fas fa-times" data-toggle="tooltip" data-placement="top" title="Refund Documents Pending"></i></div>
					<?php
					} else {
					if($inovice_status == ''){ ?>
						<div class="btn checklistClassyellow btn-sm invoiceStatusClass" data-toggle="modal" data-target="#invoiceStatusModel" data-id="<?php echo $ssno;?>"><i class="fas fa-upload" data-toggle="tooltip" data-placement="top" title="Commission Request Raised"></i></div>
					<?php }
					if($inovice_status == 'No'){
					?>
					<div class="btn checklistClassred btn-sm invoiceStatusClass" data-toggle="modal" data-target="#invoiceStatusModel" data-id="<?php echo $ssno;?>"><i class="fas fa-upload" data-toggle="tooltip" data-placement="top" title="Commission not Proccessed"></i></div>
					<?php } if($inovice_status == 'Yes'){
					?>
						<div class="btn checklistClassgreen btn-sm invoiceStatusClass" data-toggle="modal" data-target="#invoiceStatusModel" data-id="<?php echo $ssno;?>"><i class="fas fa-upload" data-toggle="tooltip" data-placement="top" title="Commission Proccessed"></i></div>
					<?php } } } ?>
					<?php
	//V-R : Refund				
					if($v_g_r_status == 'V-R'){ 
					if(($file_upload_vgr_status == '') && ($tt_upload_report_status == '')){ ?>
                    <div class="btn checklistClassred btn-sm"><i class="fas fa-times" data-toggle="tooltip" data-placement="top" title="Refund Documents Pending"></i></div>
					<?php } 
					
					if(($file_upload_vgr_status == 'No') && ($tt_upload_report_status == '')){ ?>
                    <div class="btn checklistClassred btn-sm"><i class="fas fa-times" data-toggle="tooltip" data-placement="top" title="Refund Documents Pending"></i></div>
					<?php } 
					
					if(($file_upload_vgr_status == 'Yes') && ($tt_upload_report_status == '')){ ?>
                    <div class="btn checklistClassyellow btn-sm invoiceStatusClass" data-toggle="modal" data-target="#invoiceStatusModel" data-id="<?php echo $ssno;?>"><i class="fas fa-check" data-toggle="tooltip" data-placement="top" title="Refund Docs Pending"></i></div>
					<?php }
					
					if(($file_upload_vgr_status == 'Yes') && ($tt_upload_report_status =='No')){ ?>
						<div class="btn checklistClassred btn-sm invoiceStatusClass" data-toggle="modal" data-target="#invoiceStatusModel" data-id="<?php echo $ssno;?>"><i class="fas fa-check" data-toggle="tooltip" data-placement="top" title="Refund Docs Approved By Team"></i></div>
					<?php }		
					
					if(($file_upload_vgr_status == 'Yes') && ($tt_upload_report_status =='Yes')){ ?>
						<div class="btn checklistClassgreen btn-sm invoiceStatusClass" data-toggle="modal" data-target="#invoiceStatusModel" data-id="<?php echo $ssno;?>"><i class="fas fa-check" data-toggle="tooltip" data-placement="top" title="Refund Recvd."></i></div>
					<?php }																				
					?>
					
					<?php } ?>					
					</td>
				  </tr>
				<?php } ?>
				</tbody>
			  </table>
			</div>
		</div>		
	</div>
  </div>			
</div>
</section>

<?php if(!empty($_GET["aid"])){ ?>
<script>
	$(".<?php echo $_GET["aid"];?>").css({"background-color": "#A8D8F4"});
	$("#<?php echo $_GET["aid"];?>").prop('checked', true);
</script>
<?php } ?>

<div class="modal fade" id="invoiceStatusModel" role="dialog">
<div class="modal-dialog modal-md">
<div class="modal-content">
<div class="modal-header">
	<span class="titleHead"></span>
	<button type="button" class="close" data-dismiss="modal">&times;</button>
</div>
<div class="modal-body">
<div class="vgrInvoicelist"></div>
<div class="loading_icon"></div>
<div class="vgrInvoicelist1"></div>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div></div>
</div>
</div>

<script>
$(document).on('click', '.invoiceStatusClass', function(){
	var idmodel = $(this).attr('data-id'); 
	$('.vgrsnid').attr('value' ,idmodel);
	$('.loading_icon').show();	
	$.post("../response.php?tag=getInvicestatusReport1",{"idno":idmodel},function(d){	
		$('.vgrInvoicelist1').html("");
		$('<div>' +	
		'' + d[0].titleHead + '' +
		'' + d[0].tt_duration_status + '' +
		'' + d[0].tt_duration + '' +
		'' + d[0].ttFormUpload + '' +
		'</div>').appendTo(".vgrInvoicelist1");	
		$('.loading_icon').hide();
		
	$('.ttfilebtn').on('click', function(){
		var inovice_status = $('#inviceFile').val();
		var invoicefile = $('.invoicefile').val();
		var inovice_remarks = $('.inovice_remarks').val();
		if(inovice_status == ''){
			$('#inviceFile').css("border","1px red solid");
			return false;
		}
		if(inovice_status == 'Yes'){
			if(invoicefile == ''){
				$('.invoicefile').css("border","1px red solid");
				return false;
			}		
		}
		if(inovice_status == 'No'){
			if(inovice_remarks == ''){
				$('.inovice_remarks').css("border","1px red solid");
				return false;
			}
		}
	});
		
	$('.vrRefundttfile').on('click', function(){
		var tturs = $('.tturs').val();
		var tturfile = $('.tturfile').val();
		var tturrmrk = $('.tturrmrk').val();
		if(tturs == ''){
			$('.tturs').css("border","1px red solid");
			return false;
		}
		if(tturs == 'Yes'){
			if(tturfile == ''){
				$('.tturfile').css("border","1px red solid");
				return false;
			}		
		}
		if(tturs == 'No'){
			if(tturrmrk == ''){
				$('.tturrmrk').css("border","1px red solid");
				return false;
			}
		}
	});
	
	$('.settled_vr').on('change', function(){
		var getVr = $(this).val();
		if(getVr == ''){
			$('.settledDiv').hide();
			$('.notsettledDiv').hide();
		}
		if(getVr == 'Settled'){
			$('.settledDiv').hide();
			$('.notsettledDiv').show();
		}
		if(getVr == 'Not Settled'){
			$('.settledDiv').show();
			$('.notsettledDiv').hide();
		}
	});
	
	$('.vrRefundttfile_1').on('click', function(){		
		var tturs_2 = $('.tturs_1').val();
		if(tturs_2 == ''){
			$('.tturs_1').css("border","1px red solid");
			return false;
		}
	});
		
 });
});	

$(document).on('change', '.refundVRStatus', function(){
	var idmodel = $(this).val(); 
	$('.loading_icon').show();
	$.post("../response.php?tag=refundVRStatusList",{"nameval":idmodel},function(d){
	var multiple = d.length;
	$('.totalcnt11').html(multiple);
	$('.totalcnt').show();
	if(d == ""){	
		alert("Not found");
		$('.vrList').html(" ");		
		$('.loading_icon').hide();
	}else{			
		$('.vrList').html(" ");		
		for (i in d) {
			$('<tr '+d[i].ssno+'>' +
			'<td>'+d[i].fullname+'</td>' +
			'<td>'+d[i].refid+'</td>' + 
			'<td>'+d[i].v_g_r_status+'</td>' + 
			'<td>'+d[i].inovice_status12+'</td>'+
			'</tr>').appendTo(".vrList");
		}
	}
		$('.loading_icon').hide();
});
});
</script>
<?php 
include("../../footer.php");

}else{
	header("Location: ../../application");
}
?>