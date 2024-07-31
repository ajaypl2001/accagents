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


if(isset($_GET['getcondion_'])){
			$queryConditiondata = base64_decode($_GET['getcondion_']);
			
			
		}
 
?>



<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.min.css">

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.min.js"></script>

<section><div class="main-div"><div class="col-sm-12 application-tabs">

<div class="tabs tabs-style-tzoid">
<nav>
<ul>
<div class="col-md-9 mb-margin col-sm-12 col-12">
</div>
    <div class="col-md-3 col-sm-12 col-12 search-col"> 
		<form class="form_submit_change_status" method="post"  action="apps_report_dwnlod.php?getcondion = <?php echo $_GET['getcondion_']; ?>" autocomplete="off" >
						<center>
							<button type="submit" class="btn crm-login-button1 " >Download to Excel</button>
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
	  
      <tr style="color:#fff;background:#596164;">
        <th></th>		
        <th>Agent <br>Name</th>		
        <th>Full <br>Name</th>
        <th>Refrence <br>ID</th>
        <th>Date<br>Time</th>	
        <th>Application <br>Status</th>
        <th>Conditional <br>Offer Letter</th>
		<?php if(($adminrole == 'Admin') || ($adminrole !== 'Excu')){ ?>
        <th>LOA Request <br>Status</th>
        <th>AOL <br>Contract</th>
        <th>Upload<br/> LOA </th>
		<?php } ?>
      </tr>
    </thead>
	
	
	
	
	
    <tbody id="totalshow" class="searchall">
	<?php	
		/*if(isset($_GET['aid']) && !empty($_GET['aid'])){
		$get_aid = $_GET['aid'];
		$expVal = explode("error_", $get_aid);
		$result2 = mysqli_query($con,"(SELECT * FROM st_application where application_form='1' AND sno='$expVal[1]') UNION (SELECT * FROM st_application where application_form='1' AND sno !='$expVal[1]' order by sno ASC)");
		}else{
		$result2 = mysqli_query($con,"SELECT * FROM st_application where application_form='1'");
		} */
		
		if(isset($_GET['getcondion_'])){
			$queryCondition = base64_decode($_GET['getcondion_']);
			
			
		} else {
			$queryCondition = " application_form='1'";
			
			
		}
		$result2 = mysqli_query($con,"SELECT * FROM st_application INNER JOIN allusers on st_application.user_id = allusers.sno  " . $queryCondition . " ");
	
	
		while ($row = mysqli_fetch_assoc($result2)) {
			 $snoall = mysqli_real_escape_string($con, $row['sno']);
			 $app_by = mysqli_real_escape_string($con, $row['app_by']);
			 $agent_type = mysqli_real_escape_string($con, $row['agent_type']);
			 $user_id = mysqli_real_escape_string($con, $row['user_id']);
			 $refid = mysqli_real_escape_string($con, $row['refid']);
			 $fname = mysqli_real_escape_string($con, $row['fname']);			
			 $lname = mysqli_real_escape_string($con, $row['lname']);			
			 $datetime = mysqli_real_escape_string($con, $row['datetime']);
			 $prg_name1 = mysqli_real_escape_string($con, $row['prg_name1']);
			 $prg_intake = mysqli_real_escape_string($con, $row['prg_intake']);
			 $admin_status_crs = mysqli_real_escape_string($con, $row['admin_status_crs']);
			 $admin_remark_crs = mysqli_real_escape_string($con, $row['admin_remark_crs']);
			 $ol_confirm = mysqli_real_escape_string($con, $row['ol_confirm']);
			 $signed_ol_confirm = mysqli_real_escape_string($con, $row['signed_ol_confirm']);
			 $offer_letter = mysqli_real_escape_string($con, $row['offer_letter']);
			 $file_receipt = mysqli_real_escape_string($con, $row['file_receipt']);
			 $loa_confirm = mysqli_real_escape_string($con, $row['loa_confirm']);
			 $loa_confirm_remarks = mysqli_real_escape_string($con, $row['loa_confirm_remarks']);
			 $agreement = mysqli_real_escape_string($con, $row['agreement']);
			 $agreement_loa = mysqli_real_escape_string($con, $row['agreement_loa']);
			 $signed_al_status = mysqli_real_escape_string($con, $row['signed_al_status']);
			 $contract_letter = mysqli_real_escape_string($con, $row['contract_letter']);
			 $signed_agreement_letter = mysqli_real_escape_string($con, $row['signed_agreement_letter']);
			 $loa_file = mysqli_real_escape_string($con, $row['loa_file']);
			 $loa_file_status = mysqli_real_escape_string($con, $row['loa_file_status']);
			 
			 $agntname = mysqli_real_escape_string($con, $row['username']);
			 
			 //$agnt_qry = mysqli_query($con,"SELECT username FROM allusers where sno='$user_id'");
		    // while ($row_agnt_qry = mysqli_fetch_assoc($agnt_qry)) {
			// $agntname = mysqli_real_escape_string($con, $row_agnt_qry['username']);
			// }
	?>
      <tr class="error_<?php echo $snoall;?>">
        <td>
		<input type="checkbox" id="error_<?php echo $snoall;?>" />
		</td>
        <td>
		<?php 
			if($app_by == 'Student'){
				echo $app_by; 
			}
			if($agent_type == 'normal'){
				echo $agntname; 
			}
			if($agent_type == 'int_agent'){
				echo $agntname;
			}       
		?>
		</td>
        <td><?php echo $fname.' '.$lname;?></td>
        <td><?php echo $refid;?></td>
        <td><?php echo $datetime;?></td>
        <td>
		<a href="edit.php?apid=<?php echo base64_encode($snoall); ?>" class="btn edit-aplic btn-sm"><i class="fas fa-edit" data-toggle="tooltip" data-placement="top" title="Edit Application"></i></a>
		<span class="btn btn-sm jmjm" data-toggle="modal" title="View" data-target="#myModaljjjs" data-id="<?php echo $snoall; ?>"><i class="fas fa-eye" data-toggle="tooltip" data-placement="top" title="View Application"></i></span>
        <?php if($admin_status_crs == ""){ ?>
	    <span class="btn btn-sm confirmbtn1 checklistClassyellow" data-toggle="modal" data-target="#confirmbtn2" data-id="<?php echo $snoall; ?>"><i class="fas fa-pencil-alt" data-toggle="tooltip" data-placement="top" title="Update Application Status (No Action)"></i></i></span>
        <?php } if($admin_status_crs == "No"){ ?>
	    <span class="btn btn-sm confirmbtn1 checklistClassred" data-toggle="modal" data-target="#confirmbtn2" data-id="<?php echo $snoall; ?>"><i class="fas fa-pencil-alt" data-toggle="tooltip" data-placement="top" title="Application Not Approved"></i></i></span>
        <?php } if($admin_status_crs == "Yes"){	?>
	    <span class="btn btn-sm confirmbtn1 checklistClass" data-toggle="modal" data-target="#confirmbtn2" data-id="<?php echo $snoall; ?>"><i class="fas fa-check" data-toggle="tooltip" data-placement="top" title="Application Approved (Processing Offer Letter)"></i></i></span>
        <?php } ?>
		</td>
				
		<td>
		<?php		
		if(($admin_status_crs == 'No') || ($admin_status_crs == '')){ 
			echo '<span class="btn btn-sm btn-pending" data-toggle="tooltip" data-placement="top" title="" data-original-title="No Action Made"><i class="fas fa-times"></i></span>';
		}		
		if(($admin_status_crs == 'Yes') && ($offer_letter == '') && ($ol_confirm == '')){ ?>
			<div class="btn btn-sm checklistClassred olClass" data-toggle="modal" data-target="#olModel" data-id="<?php echo $snoall; ?>"><i class="fas fa-upload" data-toggle="tooltip" data-placement="top" title="Generate Offer Letter"></i></div>		
		<?php }
		
		if(($admin_status_crs == 'Yes') && ($offer_letter !== '') && ($ol_confirm == '')){ ?>
			<div class="btn btn-sm checklistClassyellow olClass" data-toggle="modal" data-target="#olModel" data-id="<?php echo $snoall; ?>"><i class="fas fa-upload" data-toggle="tooltip" data-placement="top" title="Offer Letter Generated (Send)"></i></div>		
		<?php }
		
		if(($admin_status_crs == 'Yes') && ($offer_letter !== '') && ($ol_confirm == '1') && ($agreement == '')){ ?>
			<div class="btn btn-sm checklistClassgreen olClass" data-toggle="modal" data-target="#olModel" data-id="<?php echo $snoall; ?>"><i class="fas fa-upload" data-toggle="tooltip" data-placement="top" title="Offer Letter Sent (Sign Pending)"></i></div>		
		<?php }
		
		if(($admin_status_crs == 'Yes') && ($offer_letter !== '') && ($ol_confirm == '1') && ($agreement !== '') && ($signed_ol_confirm == '')){ ?>
			<div class="btn btn-sm checklistClassyellow olClass" data-toggle="modal" data-target="#olModel" data-id="<?php echo $snoall; ?>"><i class="fas fa-sync-alt" data-toggle="tooltip" data-placement="top" title="Signed Offer Letter Sent (Status Pending)"></i></div>		
		<?php }
		
		if(($admin_status_crs == 'Yes') && ($offer_letter !== '') && ($ol_confirm == '1') && ($agreement !== '') && ($signed_ol_confirm == 'No') ){ ?>
			<div class="btn btn-sm checklistClassred olClass" data-toggle="modal" data-target="#olModel" data-id="<?php echo $snoall; ?>"><i class="fas fa-sync-alt" data-toggle="tooltip" data-placement="top" title="Signed Offer Letter Not Approved"></i></div>		
		<?php }
		
		if(($admin_status_crs == 'Yes') && ($offer_letter !== '') && ($ol_confirm == '1') && ($agreement !== '') && ($signed_ol_confirm == 'Yes') ){ ?>
			<div class="btn btn-sm checklistClassgreen olClass" data-toggle="modal" data-target="#olModel" data-id="<?php echo $snoall; ?>"><i class="fas fa-check" data-toggle="tooltip" data-placement="top" title="Signed Offer Letter Approved (Request LOA)"></i></div>		
		<?php }	?>
		</td>
		<?php if(($adminrole == 'Admin') || ($adminrole !== 'Excu')){ ?>
		<td>
		<?php if(($signed_ol_confirm !== 'Yes') && ($file_receipt == '')){ ?>
		<span class="btn btn-sm btn-pending" data-toggle="tooltip" data-placement="top" data-original-title="No Action Made"><i class="fas fa-times"></i></span>
		<?php } 
		if(($signed_ol_confirm == 'Yes') && ($file_receipt == '')){ ?>
		<span class="btn checklistClassyellow btn-sm" data-toggle="tooltip" data-placement="top" data-original-title="LOA Not Requested"><i class="fas fa-times"></i></span>
		<?php }       
        if(($file_receipt !== '')){ ?>
		<div class="btn checklistClassgreen btn-sm" idno="<?php echo $snoall; ?>"><i class="fas fa-check" data-toggle="tooltip" data-placement="top" title="LOA Request Sent"></i></div>
		<?php } ?>				
		</td>			
		<td>
		<?php if($file_receipt !== '1'){ ?>
		<span class="btn btn-sm btn-pending" data-toggle="tooltip" data-placement="top" data-original-title="No Action Made"><i class="fas fa-times"></i></span>
		<?php } 
		if(($file_receipt == '1') && ($contract_letter =='')){ ?> 
      
		<span class="btn checklistClassred btn-sm loaAgreeCl" data-toggle="modal" data-target="#loaAgreeModel" data-id="<?php echo $snoall; ?>" > <i class="fas fa-upload" data-toggle="tooltip" data-placement="top" title="Generate Contract"></i></div>
		<?php }		
		if(($file_receipt == '1') && ($contract_letter !=='') && ($agreement_loa=='')){ ?>
		<span class="btn checklistClassyellow btn-sm loaAgreeCl" data-toggle="modal" data-target="#loaAgreeModel" data-id="<?php echo $snoall; ?>" > <i class="fas fa-upload" data-toggle="tooltip" data-placement="top" title="Contract Generated (Send)"></i></div>
		<?php }		
		if(($file_receipt == '1') && ($contract_letter !=='') && ($agreement_loa=='1') && ($signed_agreement_letter=='') ){ ?>
		<span class="btn checklistClassgreen btn-sm loaAgreeCl" data-toggle="modal" data-target="#loaAgreeModel" data-id="<?php echo $snoall; ?>" > <i class="fas fa-upload" data-toggle="tooltip" data-placement="top" title="Generated Contract Sent"></i></div>
		<?php }		
        if(($agreement_loa !=='') && ($agreement_loa =='1') && ($signed_agreement_letter !=='') && ($signed_al_status=='')){ ?>
		<span class="btn checklistClassgreen btn-sm loaAgreeCl" data-toggle="modal" data-target="#loaAgreeModel" data-id="<?php echo $snoall; ?>" > <i class="fas fa-sync-alt" data-toggle="tooltip" data-placement="top" title="Signed Contract Sent (Update Status)"></i></div>
		<?php }		
		if(($agreement_loa !=='') && ($agreement_loa =='1') && ($signed_agreement_letter !=='') && ($signed_al_status=='No')){ ?>
		<span class="btn checklistClassred btn-sm loaAgreeCl" data-toggle="modal" data-target="#loaAgreeModel" data-id="<?php echo $snoall; ?>" > <i class="fas fa-check" data-toggle="tooltip" data-placement="top" title="Signed Contract Not Approved"></i></div>
		<?php }               
        if(($agreement_loa !=='') && ($agreement_loa =='1') && ($signed_agreement_letter !=='') && ($signed_al_status=='Yes')){ ?>
		<span class="btn checklistClassgreen btn-sm loaAgreeCl" data-toggle="modal" data-target="#loaAgreeModel" data-id="<?php echo $snoall; ?>" > <i class="fas fa-check" data-toggle="tooltip" data-placement="top" title="Signed Contract Approved"></i></div>
		<?php } ?>
		</td>
		<td>
		<?php
		if(($signed_al_status == '') || ($signed_al_status == 'No')){
			echo '<span class="btn btn-sm btn-pending" data-toggle="tooltip" data-placement="top" title="" data-original-title="No Action Made"><i class="fas fa-times"></i></span>';		
		}
		if(($signed_al_status == 'Yes') && ($loa_file == '')){ ?>
		<div class="btn checklistClassyellow btn-sm genrateClass" data-toggle="modal" data-target="#genrateModel" data-id="<?php echo $snoall;?>"><i class="fas fa-upload" data-toggle="tooltip" data-placement="top" title="Generate LOA"></i></div>
		<?php }		
		if(($loa_file !== '') && ($loa_file_status == '')){ ?>
		<div class="btn checklistClassgreen btn-sm genrateClass" data-toggle="modal" data-target="#genrateModel" data-id="<?php echo $snoall;?>" ><i class="fas fa-check" data-toggle="tooltip" data-placement="top" title="LOA Generated"></i></div>
		<?php }	
		if(($loa_file !== '') && ($loa_file_status == '1')){ ?>
		<span class="btn checklistClassgreen btn-sm genrateClass" data-toggle="modal" data-target="#genrateModel" data-id="<?php echo $snoall;?>" ><i class="fas fa-check" data-toggle="tooltip" data-placement="top" title="LOA Sent"></i></div>
		<?php }	?>
		</td>
		<?php }	?>		
      </tr>
	<?php } ?>
    </tbody>	
 </table>  
 </div>

	</div>
  </div>
