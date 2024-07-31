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
$result1 = mysqli_query($con,"SELECT sno,role,clg_pr FROM allusers WHERE sno = '$sessionSno'");
 while ($row1 = mysqli_fetch_assoc($result1)) {
   $adminrole = mysqli_real_escape_string($con, $row1['role']); 
   $clg_pr = mysqli_real_escape_string($con, $row1['clg_pr']);   
 }
//if(($adminrole == 'Admin') || ($adminrole == 'Excu')){	
?> 

<section>
<div class="main-div container-fluid">
	<form class="row pt-4" method="post" action="../mysqldb.php"> 	
		<div class="col-xl-7 col-md-5"></div>
		<div class="col-xl-4 col-md-5 col-8 pl-4">
			<input type="search" class="form-control" name="search" placeholder="Search by Name,DOB,Refrence & Student Id">
		</div>
		<div class="col-xl-1 col-md-2 col-4"><button type="submit" name="srchClgbtn" class="btn btn-more btn-success">Search</button>
		</div>
	</form>

	
<div class=" application-tabs pt-4">
<?php if($clg_pr == '1'){ ?> 
	<div class="col-lg-12 content-wrap">	
	<div class="row">	
    <div class="table-responsive">
	<table class="table table-bordered" width="100%">
    <thead>	  
      <tr style="color:#fff;background:#596164;">		
        <th>Full Name</th>
        <th>Student ID</th>
        <th>Documents</th>	
        <th>Contract</th>
        <th>Signed Contract</th>
        <th>Signed Offer Letter</th>
        <th>LOA</th>
        <th>Download All Files</th>
      </tr>
    </thead>
    <tbody>
	<?php
	if(isset($_GET['getsearch']) && !empty($_GET['getsearch'])){
		$getsearch1 = $_GET['getsearch'];
		$resultQuery = "SELECT sno,student_id,fname,lname,idproof,englishpro,ielts_file,pte_file,certificate1,certificate2,certificate3,prg_name1,prg_intake,agreement,contract_letter,signed_agreement_letter,loa_file FROM st_application WHERE (CONCAT(fname,  ' ', lname) LIKE '%$getsearch1%' OR refid LIKE '%$getsearch1%' OR student_id LIKE '%$getsearch1%' OR dob LIKE '%$getsearch1%') AND loa_file !='' ORDER BY sno DESC";
	}else{
		$resultQuery = "SELECT sno,student_id,fname,lname,idproof,englishpro,ielts_file,pte_file,certificate1,certificate2,certificate3,prg_name1,prg_intake,agreement,contract_letter,signed_agreement_letter,loa_file FROM st_application where loa_file !=''";
	}		
	$result2 = mysqli_query($con, $resultQuery);
	if(mysqli_num_rows($result2)){
	while ($row = mysqli_fetch_assoc($result2)) {
		 $sno = mysqli_real_escape_string($con, $row['sno']);
		 $fname = mysqli_real_escape_string($con, $row['fname']);
		 $lname = mysqli_real_escape_string($con, $row['lname']);
		 $student_id = mysqli_real_escape_string($con, $row['student_id']);
		 $idproof = mysqli_real_escape_string($con, $row['idproof']);
		 $englishpro = mysqli_real_escape_string($con, $row['englishpro']);
		 $ielts_file = mysqli_real_escape_string($con, $row['ielts_file']);				
		 $pte_file = mysqli_real_escape_string($con, $row['pte_file']);			
		$certificate1 = mysqli_real_escape_string($con, $row['certificate1']);
		$certificate2 = mysqli_real_escape_string($con, $row['certificate2']);
		$certificate3 = mysqli_real_escape_string($con, $row['certificate3']);			 
		$signed_agreement_letter = mysqli_real_escape_string($con, $row['signed_agreement_letter']);			 
		$loa_file = mysqli_real_escape_string($con, $row['loa_file']);
		$prg_name1 = mysqli_real_escape_string($con, $row['prg_name1']);
		$prg_intake = mysqli_real_escape_string($con, $row['prg_intake']);
		$agreement_sol = mysqli_real_escape_string($con, $row['agreement']);
		$contract_letter = mysqli_real_escape_string($con, $row['contract_letter']);

		if(($idproof !== '') && ($englishpro == 'ielts' || $englishpro == 'pte') && ($certificate1 !== '') && ($signed_agreement_letter !== '') && ($loa_file !== '')){
			$clr = '';
			$brd = '';				
		}else{
			$clr = '#f2dede';
			$brd = '2px solid red';
		}
	?>
      <tr style="background:<?php echo $clr;?>;border-bottom:<?php echo $brd;?>">
        <td style="white-space: normal; width:150px;"><?php echo $fname.' '.$lname; ?></td>
        <td>
		<?php 
		if($student_id !== ''){
			echo $student_id;
		}else{
			echo '<span style="color:red;">N/A</span>';
		}
		?>
		</td>
        <td>
			<?php
			if($idproof !== ''){
				echo '<span><b>Passport : </b><a href="../../uploads/'.$idproof.'" download>Download</a></span><br>';
			}else{
				echo '<span><b>Passport : </b><span style="color:red;">N/A</span></span><br>';
			}
			if($englishpro == 'ielts'){
				echo '<span><b>IELTS : </b><a href="../../uploads/'.$ielts_file.'" download>Download</a></span><br>';
			}
			if($englishpro == 'pte'){
				echo '<span><b>PTE: </b><a href="../../uploads/'.$pte_file.'" download>Download</a></span><br>';
			}
			
			if($certificate1 !== ''){
				echo '<span><b>Certificate1 : </b><a href="../../uploads/'.$certificate1.'" download>Download</a></span><br>';
			}else{
				echo '<span><b>Certificate1 : </b><span style="color:red;">N/A</span></span><br>';
			}
			
			if($certificate2 !== ''){
				echo '<span><b>Certificate2 : </b><a href="../../uploads/'.$certificate2.'" download>Download</a></span><br>';
			}else{
				echo '<span><b>Certificate2 : </b><span style="color:red;">N/A</span></span><br>';
			}
			if($certificate3 !== ''){
				echo '<span><b>Certificate3 : </b><a href="../../uploads/'.$certificate3.'" download>Download</a></span>';
			}else{
				echo '<span><b>Certificate3 : </b><span style="color:red;">N/A</span></span><br>';
			}
			?>
		</td>		
		<td>	
			<?php 
			if($contract_letter !== ''){
				echo '<a href="../../uploads/'.$contract_letter.'" download>Download</a>';
			}else{
				echo '<span style="color:red;">N/A</span>';
			}
		?>
		</td>		
		<td>
		<?php 
			if($signed_agreement_letter !== ''){
				echo '<a href="../../uploads/'.$signed_agreement_letter.'" download>Download</a>';
			}else{
				echo '<span style="color:red;">N/A</span>';
			}
		?>
		</td>		
		<td>
		<?php 
			if($agreement_sol !== ''){
				echo '<a href="../../uploads/'.$agreement_sol.'" download>Download</a>';
			}else{
				echo '<span style="color:red;">N/A</span>';
			}
		?>
		
		<!--form method="post" action="isaf.php">
			<input type="hidden" name="pn" value="<?php //echo $prg_name1; ?>">
			<input type="hidden" name="tk" value="<?php //echo $prg_intake; ?>">
			<input type="hidden" name="snoid" value="<?php //echo $sno; ?>">
			<button class="btn btn-sm genrateloa" style="width: 36%;background: #fff;border: none;color: #07a5e8;font-size: 16px;background:none;">Download</button>
		</form-->			
		</td>
        <td>
		<?php 
			if($loa_file !== ''){
				echo '<a href="../../uploads/loa/'.$loa_file.'" download>Download</a>';
			}else{
				echo '<span style="color:red;">N/A</span>';
			}
		?>
		</td>
        <td>
		<form method="post"  action="download_docs.php">
			<input type="hidden" name="stusno" value="<?php echo $sno; ?>">
			<button type="submit" name="submit" class="btn btn-success">Download All Files</button>
		</center>
		</form>
		</td>
		
      </tr>
	<?php }
	}else{
		echo '<tr> <td colspan="8" style="text-align:center;">No Result Found</td></tr>';
	} ?>
    </tbody>	
 </table>  
 </div>
	</div>
  </div>
  <?php 
}else{
	echo "<center><b style='color:red;'>You are Not Authorised for this page.</b></center>";
}
?>
</div>
</div>
</section>
<style type="text/css">
	.application-tabs .table.table-bordered thead tr th,
	.application-tabs .table.table-bordered tbody tr td { font-size:14px !important; }


</style>
<?php 
include("../../footer.php");	
//}else{
	//header("Location: ../../application");
//}
?>  
