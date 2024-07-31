<?php
ob_start();
include "../../db.php";
include "../../header_navbar.php";

if (!isset($_SESSION["sno"])) {
    header("Location: ../../login");
    exit();
}

if (isset($_POST["srchClickbtn"])) {
    $search = $_POST["inputval"];
    header("Location: pending_application.php?getsearch=$search&page_no=1");
}

?>
<section class="container-fluid">
    <div class="main-div">
        <div class=" admin-dashboard">
            <div class="row ">
                <div class="col-sm-4 col-lg-7">
                    <h3 class="ml-4 mt-2">Application Not Submitted Lists</h3>
                </div>
                <div class="col-sm-8 col-lg-5">
                    <form action="" method="post" autocomplete="off" class="row mt-2 justify-content-end">
                        <div class="col-12 text-right">
                            <input type="text" name="inputval" placeholder="Search By Stu. Name or Ref Id or phone" class="searchbtn_btn ui-autocomplete-input form-control-sm" required>
                            <input type="submit" name="srchClickbtn" class="srchClickbtn btn btn-primary" style="margin-top: -3px;" value="Search">
                        </div>
                    </form>
                </div>
                <div class="col-12">
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered" width="100%">
                            <thead>
                                <tr>
                                    <th>Agent<br>Name</th>
                                    <th>Name Of<br>Student</th>
                                    <th>Phone No</th>
                                    <th>E-mail</th>
                                    <th>Ref. Id</th>
                                    <th>Passport No</th>
                                    <th>Personal <br>Tab</th>
                                    <th>Academic <br>Tab</th>
                                    <th>Course <br>Tab</th>
                                    <th>FinalSubmit <br>Tab</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody class="list_follow">
                                <?php

                                if (isset($_GET["getsearch"]) && $_GET["getsearch"] != "") {
                                    $searchTerm = $_GET["getsearch"];
                                    $searchInput = "AND (CONCAT(fname,  ' ', lname) LIKE '%" .
                                        $searchTerm . "%' OR refid LIKE '%" . $searchTerm . "%' OR mobile LIKE '%" . $searchTerm . "%')";
                                    $search_url = "&getsearch=" . $searchTerm . "";
                                } else {
                                    $searchInput = "";
                                    $search_url = "";
                                }


                                if (isset($_GET["page_no"]) && $_GET["page_no"] != "") {
                                    $page_no = $_GET["page_no"];
                                } else {
                                    $page_no = 1;
                                }

                                $total_records_per_page = 30;
                                $offset = ($page_no - 1) * $total_records_per_page;
                                $previous_page = $page_no - 1;
                                $next_page = $page_no + 1;
                                $adjacents = "2";
                                $result_count = mysqli_query(
                                    $con,
                                    "SELECT COUNT(*) As total_records FROM `st_application` WHERE application_form =''  $searchInput"
                                );
                                $total_records = mysqli_fetch_array($result_count);
                                $total_records = $total_records["total_records"];
                                $total_no_of_pages = ceil($total_records / $total_records_per_page);
                                $second_last = $total_no_of_pages - 1;
                                // total page minus 1

                                $rsltQuery = "SELECT * FROM st_application where application_form =''  $searchInput ORDER BY sno DESC LIMIT $offset, $total_records_per_page";
                                $qurySql = mysqli_query($con, $rsltQuery);
                                while ($row_nm = mysqli_fetch_assoc($qurySql)) {

                                    $snoall = $row_nm["sno"];
                                    $sno_encode = base64_encode($snoall);
                                    $mobile = $row_nm["mobile"];
                                    $email_address = $row_nm["email_address"];
                                    $refid = $row_nm["refid"];
                                    $studentname = $row_nm["fname"] . " " . $row_nm["lname"];
                                    $agent_name = $row_nm["agent_name"];
                                    $passport_no = $row_nm["passport_no"];
                                    $personal_status = $row_nm["personal_status"];
                                    if ($personal_status == '1') {
                                        $personal_tab = "<p style='color:green;'>Complete</p>";
                                    } else {
                                        $personal_tab = "<p style='color:red;'>Pending</p>";
                                    }
                                    $academic_status = $row_nm["academic_status"];
                                    if ($academic_status == '1') {
                                        $academic_tab = "<p style='color:green;'>Complete</p>";
                                    } else {
                                        $academic_tab = "<p style='color:red;'>Pending</p>";
                                    }
                                    $course_status = $row_nm["course_status"];
                                    if ($course_status == '1') {
                                        $cource_tab = "<p style='color:green;'>Complete</p>";
                                    } else {
                                        $cource_tab = "<p style='color:red;'>Pending</p>";
                                    }

                                    $application_form = $row_nm["application_form"];
                                    if ($application_form == '1') {
                                        $application_form_tab = "<p style='color:green;'>Complete</p>";
                                    } else {
                                        $application_form_tab = "<p style='color:red;'>Pending</p>";
                                    }

									$qryCntRemarks = "SELECT sno FROM `application_remarks` where comments_color='#f9d5d5' AND app_id='$snoall'";
											$rsltCntRemarks = mysqli_query($con, $qryCntRemarks);
											if(mysqli_num_rows($rsltCntRemarks)){
												$myRemarksTotal = mysqli_num_rows($rsltCntRemarks);
											}else{
												$myRemarksTotal = '';
											}

                                ?>
                                    <tr>
                                        <td style="white-space: normal;"><?php echo $agent_name; ?></td>
                                        <td style="white-space: normal;"><?php echo $studentname; ?></td>
                                        <td><?php echo $mobile; ?></td>
                                        <td><?php echo $email_address; ?></td>
                                        <td><?php echo $refid; ?></td>
                                        <td><?php echo $passport_no; ?></td>
                                        <td><?php echo $personal_tab; ?></td>
                                        <td><?php echo $academic_tab; ?></td>
                                        <td><?php echo $cource_tab; ?></td>
                                        <td><?php echo $application_form_tab; ?></td>
                                        <td style="white-space:nowrap;">
		<span class="btn btn-sm jmjm" data-toggle="modal" title="View" data-target="#myModaljjjs" data-id="<?php echo $snoall; ?>"><i class="fas fa-eye" data-toggle="tooltip" data-placement="top" title="View Application"></i></span>&nbsp;<span class="btn btn-success btn-sm divAppRemarks" data-toggle="modal" data-target="#modalAppRemarks" data-id="<?php echo $snoall; ?>"><i class="far fa-comment-alt" data-toggle="tooltip" data-placement="top" title="Application Remarks"></i></span><span class="badge badge-pill badge-danger divAppRemarks-bdge"><?php echo $myRemarksTotal;?></span></td>

                                    </tr>
                                <?php
                                }


                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-8 mt-2 pl-3">
                    <strong>Total Records <?php echo $total_records; ?>, </strong>
                    <strong>Page <?php echo $page_no . " of " . $total_no_of_pages; ?></strong>
                </div>
                <div class="col-md-4 mt-2">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-end">
                            <li <?php if ($page_no <= 1) {
                                    echo "class='page-item disabled'";
                                } ?>>
                                <a <?php if ($page_no > 1) {
                                        echo "href='?page_no=$previous_page&getsearch=$search_url'";
                                    } ?> class='page-link'>Previous</a>
                            </li>
                            <?php if ($total_no_of_pages <= 10) {
                                for ($counter = 1; $counter <= $total_no_of_pages; $counter++) {
                                    if ($counter == $page_no) {
                                        echo "<li class='page-item active'><a class='page-link'>$counter</a></li>";
                                    } else {
                                        echo "<li class='page-item'><a href='?page_no=$counter&getsearch=$search_url' class='page-link'>$counter</a></li>";
                                    }
                                }
                            } elseif ($total_no_of_pages > 10) {
                                if ($page_no <= 4) {
                                    for ($counter = 1; $counter < 8; $counter++) {
                                        if ($counter == $page_no) {
                                            echo "<li class='page-item active'><a class='page-link'>$counter</a></li>";
                                        } else {
                                            echo "<li class='page-item'><a href='?page_no=$counter&getsearch=$search_url' class='page-link'>$counter</a></li>";
                                        }
                                    }
                                    echo "<li><a>...</a></li>";
                                    echo "<li><a href='?page_no=$second_last&getsearch=$search_url' class='page-link'>$second_last</a></li>";
                                    echo "<li><a href='?page_no=$total_no_of_pages&getsearch=$search_url' class='page-link'>$total_no_of_pages</a></li>";
                                } elseif ($page_no > 4 && $page_no < $total_no_of_pages - 4) {
                                    echo "<li class='page-item'><a href='?page_no=1&getsearch=$search_url' class='page-link'>1</a></li>";
                                    echo "<li class='page-item'><a href='?page_no=2&getsearch=$search_url' class='page-link'>2</a></li>";
                                    echo "<li class='page-item'><a class='page-link'>...</a></li>";
                                    for (
                                        $counter = $page_no - $adjacents;
                                        $counter <= $page_no + $adjacents;
                                        $counter++
                                    ) {
                                        if ($counter == $page_no) {
                                            echo "<li class='page-item active'><a class='page-link'>$counter</a></li>";
                                        } else {
                                            echo "<li class='page-item'><a href='?page_no=$counter&getsearch=$search_url' class='page-link'>$counter</a></li>";
                                        }
                                    }
                                    echo "<li class='page-item'><a class='page-link'>...</a></li>";
                                    echo "<li class='page-item'><a href='?page_no=$second_last&getsearch=$search_url' class='page-link'>$second_last</a></li>";
                                    echo "<li class='page-item'><a href='?page_no=$total_no_of_pages&getsearch=$search_url' class='page-link'>$total_no_of_pages</a></li>";
                                } else {
                                    echo "<li class='page-item'><a href='?page_no=1&getsearch=$search_url' class='page-link'>1</a></li>";
                                    echo "<li class='page-item'><a href='?page_no=2&getsearch=$search_url' class='page-link'>2</a></li>";
                                    echo "<li class='page-item'><a class='page-link'>...</a></li>";
                                    for (
                                        $counter = $total_no_of_pages - 6;
                                        $counter <= $total_no_of_pages;
                                        $counter++
                                    ) {
                                        if ($counter == $page_no) {
                                            echo "<li class='page-item active'><a class='page-link'>$counter</a></li>";
                                        } else {
                                            echo "<li class='page-item'><a href='?page_no=$counter&getsearch=$search_url' class='page-link'>$counter</a></li>";
                                        }
                                    }
                                }
                            } ?>
                            <li <?php if ($page_no >= $total_no_of_pages) {
                                    echo "class='page-item disabled'";
                                } ?>>
                                <a <?php if ($page_no < $total_no_of_pages) {
                                        echo "href='?page_no=$next_page&getsearch=$search_url'";
                                    } ?> class='page-link'>Next</a>
                            </li>
                            <?php if ($page_no < $total_no_of_pages) {
                                echo "<li class='page-item'><a href='?page_no=$total_no_of_pages&getsearch=$search_url' class='page-link'>Last &rsaquo;&rsaquo;</a></li>";
                            } ?>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
  
