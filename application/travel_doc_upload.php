<?php
ob_start();
include("../db.php");
include("../header_navbar.php");

date_default_timezone_set("Asia/Kolkata");
$current_date = date('Y-m-d');

if (isset($_SESSION['sno'])) {

	$loggedid = $_SESSION['sno'];
	$rsltLogged = mysqli_query($con, "SELECT role FROM allusers WHERE sno = '$loggedid'");
	$rowLogged = mysqli_fetch_assoc($rsltLogged);
	$role = mysqli_real_escape_string($con, $rowLogged['role']);


	if (isset($_GET['st'])) {
		$stuid = $_GET['st'];
		$rsltqry = "SELECT sno, fname, lname, student_id, refid, passport_no FROM st_application WHERE sno = '$stuid'";
		$result = mysqli_query($con, $rsltqry);
		if (mysqli_num_rows($result) > 0) {
			
			$row = mysqli_fetch_assoc($result);
			$fname = mysqli_real_escape_string($con, $row['fname']);
			$lname = mysqli_real_escape_string($con, $row['lname']);
			$student_id = mysqli_real_escape_string($con, $row['student_id']);
			$refid = mysqli_real_escape_string($con, $row['refid']);
			$passport_no = mysqli_real_escape_string($con, $row['passport_no']);

			if ($role == 'Agent') {

				$getGTEList2 = '<div class="main-div pt-1"><h3><center>Travel Documents</center></h3><div class="container-fluid vertical_tab"><div><p>
				<b>Name:</b>'.$fname.' '.$lname.'&nbsp; &nbsp; | &nbsp; &nbsp;
				<b>RefID:</b>'.$refid.'&nbsp; &nbsp; | &nbsp; &nbsp;
				<b>Student Id:</b>'.$student_id.'&nbsp; &nbsp; | &nbsp; &nbsp;
				<b>Passport No.:</b>'.$passport_no.'
				</p></div><div class="tab-content" ><p> <b>Mandatory Documents Upload: </b><br><span style="color:red; font-size:12px;"><b>Note: </b> Upload maximum 4MB size of PDF file</span></p><div class="table-responsive mt-2"><table class="table table-sm table-bordered">';


				$resultRefA = mysqli_query($con, "SELECT * FROM `documents_name` where status='1'");
				while ($rowRefA = mysqli_fetch_assoc($resultRefA)) {

					$snoRefA = mysqli_real_escape_string($con, $rowRefA['doc_id']);
					$contentDiv = mysqli_real_escape_string($con, $rowRefA['content']);
					$doc_filled_name = mysqli_real_escape_string($con, $rowRefA['doc_filled_name']);

					$getRsltRefA = "SELECT * FROM `travel_docs` where st_id='$stuid' AND doc_name='$contentDiv'";
					$qryRsltRefA = mysqli_query($con, $getRsltRefA);
					$travel_file_upload = '';
					$doc_status = '';
					if (mysqli_num_rows($qryRsltRefA)) {
						$rowGGT = mysqli_fetch_assoc($qryRsltRefA);
						$travel_file_upload = $rowGGT['travel_file_upload'];
						$doc_status = $rowGGT['doc_status'];
						$datetime_at = $rowGGT['datetime_at'];
						$remarks = $rowGGT['remarks'];

						if ($doc_status == '1') {
							$sts_doc = 'Approved';
						} elseif ($doc_status == '2') {
							$sts_doc = 'Dis-Approved';
						} else {
							$sts_doc = 'No Action Taken';
						}

						if ($remarks != '') {
							$remarksDiv = $remarks . '(' . $sts_doc . ')';
						} else {
							$remarksDiv = "<span style='color:red;'>Action Pending</span>";
						}

						if (!empty($travel_file_upload)) {
							$valDiv = "<a class='btn btn-sm btn-primary btn-download mt-1' href='../travelDoc/" . $travel_file_upload . "' download>Download</a>";
							$timeDiv = $datetime_at;
						} else {
							$valDiv = '';
							$timeDiv = '<span style="color:red;">Pending</span>';
							$remarksDiv = "<span style='color:red;'>Action Pending'</span>";
						}
					} else {
						$valDiv = '';
						$timeDiv = '<span style="color:red;">Upload document</span>';
						$remarksDiv = "";
					}

					$getGTEList2 .= '<tr><th class="text-left">' . $contentDiv . '</th><td class="text-nowrap"><form action="../uploadpro.php" enctype="multipart/form-data" class="row  form-horizontal-docu-' . $snoRefA . '" method="post"><div class="col-sm-3">';

					if ($contentDiv == 'Enrollment Letter') {
						if ($travel_file_upload != '') {
							$getGTEList2 .= "<a class='btn btn-sm btn-primary btn-download mt-1' href='../travelDoc/" . $travel_file_upload . "' download>Download</a>";
							$valDiv = '';
						} else {
							$getGTEList2 .= "<span style='color:red;'>Pending</span>";
							$valDiv = '';
						}
					} elseif ($contentDiv == 'Contract Letter') {

						$getGTEList2 .= "<a class='btn btn-sm btn-primary btn-download mt-1' href='../backend/application/contract_letter.php?stuid=" . $stuid . "' download>Generate</a>";
						$valDiv = '';
					} else {
						$getGTEList2 .= '<input type="file" name="' . $doc_filled_name . '" class="form-control form-control-sm upload-image' . $snoRefA . '" />';
					}


					if ($contentDiv == 'Enrollment Letter') {

						$getGTEList2 .= '</div><div class="preview' . $snoRefA . '"></div>';
					} elseif ($contentDiv == 'Contract Letter') {

						$getGTEList2 .= '<input type="hidden" name="stuid" value="' . $stuid . '"><input type="hidden" name="doc_filled_name" value="' . $doc_filled_name . '">
						<input type="hidden" name="content_doc" value="' . $contentDiv . '"><input type="hidden" name="preview_div" value="' . $snoRefA . '"></div></div><div class="preview' . $snoRefA . '"><div class="col-sm-3"><div class="preview"><b>Update On :</b> ' . $timeDiv . '</div></div></div><div class="col-sm-3"><input type="file" name="' . $doc_filled_name . '" class="form-control form-control-sm upload-image' . $snoRefA . '" /><div class="preview"><b>Remarks :</b> ' . $remarksDiv . '</div></div>';
					} else {

						$getGTEList2 .=  '<input type="hidden" name="stuid" value="' . $stuid . '"><input type="hidden" name="doc_filled_name" value="' . $doc_filled_name . '">
						<input type="hidden" name="content_doc" value="' . $contentDiv . '"><input type="hidden" name="preview_div" value="' . $snoRefA . '"></div><div class="preview' . $snoRefA . '">' . $valDiv . '<div class="col-sm-3"><div class="preview"><b>Update On :</b> ' . $timeDiv . '</div></div></div><div class="col-sm-3"><div class="preview"><b>Remarks :</b> ' . $remarksDiv . '</div></div>';
					}


					$getGTEList2 .=  '<div class="col-sm-12"><div class="progress progressDiv' . $snoRefA . '" style="display:none"><div class="progress-bar progress-bar-success progress-bar-striped pbClass' . $snoRefA . '" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0%">0%</div></div></div></form></td></tr>';
				}


				echo $getGTEList2 .= '</table></div></div></div></div></div>';


?>
				<script src="../js/jquery.form.min.js"></script>

				<?php

				$resultRefA1 = mysqli_query($con, "SELECT * FROM `documents_name` where status='1'");
				while ($rowRefA1 = mysqli_fetch_assoc($resultRefA1)) {
					$snoRefA1 = mysqli_real_escape_string($con, $rowRefA1['doc_id']);
					$contentDiv1 = mysqli_real_escape_string($con, $rowRefA1['content']);
					$doc_filled_name1 = mysqli_real_escape_string($con, $rowRefA1['doc_filled_name']);

				?>
					<script>
						var progressbar = $('.pbClass<?php echo $snoRefA; ?>');
						$(".upload-image<?php echo $snoRefA1; ?>").on('change', function() {
							var idproof<?php echo $snoRefA1; ?>_image = this.files[0].size;
							if (idproof<?php echo $snoRefA1; ?>_image <= '5242880') {
								$(".form-horizontal-docu-<?php echo $snoRefA1; ?>").ajaxForm({
									target: '.preview<?php echo $snoRefA1; ?>',
									beforeSend: function() {
										$('.preview<?php echo $snoRefA1; ?>').show();
										$(".progressDiv<?php echo $snoRefA1; ?>").css("display", "block");
										progressbar.width('0%');
										progressbar.text('0%');
									},
									uploadProgress: function(event, position, total, percentComplete) {
										progressbar.width(percentComplete + '%');
										progressbar.text(percentComplete + '%');
										if (percentComplete == '100') {
											$('.progressDiv<?php echo $snoRefA1; ?>').hide();
											$('.upload-image<?php echo $snoRefA1; ?>').val('');
										} else {
											$('.progressDiv<?php echo $snoRefA1; ?>').show();
										}
									},
								}).submit();
							} else {
								alert('File too large. File must be less than 2 MB.');
								return false;
							}
						});
					</script>

<?php

				}
			} else {
				header('Location: ../logout.php');
				exit;
			}
		} else {
			header('Location: index.php');
		}
	} else {
		header('Location: index.php');
		exit;
	}
} else {
	header('Location: ../login.php');
}
?>