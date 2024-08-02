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
if(isset($_SESSION['sno']) && !empty($_SESSION['sno'])){
$sessionSno = $_SESSION['sno'];
$result1 = mysqli_query($con,"SELECT sno,role,loa_allow FROM allusers WHERE sno = '$sessionSno'");
	while ($row1 = mysqli_fetch_assoc($result1)) {
		$adminrole = mysqli_real_escape_string($con, $row1['role']);
		$loa_allow = mysqli_real_escape_string($con, $row1['loa_allow']);
	}
}else{
   $adminrole = '';
   $loa_allow = '';
}

if($adminrole == 'Admin' && $loa_allow == '1'){
?> 

<section>
<div class="main-div"><div class="col-lg-12"><div class=" admin-dashboard">
<h3><center>Application Button Hide List</center></h3><br>
	
	<div class="row mt-4"> <div class="col-12">	
    <div class="table-responsive">
	<table class="table table-bordered" width="100%">
    <thead>	  
      <tr>	  
        <th>Student  Name</th>
        <th>Reference Id</th>		
        <th>Passport Number</th>		
        <th>Button Name</th>		
        <th>Action</th>		
      </tr>
    </thead>
    <tbody class="list_follow">	 
	<?php 		
		$rsltQuery = "SELECT sno, fname, lname, refid, passport_no, offer_letter, ol_confirm, loa_file, loa_file_status FROM st_application where application_form!='' AND ((ol_confirm !='' AND offer_letter='') OR (loa_file_status !='' AND loa_file=''))";
		$qurySql = mysqli_query($con, $rsltQuery);	
		if(mysqli_num_rows($qurySql)){			
		while ($row_nm = mysqli_fetch_assoc($qurySql)){
		$sno = $row_nm['sno'];
		$fname = $row_nm['fname'];
		$lname = $row_nm['lname'];
		$refid = $row_nm['refid'];
		$passport_no = $row_nm['passport_no'];		
		$offer_letter = $row_nm['offer_letter'];
		if(empty($offer_letter)){
			$valname = 'ol';
		}else{
		$loa_file = $row_nm['loa_file'];
		if(empty($loa_file)){
			$valname = 'loa';
		}
		}
	?>
		<tr>
			<td><?php echo $fname.' '.$lname; ?></td>
			<td><?php echo $refid; ?></td>
			<td><?php echo $passport_no; ?></td>
			<td><?php echo $valname; ?></td>
			<td>
				<span class="btn btn-sm btn-success enabledbtn" val-name="<?php echo $valname; ?>" data-id="<?php echo $sno; ?>" style="width: 49%;">Click to Enabled</span>
			</td>
		</tr>			
		<?php } ?>
		<?php }else{ ?>
			<tr><td colspan="5">Not Found</td></tr>
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



<script>
$(document).on('click', '.enabledbtn', function(){	
	var id = $(this).attr('data-id');
	var val = $(this).attr('val-name');
	$('.loading_icon').show();
	$.post("../response.php?tag=getEnabled",{"idno":id, "val":val},function(d){
		if(d == '1'){
			alert('Btn have been Enabled!!!');
			window.location.href="../application/btnEnabled.php";
			$('.loading_icon').hide();
		}
	});	
});
</script>

<?php 
include("../../footer.php");

}else{
	header("Location: ../../logout.php");
}
?>  
