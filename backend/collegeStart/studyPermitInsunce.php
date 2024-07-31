<?php
ob_start();
include ("../../db.php");
include ("../../header_navbar.php");



if (isset($_GET['page_no']) && $_GET['page_no'] != "") {
    $page_no = $_GET['page_no'];
} else {
    $page_no = 1;
}

if (isset($_GET['getsearch']) && $_GET['getsearch'] != "") {
    $searchTerm = $_GET['getsearch'];
    $searchInput = "AND (CONCAT(both_main_table.fname,  ' ', both_main_table.lname) LIKE '%" . $searchTerm . "%' OR both_main_table.refid LIKE '%" . $searchTerm . "%' OR both_main_table.passport_no LIKE '%" . $searchTerm . "%' OR both_main_table.student_id LIKE '%" . $searchTerm . "%')";
    $search_url = "&getsearch=" . $searchTerm . "";
} else {
    $searchInput = '';
    $search_url = '';
    $searchTerm = '';
}

$total_records_per_page = 90;
$offset = ($page_no - 1) * $total_records_per_page;
$previous_page = $page_no - 1;
$next_page = $page_no + 1;
$adjacents = "2";

$result_count = mysqli_query($con, "SELECT COUNT(international_airport_student.sno) As total_records FROM both_main_table INNER JOIN international_airport_student ON international_airport_student.app_id=both_main_table.sno where international_airport_student.app_id!=''   $searchInput");
$total_records = mysqli_fetch_array($result_count);
$total_records = $total_records['total_records'];
$total_no_of_pages = ceil($total_records / $total_records_per_page);
$second_last = $total_no_of_pages - 1;