</div>

<?php if(!empty($_GET["aid"]) && empty($_GET["tab"])){ ?>
<script>
	$(".<?php echo $_GET["aid"];?>").css({"background-color": "#A8D8F4"});
	$("#<?php echo $_GET["aid"];?>").prop('checked', true);
</script>
<?php }
if(!empty($_GET["aid"]) && !empty($_GET["tab"])){
if($_GET["tab"] == 'All'){
?>
<script>
	$('li#activeId1').removeClass("active");
    $('li#activeId').addClass("active");	
    $('.dropagent').hide();	
	$(".<?php echo $_GET["aid"];?>").css({"background-color": "#A8D8F4"});
	$("#<?php echo $_GET["aid"];?>").prop('checked', true);
</script>
<?php }
if($_GET["tab"] == 'Agent'){
?>
<script>
	$('.dropagent').show();
	$('li#activeId').removeClass("active");
    $('li#activeId1').addClass("active");	
	$(".<?php echo $_GET["aid"];?>").css({"background-color": "#A8D8F4"});
	$("#<?php echo $_GET["aid"];?>").prop('checked', true);
</script>
<?php } } ?>


<script>
$(document).on('click', '.sabbtn', function(){	
	var agnt = $(this).attr('userVal');
	var rowbg = $(this).attr('rowbg');
	$('.applicationStatus').val("");
	$('.rowbg1').attr('value',agnt);
	
	$('#totalVal').hide();
	if(agnt == 'Agent'){
		$('.dropagent').show();
		$('.dropstudent').hide();
		$("Student").css({"background-color": "white", "color": "#1d6093", "border": "1px solid #1d6093"});
	}
	if(agnt == 'Student'){
		$('.dropagent').hide();
		$('.dropstudent').show();
		$("Agent").css({"background-color": "white", "color": "#1d6093", "border": "1px solid #1d6093"});
	}
	if(agnt == 'All'){
		$('.dropagent').hide();
		$('.dropstudent').hide();
		$("Agent").css({"background-color": "white", "color": "#1d6093", "border": "1px solid #1d6093"});
	}
	$('.loading_icon').show();
	$.post("../response.php?tag=getlisting",{"roletype":agnt, "rowbg":rowbg},function(d){	
	if(d == ""){	
		alert("Not found");
		$('.searchall').html(" ");
		$('.loading_icon').hide();
	}else{	
		$('.searchall').html(" ");		
		for (i in d) {
			$('<tr '+d[i].chbx+'>' +		
			'<td>' +
			'<input type="checkbox" id="error_'+d[i].sno+'" />' +
			'</td>' + 
			'<td>'+d[i].app_by+'</td>' + 
			'<td>'+d[i].fname+' '+d[i].lname+'</td>' +  
			'<td>'+d[i].refid+'</td>' +
			'<td>'+d[i].datetime+'</td>' + 
			'<td>'+
			'<a href="edit.php?apid='+btoa(d[i].sno)+'" class="btn edit-aplic btn-sm"><i class="fas fa-edit" data-toggle="tooltip" data-placement="top" title="Edit Application"></i></a>'+' '+
			'<span class="btn btn-sm jmjm" data-toggle="modal" title="View" data-target="#myModaljjjs" data-id="'+d[i].sno+'"><i class="fas fa-eye" data-toggle="tooltip" data-placement="top" title="View Application"></i></span>'+' '+
			''+d[i].appliStatus+''+
			'</td>'+
			'<td>'+d[i].olval1+'</td>'+
			''+d[i].btnpmt2+''+
			''+d[i].olval3+''+
			''+d[i].btnloa+''+
			'</tr>').appendTo(".searchall");
		}
	}
		$("[data-toggle='tooltip']").tooltip();
		$('.loading_icon').hide();
	});	
});

