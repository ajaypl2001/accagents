<?php
ob_start();
include("../../db.php");

echo 'Agent Name' . "\t" . 'Name Of Student' . "\t" . 'Ref. Id' . "\t" . 'DOB' . "\t" . 'Contact No' . "\t" . 'E-mail Id' . "\t" . 'Course' .  "\t" . 'Start Date' .  "\t" . 'Date Of VG' .  "\t" . 'CAD' .  "\t" . 'INR' .  "\t" . 'TT Done-Amount' .  "\t" . 'Total Amount Recieved' .  "\t" . 'Pending' .  "\t" . 'TT-Verified' .  "\t" . 'File No' .  "\t" . 'DocuSign Sent' .  "\t" . 'DocuSign(Complete Yes/No)' .  "\t" . 'Student Travelled' .  "\t" . 'Any Issue during travel' .  "\t" . 'Last Remarks' .  "\t" . 'Recived Amt1' .  "\t" . 'Followup Status1' .  "\t" . 'Remarks1' .  "\t" . 'Recived Amt2' .  "\t" . 'Followup Status2' .  "\t" . 'Remarks2' .  "\t" . 'Recived Amt3' .  "\t" . 'Followup Status3' .  "\t" . 'Remarks3' .  "\t" . 'Recived Amt4' .  "\t" . 'Followup Status4' .  "\t" . 'Remarks4' .  "\t" . 'Recived Amt5' .  "\t" . 'Followup Status5' .  "\t" . 'Remarks5' . "\n";



if (isset($_GET['sts']) == 'Followup') {
    $rsltQuery = "SELECT * FROM st_application INNER JOIN vg_payment ON st_application.sno = vg_payment.st_app_id where st_application.v_g_r_status='V-G' ";
} else {
    $rsltQuery = "SELECT * FROM st_application where v_g_r_status='V-G'";
   
}


 $qurySql = mysqli_query($con, $rsltQuery);
while ($row_nm = mysqli_fetch_assoc($qurySql)) {
    $snoid = $row_nm["sno"];
    $agent_name = $row_nm["agent_name"];
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

    $check_exits = "SELECT * FROM vg_payment WHERE st_app_id = '$snoid'";
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
        $tot_amt = " ";
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



    $logs_data = ' ';
    $getQry = "SELECT * FROM vg_payment_logs where st_app_id='$snoid' ORDER BY id ASC LIMIT 5";
    $rsltLogs = mysqli_query($con, $getQry);
    if (mysqli_num_rows($rsltLogs)) {
        while ($row_nm2 = mysqli_fetch_assoc($rsltLogs)) {
            $amt_rec = mysqli_real_escape_string($con, $row_nm2["amt_rec"]);
            $follow_sts = mysqli_real_escape_string($con, $row_nm2["follow_sts"]);
            $followup_date = mysqli_real_escape_string($con, $row_nm2["followup_date"]);
            $remarks = mysqli_real_escape_string($con, $row_nm2["remarks"]);

            if ($follow_sts == 'followup') {
                $follow_sts = $follow_sts . " (" . $followup_date . ")";
            }

            $logs_data .=  " \t $amt_rec \t $follow_sts \t $remarks";
        }
    } else {
        $logs_data .= '';
    }

    echo $agent_name . "\t" . $fullname . "\t" . $refid . "\t" . $dob . "\t" . $mobile . "\t" . $email_address . "\t" . $prg_name1 . "\t" . $start_date . "\t" . $v_g_r_status_datetime . "\t" . $cad_amt . "\t" . $tot_amt . "\t" . $tt_amt . "\t" . $total_amt_rec . "\t" . $amt_pending . "\t" . $tt_verified . "\t" . $fileno . "\t" . $docusign_sent . "\t" . $docu_sign . "\t" . $stud_travelled . "\t" . $travel_issue . "\t" . $last_remarks . $logs_data . "\n";
}
header("Content-disposition: attachment; filename=Accounts_Sheet.xls");
