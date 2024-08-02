<?php
ob_start();
include("../../db.php");
include("../../header_navbar.php");

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
		
		$agent_id_not_show = "AND (user_id IN ($agent_id_not_show2) OR (app_show='$viewName'))";
		$agent_user_table = "AND sno IN ($agent_id_not_show2)";		
	}else{
		$agent_id_not_show = "AND (user_id IN (NULL) OR (app_show='$viewName'))";
		$agent_user_table = "AND sno IN (NULL)";
	}
}else{
	$agent_id_not_show = '';
	$agent_user_table = '';
}
?> 

<?php 
if(($roles1 == 'Admin') || ($roles1 == 'Excu')){
?> 
<style>
body { background:#eeee;}
</style>

<section>
<div class="main-div container-fluid">

	<div class="col-lg-12 admin-dashboard content-wrap"> 
		
		<form method="POST" name="searchdat" action="" id="sewarchdata" class="col-sm-12" autocomplete="off">
		<div class="row"> 
		<div class="col-xl-1"></div>
			<div class="dropagent col-sm-6 col-md-3 col-xl-2 mb-2">
			<label class="label-c">Filter By Status</label>
			  <select class="agentuname form-control" name="status_wise" id="status_wise">
				<option value="" >Application Status</option>
				<option value="Yes_as">Approved</option>
				<option value="No_as">Not-Approved</option>
				<option value="blank_as">Pending</option>
				<option class="selct-opt" value="" disabled >Conditional Offer Status</option>
				<option value="Pending_cos">Pending</option>
				<option value="Generated_cos">Generated</option>
				<option value="Sent_cos">Sent</option>
				<option value="Recieved_cos">Recieved</option>
				<option value="Confirmed_cos" >Confirmed</option>
				<option class="selct-opt" value="" disabled>LOA Request Status</option>
				<option value="Pending_lrs">Pending</option>
				<option value="Sent_lrs">Sent</option>
				<option class="selct-opt" value="" disabled>AOL Contract</option>
				<option value="Pending_aolc">Pending</option>
				<option value="Generated_aolc" >Generated</option>
				<option value="Sent_aolc">Sent</option>
				<option value="Recieved_aolc">Recieved</option>
				<option value="Confirmed_aolc">Confirmed</option>
				<option class="selct-opt" value="" disabled>LOA Status</option>
				<option value="Pending_uloas">Pending</option>
				<option value="Generated_uloas" >Generated</option>
				<option value="Sent_uloas" >Sent</option>
				<option class="selct-opt" value="" disabled>File Status</option>
				<option value="File_Lodged">File Lodged</option>
				<option value="File_Not_Lodged">File Not Lodged</option>
				<option value="File_Re_Lodged">File Re-Lodged</option>
				<option value="V_G">V-G</option>
				<option value="V_R">V-R</option>
				</select>
			
		
		 </div>
		
		<div class="dropagent  col-sm-6 col-md-3 col-xl-2 mb-2">
			<label class="label-c">Filter By Intake</label>
			  <?php 
			  if(!empty($_GET['did'])){ $guid = $_GET['did']; }else{ $guid = '';}
			  $intake_quesry = mysqli_query($con,"SELECT intake FROM contract_courses GROUP BY intake"); ?>
				<select class="agentuname form-control"  name="intake_wise[]" id="intake_wise" multiple>
				
				<?php while($rowIntak= mysqli_fetch_assoc($intake_quesry)){
				$intakdata = $rowIntak['intake'];	
				?>
				<option value="<?php echo $intakdata; ?>" ><?php echo $intakdata; ?></option>
				<?php } ?>
				<option value="SEP-2019" >SEP-2019</option>
				</select>			
		 </div>
		 
		 <div class="dropagent  col-sm-6 col-md-3 col-xl-2 mb-2">
			<label class="label-c">Filter By Courses</label>
			  <?php 
			  if(!empty($_GET['did'])){ $guid = $_GET['did']; }else{ $guid = '';}
			  $crs_quesry = mysqli_query($con,"SELECT program_name FROM contract_courses GROUP BY program_name"); ?>
				<select class="agentuname form-control"  name="course_wise[]" id="course_wise" multiple>
				
				<?php while($rowCrs = mysqli_fetch_assoc($crs_quesry)){
				$crsdata = $rowCrs['program_name'];	
				?>
				<option value="<?php echo $crsdata; ?>" ><?php echo $crsdata; ?></option>
				<?php 
				}?>				
				</select>			
		 </div>
		
		
		 <div class="dropagent col-sm-6 col-md-3 col-xl-2  mb-2">
			<input type="button" name="go"  class="search-button float-right mt-0 mt-sm-5 float-sm-left read-more" value="Search" id="search">
		 </div>
		 </div>
		 </form>
		 <div class="loading_icon"></div>
		 <div id="filter_course">
	
			

		<br /><div class="row">
		<div class="col-lg-12">
		<h4 class="filter-title text-center"> Report Summary</h4>	
			<div class="table-responsive">
				<table class="table table-striped table-bordered table-sm table-scroll">
			 <thead>
				<tr>
					<th width="50%">Agent </th>
					<th>Total </th>
				</tr> 
			 </thead> 
		<?php
		$agnt_qry = "SELECT username, sno FROM allusers where role='Agent' $agent_user_table GROUP BY username";
		  $queryasd = mysqli_query($con, $agnt_qry);
		  $application_num = mysqli_num_rows($queryasd);
		  if($application_num > 0){			
			$all_total_course = 0;
			while($datarow = mysqli_fetch_array($queryasd)){
				$user_id=mysqli_real_escape_string($con, $datarow['sno']);
				$user_nam=mysqli_real_escape_string($con, $datarow['username']);				
				
				$total_course = "SELECT sno FROM st_application  where user_id='$user_id'  AND prg_name1 !='' $agent_id_not_show";
				$total_res = mysqli_query($con, $total_course);
				$total_caoyurse = mysqli_num_rows($total_res);
				$all_total_course += $total_caoyurse;
				$all_totle_by_agent =" where user_id='$user_id'  AND prg_name1 !=''";
				$all_totlecors =" where prg_name1 !=''";				
				
				echo '  
					<tbody class="searchall">
					  <tr>  
						<td>'.$user_nam.'</td>'; 
						if($total_caoyurse > 0){
							if($report_allow == '1'){
								echo '<td><a href="../application/apps_details_course.php?getcondion = '.base64_encode($all_totle_by_agent).'" target="_blank">'.$total_caoyurse.'</a></td>';	
							}else{
								echo '<td>'.$total_caoyurse.'</td>';
							}
						} else {
							echo '<td>'.$total_caoyurse.'</td>';
						}
				
					echo '</tr>
					<tbody>';				
			}		
			
			echo'  
			<tr>
				<td>Total</td>';				
				if($all_total_course > 0) {
					if($report_allow == '1'){
						echo '<td><a href="../application/apps_details_course.php?getcondion = '.base64_encode($all_totlecors).'" target="_blank">'.$all_total_course.'</a></td>';	
					}else{
						echo '<td>'.$all_total_course.'</td>';
					}
				} else {
					echo '<td>'.$all_total_course.'</td>';
				}				
			echo '</tr> ';		
	} else {
			echo '<td colspan="2">No Result Found</td>';
	}
	
		echo '</table>'; 	 ?>							 
	</div></div>	</div>
		
	</div>
	</div>
  </div>	
					
	
</section>
<style>
.table { border:1px solid #ccc; font-size:14px;}
.table.table-scroll { height:100px; overflow-y:scroll;}
.table.table-striped.table-scroll td, .table.table-striped.table-scroll th  { text-align:left; padding-left:10%;}
.table.table-striped.table-scroll td:first-child, .table.table-striped.table-scroll th:first-child  { text-align:left; font-weight:700;  padding-left:10%;}
.table.table-striped.table-scroll td a { font-size:16px; font-weight:bold;}

</style>


<?php 
include("../../footer.php");

}else{
	header("Location: ../../application");
}
?>
<script>
$(document).ready(function(){  
	$('#search').click(function(){
		var status_wise = $('#status_wise').val();  
		var intake_wise = $('#intake_wise').val(); 
		var course_wise = $('#course_wise').val(); 
		$('.loading_icon').show();
		if((status_wise != ''  || intake_wise != '' || course_wise != ''))  
			{  
			 $.ajax({  
						  url:"../searchapplication.php?coursedata=coursefilter",  
						  method:"POST",  
						  data:{status_wise:status_wise,intake_wise:intake_wise,course_wise:course_wise},  
						  success:function(data)  
						  {  
							   // console.log(data);
							   $('#filter_course').html(data);
								$('.loading_icon').hide();
						  }  
					 });   
		
			}
			else  
			{  
			$('.loading_icon').hide();
				 alert("Please Select atleast one Fields");
				return false;					 
			}
		});	
	
		$('#all_intake').click(function() {
			$('#intake_wise option').prop('selected', true);
			$('#intake_wise option:first').prop('selected', false);
		});
});  

</script> 

<script type="text/javascript">
$(function (){           
	 $('#intake_wise').multiselect({
		  columns: 1,
		  placeholder: 'Select Courses',
		  includeSelectAllOption: true				
	});   
});
$(function (){           
	 $('#course_wise').multiselect({
		  columns: 1,
		  placeholder: 'Select Courses',
		  includeSelectAllOption: true				
	});   
});
</script>



