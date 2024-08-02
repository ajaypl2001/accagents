<?php
ob_start();
include("../../db.php");
date_default_timezone_set("Asia/Kolkata");
include("../../header_navbar.php");
?>

<section>
<div class="main-div">
<div class="col-lg-12">
<div class="panel_heading"><h3></h3></div>

<div class=" admin-dashboard">
<h3><center>Latest Application Message</center></h3>
	
	<div class="row mt-2">
	<div class="col-12">
			 
	<div class="table-responsive">
	<table class="table table-bordered">                          
		 <thead>
		 <tr>
		  <th>Student Name</th>
		  <th>Reference Id</th>
		  <th>Passport No.</th>
		  <th>Comments</th>
		  <th>Added By</th>
		  <th>Updated On</th>
		  <th>Action</th>
		</tr>
		</thead>
		<tbody>
		<?php
		$list_notification_all = "SELECT application_remarks.app_id, application_remarks.added_by_name, application_remarks.application_comments, application_remarks.datetime_at, st_application.fname, st_application.lname, st_application.refid, st_application.passport_no FROM `application_remarks` INNER JOIN st_application ON st_application.sno=application_remarks.app_id where st_application.application_form ='1' AND (application_remarks.added_by_id!='3000' OR application_remarks.added_by_id!='300') AND application_remarks.comments_color='#f9d5d5' ORDER BY application_remarks.sno DESC";
		$list_notification_all2 = mysqli_query($con, $list_notification_all);
		if(mysqli_num_rows($list_notification_all2)){
		while($row_nm = mysqli_fetch_array($list_notification_all2)){
			 $app_id = mysqli_real_escape_string($con,$row_nm['app_id']);
			 $added_by_name = mysqli_real_escape_string($con,$row_nm['added_by_name']);
			 $application_comments = mysqli_real_escape_string($con,$row_nm['application_comments']);
			 $datetime_at = mysqli_real_escape_string($con,$row_nm['datetime_at']);
			 $fname = mysqli_real_escape_string($con,$row_nm['fname']);
			 $lname = mysqli_real_escape_string($con,$row_nm['lname']);
			 $refid = mysqli_real_escape_string($con,$row_nm['refid']);
			 $passport_no = mysqli_real_escape_string($con,$row_nm['passport_no']);	 
		?>
		<tr>			
			<td><?php echo ucfirst($fname).' '.ucfirst($lname); ?></td>
			<td><?php echo $refid; ?></td>
			<td><?php echo $passport_no; ?></td>
			<td><?php echo $application_comments; ?></td>
			<td><?php echo $added_by_name; ?></td>
			<td><?php echo $datetime_at; ?></td>
			<td class="text-nowrap">
				<a href="../application/?aid=error_<?php echo $app_id;?>" class="btn-sm btn-warning">Check Application</a>
			</td>
		</tr>		
		<?php } ?>
		<?php }else{
		echo "<tr><td colspan='7'><strong style='text-align:center;width: 100%;color: red;'>Not yet any Comment found!!!</strong></td></tr>";
	} ?>
		</tbody>
	</table>
	</div>		
	
	</div>
  </div> 
</div>
</div>
</section>

<?php 
include("../../footer.php");
?>