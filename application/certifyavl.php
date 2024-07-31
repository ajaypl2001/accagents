<?php
ob_start();
include("../db.php");
include("../header_navbar.php");

if(!isset($_SESSION['sno'])){
    header("Location: ../login");
    exit(); 
}
?>
  
<div class="main-div">
<h3><center>Authorisation Certificate</center></h3>
<div class="container-fluid vertical_tab">  
<div class="row">  
<div class="col-xs-12 col-sm-12 col-md-12">
<div class="tabs tabs-style-tzoid">
<div class="tab-content">
<div class="row justify-content-center mt-3"> 
	
	<?php 
	$quryCertificate = "select * from certificates where agent_id='$sessionid1'";
	$rsltCertificate = mysqli_query($con, $quryCertificate);
	if(mysqli_num_rows($rsltCertificate)){
		while($rowCertificate = mysqli_fetch_assoc($rsltCertificate)){
			$campus22 = $rowCertificate['campus'];
			$certificate22 = $rowCertificate['certificate'];
	?>
	<div class="col-lg-6">
	<div class="setting-form mb-5">
		<object data="../backend/aol_listing/certificate/<?php echo $certificate22; ?>" type="application/pdf" style="width:100%;height:500px;">
			<a href="../backend/aol_listing/certificate/<?php echo $certificate22; ?>"><?php echo $campus22;?> Certificate</a>
		</object>
	</div>
	</div>
	<?php } } ?>
	

</div>		
</div>
</div>
</div>	   
</div>  
 
 </div>
 </div>
<?php  
include("../footer.php");
?>