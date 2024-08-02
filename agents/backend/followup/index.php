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
if($roles1 == 'Admin'){
?> 

<link rel="stylesheet" href="../../css/sweetalert.min.css">

<script src="../../js/sweetalert.min.js"></script>

<section class="container-fluid">
<div class="main-div"><div class=" admin-dashboard">
<h3 class="mt-0"><center>Pending Follow Up List</center></h3>
<div class="col-sm-12 application-tabs">
	<div class=" row">					
		<div class="col-sm-6 col-md-3 mb-2">
			<label>From Date</label>
			<input type="text" id="follow_from" class="form-control form-control-sm date_followup" placeholder="From Date">
		</div>
		<div class="col-sm-6 col-md-3 mb-2">
			<label>To Date</label>
			<input type="text" id="follow_to" class="form-control form-control-sm date_followup" placeholder="To Date">
		</div>
		<div class="col-sm-6 col-md-3 mb-2">
			<label>Select Stage</label>
		<select name="followup" class="form-control form-control-sm fstage mb-4" id="followup">
			<option value="">Select Option</option>
			<option value="Profile_stage">Profile Stage</option>
			<option value="Conditional_Offer_letter">Conditional Offer letter</option>
			<option value="LOA_Request">LOA Request</option>
			<option value="Contract_Stage">Contract Stage</option>
			<option value="FH_Sent">File Lodged</option>
			<option value="File_Not_Lodged">File Not Lodged</option>
		</select>
		</div>
			
		<div class="col-sm-6 col-md-3 pt-sm-1">
		
			<input type="button" name="submit" class="btn btn-success btn-sm mt-sm-4 followbtn" value="Search">
		</div>
		<div class="col-12 mt-4 text-center totalcnt" style="display:none;"><b>Total: </b> <span class="totalcnt11"></span></div>	
	</div>	
</div>
	
	<div class="row mt-4"> <div class="col-12">	
    <div class="table-responsive">
	<table class="table table-sm table-bordered" width="100%">
    <thead>	  
      <tr>	  
        <th>Agent Name</th>
		<th>Update<br>By(Name)</th>
        <th>Student <br>Name</th>
        <th>Reference<br>Id</th>		
        <th>Follow<br>Status</th>		
        <th>Next<br>Date</th>		
        <th>Stage</th>		
        <th>Remarks</th>		
        <th>Created</th>		
        <th>Action</th>		
      </tr>
    </thead>
    <tbody class="list_follow">	 
	<?php 
		$rsltQuery = "SELECT * FROM st_application where follow_name!='' AND follow_next_date!='' AND follow_status='1' AND flowdrp!='Drop' $agent_id_not_show order by sno desc";
		$qurySql = mysqli_query($con, $rsltQuery);	
		while ($row_nm = mysqli_fetch_assoc($qurySql)){
		$sno = $row_nm['sno']; 
		$agent_id = $row_nm['user_id']; 
		
		$agent_query = "select sno, username from allusers where sno ='$agent_id'";
		$agent_res = mysqli_query($con, $agent_query);
		$agent_row_data = mysqli_fetch_assoc($agent_res);
		$agent_name = $agent_row_data['username'];
		
		$action = "<a href='../application?aid=error_$sno' class='btn btn-sm btn-success' title='View Profile'><i class='fa fa-eye'></i></a>";
		$action1 = "<a href='javascript:void(0)' class='btn btn-sm btn-warning logFollow' data-target='#logFollowModel' data-toggle='modal' data-id='$sno'>Logs</a>";
		
		$studentname1 = $row_nm['fname'].' '.$row_nm['lname'];
		$studentname = "<a href='../followup/add.php?stusno=$sno' target='_blank'>$studentname1</a>";
		
		$refid = $row_nm['refid'];
		$follow_name = $row_nm['follow_name'];
		$follow_status = $row_nm['follow_status'];
		if($follow_status == '1'){
			$fstatus = 'Follow';
		}
		if($follow_status == '0'){
			$fstatus = 'DONE';
		}
		if($follow_status == ''){
			$fstatus = 'N/A';
		}		
		
		$follow_next_date = $row_nm['follow_next_date'];
		$follow_stage = $row_nm['follow_stage'];
		$follow_fremarks = $row_nm['follow_fremarks'];
		$follow_created = $row_nm['follow_created'];
	?>
		<tr>
			<td><?php echo $agent_name; ?></td>
			<td><?php echo $follow_name; ?></td>
			<td><?php echo $studentname; ?></td>
			<td><?php echo $refid; ?></td>
			<td><?php echo $fstatus; ?></td>
			<td><?php echo $follow_next_date; ?></td>
			<td><?php echo $follow_stage; ?></td>
			<td><?php echo $follow_fremarks; ?></td>
			<td><?php echo $follow_created; ?></td>
			<td><?php echo $action.' '.$action1; ?></td>
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
</section>

<div class="modal fade main-modal" id="logFollowModel" role="dialog">
<div class="modal-dialog modal-lg">
<div class="modal-content">
<div class="modal-header">
<h4 class="modal-title">Follow Up Logs</h4>
<button type="button" class="close" data-dismiss="modal">&times;</button>
</div>
<div class="modal-body">
<div class="loading_icon"></div>

<div class="row">
<div class="col-sm-12  mt-3">
	<div class="table-responsive">
<table class="table table-sm table-bordered">
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
$(document).on('click', '.followbtn', function(){	
	var follow_from = $('#follow_from').val();
	var follow_to = $('#follow_to').val();	
	var followup = $('#followup').val();	
	$('.loading_icon').show();
	$.post("../response.php?tag=followSearch",{"follow_to":follow_to,"follow_from":follow_from,"followup":followup},function(d){
	var multiple = d.length;
	$('.totalcnt11').html(multiple);
	$('.totalcnt').show();
	if(d == ""){	
		alert("Not found");
		$('.list_follow').html(" ");
		$('.loading_icon').hide();
	}else{	
		$('.list_follow').html(" ");		
		for (i in d) {
			$('<tr>' +	 
			'<td>'+d[i].agent_name+'</td>' +		 
			'<td>'+d[i].follow_name+'</td>' +		 
			'<td>'+d[i].studentname+'</td>' + 
			'<td>'+d[i].refid+'</td>' + 
			'<td>'+d[i].fstatus+'</td>' +
			'<td>'+d[i].follow_next_date+'</td>' +
			'<td>'+d[i].follow_stage+'</td>' +
			'<td>'+d[i].follow_fremarks+'</td>' +
			'<td>'+d[i].follow_created+'</td>' +
			'<td>'+d[i].action+' '+d[i].action1+'</td>' +
			'</tr>').appendTo(".list_follow");
		}
	}
		$('.loading_icon').hide();
	});	
});

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

<script>
$(function(){
    $(".date_followup").datepicker({	  
		dateFormat: 'yy-mm-dd', 
		changeMonth: false, 
		changeYear: false,
    });
});
</script>

<?php 
include("../../footer.php");

}else{
	header("Location: ../../application");
}
?>  
