<?php
ob_start();
include ("../../db.php");
include ("../../header_navbar.php");

if ($ptib_access == 'Yes') {

} else {
    header("Location: ../../login");
    exit();
}

if (!empty($_GET['getIntake'])) {
    $getIntake2 = $_GET['getIntake'];
    $getIntake3 = "AND prg_intake='$getIntake2'";
} else {
    $getIntake2 = '';
    $getIntake3 = '';
}

if (isset($_POST['srchClickbtn'])) {
    $intakeInput = $_POST['intakeInput'];
    header("Location: ../collegeStart/ptibReports.php?getIntake=$intakeInput");
}
?>
<section class="container-fluid">
    <div class="main-div">
        <div class="admin-dashboard">
            <div class="row justify-content-center">

                <div class="col-sm-3 col-lg-3 mb-3">
                    <h3 class="m-0">PTIB Reports</h3>
                </div>
                <form action="" method="post" autocomplete="off" class="col-sm-6 col-lg-6">
                    <div class="row justify-content-center">
                        <div class="col-sm-6 mb-3">
                            <div class="input-group input-group-sm">
                                <select name="intakeInput" class="form-control">
                                    <option value="">Select Intake</option>
                                    <?php
                                    $rsltQuery5 = "SELECT intake FROM contract_courses Group BY intake ORDER BY intake DESC";
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
                        <div class="col-sm-6 mb-3">
                            <div class="input-group">
                                <div class="input-group-append">
                                    <input type="submit" name="srchClickbtn" class="btn btn-sm btn-success"
                                        value="Search">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </DIV>
            <div class="row justify-content-center mt-4">

                <div class="col-6 col-sm-4 col-md-3 col-xl-2 text-center">
                    <div class="card">
                        <div class="card-header">
                            <h6>Student</h6>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="excelSheetNewFrmt.php" autocomplete="off">
                                <input type="hidden" name="intakeInput" value="<?php echo $getIntake2; ?>">
                                <input type="hidden" name="tabName" value="Student">
                                <button type="submit" name="studentlist" class="btn btn-md btn-success ">Download
                                    Excel</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-sm-1">
                </div>

                <div class="col-6 col-sm-4 col-md-3 col-xl-2 text-center">
                    <div class="card">
                        <div class="card-header ">
                            <h6>Enrollment</h6>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="excelSheetNewFrmt.php" autocomplete="off">
                                <input type="hidden" name="intakeInput" value="<?php echo $getIntake2; ?>">
                                <input type="hidden" name="tabName" value="Enrollment">
                                <button type="submit" name="studentlist" class="btn btn-md btn-success ">Download
                                    Excel</button>
                            </form>


                        </div>
                    </div>
                </div>


            </div>
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