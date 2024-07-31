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
	header("Location: drop.php?getsearch=$search&page_no=1");
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
		
		$agent_id_not_show = "AND (user_id IN ($agent_id_not_show2) OR (app_show='$viewName'))";	
	}else{
		$agent_id_not_show = "AND (user_id IN (NULL) OR (app_show='$viewName'))";
	}
}else{
	$agent_id_not_show = '';
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
<h3 class="ml-4 mt-2">Drop</h3>
</div>
<div class="col-sm-8 col-lg-5">
<form action="" method="post" autocomplete="off" class="row mt-2">
	<div class="col-8 col-md-9">
	<input type="text" name="inputval" placeholder="Search By Stu. Name or Ref Id" class="form-control" required>
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
        <th>Update By(Name)</th>
        <th>Stu. Name</th>
        <th>Ref. Id</th>		
        <th>Status</th>	
        <th>Stage</th>		
        <th>Remarks</th>		
        <th>Created</th>		
        <th>Action</th>		
      </tr>
    </thead>
    <tbody class="list_follow">	
	<?php
	if (isset($_GET['getsearch']) && $_GET['getsearch']!="") {
		$searchTerm = $_GET['getsearch'];
		$searchInput = "AND (CONCAT(fname,  ' ', lname) LIKE '%".$searchTerm."%' OR refid LIKE '%".$searchTerm."%')";
		$search_url = "&getsearch=".$searchTerm."";
	} else {
		$searchInput = '';
		$search_url = '';
	}

	if (isset($_GET['page_no']) && $_GET['page_no']!="") {
		$page_no = $_GET['page_no'];
	} else {
		$page_no = 1;
    }

    $total_records_per_page = 30;
    $offset = ($page_no-1) * $total_records_per_page;
	$previous_page = $page_no - 1;
	$next_page = $page_no + 1;
	$adjacents = "2"; 

	$result_count = mysqli_query($con, "SELECT COUNT(*) As total_records FROM `st_application` where flowdrp='Drop' $agent_id_not_show $searchInput");
	$total_records = mysqli_fetch_array($result_count);
	$total_records = $total_records['total_records'];
    $total_no_of_pages = ceil($total_records / $total_records_per_page);
	$second_last = $total_no_of_pages - 1; // total page minus 1


	$rsltQuery = "SELECT * FROM st_application where flowdrp='Drop' $agent_id_not_show $searchInput LIMIT $offset, $total_records_per_page";
		$qurySql = mysqli_query($con, $rsltQuery);	
		while ($row_nm = mysqli_fetch_assoc($qurySql)){
		$sno = $row_nm['sno'];
		$refid = $row_nm['refid'];
		
		$action = "<a href='../application?getsearch=$refid' class='btn btn-sm btn-success' title='View Profile'><i class='fa fa-eye'></i></a>";
		$action1 = "<a href='javascript:void(0)' class='btn btn-sm btn-warning logFollow' data-target='#logFollowModel' data-toggle='modal' data-id='$sno'>Logs</a>";
		
		$studentname1 = $row_nm['fname'].' '.$row_nm['lname'];
		$studentname = "<a href='../followup/add.php?stusno=$sno' target='_blank'>$studentname1</a>";
		
		
		$follow_name = $row_nm['follow_name'];	
		$follow_stage_1 = $row_nm['follow_stage'];
		if($follow_stage_1 == 'FH_Sent'){
			$follow_stage = 'F@H';
		}else{
			$follow_stage = $follow_stage_1;
		}
		$follow_fremarks = $row_nm['follow_fremarks'];
		$follow_created = $row_nm['follow_created'];
		$flowdrp = $row_nm['flowdrp'];
	?>
		<tr>
			<td><?php echo $follow_name; ?></td>
			<td><?php echo $studentname; ?></td>
			<td>
			<a href="javascript:void(0)" class="dropClass" data-toggle="modal" data-target="#dropModel" data-id="<?php echo $sno; ?>"><?php echo $refid;?></a>
			</td>
			<td><?php echo $flowdrp; ?></td>
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
	

<div class="col-md-8 mt-2 pl-3">
	<strong>Total Records <?php echo $total_records; ?>, </strong>
	<strong>Page <?php echo $page_no." of ".$total_no_of_pages; ?></strong>
</div>

<div class="col-md-4 mt-2">
<nav aria-label="Page navigation example">
<ul class="pagination justify-content-end">  
	<?php // if($page_no > 1){ echo "<li><a href='?page_no=1'>First Page</a></li>"; } ?>
    
	<li <?php if($page_no <= 1){ echo "class='page-item disabled'"; } ?>>
	<a <?php if($page_no > 1){ echo "href='?page_no=$previous_page&getsearch=$search_url'"; } ?> class='page-link'>Previous</a>
	</li>
       
    <?php 
	if ($total_no_of_pages <= 10){  	 
		for ($counter = 1; $counter <= $total_no_of_pages; $counter++){
			if ($counter == $page_no) {
		   echo "<li class='page-item active'><a class='page-link'>$counter</a></li>";	
				}else{
           echo "<li class='page-item'><a href='?page_no=$counter&getsearch=$search_url' class='page-link'>$counter</a></li>";
				}
        }
	}
	elseif($total_no_of_pages > 10){
		
	if($page_no <= 4) {			
	 for ($counter = 1; $counter < 8; $counter++){		 
			if ($counter == $page_no) {
		   echo "<li class='page-item active'><a class='page-link'>$counter</a></li>";	
				}else{
           echo "<li class='page-item'><a href='?page_no=$counter&getsearch=$search_url' class='page-link'>$counter</a></li>";
				}
        }
		echo "<li><a>...</a></li>";
		echo "<li><a href='?page_no=$second_last&getsearch=$search_url' class='page-link'>$second_last</a></li>";
		echo "<li><a href='?page_no=$total_no_of_pages&getsearch=$search_url' class='page-link'>$total_no_of_pages</a></li>";
		}

	 elseif($page_no > 4 && $page_no < $total_no_of_pages - 4) {		 
		echo "<li class='page-item'><a href='?page_no=1&getsearch=$search_url' class='page-link'>1</a></li>";
		echo "<li class='page-item'><a href='?page_no=2&getsearch=$search_url' class='page-link'>2</a></li>";
        echo "<li class='page-item'><a class='page-link'>...</a></li>";
        for ($counter = $page_no - $adjacents; $counter <= $page_no + $adjacents; $counter++) {			
           if ($counter == $page_no) {
		   echo "<li class='page-item active'><a class='page-link'>$counter</a></li>";	
				}else{
           echo "<li class='page-item'><a href='?page_no=$counter&getsearch=$search_url' class='page-link'>$counter</a></li>";
				}                  
       }
       echo "<li class='page-item'><a class='page-link'>...</a></li>";
	   echo "<li class='page-item'><a href='?page_no=$second_last&getsearch=$search_url' class='page-link'>$second_last</a></li>";
	   echo "<li class='page-item'><a href='?page_no=$total_no_of_pages&getsearch=$search_url' class='page-link'>$total_no_of_pages</a></li>";      
            }
		
		else {
        echo "<li class='page-item'><a href='?page_no=1&getsearch=$search_url' class='page-link'>1</a></li>";
		echo "<li class='page-item'><a href='?page_no=2&getsearch=$search_url' class='page-link'>2</a></li>";
        echo "<li class='page-item'><a class='page-link'>...</a></li>";

        for ($counter = $total_no_of_pages - 6; $counter <= $total_no_of_pages; $counter++) {
          if ($counter == $page_no) {
		   echo "<li class='page-item active'><a class='page-link'>$counter</a></li>";	
				}else{
           echo "<li class='page-item'><a href='?page_no=$counter&getsearch=$search_url' class='page-link'>$counter</a></li>";
				}                   
                }
            }
	}
?>
    
	<li <?php if($page_no >= $total_no_of_pages){ echo "class='page-item disabled'"; } ?>>
	<a <?php if($page_no < $total_no_of_pages) { echo "href='?page_no=$next_page&getsearch=$search_url'"; } ?> class='page-link'>Next</a>
	</li>
    <?php if($page_no < $total_no_of_pages){
		echo "<li class='page-item'><a href='?page_no=$total_no_of_pages&getsearch=$search_url' class='page-link'>Last &rsaquo;&rsaquo;</a></li>";
		} ?>
</ul>
</nav>
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

<div class="modal fade" id="dropModel" role="dialog">
<div class="modal-dialog modal-sm">
<div class="modal-content">
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal">&times;</button>
</div>
<div class="modal-body">
<div class="dropstatus"></div>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div></div>
</div>
</div>

<script>
$(document).on('click', '.dropClass', function(){
	var idmodel = $(this).attr('data-id'); 
	$('.loading_icon').show();
	$.post("../response.php?tag=getDropstatus",{"idno":idmodel},function(d){
		$('.dropstatus').html("");
		$('<div>' +
		'' + d[0].dropform + '' +		
		'</div>').appendTo(".dropstatus");
		$('.loading_icon').hide();
		
	$('.dropreactive').on('click', function(){
	var status = $(this).attr('idno');
    var message = "You want to change the status";
        if(status){
            var updateMessage = "Activated";
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
		var url = '../response.php?tag=reactiveStatus';
		$.ajax({
			type: "POST",
			url: url,
			data:'idno='+status, 
			success :  function(data){			   
			if(data == 1){
				swal("Updated!", "" + updateMessage +" successfully", "success");   
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
