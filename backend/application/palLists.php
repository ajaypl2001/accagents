<?php
ob_start();
include("../../db.php");
include("../../header_navbar.php");

if(!isset($_SESSION['sno'])){
    header("Location: ../../login");
    exit(); 
}
?>
<style>
a.btnpdf {
    float: right;
    top: 20px; right:80px;
    position:fixed;
    padding: 4px 7px;
    background: #337AB7;
    color: #fff;
    margin-right: 10px;
}
.paybtn {margin-top: 5px;}
.alertdiv {margin-top: 2%;}
.error_color{border:1px solid #de0e0e;}
.validError{border:1px solid #ccc;}
span.btn.btn-warning.btn-sm.loaRqst {width: 82%;color: #fff;}
</style>
<link rel="stylesheet" href="../css/sweetalert.min.css">
<script src="../js/sweetalert.min.js"></script>

<?php
$sessionid = $_SESSION['sno'];

if (isset($_GET['page_no']) && $_GET['page_no']!="") {
	$page_no = $_GET['page_no'];
} else {
	$page_no = 1;
}

$total_records_per_page = 40;
$offset = ($page_no-1) * $total_records_per_page;
$previous_page = $page_no - 1;
$next_page = $page_no + 1;
$adjacents = "2"; 

$result_count1 = "SELECT COUNT(*) As total_records FROM st_application where application_form='1' and pal_status='1'";

// echo $result_count1;
$result_count = mysqli_query($con, $result_count1);
$total_records = mysqli_fetch_array($result_count);
$total_records = $total_records['total_records'];
$total_no_of_pages = ceil($total_records / $total_records_per_page);
$second_last = $total_no_of_pages - 1; // total page minus 1
?>

<div class="main-div container-fluid">
	<div class="row justify-content-between">
<div class="col-lg-6 col-12">
<h3>Student Provincial Attestation Letter(PAL) Lists</h3>
</div>
<form class="float-right" action="ApplicationExcelDownload.php" method="post">
<input type="hidden" name="pal_status" value="PALDiv">
		<button type="submit" name="submit" class="btn btn-success btn-sm float-right mt-sm-1 mr-3">Excel Download</button>
	</form>
<div class="container-fluid vertical_tab">  
  <div class="row">  
<div class="col-xs-12 col-sm-12 col-md-12">	
<div class="tab-content">
<div id="Personal-Details">
 
<div class="col-sm-12">
	<div class="row">
    <div class="table-responsive">
	<table class="table table-bordered">
    <thead>
      <tr>
        <th>Agent Name</th>
        <th>Student Name</th>
        <th>Ref Id</th>
        <th>Stu Id</th>
        <th>Program</th>
        <th>Intake</th>
		<th>LOA Type/F@H</th>
        <th>Main Status</th>
        <th>PAL File</th>
        <th>PAL No.</th>
        <th>Issue Date</th>
        <th>Expiry Date</th>
        <th>Updated Name</th>
        <th>Updated On</th>
      </tr>
    </thead>
    <tbody>
	<?php
	$qryStr = "SELECT * FROM st_application where application_form='1' and pal_status='1' LIMIT $offset, $total_records_per_page";
	// echo $qryStr;
	$result = mysqli_query($con, $qryStr);	
	while($row = mysqli_fetch_assoc($result)){
	 $insertid = mysqli_real_escape_string($con, $row['sno']);
	 $agent_type = mysqli_real_escape_string($con, $row['agent_type']);
	 $app_by = mysqli_real_escape_string($con, $row['app_by']);
	 $user_id1 = mysqli_real_escape_string($con, $row['user_id']);
	 $fname = mysqli_real_escape_string($con, $row['fname']);
	 $lname = mysqli_real_escape_string($con, $row['lname']);
	 $refid = mysqli_real_escape_string($con, $row['refid']);
	 $student_id = mysqli_real_escape_string($con, $row['student_id']);
	 if(!empty($student_id)){
		$student_id2 = $student_id; 
	 }else{
		$student_id2 = 'N/A'; 
	 }
	 $dob = mysqli_real_escape_string($con, $row['dob']);
	 $dob_1 = date("F j, Y", strtotime($dob));	 
	 $prg_name1 = mysqli_real_escape_string($con, $row['prg_name1']);
	 $prg_intake = mysqli_real_escape_string($con, $row['prg_intake']);	 
	 $ol_processing = preg_replace('/\s+/', ' ',$row['ol_processing']);
	 if(!empty($ol_processing)){
		 if(!empty($row['ol_type'])){
			 $ol_type = preg_replace('/\s+/', ' ',$row['ol_type']);
		 }else{
			 $ol_type = 'First-Time';
		 }
	 }else{
		 $ol_type = '';
	 }
	  $v_g_r_status = $row['v_g_r_status'];
	  $fh_status = $row['fh_status'];
	  if($fh_status == '1'){
		 $FH2 = 'F@H';
	 }else{
		 $FH2 = '';
	 }
	$agnt_qry = mysqli_query($con,"SELECT username FROM allusers where sno='$user_id1'");
	$row_agnt_qry = mysqli_fetch_assoc($agnt_qry);
	$agntname = mysqli_real_escape_string($con, $row_agnt_qry['username']);

	$qry2 = mysqli_query($con, "SELECT * FROM `pal_apply` where `app_id`='$insertid'");
	if(mysqli_num_rows($qry2)){
		$uid2 = mysqli_fetch_assoc($qry2);
		$pal_letter2 = $uid2['pal_letter'];
		$pal_no = $uid2['pal_no'];
		$issue_date = $uid2['issue_date'];
		$expiry_date = $uid2['expiry_date'];
		$updated_name = $uid2['updated_name'];
		$updated_datetime = $uid2['updated_datetime'];
		$pal_letter = '<a href="../backend/PALFiles/'.$pal_letter2.'" download>Download PAL File</a>';
	}else{
		$pal_letter = 'N/F';
		$pal_no = 'N/F';
		$issue_date = '';
		$expiry_date = '';
		$updated_name = '';
		$updated_datetime = '';
	}
	?>
      <tr>
        <td><?php echo $agntname;?></td>
        <td><?php echo $fname.' '.$lname;?></td>
        <td><?php echo $refid;?></td>
        <td><?php echo $student_id2;?></td>
        <td><?php echo $prg_intake;?></td>
        <td><?php echo $prg_name1;?></td>	
		<td><?php echo $ol_type.'/ <br>'.$FH2;?></td>		
        <td><?php echo $v_g_r_status;?></td>		
        <td><?php echo $pal_letter;?></td>		
        <td><?php echo $pal_no;?></td>		
        <td><?php echo $issue_date;?></td>		
        <td><?php echo $expiry_date;?></td>	
        <td><?php echo $updated_name;?></td>	
        <td><?php echo $updated_datetime;?></td>	
      </tr>
	<?php } ?>
    </tbody>
	</table>			
	</div>

<div class="col-md-8 mt-2 pl-3">
	<strong>Total Records <?php echo $total_records; ?>, </strong>
	<strong>Page <?php echo $page_no." of ".$total_no_of_pages; ?></strong>
</div>

<div class="col-md-4 mt-2">
<nav aria-label="Page navigation example">
<ul class="pagination justify-content-end">    
	<li <?php if($page_no <= 1){ echo "class='page-item disabled'"; } ?>>
	<a <?php if($page_no > 1){ echo "href='?page_no=$previous_page'"; } ?> class="page-link">Previous</a>
	</li>
       
    <?php 
	if ($total_no_of_pages <= 10){  	 
		for ($counter = 1; $counter <= $total_no_of_pages; $counter++){
			if ($counter == $page_no) {
		   echo "<li class='page-item active'><a class='page-link'>$counter</a></li>";	
				}else{
           echo "<li class='page-item'><a href='?page_no=$counter' class='page-link'>$counter</a></li>";
				}
        }
	}
	elseif($total_no_of_pages > 10){
		
	if($page_no <= 4) {			
	 for ($counter = 1; $counter < 8; $counter++){		 
			if ($counter == $page_no) {
		   echo "<li class='page-item active'><a class='page-link'>$counter</a></li>";	
				}else{
           echo "<li class='page-item'><a href='?page_no=$counter' class='page-link'>$counter</a></li>";
				}
        }
		echo "<li class='page-item'><a class='page-link'>...</a></li>";
		echo "<li class='page-item'><a href='?page_no=$second_last' class='page-link'>$second_last</a></li>";
		echo "<li class='page-item'><a href='?page_no=$total_no_of_pages' class='page-link'>$total_no_of_pages</a></li>";
		}

	 elseif($page_no > 4 && $page_no < $total_no_of_pages - 4) {		 
		echo "<li class='page-item'><a href='?page_no=1' class='page-link'>1</a></li>";
		echo "<li class='page-item'><a href='?page_no=2' class='page-link'>2</a></li>";
        echo "<li class='page-item'><a class='page-link'>...</a></li>";
        for ($counter = $page_no - $adjacents; $counter <= $page_no + $adjacents; $counter++) {			
           if ($counter == $page_no) {
		   echo "<li class='page-item active'><a class='page-link'>$counter</a></li>";	
				}else{
           echo "<li class='page-item'><a href='?page_no=$counter' class='page-link'>$counter</a></li>";
				}                  
       }
       echo "<li class='page-item'><a class='page-link'>...</a></li>";
	   echo "<li class='page-item'><a href='?page_no=$second_last' class='page-link'>$second_last</a></li>";
	   echo "<li class='page-item'><a href='?page_no=$total_no_of_pages' class='page-link'>$total_no_of_pages</a></li>";      
            }
		
		else {
        echo "<li class='page-item'><a href='?page_no=1' class='page-link'>1</a></li>";
		echo "<li class='page-item'><a href='?page_no=2' class='page-link'>2</a></li>";
        echo "<li class='page-item'><a class='page-link'>...</a></li>";

        for ($counter = $total_no_of_pages - 6; $counter <= $total_no_of_pages; $counter++) {
          if ($counter == $page_no) {
		   echo "<li class='page-item active'><a class='page-link'>$counter</a></li>";	
				}else{
           echo "<li class='page-item'><a href='?page_no=$counter' class='page-link'>$counter</a></li>";
				}                   
                }
            }
	}
?>
    
	<li <?php if($page_no >= $total_no_of_pages){ echo "class='page-item disabled'"; } ?>>
	<a <?php if($page_no < $total_no_of_pages) { echo "href='?page_no=$next_page'"; } ?> class='page-link'>Next</a>
	</li>
    <?php if($page_no < $total_no_of_pages){
		echo "<li class='page-item'><a href='?page_no=$total_no_of_pages' class='page-link'>Last &rsaquo;&rsaquo;</a></li>";
		} ?>
</ul>
</nav>
</div>
</div>

	</div>
	</div>
	</div>
   </div>
  </div>
 </div>
</div>
</div>
<script src="../../js/document.js"></script>
<?php
include("../../footer.php");
?>
