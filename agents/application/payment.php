<?php
ob_start();
include("../root_element/db.php");
include("../root_element/header_navbar.php");

if(!isset($_SESSION['sno'])){
    header("Location: ../login");
    exit(); 
}
?>
<style>
a.btnpdf {
    float: right;
    top: -26px;
    position: relative;
    padding: 4px 7px;
    background: #337AB7;
    color: #fff;
    margin-right: 10px;
}
.paybtn {
    margin-top: 5px;
}
</style>
<?php
$sessionid = $_SESSION['sno'];
$result1 = mysqli_query($con,"SELECT sno,verifystatus FROM allusers WHERE sno = '$sessionid'");
while ($row1 = mysqli_fetch_assoc($result1)) {
	 $mainloggedid = mysqli_real_escape_string($con, $row1['sno']);	 
	 $verifystatus = mysqli_real_escape_string($con, $row1['verifystatus']);	 
	 
if($verifystatus == ''){		
	include('../root_element/verifyemail.php');
}else{
?>  
<h3><center>My Courses</center></h3>
<div class="container vertical_tab">  
  <div class="row">  
	<div class="col-xs-12 col-sm-12 col-md-8 col-md-offset-2">	
<div class="tab-content">
 <div id="Personal-Details">
  <div class="col-sm-12">
	<div class="row">
	<form method="post" action="pay.php">
	<table class="table table-bordered">
    <thead>
      <tr>
        <th>Course Name</th>
        <th>Course Type</th>       
        <th>Application Fee</th>        
        <th>Action</th>        
      </tr>
    </thead>
    <tbody id="totalshow">
	<?php
	$getsno = base64_decode($_GET['psno']);
	$result = mysqli_query($con,"SELECT sno,prg_name1,prg_type1 FROM st_application where sno='$getsno' AND (prg_name1 !='')");
	 while ($row = mysqli_fetch_assoc($result)) {				 
	 $insertid = mysqli_real_escape_string($con, $row['sno']);
	 $prg_name1 = mysqli_real_escape_string($con, $row['prg_name1']);
	 $prg_type1 = mysqli_real_escape_string($con, $row['prg_type1']); 
	 
	 $queryrslt1 = "SELECT sno, program_name, program_type, application_fee FROM aol_courses where (program_name='$prg_type1' and program_type='$prg_name1')";
	 $queryrslt = mysqli_query($con, $queryrslt1);
	 while ($rowcrs = mysqli_fetch_assoc($queryrslt)){
		$program_name = $rowcrs['program_name'];
		$program_type = $rowcrs['program_type'];
		$application_fee = $rowcrs['application_fee'];
		
	 ?>
		<tr>
			<td><?php echo $program_type; ?></td>
			<td><?php echo $program_name; ?></td>
			<td><?php echo $application_fee; ?></td>
			<td>
			<?php 
			$payment_query = "SELECT sno,status FROM payments where fee_type='Application Fee' AND sid='$getsno'";
			$payrslt = mysqli_query($con, $payment_query);
			if(mysqli_num_rows($payrslt) == 0){
			?>
			<input type="checkbox" name="atc[]" class="btn btn-success btn-sm atcpay" value="<?php echo $application_fee; ?>" crsname="<?php echo $program_name; ?>" crstype="<?php echo $program_type; ?>">	
			<?php }else{
			while ($rowpay = mysqli_fetch_assoc($payrslt)){
			$paystatus = $rowpay['status'];
			if($paystatus == 'Pending'){
			?>
			<span style='color:red;'>Checking Your Payment Status</span>
			<?php }
			if($paystatus == 'Done'){
				echo "<span style='color:green;'>Approved Payment</span>";
			} } } ?>
			</td>
		</tr>		
	 <?php } } ?>
    </tbody>
	</table>
	<script>
		$('.atcpay').click(function (){
			var total = 0;
			var CrsArray = [];
			var CrsTArray = [];
			$('input:checkbox:checked').each(function(i, element){
				total += isNaN(parseInt($(this).val())) ? 0 : parseInt($(this).val());
				CrsArray.push($(element).attr('crsname'));
				CrsTArray.push($(element).attr('crstype'));
			});			
			var crsname2 = CrsArray.join(',');
			var crstype2 = CrsTArray.join(',');
			$(".crsname1").attr('value',crsname2);
			$(".crstype1").attr('value',crstype2);
			$(".totalPrice").html(total);
			$(".inputamount").attr('value',total);
			$("#paydiv").show();
		});	
	</script>
	<center>	
	<div id="paydiv" style="display:none;">	
		<div class="totalPrice"></div>
		<input type="hidden" name="stuid" value="<?php echo $getsno; ?>">
		<input type="hidden" name="crsname" class="crsname1" value="" />
		<input type="hidden" name="crstype" class="crstype1" value="" />
		<input type="hidden" name="amount" class="inputamount" value="" />
		<input type="submit" name="smtpay" class="btn btn-success" value="Payment">
	</form>		
	</div>
	</center>
	</div>
	</div>
	</div>
   </div>
  </div>
 </div>
</div>
<?php } } ?>
