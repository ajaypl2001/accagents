<?php
ob_start();
include("../root_element/header_navbar.php");
include("../root_element/db.php");

if(isset($_POST['Subbtn'])){
	$refid = $_POST['referid'];
	$pssid = $_POST['passport'];
	$querydb = "SELECT sno, refid, passport_no, tuition_fee FROM st_application WHERE refid='$refid' AND passport_no='$pssid'"; 
	$resultQ = mysqli_query($con, $querydb);
	if(mysqli_num_rows($resultQ) == '1'){
		$row = $resultQ->fetch_assoc();
		$snotf = $row['sno'];
		$passtf = $row['tuition_fee'];
		$idtf = base64_encode($snotf);
	if($passtf == ''){
		$nrmsg = base64_encode('NotReady');
		header("Location: ../checkstatus?nr=$nrmsg&$idtf");	
	}else{		
		$msg = base64_encode('VerifyID');		
		header("Location: ../checkstatus?tf=$idtf&vr1=$msg");
	}
	}else{
		$notmsg = base64_encode('NotVerifyID');
		header("Location: ../checkstatus?vr=$notmsg");	
	}
}
?>

<div class="container">
<?php if(isset($_GET['tf']) && !empty($_GET['tf'])){
	$sno = base64_decode($_GET['tf']);
	$qryDb = "SELECT sno, tuition_fee FROM st_application WHERE sno='$sno'";
	$rslt = mysqli_query($con, $qryDb);
	$rwg = $rslt->fetch_assoc();
	$tfee = $rwg['tuition_fee'];
	echo "<center><a href='../uploads/$tfee' download>Click Here to Download Tuition Fee Letter</a></center>";
}
if(isset($_GET['nr']) && !empty($_GET['nr'])){ ?>
<div class="alert alert-danger alert-dismissible">
<center>
	<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	Not Found
</center>
</div>	
<?php }
if(isset($_GET['vr']) && !empty($_GET['vr'])){ ?>
<div class="alert alert-danger alert-dismissible">
<center>
	<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	Not Found
</center>
</div>	
<?php } ?>
  <h2><center>Check Verify Letter</center></h2>
  <form class="form-horizontal" action="" method="post" autocomplete="off">
    <div class="form-group">
      <label class="control-label col-sm-2" for="ref">Refer Id:</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="ref" placeholder="Enter Refer Id" name="referid">
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-2" for="passport">Passport Number:</label>
      <div class="col-sm-10">          
        <input type="text" class="form-control" id="psprt" placeholder="Enter Passport Number" name="passport">
      </div>
    </div>    
    <div class="form-group">        
      <div class="col-sm-offset-2 col-sm-10">
		<input type="submit" name="Subbtn" class="btn btn-info btn-sm" value="Check Letter">
      </div>
    </div>
  </form>
</div>