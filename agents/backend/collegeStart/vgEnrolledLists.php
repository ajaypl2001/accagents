<?php
ob_start();
include ("../../db.php");
include ("../../header_navbar.php");

if (!empty($_GET['getIntake'])) {
    $getIntake2 = $_GET['getIntake'];
    $getIntake3 = "AND prg_intake='$getIntake2'";
} else {
    $getIntake2 = '';
    $getIntake3 = '';
}

if (isset($_POST['srchClickbtn'])) {
    $search = $_POST['inputval'];
    $intakeInput = $_POST['intakeInput'];
    header("Location: ../collegeStart/?getsearch=$search&getIntake=$intakeInput&page_no=1");
}

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

                <div class="col-sm-12 mb-3">
                    <h3 class="m-0">Download Excel for VG Students</h3>
                </div>

                <form action="esVgEnrldLists.php" method="post" autocomplete="off" class="col-sm-6 col-lg-6">
                    <div class="row">
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
                                <input type="text" name="inputval" placeholder="Search By Stu. Name or Ref Id"
                                    class="form-control form-control-sm" value="<?php echo $searchTerm; ?>">
                                <div class="input-group-append">
                                    <input type="submit" name="srchClickbtn" class="btn btn-sm btn-success"
                                        value="Search">
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
</section>

<?php
include ("../../footer.php");
?>