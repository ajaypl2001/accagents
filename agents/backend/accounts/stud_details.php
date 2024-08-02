<?php
   ob_start();
   include("../../db.php");
   include("../../header_navbar.php");
   
   if (!isset($_SESSION['sno'])) {
       header("Location: ../../login");
       exit();
   }
   
   if (!empty($_GET['idno'])) {
   
       $sno_decode = $_GET['idno'];
       $sno = base64_decode($sno_decode);
       $rsltQuery = "SELECT * FROM st_application where v_g_r_status='V-G' AND sno = '$sno' ";
       $qurySql = mysqli_query($con, $rsltQuery);
       $row_nm = mysqli_fetch_assoc($qurySql);
   
       $agent_name = $row_nm["agent_name"];
       $student_id = $row_nm["student_id"];
       $refid = $row_nm["refid"];
       $email_address = $row_nm["email_address"];
       $fname = $row_nm["fname"];
       $lname = $row_nm["lname"];
       $fullname = $fname . " " . $lname;
       $mobile = $row_nm["mobile"];
       $dob = $row_nm["dob"];
       $prg_name1 = $row_nm["prg_name1"];
       $prg_intake = $row_nm["prg_intake"];
       $v_g_r_status_datetime = $row_nm["v_g_r_status_datetime"];
   
       //////start date //////        
       $course_dtls = "SELECT * FROM contract_courses WHERE intake = '$prg_intake' AND program_name = '$prg_name1' ";
       $course_res = mysqli_query($con, $course_dtls);
       $course_row = mysqli_fetch_assoc($course_res);
       $start_date = $course_row['commenc_date'];
       /////end ///////////
   
       $check_exits = "SELECT * FROM vg_payment WHERE st_app_id = '$sno'";
       $check_res = mysqli_query($con, $check_exits);
   
       if (mysqli_num_rows($check_res) > 0) {
           $check_row = mysqli_fetch_assoc($check_res);
   
           $tot_amt = $check_row["tot_amt"];
           $amt_pending = $check_row["amt_pending"];
           $amt_rec = $check_row["amt_rec"];
           $total_amt_rec = $check_row["total_amt_rec"];
           $last_remarks = $check_row["remarks"];
           $strt_date = $check_row["strt_date"];
           $date_of_vg = $check_row["date_of_vg"];
           $cad_amt = $check_row["cad_amt"];
           $docusign_sent = $check_row["docusign_sent"];
           $tt_amt = $check_row["tt_amt"];
           $tt_verified = $check_row["tt_verified"];
           $fileno = $check_row["fileno"];
           $docu_sign = $check_row["docu_sign"];
           $stud_travelled = $check_row["stud_travelled"];
           $travel_issue = $check_row["travel_issue"];
       } else {
            $tot_amt = "";
           $amt_pending = "";
           $amt_rec = "";
           $total_amt_rec = "";
           $last_remarks = "";
           $strt_date = "";
           $date_of_vg = "";
           $cad_amt = "";
           $docusign_sent = "";
           $tt_amt = "";
           $tt_verified = "";
           $fileno = "";
           $docu_sign = "";
           $stud_travelled = "";
           $travel_issue = "";
       }
   
   ?>
<div class="loading_icon"></div>
<div class="main-div">
   <div class="container vertical_tab">
      <div class="row">
         <div class="col-md-12 col-lg-10 offset-lg-1">
            <div class="tab-content">
               <form action="../mysqldb.php" method="post" autocomplete="off" enctype="multipart/form-data">
                  <div class="col-sm-12">
                     <h3>
                        <center><b><u>Student Profile</u></b></center>
                     </h3>
                  </div>
                  <div class="col-sm-12">
                     <div class="row">
                        <div class="col-sm-6 form-group">
                           <label>Agent Name:</label>
                           <div class="input-group">
                              <span class="input-group-addon" id="icon"><i class="fas fa-user"></i></span>
                              <input type="text" name="agent_name" class="form-control" value="<?php echo $agent_name; ?>" readonly>
                           </div>
                        </div>
                        <div class="col-sm-6 form-group">
                           <label>Student Name:</label>
                           <div class="input-group">
                              <span class="input-group-addon" id="icon"><i class="fas fa-user"></i></span>
                              <input type="text" name="agent_name" class="form-control" value="<?php echo $fullname; ?>" readonly>
                           </div>
                        </div>
                        <div class="col-sm-6 form-group">
                           <label>Refrence ID:</label>
                           <div class="input-group">
                              <span class="input-group-addon" id="icon"><i class="fas fa-id-badge"></i></span>
                              <input type="text" name="agent_name" class="form-control" value="<?php echo $refid; ?>" readonly>
                           </div>
                        </div>
                        <div class="col-sm-6 form-group">
                           <label>D.O.B:</label>
                           <div class="input-group">
                              <span class="input-group-addon" id="icon"><i class="fas fa-calendar"></i></span>
                              <input type="text" name="agent_name" class="form-control" value="<?php echo $dob; ?>" readonly>
                           </div>
                        </div>
                        <div class="col-sm-6 form-group">
                           <label>Contact No:</label>
                           <div class="input-group">
                              <span class="input-group-addon" id="icon"><i class="fas fa-mobile-alt"></i></span>
                              <input type="text" name="agent_name" class="form-control" value="<?php echo $mobile; ?>" readonly>
                           </div>
                        </div>
                        <div class="col-sm-6 form-group">
                           <label>E-mail Id:</label>
                           <div class="input-group">
                              <span class="input-group-addon" id="icon"><i class="fas fa-envelope"></i></span>
                              <input type="text" name="agent_name" class="form-control" value="<?php echo $email_address; ?>" readonly>
                           </div>
                        </div>
                        <div class="col-sm-6 form-group">
                           <label>Course:</label>
                           <div class="input-group">
                              <span class="input-group-addon" id="icon"><i class="fas fa-graduation-cap"></i></span>
                              <input type="text" name="agent_name" class="form-control" value="<?php echo $prg_name1; ?>" readonly>
                           </div>
                        </div>
                        <div class="col-sm-6 form-group">
                           <label>Start Date:</label>
                           <div class="input-group">
                              <span class="input-group-addon" id="icon"><i class="fas fa-calendar"></i></span>
                              <input type="text" name="agent_name" class="form-control" value="<?php echo $start_date; ?>" readonly>
                           </div>
                        </div>
                        <div class="col-sm-6 form-group">
                           <label>Date of VG:</label>
                           <div class="input-group">
                              <span class="input-group-addon" id="icon"><i class="fas fa-calendar"></i></span>
                              <input type="text" name="agent_name" class="form-control" value="<?php echo $v_g_r_status_datetime; ?>" readonly>
                           </div>
                        </div>

                        <div class="col-sm-6 form-group">
                           <label>$CAD(In $dollar):</label>
                           <div class="input-group">
                              <span class="input-group-addon" id="icon"><i class="fas fa-coins"></i></span>
                              <input type="text" name="cad_amt" class="form-control" value="<?php echo $cad_amt; ?>" readonly>
                           </div>
                        </div>

                        <div class="col-sm-6 form-group">
                           <label>Total Amount( In INR):</label>
                           <div class="input-group">
                              <span class="input-group-addon" id="icon"><i class="fas fa-coins"></i></span>
                              <input type="text" name="tot_amt" class="form-control" value="<?php echo $tot_amt; ?>" readonly>
                           </div>
                        </div>



                        <div class="col-sm-6 form-group">
                           <label>TT- Amount(In $dollar):</label>
                           <div class="input-group">
                              <span class="input-group-addon" id="icon"><i class="fas fa-coins"></i></span>
                              <input type="text" name="tt_amt" class="form-control" value="<?php echo $tt_amt; ?>" readonly>
                           </div>
                        </div>
                        <div class="col-sm-6 form-group">
                           <label>Total Amt To be Recieved(In INR):</label>
                           <div class="input-group">
                              <span class="input-group-addon" id="icon"><i class="fas fa-coins"></i></span>
                              <input type="text" name="total_amt_rec" class="form-control" value="<?php echo $total_amt_rec; ?>" readonly>
                           </div>
                        </div>
                        <div class="col-sm-6 form-group">
                           <label>Pending:</label>
                           <div class="input-group">
                              <span class="input-group-addon" id="icon"><i class="fas fa-coins"></i></span>
                              <input type="text" name="amt_pending" class="form-control" value="<?php echo $amt_pending; ?>" readonly>
                           </div>
                        </div>
                        <div class="col-sm-6 form-group">
                           <label>TT- Verified:</label>
                           <div class="input-group">
                              <span class="input-group-addon" id="icon"><i class="fas fa-check"></i></span>
                              <input type="text" name="tt_verified" class="form-control" value="<?php echo $tt_verified; ?>" readonly>
                           </div>
                        </div>
                        <div class="col-sm-6 form-group">
                           <label>File No:</label>
                           <div class="input-group">
                              <span class="input-group-addon" id="icon"><i class="fas fa-file"></i></span>
                              <input type="text" name="fileno" class="form-control" value="<?php echo $fileno; ?>" readonly>
                           </div>
                        </div>
                        <div class="col-sm-6 form-group">
                           <label>DocuSign:</label>
                           <div class="input-group">
                              <span class="input-group-addon" id="icon"><i class="fas fa-check"></i></span>
                              <input type="text" name="docu_sign" class="form-control" value="<?php echo $docu_sign; ?>" readonly>
                           </div>
                        </div>
                         <div class="col-sm-6 form-group">
                           <label>DocuSign Sent:</label>
                           <div class="input-group">
                              <span class="input-group-addon" id="icon"><i class="fas fa-check"></i></span>
                              <input type="text" name="docusign_sent" class="form-control" value="<?php echo $docusign_sent; ?>" readonly>
                           </div>
                        </div>
                        <div class="col-sm-6 form-group">
                           <label>Student Travelled:</label>
                           <div class="input-group">
                              <span class="input-group-addon" id="icon"><i class="fas fa-check"></i></span>
                              <input type="text" name="agent_name" class="form-control" value="<?php echo $stud_travelled; ?>" readonly>
                           </div>
                        </div>

<?php if($stud_travelled == 'yes'){ ?>
                        <div class="col-sm-6 form-group">
                           <label>Any Travel Issue:</label>
                           <div class="input-group">
                              <span class="input-group-addon" id="icon"><i class="fas fa-comment"></i></span>
                              <input type="text" name="agent_name" class="form-control" value="<?php echo $travel_issue; ?>" readonly>
                           </div>
                        </div>
<?php } ?>


                        <div class="col-sm-6 form-group">
                           <label>Remarks:</label>
                           <div class="input-group">
                              <span class="input-group-addon" id="icon"><i class="fas fa-comment"></i></span>
                              <input type="text" name="agent_name" class="form-control" value="<?php echo $last_remarks; ?>" readonly>
                           </div>
                        </div>
                     </div>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
</div>
<?php
   }
   ?>
<script>
   $(function() {
   
       $(".date_followup").datepicker({
   
           dateFormat: 'yy/mm/dd',
   
           changeMonth: false,
   
           changeYear: false,
   
       });
   
   });
</script>