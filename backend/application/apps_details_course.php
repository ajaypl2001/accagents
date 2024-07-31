<?php
ob_start();
include("../../db.php");
include("../../header_navbar.php");

if(($roles1 == 'Admin') || ($roles1 == 'Excu')){
	
if(isset($_GET['getcondion_'])){
	$queryConditiondata = base64_decode($_GET['getcondion_']);
}

$viewAdminAccess = "SELECT * FROM `admin_access` where admin_id='$sessionid1'";
$resultViewAdminAccess = mysqli_query($con, $viewAdminAccess);
if(mysqli_num_rows($resultViewAdminAccess)){
	$rowsViewAdminAccess = mysqli_fetch_assoc($resultViewAdminAccess);
	$viewName = $rowsViewAdminAccess['name'];
	$viewEmailId = $rowsViewAdminAccess['email_id'];
	$viewAdminId = $rowsViewAdminAccess['admin_id'];
}else{
	$viewName = '';
	$viewEmailId = '';
	$viewAdminId = '';
}

if(mysqli_num_rows($resultViewAdminAccess) && ($email2323 == $viewEmailId)){
	$getAgentsId = "SELECT sno FROM allusers where role='Agent' AND created_by_id!='' AND created_by_id = '$viewAdminId'";
	$resultAgentsId = mysqli_query($con, $getAgentsId);	
	if(mysqli_num_rows($resultAgentsId)){
		while($resultAgentsRows = mysqli_fetch_assoc($resultAgentsId)){
			$userSno[] = $resultAgentsRows['sno'];
		}
		$getAccessid = implode("','", $userSno);
		$agent_id_not_show2 = "'$getAccessid'";
		
		$agent_id_not_show = "AND (st_application.user_id IN ($agent_id_not_show2) OR (st_application.app_show='$viewName'))";		
	}else{
		$agent_id_not_show = "AND (st_application.user_id IN (NULL) OR (st_application.app_show='$viewName'))";
	}
}else{
	$agent_id_not_show = '';
}
?>
<section>
<div class="main-div">
<div class="col-sm-12 application-tabs">

<div class="tabs tabs-style-tzoid">
<nav>
<ul>
<div class="col-md-9 mb-margin col-sm-12 col-12">
</div>
    <div class="col-md-3 col-sm-12 col-12 search-col"> 
	<form class="form_submit_change_status" method="post"  action="apps_report_course_dwnlod.php?getcondion = <?php echo $_GET['getcondion_']; ?>" autocomplete="off" >
	<center>
		<button type="submit" class="btn crm-login-button1">Download to Excel</button>
	</center>
	</form> 
	</div>	 
 </ul>
</nav>
</div>
<br>

<div class="col-lg-12 admin-dashboard content-wrap">

<div class="col-lg-12"> 
<div class="row"> 	
<div class="table-responsive">
<table class="table table-bordered" width="100%">
<thead>
	  
      <tr style="color:#fff;">
        <th></th>		
        <th>Campus</th>		
        <th>Agent  Name</th>		
        <th>Full  Name</th>
        <th>Ref ID</th>
        <th>Email</th>
        <th>Date Time</th>	
        <th>App. Status</th>
        <th>Action</th>
      </tr>
    </thead>	
	
    <tbody id="totalshow" class="searchall">
	<?php		
		if(isset($_GET['getcondion_'])){
			$queryCondition = base64_decode($_GET['getcondion_']);			
		} else {
			$queryCondition = " st_application.application_form='1'";			
		}
		
		$result2 = "SELECT st_application.sno as sno_app, st_application.app_by, st_application.agent_type, st_application.user_id, st_application.refid, st_application.fname, st_application.lname, st_application.email_address, st_application.datetime, st_application.prg_name1, st_application.prg_intake, st_application.admin_status_crs, st_application.admin_remark_crs, st_application.campus, allusers.username FROM st_application INNER JOIN allusers on st_application.user_id = allusers.sno ".$queryCondition." $agent_id_not_show";
		$get_rslt = mysqli_query($con, $result2);
		if(mysqli_num_rows($get_rslt)){
		while ($row = mysqli_fetch_assoc($get_rslt)) {
			 $snoall = mysqli_real_escape_string($con, $row['sno_app']);
			 $app_by = mysqli_real_escape_string($con, $row['app_by']);
			 $agent_type = mysqli_real_escape_string($con, $row['agent_type']);
			 $user_id = mysqli_real_escape_string($con, $row['user_id']);
			 $refid = mysqli_real_escape_string($con, $row['refid']);
			 $fname = mysqli_real_escape_string($con, $row['fname']);			
			 $lname = mysqli_real_escape_string($con, $row['lname']);			
			 $email_address = mysqli_real_escape_string($con, $row['email_address']);			
			 $datetime = mysqli_real_escape_string($con, $row['datetime']);
			 $prg_name1 = mysqli_real_escape_string($con, $row['prg_name1']);
			 $prg_intake = mysqli_real_escape_string($con, $row['prg_intake']);
			 $admin_status_crs = mysqli_real_escape_string($con, $row['admin_status_crs']);
			 $admin_remark_crs = mysqli_real_escape_string($con, $row['admin_remark_crs']);
			 $campus = mysqli_real_escape_string($con, $row['campus']);
			 
			 $agntname = mysqli_real_escape_string($con, $row['username']);
	?>
      <tr class="error_<?php echo $snoall;?>">
        <td>
		<input type="checkbox" id="error_<?php echo $snoall;?>" />
		</td>
        <td><?php echo $campus; ?></td>
        <td><?php echo $agntname; ?></td>
        <td>
		<a href="../followup/add.php?stusno=<?php echo $snoall; ?>" target="_blank">
		<?php echo $fname.' '.$lname;?>
		</a>
		</td>
        <td><?php echo $refid;?></td>
        <td><?php echo $email_address;?></td>
        <td><?php echo $datetime;?></td>		
		<td>
			<?php if(empty($admin_status_crs)){
				echo '<span style="color:#f3be23;">Pending<span>';
			}else{
				echo $admin_status_crs;
			}
			?>
		</td>
		<td>
		<a href="edit.php?apid=<?php echo base64_encode($snoall); ?>" class="btn edit-aplic btn-sm"><i class="fas fa-edit" data-toggle="tooltip" data-placement="top" title="Edit Application"></i></a>
		<span class="btn btn-sm jmjm" data-toggle="modal" title="View" data-target="#myModaljjjs" data-id="<?php echo $snoall; ?>"><i class="fas fa-eye" data-toggle="tooltip" data-placement="top" title="View Application"></i></span>
		</td>
      </tr>
	<?php } ?>
	<?php }else{ ?>
		<tr><td colspan="9"><center>Not Found</center></td></tr>
	<?php } ?>
    </tbody>	
 </table>  
 </div>

	</div>
  </div>
</div>

<div class="modal fade" id="myModaljjjs" role="dialog">
<div class="modal-dialog modal-lg">
<div class="modal-content">
<div class="modal-header">

<h4 class="modal-title">Student Application</h4>
<button type="button" class="close" data-dismiss="modal">&times;</button>
</div>
<div class="modal-body">
<div class="loading_icon"></div>
<div id="ldld"></div>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div></div>
</div>
</div>

</div></div></div>
</section>

<script>
$(document).on('click', '.jmjm', function(){
	var ssss = $(this).attr('data-id');
	$('.loading_icon').show();
	$.post("../response.php?tag=fetch",{"idno":ssss},function(obj){		
		$('#ldld').html("");
		$('<div class="overclass">' +		
		'<div class="pd-detail">' +
		'<h3><strong>Personal Details</strong></h3>' +
		'<p><b>Role: </b>' + obj[0].app_by + '</p>' +
		'<p><b>Reference Id: </b>' + obj[0].refid + '</p>' +
		'<p><b>Full Name: </b>' + obj[0].fname +' '+ obj[0].lname + '</p>' +
		'<p><b>Email Addesss: </b>' + obj[0].email_address + '</p>' +
		'<p><b>Mobile Number: </b>' + obj[0].mobile + '</p>' +
		'<p><b>Gender: </b>' + obj[0].gender + '</p>' +
		'<p><b>Martial Status: </b>' + obj[0].martial_status + '</p>' +
		'<p><b>Date of Birth: </b>' + obj[0].dob + '</p>' +
		'<p><b>Passport Number: </b>' + obj[0].passport_no + '</p>' +
		'<p><b>Passport Issue Date: </b>' + obj[0].pp_issue_date + '</p>' +
		'<p><b>Passport Expiry Date: </b>' + obj[0].pp_expire_date + '</p>' +
		'<p><b>Address-1: </b>' + obj[0].address1 + '</p>' +
		'<p><b>Address-2: </b>' + obj[0].address2 + '</p>' +
		'<p><b>Country: </b>' + obj[0].country + '</p>' +
		'<p><b>State: </b>' + obj[0].state + '</p>' +
		'<p><b>City: </b>' + obj[0].city + '</p>' +
		'<p><b>PIN Code: </b>' + obj[0].pincode + '</p>' +
		'<p><b>Passport: </b>' + obj[0].idproof + '</p>' +
		'<p><b>Created Date: </b>' + obj[0].datetime + '</p>' +
		'</div>'+
		'<div class="pd-detail">' +
		'<h3><strong>Courses</strong></h3>' +
		'<p><b>Campus Name: </b>' + obj[0].campus + '</p>' +
		'<p><b>Program Name: </b>' + obj[0].prg_name1 + '</p>' +
		'<p><b>Intake: </b>' + obj[0].prg_intake + '</p>' +
		'</div>'+
		'<div class="pd-detail">' +
		'<h3><strong>Test Details</strong></h3>' +
		'<p><b>Test Details: </b>' + obj[0].englishpro + '</p>' +
		'<p>' + obj[0].ielts_pte_over + '</p>' +		
		'<p>' + obj[0].ielts_pte_not + '</p>' +		
		'<p>' + obj[0].ielts_pte_listening + '</p>' +		
		'<p>' + obj[0].ielts_pte_reading + '</p>' +		
		'<p>' + obj[0].ielts_pte_writing + '</p>' +		
		'<p>' + obj[0].ielts_pte_speaking + '</p>' +		
		'<p>' + obj[0].ielts_pte_date + '</p>' +		
		'<p>' + obj[0].ielts_pte_file + '</p>' +		
		'<p>' + obj[0].duolingo_div + '</p>' +		
		'<h3><strong>Academic Details</strong></h3>' +
		'<h5><strong>Education Details<span style="color:red;">*</span></strong></h5>' +
		'<p><b>Qualifications: </b>' + obj[0].qualification1 + '</p>' +
		'<p><b>Education Type: </b>' + obj[0].stream1 + '</p>' +
		'<p><b>Marks(%): </b>' + obj[0].marks1 + '</p>' +
		'<p><b>Passing Year: </b>' + obj[0].passing_year1 + '</p>' +
		'<p><b>University Country: </b>' + obj[0].unicountry1 + '</p>' +
		'<p><b>Upload Certificate: </b>' + obj[0].certificate1 + '</p>' +
		'<p><b>University Name: </b>' + obj[0].uni_name1 + '</p>' +
		'<h5><strong>Education Details</strong></h5>' +
		'<p><b>Qualifications: </b>' + obj[0].qualification2 + '</p>' +
		'<p><b>Education Type: </b>' + obj[0].stream2 + '</p>' +
		'<p><b>Marks(%): </b>' + obj[0].marks2 + '</p>' +
		'<p><b>Passing Year: </b>' + obj[0].passing_year2 + '</p>' +
		'<p><b>University Country: </b>' + obj[0].unicountry2 + '</p>' +
		'<p><b>Upload Certificate: </b>' + obj[0].certificate2 + '</p>' +
		'<p><b>University Name: </b>' + obj[0].uni_name2 + '</p>' +
		'<h5><strong>Education Details</strong></h5>' +
		'<p><b>Qualifications: </b>' + obj[0].qualification3 + '</p>' +
		'<p><b>Education Type: </b>' + obj[0].stream3 + '</p>' +
		'<p><b>Marks(%): </b>' + obj[0].marks3 + '</p>' +
		'<p><b>Passing Year: </b>' + obj[0].passing_year3 + '</p>' +
		'<p><b>University Country: </b>' + obj[0].unicountry3 + '</p>' +
		'<p><b>Upload Certificate: </b>' + obj[0].certificate3 + '</p>' +
		'<p><b>University Name: </b>' + obj[0].uni_name3 + '</p>' +
		'</div>'+
		'</div>').appendTo("#ldld");
		$('.loading_icon').hide();		
	});
});
</script>

<script>
$('input[type="checkbox"]').on('change', function() {
   $('input[type="checkbox"]').not(this).prop('checked', false);
});

</script>
<script>
$(document).ready(function(){
  $('ul li').click(function(){
    $('li').removeClass("active");
    $(this).addClass("active");
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
