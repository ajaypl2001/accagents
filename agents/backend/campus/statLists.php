<?php
ob_start();
include("../../db.php");
include("../../header_navbar.php");
date_default_timezone_set("America/Toronto");

if($roles1 == 'ClgCM' || $roles1 == 'APRStep'){
	if($roles1 == 'APRStep'){
		$InstructorLists = 'Employee Lists';
		$InstructorLists3 = 'Employee';
		$getValLists = "AND role!=''";
	}else{
		$InstructorLists = 'Instructor Lists';	
		$InstructorLists3 = 'Instructor';	
		$getValLists = "AND role='Teacher'";	
	}	
} else {
	header("Location: ../../login");
    exit();
}

if(isset($_POST['srchClickbtn'])){
	$search = $_POST['inputval'];
	header("Location: ../campus/teacherLists.php?getsearch=$search&page_no=1");
}

if (isset($_GET['getsearch']) && $_GET['getsearch']!="") {
	$searchTerm = $_GET['getsearch'];
	$searchInput = "AND (name LIKE '%".$searchTerm."%' OR username LIKE '%".$searchTerm."%')";
	$search_url = "&getsearch=".$searchTerm."";
} else {
	$searchInput = '';
	$search_url = '';
	$searchTerm = '';
}
?>

<link rel="stylesheet" type="text/css" href="https://granville-college.com/agents/css/fixed-table.css">
<script src="https://granville-college.com/agents/js/fixed-table.js"></script>

<section class="container-fluid">
<div class="main-div card">
	<div class="card-header">
		<h3 class="my-0 py-0" style="font-size: 22px; ">Stat Holiday List
</h3>
</div>
<div class="card-body">
<div class="row justify-content-between">

<div class="col-sm-12 col-lg-12 mb-3 text-right">
<span class="btn btn-sm btn-success float-end modelSDClass" data-toggle="modal" data-target="#modelSDDiv">Add New Stat Day</span>
</div>
		
<div class="col-12">
    <div id="fixed-table-container-1" class="fixed-table-container">
<table class="table table-striped table-bordered text-center table-sm table-hover">
  <thead><tr class="bg-success">
    <th align="left">Sno.</th>
    <th>Holiday Name</th>
    <th>No. of days</th>
    <th class="text-nowrap">Previous Bi Weekly</th>
    <th class="text-nowrap">Holiday Bi Weekly</th>
    <th>Updated On</th>
    <th>Updated By</th>
    <th>Action</th>
</tr>
  </thead>
  <tbody>
<?php
$qryModule = "SELECT * FROM m_stat_holiday WHERE bi_weekly!='' order by sno desc";
$rsltModule = mysqli_query($con, $qryModule);
if(mysqli_num_rows($rsltModule)){
$srnoCnt=1;
while($rowModule = mysqli_fetch_assoc($rsltModule)){
	$sno = $rowModule['sno'];
	$holiday_name = $rowModule['holiday_name'];
	$no_of_stat = $rowModule['no_of_stat'];
	$bi_weekly = $rowModule['bi_weekly'];
	$p_bi_weekly = $rowModule['p_bi_weekly'];
	$updated_on = $rowModule['updated_on'];
	$updated_by = $rowModule['updated_by'];
	
	$start_date = $rowModule['start_date'];
	$p_start_date = $rowModule['p_start_date'];
	$first_value = $rowModule['first_value'];
	$second_value = $rowModule['second_value'];
?>  
    <tr>
      <td><?php echo $srnoCnt++; ?></td>
      <td><?php echo $holiday_name; ?></td>
      <td><?php echo $no_of_stat; ?></td>
      <td class="text-nowrap"><?php echo $first_value.' - '.$second_value; ?></td>
      <td class="text-nowrap"><?php echo $bi_weekly; ?></td>
      <td><?php echo $updated_on; ?></td>
      <td><?php echo $updated_by; ?></td>
      <td class="text-nowrap"><a href="statReport.php?first_value=<?php echo $first_value; ?>&startDate=<?php echo $start_date; ?>&second_value=<?php echo $second_value; ?>">Check Stat Calculation</a></td>
    </tr>
<?php }
}else{
?>
<tr><td colspan="8"><center>Not Found!!!</center></td></tr>
<?php } ?>

</tbody>  
</table>
</div>

</div>
</div>
</div>
</div>
</section>

<div class="modal" id="modelSDDiv">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Add New Stat Day</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

    <div class="modal-body">
		<div class="statDivList"></div>
    </div>
    </div>
  </div>
</div>

<style type="text/css">
.error_color{border:2px solid #de0e0e;}
.validError{border:2px solid #ccc;}
.table.table-striped.table-bordered td { vertical-align:middle; }
.table.table-striped.table-bordered {
  border-collapse: separate;
  border-spacing: 0.1em 0.1em;
}
.fixed-table-container { overflow: scroll; }
.fixed-table-container tr:first-child th { background: #3a7f3e; }
</style>

<script type="text/javascript">
$(document).on('change', '.bi_weeklyDiv', function (){
	var start_dateDiv = $('option:selected', this).attr('start_date');
	$('.getSD').attr('value', start_dateDiv);
	$.post("response.php?tag=getPrevStat",{"start_date":start_dateDiv},function(obj12){
		$('.bi_weeklyDiv2').html("");
		$('' + obj12[0].prevLists +'').appendTo(".bi_weeklyDiv2");
	});
});
$(document).on('click', '.bi_weeklyDiv2', function (){
	var start_dateDiv2 = $('option:selected', this).attr('p_bi_weekly');
	var firstValue = $('option:selected', this).attr('first-value');
	var secondValue = $('option:selected', this).attr('value');
	$('.getSD2').attr('value', start_dateDiv2);
	$('.firstValue').attr('value', firstValue);
	$('.secondValue').attr('value', secondValue);
});

$(document).on('click', '.modelSDClass', function (){
	var updated_by = '<?php echo $contact_person; ?>';
	$.post("response.php?tag=statDivList",{"updated_by":updated_by},function(obj12){
		$('.statDivList').html("");
		$('' + obj12[0].statDivList +'').appendTo(".statDivList");
		
		$( function() {
			$(".datepicker1234").datepicker({	  
				dateFormat: 'yy-mm-dd', 
				changeMonth: true, 
				changeYear: true,
				yearRange: "-05:+05"
			});
		});

		$(function(){
			$('.statBtnSbmit').click(function(e){ 
				e.preventDefault();
				var remarks = $('.remarks').val();
				
				if(remarks == '') {
					alert("Fields are Mandatory!!!");
					return false;
				}else{
					var $form = $(this).closest("#statHForm");
					var formData =  $form.serializeArray();
					var URL = "response.php?tag=statSavedLists";
					$.post(URL, formData).done(function(data) {
						if(data == 1){
							alert("Stat Holiday Added!!!");
							window.location.href = '../campus/statLists.php?MVNlY3VSaTR5OQ==';
							return true;	
						}else{
							alert("Something went wrong. Please contact to Administrator!!!");
							return false;
						}
					 });
				}
			});
		});
		
	});
});
</script>

<script>
  var fixedTable1 = fixTable(document.getElementById('fixed-table-container-1'));
</script>  
