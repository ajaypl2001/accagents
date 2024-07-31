<?php
ob_start();
include("../../db.php");
include("../../header_navbar.php");

if(!isset($_SESSION['sno'])){
    header("Location: ../../login");
    exit(); 
}
?> 
<?php
$sessionSno = $_SESSION['sno'];

if($roles1 == 'Admin'){
?> 

<link rel="stylesheet" href="../../css/sweetalert.min.css">
<script src="../../js/sweetalert.min.js"></script>

<section class="container-fluid">
<div class="main-div">
<div class=" admin-dashboard content-wrap">	
<h3 class="mt-0"><center>Critical Reminders</center></h3>
<div class="col-sm-12 application-tabs">
	<div class=" row mb-4">		
		<div class="col-sm-4 col-md-3 col-padding">
			<label>Select Stage</label>
			<select name="followst" class="form-control followst1" id="followst">
				<option value="">Select Option</option>
				<option value="Profile_stage">Profile Stage</option>
				<option value="Conditional_Offer_letter">Conditional Offer letter</option>
				<option value="LOA_Request">LOA Request</option>
				<option value="Contract_Stage">Contract Stage</option>
				<!--option value="FH_Sent">F@H</option>
				<option value="VG_VR">VG/VR</option-->
				<option value="FH_Sent">LOA Generated</option>
				<option value="VG_VR">F@H</option>
			</select>
		</div>				
		<div class="col-sm-3 col-md-3 mt-sm-4 pt-sm-2 col-padding">
			<input type="button" name="submit" class="btn btn-success followrbtn" value="Search">
		</div>		
		<div class="col-12 mt-4 text-center totalcnt" style="display:none;"><b>Total: </b> <span class="totalcnt11"></span></div>		
	</div>	

	
    <div class="table-responsive">
	<table class="table table-bordered" width="100%">
    <thead>	  
      <tr>	  
        <th>Agent Name</th>
        <th>Student  Name</th>
        <th>Student  Reference Id</th>         		
        <th>No of Days</th>         		
        <th>Action</th>		
      </tr>
    </thead>
    <tbody class="reminder">
		
    </tbody>	
	</table>  
	</div>
	</div>
  </div>
</div>
</div>
</div>
</section>

<script>
$(document).on('click', '.followrbtn', function(){	
	var followstage = $('.followst1').val();	
	$('.loading_icon').show();
	$.post("../response.php?tag=followriminder",{"followstage":followstage},function(d){
	var multiple = d.length;
	$('.totalcnt11').html(multiple);
	$('.totalcnt').show();
	if(d == ""){	
		alert("Not found");
		$('.reminder').html(" ");
		$('.loading_icon').hide();
	}else{	
		$('.reminder').html(" ");		
		for (i in d) {
			$('<tr>' +	 
			'<td>'+d[i].agntname+'</td>' +		 
			'<td>'+d[i].student_name+'</td>' + 
			'<td>'+d[i].refid+'</td>' + 
			'<td>'+d[i].agent_col_datetime12+'</td>' + 
			'<td>'+d[i].action+'</td>' + 
			'</tr>').appendTo(".reminder");
		}
	}
		$('.loading_icon').hide();
	});	
});

$(function () {
	$('.followst').multiselect({
		  columns: 1,
		  placeholder: 'Select Month',
		  includeSelectAllOption: true		
	});           
});
</script>


<?php 
include("../../footer.php");

}else{
	header("Location: ../../application");
}
?>  
