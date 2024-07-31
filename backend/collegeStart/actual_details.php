<?php
ob_start();
include ("../../db.php");
include ("../../header_navbar.php");

if (isset($_GET['getsearch']) && $_GET['getsearch'] != "") {
    $searchTerm = $_GET['getsearch'];
    $searchInput = "AND (CONCAT(fname,  ' ', lname) LIKE '%" . $searchTerm . "%' OR refid LIKE '%" . $searchTerm . "%' OR passport_no LIKE '%" . $searchTerm . "%' OR student_id LIKE '%" . $searchTerm . "%')";
    $search_url = "&getsearch=" . $searchTerm . "";
} else {
    $searchInput = '';
    $search_url = '';
}

if (isset($_POST['submitbtn'])) {
    $app_id = $_POST['app_id'];
    $student_name = $_POST['student_name'];
    $passp = $_POST['passp'];
    $stid = $_POST['stid'];
    $refid = $_POST['refid'];

    $act_pgname = mysqli_real_escape_string($con, $_POST['act_pgname']);
    $act_start_date = $_POST['act_start_date'];
    $act_end_date = $_POST['act_end_date'];

    $act_remarks = mysqli_real_escape_string($con, $_POST['act_remarks']);
    $act_datetime_at = date('Y-m-d H:i:s');

    $queryGet = "SELECT app_id FROM `start_college` WHERE app_id='$app_id'";
    $queryRslt = mysqli_query($con, $queryGet);
    if (mysqli_num_rows($queryRslt)) {
        $queryUpdate = "UPDATE `start_college` SET `student_name`='$student_name', `student_id`='$stid', `refid`='$refid', `passport_no`='$passp', `act_pgname`='$act_pgname', `act_start_date`='$act_start_date', `act_end_date`='$act_end_date', `act_remarks`='$act_remarks', `act_datetime_at`='$act_datetime_at', `act_details_added_by`='$contact_person' WHERE `app_id`='$app_id'";
        mysqli_query($con, $queryUpdate);
    } else {
        $queryVgr2 = "INSERT INTO `start_college` (`app_id`, `student_name`, `student_id`, `refid`, `passport_no`, `act_pgname`, `act_start_date`, `act_end_date`, `act_remarks`, `act_datetime_at`, `act_details_added_by`) VALUES ('$app_id', '$student_name', '$stid', '$refid', '$passp', '$act_pgname', '$act_start_date', '$act_end_date', '$act_remarks', '$act_datetime_at', '$contact_person')";
        mysqli_query($con, $queryVgr2);
    }

    $querylog = "INSERT INTO `start_college_logs` (`app_id`, `act_pgname`, `act_start_date`, `act_end_date`, `act_remarks`, `act_datetime_at`, `act_details_added_by`) VALUES ('$app_id', '$act_pgname', '$act_start_date', '$act_end_date', '$act_remarks', '$act_datetime_at', '$contact_person')";
    mysqli_query($con, $querylog);

    header("Location: ../collegeStart/actual_details.php?SuccessFully_Submit$search_url");
}

if (isset($_POST['srchClickbtn'])) {
    $search = $_POST['inputval'];
    header("Location: ../collegeStart/actual_details.php?getsearch=$search&page_no=1");
}

if (isset($_GET['page_no']) && $_GET['page_no'] != "") {
    $page_no = $_GET['page_no'];
} else {
    $page_no = 1;
}

$total_records_per_page = 90;
$offset = ($page_no - 1) * $total_records_per_page;
$previous_page = $page_no - 1;
$next_page = $page_no + 1;
$adjacents = "2";

$result_count = mysqli_query($con, "SELECT COUNT(*) As total_records FROM `both_main_table` where v_g_r_status='V-G' $searchInput");
$total_records = mysqli_fetch_array($result_count);
$total_records = $total_records['total_records'];
$total_no_of_pages = ceil($total_records / $total_records_per_page);
$second_last = $total_no_of_pages - 1;

$rsltQuery = "SELECT * FROM st_application where loa_file!='' AND loa_file_status='1'
 $searchInput order by sno DESC LIMIT $offset, $total_records_per_page";
?>
<link rel="stylesheet" href="../../css/sweetalert.min.css">
<script src="../../js/sweetalert.min.js"></script>
<style>
    .error_color {
        border: 2px solid #de0e0e;
    }

    .validError {
        border: 2px solid #ccc;
    }
