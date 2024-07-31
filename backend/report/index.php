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
$result1 = mysqli_query($con,"SELECT sno,role,username,email FROM allusers WHERE sno = '$sessionSno'");
 while ($row1 = mysqli_fetch_assoc($result1)) {
   $adminrole = mysqli_real_escape_string($con, $row1['role']);
   $counselor_email = mysqli_real_escape_string($con, $row1['email']);
   $counselor_uname = mysqli_real_escape_string($con, $row1['username']);   
 }
if(($adminrole == 'Admin') || ($adminrole == 'Excu')){
?> 
<?php 
if(isset($_GET['imgMsg'])){
	$mssg =  base64_decode($_GET['imgMsg']);
	if(isset($mssg) == 'ImageUpload'){ 
?>
	<div class='alertdiv'>
		<div class='alert alert-danger' style="text-align:center;">
			<?php echo 'You can upload only jpg and pdf file.'; ?>
		</div>
    </div>     
<?php } } 
if(isset($_GET['ploaMsg'])){
	$mssg =  base64_decode($_GET['ploaMsg']);
	if(isset($mssg) == 'LOAPayStatus'){ 
?>
	<div class='alertdiv'>
		<div class='alert alert-success' style="text-align:center;">
			<?php echo 'Your Status successfully Updated'; ?>
		</div>
    </div>     
<?php } } 
if(isset($_GET['msgalt'])){
	$mssg =  base64_decode($_GET['msgalt']);
	if(isset($mssg) == 'Donotpdf1'){ 
?>
<script>
$(document).ready(function(){    
    $("#yes_application_alert").modal('show');    
});
</script>	    
<?php } } ?>
<style>
input#searchbtn {
    float: right;
   left:100px; margin-left:40px;
    right: 0px; padding:5px 10px; margin-bottom:8px; margin-right:0px;

}
.alertdiv {
    margin-top: 126px;
    width: 100%;
    margin-bottom: -6%;
}
body { background:#eeee;}
</style>



<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.min.css">

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.min.js"></script>

<section><div class="main-div container-fluid"><div class="col-sm-12 application-tabs">

	<div class="col-lg-12 admin-dashboard content-wrap"> 
		
		<form method="POST" name="searchdat" action="" id="sewarchdata" class="col-sm-12" autocomplete="off">
		<div class="row"> 
		<div class="col-xl-1"></div>
			<div class="dropagent  col-sm-3 col-xl-2 mb-3">
			 <label class="label-c">Filter By Agent</label>
			  <?php 
			    if(!empty($_GET['did'])){ $guid = $_GET['did']; }else{ $guid = '';}
			    $result4 = mysqli_query($con,"SELECT sno, username FROM allusers where role='Agent' ORDER BY username"); ?>
				<select class="agentuname form-control"  name="agent_wise[]" id="agent_wise" multiple required>
				
				<?php while($rowUname = mysqli_fetch_assoc($result4)){
				$usno = $rowUname['sno'];
				?>
				<option value="<?php echo $usno; ?>" <?php if($usno == $guid) { echo 'selected="selected"'; } ?>><?php echo $rowUname['username']; ?></option>
				<?php } ?>
				
				</select>
				
		 </div>
		 <div class="dropagent  col-md-3 col-xl-2 mb-3">
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
				</select>
				<div class="btn btn-default clear-btn" id="reset" style="display:none;">Clear Selected</div>
		
		 </div>
		 <div class="dropagent  col-md-3 col-xl-2 mb-3">
			<label class="label-c">Filter By Course</label>
			  <?php 
			  $course_quesry = mysqli_query($con,"SELECT program_name FROM contract_courses  GROUP BY program_name"); ?>
				<select class="agentuname agnt-cource form-control"  name="course_wise[]" id="course_wise" multiple >
				
				<?php while($rowCourse= mysqli_fetch_assoc($course_quesry)){
				$coursedata = $rowCourse['program_name'];
				?>
				<option value="<?php echo $coursedata; ?>" ><?php echo $coursedata; ?></option>
				<?php } ?>
				
				</select>
			
		 </div>
		 <div class="dropagent  col-md-3 col-xl-2 mb-3">
			<label class="label-c">Filter By Intake</label>
			  <?php 
			  if(!empty($_GET['did'])){ $guid = $_GET['did']; }else{ $guid = '';}
			  $intake_quesry = mysqli_query($con,"SELECT intake FROM contract_courses  GROUP BY intake"); ?>
				<select class="agentuname form-control"  name="intake_wise[]" id="intake_wise" multiple>
				
				<?php while($rowIntak= mysqli_fetch_assoc($intake_quesry)){
				$intakdata = $rowIntak['intake'];	
				?>
				<option value="<?php echo $intakdata; ?>" ><?php echo $intakdata; ?></option>
				<?php 
				}?>
				
				
				
				</select>
			
		 </div>
		 <!--<div class="dropagent  col-sm-2 col-md-2 mb-3">
			 
			 <select class="agentuname form-control" name="month_wise" id="month_wise">
				<option value="">Month Wise</option>
					<option value="1">January</option>
					<option value="2">February Wise</option>
					<option value="3">Martch</option>
					<option value="4">April</option>
					<option value="5">May</option>
					<option value="6">June</option>
					<option value="7">July</option>
					<option value="8">Augest</option>
					<option value="9">September</option>
					<option value="10">October</option>
					<option value="11">November</option>
					<option value="12">Deceber</option>
				
				
				
				</select>
				
		 </div> --->
		 <div class="dropagent col-md-12 col-xl-2 mb-3">
			<center><input type="button" name="go"  class="search-button read-more" value="Search" id="search">	</center>
		 </div>
		 </div>
		 </form>
		<div class="col-sm-12">
			<div id="alldata"></div> 
		</div>
		
	</div>
  </div>
  
  

					
					
					
</div>
</section>








<?php 
include("../../footer.php");

}else{
	header("Location: ../../application");
}
?>
<script>
$(document).ready(function(){  
	$('#search').click(function(){  
				var agent_wise = $('#agent_wise').val();  
                var status_wise = $('#status_wise').val();  
				var course_wise = $('#course_wise').val();  
				var intake_wise = $('#intake_wise').val(); 
				
				if(agent_wise != ''){
				
					if((agent_wise != '') || (status_wise != '' || course_wise != '' || intake_wise != '' ))  
					{  
					 $.ajax({  
								  url:"../searchapplication.php?searchdata=filter",  
								  method:"POST",  
								  data:{agent_wise:agent_wise, status_wise:status_wise, course_wise:course_wise, intake_wise:intake_wise},  
								  success:function(data)  
								  {  
									   $('#alldata').html(data);  
								  }  
							 });   
							 
							
							
					}
					else  
					{  
						 alert("Please Select atleast one Fields");
						return false;					 
					} 
				} else {
					
					alert("Please Select agent");
					return false;	
				}

		});
		
	
		$('#all_course').click(function() {
			$('#course_wise option').prop('selected', true);
			$('#course_wise option:first').prop('selected', false);
		});
		$('#all_intake').click(function() {
			$('#intake_wise option').prop('selected', true);
			$('#intake_wise option:first').prop('selected', false);
		});

});  

</script> 

 <script type="text/javascript">
        $(function () {
            $('#course_wise').multiselect({
                  columns: 1,
				  placeholder: 'Select Courses',
				  includeSelectAllOption: true
				
            });
			 $('#intake_wise').multiselect({
                  columns: 1,
				  placeholder: 'Select Courses',
				  includeSelectAllOption: true
				
            });
			$('#agent_wise').multiselect({
                  columns: 1,
				  placeholder: 'Select Courses',
				  includeSelectAllOption: true
				
            });
           
        });
    </script>
<script>
//if(!$("#status_wise option:selected").length) {
//	alert('adiasfhi');
    //document.getElementById("reset").style.display = "block"; ;
//}

	 $("#status_wise").on("change", function () {
		 document.getElementById("reset").style.display = "block"; ;
    });
	
	
	
	


$("#reset").on("click", function () {
     $('#status_wise option').prop('selected', function() {
        return this.defaultSelected;
    });
});
</script>
<style>
.clear-btn{
	background: skyblue;
	color: white;
	
}
</style>

