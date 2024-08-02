<?php
ob_start();
include("../db.php");
include("../header_navbar.php");

if(!isset($_SESSION['sno'])){
    header("Location: ../login");
    exit(); 
}
?>
<?php
$sessionid = $_SESSION['sno'];
$result1 = mysqli_query($con,"SELECT role,verifystatus FROM allusers WHERE sno = '$sessionid'");
while ($row1 = mysqli_fetch_assoc($result1)) {
	 $role_agent = mysqli_real_escape_string($con, $row1['role']);	 
	 $verifystatus = mysqli_real_escape_string($con, $row1['verifystatus']);	 
if($role_agent == 'Admin'){
	header("Location: ../backend/application/");
}else{
	
if($verifystatus == ''){		
	include('../verifyemail.php');
}else{	
?>


<div class="main-div">
<h3><center>How it works <br />
<span style="color:#666; font-size:16px;">Process explained in the tutorial</span></center></h3>
<div class="container-fluid vertical_tab">  
  <div class="row">  
	<div class="col-xs-12 col-sm-12 col-md-12">	
	<div class="tab-content">
	<div id="Personal-Details"> 
	
	<style>iframe.navActions button.view-on-ss.btnViewOnSS{
		width:0px !important;
		background-image: none !important;
	}
	</style>
	
	<center>
	<iframe src="//www.slideshare.net/slideshow/embed_code/key/l33o2Y35ihR4uy" width="750" height="460" frameborder="0" marginwidth="0" marginheight="0" scrolling="no" style="border:1px solid #CCC; border-width:1px; margin-bottom:5px; max-width: 100%;" allowfullscreen> </iframe>
	</center>
	
	</div>
   </div>
  </div>
 </div>
</div>
</div>

<?php } 
include("../footer.php");
} } ?>