</style>
<section class="container-fluid">
    <div class="main-div">
        <div class="admin-dashboard">
            <div class="row">
                <div class="col-sm-4 col-lg-7">
                    <h3 class="ml-4">On/Off Shore Actual Details</h3>
                </div>
                <div class="col-sm-8 col-lg-5">
                    <form action="" method="post" autocomplete="off" class=" mt-3">
                        <div class="input-group">
                            <input type="text" name="inputval" placeholder="Search By Stu. Name or Ref Id"
                                class="form-control" required>
                            <div class="input-group-append">
                                <input type="submit" name="srchClickbtn" class="btn btn-success" value="Search">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-12">
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered" width="100%">
                            <thead>
                                <tr>
                                    <th>Student Name</th>
                                    <th>Ref/Std Id</th>
                                    <th>Email Address</th>
                                    <th>Passport</th>
                                    <th>Start/End Date</th>
                                    <th>On/Off</th>
                                    <th>Inp.Program Name</th>
                                    <th>Inp.Actual Start Date</th>
                                    <th>Inp.Actual End Date</th>
                                    <th>Updated On</th>
                                    <th>Updated By</th>
                                    <th>Action/Logs</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $qurySql = mysqli_query($con, $rsltQuery);
                                if (mysqli_num_rows($qurySql)) {
                                    while ($row_nm = mysqli_fetch_assoc($qurySql)) {
                                        $snoid = $row_nm['sno'];
                                        $fname = $row_nm['fname'];
                                        $lname = $row_nm['lname'];
                                        $fullname = ucfirst($fname) . ' ' . ucfirst($lname);
                                        $refid = $row_nm['refid'];
                                        $student_id = $row_nm['student_id'];
                                        $passport_no = $row_nm['passport_no'];
                                        $email_address = $row_nm['email_address'];
                                        $prg_name1 = $row_nm['prg_name1'];
                                        $prg_intake = $row_nm['prg_intake'];
                                        $country = $row_nm['country'];
                                        if ($country == 'Canada') {
                                            $countryDiv = 'Onshore';
                                        } else {
                                            $countryDiv = 'Offshore';
                                        }
                                        $queryGet4 = "SELECT commenc_date, expected_date FROM `contract_courses` WHERE program_name='$prg_name1' AND intake='$prg_intake'";
                                        $queryRslt4 = mysqli_query($con, $queryGet4);
                                        $rowSC4 = mysqli_fetch_assoc($queryRslt4);
                                        $start_date = 'Start Date: ' . $rowSC4['commenc_date'] . '<br>';
                                        $end_date = 'End Date: ' . $rowSC4['expected_date'];

                                        $queryGet2 = "SELECT * FROM `start_college` WHERE act_pgname!='' AND app_id='$snoid'";
                                        $queryRslt2 = mysqli_query($con, $queryGet2);
                                        if (mysqli_num_rows($queryRslt2)) {
                                            $rowSC = mysqli_fetch_assoc($queryRslt2);
                                            $act_pgname2 = $rowSC['act_pgname'];
                                            $act_start_date = $rowSC['act_start_date'];
                                            $act_end_date = $rowSC['act_end_date'];
                                            if (!empty($act_pgname2)) {
                                                $act_pgname = $act_pgname2;
                                            } else {
                                                $act_pgname = '<span style="color:red;">No Action</span>';
                                            }
                                            $datetime_at = $rowSC['act_datetime_at'];
                                            $act_details_added_by = $rowSC['act_details_added_by'];
                                        } else {
                                            $act_pgname = '<span style="color:red;">No Action</span>';
                                            $datetime_at = '';
                                            $act_start_date = '';
                                            $act_end_date = '';
                                            $act_details_added_by = '';
                                        }
                                        ?>
                                        <tr>
                                            <td><?php echo $fname . ' ' . $lname; ?></td>
                                            <td><?php echo $refid . '/<br>' . $student_id; ?></td>
                                            <td><?php echo $email_address; ?></td>
                                            <td><?php echo $passport_no; ?></td>
                                            <td style="white-space: nowrap;">
                                                <?php echo $start_date . '' . $end_date; ?>
                                            </td>
                                            <td style="white-space: nowrap;"><?php echo $countryDiv; ?></td>
                                            <td><?php echo $act_pgname; ?></td>
                                            <td><?php echo $act_start_date; ?></td>
                                            <td><?php echo $act_end_date; ?></td>
                                            <td><?php echo $datetime_at; ?></td>
                                            <td><?php echo $act_details_added_by; ?></td>
                                            <td style="white-space: nowrap;">
                                                <span class="btn btn-sm btn-success statusClass" data-toggle="modal"
                                                    data-target="#statusModal" data-id="<?php echo $snoid; ?>"
                                                    data-name="<?php echo $fullname; ?>" data-refid="<?php echo $refid; ?>"
                                                    data-stid="<?php echo $student_id; ?>"
                                                    data-passp="<?php echo $passport_no; ?>">Add Status</span>
                                                <span class="btn btn-sm btn-info allClass" data-toggle="modal"
                                                    data-target="#allModel" data-id="<?php echo $snoid; ?>"
                                                    data-name="<?php echo $fullname; ?>">Logs</span>
                                            </td>
                                        </tr>
                                    <?php }
                                } else {
                                    echo '<tr><td colspan="9"><center>Not Found!!!</center></td></tr>';
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
                                    echo "href='?page_no=$previous_page&getsearch=$search_url'";
                                } ?> class='page-link'>Previous</a>
                            </li>

                            <?php
                            if ($total_no_of_pages <= 10) {
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
                                    for ($counter = $page_no - $adjacents; $counter <= $page_no + $adjacents; $counter++) {
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

                                    for ($counter = $total_no_of_pages - 6; $counter <= $total_no_of_pages; $counter++) {
                                        if ($counter == $page_no) {
                                            echo "<li class='page-item active'><a class='page-link'>$counter</a></li>";
                                        } else {
                                            echo "<li class='page-item'><a href='?page_no=$counter&getsearch=$search_url' class='page-link'>$counter</a></li>";
                                        }
                                    }
                                }
                            }
                            ?>

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

