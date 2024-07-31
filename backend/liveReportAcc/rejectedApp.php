<?php
ob_start();
include("../../db.php");
include("../../header_navbar.php");

if (isset($_GET['page_no']) && $_GET['page_no']!="") {
	$page_no = $_GET['page_no'];
} else {
	$page_no = 1;
}

$inputSearch = '';
$get_aid = '';
$srch_status_name = '';

if(($email2323 == 'admin@acc.com') || ($email2323 == 'acc_admin')){
if(isset($_GET['getsearch'])){
	$getsearch4 = $_GET['getsearch'];
}else{
	$getsearch4 = '';
}

if(isset($_POST['srchClickbtn'])){
	$search = $_POST['search'];
	header("Location: ../liveReportGrn/rejectedApp.php?srchstatus=&page_no=1&getsearch=$search&agentid=");
}

if(isset($_GET['srchstatus']) || isset($_GET['getsearch']) || isset($_GET['agentid'])){

$getsearch2 = '';
$orederby = 'ORDER BY last_updated_at DESC';

/////////////
if(isset($_GET['getsearch']) && !empty($_GET['getsearch'])){
	$getsearch2 = $_GET['getsearch'];
	$inputSearch = "AND (CONCAT(fname,  ' ', lname) LIKE '%$getsearch2%' OR refid LIKE '%$getsearch2%' OR passport_no LIKE '%$getsearch2%')";
	$orederby = 'ORDER BY last_updated_at DESC';
}
	
}else{
	$orederby = 'ORDER BY last_updated_at DESC';
	$getsearch2 = '';
	$inputSearch = '';
}

$total_records_per_page = 70;
$offset = ($page_no-1) * $total_records_per_page;
$previous_page = $page_no - 1;
$next_page = $page_no + 1;
$adjacents = "2";

$getCrntDate = date('Y-m-d');

$result3 = "SELECT COUNT(*) As total_records FROM st_application where admin_status_crs!='' AND admin_status_crs!='Yes' AND flowdrp!='Drop' $inputSearch";
// print_r($result3);

$result2 = mysqli_query($con, $result3);
$total_records = mysqli_fetch_array($result2);
$total_records = $total_records['total_records'];
$total_no_of_pages = ceil($total_records / $total_records_per_page);
$second_last = $total_no_of_pages - 1; // total page minus 1
?> 
<section>
<div class="main-div">
<div class="col-lg-12">
<div class=" admin-dashboard">
<div class="row">	

<div class="col-sm-6 col-lg-6 col-xl-6">
<h3 class="mb-0 mt-2">Rejected & Not Eligible Applications</h3>
</div>

<div class="col-sm-6 col-lg-4 col-xl-4">
<form action="" method="post" autocomplete="off" class=" mt-2">
	<div class="input-group">
	<input type="text" name="search" placeholder="Search By Student Name, Refid &amp; Passport No." class="form-control form-control-sm" required>
	
	<div  class="input-group-append">
	<input type="submit" name="srchClickbtn" class="btn btn-success btn-sm" value="Search">
	</div>
	</div>
</form>
</div>

<div class="col-lg-2 col-xl-2 mt-2">
<a class="btn btn-sm btn-success float-right " href="../liveReportGrn/rejectedAppExcel.php?getsearch=<?php echo $getsearch4; ?>">Excel Download</a>
</div>

</div>
	<div class="row mt-4"> 
		<div class="col-12">
		
    <div class="table-responsive">
	<table class="table table-bordered" width="100%">
    <thead>	  
      <tr>	  
        <th>Student<br>Name</th>
        <th>Agent<br>Name</th>
        <th>Ref<br>Id</th>
        <th>Passport<br>No.</th>
        <th>Created<br>On</th>
        <th>Application<br>Status</th>
        <th>Application<br>Remarks</th>		
      </tr>
    </thead>
    <tbody>
	<?php
	$result4 = "SELECT * FROM st_application where admin_status_crs!='' AND admin_status_crs!='Yes' AND flowdrp!='Drop' $inputSearch $orederby LIMIT $offset, $total_records_per_page";

	// print_r($result4);
	$result5 = mysqli_query($con, $result4);
	if(mysqli_num_rows($result5)){

	while ($row = mysqli_fetch_assoc($result5)) {
		$snoall = mysqli_real_escape_string($con, $row['sno']);
		$user_id = mysqli_real_escape_string($con, $row['user_id']);
		$refid = mysqli_real_escape_string($con, $row['refid']);
		$student_id = mysqli_real_escape_string($con, $row['student_id']);
		$fname = mysqli_real_escape_string($con, $row['fname']);			
		$lname = mysqli_real_escape_string($con, $row['lname']);
		$passport_no = mysqli_real_escape_string($con, $row['passport_no']);
		$dob = mysqli_real_escape_string($con, $row['dob']);
		$date_at = mysqli_real_escape_string($con, $row['datetime']);
		$admin_status_crs = mysqli_real_escape_string($con, $row['admin_status_crs']);
		$admin_remark_crs = mysqli_real_escape_string($con, $row['admin_remark_crs']);

		$agnt_qry = mysqli_query($con,"SELECT username FROM allusers where sno='$user_id'");
		$row_agnt_qry = mysqli_fetch_assoc($agnt_qry);
		$agntname = mysqli_real_escape_string($con, $row_agnt_qry['username']);
	?>
      <tr class="error_<?php echo $snoall;?>">
		<td style="white-space: nowrap;">
			<?php echo $fname.' '.$lname;?><br><?php echo $dob; ?>
		</td>
		<td><?php echo $agntname; ?></td>
		<td><?php echo $refid; ?></td>
		<td><?php echo $passport_no; ?></td>
		<td><?php echo $date_at; ?></td>		
		<td><?php echo $admin_status_crs; ?></td>		
		<td><?php echo $admin_remark_crs; ?></td>		
      </tr>	  
	    
	<?php } 
	}else{
		echo '<tr><td colspan="7" class="text-center">Not Found</td></tr>';
	}?>
    </tbody>
	</table>  
	</div>

<div class="row">
<div class="col-md-8 mt-2 pl-3">
	<strong>Total Records <?php echo $total_records; ?>, </strong>
	<strong>Page <?php echo $page_no." of ".$total_no_of_pages; ?></strong>
</div>
<div class="col-md-4 mt-2">
<nav aria-label="Page navigation example">
<ul class="pagination justify-content-end"> 
	<li <?php if($page_no <= 1){ echo "class='page-item disabled'"; } ?>>
	<a <?php if($page_no > 1){ echo "href='?page_no=$previous_page&srchstatus=$srch_status_name&getsearch=$getsearch2&agentid=$get_aid'"; } ?> class="page-link"><i class="fas fa-angle-double-left"></i></a>
	</li>       

    <?php 
	if ($total_no_of_pages <= 10){
		for ($counter = 1; $counter <= $total_no_of_pages; $counter++){
			if ($counter == $page_no) {
				echo "<li class='page-item active'><a class='page-link'>$counter</a></li>";
			}else{
				echo "<li class='page-item'><a href='?page_no=$counter&srchstatus=$srch_status_name&getsearch=$getsearch2&agentid=$get_aid' class='page-link'>$counter</a></li>";
			}
        }
	}

	elseif($total_no_of_pages > 10){	

	if($page_no <= 4) {
	 for ($counter = 1; $counter < 8; $counter++){
			if ($counter == $page_no) {
				echo "<li class='page-item active'><a class='page-link'>$counter</a></li>";	
			}else{
				echo "<li class='page-item'><a href='?page_no=$counter&srchstatus=$srch_status_name&getsearch=$getsearch2&agentid=$get_aid' class='page-link'>$counter</a></li>";
			}
        }

		echo "<li class='page-item'><a class='page-link'>...</a></li>";

		echo "<li class='page-item'><a href='?page_no=$second_last&srchstatus=$srch_status_name&getsearch=$getsearch2&agentid=$get_aid' class='page-link'>$second_last</a></li>";

		echo "<li class='page-item'><a href='?page_no=$total_no_of_pages&srchstatus=$srch_status_name&getsearch=$getsearch2&agentid=$get_aid' class='page-link'>$total_no_of_pages</a></li>";

		}



	 elseif($page_no > 4 && $page_no < $total_no_of_pages - 4) {		 

		echo "<li class='page-item'><a href='?page_no=1&srchstatus=$srch_status_name&getsearch=$getsearch2&agentid=$get_aid' class='page-link'>1</a></li>";

		echo "<li class='page-item'><a href='?page_no=2&srchstatus=$srch_status_name&getsearch=$getsearch2&agentid=$get_aid' class='page-link'>2</a></li>";

        echo "<li class='page-item'><a class='page-link'>...</a></li>";

        for ($counter = $page_no - $adjacents; $counter <= $page_no + $adjacents; $counter++) {			

           if ($counter == $page_no) {

		   echo "<li class='page-item active'><a class='page-link'>$counter</a></li>";	

				}else{

           echo "<li class='page-item'><a href='?page_no=$counter&srchstatus=$srch_status_name&getsearch=$getsearch2&agentid=$get_aid' class='page-link'>$counter</a></li>";

				}                  

       }

       echo "<li class='page-item'><a class='page-link'>...</a></li>";

	   echo "<li class='page-item'><a href='?page_no=$second_last&srchstatus=$srch_status_name&getsearch=$getsearch2&agentid=$get_aid' class='page-link'>$second_last</a></li>";

	   echo "<li class='page-item'><a href='?page_no=$total_no_of_pages&srchstatus=$srch_status_name&getsearch=$getsearch2&agentid=$get_aid' class='page-link'>$total_no_of_pages</a></li>";      

            }

		

		else {

        echo "<li class='page-item'><a href='?page_no=1&srchstatus=$srch_status_name&getsearch=$getsearch2&agentid=$get_aid' class='page-link'>1</a></li>";

		echo "<li class='page-item'><a href='?page_no=2&srchstatus=$srch_status_name&getsearch=$getsearch2&agentid=$get_aid' class='page-link'>2</a></li>";

        echo "<li class='page-item'><a class='page-link'>...</a></li>";



        for ($counter = $total_no_of_pages - 6; $counter <= $total_no_of_pages; $counter++) {

          if ($counter == $page_no) {

		   echo "<li class='page-item active'><a class='page-link'>$counter</a></li>";	

				}else{

           echo "<li class='page-item'><a href='?page_no=$counter&srchstatus=$srch_status_name&getsearch=$getsearch2&agentid=$get_aid' class='page-link'>$counter</a></li>";

				}                   

                }

        }
	}
?>
	<li <?php if($page_no >= $total_no_of_pages){ echo "class='page-item disabled'"; } ?>>
	<a <?php if($page_no < $total_no_of_pages) { echo "href='?page_no=$next_page&srchstatus=$srch_status_name&getsearch=$getsearch2&agentid=$get_aid'"; } ?> class='page-link'><i class="fas fa-angle-double-right"></i></a>
	</li>
    <?php if($page_no < $total_no_of_pages){
		echo "<li class='page-item'><a href='?page_no=$total_no_of_pages&srchstatus=$srch_status_name&getsearch=$getsearch2&agentid=$get_aid' class='page-link'>Last &rsaquo;&rsaquo;</a></li>";
		}
	?>
</ul>
</nav>
</div>
</div>

</div>
</div>
</div>
</div>
</div>
</section>

<?php 
include("../../footer.php");

}else{
	header("Location: ../../login");
    exit();
}
?>  
