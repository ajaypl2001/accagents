<?php
ob_start();
include ("../../db.php");
include ("../../header_navbar.php");

if ($transcript_tab == 'Yes') {

} else {
    header("Location: ../../login");
    exit();
}

if (isset($_GET['page_no']) && $_GET['page_no'] != "") {
    $page_no = $_GET['page_no'];
} else {
    $page_no = 1;
}

if (isset($_GET['getsearch']) && $_GET['getsearch'] != "") {
    $searchTerm = $_GET['getsearch'];
    $searchInput = "AND (CONCAT(st_application.fname,  ' ', st_application.lname) LIKE '%" . $searchTerm . "%' OR st_application.refid LIKE '%" . $searchTerm . "%' OR st_application.passport_no LIKE '%" . $searchTerm . "%' OR st_application.student_id LIKE '%" . $searchTerm . "%')";
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

$result_count = mysqli_query($con, "SELECT COUNT(student_transcript.sno) As total_records FROM st_application INNER JOIN student_transcript ON student_transcript.app_id=st_application.sno where student_transcript.app_id!='' $searchInput");
$total_records = mysqli_fetch_array($result_count);
$total_records = $total_records['total_records'];
$total_no_of_pages = ceil($total_records / $total_records_per_page);
$second_last = $total_no_of_pages - 1;

$rsltQuery = "SELECT st_application.sno, st_application.fname, st_application.lname, st_application.student_id, st_application.email_address, st_application.prg_intake, st_application.prg_name1, student_transcript.official_unofficail, student_transcript.class, student_transcript.date_of_issue, student_transcript.status_ip FROM st_application INNER JOIN student_transcript ON student_transcript.app_id=st_application.sno where student_transcript.app_id!='' $searchInput order by student_transcript.sno DESC LIMIT $offset, $total_records_per_page";
?>
<section class="container-fluid">
    <div class="main-div">
        <div class="admin-dashboard">
            <div class="row">

                <div class="col-sm-12 col-lg-12 mb-3">
                    <h3 class="m-0">Student Transcript Lists
                        <a href="student_transcript.php" class="btn btn-sm btn-success float-right">Add New
                            Transcript</a>
                    </h3>
                </div>

                <div class="col-12">
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered" width="100%">
                            <thead>
                                <tr>
                                    <th>Student Name</th>
                                    <th>Std Id</th>
                                    <th>Email Address</th>
                                    <th>Program</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Type</th>
                                    <th>Class</th>
                                    <th>Date of Issue</th>
                                    <th>Completion Status</th>
                                    <th>Action</th>
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
                                        $fullname = $fname . ' ' . $lname;
                                        $email_address = $row_nm['email_address'];
                                        $student_id = $row_nm['student_id'];
                                        $prg_name1 = $row_nm['prg_name1'];
                                        $prg_intake = $row_nm['prg_intake'];
                                        $official_unofficail = $row_nm['official_unofficail'];
                                        $classdiv = $row_nm['class'];
                                        $date_of_issue = $row_nm['date_of_issue'];
                                        $status_ip = $row_nm['status_ip'];

                                        $resultsStr2 = "SELECT sno, commenc_date, expected_date FROM contract_courses WHERE intake='$prg_intake' AND program_name='$prg_name1'";
                                        $get_query2 = mysqli_query($con, $resultsStr2);
                                        $rowstr2 = mysqli_fetch_assoc($get_query2);
                                        $commenc_date = $rowstr2['commenc_date'];
                                        $commenc_date2 = date("F d, Y", strtotime($commenc_date));
                                        $expected_date = $rowstr2['expected_date'];
                                        $expected_date2 = date("F d, Y", strtotime($expected_date));
                                        ?>
                                        <tr>
                                            <td><?php echo $fullname; ?></td>
                                            <td><?php echo $student_id; ?></td>
                                            <td><?php echo $email_address; ?></td>
                                            <td><?php echo $prg_name1; ?></td>
                                            <td><?php echo $commenc_date2; ?></td>
                                            <td><?php echo $expected_date2; ?></td>
                                            <td><?php echo $official_unofficail; ?></td>
                                            <td><?php echo $classdiv; ?></td>
                                            <td><?php echo $date_of_issue; ?></td>
                                            <td><?php echo $status_ip; ?></td>
                                            <td style="white-space: nowrap;">
                                                <a href="student_transcript.php?official_unofficail=<?php echo $official_unofficail; ?>&getsearch=<?php echo $student_id; ?>"
                                                    class="btn btn-sm btn-success">View & Edit Transcript</a>

                                                <span class="text-right btn btn-info btn-sm sendbtnClick"
                                                    data-id="<?php echo $snoid; ?>">Send to Student</span>
                                            </td>
                                        </tr>
                                    <?php }
                                } else {
                                    echo '<tr><td colspan="12"><center>Not Found!!!</center></td></tr>';
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

<script type="text/javascript">
    $(document).on('click', '.sendbtnClick', function () {
        var stusno = $(this).attr('data-id');
        var checkstr = confirm('Are you sure you want to Sent Email to Student?');
        if (checkstr == true) {
            $.post("../response.php?tag=getTranscript", { "stusno": stusno }, function (d) {
                if (d == '1') {
                    alert('Sent Email to Student!!!');
                    return false;
                }
                if (d == '2') {
                    alert('Something went wrong. Please contact to Manager!!!');
                    return false;
                }
                if (d == '3') {
                    alert('Again Send Email to Student!!!');
                    return false;
                }
            });
        } else {
            return false;
        }
    });
</script>

<?php
include ("../../footer.php");
?>