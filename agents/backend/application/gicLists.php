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

$result_count1 = "SELECT COUNT(pal_apply.app_id) As total_records FROM pal_apply
INNER JOIN st_application
ON pal_apply.app_id = st_application.sno
WHERE pal_apply.gic_pr!=''";

// echo $result_count1;
$result_count = mysqli_query($con, $result_count1);
$total_records = mysqli_fetch_array($result_count);
$total_records = $total_records['total_records'];
$total_no_of_pages = ceil($total_records / $total_records_per_page);
$second_last = $total_no_of_pages - 1; // total page minus 1
?>

<section class="container-fluid">
<div class="main-div">
<div class=" admin-dashboard">
	<div class="row justify-content-between">
<div class="col-lg-6 col-12">
<h3 class="mt-0">Guaranteed Investment Certificate(GIC) Lists</h3>
</div>

<div class="container-fluid vertical_tab">  

<div class="tab-content">
<div id="Personal-Details">
   <div class="row">  
<div class="col-xs-12 col-sm-12 col-md-12">	
    <div class="table-responsive">
	<table class="table table-sm table-bordered">
    <thead>
      <tr>
        <th>Agent Name</th>
        <th>Student Name</th>
        <th>Ref Id</th>
        <th>Stu Id</th>
        <th>Program</th>
        <th>Intake</th>
        <th>GIC</th>
        <th>GIC File</th>
        <th>Updated Name</th>
        <th>Updated On</th>
      </tr>
    </thead>
    <tbody>
	<?php
	$qryStr = "SELECT st_application.sno, st_application.agent_type, st_application.app_by, st_application.user_id, st_application.fname, st_application.lname, st_application.refid, st_application.student_id, st_application.dob, st_application.prg_name1, st_application.prg_intake, pal_apply.app_id, pal_apply.gic_pr, pal_apply.gic_file, pal_apply.gic_added_by, pal_apply.gic_datetime FROM pal_apply
INNER JOIN st_application
ON pal_apply.app_id = st_application.sno
WHERE pal_apply.gic_pr!='' order by pal_apply.app_id DESC LIMIT $offset, $total_records_per_page
";
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
	 $gic_pr = $row['gic_pr'];
	 $gic_file2 = $row['gic_file'];
	 $gic_added_by = $row['gic_added_by'];
	 $gic_datetime = $row['gic_datetime'];

	if(!empty($gic_file2)){
		$gic_file = '<a href="../GICFiles/'.$gic_file2.'" download>Download GIC File</a>';
	}else{
		$gic_file = 'N/F';
	}
	
	$agnt_qry = mysqli_query($con,"SELECT username FROM allusers where sno='$user_id1'");
	$row_agnt_qry = mysqli_fetch_assoc($agnt_qry);
	$agntname = mysqli_real_escape_string($con, $row_agnt_qry['username']);
	
	$agnt_qry2 = mysqli_query($con,"SELECT contact_person FROM allusers where sno='$gic_added_by'");
	$row_agnt_qry2 = mysqli_fetch_assoc($agnt_qry2);
	$updated_name = $row_agnt_qry2['contact_person'];
	?>
      <tr>
        <td><?php echo $agntname;?></td>
        <td><?php echo $fname.' '.$lname;?></td>
        <td><?php echo $refid;?></td>
        <td><?php echo $student_id2;?></td>
        <td><?php echo $prg_intake;?></td>
        <td><?php echo $prg_name1;?></td>		
        <td><?php echo $gic_pr;?></td>		
        <td><?php echo $gic_file;?></td>
        <td><?php echo $updated_name;?></td>	
        <td><?php echo $gic_datetime;?></td>	
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
</div>
</div>
</section>
<script src="../../js/document.js"></script>
<?php
include("../../footer.php");
?>
