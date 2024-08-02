<?php
ob_start();
include("../../db.php");
date_default_timezone_set("Asia/Kolkata");
include("../../header_navbar.php");

if($loa_allow == '1'){

if (isset($_GET['agid']) && $_GET['agid']!="") {
	$agid = $_GET['agid'];
} else {
	header("Location: ../../logout.php");
    exit();
}

$quryAll = "select sno, username from allusers where sno='$agid'";
$rsltbrnch = mysqli_query($con, $quryAll);
$rowBranch = mysqli_fetch_assoc($rsltbrnch);
$username = $rowBranch['username'];
?>

<section class="container-fluid">
<div class="main-div">
<div class="col-lg-12">
<div class=" admin-dashboard">

<div class=" form-horizontal">
	<div class="form-content pt-2 pb-5">
	<h4><?php echo $username; ?> Login Logs</h4>

<div class="resultClass">
	<?php
	$qryStr = "SELECT * FROM allusers_logs where uid='$agid' ORDER by id DESC";
	$resultcnt = mysqli_query($con, $qryStr);
	?>
	<p><center><b>No. Of Times Login - </b><?php echo mysqli_num_rows($resultcnt); ?></center></p>
	<div class="table-responsive">
	<table  id="appointment_data" class="table table-bordered" width="100%">
	<thead>
      <tr>
        <th>Sr. No.</th>
        <th>IP Address</th>
        <th>Login Date Time</th>
        <th>Normal Datetime</th>
      </tr>
    </thead>
    <tbody>
	<?php
	$counter=1;
	while($rowLog = mysqli_fetch_assoc($resultcnt)) {
		$ip_address = mysqli_real_escape_string($con, $rowLog['ip_address']);
		$created_date = mysqli_real_escape_string($con, $rowLog['created_date']);
		$created_time = mysqli_real_escape_string($con, $rowLog['created_time']);
		$datetime_at = $created_date.' '.$created_time;
		$datetime_formate = date("l jS \of F Y h:i:s", strtotime($datetime_at));		
	?>
    <tr>
		<td><?php echo $counter++; ?></td>
		<td><?php echo $ip_address; ?></td>		
		<td><?php echo $datetime_formate; ?></td>		
		<td><?php echo $datetime_at; ?></td>		
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
</section>
<?php 
include("../../footer.php");

}else{
	header("Location: ../../logout.php");
}
?>