$(document).on('change', '.agentuname', function(){	
	var uid = $(this).val();
	$('.applicationStatus option').attr('value', uid);
	var rowbg = $(this).attr('rowbg');
	$('#totalVal').hide();
	$('.loading_icon').show();

	$.post("../response.php?tag=getuname",{"idtype":uid, "rowbg":rowbg},function(d){	
	if(d == ""){		
		alert("Not found");
		$('.searchall').html(" ");
		$('.loading_icon').hide();		
	}else{
		$('.searchall').html(" ");		
		for (i in d) {
			$('<tr '+d[i].chbx+'>' +			
			'<td>' +
			'<input type="checkbox" id="error_'+d[i].sno+'" />' +
			'</td>' +
			'<td>'+d[i].app_by+'</td>' + 
			'<td>'+d[i].fname+' '+d[i].lname+'</td>' +  
			'<td>'+d[i].refid+'</td>' + 
			'<td>'+d[i].datetime+'</td>' + 
			'<td>'+
			'<a href="edit.php?apid='+btoa(d[i].sno)+'" class="btn edit-aplic btn-sm"><i class="fas fa-edit" data-toggle="tooltip" data-placement="top" title="Edit Application"></i></a>'+' '+
			'<span class="btn btn-sm jmjm" data-toggle="modal" title="View" data-target="#myModaljjjs" data-id="'+d[i].sno+'"><i class="fas fa-eye" data-toggle="tooltip" data-placement="top" title="View Application"></i></span>'+' '+
			''+d[i].appliStatus+''+
			'</td>'+
			'<td>'+d[i].olval1+'</td>'+
			''+d[i].btnpmt2+''+
			''+d[i].olval3+''+
			''+d[i].btnloa+''+
			'</tr>').appendTo(".searchall");
		}
		}
		$("[data-toggle='tooltip']").tooltip();
		$('.loading_icon').hide();
	});	
});

