<?php
ob_start();
include("../../db.php");
include("../../header_navbar.php");
date_default_timezone_set("America/Toronto");

// if($roles1 == 'ClgCM' || $roles1 == 'APRStep'){
// 	if($roles1 == 'APRStep'){
// 		$InstructorLists = 'Employee Lists';
// 		$InstructorLists3 = 'Employee';
// 		$getValLists = "AND role!=''";
// 	}else{
// 		$InstructorLists = 'Instructor Lists';	
// 		$InstructorLists3 = 'Instructor';	
// 		$getValLists = "AND role='Teacher'";	
// 	}	
// } else {
// 	header("Location: ../../login");
//     exit();
// }

if(isset($_POST['srchClickbtn'])){
	$search = $_POST['inputval'];
	header("Location: ../campus/teacherLists.php?getsearch=$search&page_no=1");
}

if (isset($_GET['getsearch']) && $_GET['getsearch']!="") {
	$searchTerm = $_GET['getsearch'];
	$searchInput = "AND (name LIKE '%".$searchTerm."%' OR username LIKE '%".$searchTerm."%')";
	$search_url = "&getsearch=".$searchTerm."";
} else {
	$searchInput = '';
	$search_url = '';
	$searchTerm = '';
}
?>

<style>
.error_color{border:2px solid #de0e0e;}
.validError{border:2px solid #ccc;}
</style>
<link rel="stylesheet" type="text/css" href="localhost/accagents/agents/css/fixed-table.css">
<script src="localhost/accagents/agents/js/fixed-table.js"></script>
<section class="container-fluid">
<div class="main-div card">
	<div class="card-header">
		<h3 class="my-0 py-0" style="font-size: 22px; "><?php echo $InstructorLists; ?>
</h3></div>
<div class="card-body">
<div class="row justify-content-between">	



<!--div class="col-sm-1 col-lg-1 mt-4 pt-2">
<form method="POST" action="excelSheet.php" autocomplete="off">
	<input type="hidden" name="role" value="<?php //echo 'Student_Status'; ?>">
	<input type="hidden" name="keywordLists" value="<?php //echo $searchTerm; ?>">
	<button type="submit" name="studentlist" class="btn btn-sm btn-success float-right" >Download Excel</button>
</form>
</div-->

<form action="" method="post" autocomplete="off" class="col-sm-6 col-lg-4 mb-3">
	<div class="input-group m-auto">
		<input type="text" name="inputval" placeholder="Search By Name & Username" class="form-control form-control-sm" value="<?php echo $searchTerm; ?>">
		<div class="input-group-append">
			<input type="submit" name="srchClickbtn" class="btn btn-sm btn-success" value="Search">		
		</div>
	</div>
</form>
<div class="col-sm-3 col-lg-3 mb-3 text-right">
<a href="teacherAdd.php" class="btn btn-sm btn-success float-end">Add New <?php echo $InstructorLists3; ?></a>
</div>
		
<div class="col-12">
    <div id="fixed-table-container-1" class="fixed-table-container">
<table class="table table-striped table-bordered text-center table-sm table-hover">
  <thead><tr class="bg-success">
    <!--th>Role</th-->
    <th align="left">Name</th>
    <th>Username</th>
    <th>Password</th>
    <th>Emp ID</th>
    <th>Status</th>
    <th>Payroll Type</th>
    <th>Updated On</th>
    <th>Action</th>
</tr>
  </thead>
  <tbody>
<?php
$qryModule = "SELECT * FROM m_teacher WHERE role!='' $getValLists $searchInput order by sno desc";
$rsltModule = mysqli_query($con, $qryModule);
$srnoCnt=1;
while($rowModule = mysqli_fetch_assoc($rsltModule)){
	$sno = $rowModule['sno'];
	$role = $rowModule['role'];
	$name = $rowModule['name'];
	$username2 = $rowModule['username'];
	$org_pass3 = $rowModule['org_pass'];
	$status2 = $rowModule['status'];
	if($status2 == '1'){
		$status = 'Active';
	}else{
		$status = 'De-Active';
	}
	$emp_code = $rowModule['emp_code'];
	$added_on = $rowModule['added_on'];
	$payroll_type = $rowModule['payroll_type'];
?>  
    <tr>
      <!--td><?php //echo $role; ?></td-->
      <td align="left" class="text-left text-nowrap"><?php echo $name; ?></td>
      <td><?php echo $username2; ?></td>
      <td><?php echo $org_pass3; ?></td>
      <td><?php echo $emp_code; ?></td>
      <td>
		<select class="adStatus form-control form-control-sm" style="width:100px" data-id="<?php echo $sno; ?>">
			<option value="">Select Option</option>
			<option value="1" <?php if($status2 == '1') { echo 'selected="selected"'; } ?>>Active</option>
			<option value="2" <?php if($status2 == '2') { echo 'selected="selected"'; } ?>>DeActive</option>
		</select>	 
	  </td>
      <td><?php echo $payroll_type; ?></td>
      <td><?php echo $added_on; ?></td>
      <td class="text-nowrap">
	  <a href="teacherAdd.php?sno=<?php echo $sno; ?>&Teacher" class="btn btn-sm btn-success text-white">View/Edit</a>	  
	  <a href="JavaScript:void(0);" title="Change Password" data-eid="<?php echo $sno; ?>" id="stbtnd<?php echo $sno; ?>" id-contact_person="<?php echo $name; ?>" class="btn btn-sm btn-danger stbtnd" data-toggle="modal" data-target="#actchangePass"><i class="fas text-white fa-unlock-alt"></i></a>
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
</section>

<div class="modal" id="actchangePass">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Change Password - <span class="cnpName"></span></h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

    <div class="modal-body">
		<form name="actchngpwd" class="actchngpwd" id="actchngpwd">

		  <div class="form-group">
			<label for="pwd"><b>New Password:</b></label>
			<input type="password" class="form-control mb-2" id="newpwd1" name="newpwd">
			<span class="new-pwd-error"></span>
		  </div>
		  <div class="form-group">
			<label for="pwd"><b>Confirm Password:</b></label>
			<input type="password" class="form-control mb-2" id="cnfmpwd1" name="cnfmpwd">
			<span class="confrm-pwd-error"></span>
		  </div>
		  <input type="hidden" name="sno" value="" id="user_ids">
		  <button type="submit" class="btn btn-success actdatasubmit" id="actdatasubmit">Submit</button>
		</form>
    </div>

    </div>
  </div>
</div>

<script>
$(document).on('click', '.stbtnd', function(){
	var callerno = $(this).attr('data-eid');
	$('#user_ids').attr('value', callerno);
	
	var contact_person = $(this).attr('id-contact_person');
	$('.cnpName').html(contact_person);
});
$(document).ready(function () {
	$('#newpwd1').keyup(function () {
		var newpwd1 = this.value;
		var newpwd2 = newpwd1.length;
		if(newpwd2 < 8){
		   $(".new-pwd-error").text("New Password should be Minimum 8 character").fadeIn();
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
			if(new_passord1 < 8){
				$('.new-pwd-error').html("New Password should be Minimum 8 character.").fadeIn();
				 return false;
			}
			if(new_passord !== confrim_passord){
				$('.confrm-pwd-error').html("Confirm Password is not match with new password").fadeIn();
				 return false;
			}
			$.post(URL, formData).done(function(data) {
				if(data == 1){
					alert("Change Password has been updated!!!");
					$("#actchngpwd")[0].reset();
					$('#actchangePass').modal('toggle');
						setTimeout(function(){
						   window.location.reload(1);
						}, 1000);
				} else if(data == 2){
					alert("Confirm Password is not match with new password");
				} else if(data == 3){
					alert("New Password should be Minimum 8 character");
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
$(document).on('change', '.adStatus', function(){
	var stusno = $(this).attr('data-id');
	var getVal = $(this).val();
	var loggedName = '<?php echo $contact_person; ?>';
	$.post("response.php?tag=stActiveDe",{"stusno":stusno, "getval":getVal, "loggedName":loggedName},function(d){
		if(d=='1'){
			alert('Status Updated!!!');
			return false;
		}else{
			alert('Something went wrong. Please try again!!!');
			return false;
		}
	});
});
</script>

<style type="text/css">
	.table.table-striped.table-bordered td { vertical-align:middle; }
	.table.table-striped.table-bordered {
  border-collapse: separate;
  border-spacing: 0.1em 0.1em;
}
	.fixed-table-container { overflow: scroll; }
	.fixed-table-container tr:first-child th {
    background: #3a7f3e;
}
</style>	
<script>
  var fixedTable1 = fixTable(document.getElementById('fixed-table-container-1'));
</script>  
