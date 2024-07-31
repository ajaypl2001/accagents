<?php
ob_start();
include("../../db.php");
include("../../header_navbar.php");

if(isset($_POST['srchClickbtn'])){
	$search = $_POST['inputval'];
	header("Location: ../collegeStart/processed.php?getsearch=$search&page_no=1");
}

if (isset($_GET['getsearch']) && $_GET['getsearch']!="") {
	$searchTerm = $_GET['getsearch'];
	$searchInput = "AND (student_name LIKE '%".$searchTerm."%' OR refid LIKE '%".$searchTerm."%' OR passport_no LIKE '%".$searchTerm."%' OR student_id LIKE '%".$searchTerm."%')";
	$search_url = "&getsearch=".$searchTerm."";
} else {
	$searchInput = '';
	$search_url = '';
	$searchTerm = '';
}

if (isset($_GET['page_no']) && $_GET['page_no']!="") {
	$page_no = $_GET['page_no'];
} else {
	$page_no = 1;
}

$total_records_per_page = 90;
$offset = ($page_no-1) * $total_records_per_page;
$previous_page = $page_no - 1;
$next_page = $page_no + 1;
$adjacents = "2";
$result_count = mysqli_query($con, "SELECT COUNT(*) As total_records FROM `start_college` where with_dism!='' AND app_id!='' $searchInput");
$total_records = mysqli_fetch_array($result_count);
$total_records = $total_records['total_records'];
$total_no_of_pages = ceil($total_records / $total_records_per_page);
$second_last = $total_no_of_pages - 1;

$rsltQuery = "SELECT * FROM start_college where with_dism!='' AND app_id!='' $searchInput order by sno DESC LIMIT $offset, $total_records_per_page";
?> 
<link rel="stylesheet" href="../../css/sweetalert.min.css">
<script src="../../js/sweetalert.min.js"></script>
<style>
.error_color{border:2px solid #de0e0e;}
.validError{border:2px solid #ccc;}
</style>
<section class="container-fluid">
<div class="main-div">
<div class="admin-dashboard">
<div class="row">

<div class="col-sm-4 col-lg-4 mb-3">
<h3 class="m-0">Dashboard Student Status</h3>
</div>

<div class="col-sm-3 col-lg-3 mb-3">
<form method="POST" action="excelSheet.php" autocomplete="off">
	<input type="hidden" name="role" value="<?php echo 'Dashboard_Std_Status'; ?>">
	<input type="hidden" name="keywordLists" value="<?php echo $searchTerm; ?>">
	<button type="submit" name="studentlist" class="btn btn-sm btn-success float-right" >Download Excel</button>
</form>
</div>

<div class="col-sm-5 col-lg-5 mb-3">
<form action="" method="post" autocomplete="off">
	<div class="input-group">
		<input type="text" name="inputval" placeholder="Search By Stu. Name or Ref Id" class="form-control form-control-sm" required>
		<div class="input-group-append">
			<input type="submit" name="srchClickbtn" class="btn btn-sm btn-success" value="Search">
		</div>
	</div>
</form>
</div>

<div class="col-12">			
    <div class="table-responsive">
	<table class="table table-sm table-bordered" width="100%">
    <thead>	  
      <tr>
        <th>Student Name</th>
        <th>Std Id</th>
        <th>Passport</th>
        <th>In/W/D</th>	
        <th>Refund Type</th>	
        <th>Updated On</th>	
        <th>Updated By</th>	
        <th>Logs</th>	
      </tr>
    </thead>
    <tbody>	
	<?php
	$qurySql = mysqli_query($con, $rsltQuery);
	if(mysqli_num_rows($qurySql)){
		while ($row_nm = mysqli_fetch_assoc($qurySql)){
		$snoid = $row_nm['sno'];
		$app_id = $row_nm['app_id'];
		$student_name = $row_nm['student_name'];
		$refid = $row_nm['refid'];
		$student_id = $row_nm['student_id'];
		$passport_no = $row_nm['passport_no'];
		$with_dism = $row_nm['with_dism'];			
		$refund_rp = $row_nm['refund_rp'];		
		$datetime_at = $row_nm['datetime_at'];		
		$in_w_d = $row_nm['in_w_d'];		
	?>
	<tr>
		<td><?php echo $student_name; ?></td>
		<td><?php echo $student_id; ?></td>		
		<td><?php echo $passport_no; ?></td>
		<td><?php echo $with_dism; ?></td>			
		<td><?php echo $refund_rp; ?></td>			
		<td><?php echo $datetime_at; ?></td>
		<td><?php echo $in_w_d; ?></td>
		<td>
		<span class="btn btn-sm btn-info allClass" data-toggle="modal" data-target="#allModel" data-id="<?php echo $app_id; ?>" data-name="<?php echo $student_name; ?>">Logs</span>
		</td>
	</tr>			
	<?php }
	}else{
		echo '<tr><td colspan="9"><center>Not Found!!!</center></td></tr>';
	}
	?>
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

<div class="modal fade" id="allModel">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">	  
	  <div class="modal-header">
        <h4 class="modal-title"><span class="stNameLogs"></span></h4>
		<button type="button" class="close" data-dismiss="modal">×</button>
      </div>	  
	  <div class="loading_icon"></div>
      <div class="modal-body">
	  <div class="table-responsive">
		<table class="table table-bordered table-sm table-striped table-hover">
	<thead>
	<tr>
	<th>Sno.</th>
	<th>In/W/D</th>	
	<th>Inprogress Status</th>	
	<th>Refund Type</th>
	<th>Refund Processed</th>
	<th>Refund Amount</th>
	<th>Followup Status</th>
	<th>Followup Date</th>
	<th>Remarks</th>
	<th>Updated On</th>
	<th>Updated By</th>
	</tr>
	</thead>
	<tbody class="getAllLogsDiv">
	</tbody>
	</table>
      </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
$(document).on('click', '.allClass', function(){
	var idmodel = $(this).attr('data-id');
	var getHeadVal = $(this).attr('data-name');
	$('.stNameLogs').html(getHeadVal);
	$('.loading_icon').show();	
	$.post("../responseStart.php?tag=getAllLogs",{"idno":idmodel},function(il){
		$('.getAllLogsDiv').html("");
		if(il==''){
			$('.getAllLogsDiv').html("<tr><td colspan='10'><center>Not Found</center></td></tr>");
		}else{
		 for (i in il){
			$('<tr>' + 
			'<td>'+il[i].idLogs+'</td>'+
			'<td>'+il[i].with_dismLogs+'</td>'+
			'<td style="white-space: nowrap;">'+il[i].inpStLogs+'</td>'+
			'<td>'+il[i].refund_rpLogs+'</td>'+
			'<td>'+il[i].rproccessLogs+'</td>'+
			'<td>'+il[i].yesp_amountLogs+'</td>'+			
			'<td>'+il[i].followup_statusLogs+'</td>'+
			'<td>'+il[i].follow_dateLogs+'</td>'+
			'<td>'+il[i].remarksLogs+'</td>'+
			'<td>'+il[i].updateLogs+'</td>'+
			'<td>'+il[i].in_w_dLogs+'</td>'+
			'</tr>').appendTo(".getAllLogsDiv");
		}
		}		
		$('.loading_icon').hide();	
	});	
});	
</script>

<?php 
include("../../footer.php");
?>