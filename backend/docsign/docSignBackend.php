<?php
ob_start();
include("../db.php");
include("../header.php");
date_default_timezone_set("America/Toronto");

if($_SESSION['role'] !== 'SuperAdmin' && $usernameLogged !== 'jamaiya'){
	header("Location: ../login");
    exit();
}

if(isset($_POST['btnsrch'])){
	$vnoFilter = $_POST['vnoFilter'];
	header("Location: ../docsign/docSignBackend.php?vnoFilter=$vnoFilter");
}

if(!empty($_GET['vnoFilter'])){
	$vnoFilter2 = $_GET['vnoFilter'];
	$vnoFilter3 = "AND student_no='$vnoFilter2'";
}else{
	$vnoFilter2 = '';
	$vnoFilter3 = '';
}

// $slctQry_2 = "SELECT * FROM ppp_form where worker_id!='' AND contract!='' AND final_student_sign_sbmit='1' $vnoFilter3";
$slctQry_2 = "SELECT * FROM ppp_form where worker_id!='' AND contract!='' $vnoFilter3";
$checkQuery_2 = mysqli_query($con, $slctQry_2);
?>
<div class="loading_icon" style="display:none;"></div> 
<div class="s01 mb-5">
<div class="signin-page">
<div class="container pt-5">
<div class="row">
		
<div class="col-12 mt-5 p-0">

<form action="" class="row" method="POST" autocomplete="off">

<div class="col-md-12 col-sm-12 form-group">
<input type="text" class="form-control form-control-sm" name="vnoFilter" placeholder="Search By V-Number" value="<?php echo $vnoFilter2; ?>">
<p><b style="color: #ec8282;">Note:</b> <span style="color: white;">Only for those students whose signatures are missing after email signature process.</span></p>
</div>

<div class="col-12 form-group">
<button name="btnsrch" class="btn btn-sm btn-success float-right">Search</button>
</div>
</form>