$(document).on('change', '.applicationStatus', function(){	
	var idtype1 = $(this).val(); 
	var statusVal = $('option:selected', this).attr('data-id')
	if(idtype1 !== ''){
		idtype2 = idtype1;
	}
	if(idtype1 == ''){
		idtype2 = '';
	}
	var rowbg = $(this).attr('rowbg');
	$('.loading_icon').show();
	
	$.post("../response.php?tag=Select_Status",{"status1":statusVal, "subid":idtype2, "rowbg":rowbg},function(d){
	if(d == ""){	
		alert("Not found");
		$('.searchall').html(" ");
		$('#totalVal').show();
		var multiple = d.length;
		$('#countVal').html(multiple);
		$('.loading_icon').hide();
	}else{		
		$('#totalVal').show();
		var multiple = d.length;
		$('#countVal').html(multiple);
		$('.searchall').html("");	
		for (i in d) {
			$('<tr '+d[i].chbx+'>' +			
			'<td>' +
			'<input type="checkbox" id="error_'+d[i].sno+'" />' +
			'</td>' +
			'<td>'+d[i].app_by+'</td>' + 
			'<td>'+d[i].fname+' '+d[i].lname+'</td>' +  
			'<td>'+d[i].refid+'</td>' + 
			'<td>'+d[i].datetime+'</td>' + 
			'<td>'+
			'<a href="edit.php?apid='+btoa(d[i].sno)+'" class="btn edit-aplic btn-sm"><i class="fas fa-edit" data-toggle="tooltip" data-placement="top" title="Edit Application"></i></a>'+' '+
			'<span class="btn btn-sm jmjm" data-toggle="modal" title="View" data-target="#myModaljjjs" data-id="'+d[i].sno+'"><i class="fas fa-eye" data-toggle="tooltip" data-placement="top" title="View Application"></i></span>'+' '+
			''+d[i].appliStatus+''+
			'</td>'+
			'<td>'+d[i].olval1+'</td>'+
			''+d[i].btnpmt2+''+
			''+d[i].olval3+''+
			''+d[i].btnloa+''+
			'</tr>').appendTo(".searchall");
		}
	}
		$("[data-toggle='tooltip']").tooltip();
		$('.loading_icon').hide();
	});	
});
</script>

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

