<?php 
ob_start();
include("../db.php");
include("../header_navbar.php");

if(!isset($_SESSION['sno'])){
    header("Location: ../login");
    exit(); 
}
?>
<div class="container" style="width:100%;margin-top: 126px;">
<?php
include 'folderpay/src/Instamojo.php';
$api = new Instamojo\Instamojo('test_55d2c173b633b635fc4e8286466', 'test_0c45e4cb11723442c7a272c719b','https://test.instamojo.com/api/1.1/');
$payid = $_GET["payment_request_id"];
try {
    $response = $api->paymentRequestStatus($payid);
	// echo "<pre>";
	// print_r($response);
	// echo "</pre>";
	
	$purpose = $response['purpose'];	
	$status1 = $response['status'];	
	$payment_id = $response['payments'][0]['payment_id'];	
	$amount1 = $response['payments'][0]['amount'];	
	$paymentCheck = mysqli_query($con,"SELECT payment_id FROM payments WHERE payment_id = '$payment_id'");
	if(mysqli_num_rows($paymentCheck) == 0){
		
	echo '<h3 style="color:#6da552">Thank You, Payment success!!</h3>';
	echo '<a href="../application/">Back to Application</a>';
		
	$status = $response['payments'][0]['status'];
	$currency = $response['payments'][0]['currency'];
	$instrument_type = $response['payments'][0]['instrument_type'];
	$created_at = $response['payments'][0]['created_at'];
	$getid = $_GET['sno'];
	$df = explode(",", $getid);
	for($i=0; $i<count($df); $i++) {	
	$result1 = mysqli_query($con,"SELECT sno,prg_name1,prg_type1 FROM st_application WHERE sno = '$df[$i]'");
	while ($row1 = mysqli_fetch_assoc($result1)) {
		$sno1 = mysqli_real_escape_string($con, $row1['sno']);
		$prg_name1 = mysqli_real_escape_string($con, $row1['prg_name1']);
		$prg_type1 = mysqli_real_escape_string($con, $row1['prg_type1']);
		$queryrslt1 = "SELECT application_fee FROM aol_courses where (program_name='$prg_type1' and program_type='$prg_name1')";
		$queryrslt = mysqli_query($con, $queryrslt1);		
		while ($rowcrs = mysqli_fetch_assoc($queryrslt)){
		$application_fee = $rowcrs['application_fee'];		
		$insrtData = "INSERT INTO `payments` (`sid`, `payment_id`, `currency`, `paid_from`, `course_name`, `course_type`, `fee_type`, `amount`, `status`, `created`) VALUES('$sno1', '$payment_id','$currency','$instrument_type', '$prg_name1', '$prg_type1', 'Application Fee', '$application_fee', '$status', '$created_at')";
		$querypaymt = mysqli_query($con, $insrtData);
		}
	  }
	}
	}else{
		echo '<h3 style="color:#6da552">Your payment already has been done.</h3>';
		echo '<a href="../application/">Back to Application</a>';
	}	
?>
<style>
.fullDiv {
    float: left;
    margin-left: 35%;
    border: 1px solid #c1abab;
    padding: 20px;
	margin-top: 30px;
}
.fullDiv p {
    font-size: 20px;
    text-align: center;
}
tbody tr th:first-child {
    background: #F2F5F8;
    width: 125px;
    padding: 5px;
}
tbody tr td:last-child {
    padding-left: 11px;
} 
</style>

<div class="pDoneDiv" style="width:100%;float:left;">
<div class="fullDiv">
<p>PAYMENT DETAILS</p> 
<table>
  <tr>
    <th>Payment ID:</th>
    <td><?php echo $payment_id; ?></td>
  </tr>
  <tr>
    <th>Total Amount:</th>
    <td><?php echo $amount1; ?></td>
  </tr>
  <tr>
    <th>Paid for:</th>
    <td><?php echo $purpose; ?></td>
  </tr>
  <tr>
    <th>Status:</th>
    <td><?php echo $status1; ?></td>
  </tr>
</table>
</div>
</div>


    <?php
}
catch (Exception $e) {
    print('Error: ' . $e->getMessage());
}
  ?>


      
    </div> <!-- /container -->
