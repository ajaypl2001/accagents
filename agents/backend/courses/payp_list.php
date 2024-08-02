<?php
ob_start();
include("../../db.php");
include("../../header_navbar.php");

if(!isset($_SESSION['sno'])){
    header("Location: ../../login");
    exit(); 
}

if(!empty($_GET['idCrs_'])){
	$snoid_6 = base64_decode($_GET['idCrs_']);
	$qryCrs = "select program_name, intake from contract_courses where sno='$snoid_6'";
	$rsltCrs = mysqli_query($con, $qryCrs); 
	$rowCrs = mysqli_fetch_assoc($rsltCrs);
	$program_name = $rowCrs['program_name'];
	$intake = $rowCrs['intake'];

}else{
	$snoid_6 = '';
	$program_name = '';
	$intake = '';
}	
?>
<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">	
	
<div class="main-div">           
<div class="container vertical_tab">  
  <div class="row">  
	<div class="col-md-12 col-lg-12"> 
             
	<div class="tab-content">
	<div id="Personal-Details">

	<div class="col-sm-12">
	<h3><b style="font-size: 16px;"><?php echo $program_name; ?> Payment Plan</b> 
	<a class="btn btn-success coursre_btn float-right mt-1 ml-2" href="payment_plan.php?idpp_=&idCrs_=<?php echo base64_encode($snoid_6); ?>&<?php echo base64_encode('Payment_Plan-Details'); ?>">Add New Payment Plan</a>
	</h3>
	</div>
	
	<div class="col-sm-12">

		<div class="table-responsive">
		<table class="table table-bordered appointment_data" width="100%">
		<thead>
			<tr>
				<th>Intake</th>
				<th>Due date</th>
				<th>Total Fee</th>
				<th>Int Fees</th>
				<th>Created</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
		<?php
		$qryCrs = "select * from cc_date_wise_fee where crs_id='$snoid_6'";
		$rsltCrs = mysqli_query($con, $qryCrs); 
		while($rowCrs = mysqli_fetch_assoc($rsltCrs)){

		$snoid = $rowCrs['sno'];
		$due_date = $rowCrs['due_date'];
		$total_fee = $rowCrs['total_fee'];
		$int_fee = $rowCrs['int_fee'];
		$created_at = $rowCrs['created_at'];
		?>
		<tr>
			<td><?php echo $intake; ?></td>
			<td><?php echo $due_date; ?></td>
			<td><?php echo $total_fee; ?></td>
			<td><?php echo $int_fee; ?></td>
			<td><?php echo $created_at; ?></td>
			<td>
			<a href="payment_plan.php?idpp_=<?php echo base64_encode($snoid); ?>&idCrs_=<?php echo base64_encode($snoid_6); ?>&<?php echo base64_encode('1Security5');?>" class="btn btn-success coursre_btn">Edit & View</a>
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