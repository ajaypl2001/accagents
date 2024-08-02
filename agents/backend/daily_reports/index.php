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
if($roles1 == "Admin" && $notify_per == "1"){
	
if($email2323 == 'operation@aol'){
	$agent_id_not_show2 = "AND notification_aol.agent_id NOT IN ('1136')";
}else{
	$agent_id_not_show2 = '';
}
?>

<section class="container-fluid">
<div class="main-div">
<div class="col-sm-12 application-tabs admin-dashboard">
	<center>
	<?php 
		if(!empty($_GET['crt']) && !empty($_GET['crt1'])){
			if(!empty($_GET['campus'])){
				$campus = $_GET['campus'];
			}else{
				$campus = '';
			}					
			$st = $_GET['status'];		
			$crt = $_GET['crt'];
			$crt1 = $_GET['crt1'];
			if(($st == 'Yes') || ($st == 'No')){
				if($st == 'Yes'){
				$solsq = 'Application Approved';
				}
				if($st == 'No'){
				$solsq = 'Application Dis-approved';
				}
			}
			elseif(($st == 'sol-Yes') || ($st == 'sol-No')){
			if($st == 'sol-Yes'){
				$solsq = 'Signed Offer Letter Approved';
			}
			if($st == 'sol-No'){
				$solsq = 'Signed Offer Letter Dis-approved';
			}
			}
			elseif(($st == 'scs-Yes') || ($st == 'scs-No')){
			if($st == 'scs-Yes'){
				$solsq = 'Signed Contract Approved';
			}
			if($st == 'scs-No'){
				$solsq = 'Signed Contract Dis-approved';
			}
			}else{
				$solsq = $st;
			}
			
			echo "<p><b>Search by - </b><br><b>Campus : </b>$campus | <b>Status : </b>$solsq | <b>Date From : </b>$crt | <b>Date To : </b>$crt1</p>";
		}
	?>
	<form action="../mysqldb.php" method="post" autocomplete="off" id="requriedForm">
		<div id="totalVal" class="row justify-content-center">
			<div class="col-lg-3 col-xl-2 col-md-4 col-sm-6 text-sm-right">	<b>Check Report: </b>	</div>
			<div class="col-lg-3 col-xl-2 col-md-4 col-sm-6 mb-2">	
		<select name="campus" class="form-control">
			<option value="">Select Campus</option>
			<option value="Brampton">Brampton</option>
			<option value="Hamilton">Hamilton</option>
			<option value="Toronto">Toronto</option>
		</select></div>
		<div class="col-lg-3  col-xl-2 col-md-4 col-sm-6 mb-2">
		<select name="status" class="form-control">
			<option value="">Select Option</option>
			<option value="Application Created">Application Created</option>
			<option value="Application Status">Application Status</option>
			<option value="Yes">Application Approved</option>
			<option value="No">Application Dis-approved</option>
			<option value="Conditional Offer Letter">Conditional Offer Letter Sent</option>
			<option value="sol-Yes">Signed Offer Letter Approved</option>
			<option value="sol-No">Signed Offer Letter Dis-approved</option>
			<option value="Signed Conditional Offer Letter Status">Signed Conditional Offer Letter</option>
			<option value="Contract Sent">Contract Sent</option>
			<option value="Signed Contract Status">Signed Contract Status</option>
			<option value="scs-Yes">Signed Contract Approved</option>
			<option value="scs-No">Signed Contract Dis-approved</option>
			<option value="LOA Sent">LOA Sent</option>
			<option value="LOA Request">LOA Request</option>
			<option value="LOA_Generated">LOA Generated</option>
			<option value="LOA_Revised_Generated">LOA Revised Generated</option>
			<option value="LOA_Defer_Generated">LOA Defer Generated</option>
		</select></div>
		<div class="col-lg-3  col-xl-2 col-md-4 col-sm-6 mb-2">
		<input type="text" name="created" class="datepicker123 form-control" placeholder="Date From" required>
	</div><div class="col-lg-3  col-xl-2 col-md-4 col-sm-6 mb-2">
		<input type="text" name="created1" class="datepicker123 form-control" placeholder="Date To" required>
	</div>
	<div class="col-lg-3  col-xl-2 col-md-4 col-sm-6 mb-2">
		<input type="submit" name="reportbtn" value="Search" class="btn float-sm-left float-right btn-success">
		</div>
	</form>
<?php if(!empty($_GET['crt']) && !empty($_GET['crt1'])){ ?>	
	<form method="post" action="report_download_excel.php">
		<input name="start_date" type="hidden" value="<?php echo $crt; ?>">
		<input name="end_date" type="hidden" value="<?php echo $crt1; ?>">
		<input name="campus" type="hidden" value="<?php echo $campus; ?>">
		<input name="status" type="hidden" value="<?php echo $st; ?>">
		<input type='submit' name="downloadbtn" value="Download Excel" class="btn btn-success">
	</form>
<?php } ?>
	</center> 
	<div class="row">	 
    <?php 
	if(!empty($_GET['crt']) && !empty($_GET['crt1'])){
		if(!empty($_GET['campus'])){
			$campus2 = $_GET['campus'];
			$campus3 = "AND st_application.campus='$campus2'";
		}else{
			$campus2 = '';
			$campus3 = '';
		}		
		$st = $_GET['status'];		
		$crt = $_GET['crt'];
		$crt1 = $_GET['crt1'];
		if(($st == 'Yes') || ($st == 'No')){
			$st1 = "st_application.admin_status_crs = '$st' AND notification_aol.stage='Application Status' AND notification_aol.created >= '$crt 00:00:00' and  notification_aol.created  <= '$crt1 23:59:59'";
			$scs2 = '';
			$scs3 = '';
		} elseif(($st == 'sol-Yes') || ($st == 'sol-No')){
			if($st == 'sol-Yes'){
				$sols = 'Yes';
			}
			if($st == 'sol-No'){
				$sols = 'No';
			}
			$st1 = "st_application.signed_ol_confirm = '$sols' AND notification_aol.stage='Signed Conditional Offer Letter Status' AND notification_aol.created >= '$crt 00:00:00' and  notification_aol.created  <= '$crt1 23:59:59'";
			$scs2 = '';
			$scs3 = '';
		} elseif(($st == 'scs-Yes') || ($st == 'scs-No')){
			if($st == 'scs-Yes'){
				$scs1 = 'Yes';
			}
			if($st == 'scs-No'){
				$scs1 = 'No';
			}
			$st1 = "st_application.signed_al_status = '$scs1' AND notification_aol.stage='Signed Contract Status' AND notification_aol.created >= '$crt 00:00:00' and  notification_aol.created  <= '$crt1 23:59:59'";
			$scs2 = '';
			$scs3 = '';
		} 
		elseif($st == 'LOA_Generated'){
			$scs1 = "st_application.loa_file_date_updated_by >= '$crt 00:00:00' and  st_application.loa_file_date_updated_by  <= '$crt1 23:59:59'";
			$st1 = "$scs1";
			$scs2 = '';
			$scs3 = '';
		} 
		elseif($st == 'LOA_Revised_Generated'){
			$scs2 = "st_application.loa_revised_date >= '$crt 00:00:00' and  st_application.loa_revised_date  <= '$crt1 23:59:59'";
			$st1 = '';
			$scs3 = '';
		}
		elseif($st == 'LOA_Defer_Generated'){
			$scs3 = "st_application.loa_defer_date >= '$crt 00:00:00' and  st_application.loa_defer_date  <= '$crt1 23:59:59'";
			$st1 = '';
			$scs2 = '';
		}
		else{
			if(empty($st)){
				$st1 = "notification_aol.created >= '$crt 00:00:00' and  notification_aol.created  <= '$crt1 23:59:59'";
			}else{
				$st1 = "notification_aol.stage = '$st' AND notification_aol.created >= '$crt 00:00:00' and  notification_aol.created  <= '$crt1 23:59:59'";
			}
			$scs2 = '';
			$scs3 = '';
		}
		if($st == 'LOA_Generated' || $st == 'LOA_Revised_Generated' || $st == 'LOA_Defer_Generated'){
		$getquery = "SELECT allusers.username, st_application.sno, st_application.user_id, st_application.campus, st_application.refid, st_application.fname, st_application.lname, st_application.loa_file_date_updated_by FROM st_application
INNER JOIN allusers ON st_application.user_id = allusers.sno
WHERE st_application.campus!='' $agent_id_not_show $campus3 AND
$st1 $scs2 $scs3";
		}else{ 
		$getquery = "SELECT allusers.username, st_application.campus, st_application.user_id, st_application.admin_status_crs, st_application.signed_ol_confirm, notification_aol.sno, notification_aol.fullname, notification_aol.refid, notification_aol.post, notification_aol.stage, notification_aol.url, notification_aol.status, notification_aol.created, notification_aol.bgcolor, notification_aol.action_taken 
FROM notification_aol
INNER JOIN st_application ON notification_aol.application_id = st_application.sno
INNER JOIN allusers ON notification_aol.agent_id = allusers.sno
WHERE st_application.campus!='' $campus3 $agent_id_not_show2 AND
$st1 AND notification_aol.sno IN ( SELECT max(notification_aol.sno) FROM `notification_aol` group by notification_aol.refid )";
		}
		
$list_all = mysqli_query($con, $getquery);		
$count_all = mysqli_num_rows($list_all);
if($count_all){
	echo "<center><b>Number of Applications: $count_all</b></center>";
	?>		 
	<div class="table-responsive">
	<table class="table table-bordered">                          
		 <thead>		
		 <tr>
		  <th><strong>Campus</strong></th>
		  <th><strong>Agent Name</strong></th>
		  <th><strong>Fullname</strong></th>
		  <th><strong>Reference Id</strong></th>
		  <th><strong>Post</strong></th>
		  <?php if($st == 'LOA_Generated'){ ?>
		  <th><strong>Stage</strong></th>
		  <th><strong>LOA Generated Date</strong></th>
		  <?php }else{ ?>
			<th><strong>Stage</strong></th>
			<th><strong>Date</strong></th>
		  <?php } ?> 
		  
		  <th><strong>Action</strong></th>
		</tr>
		</thead>
		<tbody>
		<?php 
		if($st == 'LOA_Generated' || $st == 'LOA_Revised_Generated' || $st == 'LOA_Defer_Generated'){
			while($row_nm = mysqli_fetch_array($list_all)){
			 $sno23 = mysqli_real_escape_string($con,$row_nm['sno']);
			 $username = mysqli_real_escape_string($con,$row_nm['username']);
			 $fname = mysqli_real_escape_string($con,$row_nm['fname']);
			 $lname = mysqli_real_escape_string($con,$row_nm['lname']);
			 $refid = mysqli_real_escape_string($con,$row_nm['refid']);
			 $campus = mysqli_real_escape_string($con,$row_nm['campus']);
			 $created = mysqli_real_escape_string($con,$row_nm['loa_file_date_updated_by']);
			 $time = date('jS F, Y h:i:s A', strtotime("$created"));
			 if($st == 'LOA_Generated'){
				 $loa_1 = 'LOA Generated';
			 }
			 if($st == 'LOA_Revised_Generated'){
				 $loa_1 = 'LOA Revised Generated';
			 }
			 if($st == 'LOA_Defer_Generated'){
				 $loa_1 = 'LOA Defer Generated';
			 }
			?>
			<tr>			
			<td><?php echo $campus; ?></td>
			<td><?php echo $username; ?></td>
			<td><?php echo $fname.' '.$lname; ?></td>
			<td><?php echo $refid; ?></td>
			<td><?php echo $loa_1; ?></td>
			<td><?php echo $loa_1; ?></td>
			<td><?php echo $time; ?></td>
			<td>
			<a href="../../backend/application?aid=error_<?php echo $sno23; ?>" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="View Status"><i class="fa fa-eye"></i></a>
			</td>
		</tr>
		<?php }
		}else{
		while($row_nm = mysqli_fetch_array($list_all)){
			 $sno = mysqli_real_escape_string($con,$row_nm['sno']);
			 $username = mysqli_real_escape_string($con,$row_nm['username']);
			 $fullname = mysqli_real_escape_string($con,$row_nm['fullname']);
			 $refid = mysqli_real_escape_string($con,$row_nm['refid']);
			 $post = mysqli_real_escape_string($con,$row_nm['post']);
			 $stage = mysqli_real_escape_string($con,$row_nm['stage']);
			 $url = mysqli_real_escape_string($con, $row_nm['url']);
			 $bgcolor = mysqli_real_escape_string($con,$row_nm['bgcolor']);
			 $campus = mysqli_real_escape_string($con,$row_nm['campus']);
			 $action_taken = mysqli_real_escape_string($con,$row_nm['action_taken']);
			 $created = mysqli_real_escape_string($con,$row_nm['created']);
			 $time = date('jS F, Y h:i:s A', strtotime("$created"));
		?>
		<tr>			
			<td><?php echo $campus; ?></td>
			<td><?php echo $username; ?></td>
			<td><?php echo $fullname; ?></td>
			<td><?php echo $refid; ?></td>
			<td><?php echo $post; ?></td>
			<td><?php echo $stage; ?></td>
			<td><?php echo $time; ?></td>
			<td>
			<?php if($bgcolor == '#f9f3f3'){ ?>
			<a href="../<?php echo $url.'&noti='.$sno;?>" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="View Status"><i class="fa fa-eye"></i></a>
			
			<a href="../<?php echo $url.'&takenid='.$sno;?>" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Action Taken"><i class="fas fa-edit"></i></a>
			
			<?php }else{ ?>
			<a href="../<?php echo $url.'&noti='.$sno;?>" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="View Status"><i class="fa fa-eye"></i></a>
			
			<a href="../<?php echo $url.'&takenid='.$sno;?>" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Action Taken"><i class="fas fa-edit"></i></a>
			<?php } ?>
			</td>
		</tr>		
		<?php } } ?>
		</tbody>
	</table>
	</div>		
	<?php 
	}else{
		echo "<strong style='text-align:center;width: 100%;color: red;margin-top: 30px;'>Not Found</strong>";
	}
	}else{
		echo "<strong style='text-align:center;width: 100%;color: red;margin-top: 30px;'>Search Your Campus, Status and Date</strong>";
	} ?>
	</div>
  </div> 
</div>
</div>
</section>
<?php }else{
	echo "<strong style='text-align:center;width: 100%;color: red;margin-top: 30px;'>You can not access this page. Please contact to Administrator.</strong>";
}
	include("../../footer.php");
?>  