<div class="modal" id="statusModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><span class="getNameId"></span></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body getStartLists"></div>
            <div class="modal-footer"></div>
        </div>
    </div>
</div>

<div class="modal fade" id="allModel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><span class="stNameLogs"></span></h4>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            <div class="loading_icon"></div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-sm table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Sno.</th>
                                <th>Program Name</th>
                                <th>Actual Start Date</th>
                                <th>Actual End Date</th>
                                <th>Remarks</th>
                                <th>Updated On</th>
                                <th>Added By</th>
                            </tr>
                        </thead>
                        <tbody class="getAllLogsDiv">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).on('click', '.statusClass', function () {
        var getVal = $(this).attr('data-id');
        var getVal2 = $(this).attr('data-name');
        var getVal3 = $(this).attr('data-passp');
        var getVal4 = $(this).attr('data-stid');
        var getVal5 = $(this).attr('data-refid');
        $('.getNameId').html(getVal2);
        $.post("../responseStart.php?tag=getActualLists", { "idno": getVal, "name": getVal2, "passp": getVal3, "stid": getVal4, "refid": getVal5 }, function (d) {
            $('.getStartLists').html("");
            $('' + d[0].getStartLists + '').appendTo(".getStartLists");

            $(function () {
                $(".datepickerDiv").datepicker({
                    dateFormat: 'yy-mm-dd',
                    changeMonth: false,
                    changeYear: false,
                });
            });

            $("#firsttab_requried").submit(function () {
                var submit = true;
                $(".is_require:visible").each(function () {
                    if ($(this).val() == '') {
                        $(this).addClass('error_color');
                        submit = false;
                    } else {
                        $(this).addClass('validError');
                    }
                });
                if (submit == true) {
                    return true;
                } else {
                    $('.is_require').keyup(function () {
                        $(this).removeClass('error_color');
                    });
                    return false;
                }
            });

        });
    });
</script>

<script type="text/javascript">
    $(document).on('click', '.allClass', function () {
        var idmodel = $(this).attr('data-id');
        var getHeadVal = $(this).attr('data-name');
        $('.stNameLogs').html(getHeadVal);
        $('.loading_icon').show();
        $.post("../responseStart.php?tag=getActualLogs", { "idno": idmodel }, function (il) {
            $('.getAllLogsDiv').html("");
            if (il == '') {
                $('.getAllLogsDiv').html("<tr><td colspan='6'><center>Not Found</center></td></tr>");
            } else {
                for (i in il) {
                    $('<tr>' +
                        '<td>' + il[i].idLogs + '</td>' +
                        '<td style="white-space: nowrap;">' + il[i].act_pgname + '</td>' +
                        '<td>' + il[i].act_start_date + '</td>' +
                        '<td>' + il[i].act_end_date + '</td>' +
                        '<td>' + il[i].act_remarks + '</td>' +
                        '<td>' + il[i].datetime_at + '</td>' +
                        '<td>' + il[i].act_details_added_by + '</td>' +
                        '</tr>').appendTo(".getAllLogsDiv");
                }
            }
            $('.loading_icon').hide();
        });
    });	
</script>

<script type="text/javascript">
    $(document).on('change', '.ipDiv', function () {
        var getVal = $(this).val();
        if (getVal == 'Inprogress') {
            $('.InprgsDiv').show();
        } else {
            $('.InprgsDiv').hide();
        }
    });
</script>

<?php
include ("../../footer.php");
?>