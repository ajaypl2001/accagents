<?php
ob_start();
include("../../db.php");
date_default_timezone_set("Asia/Kolkata");
include("../../header_navbar.php");

if(!isset($_SESSION['sno'])){
    header("Location: ../../login");
    exit(); 
}
?> 
<?php
$sessionSno = $_SESSION['sno'];

if($email2323 == 'operation@aol'){
	$agent_id_not_show2 = "AND notification_aol.agent_id NOT IN ('1136')";
}else{
	$agent_id_not_show2 = '';
} 
?> 
<style>
.clr{color:#000;}
</style>

<section>
<div class="main-div">
<div class="col-sm-12 application-tabs">
	<div class="col-lg-12 content-wrap">
	<center><div id="totalVal" style="display:none;"><b>Number of Notifications: </b><span id="countVal"></span></div></center>
	<div class="row">	
    <?php 
	// $getcDate = date('Y-m-d');
	// $crntDate = date('Y-m-d', strtotime('-2 days', strtotime("$getcDate")));
	
	if(($roles1 == "Admin") && ($loa_allow == '1')){
		// $agent_noti = "(notification_aol.role = 'Admin') AND notification_aol.stage='Signed Contract Status' AND notification_aol.created >= '2019-04-18' AND";
		// $clg_pr_type = '';
		
		$agent_noti = "(notification_aol.role='Agent') AND (notification_aol.created >= '2019-04-01') AND";
		$clg_pr_type = " AND (notification_aol.clg_pr_type = 'admin' OR notification_aol.clg_pr_type = 'excu')";
	}else{
		
	if($roles1 == "Excu"){
		$agent_noti = "(notification_aol.role='Agent') AND";
		$clg_pr_type = "AND notification_aol.clg_pr_type = 'excu'";
	}
	if($roles1 == "Admin"){
		$agent_noti = "(notification_aol.role='Agent') AND";
		$clg_pr_type = "AND notification_aol.clg_pr_type = 'admin'";
	}
	if($roles1 == "Excu1"){
		$agent_noti = "(notification_aol.role='Agent') AND";
		$clg_pr_type = "AND notification_aol.clg_pr_type = 'admin'";
	}
	// if($roles1 == "Admin" && $notify_per == "1"){
	if($roles1 == "Admin" && $notify_per == "1" && $report_allow == "1"){
		// $clg_pr_type = " AND (clg_pr_type = 'admin' OR clg_pr_type = 'excu')";
		$agent_noti = "(notification_aol.role='Agent') AND (notification_aol.created >= '2019-04-01') AND";
		$clg_pr_type = " AND (notification_aol.clg_pr_type = 'admin' OR notification_aol.clg_pr_type = 'excu')";
	}
	if($roles1 == "Admin" && $notify_per == "" && $report_allow == ""){
		// $clg_pr_type = " AND (clg_pr_type = 'admin' OR clg_pr_type = 'excu')";
		$agent_noti = '';
		$clg_pr_type = " AND (notification_aol.role = 'Admin') AND (notification_aol.report_noti='Yes')";
	}
	}
// echo $agent_noti;
// die;	

	// $queryNotify = "(SELECT allusers.username,notification_aol.sno, notification_aol.fullname, notification_aol.refid, notification_aol.post, notification_aol.stage, notification_aol.url, notification_aol.created, notification_aol.bgcolor, notification_aol.action_taken
// FROM notification_aol
// INNER JOIN allusers ON notification_aol.agent_id=allusers.sno where notification_aol.role='Agent' AND status='1' AND action_taken !='Yes' $clg_pr_type ORDER BY notification_aol.sno DESC) 
// UNION 
// (SELECT allusers.username,notification_aol.sno, notification_aol.fullname, notification_aol.refid, notification_aol.post, notification_aol.stage, notification_aol.url, notification_aol.created, notification_aol.bgcolor,notification_aol.action_taken
// FROM notification_aol
// INNER JOIN allusers ON notification_aol.agent_id=allusers.sno where notification_aol.role='Agent' AND status!='1' AND action_taken !='Yes' $clg_pr_type ORDER BY notification_aol.sno DESC)";
	
	// $queryNotify = "(SELECT allusers.username,notification_aol.sno, notification_aol.application_id, notification_aol.fullname, notification_aol.refid, notification_aol.post, notification_aol.stage, notification_aol.url, notification_aol.status, notification_aol.created, notification_aol.bgcolor, notification_aol.action_taken
// FROM notification_aol
// INNER JOIN allusers ON notification_aol.agent_id=allusers.sno where $agent_noti notification_aol.action_taken !='Yes' AND notification_aol.created>='$crntDate' $clg_pr_type) ORDER BY notification_aol.status DESC, notification_aol.sno DESC";

$queryNotify = "(SELECT allusers.username,notification_aol.sno, notification_aol.application_id, notification_aol.fullname, notification_aol.refid, notification_aol.post, notification_aol.stage, notification_aol.url, notification_aol.status, notification_aol.created, notification_aol.bgcolor, notification_aol.action_taken
FROM notification_aol
INNER JOIN allusers ON notification_aol.agent_id=allusers.sno where $agent_noti notification_aol.action_taken !='Yes' $clg_pr_type $agent_id_not_show2) ORDER BY notification_aol.status DESC, notification_aol.created DESC";