<div class="modal fade" id="myModaljjjs" role="dialog">
<div class="modal-dialog modal-lg">
<div class="modal-content">
<div class="modal-header">

<h4 class="modal-title">Student Application</h4>
<button type="button" class="close" data-dismiss="modal">&times;</button>
</div>
<div class="modal-body">
<div class="loading_icon"></div>
<div id="ldld"></div>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div></div>
</div>
</div>


<div class="modal" id="modalAppRemarks">
	<div class="modal-dialog modal-md">
		<div class="modal-content">

			<div class="modal-header">
				<h4 class="modal-title">Application Remarks</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>

			<div class="modal-body">
				<form method="post" class="form well-form" autocomplete="off" name="registerFrm" id="registerFrm">
					<div class="form-group">
						<textarea class="form-control" name="application_comments" id="application_comments" rows="5" placeholder="Enter Here..."></textarea>
					</div>
					<input type="hidden" name="application_id" class="appIdDiv" value="">
					<input type="hidden" name="sessionid" value="<?php echo $sessionid1; ?>">
					<input type="hidden" name="sessionname" value="<?php echo $username; ?>">
					<div class="form-group">
						<button type="submit" class="btn btn-sm btn-success float-right mt-2" id="queryStudentbtn">Submit</button>
					</div>
				</form>

				<div class="table-responsive">
					<table class="table table-hover table-bordered">
						<thead>
							<tr>
								<th>Remarks</th>
								<th>Updated By</th>
								<th>Updated at</th>
							</tr>
						</thead>
						<tbody class="applRemarks"></tbody>
					</table>
				</div>
			</div>

			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
			</div>

		</div>
	</div>
