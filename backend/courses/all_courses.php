<?php
ob_start();
include("../../db.php");
include("../../header_navbar.php");

if(!isset($_SESSION['sno'])){
    header("Location: ../../login");
    exit(); 
}
?>
<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">	
	
<div class="main-div">           
<div class="container-fluid vertical_tab">  
	<div class="tab-content">
	<div id="Personal-Details">

	<div class="col-sm-12">
	<h3><b>All Courses</b> 
	<a class="btn btn-primary coursre_btn float-right mt-1 ml-2" href="../courses?<?php echo base64_encode('Course-Details'); ?>">Add New Course</a>
	<form action="crs_export.php" method="post" class="float-right ml-2">
		<button type="submit" name="exportbtn" class="btn btn-success coursre_btn">Export Excel</button>
	</form>
	</h3>
	</div>
	
	<div class="col-sm-12">
		<div class="table-responsive">
		<table class="table table-bordered appointment_data" width="100%">
		<thead>
			<tr>
				<th style="white-space:nowrap">Campus Name</th>
				<th style="white-space:nowrap">Program Name</th>
				<th>Intake</th>
				<th>Start Date</th>
				<th>End Date</th>
				<th>Week</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
		<?php
		$qryCrs = "select * from contract_courses order by sno desc";
		$rsltCrs = mysqli_query($con, $qryCrs); 
		while ($rowCrs = mysqli_fetch_assoc($rsltCrs)){
			$snoid = $rowCrs['sno'];
			$campus = $rowCrs['campus'];
			$program_name = $rowCrs['program_name'];
			$intake = $rowCrs['intake'];
			$week = $rowCrs['week'];
			$commenc_date = $rowCrs['commenc_date'];
			$expected_date = $rowCrs['expected_date'];
		?>
		<tr>
			<td><?php echo $campus; ?></td>
			<td><?php echo $program_name; ?></td>
			<td style="white-space:nowrap"><?php echo $intake; ?></td>
			<td style="white-space:nowrap"><?php echo $commenc_date; ?></td>
			<td style="white-space:nowrap"><?php echo $expected_date; ?></td>
			<td><?php echo $week; ?></td>
			<td style="white-space: nowrap;">
			<a href="../courses?idCrs_=<?php echo base64_encode($snoid); ?>&<?php echo base64_encode('1Security5');?>" class="btn btn-success coursre_btn">Edit & View</a>
			<a href="payp_list.php?idCrs_=<?php echo base64_encode($snoid); ?>&<?php echo base64_encode('1Security5');?>" class="btn btn-primary coursre_btn">Payment Plan</a>
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
   </div>
</div>
<style>
.coursre_btn { padding:3px 10px; font-size:13px;color:#fff !important;}
</style>
<script src="js/jquery.dataTables.js"></script>
<script>	
$('.appointment_data').dataTable({
  "ordering": false
});
</script>  