<?php if(!empty($vnoFilter2) && !empty($vnoFilter2)){ ?>

<div class="srchResult">
<h3 class=" bg-white p-2">Student Lists</h3>

<div class="col-12 bg-white py-3">
<div class="table-responsive">
<table class="table table-bordered table-hover">
    <thead>
      <tr>
        <th>Program</th>
        <th>Campus</th>
        <th>St.Name</th>
        <th>VNo.</th>
        <th>Start Date</th>
        <th>Case Worker Name</th>
        <th>Action</th>
      </tr>
      
    </thead>
    <tbody class="rsltFind">
    <?php
	$fullname = '';
	$snoid = '';
	$student_no = '';
    if(mysqli_num_rows($checkQuery_2)){
		$rowstr_2 = mysqli_fetch_assoc($checkQuery_2);
		$snoid = $rowstr_2['sno'];
        $campus = $rowstr_2['campus'];
        $worker_id = $rowstr_2['worker_id'];
        $program = $rowstr_2['program'];
        $title = $rowstr_2['title'];
        $fname = $rowstr_2['fname'];
        $lname = $rowstr_2['lname'];
		$fullname = $fname.' '.$lname;
        $student_no = $rowstr_2['student_no'];	
		$start_date2 = $rowstr_2['start_date'];
		$start_date = date("d M, Y", strtotime($start_date2));
		$bursary_award23 = $rowstr_2['bursary_award'];
		
		$agnt_qry = mysqli_query($con,"SELECT name FROM ulogin where name!='' AND sno='$worker_id'");
		$row_agnt_qry = mysqli_fetch_assoc($agnt_qry);
		$agntname = mysqli_real_escape_string($con, $row_agnt_qry['name']);
    ?>	
      <tr>
        <td><?php echo $program; ?></td>
        <td><?php echo $campus; ?></td>
        <td><?php echo $title.' '.$fullname; ?></td>
        <td><?php echo $student_no; ?></td>
        <td><?php echo $start_date; ?></td>   
        <td><?php echo $agntname; ?></td>
        <td>
		<a class="btn btn-sm btn-primary btn_next" data-bs-toggle="modal" data-bs-target="#exampleModal">Click here to Sign</a>
		</td>
      </tr>
	<?php
    }else{
        echo '<tr><td colspan="6" align="center">No result found!!!</td></tr>';
    }
	?>
	</tbody>
  </table>
<?php if(mysqli_num_rows($checkQuery_2)){ ?> 
<table class="table table-bordered table-hover">
    <thead>  
  <tr>
		<th>PP Form</th>
		<th>Contract</th>
		<th>Bursary Form</th>
		<th>Enrollment Checklist</th>
	</tr>
	</thead>
	<tbody>
	<tr>
	<td>
	<form method="post" action="pdf_pp.php">
		<input type="hidden" name="snoidbknd" value="<?php echo $snoid; ?>">			
		<input type="hidden" name="docBackend" value="DocBackend">			
		<button class="btn btn-success btn-sm" type="submit">
			Signed PP Form
		</button>		
	</form>
	</td>
	<td>
	<form method="post" action="pdf.php">
		<input type="hidden" name="snoidbknd" value="<?php echo $snoid; ?>">			
		<input type="hidden" name="docBackend" value="DocBackend">	
		<button class="btn btn-success btn-sm" type="submit">
			Signed Contract
		</button>				
	</form>
	</td>
	<td>
	<?php
	if($bursary_award23 == 'No bursary'){
		echo 'You have selected No bursary.';
	}else{
	?>
	<form method="post" action="pdf_brsry.php">
		<input type="hidden" name="snoidbknd" value="<?php echo $snoid; ?>">			
		<input type="hidden" name="docBackend" value="DocBackend">				
		<button class="btn btn-success btn-sm" type="submit">
			Signed Bursary Form
		</button>
	</form>
	<?php } ?>
	</td>
	<td>
	<form method="post" action="pdf_emc.php">
		<input type="hidden" name="snoidbknd" value="<?php echo $snoid; ?>">			
		<input type="hidden" name="docBackend" value="DocBackend">	
		<button class="btn btn-success btn-sm" type="submit">
			Signed Enrollment Checklist
		</button>				
	</form>
	</td>
	</tr>
    </tbody>
</table>
  
<table class="table table-bordered table-hover">
    <thead>  
	<tr>
		<th>Student Handbook Confirmation</th>
		<th>OSAP GUIDELINES FOR RELEASING FUNDS</th>
		<th>Proof of Admissions Interview</th>
	</tr>
	</thead>
	<tbody>
	<tr>
	<td>
	<form method="post" action="pdf_shc.php">
		<input type="hidden" name="snoidbknd" value="<?php echo $snoid; ?>">			
		<input type="hidden" name="docBackend" value="DocBackend">	
		<button class="btn btn-success btn-sm" type="submit">
			Signed SHC
		</button>				
	</form>
	</td>
	<td>
	<form method="post" action="pdf_osap_fund.php">
		<input type="hidden" name="snoidbknd" value="<?php echo $snoid; ?>">			
		<input type="hidden" name="docBackend" value="DocBackend">	
		<button class="btn btn-success btn-sm" type="submit">
			Signed OSAP
		</button>				
	</form>
	</td>
	<td>
	<form method="post" action="pdf_pai.php">
		<input type="hidden" name="snoidbknd" value="<?php echo $snoid; ?>">			
		<input type="hidden" name="docBackend" value="DocBackend">	
		<button class="btn btn-success btn-sm" type="submit">
			Signed PAI
		</button>				
	</form>
	</td>
	</tr>
    </tbody>
</table>
<?php } ?>
</div>

</div>
</div>
<?php
}else{
	echo '<div class="srchResult">
<h3 class="bg-white p-2"><center>Search Here!!!</center></h3></div>';
}
?>


