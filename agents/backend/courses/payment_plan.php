<?php
ob_start();
include("../../db.php");
include("../../header_navbar.php");

if(!isset($_SESSION['sno'])){
    header("Location: ../../login");
    exit(); 
}

if(!empty($_GET['idpp_'])){
	$ppid_6 = base64_decode($_GET['idpp_']);
	$snoid_6 = base64_decode($_GET['idCrs_']);
	$qryCrs = "select * from cc_date_wise_fee where sno='$ppid_6' AND crs_id='$snoid_6'";
	$rsltCrs = mysqli_query($con, $qryCrs); 	
	$rowCrs = mysqli_fetch_array($rsltCrs);
	$snoid = $rowCrs['sno'];
	$due_date = $rowCrs['due_date'];
	$total_fee = $rowCrs['total_fee'];
	$int_fee = $rowCrs['int_fee'];
	$book = $rowCrs['book'];
	$comp_fees = $rowCrs['comp_fees'];	
	$tuition_fees = $rowCrs['tuition_fees'];
	$invoice_code = $rowCrs['invoice_code'];
}else{
	$snoid = '';
	$ppid_6 = '';
	$snoid_6 = base64_decode($_GET['idCrs_']);
	$due_date = '';
	$total_fee = '';
	$int_fee = '';
	$book = '';
	$comp_fees = '';	
	$tuition_fees = '';
	$invoice_code = '';	
}
?>		
<div class="main-div">           
<div class="container vertical_tab">  
  <div class="row">  
	<div class="col-md-12 col-lg-10 offset-lg-1"> 
             
<div class="tab-content">
<div id="Personal-Details">
<form action="../mysqldb.php" method="post" autocomplete="off" enctype="multipart/form-data">
<div class="col-sm-12">
<h3 class="folded"><center><b>Add New Payment Plan</b></center></h3>
</div>
<div class="col-sm-12">
	<div class="row">
		
	<div class="col-sm-6 form-group">
	<label>Due Date:</label>
	 <div class="input-group">
		  <span class="input-group-addon" id="icon"><i class="fas fa-envelope"></i></span>
		<input type="text" name="due_date" placeholder="Eg: November MM, YYYY" class="form-control date_followup" value="<?php echo $due_date; ?>">
	</div>	
   </div>		
						
	<div class="col-sm-6 form-group">
		<label>Total Fee: </label>
		 <div class="input-group">
			<span class="input-group-addon" id="icon"><i class="fas fa-envelope"></i></span>
		<input type="text" name="total_fee" class="form-control" placeholder="Eg: 0.00" value="<?php echo $total_fee; ?>">
		</div>
	</div>
		
	<div class="col-sm-6 form-group">
		<label>International fees :</label>
		 <div class="input-group">
			<span class="input-group-addon" id="icon"><i class="fas fa-envelope"></i></span>
		<input type="text" name="int_fee" class="form-control" placeholder="Eg: 0.00" value="<?php echo $int_fee; ?>">
		</div>
	</div>
			
	<div class="col-sm-6 form-group">	
	<label>Books:</label>
	<div class="input-group">
		<span class="input-group-addon" id="icon"><i class="fas fa-map-marker"></i></span>
		<input type="text" name="book" placeholder="Eg: 0.00" class="form-control" value="<?php echo $book; ?>">
	</div>
	</div>
	
	<div class="col-sm-6 form-group">	
	<label>Compulsory fees:</label>
	<div class="input-group">
		<span class="input-group-addon" id="icon"><i class="fas fa-map-marker"></i></span>
		<input type="text" name="comp_fees" placeholder="Eg: 0.00" class="form-control" value="<?php echo $comp_fees; ?>">
	</div>
	</div>
	
	<div class="col-sm-6 form-group">	
	<label>Tuition fees:</label>
	<div class="input-group">
		<span class="input-group-addon" id="icon"><i class="fas fa-map-marker"></i></span>
		<input type="text" name="tuition_fees" placeholder="Eg: 0.00" class="form-control" value="<?php echo $tuition_fees; ?>">
	</div>
	</div>	
	
	<div class="col-sm-6 form-group">	
	<label>Invoice code:<span style="font-size: 13px;"></span></label>
	<div class="input-group">
		<span class="input-group-addon" id="icon"><i class="fas fa-map-marker"></i></span>
		<input type="text" name="invoice_code" id="invoice_code" placeholder="Eg: X1, X2, X3, X4" class="form-control" value="<?php echo $invoice_code; ?>">
	</div>
	</div>
	
	<input type="hidden" name="ppid" value="<?php echo $ppid_6;?>">
	<input type="hidden" name="crs_id" value="<?php echo $snoid_6;?>">
	
	<div class="col-sm-12">
	<?php if(!empty($_GET['idpp_'])){ ?>
		<button type="submit" name="ppBtnNew" class="btn btn-primary btn-sm courseBtnNew float-right" onclick="return confirm('Are you sure you want to update this Payment Plan?');">Update</button>
	<?php }else{ ?>
		<button type="submit" name="ppBtnNew" class="btn btn-primary btn-sm courseBtnNew float-right" onclick="return confirm('Are you sure you want to add this Payment Plan?');">Submit</button>
	<?php } ?>
	</div>
	</form>	
	</div>
	</div>
  </div>
   
<!---Personal details ending-->
		
  </div>
  </div>
   </div></div>

<script>
$(function(){
    $(".date_followup").datepicker({	  
		dateFormat: 'yy-mm-dd', 
		changeMonth: false, 
		changeYear: false,
    });
});
</script>
   