<?php
ob_start();
include("../../db.php");
date_default_timezone_set("Asia/Kolkata");
include("../../header_navbar.php");

if(!isset($_SESSION['sno'])){
    header("Location: ../../login");
    exit(); 
}

if(isset($_SESSION['sno']) && !empty($_SESSION['sno'])){
$sessionSno = $_SESSION['sno'];
$result1 = mysqli_query($con,"SELECT sno,role,username,email FROM allusers WHERE sno = '$sessionSno'");
 while ($row1 = mysqli_fetch_assoc($result1)) {
   $adminrole = mysqli_real_escape_string($con, $row1['role']);
   $counselor_email = mysqli_real_escape_string($con, $row1['email']);
   $counselor_uname = mysqli_real_escape_string($con, $row1['username']);   
 }
}else{
   $adminrole = '';
   $counselor_email = '';
   $counselor_uname = ''; 
}

	$stu_sno = $_GET['stusno'];
	
	$matchFllw = "SELECT * FROM followup WHERE st_app_id = '$stu_sno' order by sno desc limit 1";
	$resultFollow = mysqli_query($con, $matchFllw);
	if(mysqli_num_rows($resultFollow)){
		$rowflow = mysqli_fetch_assoc($resultFollow);
		$fdatetime = $rowflow['fdatetime'];
		$fremarks = $rowflow['fremarks'];
		$fstage = $rowflow['fstage'];
		$fstatus1 = $rowflow['fstatus'];
		if($fstatus1 == '1'){
			// $fstatus = '<p>Your last task is <span style="color:red;">Not Done</span></p>';
		}
		if($fstatus1 == '0'){
			// $fstatus = '<p>Your last task is <span style="color:green;">Done</span></p>';
		}
	}else{
		$fdatetime = '';
		$fremarks = '';
		$fstage = '';		
		// $fstatus = '<p>Your last task is <span style="color:red;">Pending</span></p>';		
	}
?>
<link rel="stylesheet" href="../../css/sweetalert.min.css">
<script src="../../js/sweetalert.min.js"></script>

<section>
<div class="main-div"><div class="col-lg-12"><div class=" admin-dashboard">
<div class="col-sm-12 application-tabs">
	<div class="col-lg-12 content-wrap">
	<center>
	<h3>Follow Up/Drop: </h3>
	<a href='javascript:void(0)' class='btn btn-warning logFollow' data-target='#logFollowModel' data-toggle='modal' data-id='<?php echo $stu_sno;?>' style="float: right;margin-top: -4%;">Logs</a>
	</center>
	<center><div id="totalVal" style="display:none;"><b>Number of Notifications: </b><span id="countVal"></span></div></center>
		<strong>Choose Option:</strong>
		<select class="form-control flowdrp mb-4">
			<option value="">Select Option</option>
			<option value="Follow Up">Follow Up</option>
			<option value="Drop">Drop</option>
		</select>
		<strong>Next Date:</strong>
		<input type="text" class="form-control fdatetime date_followup1 mb-4" placeholder="Next Date">
		<strong>Remarks:</strong>
		<input type="text" class="form-control fremarks mb-4" placeholder="Remarks">	
		<strong>Choose Stage:</strong>
		<select class="form-control fstage mb-4">
			<option value="">Select Option</option>
			<option value="Profile_stage">Profile Stage</option>
			<option value="Conditional_Offer_letter">Conditional Offer letter</option>
			<option value="LOA_Request">LOA Request</option>
			<option value="Contract_Stage">Contract Stage</option>
			<option value="FH_Sent">File Lodged</option>
			<option value="File_Not_Lodged">File Not Lodged</option>
			<!--option value="FH_Sent">F@H</option>
			<option value="V-G">V-G</option>
			<option value="V-R">V-R</option-->			
		</select>	
    <p>
	<input type="hidden" class="stu_id" value="<?php echo $stu_sno;?>">
	<input type="submit" class="btn btn-submit followbtn">
	</p>
	
	<?php //echo $fstatus; ?>
	
	</div> 
</div>
</div>
</div>
</div>
</section>

