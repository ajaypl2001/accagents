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
if(isset($_POST['srchClickbtn'])){
	$search = $_POST['inputval'];
	header("Location: agent_change.php?getsearch=$search");
}


if($roles1 == 'Admin'){
?> 
<link rel="stylesheet" href="../../css/sweetalert.min.css">
<script src="../../js/sweetalert.min.js"></script>

<section class="container-fluid">
<div class="main-div">
<div class=" admin-dashboard">
<div class="row">	
<div class="col-sm-4 col-lg-7">
<h3 class="ml-4 mt-2">Agent Change</h3>
</div>
<div class="col-sm-8 col-lg-5">
<form action="" method="post" autocomplete="off" class="row mt-2">
	<div class="col-8 col-md-9">
	<input type="text" name="inputval" placeholder="Search By Ref Id Only" class="form-control" required>
	</div>
	<div  class="col-4 col-md-3">
	<input type="submit" name="srchClickbtn" class="btn btn-primary" value="Search">
	</div>
</form>
</div>

		<div class="col-12">
		
    <div class="table-responsive">
	<table class="table table-sm table-bordered" width="100%">
    <thead>	  
      <tr>	  
        <th>Stu. Name</th>
        <th>Ref. Id</th>				
        <th>Agent</th>						
        <th>To Agent</th>		
        		
      </tr>
    </thead>
    <tbody>	
	
	<?php
	if (isset($_GET['getsearch']) && $_GET['getsearch']!="") {
		$searchTerm = $_GET['getsearch'];
		$searchInput = "AND refid LIKE '%".$searchTerm."%'";
		$search_url = "&getsearch=".$searchTerm."";
	
		$rsltQuery = "SELECT * FROM st_application where flowdrp !='Drop' $searchInput";
		$qurySql = mysqli_query($con, $rsltQuery);	
		if($qurySql){
		while ($row_nm = mysqli_fetch_assoc($qurySql)){
		$sno = $row_nm['sno'];
		$agentid = $row_nm['user_id'];
		$studentname = $row_nm['fname'].' '.$row_nm['lname'];
		$agent_name = $row_nm['agent_name'];
		$refid = $row_nm['refid'];
		
		//$action1 = "<a href='javascript:void(0)' class='btn btn-sm btn-warning logFollow' data-target='#logFollowModel' data-toggle='modal' data-id='$sno'>Logs</a>";
		$upd_agent = "<a href='javascript:void(0)' class='btn btn-sm btn-warning updAgnt' data-target='#AgentUpdModal' data-toggle='modal' data-id='$sno'>Update Agent</a>";
		
	?>
	
	
		<tr>
			<td><?php echo $studentname; ?></td>
			<td><?php echo $refid;?></td>
			<td><?php echo $agent_name; ?></td>
			<td><?php echo $upd_agent; ?></td>
		</tr>
			
	<?php } ?>
    </tbody>	
	</table>  
	</div>
	</div>
		<?php }else{
			echo '<tr><td>NO Record Found</td></tr>';
		} 
	?>
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

<div class="modal-footer">
<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>
</div>
</div>
</div>



<div class="modal fade main-modal" id="AgentUpdModal" role="dialog">
<div class="modal-dialog modal-sm">
<div class="modal-content">
<div class="modal-header">
<h4 class="modal-title">Update Agent</h4>
<button type="button" class="close" data-dismiss="modal">&times;</button>
</div>
<div class="modal-body">
<div class="loading_icon"></div>

<form class=""  method="post" action=""  autocomplete="off" name="assign_register" id="assign_register" autocomplete="off">
	<div class="form-group ">                                   
		<select class="form-control" name="new_agentid" id="assign_iddds">
				<option value="">Select Agent</option>
				<?php
				 $getAgentsId = "SELECT sno,username FROM allusers where role='Agent' AND created_by_id!='' AND username !='$agent_name' order by username asc";
					$resultAgentsId = mysqli_query($con, $getAgentsId);	
					if(mysqli_num_rows($resultAgentsId)){
						while($resultAgentsRows = mysqli_fetch_assoc($resultAgentsId)){
							$userSno = $resultAgentsRows['sno'];
							$username = $resultAgentsRows['username'];
							echo '<option value ="'.$userSno.'">'.$username.'</option>';
						}
					}?>
			</select>							 
	</div>
	<div class="form-group">
		<textarea placeholder="Enter Remarks Here..." name="remarks" class="form-control remarks"></textarea>
	</div>
	<input type="hidden" name="application_id" id="application_id" value="">                                    
	<input type="hidden" name="agent_name" value="<?php echo $agent_name; ?>">                                    
	<input type="hidden" name="agentid" value="<?php echo $agentid; ?>">                                    
	 <center>
		<button type="submit" name="assign_submit" class="btn assin-button assign_submit" style=" float:right !important;">Assign</button>
	 </center>
	 </div>
	 </form>

</div>
</div>
</div>
</div>

<?php
}
	
	?>
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
<script>
$(document).on('click', '.updAgnt', function(){	
	var appid = $(this).attr('data-id');
	$('#application_id').val(appid);
});
</script>
<script>
   $(function(){
       $('.assign_submit').click(function(e) {  
      e.preventDefault();
      var $form = $(this).closest("#assign_register");
      var formData =  $form.serializeArray();
	    if($('#assign_iddds').val() == '') {
           alert('PLease select Agent');
           return false;
       }
	  if($('.remarks').val() == '') {
          alert('PLease enter Remark');
          return false;
      }
      var URL = "../mysqldb.php";
      $.post(URL, formData).done(function(data) {
        if(data == 00){
			alert("Something Went Wrong");
            return false;         
         } else {
			alert("Update Successfully");
			window.location.href = '../application/?aid=error_'+data+'';
			return false;
         }
       });
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
	header("Location: ../../login");
    exit();
}
?>  
