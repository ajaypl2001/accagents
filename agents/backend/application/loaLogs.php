<?php
ob_start();
include("../../db.php");
include("../../header_navbar.php");

if(empty($_SESSION['sno'])){
    header("Location: ../../logout.php");
    exit(); 
}

if(isset($_POST['srchClickbtn'])){
	$searchloa2 = $_POST['searchloa'];
	header("Location: loaLogs.php?searchloa=$searchloa2");	
}

if($roles1 == 'Admin' && $loa_allow == '1'){
?> 

section>
<div class="main-div container-fluid">
<div class=" admin-dashboard">
<div class="row">
<div class="col-lg-6 col-sm-12 col-12">
<h3 class="mt-0">LOA Latest Geneated Lists/Logs</h3>
</div>

<div class="col-lg-6 col-sm-12 col-12 search-col mb-2">
	<form method="post" class="row" action="" autocomplete="off"> 
	<div class="col-8 col-sm-9">
		<input type="text" id="searchbtn_btn" class="form-control searchbtn_btn ui-autocomplete-input" placeholder="Search by Student Name,Ref & Id, Passport Number" name="searchloa">		
	</div>
	<div class="col-4 col-sm-3">
		<input type="submit" name="srchClickbtn" class="btn btn-submit" value="Search">
	</div>
	</form>
</div>
	
	<div class="col-12">	
    <div class="table-responsive">
	<table class="table table-sm table-bordered" width="100%">
    <thead>	  
      <tr>
        <th>College<br>Name</th>
        <th>Agent<br>Name</th>
        <th>Student<br>Name</th>
        <th>Reference<br>Id</th>		
        <th>Passport<br>Number</th>		
        <th>First Date</th>		
        <th>Revised Date</th>		
        <th>Defer Date</th>		
        <th>LOA Last<br>Updated Date</th>		
        <th>Check<br>Logs</th>		
      </tr>
    </thead>
    <tbody class="list_follow">	 
	<?php
		$getCrntDate1 = '2021-01-13';
		$getCrntDate2 = date('Y-m-d');
		$getFilterToday = "AND loa_last_generated_datetime >= '$getCrntDate1 01:00:01' AND loa_last_generated_datetime <= '$getCrntDate2 23:59:59'";
		if(!empty($_GET['searchloa'])){
			$getsearch1 = $_GET['searchloa'];
			$srchbtnbtn = "AND (CONCAT(fname,  ' ', lname) LIKE '%$getsearch1%' OR refid LIKE '%$getsearch1%' OR student_id LIKE '%$getsearch1%' OR passport_no LIKE '%$getsearch1%')";
			$rsltQuery = "SELECT sno, user_id, fname, lname, refid, passport_no, campus, loa_last_generated_datetime, loa_first_generate_date, loa_revised_date, loa_defer_date FROM st_application where loa_last_generated_datetime!='' AND loa_file!='' $getFilterToday $srchbtnbtn";
		}else{
			$rsltQuery = "SELECT sno, user_id, fname, lname, refid, passport_no, campus, loa_last_generated_datetime, loa_first_generate_date, loa_revised_date, loa_defer_date FROM st_application where loa_last_generated_datetime!='' AND loa_file!='' $getFilterToday";
		}
		$qurySql = mysqli_query($con, $rsltQuery);	
		if(mysqli_num_rows($qurySql)){			
		while ($row_nm = mysqli_fetch_assoc($qurySql)){
		$sno = $row_nm['sno'];
		$user_id = $row_nm['user_id'];
		$rsltQuery2 = "SELECT username FROM allusers where sno='$user_id'";
		$qurySql2 = mysqli_query($con, $rsltQuery2);
		$row_nm2 = mysqli_fetch_assoc($qurySql2);		
		$agent_name = $row_nm2['username'];
		$fname = $row_nm['fname'];
		$lname = $row_nm['lname'];
		$refid = $row_nm['refid'];
		$passport_no = $row_nm['passport_no'];		
		$campus = $row_nm['campus'];		
		$loa_last_generated_datetime = $row_nm['loa_last_generated_datetime'];		
		$loa_first_generate_date = $row_nm['loa_first_generate_date'];		
		$loa_revised_date = $row_nm['loa_revised_date'];		
		$loa_defer_date = $row_nm['loa_defer_date'];		
	?>
		<tr>
			<td><?php echo $campus; ?></td>
			<td><?php echo $agent_name; ?></td>
			<td><?php echo $fname.' '.$lname; ?></td>
			<td><?php echo $refid; ?></td>
			<td><?php echo $passport_no; ?></td>
			<td><?php echo $loa_first_generate_date; ?></td>
			<td><?php echo $loa_revised_date; ?></td>
			<td><?php echo $loa_defer_date; ?></td>
			<td><?php echo $loa_last_generated_datetime; ?></td>
			<td>
				<span class="btn btn-sm btn-success btnLoaClass" data-toggle="modal" data-target="#myModalLogsLoa" data-id="<?php echo $sno; ?>">Logs</span>
			</td>
		</tr>			
		<?php } ?>
		<?php }else{ ?>
			<tr><td colspan="7">Not Found</td></tr>
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

<div class="modal-box">
	<div class="modal fade" id="myModalLogsLoa" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">	<h4 class="modal-title">LOA No. Of Geneated Logs</h4>
		<button type="button" class="close" data-dismiss="modal">&times;</button>
	</div>
			<div class="modal-body">
			
				<div class="loading_icon"></div>
				<div class="table-responsive">
				<table class="table table-sm table-striped table-bordered">
				<thead><tr><th>Campus</th><th>Intake</th><th>Loa Type</th><th>Updated On Datetime</th></tr></thead>
				<tbody class="logsLoaId">
				</tbody>
				</table>
			</div>
			</div>
		</div>
	</div>
	</div>
</div>

<script>
$(document).on('click', '.btnLoaClass', function(){	
	var id = $(this).attr('data-id');
	$('.loading_icon').show();
	$.post("../response.php?tag=getLoaLogs",{"idno":id},function(d){
		$('.logsLoaId').html("");
		for (i in d) {
			$('' +	d[i].getDivLogs + '').appendTo(".logsLoaId");
		}
	});
	$('.loading_icon').hide();
});
</script>

<?php 
include("../../footer.php");

}else{
	header("Location: ../../logout.php");
}
?>  
