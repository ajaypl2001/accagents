<?php
ob_start();
include ("../../db.php");
include ("../../header_navbar.php");
date_default_timezone_set("America/Toronto");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../vendor/autoload.php';
$mail = new PHPMailer(true);

// if($roles1 == 'ClgCM'){

// } else {
// 	header("Location: ../../login");
//     exit();
// }

if (isset($_POST['srchClickbtn'])) {
    $search = $_POST['inputval'];
    $intakeInput = $_POST['intakeInput'];
    $pNameInput = $_POST['pNameInput'];
    $getVGInput = $_POST['getVGInput'];
    $locationInput = $_POST['locationInput'];
    header("Location: ../campus/?getsearch=$search&getIntake=$intakeInput&getPName=$pNameInput&getVGDate=$getVGInput&getLocation=$locationInput&page_no=1");
}

if (isset($_GET['getsearch']) && $_GET['getsearch'] != "") {
    $searchTerm = $_GET['getsearch'];
    $searchInput = "AND (CONCAT(fname,  ' ', lname) LIKE '%" . $searchTerm . "%' OR refid LIKE '%" . $searchTerm . "%' OR passport_no LIKE '%" . $searchTerm . "%' OR student_id LIKE '%" . $searchTerm . "%')";
    $search_url = "&getsearch=" . $searchTerm . "";
} else {
    $searchInput = '';
    $search_url = '';
    $searchTerm = '';
}

if (!empty($_GET['getIntake'])) {
    $getIntake2 = $_GET['getIntake'];
    $getIntake3 = "AND prg_intake='$getIntake2'";
} else {
    $getIntake2 = '';
    $getIntake3 = '';
}

if (!empty($_GET['getLocation'])) {
    $getLocation2 = $_GET['getLocation'];
    $getLocation3 = "AND on_off_shore='$getLocation2'";
} else {
    $getLocation2 = '';
    $getLocation3 = '';
}

if (!empty($_GET['getVGDate'])) {
    $getVGDate2 = $_GET['getVGDate'];
    $getVGDate3 = "AND v_g_r_status_datetime LIKE '%$getVGDate2%'";
} else {
    $getVGDate2 = '';
    $getVGDate3 = '';
}

if (!empty($_GET['getPName'])) {
    $getPName2 = $_GET['getPName'];
    if ($getPName2 == 'Human Resources Management Speciality') {
        $getPName3 = "AND (prg_name1='Human Resources Management Speciality(1)' OR prg_name1='Human Resources Management Speciality(2)' OR prg_name1='Human Resources Management Speciality(3)' OR prg_name1='Human Resources Management Speciality(4)' OR prg_name1='Human Resources Management Speciality')";
    } elseif ($getPName2 == 'Healthcare Office Administration Diploma') {
        $getPName3 = "AND (prg_name1='Healthcare Office Administration Diploma(1)' OR prg_name1='Healthcare Office Administration Diploma(2)' OR prg_name1='Healthcare Office Administration Diploma(3)' OR prg_name1='Healthcare Office Administration Diploma(4)' OR prg_name1='Healthcare Office Administration Diploma')";
    } elseif ($getPName2 == 'Diploma in Hospitality Management') {
        $getPName3 = "AND (prg_name1='Diploma in Hospitality Management(1)' OR prg_name1='Diploma in Hospitality Management(2)' OR prg_name1='Diploma in Hospitality Management(3)' OR prg_name1='Diploma in Hospitality Management(4)' OR prg_name1='Diploma in Hospitality Management')";
    } elseif ($getPName2 == 'Business Administration Diploma') {
        $getPName3 = "AND (prg_name1='Business Administration Diploma(1)' OR prg_name1='Business Administration Diploma(2)' OR prg_name1='Business Administration Diploma(3)' OR prg_name1='Business Administration Diploma(4)' OR prg_name1='Business Administration Diploma')";
    } elseif ($getPName2 == 'Global Supply Chain Management Diploma') {
        $getPName3 = "AND (prg_name1='Global Supply Chain Management Diploma(1)' OR prg_name1='Global Supply Chain Management Diploma(2)' OR prg_name1='Global Supply Chain Management Diploma(3)' OR prg_name1='Global Supply Chain Management Diploma(4)' OR prg_name1='Global Supply Chain Management Diploma')";
    } else {
        $getPName3 = "AND prg_name1='$getPName2'";
    }
} else {
    $getPName2 = '';
    $getPName3 = '';
}