<div class="modal fade main-modal" id="confirmbtn2" role="dialog">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<h4 class="modal-title">Application Status</h4>
<button type="button" class="close" data-dismiss="modal">&times;</button>

</div>
<form method="post" action="../mysqldb.php">
<div class="modal-body">
<div class="loading_icon"></div>
<div class="col-sm-12">
<div class="row">
	<h3 style="font-size:22px;">Update Application Status and Course</h3>     
	 <div class="col-sm-12">
	 <div class="row">
		<strong>Intake </strong>:
		<select name="intake" class="form-control intke" required>
			<option value="">Select Option</option>
			<option value="SEP-2018">SEP 2018</option>
			<option value="NOV-2018">NOV 2018</option>
		</select>
		<strong>Program Type:</strong>
		<select name="prg_name1" class="form-control intkeAppend" required>
			<option value="">Select Option</option>			
		</select>
		<strong> Status </strong>: 
		<select name="admin_status_crs" class="form-control" required>
			<option value="">Select Option</option>
			<option value="Yes">Yes</option>
			<option value="No">No</option>
		</select>		
		<strong>Remarks </strong>: 
		<textarea name="admin_remark_crs" class="form-control" required></textarea>		
	</div>
	</div>
    <p>
	<input type="hidden" name="rowbg1" class="rowbg1" value="<?php if(!empty($_GET['tab'])){ echo $_GET['tab']; } ?>">
	<input type="hidden" name="snoid" class="ssid" value="">
	<input type="submit" name="appbtncrs" class="btn btn-submit">
	</p>
    </div>   
	<br>
   </div>   
   <div class="col-sm-12  mt-3"> <div class="remarkShow"></div></div>    
     </div>