$rsltQuery = "SELECT both_main_table.sno, both_main_table.fname, both_main_table.lname, both_main_table.student_id, both_main_table.prg_name1, both_main_table.email_address, both_main_table.prg_intake, both_main_table.sif_send_by, international_airport_student.can_address, international_airport_student.can_contact_no, international_airport_student.datetime_at, international_airport_student.study_permit, international_airport_student.insurance FROM both_main_table INNER JOIN international_airport_student ON international_airport_student.app_id=both_main_table.sno where international_airport_student.app_id!='' AND  both_main_table.study_permit='Yes' $searchInput order by international_airport_student.sno DESC LIMIT $offset, $total_records_per_page";
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<section class="container-fluid">
    <div class="main-div">
        <div class="admin-dashboard">
            <div class="row">

                <div class="col-sm-12 col-lg-12 mb-3">
                    <h3 class="m-0">Student Study Permit Lists
                        <a href="studyPermitInsunce.php?MVNlY3VSaTR5OQ==" style="font-size: 13px;">Reload Page <i
                                class="fas fa-refresh"></i></a>
                        <a href="vgStudyPermit.php" class="btn btn-sm btn-success float-right">Add New Study Permit</a>
                    </h3>
                </div>

                <div class="col-12">
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered" width="100%">
                            <thead>
                                <tr>
                                    <th>Added By Name</th>
                                    <th>Updated ON</th>
                                    <th>Student Name</th>
                                    <th>Std Id</th>
                                    <th>Email Address</th>
                                    <th>Program</th>
                                    <th>STUDY PERMIT & Insurance</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $qurySql = mysqli_query($con, $rsltQuery);
                                if (mysqli_num_rows($qurySql)) {
                                    while ($row_nm = mysqli_fetch_assoc($qurySql)) {
                                        $fname = $row_nm['fname'];
                                        $lname = $row_nm['lname'];
                                        $fullname = $fname . ' ' . $lname;
                                        $email_address = $row_nm['email_address'];
                                        // $program = $row_nm['prg_name1'];
                                        $student_id = $row_nm['student_id'];
                                        $study_file = $row_nm['study_permit'];
                                        $insurance = $row_nm['insurance'];
                                        $prg_name1 = $row_nm['prg_name1'];
                                        $prg_intake = $row_nm['prg_intake'];
                                        $sif_send_by = $row_nm['sif_send_by'];
                                        $update_date = $row_nm['datetime_at'];

                                        if (!empty($sif_send_by)) {
                                            $study_fileName = $sif_send_by;
                                        } else {
                                            $study_fileName = 'Student';
                                        }

                                        if (!empty($study_file)) {
                                            $study_file2 = '<a href="localhost/accagents/international/uploads/' . $study_file . '" download>Download STUDY PERMIT</a>';
                                        } else {
                                            $study_file2 = 'N/A';
                                        }

                                        if (!empty($insurance)) {
                                            $insurance2 = '<br><a href="localhost/accagents/international/uploads/' . $insurance . '" download>Download Insurance</a>';
                                        } else {
                                            $insurance2 = '';
                                        }

                                        $resultsStr2 = "SELECT sno, commenc_date, expected_date FROM contract_courses WHERE intake='$prg_intake' AND program_name='$prg_name1'";
                                        $get_query2 = mysqli_query($con, $resultsStr2);
                                        $rowstr2 = mysqli_fetch_assoc($get_query2);
                                        $commenc_date = $rowstr2['commenc_date'];
                                        $commenc_date2 = date("F d, Y", strtotime($commenc_date));
                                        $expected_date = $rowstr2['expected_date'];
                                        $expected_date2 = date("F d, Y", strtotime($expected_date));
                                        ?>
                                        <tr>
                                            <td><?php echo $study_fileName; ?></td>
                                            <td><?php echo $update_date; ?></td>
                                            <td><?php echo $fullname; ?></td>
                                            <td><?php echo $student_id; ?></td>
                                            <td><?php echo $email_address; ?></td>
                                            <td><?php echo $prg_name1; ?></td>
                                            <td style="white-space: nowrap;"><?php echo $study_file2 . '' . $insurance2; ?></td>
                                            <td><?php echo $commenc_date2; ?></td>
                                            <td><?php echo $expected_date2; ?></td>
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
                            <?php if ($page_no > 1) {
                                echo "<li class='page-item'><a href='?page_no=1' class='page-link'>First Page</a></li>";
                            } ?>

                            <li <?php if ($page_no <= 1) {
                                echo "class='page-item disabled'";
                            } ?>>
                                <a <?php if ($page_no > 1) {
                                    echo "href='?page_no=$previous_page'";
                                } ?>
                                    class='page-link'>Previous</a>
                            </li>

                            <?php
                            if ($total_no_of_pages <= 10) {
                                for ($counter = 1; $counter <= $total_no_of_pages; $counter++) {
                                    if ($counter == $page_no) {
                                        echo "<li class='page-item active'><a class='page-link'>$counter</a></li>";
                                    } else {
                                        echo "<li class='page-item'><a href='?page_no=$counter' class='page-link'>$counter</a></li>";
                                    }
                                }
                            } elseif ($total_no_of_pages > 10) {

                                if ($page_no <= 4) {
                                    for ($counter = 1; $counter < 8; $counter++) {
                                        if ($counter == $page_no) {
                                            echo "<li class='page-item active'><a class='page-link'>$counter</a></li>";
                                        } else {
                                            echo "<li class='page-item'><a href='?page_no=$counter' class='page-link'>$counter</a></li>";
                                        }
                                    }
                                    echo "<li><a>...</a></li>";
                                    echo "<li><a href='?page_no=$second_last&getsearch=$search_url' class='page-link'>$second_last</a></li>";
                                    echo "<li><a href='?page_no=$total_no_of_pages' class='page-link'>$total_no_of_pages</a></li>";
                                } elseif ($page_no > 4 && $page_no < $total_no_of_pages - 4) {
                                    echo "<li class='page-item'><a href='?page_no=1&getsearch=$search_url' class='page-link'>1</a></li>";
                                    echo "<li class='page-item'><a href='?page_no=2' class='page-link'>2</a></li>";
                                    echo "<li class='page-item'><a class='page-link'>...</a></li>";
                                    for ($counter = $page_no - $adjacents; $counter <= $page_no + $adjacents; $counter++) {
                                        if ($counter == $page_no) {
                                            echo "<li class='page-item active'><a class='page-link'>$counter</a></li>";
                                        } else {
                                            echo "<li class='page-item'><a href='?page_no=$counter' class='page-link'>$counter</a></li>";
                                        }
                                    }
                                    echo "<li class='page-item'><a class='page-link'>...</a></li>";
                                    echo "<li class='page-item'><a href='?page_no=$second_last' class='page-link'>$second_last</a></li>";
                                    echo "<li class='page-item'><a href='?page_no=$total_no_of_pages' class='page-link'>$total_no_of_pages</a></li>";
                                } else {
                                    echo "<li class='page-item'><a href='?page_no=1&getsearch=$search_url' class='page-link'>1</a></li>";
                                    echo "<li class='page-item'><a href='?page_no=2&getsearch=$search_url' class='page-link'>2</a></li>";
                                    echo "<li class='page-item'><a class='page-link'>...</a></li>";

                                    for ($counter = $total_no_of_pages - 6; $counter <= $total_no_of_pages; $counter++) {
                                        if ($counter == $page_no) {
                                            echo "<li class='page-item active'><a class='page-link'>$counter</a></li>";
                                        } else {
                                            echo "<li class='page-item'><a href='?page_no=$counter' class='page-link'>$counter</a></li>";
                                        }
                                    }
                                }
                            }
                            ?>

                            <li <?php if ($page_no >= $total_no_of_pages) {
                                echo "class='page-item disabled'";
                            } ?>>
                                <a <?php if ($page_no < $total_no_of_pages) {
                                    echo "href='?page_no=$next_page'";
                                } ?>
                                    class='page-link'>Next</a>
                            </li>
                            <?php if ($page_no < $total_no_of_pages) {
                                echo "<li class='page-item'><a href='?page_no=$total_no_of_pages' class='page-link'>Last &rsaquo;&rsaquo;</a></li>";
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

<?php
include ("../../footer.php");
?>