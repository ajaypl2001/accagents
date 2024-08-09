<?php
ob_start();
include("../../db.php");
include("../../header_navbar.php");
date_default_timezone_set("America/Toronto");
$getCD = date('Y-m-d');

$date_at22_hdr = strtotime($getCD);
$getMonthYear_hdr = date('Y-m');

// if($roles1 == 'ClgCM' || $roles1 == 'APRStep'){
	
// } else {
// 	header("Location: ../../login");
//     exit();
// }

$showMonthStart_HDR = '';
$dssad_hdr = "SELECT start_date FROM `m_bi_weekly_start_date` where (start_date LIKE '%$getMonthYear_hdr%')";
$login_hdr = mysqli_query($con, $dssad_hdr);
while($row_hdr = mysqli_fetch_array($login_hdr)){
	$row2_hdr[] = $row_hdr['start_date'];
}
$getStartDate1_HDR = strtotime($row2_hdr[0]);
$endDate_HDR = strtotime($row2_hdr[0].'+13 days');

$getStartDate2_HDR = strtotime($row2_hdr[1]);
$endDate2_HDR = strtotime($row2_hdr[1].'+13 days');

if(!empty($row2_hdr[2])){
	$getStartDate3_HDR = strtotime($row2_hdr[2]);
	$endDate3_HDR = strtotime($row2_hdr[2].'+13 days');
}else{	
	$getStartDate3_HDR = 'h';
	$endDate3_HDR ='';
}

if($getStartDate1_HDR >= $date_at22_hdr || $date_at22_hdr <= $endDate_HDR){
	$showMonthStart_HDR = $row2_hdr[0];
}elseif($getStartDate2_HDR >= $date_at22_hdr || $date_at22_hdr <= $endDate2_HDR){
	$showMonthStart_HDR = $row2_hdr[1];
}elseif($getStartDate3 >= $date_at22_hdr || $date_at22_hdr <= $endDate3_HDR){
	$showMonthStart_HDR = $row2_hdr[2];
}



if(!empty($_GET['getDateSlot'])){
	$getDateSlot = $_GET['getDateSlot'];
	$getDateSlot3 = '2024-05-06';
	$endDateSlot_Search = date("Y-m-d", strtotime( $getDateSlot . "+13 day"));
}else{
	$getDateSlot = "$showMonthStart_HDR";
	$getDateSlot3 = '2024-05-06';
	$endDateSlot_Search = date("Y-m-d", strtotime( $getDateSlot . "+13 day"));
}
?>

