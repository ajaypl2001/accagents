<?php
ob_start();
include("../db.php");
include("../header_navbar.php");
date_default_timezone_set("Asia/Kolkata");

if(!isset($_SESSION['sno'])){
    header("Location: ../login");
    exit(); 
}
?> 
<?php
$sessionSno = $_SESSION['sno'];
$result1 = mysqli_query($con,"SELECT role FROM allusers WHERE sno = '$sessionSno'");
 while ($row1 = mysqli_fetch_assoc($result1)) {
   $adminrole = mysqli_real_escape_string($con, $row1['role']);  
 }	
?> 
<style>
.clr{color:#000;}
</style>

<section>
<div class="main-div">
<div class="col-sm-12 application-tabs">
	<div class="col-lg-12 content-wrap">	
	<div class="row">	
    <?php 
	// $queryNotify = "(SELECT * FROM notification_aol WHERE (role='Admin' OR role='Excu') AND agent_id='$sessionSno' AND status='1' ORDER BY sno DESC) UNION (SELECT * FROM notification_aol WHERE (role='Admin' OR role='Excu') AND agent_id='$sessionSno' AND status!='1' ORDER BY sno DESC)";
	
	$queryNotify = "(SELECT * FROM notification_aol WHERE (role='Admin' OR role='Excu' OR role='Excu1') AND agent_id='$sessionSno') ORDER BY status DESC, sno desc";
	
	$list_notification_all = mysqli_query($con, $queryNotify);
	$count_all = mysqli_num_rows($list_notification_all);
	if($count_all){
	?>				 
	<div class="table-responsive">
	<table class="table table-bordered">                          
		 <thead>  
		 <tr>
		  <th></th>
		  <th><strong>Fullname</strong></th>
		  <th><strong>Reference Id</strong></th>
		  <th><strong>Post</strong></th>
		  <th><strong>Stage</strong></th>
		  <th><strong>Date</strong></th>
		  <th><strong>Action</strong></th>
		</tr>
		</thead>		
		<tbody>
		<?php while($row_nm = mysqli_fetch_array($list_notification_all)){
			 $sno = mysqli_real_escape_string($con,$row_nm['sno']);
			 $fullname = mysqli_real_escape_string($con,$row_nm['fullname']);
			 $refid = mysqli_real_escape_string($con,$row_nm['refid']);
			 $post = mysqli_real_escape_string($con,$row_nm['post']);
			 $stage = mysqli_real_escape_string($con,$row_nm['stage']);
			 $url = mysqli_real_escape_string($con, $row_nm['url']);
			 $bgcolor = mysqli_real_escape_string($con,$row_nm['bgcolor']);
			 $created = mysqli_real_escape_string($con,$row_nm['created']);
			 $time = date('jS F, Y h:i:s A', strtotime("$created"));					 
		?>
		<tr style='<?php echo "background:$bgcolor"; ?>' class="clr">
			<td>
			<?php if($bgcolor == '#f9f3f3'){ ?>			
			<i class="fa fa-eye" style="font-size:16px;color:red;" title="View"></i>
			<?php }else{ ?>
				<i class="fa fa-eye" style="font-size:16px;color:green;" title="Viewed"></i>
			<?php } ?>
			</td>
			<td><?php echo $fullname; ?></td>
			<td><?php echo $refid; ?></td>
			<td><?php echo $post; ?></td>
			<td><?php echo $stage; ?></td>
			<td><?php echo $time; ?></td>
			<td>
			<?php if($bgcolor == '#f9f3f3'){ ?>
				<a href="../<?php echo $url.'&noti='.$sno;?>" class="btn btn-danger">View Status</a>
			<?php }else{ ?>
				<a href="../<?php echo $url.'&noti='.$sno;?>" class="btn btn-success">View Status</a>				
			<?php } ?>
			</td>
		</tr>		
		<?php } ?>
		</tbody>
	</table>
	</div>		
	<?php }else{
		echo "<strong style='text-align:center;width: 100%;color: red;'>Not Found</strong>";
	}
	?>
	</div>
  </div> 
</div>
</div>
</section>
<?php 
include("../footer.php");	
//}else{
	//header("Location: ../../application");
//}
?>  