<?php include("../../footer.php"); ?>
<script>
$(function(){
    $(".date_followup1").datepicker({	  
		dateFormat: 'yy-mm-dd', 
		changeMonth: false, 
		changeYear: false,
    });
});
</script>

<script>
$('.followbtn').on('click', function(){
	var status = $('.stu_id').val();
	var fdatetime1 = $('.fdatetime').val();
	var fremarks1 = $('.fremarks').val();
	var fstage1 = $('.fstage').val();
	var flowdrp1 = $('.flowdrp').val();
	
	if(flowdrp1 == 'Follow Up'){
	if(fdatetime1 == ''){
		$('.fdatetime').css("border","1px red solid");
		return false;	
	}
	}	
	if(flowdrp1 == 'Drop'){
		$('.fdatetime').css("border","1px #CED4DA solid");		
	}
	
	if(fremarks1 == ''){
		$('.fremarks').css({"border":"1px solid red"});
		return false;
	}else{
		$('.fremarks').css({"border":"1px solid #CED4DA"});
	}
	if(fstage1 == ''){
		$('.fstage').css({"border":"1px solid red"});
		return false;
	}else{
		$('.fstage').css({"border":"1px solid #CED4DA"});
	}
	if(flowdrp1 == ''){
		$('.flowdrp').css({"border":"1px solid red"});
		return false;
	}else{
		$('.flowdrp').css({"border":"1px solid #CED4DA"});
	}	
	
    var message = "You can change the Status";
        if(status){
            var updateMessage = "Change";
        }else{
            var updateMessage = "Cancel";
        }        
        swal({
            title: "Are you sure?",
            text: message,
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            closeOnConfirm: false
        }, function () {
		var url = '../response.php?tag=followupFun';
		$.ajax({
			type: "POST",
			url: url,
			data:'idno='+status+'&fdatetime='+fdatetime1+'&fremarks='+fremarks1+'&fstage='+fstage1+'&flowdrp='+flowdrp1, 
			success :  function(data){			   
			if(data == 1){
				swal("Updated!", "Status " + updateMessage +" Successfully", "success");   
			}else{
			   swal("Failed", data, "error");				   
			}
			setTimeout(function(){
				location.reload(); 
			}, 2000);  
            }
        })  
    }); 
});
</script>

<div class="modal fade main-modal" id="logFollowModel" role="dialog">
<div class="modal-dialog modal-lg">
<div class="modal-content">
<div class="modal-header">
<h4 class="modal-title">Follow Up Logs</h4>
<button type="button" class="close" data-dismiss="modal">&times;</button>
</div>
<div class="modal-body">
<div class="loading_icon"></div>
<div class="col-sm-12">
<div class="row">
<div class="col-sm-12  mt-3">
<table class="table table-bordered">
    <thead>
      <tr>
        <th>Stage</th>
        <th>Next Date</th>
        <th>Status</th>
        <th>Remarks</th>
        <th>Created</th>
        <th>Updated</th>
      </tr>
    </thead>
    <tbody class="totalFollowup"></tbody>
  </table>
</div>
</div>
</div>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>
</div>
</div>
</div>

<script>
$(document).on('click', '.logFollow', function(){	
	var id = $(this).attr('data-id');
	$('.loading_icon').show();
	$.post("../response.php?tag=followElement",{"idno":id},function(d){
	if(d == ""){	
		alert("Not found");
		$('.totalFollowup').html(" ");
		$('.loading_icon').hide();
	}else{	
		$('.totalFollowup').html(" ");		
		for (i in d) {
			$('<tr>' +	 
			'<td>'+d[i].fstage+'</td>' +		 
			'<td>'+d[i].fdatetime+'</td>' + 
			'<td>'+d[i].fstatus+'</td>' + 
			'<td>'+d[i].fremarks+'</td>' +
			'<td>'+d[i].created+'</td>' +
			'<td>'+d[i].updated+'</td>' +
			'</tr>').appendTo(".totalFollowup");
		}
	}
		$('.loading_icon').hide();
	});	
});
</script>