<style>
.error_color{border:2px solid #de0e0e;}
.validError{border:2px solid #ccc;}
</style>
<section class="container-fluid">
<div class="main-div card">
	<div class="card-header">	
		<div class="row justify-content-between">
		<div class="col-12 col-sm-8 col-md-7 col-lg-8 col-xl-9">
		<h3 class="mt-0 mb-3 mb-sm-0 py-0">OverTime/Sick Days Approval List</h3></div>
		<div class="col-12 col-sm-4 col-md-5 col-lg-4 col-xl-3">
		<select class="bIWeeklyFilter form-control form-control-sm">
			<option value="">Select Bi Weekly Filter</option>
			<?php
			$begin = new DateTime("$getDateSlot3");
			$end   = new DateTime("$date_at");
			for($m = $begin; $m <= $end; $m->modify('+14 day')){
				$start_date =  $m->format("Y-m-d");
				$end_date =  date( "Y-m-d", strtotime( $start_date . "+13 day"));
				
				$newdate = date("d M Y", strtotime("$start_date"));
				$end_date2 = date("d M Y", strtotime("$end_date"));
				if($start_date == $getDateSlot){
					$selectedVal = 'selected="selected"';
				}else{
					$selectedVal = '';
				}
				echo '<option value="'.$start_date.'" data-id="'.$start_date.'" end-id="'.$end_date.'" '.$selectedVal.'>'.$newdate.' to '.$end_date2.'</option>';
			}
			?>
		</select></div></div>
</div>
<div class="card-body">
<div class="row justify-content-between">
		
<div class="col-12">
<div class="table-responsive">
<table class="table table-striped table-bordered text-center table-sm table-hover">
	<thead>	  
      <tr class="bg-success text-white">
        <th>Emp Name</th>
        <th>Emp Code</th>
        <th>Bi Weekly</th>
        <th>Date</th>
        <th>Day</th>
        <!--th>SignIn</th>
        <th>SignOut</th-->
		<th>Regular Hrs</th>
		<th>OT Hrs</th>
		<th>OT Approval</th>
		<th>Sick Day Hrs</th>
		<th>SD Approval</th>
		<th>Logs</th>
      </tr>
    </thead>
	<tbody>
	<?php
	$rsltQuery = "SELECT * FROM `m_emp_instructor` WHERE bi_weekly!='' AND m_instructor_id!='' AND (ot!='0' AND ot!='' OR sd!='0' AND sd!='') AND (date_at BETWEEN '$getDateSlot' AND '$endDateSlot_Search')";
	$qurySql = mysqli_query($con, $rsltQuery);
	if(mysqli_num_rows($qurySql)){
		while($row_nm = mysqli_fetch_assoc($qurySql)){
		$snoid_4 = $row_nm['sno'];
		$inst_name = $row_nm['inst_name'];
		$inst_code = $row_nm['emp_code'];
		$bi_weekly = $row_nm['bi_weekly'];
		$toSE = explode('to', $bi_weekly);
		$start_date = date("Y-m-d", strtotime("$toSE[0]"));
		$date_at3 = $row_nm['date_at'];
		$getday = date('l', strtotime("$date_at3"));
		$signin = $row_nm['signin'];
		$signout = $row_nm['signout'];		
		$daily_hourly = $row_nm['daily_hourly'];
		$ot = $row_nm['ot'];
		$ot_status = $row_nm['ot_status'];
		if(!empty($ot_status)){
			if($ot_status == 'Approved'){
				$statusName = 'Approved';
				$statusClassName = 'success';
			}elseif($ot_status == 'Reject'){
				$statusName = 'Reject';
				$statusClassName = 'danger';
			}elseif($ot_status == 'Partial-Approved'){
				$statusName = 'Partial-Approved';
				$statusClassName = 'success';
			}else{
				$statusName = 'Pending';
				$statusClassName = 'danger';
			}				
		}else{
			$statusName = 'Pending';
			$statusClassName = 'warning';
		}
		
		
		$sd = $row_nm['sd'];
		$sd_status = $row_nm['sd_status'];
		if(!empty($sd_status)){
			if($sd_status == 'Approved'){
				$statusNameSD = 'Approved';
				$statusClassNameSD = 'success';
			}elseif($sd_status == 'Reject'){
				$statusNameSD = 'Reject';
				$statusClassNameSD = 'danger';
			}elseif($sd_status == 'Partial-Approved'){
				$statusNameSD = 'Partial-Approved';
				$statusClassNameSD = 'success';
			}else{
				$statusNameSD = 'Pending';
				$statusClassNameSD = 'danger';
			}				
		}else{
			$statusNameSD = 'Pending';
			$statusClassNameSD = 'warning';
		}
	?>
	<tr>
		<td style="white-space: nowrap;"><?php echo $inst_name; ?></td>		
		<td style="white-space: nowrap;"><?php echo $inst_code; ?></td>		
		<td style="white-space: nowrap;"><?php echo $bi_weekly; ?></td>
		<td style="white-space: nowrap;"><?php echo $date_at3; ?></td>		
		<td style="white-space: nowrap;"><?php echo $getday; ?></td>		
		<!--td style="white-space: nowrap;"><?php //echo $signin; ?></td>
		<td style="white-space: nowrap;"><?php //echo $signout; ?></td-->
		<td style="white-space: nowrap;"><?php echo $daily_hourly; ?></td>
		<?php
		if($ot == '0' || $ot == ''){
			echo '<td>N/A</td>';
			echo '<td></td>';
		}else{
		?>
		<td style="white-space: nowrap;"><?php echo $ot; ?></td>
		<td align="center">
		<select class="statusOTDiv form-control form-control-sm" data-id="<?php echo $snoid_4; ?>" fullstName="<?php echo $inst_name; ?>" teacher_id="<?php echo $inst_code; ?>" start_date="<?php echo $start_date; ?>" tab_name="OT">
			<option value="Pending" <?php if($ot_status == 'Pending'){ echo 'selected="selected"'; } ?>>Pending</option>
			<option value="Approved" <?php if($ot_status == 'Approved'){ echo 'selected="selected"'; } ?>>Approved</option>
			<option value="Reject" <?php if($ot_status == 'Reject'){ echo 'selected="selected"'; } ?> data-toggle="modal" data-target="#empOTModal">Reject</option>
			<option value="Partial-Approved" <?php if($ot_status == 'Partial-Approved'){ echo 'selected="selected"'; } ?> data-toggle="modal" data-target="#empOTModal">Partial Approved</option>
		</select>
		</td>
		<?php }
		if($sd == '0' || $sd == ''){
			echo '<td>N/A</td>';
			echo '<td></td>';
		}else{
		?>
		<td style="white-space: nowrap;"><?php echo $sd; ?></td>
		<td align="center">
		<select class="statusSDDiv form-control form-control-sm" data-id="<?php echo $snoid_4; ?>" fullstName="<?php echo $inst_name; ?>" teacher_id="<?php echo $inst_code; ?>" start_date="<?php echo $start_date; ?>" tab_name="SickDay">
			<option value="Pending" <?php if($sd_status == 'Pending'){ echo 'selected="selected"'; } ?>>Pending</option>
			<option value="Approved" <?php if($sd_status == 'Approved'){ echo 'selected="selected"'; } ?>>Approved</option>
			<option value="Reject" <?php if($sd_status == 'Reject'){ echo 'selected="selected"'; } ?> data-toggle="modal" data-target="#empSDModal">Reject</option>
			<option value="Partial-Approved" <?php if($sd_status == 'Partial-Approved'){ echo 'selected="selected"'; } ?> data-toggle="modal" data-target="#empSDModal">Partial Approved</option>
		</select>
		</td>
		<?php } ?>
		<td style="white-space: nowrap;">
			<span class="btn btn-outline-info btn-sm empAdminStatus" data-toggle="modal" data-target="#empAdminStatusModal" data-id="<?php echo $snoid_4; ?>" fullstName="<?php echo $inst_name; ?>" panel-div="Emp">Emp.</span>
			
			<span class="btn btn-outline-<?php echo $statusClassName; ?> btn-sm empAdminStatus" data-toggle="modal" data-target="#empAdminStatusModal" data-id="<?php echo $snoid_4; ?>" fullstName="<?php echo $inst_name; ?>" panel-div="Admin">Admin</span>
		</td>		
	</tr>
	<?php }
	}else{
		echo '<tr><td colspan="11"><center>Not Found!!!</center></td></tr>';
	}
	?>
	</tbody>
</table>
</div>

</div>
</div>
</div>
</div>
</section>

<div class="modal" id="empAdminStatusModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><span class="showFullName"></span></h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body getOTLogs"></div>
      <div class="modal-footer"></div>
    </div>
  </div>
</div>

<div class="modal" id="empOTModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><span class="showFullName"></span></h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body OTDiv"></div>
      <div class="modal-footer"></div>
    </div>
  </div>
</div>

<div class="modal" id="empSDModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><span class="showFullName"></span></h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body SDDiv"></div>
      <div class="modal-footer"></div>
    </div>
  </div>
</div>

<script type="text/javascript">
$(document).on('change', '.statusOTDiv', function () {
	var opval = $(this).val();
	var getFullName = $(this).attr('fullstName');
	$('.showFullName').html(getFullName);
	var getVal = $(this).attr('data-id');
	var getRole = 'Admin';
	var getCP = '<?php echo $contact_person; ?>';
	var getTId = $(this).attr('teacher_id');
	var getSD = $(this).attr('start_date');
	var getTabName = $(this).attr('tab_name');
	
	if(opval == "Approved"){				
		$.post("response.php?tag=otStatusApproval",{"ot_status":opval, "snoid":getVal, "role":getRole, "ubn":getCP, "tid":getTId, "tab_name":getTabName},function(obj14){
			if(obj14 == 1){
				window.location.href = '../campus/OTLists.php?T3SZlkFsbE&Success&getDateSlot='+getSD+'';
				return true;	
			}else{
				alert("Something went wrong. Please contact to Administrator!!!");
				return false;
			}
		 });
	}
	
	if(opval == "Reject"){
        $('#empOTModal').modal("show");
		
	$.post("response.php?tag=otRstStatusDiv",{"ot_status":opval, "snoid":getVal, "role":getRole, "ubn":getCP, "tid":getTId, "tab_name":getTabName},function(obj13){
		$('.OTDiv').html("");
		$('' + obj13[0].getOTClass +'').appendTo(".OTDiv");
		
		$(function(){
			$('.otBtnSbmit').click(function(e){ 
				e.preventDefault();
				var remarks = $('.remarks').val();
				
				if(remarks == '') {
					alert("Fields are Mandatory!!!");
					return false;
				}else{
					var $form = $(this).closest("#otStatusForm");
					var formData =  $form.serializeArray();
					var URL = "response.php?tag=otStatusApproval";
					$.post(URL, formData).done(function(data) {
						if(data == 1){
							alert("OT Status Updated!!!");
							window.location.href = '../campus/OTLists.php?T3SD3ZlkFsbE&getDateSlot='+getSD+'';
							return true;	
						}else{
							alert("Something went wrong. Please contact to Administrator!!!");
							return false;
						}
					 });
				}
			});
		});
		
	});
	
	}
	
	if(opval == "Partial-Approved"){
        $('#empOTModal').modal("show");
		
	$.post("response.php?tag=otRstStatusDiv",{"ot_status":opval, "snoid":getVal, "role":getRole, "ubn":getCP, "tid":getTId, "tab_name":getTabName},function(obj13){
		$('.OTDiv').html("");
		$('' + obj13[0].getOTClass +'').appendTo(".OTDiv");
		
		$(function(){
			$('.otBtnSbmit').click(function(e){ 
				e.preventDefault();
				var remarks = $('.remarks').val();
				
				if(remarks == '') {
					alert("Fields are Mandatory!!!");
					return false;
				}else{
					var $form = $(this).closest("#otStatusForm");
					var formData =  $form.serializeArray();
					var URL = "response.php?tag=otStatusApproval";
					$.post(URL, formData).done(function(data) {
						if(data == 1){
							alert("OT Status Updated!!!");
							window.location.href = '../campus/OTLists.php?T3SD3ZlkFsbE&getDateSlot='+getSD+'';
							return true;	
						}else{
							alert("Something went wrong. Please contact to Administrator!!!");
							return false;
						}
					 });
				}
			});
		});
		
	});
	
	}
	
});
</script>


<script type="text/javascript">
$(document).on('change', '.statusSDDiv', function () {
	var opval = $(this).val();
	var getFullName = $(this).attr('fullstName');
	$('.showFullName').html(getFullName);
	var getVal = $(this).attr('data-id');
	var getRole = 'Admin';
	var getCP = '<?php echo $contact_person; ?>';
	var getTId = $(this).attr('teacher_id');
	var getSD = $(this).attr('start_date');
	var getTabName = $(this).attr('tab_name');
	
	if(opval == "Approved"){				
		$.post("response.php?tag=otStatusApproval",{"ot_status":opval, "snoid":getVal, "role":getRole, "ubn":getCP, "tid":getTId, "tab_name":getTabName},function(obj14){
			if(obj14 == 1){
				window.location.href = '../campus/OTLists.php?T3SZlkFsbE&Success&getDateSlot='+getSD+'';
				return true;	
			}else{
				alert("Something went wrong. Please contact to Administrator!!!");
				return false;
			}
		 });
	}
	
	if(opval == "Reject"){
        $('#empSDModal').modal("show");
		
	$.post("response.php?tag=otRstStatusDiv",{"ot_status":opval, "snoid":getVal, "role":getRole, "ubn":getCP, "tid":getTId, "tab_name":getTabName},function(obj13){
		$('.SDDiv').html("");
		$('' + obj13[0].getOTClass +'').appendTo(".SDDiv");
		
		$(function(){
			$('.otBtnSbmit').click(function(e){ 
				e.preventDefault();
				var remarks = $('.remarks').val();
				
				if(remarks == '') {
					alert("Fields are Mandatory!!!");
					return false;
				}else{
					var $form = $(this).closest("#otStatusForm");
					var formData =  $form.serializeArray();
					var URL = "response.php?tag=otStatusApproval";
					$.post(URL, formData).done(function(data) {
						if(data == 1){
							alert("Sick Day Status Updated!!!");
							window.location.href = '../campus/OTLists.php?T3SD3ZlkFsbE&getDateSlot='+getSD+'';
							return true;	
						}else{
							alert("Something went wrong. Please contact to Administrator!!!");
							return false;
						}
					 });
				}
			});
		});
		
	});
	
	}
	
	if(opval == "Partial-Approved"){
        $('#empSDModal').modal("show");
		
	$.post("response.php?tag=otRstStatusDiv",{"ot_status":opval, "snoid":getVal, "role":getRole, "ubn":getCP, "tid":getTId, "tab_name":getTabName},function(obj13){
		$('.SDDiv').html("");
		$('' + obj13[0].getOTClass +'').appendTo(".SDDiv");
		
		$(function(){
			$('.otBtnSbmit').click(function(e){ 
				e.preventDefault();
				var remarks = $('.remarks').val();
				
				if(remarks == '') {
					alert("Fields are Mandatory!!!");
					return false;
				}else{
					var $form = $(this).closest("#otStatusForm");
					var formData =  $form.serializeArray();
					var URL = "response.php?tag=otStatusApproval";
					$.post(URL, formData).done(function(data) {
						if(data == 1){
							alert("Sick Day Status Updated!!!");
							window.location.href = '../campus/OTLists.php?T3SD3ZlkFsbE&getDateSlot='+getSD+'';
							return true;	
						}else{
							alert("Something went wrong. Please contact to Administrator!!!");
							return false;
						}
					 });
				}
			});
		});
		
	});
	
	}
	
});
</script>

<script type="text/javascript">
$(document).on('click', '.empAdminStatus', function () {
	var getFullName = $(this).attr('fullstName');
	$('.showFullName').html(getFullName);
	var getVal = $(this).attr('data-id');
	var getPanel = $(this).attr('panel-div');
	var getRole = 'Admin';
	var getCP = '<?php echo $contact_person; ?>';
	$.post("response.php?tag=getOTRemarks",{"snoid":getVal, "role":getRole, "ubn":getCP, "panel":getPanel},function(obj12){
		$('.getOTLogs').html("");
		$('' + obj12[0].getOTLogs +'').appendTo(".getOTLogs");		
	});
});
</script>

<script>
$(document).on('change', '.bIWeeklyFilter', function(){
	var getVal = $(this).val();
	var statusVal = $('option:selected', this).attr('data-id');
	var statusVal2 = $('option:selected', this).attr('end-id');
	if(getVal == ''){
		alert("Select Date!!!");
		return false;
	}else{		
		location.href="../campus/OTLists.php?getDateSlot="+statusVal+"&endDateSlot="+statusVal2+"";
		return true;
	}
});
</script>