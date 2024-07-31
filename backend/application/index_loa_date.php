<?php
ob_start();
include("../../db.php");
date_default_timezone_set("Asia/Kolkata");
include("../../header_navbar.php");

if(!isset($_SESSION['sno'])){
    header("Location: ../../login");
    exit(); 
}
?> 
<?php
if(isset($_SESSION['sno']) && !empty($_SESSION['sno'])){
$sessionSno = $_SESSION['sno'];
$result1 = mysqli_query($con,"SELECT sno,role,username,email,loa_allow FROM allusers WHERE sno = '$sessionSno'");
 while ($row1 = mysqli_fetch_assoc($result1)) {
   $adminrole = mysqli_real_escape_string($con, $row1['role']);
   $counselor_email = mysqli_real_escape_string($con, $row1['email']);
   $counselor_uname = mysqli_real_escape_string($con, $row1['username']);   
   $loa_allow = mysqli_real_escape_string($con, $row1['loa_allow']);   
 }
}else{
   $adminrole = '';
   $counselor_email = '';
   $counselor_uname = ''; 
   $loa_allow = ''; 
}

if(($adminrole == 'Admin') || ($adminrole == 'Excu') || ($adminrole == 'Excu1')){
?> 
<?php 
if(isset($_GET['imgMsg'])){
	$mssg =  base64_decode($_GET['imgMsg']);
	if(isset($mssg) == 'ImageUpload'){ 
?>
	<div class='alertdiv'>
		<div class='alert alert-danger' style="text-align:center;">
			<?php echo 'You can upload only jpg and pdf file.'; ?>
		</div>
    </div>     
<?php } } 
if(isset($_GET['ploaMsg'])){
	$mssg =  base64_decode($_GET['ploaMsg']);
	if(isset($mssg) == 'LOAPayStatus'){ 
?>
	<div class='alertdiv'>
		<div class='alert alert-success' style="text-align:center;">
			<?php echo 'Your Status successfully Updated'; ?>
		</div>
    </div>     
<?php } } 
if(isset($_GET['msgalt'])){
	$mssg =  base64_decode($_GET['msgalt']);
	if(isset($mssg) == 'Donotpdf1'){ 
?>
<script>
$(document).ready(function(){    
    $("#yes_application_alert").modal('show');    
});
</script>	    
<?php } } ?>

<style>
input#searchbtn {
    float: right;
   left:100px; margin-left:40px;
    right: 0px; padding:5px 10px; margin-bottom:8px; margin-right:0px;

}
.alertdiv {
    margin-top: 126px;
    width: 100%;
    margin-bottom: -6%;
}
body { background:#eeee;}
.fixed-table-container th select { width:90px;}
.form-control.searchbtn_btn, .ui-menu .ui-menu-item-wrapper { font-size:14px;}
.ui-menu.ui-widget.ui-widget-content.ui-autocomplete.ui-front {height:250px; overflow-y:scroll;overflow-x:hidden;}
</style>
<link rel="stylesheet" href="../../css/sweetalert.min.css">
<script src="../../js/sweetalert.min.js"></script>

<link rel="stylesheet" type="text/css" href="../../css/fixed-table.css">
<script src="../../js/fixed-table.js"></script>

<section>
<div class="main-div">	
	<form class="row pt-4" method="post" action="../mysqldb.php"> 	
		<div class="col-xl-7 col-md-5"></div>
		<div class="col-xl-4 col-md-5 col-8 pl-4">
			<input type="search" class="form-control" name="search" placeholder="Search by Name,DOB,Refrence & Student Id">
		</div>
		<div class="col-xl-1 col-md-2 col-4"><button type="submit" name="srchAolbtn" class="btn btn-more btn-success">Search</button>
		</div>
	</form>
<div class="col-sm-12 application-tabs pt-4">

	<div class="col-lg-12 admin-dashboard content-wrap"> 
	
	
	<div class="col-lg-12">
	<div class="row"> 	
    <div id="fixed-table-container-1" class="fixed-table-container">
	<table class="table table-bordered" width="100%">
    <thead>	 
      <tr bgcolor="#114663">
        <th><input type="checkbox"></th>		
        <th>Agent Name</th>		
        <th>Full Name</th>
        <th>St ID/ Ref ID</th>
        <th>Current LOA Date</th>		
        <th>LOA</th>        
      </tr>
    </thead>
	<div class="loading_icon"></div>
    <tbody id="totalshow" class="searchall">
	<?php
		if(isset($_GET['getsearch']) && !empty($_GET['getsearch'])){
			$getsearch1 = $_GET['getsearch'];
			
			$getValSearch = "SELECT * FROM st_application WHERE (CONCAT(fname,  ' ', lname) LIKE '%$getsearch1%' OR refid LIKE '%$getsearch1%' OR student_id LIKE '%$getsearch1%' OR dob LIKE '%$getsearch1%') AND loa_file_date_updated_by!='' AND loa_file_status!='' ORDER BY sno DESC";		
			$result2 = mysqli_query($con, $getValSearch);
		if(mysqli_num_rows($result2)){
		while ($row = mysqli_fetch_assoc($result2)) {
			 $snoall = mysqli_real_escape_string($con, $row['sno']);
			 $app_by = mysqli_real_escape_string($con, $row['app_by']);
			 $agent_type = mysqli_real_escape_string($con, $row['agent_type']);
			 $user_id = mysqli_real_escape_string($con, $row['user_id']);
			 $refid = mysqli_real_escape_string($con, $row['refid']);
			 $student_id = mysqli_real_escape_string($con, $row['student_id']);
			 $fname = mysqli_real_escape_string($con, $row['fname']);			
			 $lname = mysqli_real_escape_string($con, $row['lname']);			
			 $dob = mysqli_real_escape_string($con, $row['dob']);
			 $dob_1 = date("F j, Y", strtotime($dob)); 
			 $prepaid_fee = mysqli_real_escape_string($con, $row['prepaid_fee']);
			 $loa_file = mysqli_real_escape_string($con, $row['loa_file']);
			 $loa_file_status = mysqli_real_escape_string($con, $row['loa_file_status']);
			 $loa_file_date_updated_by = mysqli_real_escape_string($con, $row['loa_file_date_updated_by']);
			 $agnt_qry = mysqli_query($con,"SELECT username FROM allusers where sno='$user_id'");
		     while ($row_agnt_qry = mysqli_fetch_assoc($agnt_qry)) {
			 $agntname = mysqli_real_escape_string($con, $row_agnt_qry['username']);
			 }
	?>
      <tr class="error_<?php echo $snoall;?>">
        <td>
		<input type="checkbox" id="error_<?php echo $snoall;?>" />
		</td>
        <td>
		<?php 
			if($app_by == 'Student'){
				echo $app_by; 
			}
			if($agent_type == 'normal'){
				echo $agntname; 
			}
			if($agent_type == 'int_agent'){
				echo $agntname;
			}       
		?>
		</td>
        <td><a href="../followup/add.php?stusno=<?php echo $snoall; ?>" target="_blank">
		<?php echo $fname.' '.$lname;?></a><br><?php echo $dob_1;?>
		</td>
        <td>
		<?php echo $student_id.'<br>'; ?>
		<?php echo $refid; ?>		
		</td>
		<td><?php echo $loa_file_date_updated_by; ?></td>
		
		<?php if($adminrole !== 'Excu1'){ ?>

		
		<?php } 
		if(($adminrole == 'Admin') || ($adminrole !== 'Excu') || ($adminrole == 'Excu1')){ ?>
		<td>
		<?php
		if(($prepaid_fee == '') && ($loa_file == '') && ($loa_file_status == '')){
			echo '<span class="btn btn-sm btn-pending" data-toggle="tooltip" data-placement="top" title="" data-original-title="No Action Made"><i class="fas fa-times"></i></span>';		
		}
		if(($prepaid_fee !== '') && ($loa_file == '') && ($loa_file_status == '')){ ?>
		<div class="btn checklistClassyellow btn-sm genrateClass" data-toggle="modal" data-target="#genrateModel" data-id="<?php echo $snoall;?>"><i class="fas fa-upload" data-toggle="tooltip" data-placement="top" title="Generate LOA"></i></div>
		<?php }		
		if(($prepaid_fee !== '') && ($loa_file !== '') && ($loa_file_status == '')){ ?>
		<div class="btn checklistClassgreen btn-sm genrateClass" data-toggle="modal" data-target="#genrateModel" data-id="<?php echo $snoall;?>" ><i class="fas fa-upload" data-toggle="tooltip" data-placement="top" title="LOA Generated"></i></div>
		<?php }	
		if(($prepaid_fee !== '') && ($loa_file !== '') && ($loa_file_status == '1')){ ?>
		<span class="btn checklistClassgreen btn-sm genrateClass" data-toggle="modal" data-target="#genrateModel" data-id="<?php echo $snoall;?>" ><i class="fas fa-check" data-toggle="tooltip" data-placement="top" title="LOA Sent"></i></span>
		<?php }	?>
		</td>		
		
		<?php } ?>		
      </tr>
	  
	<?php } 
	}else{
	echo '<tr><td colspan="6">No Result Found</td></tr>';
}
}else{
	echo '<tr><td colspan="6">Search To View Results</td></tr>';
} ?>
    </tbody>	
 </table> 
</div>
</div>
</div>



</div>
</div>
</div>
</section>

<?php if(!empty($_GET["aid"]) && empty($_GET["tab"])){ ?>
<script>
	$(".<?php echo $_GET["aid"];?>").css({"background-color": "#A8D8F4"});
	$("#<?php echo $_GET["aid"];?>").prop('checked', true);
</script>
<?php }
if(!empty($_GET["aid"]) && !empty($_GET["tab"])){
if($_GET["tab"] == 'All'){
?>
<script>
	$('li#activeId1').removeClass("active");
    $('li#activeId').addClass("active");	
    $('.dropagent').hide();	
	$(".<?php echo $_GET["aid"];?>").css({"background-color": "#A8D8F4"});
	$("#<?php echo $_GET["aid"];?>").prop('checked', true);
</script>
<?php }
if($_GET["tab"] == 'Agent'){
?>
<script>
	$('.dropagent').show();
	$('li#activeId').removeClass("active");
    $('li#activeId1').addClass("active");	
	$(".<?php echo $_GET["aid"];?>").css({"background-color": "#A8D8F4"});
	$("#<?php echo $_GET["aid"];?>").prop('checked', true);
</script>
<?php } } ?>

<div class="modal fade main-modal" id="genrateModel" role="dialog">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<h4 class="modal-title">Change LOA Date</h4>
<button type="button" class="close" data-dismiss="modal">&times;</button>
</div>
<div class="modal-body pt-0">
<div class="loading_icon"></div>
<div class="row">
<div class="col-sm-12 mt-0">
	<div class="loaDateChangeDiv"></div>
</div>
</div>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>
</div>
</div>
</div>

<style type="text/css">
	.fixed-table-container th  { width:100px;}
	.fixed-table-container { overflow: scroll; }
	.fixed-table-container tr:first-child th {
    background: #114663;
}

.error_color{border:1px solid #de0e0e;}
.validError{border:1px solid #ccc;}
</style>
<script>

<!--- LOA --->	
$(document).on('click', '.genrateClass', function(){
	var idmodel = $(this).attr('data-id');
	$('.loading_icon').show();
	$.post("../response.php?tag=loaGenrate_DateChange",{"idno":idmodel},function(d){
		$('.loaDateChangeDiv').html("");
		$('<div>' +
		'<p>' + d[0].loaDateChange + '</p>' +
		'</div>').appendTo(".loaDateChangeDiv");
		$('.loading_icon').hide();


$(function(){
    $(".date_loa").datepicker({	  
		dateFormat: 'yy-mm-dd', 
		changeMonth: false, 
		changeYear: false,
    });
});

    }); 
});

</script>

<script>
  var fixedTable1 = fixTable(document.getElementById('fixed-table-container-1'));
</script>  
<?php 
include("../../footer.php");

}else{
	header("Location: ../../application");
}
// cricketalllineindia@gmail.com
?>  