if (isset($_GET['page_no']) && $_GET['page_no'] != "") {
    $page_no = $_GET['page_no'];
} else {
    $page_no = 1;
}

$total_records_per_page = 110;
$offset = ($page_no - 1) * $total_records_per_page;
$previous_page = $page_no - 1;
$next_page = $page_no + 1;
$adjacents = "2";

$result_count = mysqli_query($con, "SELECT COUNT(*) As total_records FROM `both_main_table` where (v_g_r_status='V-G' OR (on_off_shore='Onshore' AND loa_file!='')) AND (STR_TO_DATE(prg_intake, '%b-%Y')) >= '2024-05-00' AND (tearcher_assign='' OR tearcher_assign='Completed') AND student_status!='' $searchInput $getIntake3 $getPName3 $getVGDate3 $getLocation3");
echo $total_records = mysqli_fetch_array($result_count);
$total_records = $total_records['total_records'];
$total_no_of_pages = ceil($total_records / $total_records_per_page);
$second_last = $total_no_of_pages - 1;

// $rsltQuery = "SELECT * FROM both_main_table where tearcher_assign_old='Yes' AND tearcher_assign_old!='' AND tearcher_assign='' $searchInput $getIntake3 $getPName3 $getVGDate3 $getLocation3 order by v_g_r_status_datetime DESC LIMIT $offset, $total_records_per_page";

$rsltQuery = "SELECT * FROM both_main_table where student_id!='' AND v_g_r_status='V-G' AND on_off_shore='Offshore'  $searchInput $getIntake3 $getPName3 $getVGDate3 $statusInput3 $statusInput3_cont $agentInput3 order by main_id DESC LIMIT $offset, $total_records_per_page";
$rsltQuery = "SELECT * FROM both_main_table where (v_g_r_status='V-G' OR (on_off_shore='Offshore')) AND (tearcher_assign='' OR tearcher_assign='Completed') AND (student_status!='' AND student_status!='Not started') $searchInput $getIntake3 $getPName3 $getVGDate3 $getLocation3 order by v_g_r_status_datetime DESC LIMIT $offset, $total_records_per_page";
?>
<style>
    .error_color {
        border: 2px solid #de0e0e;
    }

    .validError {
        border: 2px solid #ccc;
    }
</style>

<link rel="stylesheet" type="text/css" href="../../css/fixed-table.css">
<script src="../../js/fixed-table.js"></script>
<section class="container-fluid">
    <div class="main-div card">
        <div class="card-header">
            <h3 class="my-0 py-0">Student Lists - Assign to Instructor</h3>
        </div>
        <div class="card-body">
            <div class="row">

                <!-- <div class="col-sm-1 col-lg-1 mt-4 pt-2"> -->
                <!--form method="POST" action="excelSheet.php" autocomplete="off">
    <input type="hidden" name="role" value="<?php //echo 'Student_Status'; ?>">
    <input type="hidden" name="keywordLists" value="<?php //echo $searchTerm; ?>">
    <input type="hidden" name="intakeInput" value="<?php //echo $getIntake2; ?>">
    <input type="hidden" name="pNameInput" value="<?php //echo $getPName2; ?>">
    <button type="submit" name="studentlist" class="btn btn-sm btn-success float-right" >Download Excel</button>
