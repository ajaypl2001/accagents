<?php
ob_start();
include("../../db.php");
include("../../header_navbar.php");

if(!isset($_SESSION['sno'])){
    header("Location: ../../login");
    exit(); 
}

if(isset($_SESSION['sno']) && !empty($_SESSION['sno'])){
$sessionSno = $_SESSION['sno'];
$result1 = mysqli_query($con,"SELECT sno,role,username,email,report_allow FROM allusers WHERE sno = '$sessionSno'");
 while ($row1 = mysqli_fetch_assoc($result1)) {
   $adminrole = mysqli_real_escape_string($con, $row1['role']);
   $counselor_email = mysqli_real_escape_string($con, $row1['email']);
   $counselor_uname = mysqli_real_escape_string($con, $row1['username']);   
   $report_allow = mysqli_real_escape_string($con, $row1['report_allow']);   
 }
}else{
	$adminrole = '';
	$counselor_email = '';
	$counselor_uname = '';
	$report_allow = '';
} 

if(($adminrole == 'Admin') || ($adminrole == 'Excu')){

if(!empty($_GET['noti']) && isset($_GET['noti'])){
	$notif =  $_GET['noti'];
	mysqli_query($con, "UPDATE `notification_aol` SET  `status`='0', `bgcolor`='#fff' WHERE `sno`='$notif'");
}
	
?> 

<style>
body { background:#eeee;}
</style>

<section>
<div class="main-div container-fluid">
<div class="col-sm-12 application-tabs mt-2">
	<div class="admin-dashboard"> 
	
		
		<div class="col-sm-12">
			<div class="table-responsive">          
			  <table class="table table-bordered table-hover">
				<thead>
				  <tr>
					<th>Agent Name</th>
					<th>Full</br>Name</th>
					<th>Reference</br>Id</th>
					<th>TT File</th>
				  </tr>
				</thead>
				<tbody class="vrList">
				<?php
				if(isset($_GET['aid']) && !empty($_GET['aid'])){
				$get_aid = $_GET['aid'];
				$expVal = explode("error_", $get_aid);
					$queryVgr = "(SELECT sno, fname, lname, user_id, refid, loa_tt, loa_receipt_file FROM st_application where (loa_tt!='' OR loa_receipt_file!='') AND sno='$expVal[1]') UNION (SELECT sno, fname, lname, user_id, refid, loa_tt, loa_receipt_file FROM st_application where (loa_tt!='' OR loa_receipt_file!='') AND sno !='$expVal[1]' order by sno ASC)";
				}else{
					$queryVgr = "SELECT sno, fname, lname, user_id, refid, loa_tt, loa_receipt_file FROM st_application where (loa_tt!='' OR loa_receipt_file!='')";
				}
					
				$get_query = mysqli_query($con, $queryVgr);
				while ($row_nm = mysqli_fetch_assoc($get_query)){
					$ssno = mysqli_real_escape_string($con, $row_nm['sno']);
					$fname = mysqli_real_escape_string($con, $row_nm['fname']);
					$lname = mysqli_real_escape_string($con, $row_nm['lname']);
					$user_id = mysqli_real_escape_string($con, $row_nm['user_id']);
					$refid = mysqli_real_escape_string($con, $row_nm['refid']);					
					$loa_tt = mysqli_real_escape_string($con, $row_nm['loa_tt']);
					$loa_receipt_file = mysqli_real_escape_string($con, $row_nm['loa_receipt_file']);
					
					$agnt_qry = mysqli_query($con,"SELECT username FROM allusers where sno='$user_id'");
					    while ($row_agnt_qry = mysqli_fetch_assoc($agnt_qry)) {
					    $agntname = mysqli_real_escape_string($con, $row_agnt_qry['username']);
					}
				?>
				 <tr class="error_<?php echo $ssno;?>">
					<td><?php echo ucfirst($agntname); ?></td>
					<td><?php echo $fname.' '.$lname; ?></td>
					<td><?php echo $refid; ?></td>
					<td>
					<?php if($loa_tt != '' ){ ?>
					<div class="btn checklistClassgreen btn-sm ttReceiptClass" data-toggle="modal" data-target="#ttReceiptModel" data-id="<?php echo $ssno;?>"><i class="fas fa-download" data-toggle="tooltip" data-placement="top" title="Downlaod"></i></div>
					<?php }
					if($loa_receipt_file != ''){ ?>
					<div class="btn checklistClassgreen btn-sm"><a href="../uploads/<?php echo $loa_receipt_file; ?>" download><i class="fas fa-download" data-toggle="tooltip" data-placement="top" title="Downlaod"></i></a></div>
					<?php } ?>
					</td>
				  </tr>
				<?php } ?>
				</tbody>
			  </table>
			</div>
		</div>		
	</div>
  </div>			
</div>
</section>

<?php if(!empty($_GET["aid"])){ ?>
<script>
	$(".<?php echo $_GET["aid"];?>").css({"background-color": "#A8D8F4"});
	$("#<?php echo $_GET["aid"];?>").prop('checked', true);
</script>
<?php } ?>

<div class="modal fade" id="ttReceiptModel" role="dialog">
<div class="modal-dialog modal-sm">
<div class="modal-content">
<div class="modal-header">
	<span class="titleHead"></span>
	<button type="button" class="close" data-dismiss="modal">&times;</button>
</div>
<div class="modal-body">
<div class="ttReceiptList"></div>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div></div>
</div>
</div>

<script>
$(document).on('click', '.ttReceiptClass', function(){
	var idmodel = $(this).attr('data-id'); 
	$('.loading_icon').show();	
	$.post("../response.php?tag=getTTReceiptFile",{"idno":idmodel},function(d){	
		$('.ttReceiptList').html("");
		$('<div>' +	
		'' + d[0].collegeTT + '' +
		'</div>').appendTo(".ttReceiptList");	
		$('.loading_icon').hide();
	});
});
</script>
<?php 
include("../../footer.php");

}else{
	header("Location: ../../application");
}
?>