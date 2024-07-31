<?php
ob_start();
include("../db.php");
include("../header_navbar.php");
?>

<div class="main-div">
<h3><center>International Student Quarantine Plan</center></h3>
<div class="container-fluid vertical_tab">  
  <div class="row">  
<div class="col-xs-12 col-sm-12 col-md-12">
<div class="tabs tabs-style-tzoid ">
<nav>
<ul class="nav nav-pills">

<?php 
if($email2323 == 'apply_board@aol'){
	$displaydiv = 'style="display:none;"';
	$activediv1 = 'id="activeId"';
	$activediv2 = '';
	
	$tabfade1 = 'class="tab-pane active"';
	$tabfade2 = '';
}else{
	$displaydiv = '';
	$activediv1 = '';
	$activediv2 = 'id="activeId"';
	
	$tabfade1 = 'class="tab-pane fade"';
	$tabfade2 = 'class="tab-pane active"';
} ?>
	<li <?php echo $activediv2; ?> class="nav-item" <?php echo $displaydiv; ?>>
		<a class="btn btn-lg sabbtn"  data-toggle="pill" href="#Brampton">
		<span>Brampton Student Quarantine Plan</span>
		</a>
	</li>

	<li <?php echo $activediv1; ?> class="nav-item">
		<a class="btn btn-lg sabbtn"  data-toggle="pill" href="#toronto">
			<span>Toronto Student Quarantine Plan</span>
		</a>
	</li>
	
	<li class="nav-item" <?php echo $displaydiv; ?>>
		<a class="btn btn-lg sabbtn"  data-toggle="pill" href="#hamilton">
			<span>Hamilton Student Quarantine Plan</span>
		</a>
	</li>	

 </ul>
 
</nav>	
<div class="tab-content">

<div <?php echo $tabfade2; ?> class="col-12 pt-4" id="Brampton" <?php echo $displaydiv; ?>>
<div class="col-12 pt-4">
<p>We are pleased to inform you that <b>Academy of Learning, Brampton Campus</b> is on the list of <b>Designated Learning Institutions</b> in Ontario, Canada that have been <b>approved to resume on-campus learning</b> for international students. We are now in a position to allow international students from outside Canada to attend classes at our campuses located in Brampton City.<br><br>

International students planning to enter Canada are required to <b>quarantine for 14 days</b> after arrival in Canada and need to have a <b>quarantine action plan</b> in place. They also need to carry a signed International Student Quarantine Plan form with them when they travel to Canada.
<a href="https://aoltorontoagents.ca/Student_quarantine_Plan_aol-Brampton.php" download="">
Please download the form here</a>. As our recruitment partner, you are responsible for ensuring that <b>all students recruited by you fill in this form</b> and <b>carry it with them when they travel to Canada</b>. Please note that in absence of this form, the student may face problems in clearing immigration at their port of departure in India or the port of arrival in Canada.<br><br>

Please ensure all of your students who are enrolled in <b>Academy of Learning, Brampton Campus</b> programs and have received an AIP/ Study Permit from the Canadian HC in India, fill this form ASAP.
</p></div>
</div>

 <div <?php echo $tabfade1; ?> id="toronto">

<div class="col-12 pt-4">
<p>We are pleased to inform you that <b>Academy of Learning, Bay Queen Campus</b> is on the list of <b>Designated Learning Institutions</b> in Ontario, Canada that have been <b>approved to resume on-campus learning</b> for international students. We are now in a position to allow international students from outside Canada to attend classes at our campuses located in Bay Queen City.<br><br>

International students planning to enter Canada are required to <b>quarantine for 14 days</b> after arrival in Canada and need to have a <b>quarantine action plan</b> in place. They also need to carry a signed International Student Quarantine Plan form with them when they travel to Canada.
<a href="https://aoltorontoagents.ca/Student_quarantine_Plan_aol-toronto.php" download="">
Please download the form here</a>. As our recruitment partner, you are responsible for ensuring that <b>all students recruited by you fill in this form</b> and <b>carry it with them when they travel to Canada</b>. Please note that in absence of this form, the student may face problems in clearing immigration at their port of departure in India or the port of arrival in Canada.<br><br>

Please ensure all of your students who are enrolled in <b>Academy of Learning, Bay Queen Campus</b> programs and have received an AIP/ Study Permit from the Canadian HC in India, fill this form ASAP.
</p></div>
</div>

<div class="tab-pane fade" id="hamilton" <?php echo $displaydiv; ?>>

<div class="col-12 pt-4" >
<p>We are pleased to inform you that <b>Academy of Learning, Hamilton Campus</b> is on the list of <b>Designated Learning Institutions</b> in Ontario, Canada that have been <b>approved to resume on-campus learning</b> for international students. We are now in a position to allow international students from outside Canada to attend classes at our campuses located in Hamilton City.<br><br>

International students planning to enter Canada are required to <b>quarantine for 14 days</b> after arrival in Canada and need to have a <b>quarantine action plan</b> in place. They also need to carry a signed International Student Quarantine Plan form with them when they travel to Canada.
<a href="https://aoltorontoagents.ca/Student_quarantine_Plan_aol-Hamilton.php" download="">
Please download the form here</a>. As our recruitment partner, you are responsible for ensuring that <b>all students recruited by you fill in this form</b> and <b>carry it with them when they travel to Canada</b>. Please note that in absence of this form, the student may face problems in clearing immigration at their port of departure in India or the port of arrival in Canada.<br><br>

Please ensure all of your students who are enrolled in <b>Academy of Learning, Hamilton Campus</b> programs and have received an AIP/ Study Permit from the Canadian HC in India, fill this form ASAP.
</p></div>
</div> 
</div> 
 
</div>
</div></div></div></div></section>


<?php 
include("../footer.php");
?>