</form>
<div class="modal-footer">
<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>
</div>
</div>
</div>

<div class="modal fade main-modal" id="loaModel" role="dialog">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<h4 class="modal-title">LOA Request Status</h4>
<button type="button" class="close" data-dismiss="modal">&times;</button>
</div>
<div class="modal-body">
<div class="loading_icon"></div>
<div class="col-sm-12">
<div class="row">
<div class="col-sm-12  mt-3">
<div class="loalist"></div>
<div class="loars"></div>
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

<div class="modal fade main-modal" id="loaAgreeModel" role="dialog">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<h4 class="modal-title">Contract Status</h4>
<button type="button" class="close" data-dismiss="modal">&times;</button>
</div>
<div class="modal-body">
<div class="loading_icon"></div>
<div class="col-sm-12">
<div class="row">
<div class="col-sm-12  mt-3">
<div class="loalist1"></div>
<form method="post" action="../mysqldb.php">
<p><b>Update Status</b></p>
<select name="signed_al_status" class="form-control col-sm-6" required>
<option value="">Select Option</option>
<option value="Yes">Yes</option>
<option value="No">No</option>
</select><br>
<textarea name="signed_al_remarks" class="form-control col-sm-6" required></textarea><br>
<input type="hidden" name="rowbg1" class="rowbg1" value="<?php if(!empty($_GET['tab'])){ echo $_GET['tab']; } ?>">
<input type="hidden" name="snid" class="olsnid" value="">
<input type="submit" name="SignedalBtn" value="Submit" class="btn btn-sm btn-success">
</form><br />
<div class="loalist3"></div>
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

<div class="modal fade main-modal" id="genrateModel" role="dialog">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<h4 class="modal-title">Upload LOA</h4>
<button type="button" class="close" data-dismiss="modal">&times;</button>
</div>
<div class="modal-body">
<div class="loading_icon"></div>
<div class="col-sm-12">
<div class="row">
<div class="col-sm-12  mt-3">
	<div class="gloadiv"></div>
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

</div></div></div></section>


<div class="modal fade main-modal" id="olModel" role="dialog">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<h3 class="modal-title" style="font-size:22px;">Conditional Offer Letter</h3>
<button type="button" class="close" data-dismiss="modal">&times;</button>
</div>
<div class="modal-body">
<div class="row">
<div class="col-sm-12">
<div class="loading_icon"></div>
<div id="oldownload" class="mt-3"></div>
<form method="post" action="../mysqldb.php">
<p><b>Update Status</b></p>
<select name="signed_ol_confirm" class="form-control col-sm-6" required>
<option value="">Select Option</option>
<option value="Yes">Yes</option>
<option value="No">No</option>
</select><br>
<textarea name="signed_ol_remarks" class="form-control col-sm-6" required></textarea><br>
<input type="hidden" name="rowbg1" class="rowbg1" value="<?php if(!empty($_GET['tab'])){ echo $_GET['tab']; } ?>">
<input type="hidden" name="snid" class="olsnid" value="">
<input type="submit" name="SignedolBtn" value="Submit" class="btn btn-sm btn-success">
</form>
<div id="agdownload" class="mt-3"></div>
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
$(document).on('change', '.intke', function(){
	$('.loading_icon').show();
	var vl = $(this).val();
	$.post("../response.php?tag=corseadd",{"intake":vl},function(d){
		$(".intkeAppend").html(" ");
		$(".intkeAppend").html("<option value=''>Select Option</option>");		
		for (i in d) {
			$('<option value="' + d[i].program_name + '">'+ d[i].program_name +'</option>').appendTo(".intkeAppend");
		}
	$('.loading_icon').hide();		
	});	
});
</script>