// echo $queryNotify;
// die;	

	$list_notification_all = mysqli_query($con, $queryNotify);		
	$count_all = mysqli_num_rows($list_notification_all);
	if($count_all){
	?>				 
	<div class="table-responsive">
	<table class="table table-bordered">                          
		 <thead>
		 <tr style="background:#fff;">
		  <th></th>
		  <th></th>
		  <th></th>
		  <th></th>
		  <th>
		  <?php if($roles1 == "Excu"){ ?>
		  <select class="notifyStatus">
			  <option value="">Filter</option>
			  <option value="crt_Application">New Application</option>
			  <option value="signed_ol">Signed Offer Letter</option>	  
		  </select>
		  <?php }
		  if($roles1 == "Admin" && $notify_per !== "1" && $cmsn_login !== "1"){ ?>
		  <select class="notifyStatus">
			  <option value="">Filter</option>
			  <option value="rqst_loa">LOA Request</option>
			  <option value="signed_cntrt">Signed Contract</option>		  
		  </select>
		  		  
		  <?php } 
		  if($roles1 == "Admin" && $notify_per == "1" && $cmsn_login == "1"){ ?>
		  <select class="notifyStatus">
			  <option value="">Filter</option>
			  <option value="crt_Application">New Application</option>
			  <option value="signed_ol">Signed Offer Letter</option>
			  <option value="rqst_loa">LOA Request</option>
			  <option value="signed_cntrt">Signed Contract</option>		  
			  <option value="Commission_Proccessed_by_Processor">Comm. Proccessed by Processor</option>		  
			  <option value="Commission_Not_Approved_by_Processor">Comm. Not Approved by Processor</option>		  
			  <option value="Refund_Form">Refund Docs Send By Agent</option>		  
			  <option value="For_Refund_Docs_Approved">Refund Docs Approved</option>		  
			  <option value="For_Refund_Docs_Not_Approved">Refund Status Not Approved</option>		  
		  </select>
		  <?php } 
		  if($roles1 == "Admin" && $notify_per == "" && $cmsn_login == "1"){ ?>
		  <select class="notifyStatus">
			  <option value="">Filter</option>		  
			  <option value="Status_changed_to_VG">V-G</option>		  
			  <option value="Status_changed_to_VR">V-R</option>		  
			  <option value="Commission_Details_Updated">Commission Details Updated</option>		  
			  <option value="COMMISSION_Details_Remarks_For_Admin">Remarks For(Comm. Details Uploaded by Team)</option>		  
			  <option value="Refund_Documents_Status">Refund Documents Send by Team</option>		  
		  </select>
		  <?php } ?>
		  </th>
		  <th></th>
		  <th></th>
		</tr>
		 <tr>
		  <th><strong>Agent Name</strong></th>
		  <th><strong>Fullname</strong></th>
		  <th><strong>Reference Id</strong></th>
		  <th><strong>Post</strong></th>
		  <th><strong>Stage</strong></th>
		  <th><strong>Date</strong></th>
		  <th><strong>Action</strong></th>
		</tr>
		</thead>
		<div class="loading_icon"></div>
		<tbody class="searchall">
		<?php while($row_nm = mysqli_fetch_array($list_notification_all)){
			 $sno = mysqli_real_escape_string($con,$row_nm['sno']);
			 $username = mysqli_real_escape_string($con,$row_nm['username']);
			 $fullname = mysqli_real_escape_string($con,$row_nm['fullname']);
			 $refid = mysqli_real_escape_string($con,$row_nm['refid']);
			 $application_id = mysqli_real_escape_string($con,$row_nm['application_id']);
			 $post = mysqli_real_escape_string($con,$row_nm['post']);
			 $stage = mysqli_real_escape_string($con,$row_nm['stage']);
			 $url = mysqli_real_escape_string($con, $row_nm['url']);
			 $bgcolor = mysqli_real_escape_string($con,$row_nm['bgcolor']);
			 $action_taken = mysqli_real_escape_string($con,$row_nm['action_taken']);
			 $created = mysqli_real_escape_string($con,$row_nm['created']);
			 $time = date('jS F, Y h:i:s A', strtotime("$created"));					 
		?>
		<tr style='<?php echo "background:$bgcolor"; ?>' class="clr">			
			<td><?php echo $username; ?></td>
			<td><?php echo $fullname; ?></td>
			<td><?php echo $refid; ?></td>
			<td><?php echo $post; ?></td>
			<td><?php echo $stage; ?></td>
			<td><?php echo $time; ?></td>
			<td>
			
		<?php if($roles1 == "Admin" && $notify_per == "" && $cmsn_login == "1"){
			$view_status_url = "../report/vgrapplication.php?noti=$sno&aid=error_$application_id&cmsn=Yes";
		}else{
			$view_status_url = "../$url&noti=$sno";
		}
		?>
		
		<?php if($bgcolor == '#f9f3f3'){ ?>
		<a href="<?php echo $view_status_url;?>" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="View Status"><i class="fa fa-eye"></i></a>
		
		<?php if($roles1 == "Admin" && $notify_per == "" && $cmsn_login == "1"){  ?>		
		<?php }else{ ?>
			<a href="../<?php echo $url.'&takenid='.$sno;?>" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Action Taken"><i class="fas fa-edit"></i></a>
		<?php } ?>
		
		<?php }else{ ?>
		<a href="../<?php echo $url.'&noti='.$sno;?>" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="View Status"><i class="fa fa-eye"></i></a>
		
		<?php if($roles1 == "Admin" && $notify_per == "" && $cmsn_login == "1"){  ?>		
		<?php }else{ ?>
		<a href="../<?php echo $url.'&takenid='.$sno;?>" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Action Taken"><i class="fas fa-edit"></i></a>
		<?php } } ?>
			</td>
		</tr>		
		<?php } ?>
		</tbody>
	</table>
	</div>		
	<?php }else{
		echo "<strong style='text-align:center;width: 100%;color: red;'>Not Found</strong>";
	} ?>
	</div>
  </div> 