</div>

</div></div></div>
</section>
<script>
$(document).on('click', '.jmjm', function(){
	var ssss = $(this).attr('data-id');
	$('.loading_icon').show();
	$.post("../response.php?tag=fetch",{"idno":ssss},function(obj){		
		$('#ldld').html("");
		$('<div class="overclass">' +		
		'<div class="pd-detail">' +
		'<h3><strong>Personal Details</strong></h3>' +
		'<p><b>Role: </b>' + obj[0].app_by + '</p>' +
		'<p><b>Reference Id: </b>' + obj[0].refid + '</p>' +
		'<p><b>Full Name: </b>' + obj[0].fname +' '+ obj[0].lname + '</p>' +
		'<p><b>Email Addesss: </b>' + obj[0].email_address + '</p>' +
		'<p><b>Mobile Number: </b>' + obj[0].mobile + '</p>' +
		'<p><b>Gender: </b>' + obj[0].gender + '</p>' +
		'<p><b>Martial Status: </b>' + obj[0].martial_status + '</p>' +
		'<p><b>Date of Birth: </b>' + obj[0].dob + '</p>' +
		'<p><b>Passport Number: </b>' + obj[0].passport_no + '</p>' +
		'<p><b>Passport Issue Date: </b>' + obj[0].pp_issue_date + '</p>' +
		'<p><b>Passport Expiry Date: </b>' + obj[0].pp_expire_date + '</p>' +
		'<p><b>Address-1: </b>' + obj[0].address1 + '</p>' +
		'<p><b>Address-2: </b>' + obj[0].address2 + '</p>' +
		'<p><b>Country: </b>' + obj[0].country + '</p>' +
		'<p><b>State: </b>' + obj[0].state + '</p>' +
		'<p><b>City: </b>' + obj[0].city + '</p>' +
		'<p><b>PIN Code: </b>' + obj[0].pincode + '</p>' +
		'<p><b>Passport: </b>' + obj[0].idproof + '</p>' +
		'<p><b>Created Date: </b>' + obj[0].datetime + '</p>' +
		'</div>'+
		'<div class="pd-detail">' +
		'<h3><strong>Courses</strong></h3>' +
		'<p><b>Campus Name: </b>' + obj[0].campus + '</p>' +
		'<p><b>Program Name: </b>' + obj[0].prg_name1 + '</p>' +
		'<p><b>Intake: </b>' + obj[0].prg_intake + '</p>' +
		'</div>'+
		'<div class="pd-detail">' +
		'<h3><strong>Test Details</strong></h3>' +
		'<p><b>Test Details: </b>' + obj[0].englishpro + '</p>' +
		'<p>' + obj[0].ielts_pte_over + '</p>' +		
		'<p>' + obj[0].ielts_pte_not + '</p>' +		
		'<p>' + obj[0].ielts_pte_listening + '</p>' +		
		'<p>' + obj[0].ielts_pte_reading + '</p>' +		
		'<p>' + obj[0].ielts_pte_writing + '</p>' +		
		'<p>' + obj[0].ielts_pte_speaking + '</p>' +		
		'<p>' + obj[0].ielts_pte_date + '</p>' +		
		'<p>' + obj[0].ielts_pte_file + '</p>' +		
		'<p>' + obj[0].duolingo_div + '</p>' +		
		'<h3><strong>Academic Details</strong></h3>' +
		'<h5><strong>Education Details<span style="color:red;">*</span></strong></h5>' +
		'<p><b>Qualifications: </b>' + obj[0].qualification1 + '</p>' +
		'<p><b>Education Type: </b>' + obj[0].stream1 + '</p>' +
		'<p><b>Marks(%): </b>' + obj[0].marks1 + '</p>' +
		'<p><b>Passing Year: </b>' + obj[0].passing_year1 + '</p>' +
		'<p><b>University Country: </b>' + obj[0].unicountry1 + '</p>' +
		'<p><b>Upload Certificate: </b>' + obj[0].certificate1 + '</p>' +
		'<p><b>University Name: </b>' + obj[0].uni_name1 + '</p>' +
		'<h5><strong>Education Details</strong></h5>' +
		'<p><b>Qualifications: </b>' + obj[0].qualification2 + '</p>' +
		'<p><b>Education Type: </b>' + obj[0].stream2 + '</p>' +
		'<p><b>Marks(%): </b>' + obj[0].marks2 + '</p>' +
		'<p><b>Passing Year: </b>' + obj[0].passing_year2 + '</p>' +
		'<p><b>University Country: </b>' + obj[0].unicountry2 + '</p>' +
		'<p><b>Upload Certificate: </b>' + obj[0].certificate2 + '</p>' +
		'<p><b>University Name: </b>' + obj[0].uni_name2 + '</p>' +
		'<h5><strong>Education Details</strong></h5>' +
		'<p><b>Qualifications: </b>' + obj[0].qualification3 + '</p>' +
		'<p><b>Education Type: </b>' + obj[0].stream3 + '</p>' +
		'<p><b>Marks(%): </b>' + obj[0].marks3 + '</p>' +
		'<p><b>Passing Year: </b>' + obj[0].passing_year3 + '</p>' +
		'<p><b>University Country: </b>' + obj[0].unicountry3 + '</p>' +
		'<p><b>Upload Certificate: </b>' + obj[0].certificate3 + '</p>' +
		'<p><b>University Name: </b>' + obj[0].uni_name3 + '</p>' +
		'</div>'+
		'</div>').appendTo("#ldld");
		$('.loading_icon').hide();		
	});
});
</script>