<script>
$(document).on('click', '.olClass', function(){
	var idmodel = $(this).attr('data-id');
	$('.olsnid').attr('value' ,idmodel);
	$('.loading_icon').show();
	$.post("../response.php?tag=chkofferclass",{"idno":idmodel},function(d){		
		$('#oldownload').html("");
		$('<div>' +
		'<p><b><span style="fot-size:8px; color:red;">Note : <span> <span style="fot-size:6px; color:#666;">Refresh the page after generating the contract to view the latest file on download link<span></b>' + d[0].linkpdf + '</p>' +
		'<p><b>Generated Conditional Offer Letter: </b>' + d[0].ol_download + '</p>' +
		'<p>'+ d[0].btnstatus + '</p>' +
		'<p><b>Status: </b>' + d[0].col + '</p>' +
		'</div>').appendTo("#oldownload");
		
<!--- send ol status--->		
	$('.cnfmFun').on('click', function(){
	var status = $(this).attr('idno');
    var message = "You can change the status";
        if(status){
            var updateMessage = "Offer Letter Sent";
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
		var url = '../response.php?tag=confirmbtn_ol';
		$.ajax({
			type: "POST",
			url: url,
			data:'idno='+status, 
			success :  function(data){			   
			if(data == 1){
				swal("Updated!", "Status " + updateMessage +" successfully", "success");   
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
	
<!--- cancel ol status--->		
$('.cnfmFun1').on('click', function(){
	var status = $(this).attr('idno');
    var message = "You can change the status";
        if(status){
            var updateMessage = "Cancel Letter Sent";
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
		var url = '../response.php?tag=confirmbtn_ol1';
		$.ajax({
			type: "POST",
			url: url,
			data:'idno='+status, 
			success :  function(data){			   
			if(data == 1){
				swal("Updated!", "Status " + updateMessage +" successfully", "success");   
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
		
	});
	$.post("../response.php?tag=signedconfirm",{"idno":idmodel},function(d){		
		$('#agdownload').html("");
		$('<div>' +	
		'<p><b>Signed Conditional Offer Letter: </b>' + d[0].agl + '</p>' +	
		'<p><b>Status by AOL: </b>' + d[0].scol + '</p>' +
		'<p><b>Remarks by AOL: </b>' + d[0].remarks + '</p>' +
		'</div>').appendTo("#agdownload");		
		$('.loading_icon').hide();		
	});
});

<!--- Agreement Status --->
$(document).on('click', '.loaAgreeCl', function(){
	var idmodel = $(this).attr('data-id');
	$('.olsnid').attr('value' ,idmodel);
	$('.loading_icon').show();
	$.post("../response.php?tag=aol_agreement1",{"idno":idmodel},function(d){		
		$('.loalist3').html("");
		$('<div>' +		
		'<p><b>Signed Contract Status by AOL: </b>' + d[0].sals + '</p>' +
		'<p><b>Remarks by AOL: </b>' + d[0].salr + '</p>' +
		'</div>').appendTo(".loalist3");				
	});
	$.post("../response.php?tag=aol_agreement",{"idno":idmodel},function(d){
		$('.loalist1').html("");
		$('<div>' +
		'<p><b><span style="fot-size:8px; color:red;">Note : <span> <span style="fot-size:6px; color:#666;">Refresh the page after generating the contract to view the latest file on download link.<span></b>' + d[0].agree_download + '</p>' +		
		'<p><b>Generated Contract : </b>' + d[0].contract_download + '</p>' +		
		'<p>' + d[0].btnstatus + '</p>' +		
		'<p><b>Signed Contract by Student: </b>' + d[0].loaconfirm1 + '</p>' +
		'</div>').appendTo(".loalist1");
$('.loading_icon').hide();		

<!--- Verified --->	
	$('.loaAgreeFun').on('click', function(){
	var status = $(this).attr('idno');
    var message = "You can change the status";
        if(status){
            var updateMessage = "LOA Contract Sent";
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
		var url = '../response.php?tag=contratStatus';
		$.ajax({
			type: "POST",
			url: url,
			data:'idno='+status, 
			success :  function(data){			   
			if(data == 1){
				swal("Updated!", "Status " + updateMessage +" successfully", "success");   
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
	<!--- Cancel --->		
$('.loaAgreeFun1').on('click', function(){
	var status = $(this).attr('idno');
    var message = "You can change the status";
        if(status){
            var updateMessage = "LOA Contract Sent";
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
		var url = '../response.php?tag=contratStatus1';
		$.ajax({
			type: "POST",
			url: url,
			data:'idno='+status, 
			success :  function(data){			   
			if(data == 1){
				swal("Updated!", "Status " + updateMessage +" successfully", "success");   
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
	});	
});


$('.genrateloa1').on('click', function(){	
    var message = "You can change the status";
        if(status){
            var updateMessage = "LOA Contract Sent";
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
		var url = '../response.php?tag=gnrtLoa';
		$.ajax({
			type: "POST",
			url: url,
			data:'idno=1', 
			success :  function(data){			   
			if(data == 1){
				swal("Updated!", "Status " + updateMessage +" successfully", "success");   
			}else{
			   swal("Failed", data, "error");				   
			}
			setTimeout(function(){
				location.reload(); 
			}, 5000);  
            }
        })  
    }); 
});

<!--- LOA --->
$(document).on('click', '.genrateClass', function(){
	var idmodel = $(this).attr('data-id');
	$('.loading_icon').show();
	$.post("../response.php?tag=loaGenrate",{"idno":idmodel},function(d){
		$('.gloadiv').html("");
		$('<div>' +
		'<p>' + d[0].btnstatus + '</p>' +	
		'<p><b>Upload LOA: </b>' + d[0].Loadownload + '</p>' +
		'</div>').appendTo(".gloadiv");
		$('.loading_icon').hide();
		
<!--- Cancel --->		
$('.loastatusFun1').on('click', function(){
	var status = $(this).attr('idno');
    var message = "You can change the status";
        if(status){
            var updateMessage = "LOA Cancel Status Sent";
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
		var url = '../response.php?tag=loaStatus1';
		$.ajax({
			type: "POST",
			url: url,
			data:'idno='+status, 
			success :  function(data){			   
			if(data == 1){
				swal("Updated!", "Status " + updateMessage +" successfully", "success");   
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
	
<!--- Verified --->	
	$('.loastatusFun').on('click', function(){
	var status = $(this).attr('idno');
    var message = "You can change the status";
        if(status){
            var updateMessage = "LOA Status Sent";
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
		var url = '../response.php?tag=loaStatus';
		$.ajax({
			type: "POST",
			url: url,
			data:'idno='+status, 
			success :  function(data){			   
			if(data == 1){
				swal("Updated!", "Status " + updateMessage +" successfully", "success");   
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

    }); 
});

$(document).on('click', '.confirmbtn1', function(){
	var idmodel = $(this).attr('data-id');
	$('.ssid').attr('value' ,idmodel);
	$('.loading_icon').show();
	$.post("../response.php?tag=remarkdb",{"idno":idmodel},function(obj){
		$('.remarkShow').html("");
		$('<div>' +
		'<p><strong>Application Status : </strong>' + obj[0].admin_status_crs + '</p>' +
		'<p><strong>Application Remarks : </strong> ' + obj[0].admin_remark_crs + '</p>' +
		'<p><strong>Course Intake: </strong>' + obj[0].ptake + '</p>' +
		'<p><strong>Course Type : </strong> ' + obj[0].pname + '</p>' +
		'</div>').appendTo(".remarkShow");
		$('.loading_icon').hide();	
	});
});	

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
$(document).on('keyup', '#searchbtn', function(){
	var lst = $(this).val();
	$('#totalVal').hide();
	var rowbg = $(this).attr('rowbg');
	$('.loading_icon').show();
	$.post("../response.php?tag=getlisting",{"searchtext":lst, "rowbg":rowbg},function(d){
		$('.searchall').html(" ");		
		for (i in d) {
			$('<tr class="error_'+d[i].sno+'">' +			
			'<td>' +
			'<input type="checkbox" id="error_'+d[i].sno+'" />' +
			'</td>' +
			'<td>'+d[i].app_by+'</td>' + 
			'<td>'+d[i].fname+' '+d[i].lname+'</td>' +  
			'<td>'+d[i].refid+'</td>' +
			'<td>'+d[i].datetime+'</td>' + 
			'<td>'+
			'<a href="edit.php?apid='+btoa(d[i].sno)+'" class="btn edit-aplic btn-sm"><i class="fas fa-edit" data-toggle="tooltip" data-placement="top" title="Edit Application"></i></a>'+' '+
			'<span class="btn btn-sm jmjm" data-toggle="modal" title="View" data-target="#myModaljjjs" data-id="'+d[i].sno+'"><i class="fas fa-eye" data-toggle="tooltip" data-placement="top" title="View Application"></i></span>'+' '+
			''+d[i].appliStatus+''+
			'</td>'+
			'<td>'+d[i].olval1+'</td>'+
			''+d[i].btnpmt2+''+
			''+d[i].olval3+''+
			''+d[i].btnloa+''+
			'</tr>').appendTo(".searchall");
		}
		$("[data-toggle='tooltip']").tooltip();
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

<div class="modal fade" id="yes_application_alert">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">×</button>
        </div>
        <div class="modal-body">
          Status Updated Successfully 
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
        
      </div>
    </div>
  </div>
<?php 
include("../../footer.php");

}else{
	header("Location: ../../application");
}
?>  