</div>
</div>
</div>
</div>
</div>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="./jquery.signature.css">
<link rel="stylesheet" type="text/css" href="../css/almuni.css">

<div class="modal" tabindex="-1" id="exampleModal">
<div class="modal-dialog">
<div class="modal-content">
	<div class="modal-header">
		<h5 class="modal-title">Select Signnature</h5>
		<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	</div>
	<div class="modal-body">
		<div style="text-align:center">
			<!--a href="javascript:void(0)" class="btn btn-secondary DrawSig">Draw Signature</a-->
			<a href="javascript:void(0)" class="btn btn-primary Stylish">Stylish Signature</a>
		</div>
	</div>
</div>
</div>
</div>
<div class="modal" tabindex="-1" id="styleModel">
<div class="modal-dialog modal-lg">
<div class="modal-content">
	<div class="modal-header">
		<h5 class="modal-title">Select Signature</h5>
		<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	</div>
	<div class="modal-body">
		<div class="row px-2">
			<div class="col-lg-6 p-1 text-center" data-aos="fade-left">
				<div class="my-div mt-2" data-id="1">
					<div class="sig1 namediv"> <?php echo $fullname; ?> </div>
				</div>

			</div>
			<div class=" col-lg-6 p-1 text-center" data-aos="fade-left">
				<div class="my-div mt-2" data-id="2">
					<div class="sig2 namediv"> <?php echo $fullname; ?> </div>
				</div>

			</div>

			<div class=" col-lg-6 p-1 text-center" data-aos="fade-left">
				<div class="my-div mt-2" data-id="3">
					<div class="sig3 namediv"> <?php echo $fullname; ?> </div>
				</div>

			</div>
			<div class=" col-lg-6 p-1 text-center" data-aos="fade-left">
				<div class="my-div mt-2" data-id="4">
					<div class="sig4 namediv"> <?php echo $fullname; ?> </div>
				</div>
			</div>
			<div class="col-lg-6 p-1 text-center" data-aos="fade-left">
				<div class="my-div mt-2" data-id="5">
					<div class="sig5 namediv"> <?php echo $fullname; ?> </div>
				</div>

			</div>
			<div class=" col-lg-6 p-1 text-center" data-aos="fade-left">
				<div class="my-div mt-2" data-id="6">
					<div class="sig6 namediv"> <?php echo $fullname; ?> </div>
				</div>

			</div>
		</div>
	</div>
	<div class="modal-footer">
		<button class="btn btn-primary px-4 mt-2 Next">Ok</button>
	</div>
</div>
</div>
</div>


<div class="modal" tabindex="-1" id="drawModal">
<div class="modal-dialog">
<div class="modal-content">
	<div class="modal-header">
		<h5 class="modal-title">Draw Signature</h5>
		<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	</div>
	<div class="modal-body">
		<form method="POST" class="row justify-content-center" action="draw.php">

			<div class="col-md-12 text-center w-100">
				<label class="" for=""><b>Student's Signature:<b></label>
				<br />
				<div id="sig" class=" m-auto"></div>
				<br />
				<div class="row">
				<div class="col-6">
				<button id="clear" class=" btn btn-danger float-end mt-2">Clear Signature</button>
				<textarea id="signature64" name="signed" style="display: none"></textarea>
			</div>
			

			<div class="col-6">
			<button type="submit" name="submit" class="btn btn-success float-start mt-2">Sign & Continue</button>
			</div>
			</div>
		</form>
	</div>
   
</div>
</div>
</div>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<link type="text/css" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/south-street/jquery-ui.css" rel="stylesheet">
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

