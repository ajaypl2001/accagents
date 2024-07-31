<?php
ob_start();
include("../../db.php");
date_default_timezone_set("Asia/Kolkata");
include("../../header_navbar.php");

if($roles1 !== 'Admin'){
	header("Location: ../../login");
    exit();
}

$viewAdminAccess = "SELECT * FROM `admin_access` where admin_id='$sessionid1'";
$resultViewAdminAccess = mysqli_query($con, $viewAdminAccess);
if(mysqli_num_rows($resultViewAdminAccess)){
	$rowsViewAdminAccess = mysqli_fetch_assoc($resultViewAdminAccess);
	$viewEmailId = $rowsViewAdminAccess['email_id'];
	$viewAdminId = $rowsViewAdminAccess['admin_id'];
}else{
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
		$agent_user_table = "AND sno IN ($agent_id_not_show2)";		
	}else{
		$agent_user_table = "AND sno IN (NULL)";
	}
}else{
	$agent_user_table = '';
}
?> 
<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">	
<script src="js/jquery.dataTables.js"></script>

<link rel="stylesheet" href="../../css/sweetalert.min.css">
<script src="../../js/sweetalert.min.js"></script>

<style>
@media (min-width:1200px){
.container {max-width:1260px; width:100%;}}
.red-bg { background:#d00606; color:#fff;}
.green-bg { background:#28a745;}
.light-blue-bg { background:#3fbee7;}
.yellow-bg { background:#e6b010;}
.pwd-error { color:red; }
.table .form-control::placeholder {color:#999; font-size:13px; font-weight:normal;}
.table .form-control { padding:2px 10px; 
    background: #f9f9f9;border:1px solid #999;
    box-shadow: 0px 0px 2px inset #ccc;
    border-radius: 0px;}
	.dataTables_length {width:100px;}
	.dataTables_filter {width:200px;}
	.dataTables_filter label {text-align:left;}
	.dataTables_length label { float:left;    max-width: 100%;
    margin-bottom: 5px;
    display: inline;
    font-weight: 700;
    font-size: 16px;font-weight: normal;
    text-align: left;
    white-space: nowrap;}
	.dataTables_length select, .dataTables_filter input { float:left;padding: 5px 10px;
    border-radius: 5px;
    margin: 0px 0px;
    font-size: 13px; width: 100%;
    display: inline-block;}
	.btn-success.btn-sm { z-index:9;}
</style>
<section class="container-fluid pt-4 pb-5">
<div class="main-div">
<div class=" admin-dashboard">

<div class=" form-horizontal">
	<div class="form-content pt-2 pb-5">
	<div class="row text-center">
	<div class="col-6">
		<a href="../createlogin/" class="btn btn-success btn-sm float-right" target="_blank">Create Agent Account</a>
		</div>
		<div class="col-6">
	<?php if($email2323 == 'admin@acc.com' || $email2323 == 'demo_acc'){ ?>	
		<form class="" action="agent_export_excel.php" method="post">
			<button type="submit" name="submit" class="btn btn-success btn-sm float-left mr-5">Excel Download</button>
		</form>
	<?php } ?>
    </div>
	</div>
		<div class="resultClass">
		
		<div class="table-responsive">
		<table  id="appointment_data" class="table table-sm table-bordered" width="100%">
		<thead>
			<tr>			
				<th>Agent</th>
				<th>Name</th>
				<th>Username</th>
				<th>Password</th>
				<th>Email</th>
				<th>Mobile No</th>
				<th>Alternate</th>
				<th>Address</th>
				<th>City</th>
				<th>Sales Manager</th>
				<th>Created Date</th>
				<th>Action</th>
				<th>Certificates</th>
			</tr>
		</thead>
		<?php
		$quryAll = "select * from allusers where role='Agent' $agent_user_table";
		$rsltbrnch = mysqli_query($con, $quryAll); 
		while ($rowBranch = mysqli_fetch_assoc($rsltbrnch)){			
			$sno = $rowBranch['sno'];
			$username = $rowBranch['username'];
			$original_pass = $rowBranch['original_pass'];
			$contact_person = $rowBranch['contact_person'];
			$role = $rowBranch['role'];
			$agent_type = $rowBranch['agent_type'];
			$email = $rowBranch['email'];
			$agent_email = $rowBranch['agent_email'];
			$mobile_no = $rowBranch['mobile_no'];
			$alternate_mobile = $rowBranch['alternate_mobile'];
			$address = $rowBranch['address'];
			$city = $rowBranch['city'];
			$original_pass = $rowBranch['original_pass'];
			$verifystatus = $rowBranch['verifystatus'];
			$created_by_id = $rowBranch['created_by_id'];
			$created = $rowBranch['created'];

			$qryModule2 = "SELECT name FROM admin_access WHERE admin_id='$created_by_id'";
			$rsltModule = mysqli_query($con, $qryModule2);
			if(mysqli_num_rows($rsltModule)){
				$rowSM = mysqli_fetch_assoc($rsltModule);
				$sales_manager = $rowSM['name'];
			}else{
				$sales_manager = 'Delta Immigration Admin';
			}
			?>
			<tr>			
				<td>
					<span class="username<?php echo $sno; ?>"><?php echo $username; ?></span>
					<input type="text" name="username" placeholder="Enter Username" class="form-control form-control-sm usernameInput<?php echo $sno; ?>" value="<?php echo $username; ?>" style="display:none;">
				</td>
				
				<td>
					<span class="contact_person<?php echo $sno; ?>"><?php echo $contact_person; ?></span>
					<input type="text" name="contact_person" placeholder="Enter Contact Name" class="form-control form-control-sm contact_personInput<?php echo $sno; ?>" value="<?php echo $contact_person; ?>" style="display:none;">
				</td>
				
				<td><?php echo $email;?></td>
				<td><?php echo $original_pass;?></td>
				
				<td>
					<span class="agent_email<?php echo $sno; ?>"><?php echo $agent_email; ?></span>
					<input type="text" name="agent_email" placeholder="Enter Agent Email Id" class="form-control form-control-sm agent_emailInput<?php echo $sno; ?>" value="<?php echo $agent_email; ?>" style="display:none;">
				</td>
				
				
				<td>
					<span class="mobile_no<?php echo $sno; ?>"><?php echo $mobile_no; ?></span>
					<input type="text" name="mobile_no" placeholder="Enter Mobile No" class="form-control form-control-sm mobile_noInput<?php echo $sno; ?>" value="<?php echo $mobile_no; ?>" style="display:none;">
				</td>
				<td>
					<span class="alternate_mobile<?php echo $sno; ?>"><?php echo $alternate_mobile; ?></span>
					<input type="text" name="alternate_mobile" placeholder="Enter Alternate Mobile No" class="form-control form-control-sm alternate_mobileInput<?php echo $sno; ?>" value="<?php echo $alternate_mobile; ?>" style="display:none;">
				</td>
				<td>
					<span class="address2<?php echo $sno; ?>"><?php echo $address; ?></span>
					<input type="text" name="address" placeholder="Enter Address" class="form-control form-control-sm addressInput<?php echo $sno; ?>" value="<?php echo $address; ?>" style="display:none;">
				</td>
				<td>
				<span class="city<?php echo $sno; ?>"><?php echo $city; ?></span>
					<input type="text" name="city" placeholder="Enter City" class="form-control form-control-sm cityInput<?php echo $sno; ?>" value="<?php echo $city; ?>" style="display:none;">
				</td>
				<td><?php echo $sales_manager; ?></td>
				<td><?php echo $created; ?></td>
				<td style="white-space:nowrap;">
		<?php if($verifystatus == '1'){ ?>
			<a href="JavaScript:void(0);" title="Activated" data-eid="<?php echo $sno; ?>" targetid="1" id="stbtn<?php echo $sno; ?>" class="btn btn-sm green-bg stbtn"><i class="fas text-white fa-check"></i></a>
			
			<a href="JavaScript:void(0);" title="Change Password" data-eid="<?php echo $sno; ?>"  id="chngpass<?php echo $sno; ?>" class="btn btn-sm light-blue-bg changePass"  data-toggle="modal" data-target="#changePass" ><i class="fas text-white fa-unlock-alt"></i></a>
		<?php }  if($verifystatus == '2'){ ?>
			<a href="JavaScript:void(0);" title="Deactivated" data-eid="<?php echo $sno; ?>" id="stbtnd<?php echo $sno; ?>" class="btn btn-sm red-bg stbtnd" data-toggle="modal" data-target="#actchangePass"><i class="fas text-white fa-times"></i></a>
		<?php } ?>


		<a href="javascript:void(0)" title="Update Info" class="btn btn-sm yellow-bg editbtn" id="editbtn<?php echo $sno; ?>" data-id="<?php echo $sno; ?>"><i class="fas text-white fa-user-edit"></i></a>

		<a href="javascript:void(0)" title="Save Info" class="btn btn-sm green-bg savebtn" id="update<?php echo $sno; ?>" data-id="<?php echo $sno; ?>" style="display:none;"><i class="fas text-white fa-save"></i></a>

				
				</td>
				
	<td>
	<?php
	echo '<form method="post" action="certificate_acc.php">
	  <div class="input-group mb-3">
		<input type="hidden" name="snoid" value="'.$sno.'">
		<input type="hidden" name="crted_by" value="'.$sessionid1.'">
		<input type="hidden" name="campus" value="Nanaimo">
		<button class="btn btn-sm btn-warning w-100">Generate</button>
		</div>
	</form>';
		
	$quryCertificate = "select certificate from certificates where agent_id='$sno'";
	$rsltCertificate = mysqli_query($con, $quryCertificate);
	if(mysqli_num_rows($rsltCertificate)){
		while($rowCertificate = mysqli_fetch_assoc($rsltCertificate)){
			$certificate22 = $rowCertificate['certificate'];
			echo '<p class="m-0"><a style="white-space:nowrap; color:#007bff; text-decoration:underline;" href="certificate/'.$certificate22.'" download>Download</a></p>';
		}
	}
	?>
	</td>
				
				
				
			</tr>
		<?php } ?>
		
	</table>
	</div>
    </div>
</div>
</div>
</div>
</div>
</div>
</section>
<!------ here is start modal for change password---->
	<!-- The Modal -->
	<div class="modal main-modal" id="changePass">
	  <div class="modal-dialog">
		<div class="modal-content">

		  <!-- Modal Header -->
		  <div class="modal-header">
			<h4 class="modal-title"><b>Change Password</b></h4>
			<button type="button" class="close" data-dismiss="modal">&times;</button>
		  </div>

		  <!-- Modal body -->
		  <div class="modal-body">
	<form name="chngpwd"  class="chngpwd" id="chngpwd">
	 <div class="form-group">
		<label for="pwd"><b>Current Password:</b></label>
		<input type="password" class="form-control form-control-sm" id="crntpwd" name="crntpwd">
		<span class="curnt-pwd-error"></span>
	  </div>
		<div class="form-group">
		<label for="pwd"><b>New Password:</b></label>
		<input type="password" class="form-control form-control-sm" id="newpwd" name="newpwd">
		<span class="new-pwd-error"></span>
	  </div>
		<div class="form-group">
		<label for="pwd"><b>Confirm Password:</b></label>
		<input type="password" class="form-control form-control-sm" id="cnfmpwd" name="cnfmpwd">
		<span class="confrm-pwd-error"></span>
	  </div>
	  <input type="hidden" name="sno" value="" id="user_id">
	  <button type="submit" class="btn btn-success float-right datasubmit" id="datasubmit">Submit</button>
	</form>
		  </div>

		  <!-- Modal footer -->
		  		</div>
	  </div>
	</div>
	
	
	<!-- The Modal for set password and activate status-->
	<div class="modal main-modal" id="actchangePass">
	  <div class="modal-dialog">
		<div class="modal-content">

		  <!-- Modal Header -->
		  <div class="modal-header">
			<h4 class="modal-title">Activate and Set Password</h4>
			<button type="button" class="close" data-dismiss="modal">&times;</button>
		  </div>

		  <!-- Modal body -->
		  <div class="modal-body">
	<form name="actchngpwd"  class="actchngpwd" id="actchngpwd">
	
		<div class="form-group">
		<label for="pwd"><b>New Password:</b></label>
		<input type="password" class="form-control form-control-sm" id="newpwd1" name="newpwd">
		<span class="new-pwd-error"></span>
	  </div>
		<div class="form-group">
		<label for="pwd"><b>Confirm Password:</b></label>
		<input type="password" class="form-control form-control-sm" id="cnfmpwd1" name="cnfmpwd">
		<span class="confrm-pwd-error"></span>
	  </div>
	  <input type="hidden" name="sno" value="" id="user_ids">
	  <button type="submit" class="btn btn-success actdatasubmit" id="actdatasubmit">Submit</button>
	</form>
		  </div>

		  <!-- Modal footer -->
		  

		</div>
	  </div>
	</div>
	
<!------ here is end of code for change password---->
<style>.btnorange{background:orange;color:#fff;}</style>
<script>
$(document).ready(function () {
		$('#newpwd1').keyup(function () {
			var newpwd1 = this.value;
			var newpwd2 = newpwd1.length;
			if(newpwd2 < 6){
			   $(".new-pwd-error").text("New Password should be Minimum 6 character").fadeIn();
			   return false;
			} else {
				$('.new-pwd-error').html(" ").fadeOut();
			}
		});
		$('#cnfmpwd1').keyup(function () {
			var cnfmpwd1 = this.value;
			var new_passord =  $("#newpwd1").val();
			if(new_passord !== cnfmpwd1){
			  $('.confrm-pwd-error').html("Confirm Password is not match with new password").fadeIn();
			   return false;
			} else {
				$('.confrm-pwd-error').html(" ").fadeOut();
			} 
		});
		$('.actdatasubmit').click(function(e) {
				e.preventDefault();
				var $form = $(this).closest("#actchngpwd");
				var formData =  $form.serializeArray();
				var new_passord =  $form.find("#newpwd1").val();
				var new_passord1 = new_passord.length;
				var confrim_passord =  $form.find("#cnfmpwd1").val();
				var URL = "response.php?tag=actchangepass";
				if(new_passord=='' || confrim_passord==''){
					alert('Please Enter The Details');
					return false;
				}
				if(new_passord1 < 6){
					$('.new-pwd-error').html("New Password should be Minimum 6 character.").fadeIn();
					 return false;
				}
				if(new_passord !== confrim_passord){
					$('.confrm-pwd-error').html("Confirm Password is not match with new password").fadeIn();
					 return false;
				}
				$.post(URL, formData).done(function(data) {
					if(data == 1){
						alert("Your Status is Activated");
						$("#actchngpwd")[0].reset();
						$('#actchangePass').modal('toggle');
							setTimeout(function(){
							   window.location.reload(1);
							}, 1000);
					} else if(data == 2){
						alert("Confirm Password is not match with new password");
					} else if(data == 3){
						alert("New Password should be Minimum 6 character");
					}  else if(data == 5){
						alert("Please fill all the details");
					} else {
						alert("Sonthing went wrong please try again");
					}
				});
				 
		});
		
	}); 
</script>
<script>
$(document).ready(function () {
		var exit_mobile;
		$('#crntpwd').keyup(function () {
			var crntpwd = this.value;
			var user_id = $('#user_id').val();
			if(crntpwd == "") {
			   $(".curnt-pwd-error").text("Please Enter Your Old Password").fadeIn();
			   return false;
			} 
			$.post("response.php?tag=checkpass", {"crntpwd": crntpwd,"user_id": user_id}, function (d) {
			if (d == 1) {
					exit_mobile = 0;
					$('.curnt-pwd-error').html(" ").fadeOut();
				}
				if (d == 0) {
					exit_mobile = 1;
					$('.curnt-pwd-error').html("Your Old Password is Wrong.").fadeIn();
					
				}
			});
		});
		$('#newpwd').keyup(function () {
			var newpwd = this.value;
			var newpwd1 = newpwd.length;
			if(newpwd1 < 6){
			   $(".new-pwd-error").text("New Password is Minimum 6 char").fadeIn();
			   return false;
			} else {
				$('.new-pwd-error').html(" ").fadeOut();
			}
		});
		$('#cnfmpwd').keyup(function () {
			var cnfmpwd = this.value;
			var new_passord =  $("#newpwd").val();
			if(new_passord !== cnfmpwd){
			  $('.confrm-pwd-error').html("Confirm Password is not match with new password").fadeIn();
			   return false;
			} else {
				$('.confrm-pwd-error').html(" ").fadeOut();
			} 
		});
		$('.datasubmit').click(function(e) {
				e.preventDefault();
				var $form = $(this).closest("#chngpwd");
				var formData =  $form.serializeArray();
				var currnt_passord =  $form.find("#crntpwd").val();
				var new_passord =  $form.find("#newpwd").val();
				var new_passord1 = new_passord.length;
				var confrim_passord =  $form.find("#cnfmpwd").val();
				var URL = "response.php?tag=changepass";
				if(currnt_passord=='' || new_passord=='' || confrim_passord==''){
					alert('Please Enter The Details');
					return false;
				}
				if(exit_mobile == 1){
					 $('.curnt-pwd-error').html("Your Old Password is Wrong.").fadeIn();
					 return false;
				}
				if(new_passord1 < 6){
					$('.new-pwd-error').html("New Password is Minimum 6 char.").fadeIn();
					 return false;
				}
				if(new_passord !== confrim_passord){
					$('.confrm-pwd-error').html("Confirm Password is not match with new password").fadeIn();
					 return false;
				}
				$.post(URL, formData).done(function(data) {
					if(data == 1){
						alert("Your Password is successfully changed");
						$("#chngpwd")[0].reset();
						$('#changePass').modal('toggle');
					} else if(data == 2){
						alert("Confirm Password is not match with new password");
					} else if(data == 3){
						alert("New Password should be Minimum 6 char");
					} else if(data == 4){
						alert("Your Old Password is Wrong");
					} else if(data == 5){
						alert("Please fill all the details");
					} else {
						alert("Sonthing went wrong please try again");
					}
				});
				 
		});
		
	}); 
</script>
<script>
$(document).on('click', '.changePass', function(){
	var callerno = $(this).attr('data-eid');
	$('#user_id').attr('value', callerno);
});
</script>
<script>
$(document).on('click', '.stbtnd', function(){
	var callerno = $(this).attr('data-eid');
	$('#user_ids').attr('value', callerno);
});
</script>
<script>
	  //$(document).ready(function(){  
		$('#appointment_data').DataTable();
	 //});  
</script>

<script>
$(document).on('click', '.editbtn', function(){
	var empid = $(this).attr('data-id');
	
	$('#editbtn'+empid).hide();
	$('#chngpass'+empid).hide(); 
	$('#stbtn'+empid).hide();
	$('#stbtnd'+empid).hide();	
	$('#update'+empid).show();
	
	//input	
	$('.username'+empid).hide();
	$('.usernameInput'+empid).show();
	
	$('.contact_person'+empid).hide();
	$('.contact_personInput'+empid).show();
	
	// $('.email'+empid).hide();
	// $('.emailInput'+empid).show();
	
	$('.agent_email'+empid).hide();
	$('.agent_emailInput'+empid).show();
	
	$('.mobile_no'+empid).hide();
	$('.mobile_noInput'+empid).show(); 
	
	$('.alternate_mobile'+empid).hide();
	$('.alternate_mobileInput'+empid).show(); 
	
	$('.address2'+empid).hide();
	$('.addressInput'+empid).show(); 
	
	$('.city'+empid).hide();
	$('.cityInput'+empid).show();
	
});

$(document).on('click', '.savebtn', function(){
	$('.loading_icon').show();
	var empid = $(this).attr('data-id');
	var usernameInput = $('.usernameInput'+empid).val();
	var contact_personInput = $('.contact_personInput'+empid).val();
	// var emailInput = $('.emailInput'+empid).val();
	var agent_emailInput = $('.agent_emailInput'+empid).val();
	var mobile_noInput = $('.mobile_noInput'+empid).val();
	var alternate_mobileInput = $('.alternate_mobileInput'+empid).val();
	var addressInput = $('.addressInput'+empid).val();
	var cityInput = $('.cityInput'+empid).val();
	
	$.post("response.php?tag=EditEmp",{"snoid":empid, "usernameInput":usernameInput, "contact_personInput":contact_personInput, "agent_emailInput":agent_emailInput, "mobile_noInput":mobile_noInput, "alternate_mobileInput":alternate_mobileInput, "addressInput":addressInput, "cityInput":cityInput},function(d){
	if(d == 1){	
		alert('Updated Successfully');
		$('#editbtn'+empid).show();
		$('#chngpass'+empid).show(); 
		$('#stbtn'+empid).show(); 
		$('#stbtnd'+empid).show();
		$('#update'+empid).hide();
		
		$('.usernameInput'+empid).hide();
		$('.contact_personInput'+empid).hide();
		// $('.emailInput'+empid).hide();
		$('.agent_emailInput'+empid).hide();
		$('.mobile_noInput'+empid).hide();
		$('.alternate_mobileInput'+empid).hide();
		$('.addressInput'+empid).hide();
		$('.cityInput'+empid).hide();
				
		$('.username'+empid).show();
		$('.username'+empid).html(usernameInput);
			
		$('.contact_person'+empid).show();
		$('.contact_person'+empid).html(contact_personInput);
				
		// $('.email'+empid).show();
		// $('.email'+empid).html(emailInput);
		
		$('.agent_email'+empid).show();
		$('.agent_email'+empid).html(agent_emailInput);		
		
		$('.mobile_no'+empid).show();
		$('.mobile_no'+empid).html(mobile_noInput);
		
		$('.alternate_mobile'+empid).show();
		$('.alternate_mobile'+empid).html(alternate_mobileInput);
		
		$('.address2'+empid).show();
		$('.address2'+empid).html(addressInput);
		
		$('.city'+empid).show();
		$('.city'+empid).html(cityInput);

		$('.loading_icon').hide();
		
	}
	 });	
});	
</script>
<script>


	$(document).on('click', '.stbtn', function(){
		var empid = $(this).attr('data-eid');
		var getst = $(this).attr('targetid');
			if(getst == '2'){
				var updateMessage = "Activated";
				var message = "You want to Activated status";
			}else{
				var updateMessage = "Deactivated";
				var message = "You want to Deactivated status";
			}
			swal({
				title: "Are you sure?",
				text: message,
				type: "warning",
				showCancelButton: true,
				confirmButtonColor: "#DD6B55",
				closeOnConfirm: true
			}, function () {
			$.post("response.php?tag=empStatus",{"empid":empid, "getst":getst},function(d){
					if(d == '1'){
						if(getst == '1'){
							swal("Updated!", "Status " + updateMessage +" successfully", "success");
							setTimeout(function(){
							   window.location.reload(1);
							}, 1000);
						} else {
							swal("Failed" + updateMessage + "error");
						}
					} else {
						swal("Failed" + updateMessage + "error");
					}
			});
		});
	});

</script>

<?php 
include("../../footer.php");
?>