<script>
	$('#queryStudentbtn').on('click', function(e) {
		$("#queryStudentbtn").attr("disabled", true);
		e.preventDefault();
		var getMsg = $('#application_comments').val();
		var appIdDiv = $('.appIdDiv').val();

		if (getMsg == "") {
			$('#application_comments').css({
				"border": "1px solid red"
			});
		}

		if (getMsg == "") {
			$("#queryMsg").attr("disabled", false);
			return false;
		}

		var $form = $(this).closest("#registerFrm");
		var formData = $form.serializeArray();
		var URL = "../response.php?tag=getInTouch";
		$.post(URL, formData).done(function(data) {
			if (data == 1) {
				alert('Successfully Added Your Remarks!!!');
				window.location.href = '?aid=error_' + appIdDiv + '';
				$("#registerFrm")[0].reset();
				$("#queryStudentbtn").attr("disabled", false);
				return false;
			}
		});

	});

	$(document).on('click', '.divAppRemarks', function() {
		$('.loading_icon').show();
		var app_id = $(this).attr('data-id');
		$('.appIdDiv').attr('value', app_id);
		$.post("../response.php?tag=appRemarkDiv", {
			"app_id": app_id
		}, function(d) {
			$(".applRemarks").html(" ");
			if (d == '') {
				$('<tr><td colspan="3"><center>Not Found!!!</center></td></tr>').appendTo(".applRemarks");
			} else {
				for (i in d) {
					$('<tr><td>' + d[i].application_comments + '</td><td>' + d[i].added_by_name + '</td><td>' + d[i].datetime_at + '</td></tr>').appendTo(".applRemarks");
				}
			}
			$('.loading_icon').hide();
		});
	});
</script>

<?php include "../../footer.php";
?>