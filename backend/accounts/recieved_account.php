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
       header("Location: recieved_account.php?getsearch=$search&page_no=1");
   }
   
   $viewAdminAccess = "SELECT * FROM `admin_access` where admin_id='$sessionid1'";
   $resultViewAdminAccess = mysqli_query($con, $viewAdminAccess);
   
   if (mysqli_num_rows($resultViewAdminAccess)) {
       $rowsViewAdminAccess = mysqli_fetch_assoc($resultViewAdminAccess);
       $viewName = $rowsViewAdminAccess["name"];
       $viewEmailId = $rowsViewAdminAccess["email_id"];
       $viewAdminId = $rowsViewAdminAccess["admin_id"];
   } else {
       $viewName = "";
       $viewEmailId = "";
       $viewAdminId = "";
   }
   
   if (mysqli_num_rows($resultViewAdminAccess) && $email2323 == $viewEmailId) {
       $getAgentsId = "SELECT sno FROM allusers where role='Agent' AND created_by_id!='' AND created_by_id = '$viewAdminId'";
       $resultAgentsId = mysqli_query($con, $getAgentsId);
   
       if (mysqli_num_rows($resultAgentsId)) {
           while ($resultAgentsRows = mysqli_fetch_assoc($resultAgentsId)) {
               $userSno[] = $resultAgentsRows["sno"];
           }
           $getAccessid = implode("','", $userSno);
           $agent_id_not_show2 = "'$getAccessid'";
           $agent_id_not_show = "AND (st_application.user_id IN ($agent_id_not_show2) OR (st_application.app_show='$viewName'))";
       } else {
           $agent_id_not_show = "AND (st_application.user_id IN (NULL) OR (st_application.app_show='$viewName'))";
       }
   } else {
       $agent_id_not_show = "";
   }
   
   if ($roles1 == "Admin") { ?>
<link rel="stylesheet" href="../../css/sweetalert.min.css">
<script src="../../js/sweetalert.min.js"></script>
<section class="container-fluid">
   <div class="main-div">
      <div class=" admin-dashboard">
         <div class="row ">
            <div class="col-sm-4 col-lg-7">
               <h3 class="ml-4 mt-2">VG Lists Recieved Amount</h3>
            </div>
            <div class="col-sm-8 col-lg-5">
               <form action="" method="post" autocomplete="off" class="row mt-2 justify-content-end">
                  <div class="col-12 text-right">
                     <input type="text" name="inputval" placeholder="Search By Stu. Name or Ref Id" class="searchbtn_btn ui-autocomplete-input form-control-sm" required>
                     <input type="submit" name="srchClickbtn" class="srchClickbtn btn btn-primary" style="margin-top: -3px;" value="Search">
                  </div>
               </form>
            </div>
            <div class="col-sm-12">
               <form action="vg_payment_export.php?sts=Followup" method="post" class="float-right ml-2">
                  <button type="submit" name="exportbtn" class="btn btn-golden vg-export">Export Excel</button>
               </form>
            </div>
            <div class="col-12">
               <div class="table-responsive">
                  <table class="table table-sm table-bordered" width="100%">
                     <thead>
                        <tr>
                           <th>Agent Name</th>
										<th>Name Of<br>Student</th>
										<th>Ref. Id</th>
										<th>Course</th>
										<th>Start Date</th>
										<th>Date of VG</th>
										<th>Docu<br>Sign</th>
										<th>Student<br>Travelled</th>
										<th>Total</th>
										<th>Recieved</th>
										<th>Pending</th>
										<th>FollowUp<br>Date</th>
										<th>Last Remarks</th>
										<th>Updated On</th>
										<th>Action</th>
										<th>View Details</th>
                        </tr>
                     </thead>
                     <tbody class="list_follow">
                        <?php
                           if (isset($_GET["getsearch"]) && $_GET["getsearch"] != "") {
                               $searchTerm = $_GET["getsearch"];
                               $searchInput =
                                   "AND (CONCAT(st_application.fname,  ' ', st_application.lname) LIKE '%" .
                                   $searchTerm .
                                   "%' OR refid LIKE '%" .
                                   $searchTerm .
                                   "%')";
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
                               "SELECT COUNT(*) As total_records FROM `st_application`  INNER JOIN `vg_payment` ON st_application.sno = vg_payment.st_app_id
                           where st_application.v_g_r_status='V-G' $agent_id_not_show $searchInput"
                           );
                           $total_records = mysqli_fetch_array($result_count);
                           $total_records = $total_records["total_records"];
                           $total_no_of_pages = ceil($total_records / $total_records_per_page);
                           $second_last = $total_no_of_pages - 1;
                           // total page minus 1
                           $rsltQuery = "SELECT * FROM st_application where v_g_r_status='V-G' $agent_id_not_show $searchInput LIMIT $offset, $total_records_per_page";
                           $qurySql = mysqli_query($con, $rsltQuery);
                           while ($row_nm = mysqli_fetch_assoc($qurySql)) {
                           
                               $sno = $row_nm["sno"];
                               $sno_encode = base64_encode($sno);
                               $refid = $row_nm["refid"];
                           $prg_name1 = $row_nm["prg_name1"];
                               $prg_intake = $row_nm["prg_intake"];
                               $v_g_r_status_datetime = $row_nm["v_g_r_status_datetime"];
                               
                               $action1 = "<a href='javascript:void(0)' class='btn btn-sm btn-warning add_amt' data-target='#addAmount' data-toggle='modal' data-id='$sno'>Add Amount</a>";
                               $studentname = $row_nm["fname"] . " " . $row_nm["lname"];
                               $agent_name = $row_nm["agent_name"];
                              
                           $course_dtls = "SELECT * FROM contract_courses WHERE intake = '$prg_intake' AND program_name = '$prg_name1' ";
                           $course_res = mysqli_query($con,$course_dtls);
                           $course_row = mysqli_fetch_assoc($course_res);
                           $start_date = $course_row['commenc_date'];
                           
                           
                               $check_exits = "SELECT * FROM vg_payment WHERE st_app_id = '$sno'";
                               $check_res = mysqli_query($con, $check_exits);
                           $stud_travelled = '';
                           $docu_sign = '';
                               if (mysqli_num_rows($check_res) > 0) {
                                   $check_row = mysqli_fetch_assoc($check_res);
                                   $tot_amt = $check_row["tot_amt"];
                                   $amt_pending = $check_row["amt_pending"];
                                   $amt_rec = $check_row["amt_rec"];
                                   $total_amt_rec = $check_row["total_amt_rec"];
                                   $updated_date = $check_row["updated_date"];
                                   $last_remarks = $check_row["remarks"];
                                   $follow_sts = $check_row["follow_sts"];
                                   $followup_date = $check_row["followup_date"];
                                   $docu_sign = $check_row["docu_sign"];
                                   $stud_travelled = $check_row["stud_travelled"];
                           
                                   $followup_date = $check_row["followup_date"];
                           
                           
                                  if($follow_sts == 'followup' ){
                           $follow_sts =   $follow_sts . " " . $followup_date;
                           }
                           if($docu_sign == '' ){
                           $docu_sign = '';
                           }
                           if($stud_travelled == '' ){
                           $stud_travelled = '';
                           }
                           
                           $action1 = "<a href='javascript:void(0)' class='btn btn-sm btn-success add_amt' data-target='#addAmount' data-toggle='modal' data-id='$sno'>Add Amount</a>"; ?>
                        <tr>
                           <td style="white-space: normal;"><?php echo $agent_name; ?></td>
								<td style="white-space: normal;"><?php echo $studentname; ?></td>
								<td style="white-space: normal;"><?php echo $refid; ?></td>
								<td style="white-space: normal;"><?php echo $prg_name1; ?></td>
								<td><?php echo $start_date; ?></td>
								<td><?php echo str_replace(" ","<br>",$v_g_r_status_datetime); ?></td>
								<td><?php echo $docu_sign; ?></td>
								<td><?php echo $stud_travelled; ?></td>
								<td><?php echo $tot_amt; ?></td>
								<td style="color:green;"><?php echo $total_amt_rec; ?></td>
								<td style="color:red;"><?php echo $amt_pending; ?></td>
								<td style="white-space: normal;"><?php echo $follow_sts; ?></td>
								<td><?php echo $last_remarks; ?></td>
								<td><?php echo str_replace(" ","<br>",$updated_date); ?></td>
								<td><?php echo $action1; ?></td>
								<td><a href='stud_details.php?idno=<?php echo $sno_encode; ?>' class='btn btn-sm btn-info' >View Profile</a></td>
                        </tr>
                        <?php
                           }
                           
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
   </div>
   </div>
   </div>
</section>
<div class="modal fade main-modal" id="addAmount" role="dialog">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title">Payment Recieved For <b><?php echo $studentname; ?></b></h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
         </div>
         <div class="modal-body">
            <div class="loading_icon"></div>
            <div class="form_div"></div>
            <div class="table-responsive">
               <table class="table table-sm table-bordered">
                  <thead>
                     <tr>
                        <th>Sno.</th>
                        <th>Recieved</th>
                        <th>FollowUp Status</th>
                        <th>FollowUp Date</th>
                        <th>Remarks</th>
                        <th>Updated On</th>
                        <th>Updated By</th>
                     </tr>
                  </thead>
                  <tbody class="total_amt_rec"></tbody>
               </table>
            </div>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
         </div>
      </div>
   </div>
</div>
<style>
   .vg-export { padding:3px 10px; font-size:13px;color:#fff !important; }
</style>
<script>
   $(document).on('click', '.add_amt', function() {
   	var id = $(this).attr('data-id');
   	$('.loading_icon').show();
   	$.post("../response.php?tag=recievedElement", {
   		"idno": id
   	}, function(d) {
   		if (d == "") {
   			$('.total_amt_rec').html(" ");
   			$('.loading_icon').hide();
   		} else {
   			$('.total_amt_rec').html(" ");
   			for (i in d) {
   				$('<tr>' +
   					'<td>' + d[i].sno + '</td>' +
   					'<td>' + d[i].amt_rec + '</td>' +
   					'<td>' + d[i].follow_sts + '</td>' +
   					'<td>' + d[i].followup_date + '</td>' +
   					'<td>' + d[i].remarks + '</td>' +
   					'<td>' + d[i].updated_date + '</td>' +
   					'<td>' + d[i].updated_by + '</td>' +
   
   					'</tr>').appendTo(".total_amt_rec");
   			}
   		}
   		$('.loading_icon').hide();
   	});
   });
</script>
<script>
   $(document).on('click', '.add_amt', function() {
   	var id = $(this).attr('data-id');
   	username = '<?php echo $username; ?>'
   	$.post("../response.php?tag=fetchForm", {
   		"idno": id,
   		"username": username
   	}, function(d) {
   		if (d == "") {
   			alert('something went wrong');
   		} else {
   			$('.form_div').html(" ");
   			$('.form_div').html(d);
   
   
   		}
   		$(function() {
   			$(".date_followup").datepicker({
   				dateFormat: 'yy-mm-dd',
   				changeMonth: false,
   				changeYear: false,
   			});
   		});
   
   	});
   });
</script>
<script>
   function getval(sel) {
   	val = sel.value;
   	if (val == 'followup') {
   		$("#followup_date").show();
   	} else {
   		$("#followup_date").hide();
   	}
   }
   
   function tt_sts_val(sel) {
   	tt_val = sel.value;
   	if (tt_val == 'yes') {
   		$("#tt_amt").show();
   	} else {
   		$("#tt_amt").hide();
   	}
   }
   
   function travel_sts(sel) {
   	travel_val = sel.value;
   	if (travel_val == 'yes') {
   		$("#travel_issue_div").show();
   	} else {
   		$("#travel_issue_div").hide();
   	}
   }
</script>
<?php include "../../footer.php";} else {header("Location: ../../login");
   exit();}
   ?>