</form-->
                <!-- </div> -->

                <form action="" method="post" autocomplete="off" class=" col-lg-9">
                    <div class="row">
                        <div class="col-sm-6 col-lg-3 mb-3">
                            <label><b>Program Name:</b></label>
                            <div class="input-group input-group-sm">
                                <select name="pNameInput" class="form-control">
                                    <option value="">Filter by Program</option>
                                    <option value="">All</option>
                                    <?php
                                    $rsltQuery6 = "SELECT * FROM contract_courses GROUP BY program_name";
                                    $qurySql6 = mysqli_query($con, $rsltQuery6);
                                    while ($row_nm6 = mysqli_fetch_assoc($qurySql6)) {
                                        $program_name36 = $row_nm6['program_name'];
                                        ?>
                                        <option value="<?php echo $program_name36; ?>" <?php if ($program_name36 == $getPName2) {
                                               echo 'selected="selected"';
                                           } ?>>
                                     <?php echo $program_name36; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <!-- <div class="col-sm-6 col-lg-2 mb-3">
                            <label><b>Location:</b></label>
                            <div class="input-group input-group-sm">
                                <select name="locationInput" class="form-control">
                                    <option value="">Select Location</option>
                                    <option value="">All</option>
                                    <option value="Offshore" <?php if ($getLocation2 == 'Offshore') {
                                        echo 'selected="selected"';
                                    } ?>>Offshore</option>
                                    <option value="Onshore" <?php if ($getLocation2 == 'Onshore') {
                                        echo 'selected="selected"';
                                    } ?>>Onshore</option>
                                </select>
                            </div>
                        </div> -->

                        <div class="col-lg-2 col-sm-6 mb-3">
                            <label><b>Intake:</b></label>
                            <div class="input-group input-group-sm">
                                <select name="intakeInput" class="form-control">
                                    <option value="">Select Intake</option>
                                    <option value="">All</option>
                                    <?php
                                    $rsltQuery5 = "SELECT intake FROM contract_courses WHERE program_name!='' AND (STR_TO_DATE(commenc_date, '%Y/%m/%d')) >= '2024/05/13' Group BY intake ORDER BY intake DESC";
                                    $qurySql5 = mysqli_query($con, $rsltQuery5);
                                    while ($row_nm5 = mysqli_fetch_assoc($qurySql5)) {
                                        $intake34 = $row_nm5['intake'];
                                        ?>
                                        <option value="<?php echo $intake34; ?>" <?php if ($intake34 == $getIntake2) {
                                               echo 'selected="selected"';
                                           } ?>><?php echo $intake34; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-2 col-sm-6 mb-3">
                            <label><b>VG Date:</b></label>
                            <div class="input-group input-group-sm">
                                <select name="getVGInput" class="form-control">
                                    <option value="">V-G Submit Date</option>
                                    <option value="">All</option>
                                    <?php
                                    $rsltQuery6_2 = "SELECT sno, v_g_r_status_datetime FROM both_main_table where v_g_r_status='V-G' AND (STR_TO_DATE(prg_intake, '%b-%Y')) >= '2024-05-00' Group BY DATE_FORMAT(v_g_r_status_datetime, '%Y-%m-%d') ORDER BY v_g_r_status_datetime DESC";
                                    $qurySql6_2 = mysqli_query($con, $rsltQuery6_2);
                                    while ($row_nm6_2 = mysqli_fetch_assoc($qurySql6_2)) {
                                        $intake36_2 = $row_nm6_2['v_g_r_status_datetime'];
                                        $intake36_3 = date('Y-m-d', strtotime("$intake36_2"));
                                        ?>
                                        <option value="<?php echo $intake36_3; ?>" <?php if ($intake36_3 == $getVGDate2) {
                                               echo 'selected="selected"';
                                           } ?>><?php echo $intake36_3; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-6 mb-3">
                            <label><b>Name & ID:</b></label>
                            <div class="input-group">
                                <input type="text" name="inputval" placeholder="Search By Stu. Name or ID"
                                    class="form-control form-control-sm" value="<?php echo $searchTerm; ?>">
                                <div class="input-group-append">
                                    <input type="submit" name="srchClickbtn" class="btn btn-sm btn-success"
                                        value="Search">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="col-12 col-lg-3 mt-lg-2 text-right">
                    <span class="btn btn-sm btn-danger float-right mt-sm-4 statusClass mb-2" data-toggle="modal"
                        data-target="#statusModal">Assign Student to Teacher</span>
                </div>

                <div class="col-12">
                    <div id="fixed-table-container-1" class="fixed-table-container">
                        <table class="table table-sm table-bordered" width="100%">
                            <thead>
                                <tr>
                                    <th style="padding: 6px 4px !important;">Assign <input name="product_all"
                                            class="checked_all" type="checkbox"></th>
                                    <th>Student Name</th>
                                    <th>Program Name</th>
                                    <th>vNumber</th>
                                    <th>Location</th>
                                    <th>Start Date(LOA)</th>
                                    <th>End Date(LOA)</th>
                                    <th>VG Date</th>
                                    <th>Status</th>
                                    <th>Status Submit Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $qurySql = mysqli_query($con, $rsltQuery);
                                if (mysqli_num_rows($qurySql)) {
                                    while ($row_nm = mysqli_fetch_assoc($qurySql)) {
                                        $snoid = $row_nm['sno'];
                                        $user_id = $row_nm['user_id'];
                                        $fname = $row_nm['fname'];
                                        $lname = $row_nm['lname'];
                                        $fullname = ucfirst($fname) . ' ' . ucfirst($lname);
                                        $refid = $row_nm['refid'];
                                        $student_id = $row_nm['student_id'];
                                        $email_address = $row_nm['email_address'];
                                        $prg_name1 = $row_nm['prg_name1'];
                                        $prg_intake = $row_nm['prg_intake'];
                                        $student_status = $row_nm['student_status'];
                                        $on_off_shore343 = $row_nm['on_off_shore'];
                                        $v_g_r_status_datetime = $row_nm['v_g_r_status_datetime'];
                                        $vgDate = date('Y-m-d', strtotime("$v_g_r_status_datetime"));

                                        $queryGet4 = "SELECT commenc_date, expected_date FROM `contract_courses` WHERE program_name='$prg_name1' AND intake='$prg_intake'";
                                        $queryRslt4 = mysqli_query($con, $queryGet4);
                                        $rowSC4 = mysqli_fetch_assoc($queryRslt4);
                                        $start_date = $rowSC4['commenc_date'];
                                        $expected_date = $rowSC4['expected_date'];

                                        $slctQry_23 = "SELECT email_address FROM international_airport_student where app_id='$snoid'";
                                        $checkQuery_23 = mysqli_query($con, $slctQry_23);
                                        if (mysqli_num_rows($checkQuery_23)) {
                                            $rowStartValue_33 = mysqli_fetch_assoc($checkQuery_23);
                                            $email_address_33 = $rowStartValue_33['email_address'];
                                        } else {
                                            $email_address_33 = '';
                                        }

                                        $queryGet2 = "SELECT sno, with_dism, datetime_at FROM `start_college` WHERE with_dism!='' AND app_id='$snoid' ORDER BY sno DESC";
                                        $queryRslt2 = mysqli_query($con, $queryGet2);
                                        if (mysqli_num_rows($queryRslt2)) {
                                            $rowSC = mysqli_fetch_assoc($queryRslt2);
                                            $with_dism2 = $rowSC['with_dism'];
                                            $datetime_atS = substr($rowSC['datetime_at'], 0, 10);
                                            if ($student_status == 'Dismissed' || $student_status == 'Withdrawal') {
                                                $with_dism = '<span style="color:red;">' . $with_dism2 . '</span>';
                                            } else {
                                                $with_dism = $with_dism2;
                                            }
                                        } else {
                                            $with_dism = '<span style="color:red;">Pending</span>';
                                            $datetime_atS = '';
                                        }
                                        ?>
                                        <tr>
                                            <td style="padding: 6px 4px !important; text-align: right;">
                                                <?php
                                                if ($student_status == 'Dismissed' || $student_status == 'Withdrawal') {

                                                } else {
                                                    ?>
                                                    <div class=" custom_check " id="cons_seen" name="submit">
                                                        <input type="checkbox" name="cons_seen" value="<?php echo $snoid; ?>"
                                                            v-no="<?php echo $student_id; ?>" class="checkbox cons_seen"
                                                            style="margin-left:auto; margin-right:auto;">
                                                    </div>
                                                <?php } ?>
                                            </td>
                                            <td style="white-space: nowrap;"><?php echo $fname . ' ' . $lname; ?></td>
                                            <td style="width:250px;"><?php echo $prg_name1; ?></td>
                                            <td style="white-space: nowrap;"><?php echo $student_id; ?></td>
                                            <td style="white-space: nowrap;"><?php echo $on_off_shore343; ?></td>
                                            <td style="white-space: nowrap;"><?php echo $start_date; ?></td>
                                            <td style="white-space: nowrap;"><?php echo $expected_date; ?></td>
                                            <td style="white-space: nowrap;"><?php echo $vgDate; ?></td>
                                            <td style="white-space: nowrap;"><?php echo $with_dism; ?></td>
                                            <td style="white-space: nowrap;"><?php echo $datetime_atS; ?></td>
                                        </tr>
                                    <?php }
                                } else {
                                    echo '<tr><td colspan="8"><center>Not Found!!!</center></td></tr>';
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
                            <?php // if($page_no > 1){ echo "<li><a href='?page_no=1'>First Page</a></li>"; } ?>

                            <li <?php if ($page_no <= 1) {
                                echo "class='page-item disabled'";
                            } ?>>
                                <a <?php if ($page_no > 1) {
                                    echo "href='?page_no=$previous_page&getsearch=$search_url&getIntake=$getIntake2'";
                                } ?>
                                    class='page-link'>Previous</a>
                            </li>

                            <?php
                            if ($total_no_of_pages <= 10) {
                                for ($counter = 1; $counter <= $total_no_of_pages; $counter++) {
                                    if ($counter == $page_no) {
                                        echo "<li class='page-item active'><a class='page-link'>$counter</a></li>";
                                    } else {
                                        echo "<li class='page-item'><a href='?page_no=$counter&getsearch=$search_url&getIntake=$getIntake2' class='page-link'>$counter</a></li>";
                                    }
                                }
                            } elseif ($total_no_of_pages > 10) {

                                if ($page_no <= 4) {
                                    for ($counter = 1; $counter < 8; $counter++) {
                                        if ($counter == $page_no) {
                                            echo "<li class='page-item active'><a class='page-link'>$counter</a></li>";
                                        } else {
                                            echo "<li class='page-item'><a href='?page_no=$counter&getsearch=$search_url&getIntake=$getIntake2' class='page-link'>$counter</a></li>";
                                        }
                                    }
                                    echo "<li><a>...</a></li>";
                                    echo "<li><a href='?page_no=$second_last&getsearch=$search_url&getIntake=$getIntake2' class='page-link'>$second_last</a></li>";
                                    echo "<li><a href='?page_no=$total_no_of_pages&getsearch=$search_url&getIntake=$getIntake2' class='page-link'>$total_no_of_pages</a></li>";
                                } elseif ($page_no > 4 && $page_no < $total_no_of_pages - 4) {
                                    echo "<li class='page-item'><a href='?page_no=1&getsearch=$search_url&getIntake=$getIntake2' class='page-link'>1</a></li>";
                                    echo "<li class='page-item'><a href='?page_no=2&getsearch=$search_url&getIntake=$getIntake2' class='page-link'>2</a></li>";
                                    echo "<li class='page-item'><a class='page-link'>...</a></li>";
                                    for ($counter = $page_no - $adjacents; $counter <= $page_no + $adjacents; $counter++) {
                                        if ($counter == $page_no) {
                                            echo "<li class='page-item active'><a class='page-link'>$counter</a></li>";
                                        } else {
                                            echo "<li class='page-item'><a href='?page_no=$counter&getsearch=$search_url&getIntake=$getIntake2' class='page-link'>$counter</a></li>";
                                        }
                                    }
                                    echo "<li class='page-item'><a class='page-link'>...</a></li>";
                                    echo "<li class='page-item'><a href='?page_no=$second_last&getsearch=$search_url&getIntake=$getIntake2' class='page-link'>$second_last</a></li>";
                                    echo "<li class='page-item'><a href='?page_no=$total_no_of_pages&getsearch=$search_url&getIntake=$getIntake2' class='page-link'>$total_no_of_pages</a></li>";
                                } else {
                                    echo "<li class='page-item'><a href='?page_no=1&getsearch=$search_url&getIntake=$getIntake2' class='page-link'>1</a></li>";
                                    echo "<li class='page-item'><a href='?page_no=2&getsearch=$search_url&getIntake=$getIntake2' class='page-link'>2</a></li>";
                                    echo "<li class='page-item'><a class='page-link'>...</a></li>";

                                    for ($counter = $total_no_of_pages - 6; $counter <= $total_no_of_pages; $counter++) {
                                        if ($counter == $page_no) {
                                            echo "<li class='page-item active'><a class='page-link'>$counter</a></li>";
                                        } else {
                                            echo "<li class='page-item'><a href='?page_no=$counter&getsearch=$search_url&getIntake=$getIntake2' class='page-link'>$counter</a></li>";
                                        }
                                    }
                                }
                            }
                            ?>
                            <li <?php if ($page_no >= $total_no_of_pages) {
                                echo "class='page-item disabled'";
                            } ?>>
                                <a <?php if ($page_no < $total_no_of_pages) {
                                    echo "href='?page_no=$next_page&getsearch=$search_url&getIntake=$getIntake2'";
                                } ?>
                                    class='page-link'>Next</a>
                            </li>
                            <?php if ($page_no < $total_no_of_pages) {
                                echo "<li class='page-item'><a href='?page_no=$total_no_of_pages&getsearch=$search_url&getIntake=$getIntake2' class='page-link'>Last &rsaquo;&rsaquo;</a></li>";
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

<div class="modal" id="statusModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Assign To Teacher</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form method="post" action="" autocomplete="off" name="assign_register" id="assign_register">
                    <div class="form-group">
                        <label>Select Batch Intake<span style="color:red;">*</span></label>
                        <select name="batch_intake" class="form-control batch_intake" required>
                            <option value="">Select Option</option>
                            <option value="May-2024">May-2024</option>
                            <option value="JAN-2024">JAN-2024</option>
                            <option value="OLD">OLD</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Select Batch<span style="color:red;">*</span></label>
                        <select name="batch_name" class="form-control batch_name getAssignTchrStdnt" intake-wise=""
                            required>
                            <option value="">Select Option</option>
                        </select>
                    </div>
                    <p class="showBatchLists"></p>
                    <input type="hidden" class="student_id" name="student_id" value="">
                    <input type="hidden" class="v_no" name="v_no" value="">
                    <button type="submit" name="assign_submit"
                        class="btn btn-sm btn-success assign_submit">Assign</button>
                </form>
            </div>
            <div class="modal-footer"></div>
        </div>
    </div>
</div>

<style type="text/css">
    .table thead th {
        vertical-align: middle;
    }

    .fixed-table-container th i {
        opacity: 0.5;
    }

    .fixed-table-container th {
        width: 100px;
    }

    .table.table-sm.table-bordered thead {
        position: relative !important;
        z-index: 999 !important;
    }

    .fixed-table-container {
        overflow: scroll;
    }

    .fixed-table-container tr:first-child th input[type=checkbox] {
        border: 3px solid #fff;
    }

    .fixed-table-container tr:first-child th {
        background: #333;
    }

    input[type=checkbox] {
        position: relative;
        border: 3px solid #000;
        border-radius: 2px;
        background: none;
        cursor: pointer;
        line-height: 0;
        margin: 0 0 0 0;
        outline: 0;
        padding: 0 !important;
        vertical-align: text-top;
        height: 25px;
        width: 25px;
        -webkit-appearance: none;
        opacity: .7;
    }

    input[type=checkbox]:hover {
        opacity: 1;
    }

    input[type=checkbox]:checked {
        background-color: #447d3a;
        opacity: 1;
        border: 3px solid #447d3a;
    }

    input[type=checkbox]:checked:before {
        content: '';
        position: absolute;
        right: 50%;
        top: 50%;
        width: 8px;
        height: 15px;
        border: solid #FFF;
        border-width: 0 4px 4px 0;
        margin: -1px -1px 0 -1px;
        transform: rotate(45deg) translate(-50%, -50%);
        z-index: 2;
    }
</style>

<script>
    $(document).ready(function () {
        $('.checked_all').on('change', function () {
            $('.checkbox').prop('checked', $(this).prop("checked"));

            var ctyArray1 = [];
            var ctyArray12 = [];
            $(".cons_seen:checked").each(function () {
                ctyArray1.push($(this).val());
                ctyArray12.push($(this).attr('v-no'));
            });
            var countryid1 = ctyArray1.join(',');
            var countryid12 = ctyArray12.join(',');
            $('.student_id').attr('value', countryid1);
            $('.v_no').attr('value', countryid12);
        });

        $('.checkbox').change(function () {
            if ($('.checkbox:checked').length == $('.checkbox').length) {
                $('.checked_all').prop('checked', true);
            } else {
                $('.checked_all').prop('checked', false);
            }
        });

        $('.cons_seen').on('click', function () {
            var ctyArray1 = [];
            var ctyArray12 = [];
            $(".cons_seen:checked").each(function () {
                ctyArray1.push($(this).val());
                ctyArray12.push($(this).attr('v-no'));
            });
            var countryid1 = ctyArray1.join(',');
            var countryid12 = ctyArray12.join(',');
            $('.student_id').attr('value', countryid1);
            $('.v_no').attr('value', countryid12);
        });
    });
</script>

<script>
    $(document).on('click', '.batch_intake', function () {
        var idmodel = $(this).val();
        $('.getAssignTchrStdnt').attr('intake-wise', idmodel);
        $('.showBatchLists').html("");
        $.post("response.php?tag=getIntkWise", { "intake": idmodel }, function (d) {
            $('.getAssignTchrStdnt').html("");
            $('' + d[0].getIntkWiseLists + '').appendTo(".getAssignTchrStdnt");
        });
    });

    $(document).on('change', '.batch_name', function () {
        var getBID = $(this).val();
        $.post("response.php?tag=getBIDDiv", { "getBID": getBID }, function (Bd) {
            $('.showBatchLists').html("");
            $('' + Bd[0].getBatchLists + '').appendTo(".showBatchLists");
        });
    });
</script>

<script>
    $(function () {
        $('.assign_submit').click(function (e) {
            e.preventDefault();
            var student_id = $('.student_id').val();
            var batch_name = $('.batch_name').val();
            if (student_id == '' || batch_name == '') {
                alert("Please Select Student and Select Option!!!");
                return false;
            } else {
                var $form = $(this).closest("#assign_register");
                var formData = $form.serializeArray();
                var URL = "response.php?tag=assignTeacher";
                $.post(URL, formData).done(function (data) {
                    if (data == 1) {
                        alert("Student Assigned to Instructor!!!");
                        window.location.href = '../campus/';
                        return true;
                    } else {
                        alert("Something went wrong. Please contact to Administrator!!!");
                        return false;
                    }
                });
            }
        });
    });
</script>

<script>
    var fixedTable1 = fixTable(document.getElementById('fixed-table-container-1'));
</script>
<?php
include ("../../footer.php");
?>