</div>
</div>
</section>

<script>
$(document).on('change', '.notifyStatus', function(){	
	var idtype1 = $(this).val();
	$('.loading_icon').show();	
	$.post("../response.php?tag=notifyfilter",{"status1":idtype1},function(d){
	if(d == ""){	
		alert("Not found");
		$('.searchall').html(" ");
		$('#totalVal').show();
		var multiple = d.length;
		$('#countVal').html(multiple);				
		$('.loading_icon').hide();
	}else{
		$('.searchall').html("");
		$('#totalVal').show();
		var multiple = d.length;
		$('#countVal').html(multiple);
		for (i in d) {
			$('<tr style="background:'+d[i].bgcolor+'" class="clr">' +
			'<td>'+d[i].username+'</td>' + 
			'<td>'+d[i].fullname+'</td>' + 
			'<td>'+d[i].refid+'</td>' +  
			'<td>'+d[i].post+'</td>' + 
			'<td>'+d[i].stage+'</td>' + 
			'<td>'+d[i].created+'</td>' + 
			'<td>'+d[i].actiontab+' '+d[i].actiontab1+'</td>' + 
			'</tr>').appendTo(".searchall");
		}
	}
		$("[data-toggle='tooltip']").tooltip();
		$('.loading_icon').hide();
	});	
});
</script>


<?php 
include("../../footer.php");	
//}else{
	//header("Location: ../../application");
//}
?>  
