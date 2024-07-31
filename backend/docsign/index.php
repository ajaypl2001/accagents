<?php
session_start();
include "../db.php";
if(isset($_GET['id'])) {
	$getId = base64_decode($_GET['id']);
	$query = "SELECT sno, fname, lname, student_no, bursary_award, contract, contract_mngr, contract_student_signature from ppp_form WHERE sno='$getId'";
	$result = mysqli_query($con, $query);
	if(mysqli_num_rows($result)){
		$row2 = mysqli_fetch_assoc($result);
		$getSno = $row2['sno'];
		$getSno2 = base64_encode($row2['sno']);
		$_SESSION['stsno'] = $row2['sno'];
		$student_no = $row2['student_no'];
		$fname = $row2['fname'];
		$lname = $row2['lname'];
		$contract = $row2['contract'];
		$contract_mngr = $row2['contract_mngr'];
		$bursary_award = $row2['bursary_award'];
		$contract_student_signature = $row2['contract_student_signature'];
		$nameSt = $fname.' '.$lname;
		
		$resultsStr3 = "SELECT * FROM `ppp_form_more` where ppp_form_id='$getSno'";
		$get_query3 = mysqli_query($con, $resultsStr3);
		if(mysqli_num_rows($get_query3)){
			$rowstr3 = mysqli_fetch_assoc($get_query3);
			$contract_signature = $rowstr3['contract_signature'];
			$pp_sign = $rowstr3['pp_sign'];
			$emc_sign = $rowstr3['emc_sign'];
			$shc_sign = $rowstr3['shc_sign'];
			$osap_fund_sign = $rowstr3['osap_fund_sign'];
			$pai_sign = $rowstr3['pai_sign'];
			$final_student_sbmit = $rowstr3['final_student_sbmit'];
			// if(empty($contract_student_signature) && empty($contract_signature)){
				// header('Location: ../docsign/?VGVzdFNlbmRFbWFpbEVuY29kZQ==&id='.$getSno2.'&U2VuZEVtYWlsRW5jb2Rl');
				// die();
			// }
			// elseif(!empty($contract_student_signature) && !empty($contract_signature) && empty($pp_sign)){
				// header('Location: ../docsign/pdf.php?uid='.$getSno.'');
				// die();
			// }
			// elseif(!empty($contract_signature) && !empty($pp_sign) && empty($emc_sign)){
				// header('Location: ../docsign/pdf_pp.php?uid='.$getSno.'');
				// die();
			// }
			// elseif(!empty($pp_sign) && !empty($emc_sign) && empty($shc_sign)){
				// header('Location: ../docsign/pdf_emc.php?uid='.$getSno.'');
				// die();
			// }
			// elseif(!empty($emc_sign) && !empty($shc_sign) && empty($osap_fund_sign)){
				// header('Location: ../docsign/pdf_shc.php?uid='.$getSno.'');
				// die();
			// }
			// elseif(!empty($shc_sign) && !empty($osap_fund_sign) && empty($pai_sign)){
				// header('Location: ../docsign/pdf_osap_fund.php?uid='.$getSno.'');
				// die();
			// }
			// elseif(!empty($osap_fund_sign) && !empty($pai_sign) && empty($final_student_sbmit)){
				// header('Location: ../docsign/pdf_pai.php?uid='.$getSno.'');
				// die();
			// }
			if(!empty($contract_signature) && !empty($pp_sign) && !empty($emc_sign) && !empty($shc_sign) && !empty($osap_fund_sign) && !empty($pai_sign) && !empty($final_student_sbmit) && ($contract_mngr == 'Accept')){
				header('Location: ../docsign/error.php?error=STWW');
				die();
			}else{
				header('Location: ../docsign/pdf.php?uid='.$getSno.'');
				die();
			}			
			
		}else{
			$contract_signature = '';	
		}		
		
	}else{
		header('Location: error.php?error=STWW');
		die();
	}
}else{
    header('Location: error.php?error=STWW');
	die();
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" href="../images/top-logo.jpg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="./jquery.signature.css">
	<link rel="stylesheet" type="text/css" href="../css/almuni.css">
    <title>AOLCC - Contract Signature</title>
</head>

<body>
<div class="s01 mb-5">
<div class="signin-page">
    <div class="container">
        <div class="row">
		
	<?php if(empty($contract_signature)){ ?>
		<div class="col-8 col-sm-5 pb-2">
			<a href=""><img src="../images/academy-of-learning-white.png" class="float-left" width="180"></a>
		</div>
		<div class="col-4 col-sm-7 py-2">
			<a class="btn btn-primary btn_next mt-2" data-bs-toggle="modal" data-bs-target="#exampleModal">Click here to Sign</a>
		</div>
		<div class="col-12">
			<iframe src="../uploads/<?php echo $contract; ?>" width="100%" height="600px"></iframe>
		</div>
	<?php }else{ ?>
	<div class="col-12 mt-5 text-center" id="main">
	<div class="p-md-5 p-2 bg-white">
	<a href=""><img src="../images/academy_of_learning_logo.png" class="mb-5" width="200">
	</a>
	<div class="alert alert-success mt-5 text-center">
		<strong>Success!</strong> You have already checked and signed contract. Let me know if you have any questions, please connect with your Admission Advisor.
	</div>
	</div>
		<?php } ?>
        </div>
    </div>
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
                                <div class="sig1 namediv"> <?php echo $nameSt; ?> </div>
                            </div>

                        </div>
                        <div class=" col-lg-6 p-1 text-center" data-aos="fade-left">
                            <div class="my-div mt-2" data-id="2">
                                <div class="sig2 namediv"> <?php echo $nameSt; ?> </div>
                            </div>

                        </div>

                        <div class=" col-lg-6 p-1 text-center" data-aos="fade-left">
                            <div class="my-div mt-2" data-id="3">
                                <div class="sig3 namediv"> <?php echo $nameSt; ?> </div>
                            </div>

                        </div>
                        <div class=" col-lg-6 p-1 text-center" data-aos="fade-left">
                            <div class="my-div mt-2" data-id="4">
                                <div class="sig4 namediv"> <?php echo $nameSt; ?> </div>
                            </div>
                        </div>
                        <div class="col-lg-6 p-1 text-center" data-aos="fade-left">
                            <div class="my-div mt-2" data-id="5">
                                <div class="sig5 namediv"> <?php echo $nameSt; ?> </div>
                            </div>

                        </div>
                        <div class=" col-lg-6 p-1 text-center" data-aos="fade-left">
                            <div class="my-div mt-2" data-id="6">
                                <div class="sig6 namediv"> <?php echo $nameSt; ?> </div>
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
		sigpad = '<?php echo $nameSt; ?>';
		id = '<?php echo $getSno; ?>';
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
					window.location.href = "pdf.php?uid="+id+"";
					return true;
				}else{
					window.location.href = "../docsign/";
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
	/* .my-div { border: 1px solid #ccc; box-shadow: 0px 0px 4px #ccc; padding: 10px 0px; border-radius: 4px;}*/
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

<script type="text/javascript">
var sig = $('#sig').signature({
	syncField: '#signature64',
	syncFormat: 'PNG'
});
$('#clear').click(function(e) {
	e.preventDefault();
	sig.signature('clear');
	$("#signature64").val('');
});
</script>
</body>

</html>