<script type="text/javascript" src="./jquery.signature.min.js"></script>
<script>
	$('.Stylish').on("click", function() {
		var myModal = bootstrap.Modal.getOrCreateInstance(document.getElementById('styleModel'));
		var myModal2 = bootstrap.Modal.getOrCreateInstance(document.getElementById('exampleModal'));
		var myModal3 = bootstrap.Modal.getOrCreateInstance(document.getElementById('drawModal'));
		myModal.show();
		myModal2.hide();
		myModal3.hide();
	});
	$('.DrawSig').on("click", function() {
		var myModal = bootstrap.Modal.getOrCreateInstance(document.getElementById('styleModel'));
		var myModal2 = bootstrap.Modal.getOrCreateInstance(document.getElementById('exampleModal'));
		var myModal3 = bootstrap.Modal.getOrCreateInstance(document.getElementById('drawModal'));
		myModal.hide();
		myModal2.hide();
		myModal3.show();
	});
	var fid;
	$('.my-div').on("click", function() {
		$('.my-div').removeClass('select-any');
		$(this).addClass('select-any');
		fid = $(this).data().id;
	});
	$(".Next").on("click", function() {
		sigpad = '<?php echo $fullname; ?>';
		id = '<?php echo $snoid; ?>';
		vno = '<?php echo $student_no; ?>';
		$.ajax({
			type: 'POST',
			url: 'api.php?tag=styleImg',
			data: {
				name: sigpad,
				fid: fid,
				id: id
			},
			success: function(result) {
				if(result['status'] == 200){
					alert('Signature Updated!!!');
					window.location.href = "docSignBackend.php?vnoFilter="+vno+"";
					return true;
				}else{
					window.location.href = "docSignBackend.php?vnoFilter="+vno+"";
					return false;
				}
			},
		});
	});
</script>
<script>
$(document).ready(function(){
  $('#exampleModal').modal({backdrop: 'static', keyboard: false}, 'show');
  $('#styleModel').modal({backdrop: 'static', keyboard: false}, 'show');
  $('#drawModal').modal({backdrop: 'static', keyboard: false}, 'show');
});
</script>

<style type="text/css">
	@font-face {
		font-family: "PaulSignature-WEJY";
		src: url(PaulSignature-WEJY.ttf);
		font-weight: bold;
	}

	@font-face {
		font-family: "Amadgone-BW1ax";
		src: url(Amadgone-BW1ax.otf);
	}


	@font-face {
		font-family: "Heatwood-GOKPO";
		src: url(Heatwood-GOKPO.ttf);
	}

	@font-face {
		font-family: "MaradonaSignature-DOMv0";
		src: url(MaradonaSignature-DOMv0.otf);
	}

	@font-face {
		font-family: "PandemiDemo-6Ygqx";
		src: url(PandemiDemo-6Ygqx.ttf);
	}

	@font-face {
		font-family: "SouthSand-qZ611";
		src: url(SouthSand-qZ611.ttf);

	}

	.my-div {
		width: 100%;
		min-height: 100px;
		text-align: center;
		position: relative;
		top: 0;
		bottom: 0;
		left: 0;
		right: 0;
		background: #fff;
		margin: auto;
		padding: 0px;
		border: 2px solid #fff;
		box-shadow: 0px 0px 5px #ccc;
		border-radius: 5px;
	}

	.namediv {
		font-size: 26px;
		width: 100% !important;
		height: auto;
		background: #fff;
		position: absolute;
		top: 30%;
		-ms-transform: translateY(-50%);
		transform: translateY(-50%);
		left: 50%;
		-ms-transform: translateX(-50%);
		transform: translateX(-50%);
	}

	.my-div.select-any {
		border: 2px solid #28a745;
	}

	.sig1 {
		font-family: 'PaulSignature-WEJY';
	}

	.sig2 {
		font-family: 'Amadgone-BW1ax'
	}

	.sig3 {
		font-family: 'Heatwood-GOKPO';
	}

	.sig4 {
		font-family: 'MaradonaSignature-DOMv0';
		font-weight: 500;
	}

	.sig5 {
		font-family: 'PandemiDemo-6Ygqx';
	}

	.sig6 {
		font-family: 'SouthSand-qZ611';
	}
</style>

</body>

</html>